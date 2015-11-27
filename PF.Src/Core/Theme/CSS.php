<?php

namespace Core\Theme;

class CSS extends \Core\Model {
	private $_theme;

	public function __construct(\Core\Theme\Object $Theme) {
		parent::__construct();

		$this->_theme = $Theme;
	}

  /**
   * @param $content
   * @param null $vars
   * @param string $more_content will not add to less files
   * @return bool
   */
	public function set($content, $vars = null, $more_content = '', $themeName = 'default') {
		$less = new \lessc();
		$lessContent = ($vars === null ? $this->get(true) : $vars) . "/** START CSS */\n";
    $saveLestContent = $lessContent . trim($content);
		$newContent = $saveLestContent . trim($more_content);
    if (strtolower($themeName) == 'bootstrap'){
      $less->setImportDir(PHPFOX_DIR . 'theme/frontend/bootstrap/less/');
    } else {
      $less->setImportDir(PHPFOX_DIR . 'less/');
    }
		$content = str_replace('../../../../PF.Base/less/', '', $newContent);
    $content = '@import "variables";' . PHP_EOL .  $content;
    $parsed =  null;
    try {
      $parsed = $less->compile($content);
    } catch (\Exception $ex) {
      if (PHPFOX_DEBUG) {
        \Phpfox_Error::trigger($ex->getMessage(), E_USER_ERROR);
      }
    }
		$path = $this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder;
		file_put_contents($path . '.less', $saveLestContent);
    /* remove comments */
    $minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $parsed );

    /* remove tabs, spaces, newlines, etc. */
    $minify = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $minify );
		file_put_contents($path . '.css', $minify);

		$this->db->update(':setting', array('value_actual' => ((int) \Phpfox::getParam('core.css_edit_id') + 1)), 'var_name = \'css_edit_id\'');
		$this->cache->del('setting');
		return true;

		// file_put_contents($this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.min.css', $parsed);

		// if ($this->_get()) {
			/*
			$this->db->update(':theme_template', [
				'html_data' => $parsed,
				'html_data_original' => $content,
				'time_stamp_update' => PHPFOX_TIME
			], [
				'folder' => $this->_theme->folder, 'type_id' => 'css', 'name' => $this->_theme->flavor_folder . '.css'
			]);
			*/

		//	return true;
		// }

		/*
		$this->db->insert(':theme_template', [
			'folder' => $this->_theme->folder,
			'type_id' => 'css',
			'name' => $this->_theme->flavor_folder . '.css',
			'html_data' => $parsed,
			'html_data_original' => $content,
			'time_stamp' => PHPFOX_TIME
		]);
		*/
	}

	public function get($returnLess = false) {
		$html = $this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.less';
		if (!file_exists($html)) {
			throw new \Exception('Less file does not exist.');
		}

		$html = file_get_contents($html);

		$parts = explode('/** START CSS */', $html);

		if ($returnLess === true) {
			return $parts[0];
		}

		return (isset($parts[1]) ? $parts[1] : '');
	}

  /**
   * Get content of less files from all modules
   * @param $module_list
   * @return string
   */
  public function getModule($module_list){
    if (is_array($module_list)){
      $less_contain = '';
      foreach ($module_list as $module_name){
        $file_name = PHPFOX_DIR_MODULE . $module_name . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . \Phpfox_Template::instance()->getThemeFolder() . PHPFOX_DS . \Phpfox_Template::instance()->getStyleFolder() . PHPFOX_DS . 'main.less';
        if (file_exists($file_name)){
          $less_contain .= file_get_contents($file_name);
        }
      }
      return $less_contain;
    } else {
      return '';
    }
  }

  /**
   * @param $moduleLists
   * @throws \Exception
   */
  public function reBuildModule($moduleLists, $themeName = 'default'){
    $buildFiles = array();
    if (is_array($moduleLists)){
      foreach ($moduleLists as $moduleName){
        $modulePath = PHPFOX_DIR_MODULE . $moduleName . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . \Phpfox_Template::instance()->getThemeFolder() . PHPFOX_DS . \Phpfox_Template::instance()->getStyleFolder();
        $moduleFiles = $this->scanLessFiles($modulePath);
        $buildFiles = array_merge($buildFiles, $moduleFiles);
      }
    }
    if (count($buildFiles)){
      foreach ($buildFiles as $fileName){
        $this->buildFile($fileName, 'module', $themeName);
      }
    }
  }

  public function buildFile($fileName, $locationBuild = 'module', $themeName = 'default'){
    switch ($locationBuild){
      case 'app':
        $suffixPath = '';//check later
        break;
      case 'static':
        $suffixPath = '';//check later
        break;
      case 'module':
        $suffixPath = PHPFOX_DIR_MODULE;
        break;
      default:
        $suffixPath = PHPFOX_DIR_MODULE;
        break;
    }
    //get less variable and remove import
    $variable = $this->get(true);
    $aVariable = explode(';', $variable);
    foreach ($aVariable as $key=> $var){
      $string = str_replace("\r", "", $var);
      $string = str_replace("\n", "", $string);
      $string = trim(trim($string, '\n'), ' ');
      if (strpos($string, '@import') !== false){
        $variable = str_replace($string . ';', '', $variable);
      }
    }
    $less = new \lessc();
    //build
    $lessContent = $variable . file_get_contents($suffixPath . $fileName);
    if (strtolower($themeName) == 'bootstrap'){
      $less->setImportDir([PHPFOX_DIR . 'theme/frontend/bootstrap/less/']);
    } else {
      $less->setImportDir(PHPFOX_DIR . 'less/');
    }
    $content = str_replace('../../../../PF.Base/less/', '', $lessContent);
    $parsed = $less->compile($content);
    $fileName = trim($fileName, '/');
    $path = $this->_theme->getPath() . 'flavor/' . substr(str_replace([PHPFOX_DS,'/','\\'], ['_','_','_'], $fileName), 0, -4);
    $path = trim($path, '.');
    file_put_contents($path . '.css', $parsed);
  }


  /**
   * Get content of less files from all Apps
   * @return string
   */
  public function getApp(){
    $Apps = new \Core\App();
    $app_less_contain = '';
    foreach ($Apps->all() as $App) {
      $assets = $App->path . 'assets/';
      if (file_exists($assets . 'main.less')) {
        $app_less_contain .= file_get_contents($assets . 'main.less');
      }
    }
    return $app_less_contain;
  }
	public function getParsed() {
		$css = $this->_theme->getPath() . 'flavor/' . $this->_theme->flavor_folder . '.css';
		$css = file_get_contents($css);

		return $css;
	}

	/*
	private function _get($type = 'html_data_original') {
		$html = $this->db->select('*')
			->from(':theme_template')
			->where(['folder' => $this->_theme->folder, 'type_id' => 'css', 'name' => $this->_theme->flavor_folder . '.css'])
			->get();

		if (!isset($html['template_id'])) {
			return false;
		}

		return $html[$type];
	}
	*/

  public function scanLessFiles($path){
    if(!is_dir($path))
      return [];
    $ffs = scandir($path);
    $extension = array('.css', 'less');
    $listFiles = array();
    foreach($ffs as $ff){
      if($ff != '.' && $ff != '..' && $ff != 'main.less'){
        if(is_dir($path. PHPFOX_DS .$ff)) {
          $sub = $this->scanLessFiles($path.'/'.$ff);
          $listFiles = array_merge($listFiles, $sub);
        } else {
          $fileExtension = substr($ff, -4);
          $bGet = true;
          //if have same file name in .css and .less, remove .css file
          if ($fileExtension == '.css'){
            $checkLess = substr($ff, 0, -4) . '.less';
            if (in_array($checkLess, $ffs)){
              $bGet = false;
            }
          }
          if (in_array($fileExtension, $extension) && $bGet){
            $listFiles[] = (str_replace(PHPFOX_DIR_MODULE, '', $path)) . PHPFOX_DS .$ff;
          }
        }
      }
    }
    return $listFiles;
  }
}