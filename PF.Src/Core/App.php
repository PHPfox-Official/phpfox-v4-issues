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
				$installed = $path . 'app.lock';

				if (!file_exists($file)) {
					continue;
				}

				if (!file_exists($installed)) {
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

		$lockPath = $base . 'app.lock';
		$lock = json_encode(['installed' => PHPFOX_TIME, 'version' => 0], JSON_PRETTY_PRINT);
		file_put_contents($lockPath, $lock);

		$App = new App();

		$Object = $App->get($vendor . '/' . $name);

		// $this->install($Object);

		return $Object;
	}

	/**
	 * @param null $zip
	 * @return App\Object
	 * @throws mixed
	 */
	public function import($zip = null, $download = false, $isUpgrade = false) {
		if ($zip === null || empty($zip)) {
			$zip = PHPFOX_DIR_FILE . 'static/import-' . uniqid() . '.zip';
			register_shutdown_function(function() use($zip) {
				unlink($zip);
			});

			file_put_contents($zip, file_get_contents('php://input'));
		}

		if ($download) {
			$zipUrl = $zip;
			$zip = PHPFOX_DIR_FILE . 'static/import-' . uniqid() . '.zip';
			register_shutdown_function(function() use($zip) {
				unlink($zip);
			});

			file_put_contents($zip, file_get_contents($zipUrl));
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

		$lockPath = $base . 'app.lock';
		if (!$isUpgrade && file_exists($lockPath)) {
			unlink($lockPath);
		}

		if (file_exists($lockPath)) {
			$lock = json_decode(file_get_contents($lockPath));
			$lock->updated = PHPFOX_TIME;
			file_put_contents($lockPath, json_encode($lock, JSON_PRETTY_PRINT));
		}
		else {
			if (isset($json->menu)) {
				\Admincp_Service_Menu_Process::instance()->add([
					'm_connection' => 'main',
					'product_id' => 'phpfox',
					'allow_all' => true,
					'mobile_icon' => (isset($json->menu->icon) ? $json->menu->icon : null),
					'url_value' => $json->menu->url,
					'text' => ['en' => $json->menu->name]
				]);
			}

			$lock = json_encode(['installed' => PHPFOX_TIME, 'version' => $json->version], JSON_PRETTY_PRINT);
			file_put_contents($lockPath, $lock);
		}

		$CoreApp = new \Core\App();
		$Object = $CoreApp->get($json->id);

		// $this->install($Object);

		return $Object;
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
			if (!isset($this->_apps[$id])) {
				throw new \Exception('App not found "' . $id . '".');
			}

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