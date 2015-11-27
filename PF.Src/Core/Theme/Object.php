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
	public $image;
	public $internal_id;
	public $version;

	protected $website;

	/**
	 * @var \Core\Db
	 */
	private $_db;

	public function __construct($keys) {
		parent::__construct($keys);

		if (isset($this->website) && substr($this->website, 0, 1) == '{') {
			foreach (json_decode($this->website) as $key => $value) {
				if ($key == 'id') {
					$key = 'internal_id';
				}
				$this->$key = $value;
			}
			unset($this->website);
		}

		$currentImage = $this->image;

		$this->_db = new \Core\Db();
		$this->image = new \Core\Objectify(function() use ($currentImage) {

			// class="image_load" data-src="{$theme.image}"
			$html = '';
			if ($currentImage) {
				$html = 'class="image_load" data-src="' . $currentImage . '"';
			}
			else {
				$hex = function($color) {
					$color = trim($color);
					$color = preg_replace('/(lighten|darken)\(\#(.*), (.*)\)/i', '#\\2', $color);

					return '<span style="background:' . $color . ';"></span>';
				};

				$flavor = (new \Core\Theme\Flavor($this))->getDefault();
				$path = $this->getPath() . 'flavor/' . $flavor->folder . '.less';
				if (file_exists($path)) {
					$colors = [];
					$lines = file($path);
					foreach ($lines as $line) {
						// p($line);
						if (preg_match('/@brandPrimary\:(.*?);/s', $line, $matches)) {
							$colors[] = $hex($matches[1]);
						}
						else if (preg_match('/@bodyBg\:(.*?);/s', $line, $matches)) {
							$colors[] = $hex($matches[1]);
						}
						else if (preg_match('/@blockBg\:(.*?);/s', $line, $matches)) {
							$colors[] = $hex($matches[1]);
						}
						else if (preg_match('/@headerBg\:(.*?);/s', $line, $matches)) {
							$colors[] = $hex($matches[1]);
						}
					}

					if ($colors) {
						$colors = implode('', $colors);
						$html = '><div class="theme_colors">' . $colors . '<' . "/div";
					}
				}
			}

			return $html;
		});
	}

	public function basePath() {
		return PHPFOX_DIR . 'theme/default/';
	}

	public function getPath() {
		if ($this->folder == 'default') {
			return PHPFOX_DIR . 'theme/' . $this->folder . '/';
		}

		return PHPFOX_DIR_SITE . 'themes/' . $this->folder . '/';
	}

	public function delete() {
		if (is_dir($this->getPath())) {
			\Phpfox_File::instance()->delete_directory($this->getPath());
		}

		foreach ($this->flavors() as $Flavor) {
			$Flavor->delete();
		}
		$this->_db->delete(':theme', ['theme_id' => $this->theme_id]);

		return ;
	}

	public function export($savePath = null) {

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
			'flavors' => [],
			'files' => []
		];

		$flavors = $this->_db->select('*')
			->from(':theme_style')
			->where(['theme_id' => $this->theme_id])
			->all();
		foreach ($flavors as $flavor) {
			$export['flavors'][$flavor['folder']] = $flavor['name'];
		}

		$files = \Phpfox_File::instance()->getAllFiles($this->getPath());
		foreach ($files as $file) {
			$name = str_replace($this->getPath(), '', $file);
			if (substr($name, 0, 4) == '.git') {
				continue;
			}

			$export['files'][$name] = file_get_contents($file);
			// p($name);
		}

		file_put_contents($zipFile . '.json', json_encode($export, JSON_PRETTY_PRINT));

		chdir(PHPFOX_DIR_FILE . 'static/');

		$Zip = new \ZipArchive();
		$Zip->open($zipFile, \ZipArchive::CREATE);
		$Zip->addFile($this->folder . '.zip.json');
		$Zip->close();

		unlink($zipFile . '.json');

		if ($savePath) {
			copy($zipFile, $savePath);

			return true;
		}

		$name = \Phpfox_Parse_Input::instance()->cleanFileName($this->name);
		\Phpfox_File::instance()->forceDownload($zipFile, 'phpfox-theme-' . $name . '.zip');
		exit;
	}

	public function setDefault() {
		$this->_db->update(':theme', ['is_default' => 0], ['is_default' => 1]);
		$this->_db->update(':theme_style', ['is_default' => 0], ['is_default' => 1]);

		$this->_db->update(':theme', ['is_default' => 1], ['theme_id' => $this->theme_id]);
		$this->_db->update(':theme_style', ['is_default' => 1], ['style_id' => $this->flavor_id]);

		return true;
	}

	public function deleteFlavor($id) {
		\Phpfox_Database::instance()->delete(':theme_style', ['style_id' => (int) $id]);

		return true;
	}

	public function setFlavor($id) {
		$flavor = \Phpfox_Database::instance()->select('*')
			->from(':theme_style')
			->where(['style_id' => $id])
			->get();

		if (!isset($flavor['style_id'])) {
			return false;
		}

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

			$flavors[] = new Flavor\Object($this, $row);
		}

		return $flavors;
	}

	public function rebuild() {
		$flavorId = $this->flavor_folder;
		if (!$flavorId) {
			throw new \Exception('Cannot merge a theme without a flavor.');
		}
    $db = new \Core\Db();
    $moduleList = $db->select('module_id')
      ->singleData('module_id')
      ->from(':module')
      ->where('is_active=1')
      ->all();
		$css = new CSS($this);
		try {
			$data = $css->get();
      $moduleData = $css->getModule($moduleList);
      $css->reBuildModule($moduleList, $this->name);
      $appData = $css->getApp();
			$css->set($data, null, $moduleData . $appData, $this->name);
		} catch (\Exception $e) {
			if(PHPFOX_DEBUG){
				exit("error:" . $e->getMessage());
			}
			return false;
		}
	}

	public function merge() {
		$flavorId = $this->flavor_folder;
		if (!$flavorId) {
			throw new \Exception('Cannot merge a theme without a flavor.');
		}

		$id = $this->theme_id;
    //get folder name
    $Db = new \Core\Db();
    $folderName = (String) $Db->select('folder')
      ->from(':theme')
      ->where('theme_id=' . (int) $id)
      ->count();
    if (empty($folderName)){
      $folderName = $id;
    }
		$path = PHPFOX_DIR_SITE . 'themes/' . $folderName . '/';
		$File = \Phpfox_File::instance();
		$copy = [];
		$dirs = [];
    $themeFile = (strtolower($folderName) == 'bootstrap') ? 'bootstrap' : 'default';
    $files = $File->getAllFiles(PHPFOX_DIR. 'theme/'.$themeFile.'/');
		foreach ($files as $file) {
			if (!in_array($File->extension($file), [
				'html', 'js', 'css', 'less'
			])) {
				continue;
			}

			$parts = pathinfo($file);

			$dirs[] = str_replace(PHPFOX_DIR . 'theme/default/', '', $parts['dirname']);
			$copy[] = $file;
		}

		foreach ($copy as $file) {
      $newFile = $path . str_replace(PHPFOX_DIR . 'theme/'.$themeFile.'/', '', $file);
			if (in_array($File->extension($file), ['less', 'css'])) {
				$newFile = str_replace('default.' . $File->extension($file), $flavorId . '.' . $File->extension($file), $newFile);
			}

			copy($file, $newFile);

			// p($file . ' -> ' . $newFile);
			if ($File->extension($file) == 'less') {
				$content = file_get_contents($newFile);
				$content = str_replace('../../../', '../../../../PF.Base/', $content);
				file_put_contents($newFile, $content);
			}
		}

		$Cache = new \Core\Cache();

		$Db->update(':setting', array('value_actual' => ((int) \Phpfox::getParam('core.css_edit_id') + 1)), 'var_name = \'css_edit_id\'');
		$Cache->del('setting');

		// exit;

		return true;
	}

  public function getCssFileName($path, $type = 'module'){
    //check is less file exist
    if (substr($path, -4) == '.css'){
      $lessPath = substr($path, 0, -4) . '.less';
      if (file_exists(PHPFOX_DIR . $lessPath)){
        $path = $lessPath;
      }
    }
    $path = trim(str_replace('module', '', $path), PHPFOX_DS);
    $themPath =  'themes/' . $this->folder . '/';
    if ($this->folder == 'default') {
      $themPath =  'theme/' . $this->folder . '/';
    }
    $filePath = $themPath . 'flavor/' . trim(substr(str_replace([PHPFOX_DS,'/','\\'], ['_','_','_'], $path), 0, -4),'_');
    $filePath = trim($filePath, '.');
    $filePath = $filePath . '.css';
    if (!file_exists($filePath)){
		try{
			(new CSS($this))->buildFile($path, $type);
		}catch(\Exception $e){
			if(PHPFOX_DEBUG)
				throw $e;
		}
    }

    return 'PF.Site/' . $filePath;
  }

	public function __toArray() {

	}
}