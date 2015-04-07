<?php

namespace Core;

class Model {
	/**
	 * @var \Phpfox_Database_Driver_Mysql
	 */
	protected $db;

	/**
	 * @var \Phpfox_Cache_Storage_File
	 */
	protected $cache;

	/**
	 * @var \Api\User\Object
	 */
	protected $active;

	public function __construct() {
		$this->db = \Phpfox_Database::instance();
		$this->cache = \Phpfox_Cache::instance();
		$this->active = (new \Api\User())->get(\Phpfox::getUserId());
	}
}