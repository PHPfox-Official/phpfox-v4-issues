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
				if ($key == 'user') {
					if (!isset($value['user_name'])) {
						$this->user = null;
						continue;
					}

					$this->user = new \Api\User\Object([
						'id' => $value['user_id'],
						'name' => $value['full_name'],
						'url' => \Phpfox_Url::instance()->makeUrl($value['user_name'])
					]);

					continue;
				}

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