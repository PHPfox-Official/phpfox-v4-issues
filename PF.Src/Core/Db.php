<?php

namespace Core;

/**
 * Class Db
 * @package Core
 *
 * @method Db select($select)
 * @method Db from($table, $alias = null)
 * @method Db singleData($field_name)
 * @method Db order($order)
 * @method Db get()
 * @method Db join($table, $alias, $where)
 * @method Db where(array $where)
 * @method Db limit($limit)
 * @method Db all()
 * @method Db count()
 * @method query($sql)
 * @method delete($table, array $set)
 * @method insert($table, array $set)
 * @method update($table, array $set, array $where)
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