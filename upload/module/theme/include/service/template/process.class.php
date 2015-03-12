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
 * @version 		$Id: process.class.php 1641 2010-06-08 14:07:55Z Miguel_Espinoza $
 */
class Theme_Service_Template_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('theme_template');
	}
	
	public function add($aVals)
	{
		$aForm = array(
			'product_id' => array(
				'type' => 'string'
			),
			'group_id' => array(
				'type' => 'string:required'
			),
			'folder' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.select_a_theme_for_this_template')
			),
			'name' => array(
				'type' => 'string:required',
				'message' => 'Add a file name.'
			),			
			'full_name' => array(
				'type' => 'string'
			),
			'html_data' => array(
				'type' => 'string'
			)
		);
		
		if ((!empty($aVals['group_id']) && $aVals['group_id'] != 'layout'))
		{
			$aForm['type_id'] = array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.select_what_type_of_a_template_this_is')
			);			
		}		
		
		$aVals = $this->validator()->process($aForm, $aVals);		
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}		
		
		$aVals['name'] = $this->preParse()->cleanFileName($aVals['name']);
		
		if (empty($aVals['name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.file_name_is_not_valid'));
		}			
				
		$aVals['name'] = $aVals['name'] . '.html.php';
		
		if ((empty($aVals['group_id'])) || (!empty($aVals['group_id']) && $aVals['group_id'] == 'layout'))
		{
			if (file_exists(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aVals['folder'] . PHPFOX_DS . 'template' . PHPFOX_DS . $aVals['name']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('theme.the_file_name_is_already_in_use'));
			}
		}
		else 
		{
			if (file_exists(PHPFOX_DIR_MODULE . $aVals['group_id'] . PHPFOX_DS . 'template' . PHPFOX_DS . $aVals['folder'] . PHPFOX_DS . $aVals['type_id'] . PHPFOX_DS . $aVals['name']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('theme.the_file_name_is_already_in_use'));
			}
		}	
				
		$aVals['full_name'] = (empty($aVals['full_name']) ? null : $this->preParse()->clean($aVals['full_name'], 255));
		$aVals['time_stamp'] = PHPFOX_TIME;
		$aVals['is_custom'] = '1';
		$aVals['module_id'] = ((empty($aVals['group_id']) || (!empty($aVals['group_id']) && $aVals['group_id'] == 'layout')) ? null : $aVals['group_id']);
		$aVals['type_id'] = ((empty($aVals['group_id']) || (!empty($aVals['group_id']) && $aVals['group_id'] == 'layout')) ? 'layout' : $aVals['type_id']);
		$aVals['html_data_original'] = $aVals['html_data'];		
		
		unset($aVals['group_id']);
		
		$iCheck = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('theme_template'))
			->where('folder = \'' . $this->database()->escape($aVals['folder']) . '\' AND type_id = \'' . $this->database()->escape($aVals['type_id']) . '\' AND module_id = \'' . $this->database()->escape($aVals['module_id']) . '\' AND name = \'' . $this->database()->escape($aVals['name']) . '\'')
			->execute('getField');
			
		if ($iCheck)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.the_file_name_is_already_in_use'));
		}		
		
		$this->database()->insert(Phpfox::getT('theme_template'), $aVals);
		
		return true;
	}

	public function addForTheme(&$aTheme, &$aVals)
	{		
		if (isset($aVals['template']['type_id']))
		{
			$aVals['template'] = array($aVals['template']);
		}
		
		if (isset($aVals['template']) && is_array($aVals['template']))
		{
			foreach ($aVals['template'] as $aTemplate)
			{
				if ($aTemplate['type_id'] == 'layout')
				{
					$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . 'template' . PHPFOX_DS;	
				}
				else 
				{
					if (!Phpfox::isModule($aTemplate['module_id']))
					{
						continue;
					}
					
					if (!is_dir(PHPFOX_DIR_MODULE . $aTemplate['module_id']))
					{
						continue;
					}
					
					$sParentDir = PHPFOX_DIR_MODULE . $aTemplate['module_id'] . PHPFOX_DS . 'template' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS;
					$sDir = PHPFOX_DIR_MODULE . $aTemplate['module_id'] . PHPFOX_DS . 'template' . PHPFOX_DS . $aTheme['folder'] . PHPFOX_DS . $aTemplate['type_id'] . PHPFOX_DS;
				}			
				
				if (isset($sParentDir) && !is_dir($sParentDir))
				{
					Phpfox::getLib('ftp')->mkdir($sParentDir);
				}
				
				if (!is_dir($sDir))
				{				
					Phpfox::getLib('ftp')->mkdir($sDir);
				}
				
				if (preg_match('/(.*)_(.*)/i', $aTemplate['name'], $aMatches) && isset($aMatches[2]))
				{
					if (!is_dir($sDir . $aMatches[1]))
					{
						Phpfox::getLib('ftp')->mkdir($sDir . $aMatches[1]);
					}
					
					$aTemplate['name'] = str_replace('_', '/', $aTemplate['name']);
				}
					
				$sTempFile = 'theme_template_cache_' . md5($aTemplate['name'] . $aTheme['theme_id']);
				Phpfox::getLib('file')->writeToCache($sTempFile, $aTemplate['value']);		
				if (file_exists($sDir . $aTemplate['name']))
				{
					Phpfox::getLib('ftp')->unlink($sDir . $aTemplate['name']);
				}
				Phpfox::getLib('ftp')->move(PHPFOX_DIR_CACHE . $sTempFile, $sDir . $aTemplate['name']);
				if (file_exists($sTempFile))
				{
					unlink($sTempFile);
				}			
			}		
		}
		
		return true;
	}
	
	public function update($aVals)
	{
		if (empty($aVals['module']))
		{
			$aTemplate = $this->database()->select('template_id, is_custom')
				->from($this->_sTable)
				->where("folder = '" . $aVals['theme'] . "' AND type_id = 'layout' AND name = '" . $this->database()->escape($aVals['name']) . "'")
				->execute('getSlaveRow');	
		}
		else 
		{
			$aTemplate = $this->database()->select('template_id, is_custom')
				->from($this->_sTable)
				->where("folder =  '" . $aVals['theme'] . "' AND type_id = '" . $this->database()->escape($aVals['type']) . "' AND module_id = '" . $this->database()->escape($aVals['module']) . "' AND name = '" . $this->database()->escape($aVals['name']) . "'")
				->execute('getSlaveRow');	
		}		
		
		$aSql = array(
			'product_id' => $aVals['product_id'],
			'folder' => $aVals['theme'],
			'type_id' => $aVals['type'],
			'module_id' => (empty($aVals['module']) ? null : $aVals['module']),
			'name' => $aVals['name'],
			'html_data' => str_replace('\\','\\\\',$aVals['text']),
			'full_name' => Phpfox::getUserBy('full_name')			
		);
		
		if (empty($aTemplate['is_custom']))
		{
			$aSql['time_stamp'] = PHPFOX_TIME;
		}
		else 
		{
			$aSql['time_stamp_update'] = PHPFOX_TIME;
		}
		
		if (isset($aTemplate['template_id']))
		{
			$this->database()->update($this->_sTable, $aSql, "template_id = " . $aTemplate['template_id']);
		}
		else 
		{
			$this->database()->insert($this->_sTable, $aSql);
		}
		
		$this->cache()->remove();
			
		return true;
	}
	
	public function revert($aVals)
	{		
		if (empty($aVals['module']))
		{
			$sQuery = "folder = '" . $aVals['theme'] . "' AND type_id = 'layout' AND name = '" . $this->database()->escape($aVals['name']) . "'";
		}
		else 
		{
			$sQuery = "folder =  '" . $aVals['theme'] . "' AND type_id = '" . $this->database()->escape($aVals['type']) . "' AND module_id = '" . $this->database()->escape($aVals['module']) . "' AND name = '" . $this->database()->escape($aVals['name']) . "'";
		}			
		
		$aTemplate = $this->database()->select('template_id, is_custom, html_data_original')
			->from(Phpfox::getT('theme_template'))
			->where($sQuery)
			->execute('getRow');
		
		if ((int) $aTemplate['is_custom'] > 0)
		{
			$this->database()->update($this->_sTable, array('html_data' => $aTemplate['html_data_original'], 'time_stamp_update' => '0', 'full_name' => null), 'template_id = ' . $aTemplate['template_id']);
		}
		else 
		{
			$this->database()->delete($this->_sTable, $sQuery);
		}
		
		$this->cache()->remove();	

		return true;
	}
	
	public function delete($aVals)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
		
		if (empty($aVals['module']))
		{
			$sQuery = "folder = '" . $aVals['theme'] . "' AND type_id = 'layout' AND name = '" . $this->database()->escape($aVals['name']) . "'";
		}
		else 
		{
			$sQuery = "folder =  '" . $aVals['theme'] . "' AND type_id = '" . $this->database()->escape($aVals['type']) . "' AND module_id = '" . $this->database()->escape($aVals['module']) . "' AND name = '" . $this->database()->escape($aVals['name']) . "'";
		}			
		
		$aTemplate = $this->database()->select('template_id')
			->from(Phpfox::getT('theme_template'))
			->where($sQuery)
			->execute('getRow');	
			
		if (!isset($aTemplate['template_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.not_a_valid_template_to_delete'));
		}
		
		$this->database()->delete(Phpfox::getT('theme_template'), 'template_id = ' . $aTemplate['template_id']);
		
		$this->cache()->remove();			
		
		return true;
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
		if ($sPlugin = Phpfox_Plugin::get('theme.service_template_process__call'))
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