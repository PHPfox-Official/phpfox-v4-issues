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
 * @package  		Module_Admincp
 * @version 		$Id: process.class.php 5143 2013-01-15 14:16:21Z Miguel_Espinoza $
 */
class Admincp_Service_Module_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('module');
	}
	
	/**
	 * @todo Look into adding back the is_dir() check
	 *
	 * @param unknown_type $aVals
	 * @return unknown
	 */
	public function add($aVals)
	{
		$sName = strtolower($aVals['module_id']);
		$sName = trim(preg_replace( '/ +/', '-',preg_replace('/[^0-9a-zA-Z_]+/', '', $sName)));
		$iProductId = $aVals['product_id'];		
		
		if (empty($sName))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.module_id_can_only_contain_the_following_characters'));
		}
		
		if (strlen(implode("", array_values($aVals['text']))) == 0)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.provide_information_regarding_module'));
		}

		$aInsert = array(
			'product_id' => $iProductId,
			'module_id' => $sName,
			'is_core' => (isset($aVals['is_core']) ? $aVals['is_core'] : 0),
			'is_active' => 1,
			'is_menu' => $aVals['is_menu']
		);		
		
		$iMenus = 0;
		if (isset($aVals['is_menu']) && $aVals['is_menu'])
		{				
			$sNewMenu = array();
			foreach ($aVals['menu'] as $aMenu)
			{
				if (empty($aMenu['phrase']))
				{
					continue;
				}		
				
				$iMenus++;	
			
				$sPhrase = Phpfox::getService('language.phrase.process')->add(array(
						'var_name' => 'admin_menu_' . $aMenu['phrase'],
						'product_id' => $iProductId,
						'module' => $sName . '|' . $sName,
						'text' => array(
							'en' => $aMenu['phrase']
						)
					)
				);
				
				$sNewMenu[$sPhrase] = array(
					'url' => Phpfox::getLib('url')->makeReverseUrl($aMenu['link'])
				);
			}			
		}
		
		Phpfox::getService('language.phrase.process')->add(array(
				'var_name' => 'module_' . $sName,
				'product_id' => $iProductId,
				'module' => $sName . '|' . $sName,
				'text' => $aVals['text']
			)
		);		
		
		$aInsert['phrase_var_name'] = 'module_' . $sName;
		if ($iMenus)
		{
			$aInsert['menu'] = serialize($sNewMenu);
		}
		
		$this->database()->insert($this->_sTable, $aInsert);
		
		Phpfox::getService('log.staff')->add('module', 'add', array(
				'name' => $sName
			)
		);		
		
		$this->cache()->remove();
		
		return $sName;
	}
	
	public function update($iId, $aVals)
	{	
		$sName = strtolower($aVals['module_id']);
		$sName = trim(preg_replace( '/ +/', '-',preg_replace('/[^0-9a-zA-Z_]+/', '', $sName)));
		$iProductId = $aVals['product_id'];		
		
		if (empty($sName))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.module_id_can_only_contain_the_following_characters'));
		}
		
		if (strlen(implode("", array_values($aVals['text']))) == 0)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.provide_information_regarding_module'));
		}		
		
		$iMenus = 0;
		if (isset($aVals['is_menu']) && $aVals['is_menu'] && isset($aVals['menu']) && count($aVals['menu']))
		{				
			$sNewMenu = array();
			foreach ($aVals['menu'] as $aMenu)
			{
				if (empty($aMenu['phrase']))
				{
					continue;
				}						
				
				$iMenus++;

				if (isset($aMenu['phrase_var']) && Phpfox::getService('language.phrase')->isPhrase(array('module' => $sName . '|' . $sName, 'var_name' => $aMenu['phrase_var'])))	
				{
					$aMenu['text'] = array(Phpfox::getLib('locale')->getLangId() => $aMenu['phrase']);
					
					$sPhrase = $sName . '.' . $aMenu['phrase_var'];
					
					Phpfox::getService('language.phrase.process')->updateVarName(Phpfox::getLib('locale')->getLangId(), $sPhrase, $aMenu['phrase']);										
				}
				else 
				{					
					$sPhrase = Phpfox::getService('language.phrase.process')->add(array(
							'var_name' => 'admin_menu_' . strtolower($aMenu['phrase']),
							'product_id' => $iProductId,
							'module' => $sName . '|' . $sName,
							'text' => array(
								'en' => $aMenu['phrase']
							)
						)
					);
				}
				
				$sNewMenu[$sPhrase] = array(
					'url' => Phpfox::getLib('url')->makeReverseUrl($aMenu['link'])
				);				
			}			
		}		
		
		if (Phpfox::getService('language.phrase')->isPhrase(array('module' => $sName . '|' . $sName, 'var_name' => 'module_' . $sName)))
		{
			foreach ($aVals['text'] as $sLang => $sValue)
			{
				Phpfox::getService('language.phrase.process')->updateVarName($sLang, $sName . '.' . 'module_' . $sName, $sValue, (isset($aVals['text_default']) ? true : false));
			}
		}
		else 
		{		
			Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => 'module_' . $sName,
					'product_id' => $iProductId,
					'module_id' => $sName . '|' . $sName,
					'text' => $aVals['text']
				)
			);		
		}		
		
		$aVals['phrase_var_name'] = 'module_' . $sName;
		if ($iMenus)
		{
			$aVals['menu'] = serialize($sNewMenu);
		}		
		else 
		{
			unset($aVals['menu']);
		}
		
		$this->database()->process(array(
			'product_id',
			'module_id',
			'is_core' => 'int',
			'is_menu' => 'int',
			'menu' => 'null',
			'phrase_var_name' => 'null'
		), $aVals)->update($this->_sTable, "module_id = '" . $this->database()->escape($iId) . "'");		
		
		Phpfox::getService('log.staff')->add('module', 'update', array(
				'module_id' => $iId
			)
		);
		
		$this->cache()->remove();
		
		return true;
	}
	
	public function updateActive($aVals)
	{		
		foreach ($aVals as $iId => $aVal)
		{
			if (isset($aVal['is_active']) && ($bReturn = Phpfox::getLib('module')->initMethod($iId, 'requirementCheck')) === false)
			{
				return false;
			}
			
			$this->database()->update($this->_sTable, array('is_active' => (isset($aVal['is_active']) ? 1 : 0)), "module_id = '" . $this->database()->escape($iId) . "'");
		}
		
		Phpfox::getService('log.staff')->add('module_activity', 'update');		
		
		$this->cache()->remove();
		
		return true;
	}
	
	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
		
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_module_process_updateactivity')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		
		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'module_id = \'' . $this->database()->escape($iId) . '\'');
		
		$this->cache()->remove();
	}		
	
	public function delete($iId)
	{		
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_module_process_delete')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		$aRow = $this->database()->select('*')
			->from($this->_sTable)
			->where("module_id = '" . $iId . "'")
			->execute('getRow');
			
		if (!isset($aRow['module_id']))
		{
			return false;
		}
		
		// Process mass action and connect with other modules to delete
		Phpfox::getService('admincp.module.process')->mass('admincp_module_delete', $aRow['module_id']);

		$oLanguagePhraseProcess = Phpfox::getService('language.phrase.process');
		
		if ($aRow['menu'])
		{
			$aMenus = unserialize($aRow['menu']);
			foreach ($aMenus as $sName => $aMenu)
			{
				$aParts = explode('.', $sName);
				$oLanguagePhraseProcess->delete($sName, true);
			}	
		}		

		/*
		$aBlocks = $this->database()->select('block_id')
			->from(Phpfox::getT('block'))
			->where("module_id = '" . $aRow['module_id'] . "'")
			->execute('getRows');
		foreach ($aBlocks as $aBlock)
		{
			$this->database()->delete(Phpfox::getT('block_source'), 'block_id = ' . $aBlock['block_id']);
		}		
		$this->database()->delete(Phpfox::getT('block'), "module_id = '" . $aRow['module_id'] . "'");
		*/
		
		$this->database()->delete($this->_sTable, "module_id = '" . $aRow['module_id'] . "'");				
		
		$oLanguagePhraseProcess->delete($aRow['module_id'] . '.' . $aRow['phrase_var_name'], true);
		
		Phpfox::getService('log.staff')->add('module', 'delete', array(
				'module_id' => $iId
			)
		);		
		
		$sFile = PHPFOX_DIR_MODULE . $aRow['module_id'] . PHPFOX_DIR_MODULE_XML . PHPFOX_DS . 'phpfox' . PHPFOX_XML_SUFFIX;
		if (file_exists($sFile))
		{
			$aModule = Phpfox::getLib('xml.parser')->parse($sFile);		
			if (isset($aModule['tables']))
			{
				$aTables = array();
				$aCache = unserialize(trim($aModule['tables']));			
				foreach ($aCache as $sKey => $aData)
				{
					$sKey = preg_replace('#phpfox_#i', Phpfox::getParam(array('db', 'prefix')), $sKey);
					
					$aTables[] = $sKey;
				}	
	
				if (count($aTables))
				{
					Phpfox::getLib('database')->dropTables($aTables);
				}
			}
		}
		
		$this->cache()->remove();
		
		return true;	
	}
	
	public function deleteMenu($iId, $sPhrase)
	{
		$aRow = $this->database()->select('menu')
			->from($this->_sTable)
			->where("module_id = '" . $iId . "'")
			->execute('getRow');
			
		if (!isset($aRow['menu']))
		{
			return false;
		}
		
		$aMenus = unserialize($aRow['menu']);
		
		$aNew = array();
		foreach ($aMenus as $sName => $aMenu)
		{
			if ($sName == $iId . '.' . $sPhrase)
			{
				continue;
			}
			$aNew[$sName] = $aMenu;
		}

		$this->database()->update($this->_sTable, array('menu' => (count($aNew) ? serialize($aNew) : null)), "module_id = '" . $iId . "'");
		
		Phpfox::getService('language.phrase.process')->delete($iId . '.' . $sPhrase, true);
		
		Phpfox::getService('log.staff')->add('module_menu', 'delete', array(
				'module_id' => $iId
			)
		);			
		
		$this->cache()->remove();
		
		return true;
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		if ($bMissingOnly)
		{
			$aModules = array();
			$aRows = $this->database()->select('name')
				->from($this->_sTable)
				->execute('getRows', array(
					'free_result' => true
				));
			foreach ($aRows as $aRow)
			{
				$aModules[$aRow['name']] = $aRow['name'];
			}
			
			$aSql = array();
			foreach ($aVals['module'] as $aValue)
			{
				if (in_array($aValue['name'], $aModules))
				{
					continue;
				}
				
				$aSql[] = array(
					'phpfox',
					$aValue['name'],
					$aValue['is_core'],
					$aValue['is_active'],
					$aValue['is_menu'],
					(empty($aValue['value']) ? null : $aValue['value']),
					$aValue['phrase_var_name']
				);
			}	
			
			if ($aSql)
			{
				$this->database()->multiInsert($this->_sTable, array(
					'product_id',
					'name',
					'is_core',
					'is_active',
					'is_menu',
					'menu',
					'phrase_var_name'
				), $aSql);				
			}			
		}
		else 
		{
			$aSql = array();
			foreach ($aVals['module'] as $aValue)
			{
				$aSql[] = array(
					'phpfox',
					$aValue['name'],
					$aValue['is_core'],
					$aValue['is_active'],
					$aValue['is_menu'],
					(empty($aValue['value']) ? null : $aValue['value']),
					$aValue['phrase_var_name']
				);
			}
			
			$this->database()->multiInsert($this->_sTable, array(
				'product_id',
				'name',
				'is_core',
				'is_active',
				'is_menu',
				'menu',
				'phrase_var_name'
			), $aSql);								
		}
		
		Phpfox::getService('log.staff')->add('module', 'import');			
		
		return true;
	}
	
	public function processInstall($sProduct, $aFiles, $mOverwrite = null)
	{
		$iInstalled = 0;
		
		foreach ($aFiles as $iKey => $aFile)
		{
			if ($aFile['installed'] == 'false')
			{
				$aParams = Phpfox::getLib('xml.parser')->parse(file_get_contents(PHPFOX_DIR_MODULE . $iKey . PHPFOX_DS . 'phpfox.xml'));

				if ($mOverwrite !== null && $aFile['table'] == 'true')
				{
					// $this->delete($aParams['data']['module_id']);		
				}
				
				$this->install($aParams['data']['module_id'], ($aFile['table'] == 'true' ? array('table' => true, 'insert' => true) : array('insert' => true)), $sProduct, $aParams);	
				
				$aFiles[$iKey]['installed'] = 'true';
				
				$iInstalled++;
				
				break;
			}
		}		
		
		if (!$iInstalled)
		{
			Phpfox::getLib('cache')->unlock();
			Phpfox::getLib('cache')->remove();
		}
		
		return ($iInstalled ? $aFiles : true);
	}
	
	/**
	 * @todo Memory usage. Way too much memory being used here.
	 *
	 * @param unknown_type $sModule
	 * @param unknown_type $aParams
	 * @return unknown
	 */
	public function install($sModule = null, $aParams = array(), $sProduct = 'phpfox', &$aModule = null)
	{		
		$bUpgradeCheck = (defined('PHPFOX_PRODUCT_UPGRADE_CHECK') ? true : false);
		
		if ($aModule === null)
		{			
			$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_XML . PHPFOX_DS . 'phpfox' . PHPFOX_XML_SUFFIX;
			if (!file_exists($sFile))
			{
				return false;
			}		
			$aModule = Phpfox::getLib('xml.parser')->parse($sFile);						
			
			if (!isset($aModule['data']['module_id']))
			{
				return false;
			}
			
			if ($aModule['data']['module_id'] != $sModule)
			{
				return false;
			}
		}		
		
		if (isset($aParams['table']))
		{
			if (isset($aModule['tables']))
			{
				$oPhpfoxDatabaseExport = Phpfox::getLib('database.support');
				$aTables = unserialize(trim($aModule['tables']));		
				$sQueries = Phpfox::getLib('database.export')->process(Phpfox::getParam(array('db', 'driver')), $aTables);
				$aDriver = $oPhpfoxDatabaseExport->getDriver(Phpfox::getParam(array('db', 'driver')));
				
				$sQueries = preg_replace('#phpfox_#i', Phpfox::getParam(array('db', 'prefix')), $sQueries);
					
				if ($aDriver['comments'] == 'remove_comments')
				{
					$oPhpfoxDatabaseExport->removeComments($sQueries);
				}
				else 
				{
					$oPhpfoxDatabaseExport->removeRemarks($sQueries);
				}
					
				$aSql = $oPhpfoxDatabaseExport->splitSqlFile($sQueries, $aDriver['delim']);		
				
				foreach ($aSql as $sSql)
				{
					$sSql = preg_replace('/CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $sSql);
					
					$this->database()->query($sSql);
				}			
			}				
			
			$bSkipInstallTable = false;
			if ($bUpgradeCheck)
			{
				if ($this->database()->select('COUNT(*)')->from($this->_sTable)->where('module_id = \'' . $aModule['data']['module_id'] . '\'')->execute('getField'))
				{
					$bSkipInstallTable = true;	
				}
			}
				
			if ($bSkipInstallTable === false)
			{
				$this->database()->insert($this->_sTable, array(
						'module_id' => $aModule['data']['module_id'],
						'product_id' => $sProduct,
						'is_core' => $aModule['data']['is_core'],
						'is_active' => 1,
						'is_menu' => $aModule['data']['is_menu'],
						'menu' => $aModule['data']['menu'],
						'phrase_var_name' => $aModule['data']['phrase_var_name']
					)
				);
			}			
			else{
				// update
				$this->database()->update($this->_sTable,array(
					'module_id' => $aModule['data']['module_id'],
						'product_id' => $sProduct,
						'is_core' => $aModule['data']['is_core'],
						'is_active' => 1,
						'is_menu' => $aModule['data']['is_menu'],
						'menu' => $aModule['data']['menu'],
						'phrase_var_name' => $aModule['data']['phrase_var_name']
				),
						'module_id = "' . $aModule['data']['module_id'] . '" AND product_id = "' . $sProduct .'"');
			}
		}
		
		if (isset($aParams['post_install']))
		{			
			$sFile = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DIR_MODULE_XML . PHPFOX_DS . 'phpfox' . PHPFOX_XML_SUFFIX;			
			$aModule = Phpfox::getLib('xml.parser')->parse($sFile);			
			
			if (isset($aModule['install']))
			{
				eval($aModule['install']);
			}			
		}

		if (isset($aParams['insert']))
		{			
			if (isset($aModule['settings']))
			{				
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('setting_id, var_name')
						->from(Phpfox::getT('setting'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['var_name']] = $aCacheRow;
					}
				}
				
				$aRows = (isset($aModule['settings']['setting'][1]) ? $aModule['settings']['setting'] : array($aModule['settings']['setting']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['var_name']]))
					{
						$this->database()->update(Phpfox::getT('setting'), array(
								'group_id' => (empty($aRow['group']) ? null : $aRow['group']),
								'type_id' => $aRow['type'],
								'phrase_var_name' => $aRow['phrase_var_name'],
								'value_default' => $aRow['value'],
								'ordering' => $aRow['ordering']
							), 'setting_id = ' . (int) $aCacheCheck[$aRow['var_name']]['setting_id']
						);
						
						continue;
					}					
				
					$this->database()->insert(Phpfox::getT('setting'), array(
							'group_id' => (empty($aRow['group']) ? null : $aRow['group']),
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'is_hidden' => $aRow['is_hidden'],
							'version_id' => $aRow['version_id'],
							'type_id' => $aRow['type'],
							'var_name' => $aRow['var_name'],
							'phrase_var_name' => $aRow['phrase_var_name'],
							'value_actual' => $aRow['value'],
							'value_default' => $aRow['value'],
							'ordering' => $aRow['ordering']
						)
					);					
				}				
			}
			
			if (isset($aModule['setting_groups']))
			{				
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('var_name')
						->from(Phpfox::getT('setting_group'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['var_name']] = true;
					}
				}				
				
				$aRows = (isset($aModule['setting_groups']['name'][1]) ? $aModule['setting_groups']['name'] : array($aModule['setting_groups']['name']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['var_name']]))
					{						
						continue;
					}							
					
					$this->database()->insert(Phpfox::getT('setting_group'), array(
							'group_id' => $aRow['value'],
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'version_id' => $aRow['version_id'],
							'var_name' => $aRow['var_name']	
						)
					);
				}
			}	
			
			if (isset($aModule['phrases']))
			{				
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('phrase_id, var_name, text_default')
						->from(Phpfox::getT('language_phrase'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['var_name']] = $aCacheRow;
					}
				}					
				
				$aRows = (isset($aModule['phrases']['phrase'][1]) ? $aModule['phrases']['phrase'] : array($aModule['phrases']['phrase']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['var_name']]))
					{						
						if ($aCacheCheck[$aRow['var_name']]['text_default'] != $aRow['value'])
						{
							$this->database()->update(Phpfox::getT('language_phrase'), array(
									'text_default' => $aRow['value']
								), 'phrase_id = ' . (int) $aCacheCheck[$aRow['var_name']]['phrase_id']
							);							
						}
						
						continue;
					}					
					
					$this->database()->insert(Phpfox::getT('language_phrase'), array(
							'language_id' => 'en',
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'version_id' => $aRow['version_id'],
							'var_name' => $aRow['var_name'],
							'text' => $aRow['value'],
							'text_default' => $aRow['value'],
							'added' => $aRow['added']
						)
					);
				}
			}			
			
			if (isset($aModule['menus']))
			{				
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('menu_id, var_name')
						->from(Phpfox::getT('menu'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['var_name']] = $aCacheRow;
					}
				}					
				
				$aRows = (isset($aModule['menus']['menu'][1]) ? $aModule['menus']['menu'] : array($aModule['menus']['menu']));
				/* In this array we store the previous parent_ids to convert to the newly inserted parent_ids*/
				$aParents = array();
				for ($iCycle = 0; $iCycle <= 1; $iCycle++)
				{
					foreach ($aRows as $aRow)
					{
						/* Menu has a parent but we havent added the parent yet */
						/* Make sure no wrong connections are added*/
						if (empty($aRow['m_connection']))
						{
							$aRow['m_connection'] = null;
						}
						/* Just safety */
						if (!isset($aRow['parent_id']))
						{
							$aRow['parent_id'] = 0;
						}

						if (!isset($aRow['parent_var_name']))
						{
							$aRow['parent_var_name'] = '';
						}

						if ($iCycle == 0 && !empty($aRow['parent_var_name']))
						{
							continue;
						}

						if ($iCycle == 1 && empty($aRow['parent_var_name']))
						{
							continue;
						}			

						if ($iCycle == 1 && !empty($aRow['parent_var_name']))
						{
							$aDbMenu = $this->database()->select('*')
									->from(Phpfox::getT('menu'))
									->where('var_name = "' . Phpfox::getLib('parse.input')->clean($aRow['parent_var_name']) . '"')
									->execute('getSlaveRow');						

							if (isset($aDbMenu['menu_id']))
							{
								$aRow['parent_id'] = $aDbMenu['menu_id'];
							}
						}

						if ($bUpgradeCheck && isset($aCacheCheck[$aRow['var_name']]))
						{
							$this->database()->update(Phpfox::getT('menu'), array(
									'parent_id' => (int) $aRow['parent_id'],
									'm_connection' => $aRow['m_connection'],
									'var_name' => $aRow['var_name'],
									'url_value' => (empty($aRow['url_value']) ? null : $aRow['url_value'])
								), 'menu_id = ' . (int) $aCacheCheck[$aRow['var_name']]['menu_id']
							);

							continue;
						}
						
						$aMenuUpdate = array(
								'parent_id' => (int) $aRow['parent_id'],
								'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
								'product_id' => $sProduct,
								'm_connection' => $aRow['m_connection'],
								'var_name' => $aRow['var_name'],
								'ordering' => $aRow['ordering'],
								'url_value' => (empty($aRow['url_value']) ? null : $aRow['url_value']),
								'version_id' => $aRow['version_id'],
								'disallow_access' => (empty($aRow['disallow_access']) ? null : $aRow['disallow_access']),
								'is_active' => 1								
							);
						
						if ($this->database()->isField(Phpfox::getT('menu'), 'mobile_icon'))
						{
							$aMenuUpdate['mobile_icon'] = (empty($aRow['mobile_icon']) ? null : $aRow['mobile_icon']);
						}

						$iNewParentId = $this->database()->insert(Phpfox::getT('menu'), $aMenuUpdate);					
					}
				} /* end for cycle*/
			}
			
			if (isset($aModule['user_group_settings']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('setting_id, name')
						->from(Phpfox::getT('user_group_setting'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['name']] = $aCacheRow;
					}
				}				
				
				$aRows = (isset($aModule['user_group_settings']['setting'][1]) ? $aModule['user_group_settings']['setting'] : array($aModule['user_group_settings']['setting']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['value']]))
					{						
						$this->database()->update(Phpfox::getT('user_group_setting'), array(
								'is_hidden' => (isset($aRow['is_hidden']) ? (int) $aRow['is_hidden'] : 0),
								'is_admin_setting' => $aRow['is_admin_setting'],
								'name' => $aRow['value'],
								'type_id' => $aRow['type'],
								'default_admin' => $aRow['admin'],
								'default_user' => $aRow['user'],
								'default_guest' => $aRow['guest'],
								'default_staff' => $aRow['staff'],
								'ordering' => $aRow['ordering']
							), 'setting_id = ' . (int) $aCacheCheck[$aRow['value']]['setting_id']
						);		
						
						continue;
					}						
					
					$this->database()->insert(Phpfox::getT('user_group_setting'), array(							
							'is_admin_setting' => $aRow['is_admin_setting'],
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'name' => $aRow['value'],
							'type_id' => $aRow['type'],
							'default_admin' => $aRow['admin'],
							'default_user' => $aRow['user'],
							'default_guest' => $aRow['guest'],
							'default_staff' => $aRow['staff'],
							'ordering' => $aRow['ordering']
						)
					);
				}				
			}
			
			if (isset($aModule['hooks']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('hook_id, call_name')
						->from(Phpfox::getT('plugin_hook'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['call_name']] = $aCacheRow;
					}
				}				
				
				$aRows = (isset($aModule['hooks']['hook'][1]) ? $aModule['hooks']['hook'] : array($aModule['hooks']['hook']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['call_name']]))
					{											
						continue;
					}					
					
					$this->database()->insert(Phpfox::getT('plugin_hook'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'hook_type' => $aRow['hook_type'],
							'call_name' => $aRow['call_name'],
							'added' => (int) $aRow['added'],
							'version_id' => (empty($aRow['version_id']) ? null : $aRow['version_id']),
							'is_active' => 1
						)
					);
				}				
			}			
			
			if (isset($aModule['plugins']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('plugin_id, call_name')
						->from(Phpfox::getT('plugin'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['call_name']] = $aCacheRow;
					}
				}					
				
				$aRows = (isset($aModule['plugins']['plugin'][1]) ? $aModule['plugins']['plugin'] : array($aModule['plugins']['plugin']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['call_name']]))
					{						
						$this->database()->update(Phpfox::getT('plugin'), array(
								'title' => $aRow['title'],
								'php_code' => str_replace('\\','\\\\',$aRow['value'])
							), 'plugin_id = ' . (int) $aCacheCheck[$aRow['call_name']]['plugin_id']
						);
						
						continue;
					}						
					
					$this->database()->insert(Phpfox::getT('plugin'), array(
							'module_id' => ($sModule === null ? (empty($aRow['module_id']) ? null : $aRow['module_id']) : $sModule),
							'product_id' => $sProduct,							
							'call_name' => $aRow['call_name'],
							'title' => $aRow['title'],
							'php_code' => str_replace('\\','\\\\',$aRow['value']),
							'is_active' => 1
						)
					);
				}				
			}			
			
			if (isset($aModule['components']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('component_id, component, m_connection')
						->from(Phpfox::getT('component'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['component'] . $aCacheRow['m_connection']] = $aCacheRow;
					}
				}					
				
				$aRows = (isset($aModule['components']['component'][1]) ? $aModule['components']['component'] : array($aModule['components']['component']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['component'] . $aRow['m_connection']]))
					{						
						$this->database()->update(Phpfox::getT('component'), array(
								'component' => $aRow['component'],
								'm_connection' => $aRow['m_connection'],
								'is_controller' => (int) $aRow['is_controller'],
									'is_block' => (int) $aRow['is_block']								
							), 'component_id = ' . (int) $aCacheCheck[$aRow['component'] . $aRow['m_connection']]['component_id']
						);						
						
						continue;
					}							
					
					$this->database()->insert(Phpfox::getT('component'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'component' => $aRow['component'],
							'm_connection' => $aRow['m_connection'],
							'is_controller' => (int) $aRow['is_controller'],
							'is_block' => (int) $aRow['is_block'],
							'is_active' => (int) $aRow['is_active']
						)
					);
				}				
			}	

			if (isset($aModule['blocks']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('block_id, component, m_connection')
						->from(Phpfox::getT('block'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['component'] . $aCacheRow['m_connection']] = $aCacheRow;
					}
				}					
				
				$aRows = (isset($aModule['blocks']['block'][1]) ? $aModule['blocks']['block'] : array($aModule['blocks']['block']));				
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['component'] . $aRow['m_connection']]))
					{						
						$aBlockSql = array(
							'location' => $aRow['location'],
							'can_move' => (int) $aRow['can_move']
						);
						
						if (!empty($aRow['title']))
						{
							$aBlockSql['title'] = (!empty($aRow['title']) ? $this->preParse()->clean($aRow['title']) : null);
						}
						
						if (isset($aRow['type_id']))
						{
							$aBlockSql['type_id'] = (isset($aRow['type_id']) ? (int) $aRow['type_id'] : 0);
						}
						
						$this->database()->update(Phpfox::getT('block'), $aBlockSql, 'block_id = ' . (int) $aCacheCheck[$aRow['component'] . $aRow['m_connection']]['block_id']);
						
						if (isset($aRow['type_id']) && (int) $aRow['type_id'] > 0)
						{
							$this->database()->update(Phpfox::getT('block_source'), array(
									'source_code' => $aRow['source_code'],
									'source_parsed' => $aRow['source_parsed']
								), 'block_id = ' . (int) $aCacheCheck[$aRow['component'] . $aRow['m_connection']]['block_id']
							);
						}												
						
						continue;
					}					
					
					$aBlockSql = array(
						'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
						'product_id' => $sProduct,												
						'component' => (empty($aRow['component']) ? null : $aRow['component']),
						'm_connection' => $aRow['m_connection'],
						'location' => (int) $aRow['location'],
						'is_active' => (int) $aRow['is_active'],
						'ordering' => (int) $aRow['ordering'],
						'can_move' => (int) $aRow['can_move'],
						'disallow_access' => (empty($aRow['disallow_access']) ? null : $aRow['disallow_access']),
						'version_id' => (empty($aRow['version_id']) ? null : $aRow['version_id'])
					);
					
					if (!empty($aRow['title']))
					{
						$aBlockSql['title'] = (!empty($aRow['title']) ? $this->preParse()->clean($aRow['title']) : null);
					}
					
					if (isset($aRow['type_id']))
					{
						$aBlockSql['type_id'] = (isset($aRow['type_id']) ? (int) $aRow['type_id'] : 0);
					}
					
					$iBlockId = $this->database()->insert(Phpfox::getT('block'), $aBlockSql);
					
					if (isset($aRow['type_id']) && (int) $aRow['type_id'] > 0)
					{
						$this->database()->insert(Phpfox::getT('block_source'), array(
								'block_id' => $iBlockId,
								'source_code' => $aRow['source_code'],
								'source_parsed' => $aRow['source_parsed']
							)
						);
					}
				}				
			}		
			
			if (isset($aModule['crons']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('php_code')
						->from(Phpfox::getT('cron'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[md5($aCacheRow['php_code'])] = true;
					}
				}					
				
				$aRows = (isset($aModule['crons']['cron'][1]) ? $aModule['crons']['cron'] : array($aModule['crons']['cron']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[md5($aRow['value'])]))
					{						
						continue;
					}						
					
					$this->database()->insert(Phpfox::getT('cron'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'php_code' => Phpfox::getLib('parse.format')->phpCode($aRow['value']),
							'type_id' => $aRow['type_id'],
							'every' => $aRow['every'],
							'is_active' => '1'
						)
					);
				}				
			}	
			
			/*
			if (isset($aModule['help']))
			{
				$aRows = (isset($aModule['help']['info'][1]) ? $aModule['help']['info'] : array($aModule['help']['info']));
				foreach ($aRows as $aRow)
				{					
					$this->database()->insert(Phpfox::getT('help'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'var_name' => $aRow['var_name'],
							'added' => $aRow['added']
						)
					);
				}				
			}
			*/	
			
			if (isset($aModule['pages']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('page_id, title_url')
						->from(Phpfox::getT('page'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['title_url']] = $aCacheRow;
					}
				}						
				
				$aRows = (isset($aModule['pages']['page'][1]) ? $aModule['pages']['page'] : array($aModule['pages']['page']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['title_url']]))
					{						
						$this->database()->update(Phpfox::getT('page'), array(								
								'is_phrase' => $aRow['is_phrase'],								
								'has_bookmark' => $aRow['has_bookmark'],
								'parse_php' => $aRow['parse_php'],
								'add_view' => $aRow['add_view'],
								'full_size' => $aRow['full_size'],
								'title' => $aRow['title'],
								'title_url' => $aRow['title_url']								
							), 'page_id = ' . (int) $aCacheCheck[$aRow['title_url']]['page_id']
						);
						
						$this->database()->update(Phpfox::getT('page_text'), array(
								'keyword' => (empty($aRow['keyword']) ? null : $aRow['keyword']),
								'description' => (empty($aRow['description']) ? null : $aRow['description']),
								'text' => $aRow['text'],
								'text_parsed' => $aRow['text_parsed']
							), 'page_id = ' . (int) $aCacheCheck[$aRow['title_url']]['page_id']
						);							
						
						continue;
					}						
					
					$iPageId = $this->database()->insert(Phpfox::getT('page'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'is_phrase' => $aRow['is_phrase'],
							'product_id' => $sProduct,
							'is_active' => 1,
							'has_bookmark' => $aRow['has_bookmark'],
							'parse_php' => $aRow['parse_php'],
							'add_view' => $aRow['add_view'],
							'full_size' => $aRow['full_size'],
							'title' => $aRow['title'],
							'title_url' => $aRow['title_url'],
							'added' => $aRow['added']
						)
					);
					
					$this->database()->insert(Phpfox::getT('page_text'), array(
							'page_id' => $iPageId,
							'keyword' => (empty($aRow['keyword']) ? null : $aRow['keyword']),
							'description' => (empty($aRow['description']) ? null : $aRow['description']),
							'text' => $aRow['text'],
							'text_parsed' => $aRow['text_parsed']
						)
					);					
				}				
			}			
			
			if (isset($aModule['custom_group']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('phrase_var_name')
						->from(Phpfox::getT('custom_group'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['phrase_var_name']] = true;
					}
				}				
				
				$aRows = (isset($aModule['custom_group']['group'][1]) ? $aModule['custom_group']['group'] : array($aModule['custom_group']['group']));
				$aCustomGroupCache = array();
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['phrase_var_name']]))
					{						
						continue;
					}						
					
					$aCustomGroupCache[$aRow['phrase_var_name']] = $this->database()->insert(Phpfox::getT('custom_group'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'type_id' => $aRow['type_id'],					
							'phrase_var_name' => $aRow['phrase_var_name'],
							'is_active' => $aRow['is_active'],
							'ordering' => $aRow['ordering']
						)
					);					
				}
			}

			if (isset($aModule['custom_field']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('phrase_var_name')
						->from(Phpfox::getT('custom_field'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['phrase_var_name']] = true;
					}
				}					
				
				$aRows = (isset($aModule['custom_field']['field'][1]) ? $aModule['custom_field']['field'] : array($aModule['custom_field']['field']));				
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['phrase_var_name']]))
					{						
						continue;
					}						
					
					$iFieldId = $this->database()->insert(Phpfox::getT('custom_field'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'group_id' => (isset($aCustomGroupCache[$aRow['group_name']]) ? (int) $aCustomGroupCache[$aRow['group_name']] : 0),
							'field_name' => $aRow['field_name'],
							'module_id' => $aRow['module_id'],				
							'type_id' => $aRow['type_id'],					
							'phrase_var_name' => $aRow['phrase_var_name'],
							'type_name' => $aRow['type_name'],
							'var_type' => $aRow['var_type'],
							'is_active' => 1,
							'is_required' => $aRow['is_required'],
							'ordering' => $aRow['ordering']		
						)
					);
					
					if (!empty($aRow['value']))
					{
						$aOptions = unserialize($aRow['value']);
						foreach ($aOptions as $aOption)
						{
							$this->database()->insert(Phpfox::getT('custom_option'), array('field_id' => $iFieldId, 'phrase_var_name' => $aOption['phrase_var_name']));
						}
					}

					if (!$this->database()->isField(Phpfox::getT('user_custom'), Phpfox::getService('custom')->getAlias() . $aRow['field_name']))
					{
						$this->database()->addField(array(
								'table' => Phpfox::getT('user_custom'),
								'field' => Phpfox::getService('custom')->getAlias() . $aRow['field_name'],
								'type' => $aRow['type_name']
							)
						);
					}
					if (!$this->database()->isField(Phpfox::getT('user_custom_value'), Phpfox::getService('custom')->getAlias() . $aRow['field_name']))
					{
						$this->database()->addField(array(
								'table' => Phpfox::getT('user_custom_value'),
								'field' => Phpfox::getService('custom')->getAlias() . $aRow['field_name'],
								'type' => $aRow['type_name']
							)
						);
					}
				}
			}
			
			if (isset($aModule['reports']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('message')
						->from(Phpfox::getT('report'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['message']] = true;
					}
				}					
				
				$aRows = (isset($aModule['reports']['report'][1]) ? $aModule['reports']['report'] : array($aModule['reports']['report']));
				$aInserted = array();
				foreach ($aRows as $aRow)
				{					
					if ( ($bUpgradeCheck && isset($aCacheCheck[$aRow['value']])) || (isset($aInserted[md5(serialize($aRow))])))
					{						
						continue;
					}						
					$aInserted[md5(serialize($aRow))] = true;
					$this->database()->insert(Phpfox::getT('report'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'message' => $aRow['value']							
						)
					);
				}				
			}		
			
			if (isset($aModule['stats']))
			{
				if ($bUpgradeCheck)
				{
					$aCacheCheck = array();
					$aCacheRows = $this->database()->select('stat_id, phrase_var')
						->from(Phpfox::getT('site_stat'))
						->where('module_id = \'' . $this->database()->escape(($sModule === null ? $aRow['module_id'] : $sModule)) . '\'')
						->execute('getRows');
					foreach ($aCacheRows as $aCacheRow)
					{
						$aCacheCheck[$aCacheRow['phrase_var']] = $aCacheRow;
					}
				}					
				
				$aRows = (isset($aModule['stats']['stat'][1]) ? $aModule['stats']['stat'] : array($aModule['stats']['stat']));
				foreach ($aRows as $aRow)
				{					
					if ($bUpgradeCheck && isset($aCacheCheck[$aRow['phrase_var']]))
					{						
						$this->database()->update(Phpfox::getT('site_stat'), array(								
								'phrase_var' => $aRow['phrase_var'],
								'php_code' => $aRow['value'],
								'stat_link' => $aRow['stat_link'],
								'stat_image' => $aRow['stat_image']								
							), 'stat_id = ' . (int) $aCacheCheck[$aRow['phrase_var']]['stat_id']
						);						
					
						continue;
					}						
					
					$this->database()->insert(Phpfox::getT('site_stat'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'phrase_var' => $aRow['phrase_var'],
							'php_code' => $aRow['value'],
							'stat_link' => $aRow['stat_link'],
							'stat_image' => $aRow['stat_image'],
							'is_active' => $aRow['is_active'],
							'ordering' => '0'							
						)
					);
				}				
			}	
			
			if ($sModule !== null)
			{
				$aModuleCallback = Phpfox::massCallback('installModule', $sProduct, $sModule, $aModule);
			}
			
			if (defined('PHPFOX_UPGRADE_MODULE_XML'))
			{
				// phpfox_update_settings
				if (isset($aModule['phpfox_update_settings']))
				{
					$aRows = (isset($aModule['phpfox_update_settings']['setting'][1]) ? $aModule['phpfox_update_settings']['setting'] : array($aModule['phpfox_update_settings']['setting']));
					foreach ($aRows as $aRow)
					{					
						$this->database()->update(Phpfox::getT('setting'), array(
								'group_id' => (empty($aRow['group']) ? null : $aRow['group']),
								'is_hidden' => $aRow['is_hidden'],
								'type_id' => $aRow['type'],
								'value_actual' => $aRow['value'],
								'value_default' => $aRow['value'],
								'ordering' => $aRow['ordering']
							), 'module_id = \'' . ($sModule === null ? $aRow['module_id'] : $sModule) . '\' AND var_name = \'' . $aRow['var_name'] . '\''
						);
					}					
				}
				
				// phpfox_update_blocks
				if (isset($aModule['phpfox_update_blocks']))
				{
					$aRows = (isset($aModule['phpfox_update_blocks']['block'][1]) ? $aModule['phpfox_update_blocks']['block'] : array($aModule['phpfox_update_blocks']['block']));
					foreach ($aRows as $aRow)
					{					
						$this->database()->update(Phpfox::getT('block'), array(
								'is_active' => $aRow['is_active'],
								'can_move' => $aRow['can_move'],
								'title' => $aRow['title'],
								'ordering' => $aRow['ordering']
							), 'm_connection = \'' . $aRow['m_connection'] . '\' AND module_id = \'' . ($sModule === null ? $aRow['module_id'] : $sModule) . '\' AND component = \'' . $aRow['component'] . '\''
						);
					}					
				}				
				
				// phpfox_update_rss
				if (isset($aModule['phpfox_update_rss']))
				{
					$aRows = (isset($aModule['phpfox_update_rss']['feed'][1]) ? $aModule['phpfox_update_rss']['feed'] : array($aModule['phpfox_update_rss']['feed']));
					foreach ($aRows as $aRow)
					{					
						$this->database()->update(Phpfox::getT('rss'), array(
								'php_view_code' => $aRow['php_view_code']
							), 'module_id = \'' . ($sModule === null ? $aRow['module_id'] : $sModule) . '\' AND title_var = \'' . $aRow['title_var'] . '\''
						);
					}					
				}				
				
				if (isset($aModule['phpfox_update_phrases']))
				{
					$aRows = (isset($aModule['phpfox_update_phrases']['phrase'][1]) ? $aModule['phpfox_update_phrases']['phrase'] : array($aModule['phpfox_update_phrases']['phrase']));
					foreach ($aRows as $aRow)
					{
						$this->database()->update(Phpfox::getT('language_phrase'), array(
								'text' => $aRow['value'],
								'text_default' => $aRow['value']								
							), 'language_id = \'en\' AND module_id = \'' . ($sModule === null ? $aRow['module_id'] : $sModule) . '\' AND var_name = \'' . $aRow['var_name'] . '\''
						);						
					}
				}				
				
				if (isset($aModule['phpfox_update_menus']))
				{
					$aRows = (isset($aModule['phpfox_update_menus']['menu'][1]) ? $aModule['phpfox_update_menus']['menu'] : array($aModule['phpfox_update_menus']['menu']));
					foreach ($aRows as $aRow)
					{
						$this->database()->update(Phpfox::getT('menu'), array(
								'm_connection' => $aRow['m_connection'],
								'ordering' => $aRow['ordering'],
								'url_value' => (empty($aRow['url_value']) ? null : $aRow['url_value']),
								'disallow_access' => (empty($aRow['disallow_access']) ? null : $aRow['disallow_access'])
							), 'module_id = \'' . ($sModule === null ? $aRow['module_id'] : $sModule) . '\' AND var_name = \'' . $aRow['var_name'] . '\''
						);						
					}
				}				
			}			
		}
	
		return true;
	}

	public function mass()
	{
		$aArgs = func_get_args();
		$sAction = $aArgs[0];
		$aParams = array();		
		for ($i = 1; $i <= (func_num_args() - 1); $i++)
		{
			$aParams[] = $aArgs[$i];
		}

		foreach (Phpfox::getLib('module')->getModules() as $sModule)
		{
			$sCallBack = PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_SERVICE . PHPFOX_DS . 'callback.class.php';
			if (file_exists($sCallBack))
			{
				require_once($sCallBack);
				$sClass = $sModule . '_Service_Callback';
				$sMethod = 'mass' . str_replace('_', '', $sAction);
				$oObject[$sClass] = new $sClass();
				if (is_object($oObject[$sClass]) && method_exists($oObject[$sClass], $sMethod))
				{
					$sEval = 'call_user_func(array($oObject[$sClass], $sMethod)';
					if (count($aParams))
					{
						foreach ($aParams as $mParam)
						{
							$sEval .= ', ' . var_export($mParam, true) . '';
						}
					}
					$sEval .= ');';
					eval($sEval);					
				}				
			}
		}
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_module_process___call'))
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