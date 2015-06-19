<?php

namespace Core\Extend;

/**
 * Class Cache
 * @package Core\Extend
 *
 */
abstract class Cache {
	public abstract function get($name);
	public abstract function save($name, $value);
	public abstract function remove($name = null);

	final public function set($key) {
		if (is_array($key)) {
			$key = implode(':', $key);
		}
		return $key;
	}

	final public function close() {

	}

	final public function saveInfo() {

	}

	final public function getCachedFiles() {

	}

	final public function getStats() {

	}

	final public function removeStatic() {

	}
}