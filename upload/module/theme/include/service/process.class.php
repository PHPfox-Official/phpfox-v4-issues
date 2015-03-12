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
 * @version 		$Id: process.class.php 6545 2013-08-30 08:41:44Z Raymond_Benc $
 */
class Theme_Service_Process extends Phpfox_Service 
{
	private $_aThemeStructure = array(
		'style',
		'template',
		'xml'
	);
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('theme');	
	}
	
	public function deleteUserMenu($iMenuId, $bRemove = false)
	{
		$this->database()->delete(Phpfox::getT('theme_umenu'), 'user_id = ' . Phpfox::getUserId() . ' AND menu_id = ' . (int) $iMenuId);
		if (!$bRemove)
		{
			$this->database()->insert(Phpfox::getT('theme_umenu'), array('user_id' => Phpfox::getUserId(), 'menu_id' => $iMenuId));
		}
		Phpfox::getLib('cache')->remove(array('user', 'nbselectname_' . Phpfox::getUserId()));
	}
	
	public function add($aVals, $iEditId = null, $sXmlData = null, $bIsImport = false)
	{
		$aForm = array(
			'name' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.theme_requires_a_name')
			),
			'folder' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.theme_requires_a_folder_name')
			),
			'creator' => array(
				'type' => 'string'
			),
			'website' => array(
				'type' => 'string'
			),
			'version' => array(
				'type' => 'string'
			),
			'parent_id' => array(
				'type' => 'int'				
			),
			'is_active' => array(
				'type' => 'int:required',
				'message' => Phpfox::getPhrase('theme.provide_if_the_theme_is_active_or_not')
			)			
		);	

		$bIsOverwrite = (isset($aVals['overwrite']) && $aVals['overwrite'] ? true : false);	

		if ($sXmlData !== null)
		{
			$aCache = $aVals;
		}
		
		if ($iEditId !== null)
		{
			$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aVals['folder'] . PHPFOX_DS;
			
			unset($aForm['folder']);
		}		
		
		$aVals = $this->validator()->process($aForm, $aVals);
		
		if (!empty($aVals['creator']))
		{
			$aVals['creator'] = $this->preParse()->clean($aVals['creator'], 255);
		}
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		
		if ($iEditId === null)
		{		
			if ($bIsImport === true)
			{
				if (Phpfox::getParam('core.ftp_enabled'))
				{
					if (!Phpfox::getLib('ftp')->test())
					{
						return false;
					}
				}
			}			
			
			$aVals['folder'] = $this->preParse()->cleanFileName($aVals['folder']);
			
			if (empty($aVals['folder']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('theme.folder_is_not_valid'));
			}
	
			if (is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aVals['folder'] . PHPFOX_DS) && !$bIsOverwrite)
			{
				return Phpfox_Error::set(Phpfox::getPhrase('theme.this_folder_is_already_in_use'));
			}			
			
			$aVals['created'] = PHPFOX_TIME;	
			
			$iCheck = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('theme'))
				->where('folder = \'' . $this->database()->escape($aVals['folder']) . '\'')
				->execute('getField');
				
			if ($iCheck)
			{
				return Phpfox_Error::set(Phpfox::getPhrase('theme.there_is_already_a_theme_with_the_same_folder_name'));
			}			
			
			$iId = $this->database()->insert($this->_sTable, $aVals);			
			
			$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aVals['folder'] . PHPFOX_DS;
		}
		else 
		{
			if (isset($aVals['is_default']) && $aVals['is_default'])
			{
				$this->database()->update($this->_sTable, array('is_default' => '0'), 'theme_id > 0');
				Phpfox::getLib('session')->remove('theme');
			}
			$this->database()->update($this->_sTable, $aVals, 'theme_id = ' . (int) $iEditId);
			
			$iId = $iEditId;
		}
		
		/*
		if (Phpfox::getParam('core.ftp_enabled'))
		{			
			if (!is_dir($sDir))
			{
				Phpfox::getLib('ftp')->mkdir($sDir);
			}
			foreach ($this->_aThemeStructure as $sFileDirectory)
			{
			 	if (!is_dir($sDir . $sFileDirectory . PHPFOX_DS))
			 	{
					Phpfox::getLib('ftp')->mkdir($sDir . $sFileDirectory . PHPFOX_DS);
			 	}
			}
		}		
		
		if (!empty($sXmlData))
		{
			if (Phpfox::getParam('core.ftp_enabled'))
			{
				$aVals = $aCache;
				
				$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aVals['folder'] . PHPFOX_DS;				
				$sTempFile = 'theme_cache_xml_' . $iId;				
				Phpfox::getLib('file')->writeToCache($sTempFile, base64_decode($sXmlData));
				if (file_exists($sDir . 'xml' . PHPFOX_DS . 'phpfox.xml.php'))
				{
					Phpfox::getLib('ftp')->unlink($sDir . 'xml' . PHPFOX_DS . 'phpfox.xml.php');
				}
				
				Phpfox::getLib('ftp')->move(PHPFOX_DIR_CACHE . $sTempFile, $sDir . 'xml' . PHPFOX_DS . 'phpfox.xml.php');
			}
		}		
		*/
		
		$this->cache()->remove();
		
		return $iId;
	}
	
	public function update($iId, $aVals)
	{
		return $this->add($aVals, $iId);
	}
	
	public function updateCss($sTypeId, $aCss)
	{
		$aCallback = Phpfox::callback($sTypeId . '.getDetailOnCssUpdate');
		
		if ($aCallback === false)
		{
			return false;
		}
		
		$this->database()->delete(Phpfox::getT($aCallback['table']), $aCallback['field'] . ' = ' . $aCallback['value']);
		
		foreach ($aCss as $sSelector => $aProperties)
		{
			foreach ($aProperties as $sProperty => $sValue)
			{
				if (!Phpfox::getLib('parse.css')->process($sProperty, $sValue))
				{
					continue;
				}
				
				switch ($sProperty)
				{
					case 'background-color':
						
						break;
					case 'background-image':
						if (!empty($sValue))
						{						
							$sValue = 'url(\'' . $sValue . '\')';
						}
						break;	
					case 'font-color':
						$sProperty = 'color';
						break;					
				}
				
				if (empty($sValue))
				{
					$sValue = null;
				}				
					
				(($sCmd = Phpfox::getLib('template')->getXml('update_css')) ? eval($sCmd) : null);
				
				$this->database()->insert(Phpfox::getT($aCallback['table']), array(
						$aCallback['field'] => $aCallback['value'],
						'css_selector' => $sSelector,
						'css_property' => $sProperty,
						'css_value' => $sValue
					)
				);
			}
		}
		
		$sHash = $this->database()->select($aCallback['table_hash_field'])
			->from(Phpfox::getT($aCallback['table_hash']))
			->where($aCallback['field'] . ' = ' . $aCallback['value'])
			->execute('getField');
			
		$sCacheFile = Phpfox::getParam('css.dir_cache') . $sHash . '.css';
		if (file_exists($sCacheFile))
		{
			unlink($sCacheFile);
		}
		
		$this->database()->update(Phpfox::getT($aCallback['table_hash']), array($aCallback['table_hash_field'] => md5(uniqid())), $aCallback['field'] . ' = ' . $aCallback['value']);
		
		return true;
	}
	
	public function updateTheme($sTypeId, $iStyleId, $iItemId = null)
	{
		$aCallback = Phpfox::callback($sTypeId . '.getDetailOnThemeUpdate', $iItemId);
		
		if ($aCallback === false)
		{
			return false;
		}
		
		$this->database()->update(Phpfox::getT($aCallback['table']), array($aCallback['field'] => (int) $iStyleId), $aCallback['action'] . ' = ' . $aCallback['value']);
		if (Phpfox::getParam('core.super_cache_system'))
		{
			$this->cache()->remove('profile', 'substr');
			$sCacheId = $this->cache()->remove(array('userdata', Phpfox::getUserId()));	
		}
		
		if (isset($aCallback['javascript']))
		{
			return $aCallback['javascript'];
		}
		
		return true;
	}	
	
	public function updateBlock($aVals)
	{		
		$aCallback = Phpfox::callback($aVals['type_id'] . '.getDetailOnBlockUpdate', $aVals);
		
		if ($aCallback === false)
		{
			return false;
		}		
		
		$sBlockId = $aVals['cache_id'];
		$iHidden = $aVals['is_installed'];
		
		$iHasEntry = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT($aCallback['table']))
			->where($aCallback['field'] . ' = ' . $aCallback['value'] . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'')
			->execute('getSlaveField');
			
		if ($iHasEntry)
		{
			$this->database()->update(Phpfox::getT($aCallback['table']), array('is_hidden' => $iHidden), $aCallback['field'] . ' = ' . $aCallback['value'] . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'');
		}
		else 
		{
			$aParts = explode('_',Phpfox::getLib('parse.input')->clean($sBlockId));
			if (!isset($aParts[1]))
			{
				return false;
			}
			$aBlock = $this->database()->select('location, ordering')
				->from(Phpfox::getT('block'))
				->where('module_id = "'.$aParts[0].'" AND component = "'.$aParts[1].'"')
				->execute('getSlaveRow');
			if (!isset($aBlock['location']) || empty($aBlock['location']))
			{
				return false;
			}
			$this->database()->insert(Phpfox::getT($aCallback['table']), array($aCallback['field'] => $aCallback['value'], 'cache_id' => 'js_block_border_' . $sBlockId, 'block_id' => $aBlock['location'], 'ordering' => $aBlock['ordering'], 'is_hidden' => $iHidden));
		}
		
		return true;
	}	
	
	/**
	 * Updates the order of the blocks by using the data from a callback.
	 * A common callback is for ordering in the profile which updates the table
	 * `phpfox_user_design_order`
	 * @param type $aVals
	 * @return type 
	 */
	public function updateOrder($aVals)
	{
		
		$aCallback = Phpfox::callback($aVals['param']['type_id'] . '.getDetailOnOrderUpdate', $aVals);
		
		if ($aCallback === false)
		{
			return false;
		}			
		
		if (isset($aVals['order']))
		{
			$aRows = $this->database()->select('cache_id')
				->from(Phpfox::getT($aCallback['table']))
				->where($aCallback['field'] . ' = ' . $aCallback['value'])
				->execute('getRows');
			$aCache = array();
			
			if (Phpfox::getParam('profile.cache_blocks_design'))
			{
				$aValidTables = array('pages_design_order','user_design_order','user_dashboard');
				if (in_array($aCallback['table'], $aValidTables))
				{					
					$sCacheTable = 'user_design';
					$oCache = Phpfox::getLib('cache');
					if ($aCallback['table'] == 'pages_design_order')
					{
						$sCacheTable = 'pages_design';
					}
					else if ($aCallback['table'] == 'user_dashboard')
					{
						$sCacheTable = 'user_dashboard';
					}
					$sCacheId = $this->cache()->set(array($sCacheTable, Phpfox::getUserId()));
					$this->cache()->remove($sCacheId);
				}				
			}
			
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['cache_id']] = true;
			}
			foreach ($aVals['order'] as $sCacheId => $aOrder)
			{				
				if (substr($sCacheId, 0, 6) == 'clone_')
				{
					continue;
				}
				
				$aKey = array_keys($aOrder);
				
				if (isset($aKey[0]) && $aKey[0] == 'undefined')
				{
					$aKey[0] = 'sidebar';
				}
				
				$aValue = array_values($aOrder);
				if (isset($aCache[$sCacheId]))
				{
					$sWhere = $aCallback['field'] . ' = ' . $aCallback['value'] . ' AND cache_id = \'' . $this->database()->escape($sCacheId) . '\'';
					$this->database()->update(Phpfox::getT($aCallback['table']), array('ordering' => $aValue[0], 'block_id' => $aKey[0]), 
					$sWhere		);
				}
				else 
				{
					$this->database()->insert(Phpfox::getT($aCallback['table']), array($aCallback['field'] => $aCallback['value'], 'cache_id' => $sCacheId, 'block_id' => $aKey[0], 'ordering' => $aValue[0]));
				}
			}
		}
		
		return true;
	}	
	
	/**
	 * We match aVals and sController to `phpfox_block`
	 * it updates the order or if a new block was added it inserts it into phpfox_block
	 * @param type $aVals
	 * @param type $sController 
	 */
	public function updateOrderDnD($aVals, $sController)
	{
		if (!Phpfox::getUserParam('core.can_design_dnd'))
		{
			return false;
		}
		
		/* Load all the blocks for this controller */
		$aExistingBlocks = $this->database()->select('m_connection, component, module_id')
					->from(Phpfox::getT('block'))
					->where('m_connection = "' . Phpfox::getLib('parse.input')->clean($sController) . '"')
					->execute('getSlaveRows');
		
		$aCache = array();
		$iOffset = 0;
		foreach ($aExistingBlocks as $aBlock)
		{
			$aCache[$aBlock['module_id'] . $aBlock['component']] = $aBlock;
		}
		//d($aVals);		d($aVals);
		foreach ($aVals as $sBlock => $aBlock)
		{	
			$aParts = explode('_',Phpfox::getLib('parse.input')->clean($sBlock));
			if (!isset($aParts[0]) || !isset($aParts[1]))
			{
				return Phpfox_Error::set('Wrong format when changing order of blocks');
			}
			/* Check if the current block exists already in that location */
			if (strpos($sBlock, 'new_') === false)//($aCache[$aParts[0] . $aParts[1] ]))
			{
				//continue;
				/* if it exists update its location */
				$this->database()->update(Phpfox::getT('block'), array(
						'ordering' => (int)$aBlock['ordering'] + $iOffset,
						'location' => (int)$aBlock['target']
				), 
					'm_connection = "' . Phpfox::getLib('parse.input')->clean($sController) . 
					'" AND module_id = "' . $aParts[0] . '" AND component = "' . $aParts[1] . (isset($aParts[2]) ? '.' . $aParts[2] : '') . '"'
					);
			}
			else
			{
				//continue;
				/* if it does not exist then add it */
				$iOffset++;
				$iId = $this->database()->insert(Phpfox::getT('block'), array(
					'title' => '',
					'type_id' => '0',
					'm_connection' => Phpfox::getLib('parse.input')->clean($sController),
					'module_id' => $aParts[1],
					'product_id' => 'phpfox', /* ?? */
					'component' => $aParts[2],
					'location' => (int)$aBlock['target'],
					'is_active'	=> '1',
					'ordering' => (int)$aBlock['ordering'] + $iOffset,
					'disallow_access' => '',
					'can_move' => '1',
					'version_id' => null
				));
				//d($iId, true);
			}
		}
		Phpfox::getLib('cache')->remove('block', 'substr');
		return true;
	}
	
	/**
	 * When in DnD mode this function allows the user to remove a block completely
	 * (not hide it).
	 * It removes the last added entry to phpfox_block that matches the params
	 * @param string $sController for example: core.index-member
	 * @param string $sId <module>_<block>
	 */
	public function removeBlockDnD($sController, $sId)
	{
		/* Little security check */
		if (!Phpfox::getService('theme')->isInDnDMode())
		{
			return Phpfox_Error::set('You need to enable DnD mode first.');
		}
		$oInput = Phpfox::getLib('parse.input');
		$aParts = explode('_', $oInput->clean($sId), 2);
		
		$sWhere = 'm_connection = "' . $oInput->clean($sController) . '" AND module_id = "' . $aParts[0] . (isset($aParts[1]) ? '" AND component = "' . str_replace('_','.',$aParts[1]) . '"' : '');
		
		$this->database()->update(Phpfox::getT('block'), array('is_active' => 0), $sWhere);
				
		Phpfox::getLib('cache')->remove('block', 'substr');
		return true;
	}
	
	public function resetCss($sTypeId, $aCss)
	{
		$aCallback = Phpfox::callback($sTypeId . '.getDetailOnCssUpdate');
		
		if ($aCallback === false)
		{
			return false;
		}

		foreach ($aCss as $sSelector => $aProperties)
		{
			foreach ($aProperties as $sProperty => $sValue)
			{
				(($sCmd = Phpfox::getLib('template')->getXml('reset_css')) ? eval($sCmd) : null);
				
				switch ($sProperty)
				{
					case 'font-color':
						$sProperty = 'color';
						break;
				}
				
				$this->database()->delete(Phpfox::getT($aCallback['table']), $aCallback['field'] . ' = ' . $aCallback['value'] . ' AND css_selector = \'' . $this->database()->escape($sSelector) . '\' AND css_property = \'' . $this->database()->escape($sProperty) . '\'');
			}
		}
		
		$sHash = $this->database()->select($aCallback['table_hash_field'])
			->from(Phpfox::getT($aCallback['table_hash']))
			->where($aCallback['field'] . ' = ' . $aCallback['value'])
			->execute('getField');
			
		$sCacheFile = Phpfox::getParam('css.dir_cache') . $sHash . '.css';
		if (file_exists($sCacheFile))
		{
			unlink($sCacheFile);
		}		
			
		return true;
	}
	
	public function revertDesign($sTypeId)
	{
		$aCallback = Phpfox::callback($sTypeId . '.getDetailOnCssUpdate');
		
		if ($aCallback === false)
		{
			return false;
		}	
		
		$this->database()->delete(Phpfox::getT($aCallback['table']), $aCallback['field'] . ' = ' . $aCallback['value']);
		
		$sHash = $this->database()->select($aCallback['table_hash_field'])
			->from(Phpfox::getT($aCallback['table_hash']))
			->where($aCallback['field'] . ' = ' . $aCallback['value'])
			->execute('getField');
		
		$sCacheFile = Phpfox::getParam('css.dir_cache') . $sHash . '.css';
		if (file_exists($sCacheFile))
		{
			unlink($sCacheFile);
		}	
		
		$this->database()->update(Phpfox::getT($aCallback['table_hash']), array($aCallback['table_hash_field'] => md5(uniqid())), $aCallback['field'] . ' = ' . $aCallback['value']);

		return true;	
	}
	
	public function saveCssCode($sTypeId, $sCss)
	{
		$aCallback = Phpfox::callback($sTypeId . '.getDetailOnCssUpdate');
		
		if ($aCallback === false)
		{
			return false;
		}		
		
		$this->database()->delete(Phpfox::getT($aCallback['table_code']), $aCallback['field'] . ' = ' . $aCallback['value']);
		$this->database()->insert(Phpfox::getT($aCallback['table_code']), array(
				$aCallback['field'] => $aCallback['value'],
				'css_code' => Phpfox::getLib('parse.css')->cleanCss($sCss)
			)
		);

		$sHash = $this->database()->select($aCallback['table_hash_field'])
			->from(Phpfox::getT($aCallback['table_hash']))
			->where($aCallback['field'] . ' = ' . $aCallback['value'])
			->execute('getField');
			
		$sCacheFile = Phpfox::getParam('css.dir_cache') . $sHash . '.css';
		if (file_exists($sCacheFile))
		{
			unlink($sCacheFile);
		}			
		
		$this->database()->update(Phpfox::getT($aCallback['table_hash']), array($aCallback['table_hash_field'] => md5(uniqid())), $aCallback['field'] . ' = ' . $aCallback['value']);
	}
	
	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
	
		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'theme_id = ' . (int) $iId);
		
		$this->cache()->remove();
	}	
	
	public function delete($iId)
	{		
		$aTheme = $this->database()->select('theme_id, folder')
			->from(Phpfox::getT('theme'))
			->where('theme_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aTheme['theme_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('theme.not_a_valid_theme_to_delete'));
		}
		
		$aStyles = $this->database()->select('style_id')
			->from(Phpfox::getT('theme_style'))
			->where('theme_id = ' . (int) $iId)
			->execute('getRows');
		foreach ($aStyles as $aStyle)
		{
			Phpfox::getService('theme.style.process')->delete($aStyle['style_id']);			
		}		
		
		$this->database()->delete(Phpfox::getT('theme_template'), 'folder = \'' . $this->database()->escape($aTheme['folder']) . '\'');
		$this->database()->delete(Phpfox::getT('theme'), 'theme_id = ' . $aTheme['theme_id']);		
		if (Phpfox::getParam('core.super_cache_system'))
		{
			// We need to clear cache to update the themes in profiles. user module user service
			$this->cache()->remove('profile', 'substr');
		}
		
		if (Phpfox::getParam('core.ftp_enabled'))
		{		
			if (is_dir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aTheme['folder']))
			{
				Phpfox::getLib('ftp')->rmdir(PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aTheme['folder']);
			}
			
			$hDir = opendir(PHPFOX_DIR_MODULE);
			while ($sModule = readdir($hDir))
			{
				if ($sModule == '.' || $sModule == '..')
				{
					continue;
				}
				
				$sDir = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . 'template' . PHPFOX_DS . $aTheme['folder'];
				if (is_dir($sDir))
				{
					Phpfox::getLib('ftp')->rmdir($sDir);
				}
			}
			closedir($hDir);			
		}
		
		return true;
	}
	
	public function installThemeFromFolder($sTheme, $mForce = false)
	{
		if (!$mForce)
		{
			$sDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $sTheme . PHPFOX_DS;
			if (!file_exists($sDir . 'phpfox.xml'))
			{
				return Phpfox_Error::set('Not a valid theme to install.');
			}
		}
		
		$iInstalled = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('theme'))
			->where('folder = \'' . $this->database()->escape($sTheme) . '\'')
			->execute('getField');
			
		if ($iInstalled)
		{
			return Phpfox_Error::set('This theme is already installed.');
		}

		$aParams = Phpfox::getLib('xml.parser')->parse(file_get_contents(($mForce ? PHPFOX_DIR_CACHE . $mForce . PHPFOX_DS . 'upload/theme/frontend/' . $sTheme . '/phpfox.xml' : $sDir . 'phpfox.xml')));

		$aForm = array(
			'name' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.theme_requires_a_name')
			),
			'folder' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('theme.theme_requires_a_folder_name')
			),
			'created' => array(
				'type' => 'int'
			),				
			'creator' => array(
				'type' => 'string'
			),
			'website' => array(
				'type' => 'string'
			),
			'version' => array(
				'type' => 'string'
			),
			'parent_id' => array(
				'type' => 'string'
			)			
		);					
		
		$aParams['parent_id'] = 0;	
		if (!empty($aParams['parent']))
		{
			$aParent = Phpfox::getService('theme')->getTheme($aParams['parent'], true);
			if (isset($aParent['theme_id']))
			{
				$aParams['parent_id'] = $aParent['theme_id'];
			}
		}
		
		$aParams = $this->validator()->process($aForm, $aParams);
		
		if (!empty($aParams['creator']))
		{
			$aParams['creator'] = $this->preParse()->clean($aParams['creator'], 255);
		}
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}		
		
		$aParams['is_active'] = 1;
		$aParams['is_default'] = 0;

		$iId = $this->database()->insert(Phpfox::getT('theme'), $aParams);
		// I dont think we need to clear cache for profiles here, seems to be working fine without doing this -Purefan
		
		if ($mForce && Phpfox::getParam('core.phpfox_is_hosted'))
		{
			$sStyleDir = PHPFOX_DIR_CACHE . $mForce . PHPFOX_DS . 'upload' . PHPFOX_DS . 'theme' . PHPFOX_DS . 'frontend' . PHPFOX_DS . $aParams['folder'] . PHPFOX_DS . 'style' . PHPFOX_DS;
		}
		else
		{
			$sStyleDir = PHPFOX_DIR_THEME . 'frontend' . PHPFOX_DS . $aParams['folder'] . PHPFOX_DS . 'style' . PHPFOX_DS;
		}

		$hDir = opendir($sStyleDir);
		while ($sFolder = readdir($hDir))
		{
			if ($sFolder == '.' || $sFolder == '..')
			{
				continue;
			}
		
			if (!file_exists($sStyleDir . $sFolder . PHPFOX_DS . 'phpfox.xml'))
			{
				continue;
			}
			
			$iInstalled = (int) $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('theme_style'))
				->where('theme_id = ' . (int) $iId . ' AND folder = \'' . $this->database()->escape($sFolder) . '\'')
				->execute('getField');			
			
			if (!$iInstalled)
			{
				Phpfox::getService('theme.style.process')->installStyleFromFolder($aParams['folder'], $sFolder, $mForce);
			}
		}
		closedir($hDir);		
		
		if ($mForce && Phpfox::getParam('core.phpfox_is_hosted'))
		{
			$aFiles = Phpfox::getLib('file')->getAllFiles(PHPFOX_DIR_CACHE . $mForce . PHPFOX_DS);

			$aCssContent = array();
			foreach ($aFiles as $sFile)
			{
				if ($sFile == '.' || $sFile == '..' || empty($sFile))
				{
					continue;
				}
				if (substr($sFile, -4) == '.css')
				{
					preg_match('/(.*)\/style\/(.*)\/css\/(.*)/i', $sFile, $aMatches);
					if (isset($aMatches[2]))
					{
						if (!isset($aCssContent[$aMatches[2]]))
						{
							$aCssContent[$aMatches[2]] = '';
						}
					
						$aCssContent[$aMatches[2]] .= file_get_contents($sFile);
					}
				}
				elseif (substr($sFile, -9) == '.html.php')
				{										
					$sTypeId = 'layout';
					$sModuleId = null;
					$aNameParts = explode('/', $sFile);
					$sTemplateName = $aNameParts[(count($aNameParts) - 1)];
					$sTemplateContent = file_get_contents($sFile);
										
					$this->database()->insert(Phpfox::getT('theme_template'), array(
							'is_custom' => '1',
							'folder' => $sTheme,
							'type_id' => $sTypeId,
							'product_id' => 'phpfox',
							'module_id' => $sModuleId,
							'name' => $sTemplateName,
							'html_data' => $sTemplateContent,
							'time_stamp' => PHPFOX_TIME
						)
					);
				}
			}
						
			if (!empty($sFile))
			{
				foreach ($aCssContent as $sStyleName => $sStyleContent)
				{
					$this->_sStyleDir = $sStyleDir . $sStyleName;
					
					$sStyleContent = preg_replace_callback('/url\((.*)\)/i', array($this, 'replaceCdnImages'), $sStyleContent);					
					
					$iStyleId = $this->database()->select('style_id')
						->from(Phpfox::getT('theme_style'))
						->where('folder = \'' . $this->database()->escape($sStyleName) . '\'')
						->execute('getSlaveField');
					
					if ($iStyleId)
					{
						$sName = md5(PHPFOX_IS_HOSTED_SCRIPT . uniqid()) . '.css';
						$sTempFile = PHPFOX_DIR_CACHE . $sName;							
							
						$hFile = fopen($sTempFile, 'w+');
						fwrite($hFile, $sStyleContent);
						fclose($hFile);
							
						Phpfox::getLib('cdn')->put($sTempFile, 'file/static/' . $sName);
							
						unlink($sTempFile);						
						
						$this->database()->delete(Phpfox::getT('theme_css'), 'style_id = ' . (int) $iStyleId);
						$this->database()->insert(Phpfox::getT('theme_css'), array(
								'module_id' => null,
								'product_id' => null,
								'style_id' => $iStyleId,
								'file_name' => 'custom.css',
								'css_data' => $sStyleContent,
								'css_data_original' => $sName,
								'full_name' => null,
								'time_stamp' => PHPFOX_TIME	
							)
						);
					}
				}
			}
						
			Phpfox::getLib('file')->delete_directory(PHPFOX_DIR_CACHE . $mForce . PHPFOX_DS);
		}
		
		return $iId;
	}
	
	public function replaceCdnImages($aMatches)
	{
		$sImage = trim(trim($aMatches[1], '"'), "'");
		$sActualFile = rtrim($this->_sStyleDir, '/') . str_replace('..', '', $sImage);

		if (file_exists($sActualFile))
		{
			$aParts = explode('upload/', $this->_sStyleDir);
			$sUrl = Phpfox::getParam('core.rackspace_url') . $aParts[1];
			Phpfox::getLib('cdn')->put($sActualFile, $aParts[1] . str_replace('..', '', $sImage));
		}
		else
		{
			$sUrl = Phpfox::getCdnPath() . 'theme/frontend/default/style/default';
		}
		
		$sImage = str_replace('..', $sUrl, $sImage);
		
		return 'url(\'' . $sImage . '\')';
	}
	
	public function resetBlock($sType)
	{
		Phpfox::isUser(true);
		if ($sType == 'profile')
		{
			$this->database()->delete(Phpfox::getT('user_design_order'), 'user_id = ' . Phpfox::getUserId());
			if (Phpfox::getParam('profile.cache_blocks_design'))
			{
				$sCacheId = $this->cache()->set(array('user_design', Phpfox::getUserId()));
				$this->cache()->remove($sCacheId);
			}
		}
		elseif ($sType == 'pages')
		{
			if (Phpfox::getService('pages')->isAdmin(Phpfox::getLib('request')->get('req2')))
			{	
				$this->database()->delete(Phpfox::getT('pages_design_order'), 'page_id = ' . (int) Phpfox::getLib('request')->get('req2'));
				$sCacheId = $this->cache()->set(array('pages_design', Phpfox::getUserId()));
				$this->cache()->remove($sCacheId);
			}		
		}
		else
		{
			$this->database()->delete(Phpfox::getT('user_dashboard'), 'user_id = ' . Phpfox::getUserId());
			$sCacheId = $this->cache()->set(array('user_dashboard', Phpfox::getUserId()));
			$this->cache()->remove($sCacheId);
		}
		
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
		if ($sPlugin = Phpfox_Plugin::get('theme.service_process__call'))
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