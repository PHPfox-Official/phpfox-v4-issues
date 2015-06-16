<?php

namespace Api\Feed;

class Object extends \Core\Objectify {

	/**
	 * @var \Api\User\Object
	 */
	public $id;
	public $content;
	public $total_likes = 0;
	public $total_comments = 0;
	public $user;
	public $custom;

	public function __construct($objects) {
		parent::__construct($objects);

		$this->custom = (object) $this->custom;
		if (substr($this->content, 0, 1) == '{') {
			$this->content = json_decode($this->content);
		}
	}
}