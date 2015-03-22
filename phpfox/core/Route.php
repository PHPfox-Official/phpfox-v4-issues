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

	public function __construct($route) {
		if (is_array($route)) {
			foreach ($route as $key => $value) {
				$value['path'] = \Core\Route\Controller::$active;
				self::$routes[$key] = $value;
			}
		}
		else {
			self::$routes[$route] = [
				'path' => \Core\Route\Controller::$active
			];
			self::$_active = $route;
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