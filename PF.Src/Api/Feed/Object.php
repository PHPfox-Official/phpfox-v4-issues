<?php

namespace Api\Feed;

class Object extends \Core\Objectify {

	/**
	 * @var \Api\User\Object
	 */
	public $user;
	public $id;
	public $item_id;
	public $url;
	public $external_url;
	public $title;
	public $description;
	public $time_stamp;
	public $image;
	public $type;
	public $privacy = 0;
	public $likes = 0;
	public $is_liked = false;
	public $comments = 0;
}