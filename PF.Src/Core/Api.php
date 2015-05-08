<?php

namespace Core;

abstract class Api {
	/**
	 * @var \Phpfox_Database_Driver_Mysql
	 */
	protected $db;

	protected $request;

	protected $limit;

	protected $order;

	public function __construct() {
		$this->db = \Phpfox_Database::instance();
		$this->request = \Phpfox_Request::instance();

		if ($this->request->segment(1) == 'api') {
			if ($this->request->authPass() != 'bar') {
				throw error('Authentication failed.');
			}
		}
	}

	public function limit($limit = null) {
		$this->limit = $limit;

		return $this;
	}

	public function order($order = null) {
		$this->order = $order;

		return $this;
	}

	public function assign($postFields) {
		$this->request->set($postFields);

		return $this;
	}

	protected function getLimit($default) {
		if ($this->limit === null) {
			return $default;
		}

		return $this->limit;
	}

	protected function getOrder($default) {
		if ($this->order === null) {
			return $default;
		}

		return $this->order;
	}
}