<?php

namespace Core;

class Theme extends Model {
	private static $_active;

	public function __construct() {
		if (!self::$_active) {
			parent::__construct();

			self::$_active = $this->db->select('t.*, ts.folder AS flavor_folder')
				->from(':theme', 't')
				->join(':theme_style', 'ts', ['t.theme_id' => ['=' => 'ts.theme_id'], 'ts.is_default' => 1])
				->where(['t.is_default' => 1])
				->get();
		}
	}

	/**
	 * @return Theme\Object
	 */
	public function get($id = null) {
		$data = self::$_active;
		if ($id !== null) {
			$data = $this->db->select('t.*, ts.folder AS flavor_folder')
				->from(':theme', 't')
				->join(':theme_style', 'ts', ['t.theme_id' => ['=' => 'ts.theme_id'], 'ts.is_default' => 1])
				->where(['t.theme_id' => (int) $id])
				->get();
		}

		return new Theme\Object($data);
	}

	/**
	 * @return Theme\Object[]
	 */
	public function all() {
		$rows = $this->db->select('t.*')
			->from(':theme', 't')
			->order('t.name ASC')
			->all();

		$themes = [];
		foreach ($rows as $row) {
			$Theme = new Theme\Object($row);
			if (!is_dir($Theme->getPath())) {
				continue;
			}

			$themes[] = $Theme;
		}

		return $themes;
	}
}