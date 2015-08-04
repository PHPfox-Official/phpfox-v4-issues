<?php

namespace Core;

/**
 * Class Request
 * @package Core
 *
 * @method get($var = null)
 * @method isPost()
 * @method segment($number)
 * @method method()
 * @method set($params)
 * @method uri()
 * @method all()
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
			case 'all':
				$method = 'getRequests';
				break;
		}

		return call_user_func_array([self::$_object, $method], $args);
	}
}