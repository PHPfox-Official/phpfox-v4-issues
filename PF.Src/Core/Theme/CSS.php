<?php

namespace Core\Theme;

class CSS extends \Core\Model {
	private $_theme;

	public function __construct(\Core\Theme\Object $Theme) {
		parent::__construct();

		$this->_theme = $Theme;
	}

	public function set($content) {
		$less = new \lessc();

		$less->setImportDir(PHPFOX_DIR . 'less/');
		$content = str_replace('../../../../PF.Base/less/', '', $content);
		$parsed = $less->compile($content);

		file_put_contents($this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.min.css', $parsed);

		if ($this->_get()) {
			$this->db->update(':theme_template', [
				'html_data' => $parsed,
				'html_data_original' => $content,
				'time_stamp_update' => PHPFOX_TIME
			], [
				'folder' => $this->_theme->folder, 'type_id' => 'css', 'name' => $this->_theme->flavor_folder . '.css'
			]);

			return true;
		}

		$this->db->insert(':theme_template', [
			'folder' => $this->_theme->folder,
			'type_id' => 'css',
			'name' => $this->_theme->flavor_folder . '.css',
			'html_data' => $parsed,
			'html_data_original' => $content,
			'time_stamp' => PHPFOX_TIME
		]);

		return true;
	}

	public function get() {
		$html = $this->_get();
		if (!$html) {
			$html = $this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.less';
			$html = file_get_contents($html);
		}

		return $html;
	}

	public function getParsed() {
		$css = $this->_get('html_data');
		if (!$css) {
			$css = $this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.css';
			$css = file_get_contents($css);
		}

		return $css;
	}

	private function _get($type = 'html_data_original') {
		$html = $this->db->select('*')
			->from(':theme_template')
			->where(['folder' => $this->_theme->folder, 'type_id' => 'css', 'name' => $this->_theme->flavor_folder . '.css'])
			->get();

		if (!isset($html['template_id'])) {
			return false;
		}

		return $html[$type];
	}
}