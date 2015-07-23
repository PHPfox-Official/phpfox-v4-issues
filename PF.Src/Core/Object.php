<?php

namespace Core;

class Object {
	public function __construct($objects) {
		foreach ($objects as $key => $value) {
			$this->$key = $value;
		}
	}

	public function __get($param) {
		if (!PHPFOX_DEBUG) {
			return '';
		}

		throw error('Missing param "%s".', $param);
	}
}