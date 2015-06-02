<?php

namespace Core;

/**
 * Class Route
 * @package Core
 *
 * @method Route auth($authenticate)
 * @method Route run($callback)
 * @method Route accept($methods)
 * @method Route call($class)
 * @method Route where($regex)
 * @method Route url($url)
 */
class Route {
	public static $routes = [];

	private static $_active;

	public function __construct($route) {
		if (!self::$routes) {
			self::$routes = require(PHPFOX_DIR_SETTING . 'routes.sett.php');
		}

		if (is_array($route)) {
			foreach ($route as $key => $value) {
				if (is_string($value)) {
					$value = [
						'call' => $value
					];
				}

				$key = trim($key, '/');
				$value['path'] = \Core\Route\Controller::$active;
				self::$routes[$key] = $value;
			}
		}
		else {
			$route = trim($route, '/');
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