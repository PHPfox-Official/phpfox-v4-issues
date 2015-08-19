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
	public static $group;

	private static $_active;
	private static $_buildApi = false;

	public function __construct($route, \Closure $callback = null) {
		if (!self::$_buildApi) {
			self::$_buildApi = true;
			$routes = require(PHPFOX_DIR_SETTING . 'routes.sett.php');
			foreach ($routes as $key => $value) {
				self::$routes[trim($key, '/')] = $value;
			}
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
			if (self::$group) {
				$route = self::$group . $route;
			}

			$route = trim($route, '/');
			self::$routes[$route] = [
				'path' => \Core\Route\Controller::$active,
				'id' => \Core\Route\Controller::$activeId
			];
			if ($callback instanceof \Closure) {
				self::$routes[$route]['run'] = $callback;
			}
			self::$_active = $route;
		}

		/*
		$apps = \Core\App::$routes;
		if ($apps) {
			$_routes = [];
			foreach ($apps as $key => $value) {
				$_routes[trim($key, '/')] = $value;
			}
			// d(self::$routes); exit;
			self::$routes = array_merge(self::$routes, (array) $_routes);
		}
		*/

		// d(self::$routes); exit;
	}

	public function __call($method, $args) {
		if (count($args) === 1) {
			$args = $args[0];
		}

		self::$routes[self::$_active][$method] = $args;

		return $this;
	}
}