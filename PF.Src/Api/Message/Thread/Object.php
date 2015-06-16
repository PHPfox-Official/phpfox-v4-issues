<?php

namespace Api\Message\Thread;

class Object extends \Core\Objectify {
	public $id;
	public $message;
	public $time;
	public $user;

	public function __construct($object) {

		$map = [
			'id' => (int) $object['message_id'],
			'message' => $object['text'],
			'time' => (int) $object['time_stamp'],
			'user' => $object
		];

		parent::__construct($map);
	}
}