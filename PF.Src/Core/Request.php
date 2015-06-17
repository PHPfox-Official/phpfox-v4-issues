<?php

namespace Core;

/**
 * Class Request
 * @package Core
 *
 * @method get($var)
 * @method isPost()
 * @method segment($number)
 * @method method()
 * @method uri()
 */
class Request {
	private static $_object = null;

	public function __construct() {
		if (self::$_object === null) {
			self::$_object = \Phpfox_Request::instance();
		}
	}

	public function __call($method, $args) {
		switch ($method) {

		}

		return call_user_func_array([self::$_object, $method], $args);
	}
}