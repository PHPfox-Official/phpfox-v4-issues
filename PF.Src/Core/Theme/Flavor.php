<?php

namespace Core\Theme;

class Flavor extends \Core\Model {
	private $_theme;
	// private $_service;

	public function __construct(\Core\Theme\Object $Theme) {
		parent::__construct();

		$this->_theme = $Theme;
		// $this->_service = new Service($this->_theme);
	}

	public function getDefault() {
		$flavor = $this->db->select('*')
			->from(':theme_style')
			->where(['theme_id' => $this->_theme->theme_id])
			->get();

		return new Flavor\Object($this->_theme, $flavor);
	}

	public function make($val) {
		/*
		 *
		$check = $this->db->select('COUNT(*) as total')->from(':theme_style')->where(['folder' => $val['folder']])->get();
		if ($check['total']) {
			throw error('Folder already exists.');
		}
		*/

		$id = $this->db->insert(':theme_style', [
			'theme_id' => $this->_theme->theme_id,
			'is_active' => 1,
			'name' => $val['name'],
			'folder' => '_',
			'created' => PHPFOX_TIME,
			'is_default' => 0
		]);
		$this->db->update(':theme_style', ['folder' => $id], ['style_id' => $id]);

		$path = PHPFOX_DIR_SITE . 'themes/' . $this->_theme->folder . '/flavor/';
		copy($path . $val['clone'] . '.less', $path . $id . '.less');
		copy($path . $val['clone'] . '.css', $path . $id . '.css');

		/*
		$copy = [];
		$dirs = [];
		$files = \Phpfox_File::instance()->getAllFiles(PHPFOX_DIR_SITE . 'themes/default/');
		foreach ($files as $file) {
			if (!in_array(\Phpfox_File::instance()->extension($file), [
				'html', 'js', 'css', 'less'
			])) {
				continue;
			}

			$parts = pathinfo($file);

			$dirs[] = str_replace(PHPFOX_DIR_SITE . 'themes/default/', '', $parts['dirname']);
			$copy[] = $file;
		}

		$path = PHPFOX_DIR_SITE . 'themes/' . $val['folder'] . '/';
		foreach ($dirs as $dir) {
			if (!is_dir($path . $dir)) {
				mkdir($path . $dir, 0777, true);
			}
		}

		foreach ($copy as $file) {
			copy($file, $path . str_replace(PHPFOX_DIR_SITE . 'themes/default/', '', $file));
		}
		*/

		return $id;
	}
}