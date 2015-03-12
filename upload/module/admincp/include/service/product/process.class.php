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
 * @version 		$Id: process.class.php 5185 2013-01-23 10:33:47Z Miguel_Espinoza $
 */
class Admincp_Service_Product_Process extends Phpfox_Service 
{
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('product');
	}
	
	public function add($aVals, $bIsUpdate = false)
	{
		$sName = $this->_clean($aVals['product_id']);

		if ($bIsUpdate === false && $this->_isProduct($sName))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_name_is_not_valid'));
		}		
		
		$aFields = array(
			'product_id',
			'title',
			'description',
			'version',
			'is_active' => 'int',
			'url',
			'url_version_check'
		);
		
		if ($bIsUpdate)
		{
			// Remove product_id
			unset($aFields[0]);

			$this->database()->process($aFields, $aVals)->update($this->_sTable, "product_id = '" . $this->database()->escape($aVals['product_id']) . "'");
		}
		else 
		{
			$this->database()->process($aFields, $aVals)->insert($this->_sTable);
		}		
		
		$this->cache()->remove();
		
		return true;
	}
	
	public function update($sProduct, $aVals)
	{
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_product_process_update')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		return $this->add($aVals, true);
	}
	
	public function delete($sProduct)
	{
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_product_process_delete')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		$aProduct = $this->database()->select('*')
			->from($this->_sTable)
			->where('product_id = \'' . $this->database()->escape($sProduct) . '\'')
			->execute('getSlaveRow');
			
		if (!isset($aProduct['product_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.not_a_valid_product_to_upgrade'));
		}		
		
		$aCommands = $this->database()->select('*')
			->from(Phpfox::getT('product_install'))
			->where('product_id = \'' . $this->database()->escape($sProduct) . '\'')
			->order('version ASC')
			->execute('getSlaveRows');		
			
		if (count($aCommands))
		{
			foreach ($aCommands as $aCommand)
			{
				eval($aCommand['uninstall_code']);
			}
		}
		
		// Process mass action and connect with other modules to delete
		Phpfox::getService('admincp.module.process')->mass('admincp_product_delete', $sProduct);
		
		$this->database()->delete($this->_sTable, "product_id = '" . $this->database()->escape($sProduct) . "'");
		$this->database()->delete(Phpfox::getT('product_dependency'), "product_id = '" . $this->database()->escape($sProduct) . "'");
		$this->database()->delete(Phpfox::getT('product_install'), "product_id = '" . $this->database()->escape($sProduct) . "'");
				
		$this->cache()->remove();
		
		return true;	
	}
	
	public function checkProductVersions()
	{
		$aProduct = $this->database()->select('product_id, url_version_check')
			->from(Phpfox::getT('product'))			
			->order('last_check ASC')
			->execute('getRow');
			
		$iVersion = null;
		if (!empty($aProduct['url_version_check']))
		{
			$mData = Phpfox::getLib('request')->send($aProduct['url_version_check']);
			if (is_string($mData) && preg_match('/<phpfox>(.*?)<\/phpfox>/is', $mData))
			{
				$aXml = Phpfox::getLib('xml.parser')->parse($mData);
				if (isset($aXml['product_version']))
				{
					$iVersion = $aXml['product_version'];	
				}
			}
		}
			
		$this->database()->update(Phpfox::getT('product'), array('last_check' => PHPFOX_TIME, 'latest_version' => $iVersion), 'product_id = \'' . $this->database()->escape($aProduct['product_id']) . '\'');
	}
	
	public function addDependency($aVals)
	{		
		if (empty($aVals['product_id']) || empty($aVals['dependency_start']))
		{
			return false;
		}
		
		return $this->database()->process(array(
				'product_id',
				'type_id',
				'check_id',
				'dependency_start',
				'dependency_end'
			), $aVals)->insert(Phpfox::getT('product_dependency'));		
	}	

	public function updateDependency($iId, $aVals)
	{
		return $this->database()->process(array(
				'dependency_start',
				'dependency_end'
			), $aVals)->update(Phpfox::getT('product_dependency'), 'dependency_id = ' . (int) $iId);		
	}	
	
	public function deleteDependency($iId)
	{		
		return $this->database()->delete(Phpfox::getT('product_dependency'), 'dependency_id = ' . (int) $iId);
	}
	
	public function addInstall($aVals)
	{
		if (empty($aVals['product_id']) || empty($aVals['version']) || empty($aVals['install_code']))
		{
			return false;
		}
		
		$aVals['install_code'] = str_replace('\\','\\\\',$aVals['install_code']);
		$aVals['uninstall_code'] = str_replace('\\','\\\\',$aVals['uninstall_code']);
		
		return $this->database()->process(array(
				'product_id',
				'version',
				'install_code',
				'uninstall_code'
			), $aVals)->insert(Phpfox::getT('product_install'));			
	}
	
	public function updateInstall($iId, $aVals)
	{
		$aVals['install_code'] = str_replace('\\','\\\\',$aVals['install_code']);
		$aVals['uninstall_code'] = str_replace('\\','\\\\',$aVals['uninstall_code']);	
		
		return $this->database()->process(array(
				'version',
				'install_code',
				'uninstall_code'
			), $aVals)->update(Phpfox::getT('product_install'), 'install_id = ' . (int) $iId);		
	}
	
	public function deleteInstall($iId)
	{		
		return $this->database()->delete(Phpfox::getT('product_install'), 'install_id = ' . (int) $iId);
	}	
	
	public function updateActive($aVals)
	{
		foreach ($aVals as $iId => $aVal)
		{
			$this->database()->update($this->_sTable, array('is_active' => (isset($aVal['is_active']) ? 1 : 0)), "product_id = '" . $this->database()->escape($iId) . "'");
		}		
		
		$this->cache()->remove();
		
		return true;
	}
	
	public function upgrade($sProductFile)
	{
		$aProduct = $this->database()->select('*')
			->from($this->_sTable)
			->where('product_id = \'' . $this->database()->escape($sProductFile) . '\'')
			->execute('getSlaveRow');
			
		if (!isset($aProduct['product_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.not_a_valid_product_to_upgrade'));
		}
		
		if (!file_exists(PHPFOX_DIR_XML . $sProductFile . '.xml'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.unable_to_find_xml_file_to_import_for_this_product'));
		}		
		
		$aParams = Phpfox::getLib('xml.parser')->parse(file_get_contents(PHPFOX_DIR_XML . $sProductFile . '.xml'));		
		
		if (isset($aParams['modules']['module_id']))
		{
			define('PHPFOX_PRODUCT_UPGRADE_CHECK', true);
			$aModules = (is_array($aParams['modules']['module_id']) ? $aParams['modules']['module_id'] : array($aParams['modules']['module_id']));						
			foreach ($aModules as $sModuleUpdate)
			{
				$aModuleData = Phpfox::getLib('xml.parser')->parse(file_get_contents(PHPFOX_DIR_MODULE . $sModuleUpdate . PHPFOX_DS . 'phpfox.xml'));
				
				Phpfox::getService('admincp.module.process')->install($sModuleUpdate, array('table' => true, 'insert' => true), $aParams['data']['product_id'], $aModuleData);		
			}	
		}		
		
		$iLastVersion = $aProduct['version'];
		if (isset($aParams['installs']))
		{
			$aInstalls = (isset($aParams['installs']['install'][1]) ? $aParams['installs']['install'] : array($aParams['installs']['install']));
			$aInstallOrder = array();
			foreach ($aInstalls as $aInstall)
			{
				if (version_compare($aInstall['version'], $aProduct['version'], '<='))
				{
					continue;
				}
				
				$aInstallOrder[$aInstall['version']] = $aInstall;							
			}
			
			sort($aInstallOrder);

			foreach ($aInstallOrder as $aInstall)
			{
				if (isset($aInstall['install_code']))
				{
					eval($aInstall['install_code']);
					/* Suggest to check for a return val here so products can interrupt the install process:
					 * if (isset($mInstallReturn)) { return $mInstallReturn; }
					 * */
					$iLastVersion = $aInstall['version'];

					/* bug fix here? http://www.phpfox.com/tracker/view/6005/*/
					$aInsert = array(
						'product_id' => $aProduct['product_id'],
						'version' => $aInstall['version'],
						'install_code' => $aInstall['install_code'],
						'uninstall_code' => isset($aInstall['uninstall_code']) ? $aInstall['uninstall_code'] : ''
					);
					$this->database()->insert(Phpfox::getT('product_install'), $aInsert);
				}		
			}				
		}
		
		$this->database()->update($this->_sTable, array(
				'version' => $aParams['data']['version']
			), 'product_id = \'' . $this->database()->escape($aProduct['product_id']) . '\''
		);
		
		$this->cache()->remove();
		
		return true;
	}

	public function import($sProductFile, $bOverwrite = false)
	{
		$aCache = array();
		$aModuleInstall = array();		
		
		if (!file_exists(PHPFOX_DIR_XML . $sProductFile . '.xml'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.unable_to_find_xml_file_to_import_for_this_product'));
		}

		$aParams = Phpfox::getLib('xml.parser')->parse(file_get_contents(PHPFOX_DIR_XML . $sProductFile . '.xml'));

		if (isset($aParams['modules']))
		{			
			$aModules = (is_array($aParams['modules']['module_id']) ? $aParams['modules']['module_id'] : array($aParams['modules']['module_id']));						
			foreach ($aModules as $sModule)
			{
				$aModuleInstall[$sModule] = array(
					'table' => 'true',
					'installed' => 'false'
				);
			}
		}
		
		$iFailed = 0;
		foreach ($aCache as $sModuleCheck => $mTrue)
		{
			if (!Phpfox::isModule($sModuleCheck))
			{
				$iFailed++;
				
				Phpfox_Error::set(Phpfox::getPhrase('admincp.the_module_name_is_required', array('name' => $sModuleCheck)));
			}
		}		
		
		if ($iFailed > 0)
		{
			return false;
		}		
		
		if (!isset($aParams['data']['product_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.not_a_valid_xml_file'));
		}
		
		Phpfox::getLib('cache')->lock();
		
		if ($bOverwrite)
		{
			$this->delete($aParams['data']['product_id']);
		}
		
		$bIsProduct = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where("product_id = '" . $this->database()->escape($aParams['data']['product_id']) . "'")
			->execute('getField');
			
		if ($bIsProduct)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_already_exists'));
		}
		
		if (isset($aParams['dependencies']))
		{			
			$aDependencies = (isset($aParams['dependencies']['dependency'][1]) ? $aParams['dependencies']['dependency'] : array($aParams['dependencies']['dependency']));
			foreach ($aDependencies as $aDependancy)
			{
				if (!isset($aDependancy['type_id']) || !isset($aDependancy['dependency_start']))
				{
					continue;
				}
				
				switch ($aDependancy['type_id'])
				{
					case 'php':
						if (version_compare(PHP_VERSION, $aDependancy['dependency_start'], '<'))
						{
							return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_requires_php_version', array('dependency_start' => $aDependancy['dependency_start'])));	
						}
						
						if (isset($aDependancy['dependency_end']) && $aDependancy['dependency_end'] != '')
						{
							if (version_compare(PHP_VERSION, $aDependancy['dependency_end'], '>'))
							{
								return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_requires_php_version_up_until', array('dependency_start' => $aDependancy['dependency_start'], 'dependency_end' => $aDependancy['dependency_end'])));	
							}
						}
						break;
					case 'phpfox':
						if (version_compare(Phpfox::getVersion(), $aDependancy['dependency_start'], '<'))
						{
							return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_requires_phpfox_version', array('dependency_start', $aDependancy['dependency_start'])));	
						}
						
						if (isset($aDependancy['dependency_end']) && $aDependancy['dependency_end'] != '')
						{
							if (version_compare(Phpfox::getVersion(), $aDependancy['dependency_end'], '>'))
							{
								return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_requires_phpfox_version_up_until', array('dependency_start' => $aDependancy['dependency_start'], 'dependency_end' => $aDependancy['dependency_end'])));	
							}
						}						
						break;
					case 'product':						
						if (!isset($aDependancy['check_id']))
						{
							continue;		
						}
						
						$aProductVersion = $this->database()->select('product_id, version, title')
							->from($this->_sTable)
							->where("product_id = '" . $this->database()->escape($aDependancy['check_id']) . "'")
							->execute('getRow');	
							
						if (isset($aProductVersion['product_id']))
						{						
							if (version_compare($aProductVersion['version'], $aDependancy['dependency_start'], '<'))
							{
								return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_requires_check_id_version_dependency_start', array('check_id' => $aProductVersion['title'], 'dependency_start' => $aDependancy['dependency_start'])));
							}
							
							if (!empty($aDependancy['dependency_end']))
							{
								if (version_compare($aProductVersion['version'], $aDependancy['dependency_end'], '>'))
								{
									return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_requires_check_id_version_dependency_start_up_until_dependency_end', array('check_id' => $aProductVersion['title'], 'dependency_start' => $aDependancy['dependency_start'], 'dependency_end' => $aDependancy['dependency_end'])));
								}
							}						
						}
						else
						{
						    return Phpfox::getPhrase('admincp.product_requires_check_id_version_dependency_start', array(
							'check_id' => $aDependancy['check_id'], 
							'dependency_start'=>$aDependancy['dependency_start'])); 
						    
						}
						break;						
					default:					
						
						break;
				}
			}
		}	
		
		$this->database()->insert($this->_sTable, array(
				'product_id' => $aParams['data']['product_id'],
				'title' => $aParams['data']['title'],
				'description' => (empty($aParams['data']['description']) ? null : $aParams['data']['description']),
				'version' => (empty($aParams['data']['version']) ? null : $aParams['data']['version']),
				'is_active' => 1,
				'url' => (empty($aParams['data']['url']) ? null : $aParams['data']['url']),
				'url_version_check' => (empty($aParams['data']['url_version_check']) ? null : $aParams['data']['url_version_check'])
			)
		);		
		
		if (isset($aParams['dependencies']))
		{			
			$aDependencies = (isset($aParams['dependencies']['dependency'][1]) ? $aParams['dependencies']['dependency'] : array($aParams['dependencies']['dependency']));
			foreach ($aDependencies as $aDependancy)
			{
				$aDependancy['product_id'] = $aParams['data']['product_id'];
				
				$this->addDependency($aDependancy);
			}
		}		
		
		if (isset($aParams['installs']))
		{
			$aInstalls = (isset($aParams['installs']['install'][1]) ? $aParams['installs']['install'] : array($aParams['installs']['install']));
			$aInstallOrder = array();
			foreach ($aInstalls as $aInstall)
			{
				$aInstallOrder[$aInstall['version']] = $aInstall;
				
				$aInstall['product_id'] = $aParams['data']['product_id'];
				
				$this->addInstall($aInstall);				
			}
			
			sort($aInstallOrder);
			
			foreach ($aInstallOrder as $aInstall)
			{
				if (isset($aInstall['install_code']))
				{
					eval($aInstall['install_code']);
				}		
			}			
		}			
		
		$this->cache()->remove();
	
		return array(
			'product_id' => $aParams['data']['product_id'],
			'files' => $aModuleInstall
		);
	}
	
	private function _isProduct($sName)
	{
		return $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('product'))
			->where("product_id = '" . $this->database()->escape($sName) . "'")	
			->execute('getField');
	}
	
	private function _clean($sName)
	{
		return trim(preg_replace( '/ +/', '-',preg_replace('/[^0-9a-zA-Z_]+/', '', strtolower($sName))));		
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_product_process___call'))
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
