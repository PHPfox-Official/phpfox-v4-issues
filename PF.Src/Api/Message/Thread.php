<?php

namespace Api\Message;

class Thread extends \Core\Api {
	public function get($id) {
		list($thread, $messages) = \Mail_Service_Mail::instance()->getThreadedMail($id);

		$objects = [];
		foreach ($messages as $message) {
			$objects[] = new Thread\Object($message);
		}

		$object = [
			'thread' => new Object($thread),
			'messages' => $objects
		];

		return $object;
	}

	public function post($id) {
		$this->auth();
		$this->requires([
			'message'
		]);

		\Mail_Service_Process::instance()->add([
			'thread_id' => $id,
			'message' => $this->request->get('message')
		]);

		$thread = new Thread\Object(\Mail_Service_Mail::instance()->getThreadedMail($id, 0, true));

		return $thread;
	}
}