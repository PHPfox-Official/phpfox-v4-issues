<?php

namespace Core;

class App {
	private $_apps = [];

	public function __construct() {
		foreach (scandir(PHPFOX_DIR_SITE . 'apps/') as $apps) {
			if ($apps == '.' || $apps == '..') {
				continue;
			}

			$path = PHPFOX_DIR_SITE . 'apps/' . $apps . '/';
			$file = $path . 'app.json';
			if (!file_exists($file)) {
				continue;
			}
			$data = json_decode(file_get_contents($file));
			$data->path = $path;

			$this->_apps[$data->name] = $data;
		}

		// d($this->_apps); exit;
	}

	public function get($id) {
		$app = [];
		if (substr($id, 0, 9) == '__module_') {
			$id = substr_replace($id, '', 0, 9);
			$db = new \Core\Db();
			$module = $db->select('m.*, p.*')
				->from(':module', 'm')
				->join(':product' , 'p', 'p.product_id = m.product_id')
				->where(['m.module_id' => $id])
				->get();

			if ($module['product_id'] == 'phpfox') {
				$module['version'] = \Phpfox::getVersion();
			}
			$app = [
				'id' => '__module_' . $id,
				'name' => \Phpfox_Locale::instance()->translate($id, 'module'),
				'path' => null,
				'is_module' => true,
				'version' => $module['version']
			];
		}

		return new App\Object($app);
	}

	/**
	 * @return App\Object[]
	 */
	public function all($includeModules = false) {
		$apps = [];
		if ($includeModules) {
			$modules = \Phpfox_Module::instance()->all();
			$skip = ['admincp', 'api', 'apps', 'ban', 'core', 'custom', 'emoticon', 'error', 'favorite', 'help', 'im', 'input', 'invite', 'language', 'link', 'log', 'mobile', 'page', 'privacy', 'profile', 'rate', 'report', 'request', 'rss', 'search', 'share', 'tag', 'theme', 'track', 'user'];
			foreach ($modules as $module_id) {
				if (in_array($module_id, $skip)) {
					continue;
				}

				$app = [
					'id' => '__module_' . $module_id,
					'name' => \Phpfox_Locale::instance()->translate($module_id, 'module'),
					'path' => null,
					'is_module' => true
				];

				$apps[] = new App\Object($app);
			}

			if ($includeModules == '__modules') {
				return $apps;
			}
		}

		foreach ($this->_apps as $app) {
			$apps[] = new App\Object($app);
		}

		// d($apps); exit;

		return $apps;
	}
}