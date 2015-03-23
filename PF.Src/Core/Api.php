<?php

namespace Core;

abstract class Api {
	/**
	 * @var \Phpfox_Database_Driver_Mysql
	 */
	protected $db;


	protected $request;

	public function __construct() {
		$this->db = \Phpfox_Database::instance();
		$this->request = \Phpfox_Request::instance();
		if ($this->request->segment(1) == 'api') {
			if ($this->request->authPass() != 'bar') {
				throw error('Authentication failed.');
			}
		}
	}
}