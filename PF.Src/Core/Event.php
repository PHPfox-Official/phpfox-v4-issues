<?php

namespace Core;

class Event {
	private static $_events = null;

	public function __construct($events, $callback = null) {

		if (is_array($events) && is_callable($callback)) {
			foreach ($events as $name) {
				new self($name, $callback);
			}
			return;
		}

		if (!is_array($events)) {
			$events = [$events => $callback];
		}

		foreach ($events as $name => $callback) {
			self::$_events[$name][] = $callback;
		}
	}

	public static function trigger($name) {
		$args = func_get_args();
		unset($args[0]);

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
					else if (is_object($c) && $c instanceof \Closure) {
						call_user_func_array($c, $args);
					}
				}
			}
		// }

		return null;
	}
}