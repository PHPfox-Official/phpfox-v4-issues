<?php

namespace Core\App;

class Object extends \Core\Objectify {
	public $id;
	public $name;
	public $vendor;
	public $path;
	public $is_module = false;
	public $icon;
	public $version;
	public $currentVersion;
	public $unityId;
	public $admincpMenu;
	public $settings = [];

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
	}

	public function delete() {
		$path = $this->path;
		if (is_dir($path)) {
			\Phpfox_File::instance()->delete_directory($path);
		}
	}

	public function export() {
		$zipFile = PHPFOX_DIR_FILE . 'static/' . uniqid() . '.zip';
		$zipArchive = new \ZipArchive();

		if (!$zipArchive->open($zipFile, \ZIPARCHIVE::OVERWRITE)) {
			throw new \Exception('Unable to create ZIP archive.');
		}

		$exclude = array('.git');
		$filter = function ($file, $key, $iterator) use ($exclude) {
			if ($file->getFileName() == 'app.lock') {
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
				$zipArchive->addFile($filePath, $name);
			}
		}

		$zipArchive->close();

		$name = \Phpfox_Parse_Input::instance()->cleanFileName($this->id);
		\Phpfox_File::instance()->forceDownload($zipFile, 'phpfox-app-' . $name . '.zip');

		return $zipFile;
	}

	public function __toArray() {

	}
}