<?php

namespace Api;

class Friend extends \Core\Api {
	/**
	 * @param null $userId
	 * @return User\Object|User\Object[]
	 * @throws \Exception
	 */
	public function get($userId = null) {
		$this->auth();

		$friends = [];
		// list($total, $users) = \Friend_Service_Friend::instance()->get(['friend.user_id' => user()->id]);
		$userId = user()->id;
		$users = $this->db->select(\Phpfox::getUserField())
			->from(':friend', 'f')
			->join(':user', 'u', 'u.user_id = f.friend_user_id')
			->where(['f.user_id' => $userId])
			->limit(20)
			->all();
		foreach ($users as $user) {
			$friends[$user['user_id']] = new User\Object($user);
		}

		return $friends;
	}
}