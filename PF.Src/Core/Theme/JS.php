<?php

namespace Core\Theme;

class JS extends \Core\Model {
	private $_theme;

	public function __construct(\Core\Theme\Object $Theme) {
		parent::__construct();

		$this->_theme = $Theme;
	}

	public function set($content) {

		file_put_contents($this->_theme->getPath() . 'assets/autoload.js', $content);
		/*
		if ($this->_get()) {
			$this->db->update(':theme_template', [
				'html_data' => $content,
				'time_stamp_update' => PHPFOX_TIME
			], [
				'folder' => $this->_theme->folder, 'type_id' => 'js', 'name' => 'autoload.js'
			]);

			return true;
		}

		$this->db->insert(':theme_template', [
			'folder' => $this->_theme->folder,
			'type_id' => 'js',
			'name' => 'autoload.js',
			'html_data' => $content,
			'html_data_original' => $content,
			'time_stamp' => PHPFOX_TIME
		]);
		*/

		return true;
	}

	public function get() {
		$html = $this->_theme->getPath() . 'assets/autoload.js';
		$html = file_get_contents($html);

		return $html;
	}
}