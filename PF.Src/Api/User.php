<?php

namespace Api;

class User extends \Core\Api {

	/**
	 * @param null $userId
	 * @return User\Object|User\Object[]
	 */
	public function get($userId = null) {
		$where = [];
		if ($userId !== null) {
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