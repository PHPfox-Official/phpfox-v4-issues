<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Service
 * @version 		$Id: style.class.php 6882 2013-11-12 17:39:57Z Fern $
 */
class Theme_Service_Style_Style extends Phpfox_Service 
{
	private $_aStyleImages = array();
	
	private $_aStyleImageCache = array();	
	
	private $_aStyleScripts = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('theme_style');
	}
	
	public function getStyleContent($iStyleId)	
	{
		$aRow = $this->database()->select('*')
			->from(Phpfox::getT('theme_css'))
			->where('style_id = ' . (int) $iStyleId . ' AND file_name = \'custom.css\'')
			->execute('getSlaveRow');
		
		$aStyle = $this->database()->select('ts.*, t.folder AS theme_folder')
			->from($this->_sTable, 'ts')
			->join(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id AND t.is_active = 1')
			->where('ts.style_id = ' . (int) $iStyleId)
			->execute('getSlaveRow');		
		
		if (!isset($aRow['css_id']))
		{
			$sCssFile = PHPFOX_DIR . 'theme/frontend/' . $aStyle['theme_folder'] . '/style/' . $aStyle['folder'] . '/css/custom.css';
			if (file_exists($sCssFile))
			{
				$aRow['css_data'] = file_get_contents($sCssFile);
			}
		}
		
		if (empty($aRow['css_data']))
		{
			return '';
		}

		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$aRow['css_data'] = str_replace('../', Phpfox::getParam('core.path') . 'theme/frontend/' . $aStyle['theme_folder'] . '/style/' . $aStyle['folder'] . '/', $aRow['css_data']);
		}

		return $aRow;
	}
	
	public function get($aCond = array())
	{		
		$aRows = $this->database()->select('*')
			->from($this->_sTable)
			->where($aCond)
			->execute('getRows');
		
		$aDefaultTheme = Phpfox::getService('theme')->getTheme('default', true);
		$aDefaultStyle = Phpfox::getService('theme.style')->getStyleParent($aDefaultTheme['theme_id'], 'default');
		
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['is_default_style'] = ((isset($aDefaultStyle['style_id']) && $aDefaultStyle['style_id'] == $aRow['style_id']) ? true : false);	
		}		
			
		return $aRows;
	}
	
	public function getStyles()
	{
		$aRows = $this->database()->select('ts.*, t.folder AS theme_folder')
			->from($this->_sTable, 'ts')
			->join(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id AND t.is_active = 1')
			->where('ts.is_active = 1')
			->execute('getSlaveRows');
		
        if ($sPlugin = Phpfox_Plugin::get('theme.service_style_getstyles__1')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
        
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['block_total'] = range(1, 10);
			
			if (file_exists(PHPFOX_DIR . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . $aRow['theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aRow['folder'] . PHPFOX_DS . 'sample.png'))
			{
				$aRows[$iKey]['sample_image'] = Phpfox::getParam('core.path') . 'theme/frontend/' . $aRow['theme_folder'] . '/style/' . $aRow['folder'] . '/sample.png';
			}
			else
			{
				$aRows[$iKey]['sample_image'] = Phpfox::getParam('core.path') . 'theme/frontend/' . $aRow['theme_folder'] . '/style/' . $aRow['folder'] . '/phpfox.gif';
			}
		}
			
		return $aRows;
	}
	
	public function getStyleParent($iThemeId, $sStyleFolder)
	{
		return $this->database()->select('ts.*')
			->from(Phpfox::getT('theme_style'), 'ts')
			->where('ts.theme_id = ' . (int) $iThemeId . ' AND folder = \'' . $this->database()->escape($sStyleFolder) . '\'')
			->execute('getRow');
	}
	
	public function getStyle($iId, $bFolder = false)
	{
		if ($bFolder === true)
		{
			return Phpfox_Error::trigger('You cannot get a style based on the folder name. This method is depreciated.', E_USER_ERROR);
		}
		
		$aStyle = $this->database()->select('ts.*, t.name AS theme_name, t.folder AS theme_folder, ts.parent_id AS parent_style_id, pts.folder AS parent_style_folder, pt.folder AS parent_theme_folder')
			->from(Phpfox::getT('theme_style'), 'ts')
			->join(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id')
			->leftJoin(Phpfox::getT('theme_style'), 'pts', 'pts.style_id = ts.parent_id')	
			->leftJoin(Phpfox::getT('theme'), 'pt', 'pt.theme_id = t.parent_id')	
			->where(($bFolder ? 'ts.folder = \'' . $this->database()->escape($iId) . '\'' : 'ts.style_id = ' . (int) $iId))
			->execute('getRow');
			
		return $aStyle;
	}
	
	public function getForEdit($iId)
	{
		return $this->getStyle($iId);
	}
	
	public function getCurrentLogo($iId)
	{	
		$aStyle = $this->database()->select('ts.style_id, ts.folder, ts.logo_image, t.folder AS theme_folder, tsl.logo_id, tsl.file_ext, ts.parent_id AS parent_style_id, pts.folder AS parent_style_folder, pts.logo_image AS parent_logo_image, pt.folder AS parent_theme_folder')
			->from($this->_sTable, 'ts')
			->join(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id')
			->leftJoin(Phpfox::getT('theme_style_logo'), 'tsl', 'tsl.style_id = ts.style_id')
			->leftJoin(Phpfox::getT('theme_style'), 'pts', 'pts.style_id = ts.parent_id')
			->leftJoin(Phpfox::getT('theme'), 'pt', 'pt.theme_id = t.parent_id')	
			->where('ts.style_id = ' . (int) $iId)
			->execute('getRow');		
		
		if (!isset($aStyle['style_id']))
		{
			return false;
		}
		
		if (empty($aStyle['logo_image']) && !empty($aStyle['parent_logo_image']))
		{
			$aStyle['logo_image'] = $aStyle['parent_logo_image'];			
		}

		$bIsCustomLogo = false;
		$bPass = false;
		if (file_exists(PHPFOX_DIR . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . '' . $aStyle['theme_folder'] . '' . PHPFOX_DS . 'style' . PHPFOX_DS . '' . $aStyle['folder'] . '' . PHPFOX_DS . 'image/layout' . PHPFOX_DS . $aStyle['logo_image']))
		{
			$iActualImage = PHPFOX_DIR . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . '' . $aStyle['theme_folder'] . '' . PHPFOX_DS . 'style' . PHPFOX_DS . '' . $aStyle['folder'] . '' . PHPFOX_DS . 'image/layout' . PHPFOX_DS . $aStyle['logo_image'];
			$bPass = true;
		}
		
		if ($bPass === false && !empty($aStyle['parent_style_folder']) && file_exists(PHPFOX_DIR . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . '' . $aStyle['theme_folder'] . '' . PHPFOX_DS . 'style' . PHPFOX_DS . '' . $aStyle['parent_style_folder'] . '' . PHPFOX_DS . 'image/layout' . PHPFOX_DS . $aStyle['logo_image']))
		{
			$iActualImage = PHPFOX_DIR . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . '' . $aStyle['theme_folder'] . '' . PHPFOX_DS . 'style' . PHPFOX_DS . '' . $aStyle['parent_style_folder'] . '' . PHPFOX_DS . 'image/layout' . PHPFOX_DS . $aStyle['logo_image'];
			$bPass = true;			
		}
		
		if ($bPass === false && !empty($aStyle['parent_theme_folder']) && file_exists(PHPFOX_DIR . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . '' . $aStyle['parent_theme_folder'] . '' . PHPFOX_DS . 'style' . PHPFOX_DS . '' . $aStyle['parent_style_folder'] . '' . PHPFOX_DS . 'image/layout' . PHPFOX_DS . $aStyle['logo_image']))
		{
			$iActualImage = PHPFOX_DIR . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . '' . $aStyle['parent_theme_folder'] . '' . PHPFOX_DS . 'style' . PHPFOX_DS . '' . $aStyle['parent_style_folder'] . '' . PHPFOX_DS . 'image/layout' . PHPFOX_DS . $aStyle['logo_image'];
			$bPass = true;			
		}		
		
		if (file_exists(PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . md5($aStyle['theme_folder'] . $aStyle['folder']) . '_thumb.' . $aStyle['file_ext']))
		{			
			$bIsCustomLogo = true;
			$iActualImage = PHPFOX_DIR_FILE . 'static' . PHPFOX_DS . md5($aStyle['theme_folder'] . $aStyle['folder']) . '_thumb.' . $aStyle['file_ext'];
			$bPass = true;
		}		

		if ($bPass === false)
		{
			return false;
		}
		
		list($iWidth, $iHeight) = getimagesize($iActualImage);		
		
		return array(str_replace('\\', '/', str_replace(PHPFOX_DIR, Phpfox::getParam('core.path'), $iActualImage)), $bIsCustomLogo, $iWidth, $iHeight);
	}
	
	public function getStyleDisplayLogo($sThemeFolder, $sFolder, $iStyleId, $bIncludeParent = true)
	{
		$bPass = false;
		$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'phpfox.gif';
		if (file_exists($sDir))
		{
			$bPass = true;	
		}
		
		if ($bIncludeParent === true && $bPass === false)
		{
			$aStyle = $this->getStyle($iStyleId);	
		
			if ($bIncludeParent === true && $aStyle['parent_style_id'] > 0)
			{
				if (file_exists(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'phpfox.gif'))
				{
					$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'phpfox.gif';	
					$bPass = true;			
				}
				
				if ($bPass == false && file_exists(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['parent_theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'phpfox.gif'))
				{
					$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['parent_theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'phpfox.gif';
					$bPass = true;
				}
			}
		}
		
		if (!file_exists($sDir))
		{
			$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . 'default' . PHPFOX_DS . 'style' . PHPFOX_DS . 'default' . PHPFOX_DS . 'phpfox.gif';
		}
		
		return $sDir;
	}
	
	public function getScript($sThemeFolder, $sFolder, $iStyleId, $bIncludeParent = true)
	{
		$this->_getScript($sThemeFolder, $sFolder);	
		
		$aStyle = $this->getStyle($iStyleId);	
		
		if ($bIncludeParent === true && $aStyle['parent_style_id'] > 0)
		{
			if (is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'jscript'))
			{
				$this->_getScript($sThemeFolder, $aStyle['parent_style_folder']);	
			}
			else 
			{
				$this->_getScript($aStyle['parent_theme_folder'], $aStyle['parent_style_folder']);	
			}							
		}		

		return $this->_aStyleScripts;
	}	
	
	public function getImages($sThemeFolder, $sFolder, $iStyleId, $bIncludeParent = true)
	{
		$this->_getImages($sThemeFolder, $sFolder);	
		
		$aStyle = $this->getStyle($iStyleId);	
		
		if ($bIncludeParent === true && $aStyle['parent_style_id'] > 0)
		{
			if (is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'image'))
			{
				$this->_getImages($sThemeFolder, $aStyle['parent_style_folder']);	
			}
			else 
			{
				$this->_getImages($aStyle['parent_theme_folder'], $aStyle['parent_style_folder']);	
			}							
		}		

		return $this->_aStyleImages;	
	}

	public function getFiles($sThemeFolder, $sFolder, $iStyleId, $bNoArray = false, $bIncludeParent = true)
	{
		$aCached = array();
		$aFiles = array();		
		$aRows = $this->database()->select('module_id, file_name, time_stamp_update')
			->from(Phpfox::getT('theme_css'))
			->where('is_custom = 0 AND style_id = ' . (int) $iStyleId . '')
			->execute('getRows');	
			
		foreach ($aRows as $aRow)
		{
			$aCached[($aRow['module_id'] ? $aRow['module_id'] : null)][$aRow['file_name']] = true;
			
			$aFiles[($aRow['module_id'] ? $aRow['module_id'] : null)][$aRow['file_name']] = (($bNoArray === false  && $aRow['time_stamp_update']) ? array($aRow['file_name']) : $aRow['file_name']);
		}				
		
		if (is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'css'))
		{
			$hDir = opendir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'css');
			while ($sFile = readdir($hDir))
			{
				if (substr($sFile, -4) != '.css')
				{
					continue;
				}
				
				$aFiles[null][$sFile] = (($bNoArray === false && isset($aCached[null][$sFile])) ? array($sFile) : $sFile);				
			}
		}
		
		$aStyle = $this->getStyle($iStyleId);		
		if ($bIncludeParent === true && $aStyle['parent_style_id'] > 0)
		{
			$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'css';			
			if (!is_dir($sDir))
			{
				$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['parent_theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'css';				
			}			
				
			if (is_dir($sDir))
			{		
				$hDir = opendir($sDir);
				while ($sFile = readdir($hDir))
				{
					if (substr($sFile, -4) != '.css')
					{
						continue;
					}
						
					if (isset($aFiles[null][$sFile]))
					{
						continue;
					}
						
					$aFiles[null][$sFile] = (($bNoArray === false && isset($aCached[null][$sFile])) ? array($sFile) : $sFile);
				}				
			}
		}
		
		if ($bNoArray === false && is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . 'default' . PHPFOX_DS . 'style' . PHPFOX_DS . 'default' . PHPFOX_DS . 'css'))
		{
			$hDir = opendir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . 'default' . PHPFOX_DS . 'style' . PHPFOX_DS . 'default' . PHPFOX_DS . 'css');
			while ($sFile = readdir($hDir))
			{
				if (substr($sFile, -4) != '.css')
				{
					continue;
				}
				
				$aFiles[null][$sFile] = (($bNoArray === false && isset($aCached[null][$sFile])) ? array($sFile) : $sFile);				
			}
		}		
		
		$hDir = opendir(PHPFOX_DIR_MODULE);
		while ($sDir = readdir($hDir))
		{
			if ($sDir == '.' || $sDir == '..')
			{
				continue;
			}
			
			if ($sDir == 'admincp')
			{
				continue;
			}
			
			if (!Phpfox::isModule($sDir))
			{
				continue;
			}			
			
			$sCssDir = PHPFOX_DIR_MODULE . $sDir . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . $sFolder . PHPFOX_DS;			
			if (is_dir($sCssDir))
			{				
				$hCssDir = opendir($sCssDir);
				while ($sFile = readdir($hCssDir))
				{
					if (substr($sFile, -4) != '.css')
					{
						continue;
					}
					
					$aFiles[$sDir][$sFile] = (($bNoArray === false && isset($aCached[$sDir][$sFile])) ? array($sFile) : $sFile);
				}
				closedir($hCssDir);
			}
			
			if ($bIncludeParent === true && $aStyle['parent_style_id'] > 0)
			{				
				$sCssDir = PHPFOX_DIR_MODULE . $sDir . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS;					
				if (!is_dir($sCssDir))
				{
					$sCssDir = PHPFOX_DIR_MODULE . $sDir . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $aStyle['parent_theme_folder'] . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS;						
				}			
				
				if (is_dir($sCssDir))
				{					
					$hCssDir = opendir($sCssDir);
					while ($sFile = readdir($hCssDir))
					{
						if (substr($sFile, -4) != '.css')
						{
							continue;
						}
						
						if (isset($aFiles[$sDir][$sFile]))
						{
							continue;
						}
						
						$aFiles[$sDir][$sFile] = (($bNoArray === false && isset($aCached[$sDir][$sFile])) ? array($sFile) : $sFile);
					}
					closedir($hCssDir);				
				}
			}
			
			$sCssDir = PHPFOX_DIR_MODULE . $sDir . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . 'default' . PHPFOX_DS . 'default' . PHPFOX_DS;
			if ($bNoArray === false && is_dir($sCssDir))
			{				
				$hCssDir = opendir($sCssDir);
				while ($sFile = readdir($hCssDir))
				{
					if (substr($sFile, -4) != '.css')
					{
						continue;
					}
					
					$aFiles[$sDir][$sFile] = (($bNoArray === false && isset($aCached[$sDir][$sFile])) ? array($sFile) : $sFile);
				}
				closedir($hCssDir);
			}			
		}	
		closedir($hDir);	
		
		$aStyles = $this->database()->select('file_name, module_id, time_stamp_update')
			->from(Phpfox::getT('theme_css'))
			->where('is_custom = 1 AND style_id = ' . $aStyle['style_id'])
			->execute('getSlaveRows');
		foreach ($aStyles as $aRow)
		{
			if (isset($aFiles[$aRow['file_name']]))
			{
				continue;
			}
			
			$aFiles[($aRow['module_id'] ? $aRow['module_id'] : null)][$aRow['file_name']] = (($bNoArray === false  && $aRow['time_stamp_update']) ? array($aRow['file_name']) : $aRow['file_name']);
		}		
		
		ksort($aFiles);
		
		return $aFiles;
	}	
	
	public function getFile($iStyleId, $sFileName, $sModule, $bIncludeParent = true)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
		
		$aStyle = $this->getStyle($iStyleId);
		
		if (!isset($aStyle['style_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.unable_to_find_style_sheet'));
		}
		
		$aCss = $this->database()->select('css_id, is_custom, product_id, full_name, css_data, time_stamp, time_stamp_update')
			->from(Phpfox::getT('theme_css'))
			->where('module_id = \'' . (empty($sModule) ? '' : $this->database()->escape($sModule)) . '\' AND style_id = ' . $aStyle['style_id'] . ' AND file_name = \'' . $this->database()->escape($sFileName) . '\'')
			->execute('getRow');
			
		if (isset($aCss['css_id']))
		{
			$sContent = $aCss['css_data'];
			$mModified = array(
				'full_name' => $aCss['full_name'],
				'time_stamp' => $aCss['time_stamp']
			);	
			
			if ($aCss['is_custom'] && !$aCss['time_stamp_update'])
			{
				$mModified = false;
			}
		}
		else 
		{		
			if (empty($sModule))
			{
				$sFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS . 'css' . PHPFOX_DS . $sFileName;
				
				if ($bIncludeParent === true && $aStyle['parent_style_id'] > 0)
				{
					if (!file_exists($sFile))
					{
						$sFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'css' . PHPFOX_DS . $sFileName;
					}				
					
					if (!file_exists($sFile))
					{
						$sFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['parent_theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . 'css' . PHPFOX_DS . $sFileName;					
					}
				}
				
				if (!file_exists($sFile))
				{
					$sFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . 'default' . PHPFOX_DS . 'style' . PHPFOX_DS . 'default' . PHPFOX_DS . 'css' . PHPFOX_DS . $sFileName;
				}
			}
			else
			{
				$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS . $sFileName;

				if ($bIncludeParent === true && $aStyle['parent_style_id'] > 0)
				{
					if (!file_exists($sFile))
					{
						$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . $sFileName;	
					}				
					
					if (!file_exists($sFile))
					{
						$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $aStyle['parent_theme_folder'] . PHPFOX_DS . $aStyle['parent_style_folder'] . PHPFOX_DS . $sFileName;					
					}
				}												
				
				if (!file_exists($sFile))
				{
					$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . 'default' . PHPFOX_DS . 'default' . PHPFOX_DS . $sFileName;
				}
			}
			
			if (!file_exists($sFile))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('theme.unable_to_find_the_style_sheet_file'));
			}
			
			$sContent = file_get_contents($sFile);
			$mModified = false;
		}
		
		return array(
			'id' => $iStyleId . '_' . str_replace('.', '_', $sFileName) . '_' . $sModule,
			'title' => $sFileName,
			'content' => str_replace("\r\n", "\n", $sContent),
			'modified' => $mModified,
			'product_id' => (isset($aCss['product_id']) ? $aCss['product_id'] : 'phpfox'),
			'is_custom' => (isset($aCss['is_custom']) ? $aCss['is_custom'] : 0)
		);
	}
	
	public function export($iStyleId, $bIncludeParent = false, $bMultiple = false, $sNewHomeFolder = null, $sDirectoryId = null)
	{	
		if ($bMultiple === false)
		{
			define('PHPFOX_XML_SKIP_STAMP', true);					
		}		
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
			
		$aStyle = Phpfox::getService('theme.style')->getStyle($iStyleId);
		if (isset($aStyle['style_id']))
		{	
			$sCacheHash = md5(serialize($aStyle) . PHPFOX_TIME);
			
			if ($sDirectoryId === null)
			{	
				$sDirectoryIdReturn = 'theme_' . $aStyle['style_id'] . '_' . uniqid();
				if (is_dir(PHPFOX_DIR_CACHE . $sDirectoryIdReturn))
				{
					Phpfox::getLib('file')->delete_directory(PHPFOX_DIR_CACHE . $sDirectoryIdReturn . PHPFOX_DS);
				}
				
				$sDirectoryId = $sDirectoryIdReturn . PHPFOX_DS . 'upload' . PHPFOX_DS;
		
				Phpfox::getLib('file')->mkdir(PHPFOX_DIR_CACHE . $sDirectoryId, true);				
				
				$sNewHomeFolder = PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS;
			}						
						
			$sThemePath = $sNewHomeFolder . 'style' . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS;

			Phpfox::getLib('file')->mkdir($sThemePath, true);
			Phpfox::getLib('file')->mkdir($sThemePath . 'css' . PHPFOX_DS, true);
			Phpfox::getLib('file')->mkdir($sThemePath . 'image' . PHPFOX_DS, true);
			Phpfox::getLib('file')->mkdir($sThemePath . 'jscript' . PHPFOX_DS, true);
			Phpfox::getLib('file')->mkdir($sThemePath . 'php' . PHPFOX_DS, true);
			
			$oXmlBuilder->addGroup('style', array(
					'name' => $aStyle['name'],
					'folder' => $aStyle['folder'],
					'parent_style' => $aStyle['parent_theme_folder'] . '::' . $aStyle['parent_style_folder'],
					'parent_theme' => $aStyle['theme_folder'],
					'created' => $aStyle['created'],							
					'logo_image' => $aStyle['logo_image']
				)
			);
					
			// Display Logo
			$oXmlBuilder->addTag('creator', $aStyle['creator']);
			$oXmlBuilder->addTag('website', $aStyle['website']);
			$oXmlBuilder->addTag('version', $aStyle['version']);
			
			$oXmlBuilder->closeGroup();
			
			Phpfox::getLib('file')->write($sThemePath . 'phpfox.xml', $oXmlBuilder->output());			
			
			$sLogoPath = Phpfox::getService('theme.style')->getStyleDisplayLogo($aStyle['theme_folder'], $aStyle['folder'], $aStyle['style_id'], $bIncludeParent);
			if (file_exists($sLogoPath) && is_readable($sLogoPath))
			{
				Phpfox::getLib('file')->write($sThemePath . 'phpfox.gif', file_get_contents($sLogoPath));			
			}
					
			// Css
			$aFiles = Phpfox::getService('theme.style')->getFiles($aStyle['theme_folder'], $aStyle['folder'], $aStyle['style_id'], true, $bIncludeParent);			
			foreach ($aFiles as $sModule => $aCssFiles)
			{
				foreach ($aCssFiles as $sFile)
				{
					$aCss = Phpfox::getService('theme.style')->getFile($aStyle['style_id'], $sFile, $sModule, $bIncludeParent);					
					if (empty($sModule))
					{
						Phpfox::getLib('file')->write($sThemePath . 'css' . PHPFOX_DS . $sFile, $aCss['content']);
					}
					else 
					{
						Phpfox::getLib('file')->mkdir(PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . 'module' . PHPFOX_DS . $sModule . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS, true);
						Phpfox::getLib('file')->write(PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . 'module' . PHPFOX_DS . $sModule . PHPFOX_DS . 'static' . PHPFOX_DS . 'css' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS . $sFile, $aCss['content']);
					}
				}
			}			
								
			// Images
			$aImages = Phpfox::getService('theme.style')->getImages($aStyle['theme_folder'], $aStyle['folder'], $aStyle['style_id'], $bIncludeParent);			
			foreach ($aImages as $sImagePath => $mImages)
			{						
				if (is_numeric($sImagePath))
				{
					$mImages = array($mImages);
				}
						
				foreach ($mImages as $aNewImage)
				{							
					$sNewFileName = str_replace(PHPFOX_DIR, '', $aNewImage['file']);
					$aParts = explode(PHPFOX_DS, $sNewFileName);
					unset($aParts[(count($aParts) - 1)]);
					$sDirPath = implode(PHPFOX_DS, $aParts);
					
					Phpfox::getLib('file')->mkdir(PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . $sDirPath . PHPFOX_DS, true);
					Phpfox::getLib('file')->write(PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . $sDirPath . PHPFOX_DS . $aNewImage['name'], file_get_contents($aNewImage['file']));							}
			}			
					
			// JavaScript
			$aScripts = Phpfox::getService('theme.style')->getScript($aStyle['theme_folder'], $aStyle['folder'], $aStyle['style_id'], $bIncludeParent);
			foreach ($aScripts as $aScript)
			{						
				$sNewFileName = str_replace(PHPFOX_DIR, '', $aScript['file']);
				$aParts = explode(PHPFOX_DS, $sNewFileName);
				unset($aParts[(count($aParts) - 1)]);
				$sDirPath = implode(PHPFOX_DS, $aParts);
				
				Phpfox::getLib('file')->mkdir(PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . $sDirPath . PHPFOX_DS, true);
				Phpfox::getLib('file')->write(PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . $sDirPath . PHPFOX_DS . $aScript['name'], file_get_contents($aScript['file']));					
			}			

            $sPhpHeaderFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS . 'php' . PHPFOX_DS . 'header.php';
            if (file_exists($sPhpHeaderFile))
            {
                Phpfox::getLib('file')->write($sThemePath . 'php' . PHPFOX_DS . 'header.php', file_get_contents($sPhpHeaderFile));
            }
            
            $sSamplePngFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aStyle['theme_folder'] . PHPFOX_DS . 'style' . PHPFOX_DS . $aStyle['folder'] . PHPFOX_DS . 'sample.png';
            if (file_exists($sSamplePngFile))
            {
            	Phpfox::getLib('file')->write($sThemePath . 'sample.png', file_get_contents($sSamplePngFile));
            }            
					
			if ($bMultiple === false)
			{
				Phpfox::getLib('file')->writeToCache('theme_styles_' . $sCacheHash . '.xml', $oXmlBuilder->output());					

				return array(
					'name' => $aStyle['theme_folder'] . '-' . $aStyle['folder'] . (empty($aStyle['version']) ? '' : '-' . $aStyle['version']),
					'folder' => $sDirectoryIdReturn
				);
			}
		}
		
		if ($bMultiple === false)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.not_a_valid_style'));
		}
	}
	
	public function getNewStyles()
	{
		$aCacheThemes = array();
		$aRows = $this->database()->select('theme_id, folder')
			->from(Phpfox::getT('theme'))
			->execute('getRows');
		foreach ($aRows as $aRow)
		{
			$aCacheThemes[$aRow['folder']] = $aRow['theme_id'];
		}
		
		$aStyles = array();
		$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS;
		$hDir = opendir($sDir);
		while ($sFolder = readdir($hDir))
		{
			if ($sFolder == '.' || $sFolder == '..' || $sFolder == '.svn')
			{
				continue;
			}
			
			if (!is_dir($sDir . $sFolder . PHPFOX_DS . 'style'))
			{
				continue;
			}
			
			$hStyleDir = opendir($sDir . $sFolder . PHPFOX_DS . 'style');
			while ($sStyleFolder = readdir($hStyleDir))
			{
				if ($sStyleFolder == '.' || $sStyleFolder == '..' || $sStyleFolder == '.svn')
				{
					continue;
				}				
				
				if (!file_exists($sDir . $sFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $sStyleFolder . PHPFOX_DS . 'phpfox.xml'))
				{
					continue;
				}
				
				if (!isset($aCacheThemes[$sFolder]))
				{
					continue;
				}
				
				$iInstalled = (int) $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('theme_style'))
					->where('theme_id = ' . $aCacheThemes[$sFolder] . ' AND folder = \'' . $this->database()->escape($sStyleFolder) . '\'')
					->execute('getField');				
				if (!$iInstalled)
				{
					$aStyles[] = Phpfox::getLib('xml.parser')->parse(file_get_contents($sDir . $sFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $sStyleFolder . PHPFOX_DS . 'phpfox.xml'));
				}
			}
			closedir($hStyleDir);
		}
		closedir($hDir);
		
		return $aStyles;
	}	

	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('theme.service_style_style__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function _getScript($sThemeFolder, $sFolder)
	{
		$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'jscript' . PHPFOX_DS;
		if (is_dir($sDir))
		{
			$hDir = opendir($sDir);
			while ($sFile = readdir($hDir))
			{
				if (substr($sFile, -3) != '.js')
				{
					continue;
				}
				
				$this->_aStyleScripts[] = array(
					'name' => $sFile,
					'file' => $sDir . $sFile
				);
			}
		}
	}	
	
	private function _getImages($sThemeFolder, $sFolder)
	{
		$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'image' . PHPFOX_DS;
		if (is_dir($sDir))
		{
			$hDir = opendir($sDir);
			while ($sFile = readdir($hDir))
			{
				if ($sFile == '.' || $sFile == '..')
				{
					continue;
				}
				
				if (is_dir($sDir . $sFile))
				{
					$hSubDir = opendir($sDir . $sFile);	
					while ($sSubFile = readdir($hSubDir))
					{
						if (!preg_match('/(.*)\.(gif|png|jpg|jpeg|html)/i', $sSubFile))
						{
							continue;
						}
						
						if (file_exists($sDir . $sFile . PHPFOX_DS . $sSubFile))
						{							
							if (isset($this->_aStyleImageCache[$sFile][$sSubFile]))
							{
								continue;
							}
							
							$this->_aStyleImages[$sFile][] = array(
								'name' => $sSubFile,
								'file' => $sDir . $sFile . PHPFOX_DS . $sSubFile
							);
							$this->_aStyleImageCache[$sFile][$sSubFile] = true;
						}						
					}
					closedir($hSubDir);
				}
				else 
				{
					if (!preg_match('/(.*)\.(gif|png|jpg|jpeg|html)/i', $sFile))
					{
						continue;
					}
					
					if (file_exists($sDir . $sFile))
					{
						if (isset($this->_aStyleImageCache[$sFile]))
						{
							continue;
						}
						
						$this->_aStyleImages[] = array(
							'name' => $sFile,
							'file' => $sDir . $sFile
						);
						$this->_aStyleImageCache[$sFile] = true;
					}					
				}
			}
			closedir($hDir);
			
			foreach(Phpfox::getLib('module')->getModules() as $sModule)
			{
				$sDir = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . "static" . PHPFOX_DS . "image" . PHPFOX_DS . $sThemeFolder . PHPFOX_DS . $sFolder . PHPFOX_DS;

				$this->_getSubDirImages($sDir, $sModule);				
			}
		}		
	}

	private function _getSubDirImages($sDir, $sModule)
	{
		if (is_dir($sDir))
		{
			$hDir = opendir($sDir);
			while ($sFile = readdir($hDir))
			{
				if ($sFile == '.' || $sFile == '..')
				{
					continue;
				}
		
				if (is_dir($sDir . $sFile))
				{
					d($sDir);die();
					$this->_getSubDirImages($sDir);
				}
				else 
				{
					if (!preg_match('/(.*)\.(gif|png|jpg|jpeg|html)/i', $sFile))
					{
						continue;
					}
			
					if (file_exists($sDir . $sFile))
					{
						if (isset($this->_aStyleImageCache[$sModule . "." . $sFile]))
						{
							continue;
						}

						$this->_aStyleImages[] = array(
							'name' => $sFile,
							'file' => $sDir . $sFile
						);
						$this->_aStyleImageCache[$sModule . "." . $sFile] = true;
					}					
				}
			}
			closedir($hDir);
		}
	}
}

?>
