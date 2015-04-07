<?php

namespace Core;

/**
 * Class Home
 * @package Core
 *
 * @method Home verify()
 */
class Home {
	private $_id;
	private $_key;

	public function __construct($id = null, $key = null) {
		$this->_id = $id;
		$this->_key = $key;
	}

	public function __call($method, $args) {

		$url = (defined('PHPFOX_API_URL') ? PHPFOX_API_URL : 'http://api.phpfox.com/') . $method;
		$Http = new HTTP($url);
		$Http->auth($this->_id, $this->_key);
		foreach ($args as $value) {
			$Http->using($value);
		}

		return $Http->post();
	}
}