<?php

namespace Core\Theme;

class HTML extends \Core\Model {
	private $_theme;

	public function __construct(\Core\Theme\Object $Theme) {
		parent::__construct();

		$this->_theme = $Theme;
	}

	public function set($content) {

		$dir = $this->_theme->getPath() . 'html/';
		if (!is_dir($dir)) {
			mkdir($dir);
		}

		$path = $this->_theme->getPath() . 'html/layout.html';
		file_put_contents($path, $content);

		$twig = PHPFOX_DIR_FILE . 'cache/twig/';
		if (is_dir($twig)) {
			\Phpfox_File::instance()->delete_directory($twig);
		}

		/*
		if ($this->_get()) {
			$this->db->update(':theme_template', [
				'html_data' => $content,
				'time_stamp_update' => PHPFOX_TIME
			], [
				'folder' => $this->_theme->folder, 'type_id' => 'theme', 'name' => 'layout.html'
			]);

			return true;
		}

		$this->db->insert(':theme_template', [
			'folder' => $this->_theme->folder,
			'type_id' => 'theme',
			'name' => 'layout.html',
			'html_data' => $content,
			'html_data_original' => $content,
			'time_stamp' => PHPFOX_TIME
		]);
		*/

		return true;
	}

	public function get() {
		$html = $this->_theme->getPath() . 'html/layout.html';
		if (!file_exists($html)) {
			$html = $this->_theme->basePath() . 'html/layout.html';
		}

		$html = file_get_contents($html);

		return $html;
	}

	/*
	private function _get() {
		$html = $this->db->select('*')
			->from(':theme_template')
			->where(['folder' => $this->_theme->folder, 'type_id' => 'theme', 'name' => 'layout.html'])
			->get();

		if (!isset($html['template_id'])) {
			return false;
		}

		return $html['html_data'];
	}
	*/
}