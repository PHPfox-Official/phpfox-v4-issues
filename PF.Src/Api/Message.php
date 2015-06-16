<?php

namespace Api;

class Message extends \Core\Api {
	public function get($id = null) {
		if ($id) {
			$message = $this->db->select('t.*, ' . \Phpfox::getUserField())
				->from(':mail_thread_text', 't')
				->join(':user', 'u', 'u.user_id = t.user_id')
				->where(['t.message_id' => $id])->get();

			$object = new Message\Thread\Object($message);
		}
		else {
			$this->auth();
			$object = [];
			list($total, $messages, $inputs) = \Mail_Service_Mail::instance()->get();
			foreach ($messages as $message) {
				$object[] = new Message\Object($message);
			}
		}

		return $object;
	}
}