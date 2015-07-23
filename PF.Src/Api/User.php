<?php

namespace Api;

class User extends \Core\Api {
	public function put($userId) {
		$requests = $this->accept([
			'name' => 'full_name',
			'email' => 'email',
			'username' => 'user_name'
		]);

		$this->get($userId);

		\User_Service_Process::instance()->update($userId, $requests);

		return $this->get($userId);
	}

	public function post() {
		$this->requires([
			'name',
			'email',
			'password'
		]);

		\User_Service_Validate::instance()->email($this->request('email'));

		$userId = \User_Service_Process::instance()->add([
			'full_name' => $this->request('name'),
			'email' => $this->request('email'),
			'password' => $this->request('password')
		]);

		if (!$userId) {
			throw new \Exception(implode('', \Phpfox_Error::get()));
		}

		return $this->get($userId);
	}

	/**
	 * @param null $userId
	 * @return User\Object|User\Object[]
	 */
	public function get($userId = null) {
		if ($userId !== null && !$userId) {
			return new User\Object(false);
		}

		$where = [];
		if ($userId !== null) {
			$where = ['user_id' => $userId];
			$user = $this->db->select('*')->from(':user')->where($where)->get();
			if (!isset($user['user_id'])) {
				if (!$this->isApi()) {
					return false;
				}

				throw new \Exception('User not found:' . $userId);
			}
			// $user = $this->_build($user);
		}
		else {
			$users = [];
			$rows = $this->db->select('*')->from(':user')
				->where($this->getWhere())
				->limit($this->getLimit(10))
				->order($this->getOrder('user_id DESC'))
				->all();
			foreach ($rows as $row) {
				$users[] = new User\Object($row);
			}

			return $users;
		}

		return new User\Object($user);
	}
}