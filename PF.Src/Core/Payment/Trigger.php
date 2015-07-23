<?php

namespace Core\Payment;

class Trigger {
	public static $events = [];

	public static function event($name, $params = []) {
		if (isset(self::$events[$name])) {
			call_user_func(self::$events[$name], new Object($params));
		}
	}
}