<?php

namespace Core\App;

class Object extends \Core\Objectify {

	/**
	 * App ID. Can only be alpanumeric and may contain the underscore
	 * @var int
	 */
	public $id;

	/**
	 * Name of the app
	 * @var string
	 */
	public $name;

	/**
	 * Full path to the app. This is built by the system
	 * @var string
	 */
	public $path;

	/**
	 * Define if this is an old school module or app
	 * @var bool
	 */
	public $is_module = false;

	/**
	 * Full path to icon anywhere on the internet(s)
	 * @var string
	 */
	public $icon;

	/**
	 * Version of the app
	 * @var string
	 */
	public $version = '1';

	/**
	 * Actual version of the app. This is created by the system
	 * @var string
	 */
	public $currentVersion;

	/**
	 * If an app is external, these are the auth ID/key
	 * @var object
	 */
	public $auth = [
		'id' => '',
		'key' => ''
	];

	/**
	 * Attach a menu to the AdminCP for your app
	 * @var array
	 */
	public $admincp_menu = [];

	/**
	 * When admins view your app connect to a custom route
	 * @var string
	 */
	public $admincp_route;

	/**
	 * Global settings for your app and for admins to edit
	 * @var array
	 */
	public $settings = [];

	/**
	 * Webhooks you wish to attach an event to
	 * @var array
	 */
	public $webhooks = [];

	/**
	 * List of external routes, only needed if route is using API
	 * @var array
	 */
	public $routes = [];

	/**
	 * Attach anything to each page of the sites <head></head>
	 * @var array
	 */
	public $head = [];

	/**
	 * Attach JavaScript files. Full links to the JS file itself
	 * @var array
	 */
	public $js = [];


	public $map = [];

	public $footer = [];

	/**
	 * Internal PHPfox app id. Created by the system. Move along.
	 * @var int
	 */
	public $internal_id;

	/**
	 * Company that created the app
	 *
	 * @var string
	 */
	public $vendor;

	/**
	 * User group settings your app may need and for admins to edit
	 * @var array
	 */
	public $user_group_settings = [];

	/**
	 * Define if your app requires another app or a specific PHP version or PHP lib
	 * @var array
	 */
	public $requires = [];

	/**
	 * Using open source code? Sharing is caring.
	 * @var array
	 */
	public $credits = [];

	public $menu = [];

	public function __construct($keys) {
		parent::__construct($keys);

		if (!$this->icon) {
			$name = $this->name[0];
			$parts = explode(' ', $this->name);
			if (isset($parts[1])) {
				$name .= trim($parts[1])[0];
			}
			else {
				$name .= $this->name[1];
			}
			$this->icon = '<b class="app_icons"><i class="app_icon _' . strtolower($name) . '">' . $name . '</i></b>';
		}
		else {
			$this->icon = '<div class="app_icons image_load" data-src="' . $this->icon . '"></div>';
		}
		// $this->vendor = explode('/', $this->id)[0];

		if (!$this->is_module) {
			$file = PHPFOX_DIR_SETTINGS . md5($this->id . \Phpfox::getParam('core.salt')) . '.php';
			/*
			if (!file_exists($file)) {
				$id = md5(uniqid());
				$key = md5(uniqid() . rand(0, 10000));
				// throw new \Exception('App "' . $this->id . '" is missing auth file. Something went wrong with the install of this product.');
				$response = [
					'id' => $id,
					'key' => $key
				];
				$paste = "<?php\n// @app ' . $this->id . ' \nreturn " . var_export((array) $response, true) . ';';
				file_put_contents($file, $paste);
			}
			*/
			if (file_exists($file)) {
				$this->auth = (object) require($file);
				$this->internal_id = (isset($this->auth->internal_id) ? $this->auth->internal_id : 0);
			}
		}

		if (is_array($this->auth)) {
			$this->auth = (object) $this->auth;
		}
	}

	public function delete() {
		if ($this->menu && isset($this->menu->url)) {
			\Phpfox_Database::instance()->delete(':menu', ['m_connection' => 'main', 'url_value' => $this->menu->url]);
		}

		(new \Core\Home(PHPFOX_LICENSE_ID, PHPFOX_LICENSE_KEY))->uninstall([
			'product_id' => $this->internal_id
		]);

		$path = $this->path;
    /*https://github.com/moxi9/phpfox/issues/523*/
    $json_path = $path . 'app.json';
    if (file_exists($json_path)){
      $json = json_decode(file_get_contents($json_path));
      //remove menu if exist
      if (isset($json->menu)){
        \Admincp_Service_Menu_Process::instance()->delete($json->menu->url, true);
      }
    }
		if (is_dir($path)) {
			\Phpfox_File::instance()->delete_directory($path);
		}

		\Phpfox_Cache::instance()->remove();
	}

	/**
	 * @param $object
	 * @return Map
	 */
	public function map($object, $feed) {
		if (substr($object, 0, 1) == '{') {
			$object = json_decode($object);
		}

		return new Map($this, (object) $object, $this->map, $feed);
	}

	public function export() {
		$zipFile = PHPFOX_DIR_FILE . 'static/' . uniqid() . '.zip';
		$zipArchive = new \ZipArchive();

		if (!$zipArchive->open($zipFile, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE)) {
			throw new \Exception('Unable to create ZIP archive.');
		}

		$exclude = array('.git');
		$filter = function ($file, $key, $iterator) use ($exclude) {
			if ($file->getFileName() == 'app.lock' || $file->getFileName() == 'composer.phar') {
				return false;
			}

			if ($iterator->hasChildren() && !in_array($file->getFilename(), $exclude)) {
				return true;
			}
			return $file->isFile();
		};

		$directory = new \SplFileInfo($this->path);
		$innerIterator = new \RecursiveDirectoryIterator(
			$directory->getRealPath(),
			\RecursiveDirectoryIterator::SKIP_DOTS
		);
		$files = new \RecursiveIteratorIterator(
			new \RecursiveCallbackFilterIterator($innerIterator, $filter)
		);

		foreach ($files as $name => $file) {
			if ($file instanceof \SplFileInfo) {
				$filePath = $file->getRealPath();
				$name = str_replace($directory->getRealPath(), '', $filePath);
				$name = str_replace('\\', '/', $name);

				$zipArchive->addFile($filePath, $name);
			}
		}

		$zipArchive->close();

		$name = \Phpfox_Parse_Input::instance()->cleanFileName($this->id);
		$name .= '-v' . $this->version;
		\Phpfox_File::instance()->forceDownload($zipFile, 'phpfox-app-' . $name . '.zip');

		return $zipFile;
	}

	public function __toArray() {

	}
}