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

	protected $where = [];

	/**
	 * @var App\Object
	 */
	protected $active;

	public function __construct() {
		$this->db = \Phpfox_Database::instance();
		$this->request = \Phpfox_Request::instance();

		if ($this->request->segment(1) == 'api' && $this->request->segment(2) != 'gateway') {
			\Core\Route\Controller::$isApi = true;

			if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
				throw new \Exception('Missing authentication key and pass.');
			}

			foreach ((new App())->all() as $App) {
				if ($App->auth->id == $_SERVER['PHP_AUTH_USER']) {
					$this->active = $App;
					break;
				}
			}

			if (!$this->active) {
				throw new \Exception('Unable to find this app.');
			}

			if ($_SERVER['PHP_AUTH_PW'] != $App->auth->key) {
				throw new \Exception('Authentication failed. Key is not valid: ' . $App->auth->key);
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

	public function where($where = []) {
		$this->where = $where;

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

	protected function getWhere($default = []) {
		if ($default) {

		}

		return $this->where;
	}

	protected function getOrder($default) {
		if ($this->order === null) {
			return $default;
		}

		return $this->order;
	}

	protected function requires($fields) {
		foreach ($fields as $key) {
			if (!isset($_REQUEST[$key])) {
				throw new \Exception('Missing "' . $key . '".');
			}
		}
	}

	protected function isApi() {
		return \Core\Route\Controller::$isApi;
	}

	protected function auth() {
		if (\Phpfox::isUser()) {
			return;
		}

		if (empty($_SERVER['HTTP_USER_ID'])) {
			throw new \Exception('This resource requires an HTTP USER_ID header.');
		}

		if ((int) $_SERVER['HTTP_USER_ID'] > 0) {
			\User_Service_Auth::instance()->setUserId($_SERVER['HTTP_USER_ID']);
		}
	}

	protected function accept(array $keys) {
		$accept = [];
		foreach ($keys as $key => $value) {
			$v = $this->request($key);
			if ($v === false) {
				continue;
			}
			$accept[$value] = $v;
		}

		return $accept;
	}

	protected function request($key) {
		if (isset($_REQUEST[$key])) {
			return $_REQUEST[$key];
		}

		// throw new \Exception('"' . $key . '" is missing.');
		return false;
	}
}