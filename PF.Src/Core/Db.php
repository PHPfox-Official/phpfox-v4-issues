<?php

namespace Core;

/**
 * Class Db
 * @package Core
 *
 * @method Db select($select)
 * @method Db from($table)
 * @method Db order($order)
 * @method Db get()
 * @method Db where(array $where)
 * @method Db limit($limit)
 * @method Db all()
 */
class Db {
	private static $_object = null;

	public function __construct() {
		if (self::$_object === null) {
			self::$_object = \Phpfox_Database::instance();
		}
	}

	public function __call($method, $args) {
		switch ($method) {

		}

		return call_user_func_array([self::$_object, $method], $args);
	}
}