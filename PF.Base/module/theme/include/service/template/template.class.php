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
 * @version 		$Id: template.class.php 4944 2012-10-24 05:24:29Z Raymond_Benc $
 */
class Theme_Service_Template_Template extends Phpfox_Service 
{
	private $_aFiles = array();
	
	private $_aModified = null;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('theme_template');
	}
	
	public function get($sFolder, $bFullPath = false, $bIncludeParent = true)
	{	
		$this->_buildFiles($sFolder, $bFullPath);
		
		$aTheme = $this->database()->select('t.parent_id AS theme_parent_id, pt.folder AS parent_theme_folder')
			->from(Phpfox::getT('theme'), 't')
			->leftJoin(Phpfox::getT('theme'), 'pt', 'pt.theme_id = t.parent_id')
			->where('t.folder = \'' . $this->database()->escape($sFolder) . '\'')
			->execute('getRow');
			
		if ($bIncludeParent === true && $aTheme['theme_parent_id'] > 0)
		{
			$this->_buildFiles($aTheme['parent_theme_folder'], $bFullPath);
		}
		
		if ($bFullPath === false)
		{
			$this->_buildFiles('default', $bFullPath);
		}
		
		$aTemplates = $this->database()->select('folder, type_id, module_id, name, time_stamp_update')
			->from(Phpfox::getT('theme_template'))
			->where('is_custom = 1 AND folder = \'' . $this->database()->escape($sFolder) . '\'')
			->execute('getRows');		
		foreach ($aTemplates as $aTemplate)
		{
			if (empty($aTemplate['module_id']))
			{
				$this->_aFiles['layout']['files'][] = ($aTemplate['time_stamp_update'] ? array($aTemplate['name']) : $aTemplate['name']);				
				if ($aTemplate['time_stamp_update'])
				{
					$this->_aModified['layout'][null][$aTemplate['name']] = true;
				}
			}
			else 
			{
				$this->_aFiles[$aTemplate['module_id']][$aTemplate['type_id']][] = ($aTemplate['time_stamp_update'] ? array($aTemplate['name']) : $aTemplate['name']);	
				if ($aTemplate['time_stamp_update'])
				{
					$this->_aModified[$aTemplate['type_id']][$aTemplate['module_id']][$aTemplate['name']] = true;
				}
			}
		}		
		
		ksort($this->_aFiles);		
		
		if (isset($this->_aFiles['layout']))
		{
			$aCache = $this->_aFiles['layout'];				
			
			unset($this->_aFiles['layout']);
			
			$this->_aFiles = array_merge(array('layout' => $aCache), $this->_aFiles);		
		}
		
		foreach ($this->_aFiles as $mKey => $mValues)
		{			
			if ($mKey == 'layout' && isset($this->_aModified['layout']) && count($this->_aModified['layout'][null]) > 0)
			{				
				$this->_aFiles[$mKey]['modified'] = true;
			}
			else 
			{
				if (isset($this->_aModified['block'][$mKey]) && count($this->_aModified['block'][$mKey]) > 0)
				{
					$this->_aFiles[$mKey]['modified'] = true;
				}
				
				if (isset($this->_aModified['controller'][$mKey]) && count($this->_aModified['controller'][$mKey]) > 0)
				{
					$this->_aFiles[$mKey]['modified'] = true;
				}				
			}
		}	
		
		return $this->_aFiles;
	}
	
	public function getTemplate($sTheme, $sType, $sName, $sModule = null, $bIncludeParent = true)
	{
		if ($sType == 'layout')
		{
			$aTemplate = $this->database()->select('*')
				->from($this->_sTable)
				->where("folder = '" . $this->database()->escape($sTheme) . "' AND type_id = 'layout' AND name = '" . $this->database()->escape($sName) . "'")
				->execute('getSlaveRow');	
		}
		else 
		{
			$aTemplate = $this->database()->select('*')
				->from($this->_sTable)
				->where("folder = '" . $this->database()->escape($sTheme) . "' AND type_id = '" . $this->database()->escape($sType) . "' AND module_id = '" . $this->database()->escape($sModule) . "' AND name = '" . $this->database()->escape($sName) . "'")
				->execute('getSlaveRow');	
		}		
		
		if (isset($aTemplate['template_id']))
		{
			$aTemplate['html_data'] = str_replace("\r\n", "\n", $aTemplate['html_data']);
			
			return array($aTemplate['html_data'], ($aTemplate['is_custom'] ? $aTemplate['time_stamp_update'] : $aTemplate['time_stamp']), $aTemplate['full_name'], $aTemplate['product_id'], $aTemplate['is_custom']);
		}	
		
		if ($sType == 'layout')
		{
			$sFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sTheme . PHPFOX_DS . 'template' . PHPFOX_DS . $sName;
		}
		elseif ($sType == 'controller')
		{
			$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'template' . PHPFOX_DS . $sTheme . PHPFOX_DS . 'controller' . PHPFOX_DS . $sName;
		}
		else 
		{
			$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'template' . PHPFOX_DS . $sTheme . PHPFOX_DS . 'block' . PHPFOX_DS . $sName;
		}
		
		$aTheme = $this->database()->select('t.parent_id AS theme_parent_id, pt.folder AS parent_theme_folder')
			->from(Phpfox::getT('theme'), 't')
			->leftJoin(Phpfox::getT('theme'), 'pt', 'pt.theme_id = t.parent_id')
			->where('t.folder = \'' . $this->database()->escape($sTheme) . '\'')
			->execute('getRow');		
			
		if ($bIncludeParent === true && $aTheme['theme_parent_id'] > 0)
		{
			if (!file_exists($sFile))
			{
				$sTheme = $aTheme['parent_theme_folder'];				
				if ($sType == 'layout')
				{
					$sFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sTheme . PHPFOX_DS . 'template' . PHPFOX_DS . $sName;
				}
				elseif ($sType == 'controller')
				{
					$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'template' . PHPFOX_DS . $sTheme . PHPFOX_DS . 'controller' . PHPFOX_DS . $sName;
				}
				else 
				{
					$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'template' . PHPFOX_DS . $sTheme . PHPFOX_DS . 'block' . PHPFOX_DS . $sName;
				}				
			}
		}
		
		if (!file_exists($sFile))
		{			
			if ($sType == 'layout')
			{
				$sFile = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . 'default' . PHPFOX_DS . 'template' . PHPFOX_DS . $sName;
			}
			elseif ($sType == 'controller')
			{
				$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'template' . PHPFOX_DS . 'default' . PHPFOX_DS . 'controller' . PHPFOX_DS . $sName;
			}
			else 
			{
				$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'template' . PHPFOX_DS . 'default' . PHPFOX_DS . 'block' . PHPFOX_DS . $sName;
			}
		}

		$sContent = file_get_contents($sFile);
		$sContent = str_replace("\r\n", "\n", $sContent);
		
		$aParts = explode('?>', $sContent);		
		if (isset($aParts[1]) && preg_match('/PHPFOX/', $aParts[0]))
		{		
			$sContent = ltrim($aParts[1]);
		}
		
		return $sContent;
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
		if ($sPlugin = Phpfox_Plugin::get('theme.service_template_template__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}

	private function _buildFiles($sFolder, $bFullPath = false)
	{
		static $aCache = array();		
		
		if ($this->_aModified === null)
		{
			$this->_aModified = array();
			$aTemplates = $this->database()->select('folder, type_id, module_id, name')
				->from($this->_sTable)
				->where('is_custom = 0 AND folder = \'' . $this->database()->escape($sFolder) . '\'')
				->execute('getSlaveRows');
			foreach ($aTemplates as $aTemplate)
			{
				$this->_aModified[$aTemplate['type_id']][($aTemplate['type_id'] == 'layout' ? null : $aTemplate['module_id'])][$aTemplate['name']] = true;
				if ($bFullPath === true)
				{
					if (empty($aTemplate['module_id']))
					{
						$this->_aFiles['layout']['files'][] = $aTemplate['name'];
					}
					else 
					{
						$this->_aFiles[$aTemplate['module_id']][$aTemplate['type_id']][] = $aTemplate['name'];
					}
				}
			}			
		}
		
		if (is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'template'))
		{
			$hDir = opendir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'template');
			while ($sFile = readdir($hDir))
			{
				if (substr($sFile, -9) != '.html.php')
				{
					continue;
				}
				
				if (defined('PHPFOX_IS_HOSTED_SCRIPT') && $sFile == 'blank.html.php')
				{
					continue;
				}
				
				if (isset($aCache['layout'][null][$sFile]))
				{
					continue;
				}
				
				if ($bFullPath === false && isset($this->_aModified['layout'][null][$sFile]))
				{
					$this->_aFiles['layout']['files'][] = array($sFile);
				}
				else 
				{
					$this->_aFiles['layout']['files'][] = $sFile;
				}
				
				$aCache['layout'][null][$sFile] = true;
			}
			closedir($hDir);
		}
		
		$hDir = opendir(PHPFOX_DIR_MODULE);
		while ($sDir = readdir($hDir))
		{
			if ($sDir == 'admincp')
			{
				continue;
			}
			
			$this->_readDir(PHPFOX_DIR_MODULE . $sDir . PHPFOX_DS . 'template' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'controller', $sDir, 'controller', $bFullPath);
			$this->_readDir(PHPFOX_DIR_MODULE . $sDir . PHPFOX_DS . 'template' . PHPFOX_DS . $sFolder . PHPFOX_DS . 'block', $sDir, 'block', $bFullPath);
		}
		closedir($hDir);				
	}
	
	private function _readDir($sDir, $sModule, $sType, $bFullPath = false, $sExtra = null)
	{
		static $aCache = array();
		
			if (is_dir($sDir))
			{
				$hControllerDir = opendir($sDir);
				while ($sControllerFiles = readdir($hControllerDir))
				{
					if ($sControllerFiles == 'admincp')
					{
						continue;
					}					
					
					if ($sControllerFiles == '.' || $sControllerFiles == '..' || $sControllerFiles == '.svn')
					{
						continue;
					}
					
					if (is_dir($sDir . PHPFOX_DS . $sControllerFiles))
					{
						$this->_readDir($sDir . PHPFOX_DS . $sControllerFiles, $sModule, $sType, $bFullPath, ($sExtra === null ? '' : $sExtra . '/') . $sControllerFiles);
						
						continue;
					}
					
					if (substr($sControllerFiles, -9) != '.html.php')
					{
						continue;
					}							
					
					if ($sExtra !== null)
					{
						$sControllerFiles = $sExtra . '/' . $sControllerFiles;
					}
				
					if (isset($aCache[$sModule][$sType][$sControllerFiles]))
					{
						continue;
					}					
					
					if ($bFullPath === false && isset($this->_aModified[$sType][$sModule][$sControllerFiles]))
					{
						$this->_aFiles[$sModule][$sType][] = array($sControllerFiles);
					}
					else 
					{
						$this->_aFiles[$sModule][$sType][] = $sControllerFiles;
					}
					
					$aCache[$sModule][$sType][$sControllerFiles] = true;
				}
				closedir($hControllerDir);
			}		
	}
}

?>