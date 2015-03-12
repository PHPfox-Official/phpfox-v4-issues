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
 * @package  		Module_Theme
 * @version 		$Id: theme.class.php 4887 2012-10-11 11:38:15Z Raymond_Benc $
 */
class Theme_Service_Theme extends Phpfox_Service 
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('theme');
	}
	
	public function isTheme($sTheme)
	{
		$iInstalled = (int) $this->database()->select('COUNT(*)')
		->from(Phpfox::getT('theme'))
		->where('folder = \'' . $this->database()->escape($sTheme) . '\'')
		->execute('getField');
			
		return ($iInstalled ? true : false);
	}	
	
	public function get($aCond = array())
	{		
		$aThemes = $this->database()->select('t.*, COUNT(ts.theme_id) AS total_style')
			->from($this->_sTable, 't')
			->leftJoin(Phpfox::getT('theme_style'), 'ts', 'ts.theme_id = t.theme_id')
			->where($aCond)
			->group('t.theme_id')
			->execute('getRows');		
			
		return $aThemes;
	}
	
	public function getForEdit($iId)
	{
		return $this->getTheme($iId);
	}
	
	public function getTheme($iId, $bUseFolder = false)
	{
		return $this->database()->select('*')
			->from($this->_sTable)
			->where(($bUseFolder ? 'folder = \'' . $this->database()->escape($iId) . '\'' : "theme_id = " . (int) $iId))
			->execute('getRow');
	}	
	
	public function &getDesignValues(&$aAdvanced, $aParams)
	{
		$aCss = $this->database()->select('*')
			->from(Phpfox::getT($aParams['table']))
			->where($aParams['field'] . ' = ' . $aParams['value'])
			->execute('getRows');		
		
		$aCache = array();
		foreach ($aCss as $aBuild)
		{			
			if ($aBuild['css_property'] == 'width')
			{
				$aCache[$aBuild['css_selector']]['width'] = $aBuild['css_value'];				
				
				continue;
			}
			
			if ($aBuild['css_property'] == 'color')
			{
				$aBuild['css_property'] = 'font-color';
			}			
			
			$aParts = explode('-', $aBuild['css_property']);	
			
			if (count($aParts) < 2)
			{
				continue;
			}			

			if ($aParts[0] == 'background' && $aParts[1] == 'image')
			{
				$aBuild['css_value'] = preg_replace('/url\(\'(.*?)\'\)/i', '\\1', $aBuild['css_value']);
			}
			
			if (empty($aBuild['css_value']))
			{
				continue;
			}
			
			if ($aParts[0] == 'border')
			{
				$aCache[$aBuild['css_selector']][$aParts[0]][$aParts[1]][$aParts[2]] = $aBuild['css_value'];
			}			
			else 
			{		
				$aCache[$aBuild['css_selector']][$aParts[0]][$aParts[1]] = $aBuild['css_value'];
			}
		}		
		
		// d($aCache);
        
		foreach ($aAdvanced as $iKey => $aSub)
		{
			if (isset($aCache[$aSub['name']]))
			{
				$aAdvanced[$iKey]['value'] = $aCache[$aSub['name']];
			}			
			
			if (isset($aSub['design']['link']))
			{
				foreach ($aSub['design']['link'] as $sAnchor)
				{
					if (isset($aCache[$sAnchor]))
					{
						foreach ($aCache[$sAnchor] as $sAnchorKey => $aAnchorValue)
						{
							$aAdvanced[$iKey]['value']['link'][$sAnchorKey] = $aAnchorValue;
						}
					}
				}
			}	
		}			
		
		// d($aAdvanced);
						
		return $aAdvanced;	
	}
	
	public function getCss($aParams)
	{
		$sCacheFile = $aParams['hash'] . '.css';
		
		if (Phpfox::getParam(array('balancer', 'enabled')))
		{
			$sCacheFile = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID') . '_' . $sCacheFile;
		}
		
		$sCssFile = '<link id="js_user_profile_css" rel="stylesheet" type="text/css" href="' . Phpfox::getParam('css.url_cache') . $sCacheFile . '" />';

		if (file_exists(Phpfox::getParam('css.dir_cache') . $sCacheFile))
		{
			return $sCssFile;
		}

		$aCss = $this->database()->select('*')
			->from(Phpfox::getT($aParams['table']))
			->where($aParams['field'] . ' = ' . $aParams['value'])
			->order('ordering DESC')
			->execute('getRows');
			
		$aCache = array();		
		foreach ($aCss as $aCode)
		{
			$aCache[$aCode['css_selector']][] = $aCode;
		}
		unset($aCss);	
		
		$sCss = '';
		foreach ($aCache as $sSelector => $aCss)
		{
			$sCss .= $sSelector . '{';			
			foreach ($aCss as $aCode)
			{
				if (empty($aCode['css_value']))
				{
					continue;
				}	
				
				$sProperty = $aCode['css_property'];
				if ($sProperty == 'color')
				{
					$sProperty = 'font-color';
				}
				
				if (Phpfox::getLib('parse.css')->process($sProperty, $aCode['css_value']))
				{					
					$sCss .= $aCode['css_property'] . ':' . $aCode['css_value'] . ';';	
				}
			}
			$sCss .= '}';
		}		
		
		$sUserCss = $this->database()->select('css_code')
			->from(Phpfox::getT($aParams['table_code']))
			->where($aParams['field'] . ' = ' . $aParams['value'])
			->execute('getSlaveField');
			
		if (!empty($sUserCss))
		{
			$sCss .= Phpfox::getLib('parse.css')->cleanCss($sUserCss);
		}
		
		$hFile = fopen(Phpfox::getParam('css.dir_cache') . $sCacheFile, 'w+');
		fwrite($hFile, $sCss);
		fclose($hFile);		
		
		return $sCssFile;
	}	
	
	public function getCssCode($aParams)
	{	
		return $this->database()->select('css_code')
			->from(Phpfox::getT($aParams['table_code']))
			->where($aParams['field'] . ' = ' . $aParams['value'])
			->execute('getSlaveField');		
	}
	
	public function export($aVals)
	{
		$aXmlFiles = array();
		
		define('PHPFOX_XML_SKIP_STAMP', true);
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');			
		
		$sCacheHash = md5(serialize($aVals) . PHPFOX_TIME);
		
		$aTheme = $this->getTheme($aVals['theme_id']);		
		$bIncludeParent = false;
		$oXmlBuilder->addGroup('theme');
		$oXmlBuilder->addTag('name', $aTheme['name']);
		$oXmlBuilder->addTag('folder', $aTheme['folder']);
		$oXmlBuilder->addTag('created', $aTheme['created']);
		$oXmlBuilder->addTag('creator', $aTheme['creator']);
		$oXmlBuilder->addTag('website', $aTheme['website']);
		$oXmlBuilder->addTag('version', $aTheme['version']);
		$oXmlBuilder->addTag('total_column', $aTheme['total_column']);
		$aParent = $this->getTheme($aTheme['parent_id']);		
		if (isset($aParent['theme_id']))
		{
			$oXmlBuilder->addTag('parent', $aParent['folder']);	
		}		
		
		$oXmlBuilder->closeGroup();
		
		$sDirectoryIdReturn = 'theme_' . $aVals['theme_id'] . '_' . uniqid();
			
		if (is_dir(PHPFOX_DIR_CACHE . $sDirectoryIdReturn))
		{
			Phpfox::getLib('file')->delete_directory(PHPFOX_DIR_CACHE . $sDirectoryIdReturn . PHPFOX_DS);
		}
		
		$sDirectoryId = $sDirectoryIdReturn . PHPFOX_DS . 'upload' . PHPFOX_DS;
		
		Phpfox::getLib('file')->mkdir(PHPFOX_DIR_CACHE . $sDirectoryId, true);
		
		$bPass = false;
		$sXmlDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . 'xml' . PHPFOX_DS . 'phpfox.xml.php';
		
		if (file_exists($sXmlDir))
		{
			$bPass = true;
		}
		
		if ($bPass === false && $bIncludeParent)
		{
			if (isset($aParent['theme_id']))
			{				
				if (file_exists(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aParent['folder'] . PHPFOX_DS . 'xml' . PHPFOX_DS . 'phpfox.xml.php'))
				{
					$sXmlDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aParent['folder'] . PHPFOX_DS . 'xml' . PHPFOX_DS . 'phpfox.xml.php';
					$bPass = true;
				}
			}
		}
		
		$sNewHomeFolder = PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS;
		
		Phpfox::getLib('file')->mkdir($sNewHomeFolder, true);
		Phpfox::getLib('file')->mkdir($sNewHomeFolder . 'style' . PHPFOX_DS, true);
		Phpfox::getLib('file')->mkdir($sNewHomeFolder . 'template' . PHPFOX_DS, true);
		Phpfox::getLib('file')->mkdir($sNewHomeFolder . 'xml' . PHPFOX_DS, true);	
		
		if ($bPass)
		{
			copy($sXmlDir, PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . 'xml' . PHPFOX_DS . 'phpfox.xml.php');
		}		
		
		Phpfox::getLib('file')->write($sNewHomeFolder . 'phpfox.xml', $oXmlBuilder->output());		
		
		$aTemplates = Phpfox::getService('theme.template')->get($aTheme['folder'], true, $bIncludeParent);	
		foreach ($aTemplates as $sKey => $aFiles)
		{
			unset($aFiles['modified']);
			
			foreach ($aFiles as $sSubKey => $aSubFiles)
			{
				foreach ($aSubFiles as $sFile)
				{
					$sContent = Phpfox::getService('theme.template')->getTemplate($aTheme['folder'], ($sKey == 'layout' ? $sKey : $sSubKey), $sFile, ($sKey == 'layout' ? null : $sKey), $bIncludeParent);	
					if ($sKey == 'layout')
					{
						if (is_array($sContent))
						{
							$sContent = $sContent[0];
						}
						Phpfox::getLib('file')->write($sNewHomeFolder . 'template' . PHPFOX_DS . $sFile, $sContent);
					}
					else 
					{
						Phpfox::getLib('file')->mkdir(PHPFOX_DIR_CACHE . $sDirectoryId . 'module' . PHPFOX_DS . $sKey . PHPFOX_DS . 'template' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . 'block', true);
						Phpfox::getLib('file')->mkdir(PHPFOX_DIR_CACHE . $sDirectoryId . 'module' . PHPFOX_DS . $sKey . PHPFOX_DS . 'template' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . 'controller', true);
						if (strpos($sFile, PHPFOX_DS))
						{
							$aParts = explode(PHPFOX_DS, $sFile);
							
							Phpfox::getLib('file')->mkdir(PHPFOX_DIR_CACHE . $sDirectoryId . 'module' . PHPFOX_DS . $sKey . PHPFOX_DS . 'template' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . $sSubKey . PHPFOX_DS . $aParts[0], true);
						}
						
						if (is_array($sContent) && isset($sContent[0])) // Fix for http://www.phpfox.com/tracker/view/5104/
						{
							Phpfox::getLib('file')->write(PHPFOX_DIR_CACHE . $sDirectoryId . 'module' . PHPFOX_DS . $sKey . PHPFOX_DS . 'template' . PHPFOX_DS . $aTheme['folder']. PHPFOX_DS . $sSubKey . PHPFOX_DS . $sFile, $sContent[0]);
						}
						else
						{
							Phpfox::getLib('file')->write(PHPFOX_DIR_CACHE . $sDirectoryId . 'module' . PHPFOX_DS . $sKey . PHPFOX_DS . 'template' . PHPFOX_DS . $aTheme['folder']. PHPFOX_DS . $sSubKey . PHPFOX_DS . $sFile, $sContent);
						}
					}			
				}
			}
		}
		if (isset($aVals['styles']))
		{
			foreach ($aVals['styles'] as $iStyleId)
			{			
				Phpfox::getService('theme.style')->export($iStyleId, $bIncludeParent, true, $sNewHomeFolder, $sDirectoryId);
			}					
		}
		
		return array(
			'name' => $aTheme['folder'] . (empty($aTheme['version']) ? '' : '-' . $aTheme['version']),
			'folder' => $sDirectoryIdReturn
		);
	}
	
	public function getNewThemes()
	{
		$aThemes = array();
		$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS;
		$hDir = opendir($sDir);
		while ($sFolder = readdir($hDir))
		{
			if (file_exists($sDir . $sFolder . PHPFOX_DS . 'phpfox.xml'))
			{
				$iInstalled = (int) $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('theme'))
					->where('folder = \'' . $this->database()->escape($sFolder) . '\'')
					->execute('getField');
				if (!$iInstalled)
				{
					$aParams = Phpfox::getLib('xml.parser')->parse(file_get_contents($sDir . $sFolder . PHPFOX_DS . 'phpfox.xml'));			
					$aParams['total_style'] = 0;
					
					$hDirStyle = opendir($sDir . $sFolder . PHPFOX_DS . 'style' . PHPFOX_DS);
					while ($sFolderStyle = readdir($hDirStyle))
					{
						if ($sFolderStyle == '.' || $sFolderStyle == '..')
						{
							continue;
						}
						
						if (file_exists($sDir . $sFolder . PHPFOX_DS . 'style' . PHPFOX_DS . $sFolderStyle . PHPFOX_DS . 'phpfox.xml'))
						{
							$aParams['total_style']++;
						}
					}
					closedir($hDirStyle);
					
					$aThemes[] = $aParams;
				}
			}
		}
		closedir($hDir);
		
		return $aThemes;
	}
	
	/**
	 * This function tells if the user is in Design mode with Drag and Drop support
	 * it was moved from the template library so it can be referenced by ajax
	 * calls 
	 * @return boolean
	 */
	public function isInDnDMode()
	{   		
		$aUrl = Phpfox::getLib('url')->getParams();
		
		$bIsCustomize = !isset($aUrl['req3']) || ($aUrl['req3'] != 'customize' && isset($aUrl['req2']) && $aUrl['req2'] == 'index-member');
		$bIsMusic = !isset($aUrl['req3']) || $aUrl['req1'] == 'music';

		if (Phpfox::getUserParam('core.can_design_dnd') 
				&& Phpfox::getCookie('doDnD') == 1
				// && ($bIsCustomize || $bIsMusic)
				&& (!isset($aUrl['req2']) || $aUrl['req2'] != 'designer'))
		{
			return true;
		}
		return false;
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
		if ($sPlugin = Phpfox_Plugin::get('theme.service_theme__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>
