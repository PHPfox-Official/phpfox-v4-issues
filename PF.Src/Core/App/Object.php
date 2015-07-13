<?php

namespace Core\App;

class Object extends \Core\Objectify {
	public $id;
	public $name;
	public $vendor;
	public $path;
	public $is_module = false;
	public $icon;
	public $version = '1';
	public $currentVersion;
	public $auth = [
		'id' => '',
		'key' => ''
	];
	public $admincpMenu;
	public $settings = [];
	public $webhooks = [];
	public $routes = [];
	public $head = [];
	public $js = [];
	public $map = [];

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
		$this->vendor = explode('/', $this->id)[0];

		if (!$this->is_module) {
			$file = PHPFOX_DIR_SETTINGS . md5($this->id . \Phpfox::getParam('core.salt')) . '.php';
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
			$this->auth = (object) require($file);
		}
	}

	public function delete() {
		$path = $this->path;
		if (is_dir($path)) {
			\Phpfox_File::instance()->delete_directory($path);
		}
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