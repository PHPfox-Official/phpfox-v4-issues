<?php

namespace Core\Theme;

class CSS extends \Core\Model {
	private $_theme;

	public function __construct(\Core\Theme\Object $Theme) {
		parent::__construct();

		$this->_theme = $Theme;
	}

	public function set($content, $vars = null) {
		$less = new \lessc();

		$lessContent = ($vars === null ? $this->get(true) : $vars) . "/** START CSS */\n";
		$newContent = $lessContent . trim($content);

		$less->setImportDir(PHPFOX_DIR . 'less/');
		$content = str_replace('../../../../PF.Base/less/', '', $newContent);
		$parsed = $less->compile($content);

		$path = $this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder;
		file_put_contents($path . '.less', $newContent);
		file_put_contents($path . '.css', $parsed);

		$this->db->update(':setting', array('value_actual' => ((int) \Phpfox::getParam('core.css_edit_id') + 1)), 'var_name = \'css_edit_id\'');
		$this->cache->del('setting');

		return true;

		// file_put_contents($this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.min.css', $parsed);

		// if ($this->_get()) {
			/*
			$this->db->update(':theme_template', [
				'html_data' => $parsed,
				'html_data_original' => $content,
				'time_stamp_update' => PHPFOX_TIME
			], [
				'folder' => $this->_theme->folder, 'type_id' => 'css', 'name' => $this->_theme->flavor_folder . '.css'
			]);
			*/

		//	return true;
		// }

		/*
		$this->db->insert(':theme_template', [
			'folder' => $this->_theme->folder,
			'type_id' => 'css',
			'name' => $this->_theme->flavor_folder . '.css',
			'html_data' => $parsed,
			'html_data_original' => $content,
			'time_stamp' => PHPFOX_TIME
		]);
		*/

		return true;
	}

	public function get($returnLess = false) {
		$html = $this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.less';
		if (!file_exists($html)) {
			throw new \Exception('Less file does not exist.');
		}

		$html = file_get_contents($html);

		$parts = explode('/** START CSS */', $html);

		if ($returnLess === true) {
			return $parts[0];
		}

		return (isset($parts[1]) ? $parts[1] : '');
	}

	public function getParsed() {
		$css = $this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.css';
		$css = file_get_contents($css);

		return $css;
	}

	/*
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
	*/
}