<?php

namespace Core;

class App {
	private $_apps = [];

	public function __construct() {

		$base = PHPFOX_DIR_SITE . 'apps/';
		foreach (scandir($base) as $vendors) {
			if ($vendors == '.' || $vendors == '..') {
				continue;
			}

			if (!is_dir($base . $vendors)) {
				continue;
			}
			foreach (scandir($base . $vendors) as $apps) {
				$path = $base . $vendors . '/' . $apps . '/';
				$file = $path . 'app.json';
				if (!file_exists($file)) {
					continue;
				}
				$data = json_decode(file_get_contents($file));
				$data->path = $path;

				$this->_apps[$data->id] = $data;
			}


		}

		// d($this->_apps); exit;
	}

	public function vendor() {

	}

	public function make($name, $vendor = null) {
		$base = PHPFOX_DIR_SITE . 'Apps/' . $vendor . '/';
		if (!is_dir($base)) {
			mkdir($base);
		}

		if (!preg_match('/^[a-zA-Z\-0-9]+$/', $name)) {
			throw new \Exception('Product name can only contain alphanumeric characters and a dash.');
		}

		$appBase = $base . $name . '/';
		if (is_dir($appBase)) {
			throw new \Exception('App already exists.');
		}

		$dirs = [
			'Controllers',
			'Model',
			'views'
		];
		foreach ($dirs as $dir) {
			$path = $appBase . $dir;
			if (!is_dir($path)) {
				mkdir($path, 0777, true);
			}
		}

		$json = json_encode(['id' => $vendor . '/' . $name, 'name' => $name], JSON_PRETTY_PRINT);
		file_put_contents($appBase . 'app.json', $json);

		file_put_contents($appBase . 'start.php', "<?php\n");

		$App = new App();

		return $App->get($vendor . '/' . $name);
	}

	/**
	 * @param null $zip
	 * @return App\Object
	 * @throws mixed
	 */
	public function import($zip = null) {
		if ($zip === null) {
			$zip = PHPFOX_DIR_FILE . 'static/import-' . uniqid() . '.zip';
			register_shutdown_function(function() use($zip) {
				unlink($zip);
			});

			file_put_contents($zip, file_get_contents('php://input'));
		}

		$archive = new \ZipArchive();
		$archive->open($zip);
		$json = $archive->getFromName('/app.json');

		$json = json_decode($json);
		if (!isset($json->id)) {
			throw error('Not a valid App to install.');
		}

		$base = PHPFOX_DIR_SITE . 'Apps/' . $json->id . '/';
		if (!is_dir($base)) {
			mkdir($base, 0777, true);
		}

		$archive->close();
		$appPath = $base . 'import-' . uniqid() . '.zip';
		copy($zip, $appPath);

		$newZip = new \ZipArchive();
		$newZip->open($appPath);
		$newZip->extractTo($base);
		$newZip->close();

		register_shutdown_function(function() use($appPath) {
			unlink($appPath);
		});

		$CoreApp = new \Core\App();

		return $CoreApp->get($json->id);
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
		else {
			$app = $this->_apps[$id];
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
			$skip = ['friend', 'like', 'announcement', 'notification', 'poke', 'poll', 'quiz', 'egift', 'newsletter', 'subscribe', 'comment', 'captcha', 'attachment', 'admincp', 'api', 'apps', 'ban', 'core', 'custom', 'emoticon', 'error', 'favorite', 'help', 'im', 'input', 'invite', 'language', 'link', 'log', 'mobile', 'page', 'privacy', 'profile', 'rate', 'report', 'request', 'rss', 'search', 'share', 'tag', 'theme', 'track', 'user'];
			foreach ($modules as $module_id) {
				if (in_array($module_id, $skip)) {
					continue;
				}

				$coreFile = PHPFOX_DIR_MODULE . $module_id . '/install/version/v3.phpfox';
				// p($coreFile);
				if ($includeModules == '__core') {
					if (!file_exists($coreFile)) {
						continue;
					}
				}
				else if ($includeModules == '__not_core' || $includeModules == '__remove_core') {
					if (file_exists($coreFile)) {
						continue;
					}
				}

				$app = [
					'id' => '__module_' . $module_id,
					'name' => \Phpfox_Locale::instance()->translate($module_id, 'module'),
					'path' => null,
					'is_module' => true
				];

				$apps[] = new App\Object($app);
			}

			// exit;

			if ($includeModules == '__core' || $includeModules == '__not_core') {
				return $apps;
			}
		}

		foreach ($this->_apps as $app) {
			$apps[] = new App\Object($app);
		}

		return $apps;
	}
}