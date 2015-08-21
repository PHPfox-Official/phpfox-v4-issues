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

	public function del($key) {
		return $this->_cache->remove($this->_cache->set($key));
	}

	public function get($key, $minutes = 0) {
		return $this->_cache->get($this->_cache->set($key), $minutes);
	}

	public function purge() {
		return $this->_cache->remove();
	}

	public function __call($method, $args) {
		return call_user_func_array([$this->_cache, $method], $args);
	}
}