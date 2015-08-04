<?php

namespace Core;

class Storage extends Model {
	public function set($key, $value) {
		$id = $this->db->insert(':cache', [
			'file_name' => $key,
			'cache_data' => json_encode($value),
			'time_stamp' => PHPFOX_TIME
		]);

		return $id;
	}

	/**
	 * @param $key
	 * @return Storage\Object[]
	 */
	public function all($key) {
		$return = [];
		$objects = $this->db->select('*')->from(':cache')->where(['file_name' => $key])->all();
		foreach ($objects as $object) {
			/*
			$row = new \stdClass();
			$row->id = $object['cache_id'];
			$row->content = json_decode($object['cache_data']);
			*/

			$return[] = new Storage\Object([
				'id' => $object['cache_id'],
				'value' => json_decode($object['cache_data'])
			]);
		}

		return $return;
	}
}