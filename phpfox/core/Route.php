<?php

namespace Core;

/**
 * Class Route
 * @package Core
 *
 * @method Route run($callback)
 * @method Route accept($methods)
 * @method Route call($class)
 * @method Route where($regex)
 */
class Route {
	public static $routes = [];

	private static $_active;

	public function __construct($paths) {
		self::$routes[$paths] = [
			'path' => \Core\Route\Controller::$active
		];
		self::$_active = $paths;
		if (strpos($paths, ':')) {
			$parts = explode('/', $paths);
			// d($parts); exit;
		}
	}

	public function __call($method, $args) {
		if (count($args) === 1) {
			$args = $args[0];
		}

		self::$routes[self::$_active][$method] = $args;

		return $this;
	}
}