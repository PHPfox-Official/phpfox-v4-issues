<?php

namespace Core;

/**
 * Class Storage
 * @package Core
 *
 * @method Storage order($direction = 'ASC')
 */
class Storage {
	private $_args = [
		'order' => 'ASC'
	];

	/**
	 * @var \Core\Db
	 */
	public $db;

	public function __construct() {
		$this->db = new Db();
	}

	public function set($key, $value) {
		$iteration = 0;
		$cache = $this->get($key);
		if (isset($cache->order)) {
			$iteration = $cache->order;
		}
		$iteration++;
		$id = $this->db->insert(':cache', [
			'file_name' => $key,
			'cache_data' => json_encode($value),
			'time_stamp' => $iteration
		]);

		return $id;
	}

	/**
	 * @param $key
	 * @return Storage\Object[]
	 */
	public function all($key) {
		$return = [];
		$objects = $this->db->select('*')->from(':cache')->where(['file_name' => $key])->order('time_stamp ' . $this->_args['order'])->all();
		foreach ($objects as $object) {
			$return[] = $this->_build($object);
		}

		return $return;
	}

	public function get($key) {
		$object = $this->db->select('*')->from(':cache')->where(['file_name' => $key])->get();
		if (isset($object['cache_id'])) {
			return $this->_build($object);
		}

		return null;
	}

	public function __call($method, $args) {
		if (isset($this->_args[$method])) {
			$this->_args[$method] = array_values($this->_args[$method])[0];
		}
		return $this;
	}

	private function _build($object) {
		return new Storage\Object([
			'id' => $object['cache_id'],
			'order' => $object['time_stamp'],
			'value' => json_decode($object['cache_data'])
		]);
	}
}