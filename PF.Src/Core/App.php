<?php

namespace Core;

class App {
	public static $routes = [];

	private static $_apps = null;

	public function __construct($refresh = false) {
		if (defined('PHPFOX_NO_APPS')) {
			self::$_apps = [];
			return;
		}

		$base = PHPFOX_DIR_SITE . 'Apps/';
		if (!is_dir($base)) {
			self::$_apps = [];
			return;
		}

		if (self::$_apps !== null && !$refresh) {
			return;
		}

		self::$_apps = [];
		foreach (scandir($base) as $app) {
			if ($app == '.' || $app == '..') {
				continue;
			}

			$path = $base . $app . '/';

			if (!file_exists($path . 'app.lock')) {
				continue;
			}

			$jsonData = file_get_contents($path . 'app.json');
			$jsonData = preg_replace_callback('/{{ ([a-zA-Z0-9_]+) }}/is', function($matches) use($jsonData) {
				$_data = json_decode($jsonData);
				if (!isset($_data->{$matches[1]})) {
					return $matches[0];
				}

				return $_data->{$matches[1]};
			}, $jsonData);

			$data = json_decode($jsonData);
			$data->path = $path;

			if (isset($data->routes)) {
				foreach ((array) $data->routes as $key => $route) {
					$orig = $route;
					$route = (array) $route;
					$route['id'] = $data->id;
					if (is_string($orig)) {
						$route['url'] = $orig;
					}
					Route::$routes = array_merge(Route::$routes, [$key => $route]);
				}
			}

			self::$_apps[$data->id] = $data;

			\Core\Route\Controller::$active = $data->path;
			\Core\Route\Controller::$activeId = $data->id;

			$vendor = $data->path . 'vendor/autoload.php';
			if (file_exists($vendor)) {
				require_once($vendor);
			}

			if (file_exists($data->path . 'start.php')) {
				$callback = require_once($data->path . 'start.php');
				if (is_callable($callback)) {
					$View = new \Core\View();
					$viewEnv = null;
					if (is_dir($data->path . 'views/')) {
						$View->loader()->addPath($data->path . 'views/', $data->id);
						$viewEnv = $View->env();
					}
					call_user_func($callback, $this->get($data->id), $viewEnv);
				}
			}
		}

		// d(self::$_apps); exit;
	}

	public function vendor() {

	}

	public function make($name) {
		ignore_user_abort(true);

		$base = PHPFOX_DIR_SITE . 'Apps/';
		$isGit = false;
		$gitFile = null;
		$git = '';
		$url = '';

		if (substr($name, 0, 8) == 'https://') {
			$isGit = true;
			$git = $name;

			$url = substr_replace(str_replace(['github.com'], ['raw.githubusercontent.com'], $git), '', -4) . '/master/app.json';
			$gitFile = PHPFOX_DIR_FILE . 'static/' . md5($git) . '.log';
			if (file_exists($gitFile)) {
				unlink($gitFile);
			}

			$headers = @get_headers($url);
			if ($headers[0] != 'HTTP/1.1 200 OK') {
				throw error('Unable to load the URL "%s"', $url);
			}

			file_put_contents($gitFile, "## Github Headers: ##\n" . print_r($headers, true) . "\n\n");

			$json = json_decode(file_get_contents($url . '?v=' . PHPFOX_TIME));
			if (!isset($json->id)) {
				throw error('Not a valid JSON file. Missing App ID.');
			}
			$name = $json->id;
			file_put_contents($gitFile, "## App JSON File: ##\n" . print_r($json, true) . file_get_contents($gitFile) . "\n\n");
		}

		if (!preg_match('/^[a-zA-Z\_0-9]+$/', $name)) {
			throw new \Exception('Product name can only contain alphanumeric characters and/or an underscore.');
		}

		$appBase = $base . $name . '/';
		if (is_dir($appBase)) {
			throw new \Exception('App already exists.');
		}

		if ($isGit && function_exists('shell_exec')) {
			$out = shell_exec('git --version');
			if (!preg_match('/git version ([0-9\.]+) (.*?)/', $out)) {
				throw new \Exception('Server does not support git.');
			}
			file_put_contents($gitFile, "## git version: ##\n" . $out . file_get_contents($gitFile) . "\n\n");
		}

		try {
			if (!$isGit) {
				throw error('not_git');
			}

			$out = shell_exec('git clone ' . $git . ' ' . $appBase . ' 2>&1');
			if (!file_exists($appBase . 'app.json')) {
				throw error('Not a valid Git app.');
			}
			file_put_contents($gitFile, "## Running git clone: ##\n" . $out . file_get_contents($gitFile) . "\n\n");

			$headers = @get_headers(str_replace('app.json', 'composer.json', $url));
			if ($headers[0] == 'HTTP/1.1 200 OK') {
				$composer = $appBase . 'composer.phar';
				if (!file_exists($composer)) {
					file_put_contents($composer, file_get_contents('https://getcomposer.org/composer.phar'));
				}
				chdir($appBase);
				$out = shell_exec('php composer.phar install 2>&1');
				file_put_contents($gitFile, "## Running composer: ##\n" . $out . file_get_contents($gitFile));
				chdir(PHPFOX_DIR);
			}

			$this->processJson($json, $appBase);
		}
		catch (\Exception $e) {
			if ($e->getMessage() != 'not_git') {
				throw new \Exception($e->getMessage(), $e->getCode(), $e);
			}

			$dirs = [
				'assets',
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

			$json = json_encode(['id' => $name, 'name' => $name], JSON_PRETTY_PRINT);
			file_put_contents($appBase . 'app.json', $json);

			file_put_contents($appBase . 'assets/autoload.js', "\n\$Ready(function() {\n\n});");
			file_put_contents($appBase . 'assets/autoload.less', "\n@import \"../../../../PF.Base/less/variables\";\n");
			file_put_contents($appBase . 'start.php', "<?php\n");
		}

		$lockPath = $appBase . 'app.lock';
		$lock = json_encode(['installed' => PHPFOX_TIME, 'version' => 0], JSON_PRETTY_PRINT);
		file_put_contents($lockPath, $lock);

		(new \Core\Cache())->purge();

		$App = new App(true);

		$Object = $App->get($name);

		$this->makeKey($Object, md5(uniqid()), md5(uniqid() . rand(0, 10000)));

		return $Object;
	}

	public function makeKey(App\Object $App, $id, $key, $internalId = 0) {
		$file = PHPFOX_DIR_SETTINGS . md5($App->id . \Phpfox::getParam('core.salt')) . '.php';

		$response = [
			'id' => $id,
			'key' => $key,
			'version' => $App->version,
			'internal_id' => $internalId
		];
		$paste = "<?php\nreturn " . var_export((array) $response, true) . ';';

		file_put_contents($file, $paste);
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

			if (isset($_FILES['ajax_upload'])) {
				file_put_contents($zip, file_get_contents($_FILES['ajax_upload']['tmp_name']));
			}
			else {
				file_put_contents($zip, file_get_contents('php://input'));
			}
		}

		if ($download) {
			$zipUrl = $zip;
			$zip = PHPFOX_DIR_FILE . 'static/import-' . uniqid() . '.zip';
			register_shutdown_function(function() use($zip) {
				unlink($zip);
			});

			file_put_contents($zip, file_get_contents($zipUrl));
		}

		$fromWindows = false;
		$archive = new \ZipArchive();
		$archive->open($zip);
		$json = $archive->getFromName('/app.json');

		if (!$json) {
			$json = $archive->getFromName('app.json');
		}

		if (!$json) {
			$json = $archive->getFromName('\\app.json');
			$fromWindows = true;
		}

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

		$check = $base . 'app.json';
		if (!file_exists($check)) {
			throw new \Exception('App was unable to install.');
		}

		$lockPath = $base . 'app.lock';
		if (!$isUpgrade && file_exists($lockPath)) {
			unlink($lockPath);
		}

		$isNew = false;
		if (file_exists($lockPath)) {
			$lock = json_decode(file_get_contents($lockPath));
			$lock->updated = PHPFOX_TIME;
			file_put_contents($lockPath, json_encode($lock, JSON_PRETTY_PRINT));
		}
		else {
			$isNew = true;

			$this->processJson($json, $base);

			$lock = json_encode(['installed' => PHPFOX_TIME, 'version' => $json->version], JSON_PRETTY_PRINT);
			file_put_contents($lockPath, $lock);
		}

		$CoreApp = new \Core\App(true);
		$Object = $CoreApp->get($json->id);

		if ($isNew) {
			$Request = \Phpfox_Request::instance();
			$internalId = 0;
			if ($Request->get('product')) {
				$product = json_decode($Request->get('product'));
				$internalId = $product->id;
			}
			$this->makeKey($Object, $Request->get('auth_id'), $Request->get('auth_key'), $internalId);
		}

		return $Object;
	}

	public function processJson($json, $base) {
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

		if (file_exists($base . 'installer.php')) {
			\Core\App\Installer::$method = 'onInstall';
			\Core\App\Installer::$basePath = $base;

			require_once($base . 'installer.php');
		}
	}

	/**
	 * @param $id
	 * @return App\Object
	 */
	public function getByInternalId($id) {
		foreach ($this->all() as $app) {
			if ($app->internal_id == $id) {
				return $app;
			}
		}
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
			if (!isset(self::$_apps[$id])) {
				throw new \Exception('App not found "' . $id . '".');
			}

			$app = self::$_apps[$id];
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
			$skip = ['friend', 'like', 'facebook', 'announcement', 'notification', 'poke', 'poll', 'quiz', 'egift', 'newsletter', 'subscribe', 'comment', 'captcha', 'attachment', 'admincp', 'api', 'apps', 'ban', 'core', 'custom', 'emoticon', 'error', 'favorite', 'help', 'im', 'input', 'invite', 'language', 'link', 'log', 'mobile', 'page', 'privacy', 'profile', 'rate', 'report', 'request', 'rss', 'search', 'share', 'tag', 'theme', 'track', 'user'];
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

		foreach (self::$_apps as $app) {
			$apps[] = new App\Object($app);
		}

		return $apps;
	}
}