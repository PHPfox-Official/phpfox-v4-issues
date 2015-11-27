<?php

namespace Core;

use Core\Theme\Object;

class Theme extends Model {
	private static $_active;

	public function __construct($flavorId = null) {
		parent::__construct();

		if ($flavorId !== null) {
			self::$_active = $this->db->select('t.*, ts.folder AS flavor_folder')
				->from(':theme_style', 'ts')
				->join(':theme', 't', ['t.theme_id' => ['=' => 'ts.theme_id']])
				->where(['ts.style_id' => (int) $flavorId])
				->get();

			if (!self::$_active) {
				throw new \Exception('Not a valid flavor.');
			}
		}

		if (!self::$_active) {
			$cookie = \Phpfox::getCookie('flavor_id');

			if ($cookie) {
				self::$_active = $this->db->select('t.*, ts.folder AS flavor_folder')
					->from(':theme_style', 'ts')
					->join(':theme', 't', ['t.theme_id' => ['=' => 'ts.theme_id']])
					->where(['ts.style_id' => (int) $cookie])
					->get();
			}
			else {
				self::$_active = $this->db->select('t.*, ts.folder AS flavor_folder')
					->from(':theme', 't')
					->join(':theme_style', 'ts', ['t.theme_id' => ['=' => 'ts.theme_id'], 'ts.is_default' => 1])
					->where(($cookie ? ['t.theme_id' => (int) $cookie] : ['t.is_default' => 1]))
					->get();
			}

			if (!self::$_active || defined('PHPFOX_CSS_FORCE_DEFAULT')) {
				self::$_active = [
					'name' => 'Default',
					'folder' => 'default',
					'flavor_folder' => 'default'
				];
			}
		}
	}

	public function import($zip = null, $extra = null) {
		$file = PHPFOX_DIR_FILE . 'static/' . uniqid() . '/';
		mkdir($file);

		if ($zip === null) {
			$zip = $file . 'import.zip';
			if (isset($_FILES['ajax_upload'])) {
				file_put_contents($zip, file_get_contents($_FILES['ajax_upload']['tmp_name']));
			}
			else {
				file_put_contents($zip, file_get_contents('php://input'));
			}
		}

		$exists = false;
		if ($extra !== null && isset($extra->id)) {
			foreach ($this->all() as $theme) {
				if ($theme->internal_id == $extra->id) {
					$exists = $theme;

					break;
				}
			}
		}

		/*
		if ($exists instanceof Object) {
			$Zip = new \ZipArchive();
			$Zip->open($zip);
			$Zip->extractTo($file);
			$Zip->close();

			$this->db->update(':theme', ['website' => json_encode($extra)], ['theme_id' => $exists->theme_id]);
			$this->db->update(':setting', array('value_actual' => ((int) \Phpfox::getParam('core.css_edit_id') + 1)), 'var_name = \'css_edit_id\'');
			$this->cache->del('setting');

			return $exists;
		}
		*/

		$Zip = new \ZipArchive();
		$Zip->open($zip);
		$Zip->extractTo($file);
		$Zip->close();

		$themeId = null;
		$File = \Phpfox_File::instance();
		foreach (scandir($file) as $f) {
			if ($File->extension($f) == 'json') {
				$data = json_decode(file_get_contents($file . $f));

				$isUpdate = false;
				if ($exists instanceof Object) {
					$isUpdate = $exists->theme_id;
					$this->db->update(':theme', ['website' => json_encode($extra)], ['theme_id' => $exists->theme_id]);
					$this->db->update(':setting', array('value_actual' => ((int) \Phpfox::getParam('core.css_edit_id') + 1)), 'var_name = \'css_edit_id\'');
					$this->cache->del('setting');
				}

				$themeId = $this->make([
					'name' => $data->name,
					'extra' => ($extra ? json_encode($extra) : null)
				], $data->files, $isUpdate);

				if ($isUpdate) {
					continue;
				}

				$File->delete_directory($file);
				$iteration = 0;
				foreach ($data->flavors as $flavorId => $flavorName) {
					$iteration++;

					$this->db->insert(':theme_style', [
						'theme_id' => $themeId,
						'name' => $flavorName,
						'folder' => $flavorId,
						'is_default' => ($iteration === 1 ? '1' : '0'),
						'is_active' => 1,
						'created' => PHPFOX_TIME
					]);
				}
			}
		}

		if ($themeId === null) {
			throw new \Exception('Theme is missing its JSON file.');
		}

		return $themeId;
	}

	/**
	 * @param $val
	 * @param null $files
	 * @return Theme\Object
	 */
	public function make($val, $files = null, $isUpdate = false, $sCustomFolder = null) {
		/*
		$check = $this->db->select('COUNT(*) AS total')
			->from(':theme')
			->where(['folder' => $val['folder']])
			->get();

		if ($check['total']) {
			throw error('Folder already exists.');
		}
		*/

		if (!$isUpdate) {
			$id = $this->db->insert(':theme', [
				'name' => $val['name'],
				'folder' => '__',
				'website' => (isset($val['extra']) ? $val['extra'] : null),
				'created' => PHPFOX_TIME,
				'is_active' => 1
			]);

      if (isset($sCustomFolder) && !empty($sCustomFolder)){
        $folderTheme = strtolower($sCustomFolder);
      } else {
        $folderTheme = $id;
      }
			$this->db->update(':theme', ['folder' => $folderTheme], ['theme_id' => $id]);
		}
		else {
			$id = $isUpdate;
		}

		if ($files !== null) {
			foreach ($files as $name => $content) {
				$path = PHPFOX_DIR_SITE . 'themes/' . $folderTheme . '/' . $name;
				$parts = pathinfo($path);
				if (!is_dir($parts['dirname'])) {
					mkdir($parts['dirname'], 0777, true);
				}

				file_put_contents($path, $content);
			}

			return $id;
		}


		$flavorId = $this->db->insert(':theme_style', [
			'theme_id' => $id,
			'is_active' => 1,
			'is_default' => 1,
			'name' => 'Default',
			'created' => PHPFOX_TIME,
			'folder' => '__'
		]);

    if (isset($sCustomFolder) && !empty($sCustomFolder)){
      $folderName = strtolower($sCustomFolder);
    } else {
      $folderName = $flavorId;
    }
		$this->db->update(':theme_style', ['folder' => $folderName], ['style_id' => $flavorId]);

		$File = \Phpfox_File::instance();
		$copy = [];
		$dirs = [];
    if (isset($sCustomFolder) && !empty($sCustomFolder)){
      $files = $File->getAllFiles(PHPFOX_DIR. 'theme/'.strtolower($sCustomFolder).'/');
    } else {
      $files = $File->getAllFiles(PHPFOX_DIR. 'theme/default/');
    }
		foreach ($files as $file) {
			if (!in_array($File->extension($file), [
				'html', 'js', 'css', 'less'
			])) {
				continue;
			}

			$parts = pathinfo($file);
      if (isset($sCustomFolder) && !empty($sCustomFolder)){
        $dirs[] = str_replace(PHPFOX_DIR . 'theme/'.strtolower($sCustomFolder).'/', '', $parts['dirname']);
      } else {
        $dirs[] = str_replace(PHPFOX_DIR . 'theme/default/', '', $parts['dirname']);
      }
			$copy[] = $file;
		}

		$path = PHPFOX_DIR_SITE . 'themes/' . $folderTheme . '/';
		foreach ($dirs as $dir) {
			if (!is_dir($fullpath =  $path . $dir)) {
				if(!@mkdir($fullpath, 0777, true)){
					exit("Could not write to $fullpath");
				}
				@chmod($fullpath,0755);
			}
		}

		foreach ($copy as $file) {
      if (isset($sCustomFolder) && !empty($sCustomFolder)){
        $newFile = $path . str_replace(PHPFOX_DIR . 'theme/'.strtolower($sCustomFolder).'/', '', $file);
      } else {
        $newFile = $path . str_replace(PHPFOX_DIR . 'theme/default/', '', $file);
      }
			if (in_array($File->extension($file), ['less', 'css'])) {
				$newFile = str_replace('default.' . $File->extension($file), $folderName . '.' . $File->extension($file), $newFile);
			}

			copy($file, $newFile);
			if ($File->extension($file) == 'less') {
				$content = file_get_contents($newFile);
				$content = str_replace('../../../', '../../../../PF.Base/', $content);
				file_put_contents($newFile, $content);
			}
		}

		return $this->get($id);
	}

	/**
	 * @return Theme\Object
	 */
	public function get($id = null) {
		$data = self::$_active;
		if ($id === null && !$data) {
			$data = $this->db->select('t.*, ts.style_id AS flavor_id, ts.folder AS flavor_folder')
				->from(':theme', 't')
				->join(':theme_style', 'ts', ['t.theme_id' => ['=' => 'ts.theme_id']])
				->where(['t.is_default' => 1])
				->get();
		}

		if ($id !== null) {
			$data = $this->db->select('t.*, ts.style_id AS flavor_id, ts.folder AS flavor_folder')
				->from(':theme', 't')
				->join(':theme_style', 'ts', ['t.theme_id' => ['=' => 'ts.theme_id']])
				->where(['t.theme_id' => (int) $id])
				->get();
		}

		if (!$data) {
			throw error('Theme not found.');
		}

		return new Theme\Object($data);
	}

	/**
	 * @return Theme\Object[]
	 */
	public function all() {
		$rows = $this->db->select('t.*')
			->from(':theme', 't')
			->order('t.name ASC')
			->all();

		$themes = [];
		foreach ($rows as $row) {
			$Theme = new Theme\Object($row);

			if ($Theme->folder == 'default') {
				continue;
			}

			if (!is_dir($Theme->getPath())) {
				continue;
			}

			$themes[] = $Theme;
		}

		return $themes;
	}
}