<?php

namespace Core;

class Objectify {
	private $__toString = '';

	public function __construct($objects = null) {
		if ($objects instanceof \Closure) {
			$this->__toString = $objects;
			return;
		}

		if ($objects) {
			foreach ($objects as $key => $value) {
				if (!property_exists($this, $key)) {
					continue;
				}

				$this->$key = $value;
			}
		}
	}

	public function __toString() {
		return call_user_func($this->__toString);
	}
}