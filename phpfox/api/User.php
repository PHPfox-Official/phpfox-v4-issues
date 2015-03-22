<?php

namespace Api;

class User extends \Core\Api {
	private $_userId;

	public function __construct($userId = null) {
		parent::__construct();

		if ($userId !== null) {
			$this->_userId = $userId;
		}
	}

	/**
	 * @param null $userId
	 * @return User\Object|User\Object[]
	 */
	public function get($userId = null) {
		$where = [];
		if ($this->_userId !== null) {
			$userId = $this->_userId;
		}

		if ($userId) {
			$where = ['user_id' => $userId];
			$user = $this->db->select('*')->from(':user')->where($where)->get();
		}
		else {
			$users = [];
			$rows = $this->db->select('*')->from(':user')
				->where($where)
				->limit(10)
				->order('user_id DESC')
				->all();
			foreach ($rows as $row) {
				$users[] = new User\Object($row);
			}

			return $users;
		}

		return new User\Object($user);
	}
}