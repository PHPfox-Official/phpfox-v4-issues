<?php

namespace Core;

abstract class Api {
	/**
	 * @var \Phpfox_Database_Driver_Mysql
	 */
	protected $db;

	// private $_where;

	public function __construct() {
		$this->db = \Phpfox_Database::instance();
	}

	/*
	public function where(array $where = []) {
		if (!$where) {
			return $this->_where;
		}
		$this->_where = $where;
	}
	*/
}