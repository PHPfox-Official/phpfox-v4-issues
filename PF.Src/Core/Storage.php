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

	public function get($key) {
		$object = $this->db->select('*')->from(':cache')->where(['file_name' => $key])->get();
		if (isset($object->action_id)) {
			return json_decode($object->cache_data);
		}

		return null;
	}
}