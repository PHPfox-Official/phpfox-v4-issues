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
			if (property_exists($this, 'user')) {
				$this->user = (object) $this->_build($objects);
			}
			else if ((is_array($objects) && isset($objects['user_id']) && isset($objects['full_name']))) {
				$objects = $this->_build($objects);
			}

			foreach ($objects as $key => $value) {
				if ($key == 'user') {
					continue;
				}

				if (!property_exists($this, $key)) {
					continue;
				}

				$this->$key = $value;
			}
		}
	}

	protected function _build($row) {
		$row = (array) $row;
		if (isset($row['user']) && is_array($row['user'])) {
			$row = $row['user'];
		}

		$age = $row['birthday'];
		$day = '';
		$month = '';
		$year = '';
		if (!empty($age)) {
			$month = substr($age, 0, 2);
			$day = substr($age, 2, 2);
			$year = substr($age, -4);
		}

		$image_50px = '';
		if (!empty($row['user_image'])) {
			$image_50px = \Phpfox_Image_Helper::instance()->display([
				'user' => $row,
				'suffix' => '_50_square',
				'return_url' => true
			]);
		}

		return [
			'id' => (int) $row['user_id'],
			'name' => $row['full_name'],
			'url' => \Phpfox_Url::instance()->makeUrl($row['user_name']),
			'gender' => [
				'id' => $row['gender'],
				'name' => \User_Service_User::instance()->gender($row['gender'])
			],
			'photo' => [
				'50px' => $image_50px,
				'120px' => str_replace('_50_square', '_120_square', $image_50px),
				'200px' => str_replace('_50_square', '_200_square', $image_50px),
				'original' => str_replace('_50_square', '', $image_50px)
			],
			'location' => [
				'iso' => $row['country_iso'],
			],
			'dob' => [
				'day' => $day,
				'month' => $month,
				'year' => $year
			]
		];
	}

	public function __toString() {
		return call_user_func($this->__toString);
	}
}