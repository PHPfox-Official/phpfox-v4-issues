<?php

namespace Core;

class Event {
	private static $_events = null;

	public function __construct($events) {
		if (!is_array($events)) {

		}

		foreach ($events as $name => $callback) {
			self::$_events[$name][] = $callback;
		}
	}

	public static function trigger($name) {
		// if (self::$_events === null) {
			if (isset(self::$_events[$name])) {
				$callback = self::$_events[$name];
				foreach ($callback as $e => $c) {
					if (is_string($c)) {
						$r = new \ReflectionClass($c);
						$object = $r->newInstance();
						if (method_exists($object, '__returnObject')) {
							return $object;
						}
					}
				}
			}
		// }

		return null;
	}
}