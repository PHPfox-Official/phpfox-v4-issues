<?php

namespace Core;

class Objectify {
	public function __construct($objects) {
		foreach ($objects as $key => $value) {
			if (!property_exists($this, $key)) {
				continue;
			}

			$this->$key = $value;
		}
	}
}