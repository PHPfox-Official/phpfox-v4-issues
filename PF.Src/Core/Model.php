<?php

namespace Core;

class Model {
	/**
	 * @var \Phpfox_Database_Driver_Mysql
	 */
	protected $db;

	/**
	 * @var \Api\User\Object
	 */
	protected $active;

	public function __construct() {
		$this->db = \Phpfox_Database::instance();
		$this->active = (new \Api\User())->get(\Phpfox::getUserId());
	}
}