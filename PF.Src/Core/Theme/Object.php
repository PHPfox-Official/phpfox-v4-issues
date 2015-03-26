<?php

namespace Core\Theme;

class Object extends \Core\Objectify {
	public $theme_id;
	public $name;
	public $folder;
	public $flavor_id;
	public $flavor_folder;
	public $is_active;
	public $is_default;
	public $created;

	/**
	 * @var \Core\Db
	 */
	private $_db;

	public function __construct($keys) {
		parent::__construct($keys);

		$this->_db = new \Core\Db();
	}

	public function getPath() {
		if ($this->folder == 'default') {
			return PHPFOX_DIR . 'theme/' . $this->folder . '/';
		}

		return PHPFOX_DIR_SITE . 'themes/' . $this->folder . '/';
	}

	public function export() {

		$zipFile = PHPFOX_DIR_FILE . 'static/' . $this->folder . '.zip';
		if (file_exists($zipFile)) {
			unlink($zipFile);
		}
		if (file_exists($zipFile . '.json')) {
			unlink($zipFile . '.json');
		}

		$export = [
			'name' => $this->name,
			'created' => $this->created,
			'files' => []
		];
		$files = \Phpfox_File::instance()->getAllFiles($this->getPath());
		foreach ($files as $file) {
			$name = str_replace($this->getPath(), '', $file);

			$export['files'][$name] = file_get_contents($file);
			// p($name);
		}
		// d($export);

		file_put_contents($zipFile . '.json', json_encode($export, JSON_PRETTY_PRINT));

		chdir(PHPFOX_DIR_FILE . 'static/');

		$Zip = new \ZipArchive();
		$Zip->open($zipFile, \ZipArchive::CREATE);
		$Zip->addFile($this->folder . '.zip.json');
		$Zip->close();

		unlink($zipFile . '.json');

		\Phpfox_File::instance()->forceDownload($zipFile, 'phpfox-theme-' . $this->folder . '.zip');
		exit;
	}

	public function setDefault() {
		$this->_db->update(':theme', ['is_default' => 0], ['is_default' => 1]);
		$this->_db->update(':theme_style', ['is_default' => 0], ['is_default' => 1]);

		$this->_db->update(':theme', ['is_default' => 1], ['theme_id' => $this->theme_id]);
		$this->_db->update(':theme_style', ['is_default' => 1], ['style_id' => $this->flavor_id]);

		return true;
	}

	public function setFlavor($id) {
		$flavor = \Phpfox_Database::instance()->select('*')
			->from(':theme_style')
			->where(['style_id' => $id])
			->get();

		$this->flavor_id = $flavor['style_id'];
		$this->flavor_folder = $flavor['folder'];
	}

	/**
	 * @return Flavor\Object[]
	 */
	public function flavors() {
		$rows = \Phpfox_Database::instance()->select('*')
			->from(':theme_style')
			->where(['theme_id' => $this->theme_id])
			->order('name ASC')
			->all();

		$flavors = [];
		foreach ($rows as $row) {
			$row['is_selected'] = ($this->flavor_folder == $row['folder'] ? true : false);

			$flavors[] = new Flavor\Object($row);
		}

		return $flavors;
	}

	public function __toArray() {

	}
}