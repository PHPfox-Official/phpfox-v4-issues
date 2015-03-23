<?php

namespace Core;

class Cache {
	private $_name;
	private $_cache;
	private $_id;

	public function __construct($name = null) {
		$this->_cache = \Phpfox_Cache::instance();
		if ($name !== null) {
			$this->_name = $name;
			$this->_id = $this->_cache->set($name);
		}
	}

	public function set($key, $value) {
		return $this->_cache->save($this->_cache->set($key), $value);
	}

	public function get($key) {
		return $this->_cache->get($this->_cache->set($key));
	}
}