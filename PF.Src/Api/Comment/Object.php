<?php

namespace Api\Comment;

class Object extends \Core\Objectify {
	public $id;
	public $comment;
	public $time;
	public $user;

	public function __construct($object) {

		$map = [
			'id' => (int) $object['comment_id'],
			'comment' => $object['text'],
			'time' => (int) $object['unix_time_stamp']
		];

		parent::__construct(array_merge($object, $map));
	}
}