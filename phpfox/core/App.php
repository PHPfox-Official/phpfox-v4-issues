<?php

namespace Core;

class App {
	private $_apps = [];

	public function __construct() {
		foreach (scandir(PHPFOX_DIR_PARENT . 'apps/') as $apps) {
			if ($apps == '.' || $apps == '..') {
				continue;
			}

			$path = PHPFOX_DIR_PARENT . 'apps/' . $apps . '/';
			$file = $path . 'app.json';
			if (!file_exists($file)) {
				continue;
			}
			$data = json_decode(file_get_contents($file));
			$data->path = $path;

			$this->_apps[$data->name] = $data;
		}
	}

	/**
	 * @return App\Object[]
	 */
	public function all() {
		$apps = [];
		foreach ($this->_apps as $app) {
			$apps[] = new App\Object($app);
		}

		return $apps;
	}
}