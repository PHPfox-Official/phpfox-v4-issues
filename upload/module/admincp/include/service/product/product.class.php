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
 * @version 		$Id: product.class.php 1652 2010-06-16 08:25:59Z Raymond_Benc $
 */
class Admincp_Service_Product_Product extends Phpfox_Service 
{
	private $_aProducts = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('product');
		
		$sCacheId = $this->cache()->set('product');
		
		if (!($this->_aProducts = $this->cache()->get($sCacheId)))
		{			
			foreach ($this->_get() as $aRow)
			{
				$this->_aProducts[$aRow['product_id']] = $aRow;
			}
	
			$this->cache()->save($sCacheId, $this->_aProducts);
		}
	}
	
	public function get($bCache = true)
	{
		return ($bCache ? $this->_aProducts : $this->_get());
	}
	
	public function isProduct($sProduct)
	{
		return (isset($this->_aProducts[$sProduct]) ? true : false);
	}
	
	public function getId($sName)
	{
		return (isset($this->_aProducts[$sName]) ? $this->_aProducts[$sName]['product_id'] : 1);		
	}
	
	public function getForEdit($sProduct)
	{
		return $this->database()->select('product.*')
			->from($this->_sTable, 'product')
			->where("product_id = '" . $this->database()->escape($sProduct) . "'")
			->execute('getRow');
	}

	public function export($sProduct)
	{
		$aFiles = array();
		$oFile = Phpfox::getLib('file');
		$oDatabaseSupport = Phpfox::getLib('database.support');
		
		define('PHPFOX_XML_SKIP_STAMP', true);

		$aRow = $this->database()->select('*')
			->from($this->_sTable)
			->where("product_id = '" . $this->database()->escape($sProduct) . "'")
			->execute('getRow');

		if (!isset($aRow['product_id']))
		{
			return false;
		}

		$oXmlBuilder = Phpfox::getLib('xml.builder');
		
		$oXmlBuilder->addGroup('product');
		$oXmlBuilder->addGroup('data');
		foreach ($aRow as $sKey => $sValue)
		{
			$oXmlBuilder->addTag($sKey, $sValue);
		}
		$oXmlBuilder->closeGroup();		
		
		$aDependencies = $this->database()->select('type_id, check_id, dependency_start, dependency_end')
			->from(Phpfox::getT('product_dependency'))
			->where("product_id = '" . $this->database()->escape($sProduct) . "'")
			->execute('getRows');		
		if (count($aDependencies))
		{
			$oXmlBuilder->addGroup('dependencies');
			foreach ($aDependencies as $aDependency)
			{
				$oXmlBuilder->addGroup('dependency');
				foreach ($aDependency as $sKey => $sValue)
				{
					$oXmlBuilder->addTag($sKey, $sValue);
				}				
				$oXmlBuilder->closeGroup();
			}
			$oXmlBuilder->closeGroup();
		}
		
		$aInstalls = $this->database()->select('version, install_code, uninstall_code')
			->from(Phpfox::getT('product_install'))
			->where("product_id = '" . $this->database()->escape($sProduct) . "'")
			->order('version ASC')
			->execute('getRows');		
		if (count($aInstalls))
		{
			$oXmlBuilder->addGroup('installs');
			foreach ($aInstalls as $aInstall)
			{
				$oXmlBuilder->addGroup('install');
				foreach ($aInstall as $sKey => $sValue)
				{
					$oXmlBuilder->addTag($sKey, $sValue);
				}				
				$oXmlBuilder->closeGroup();
			}
			$oXmlBuilder->closeGroup();
		}		
		
		$aModules = $this->database()->select('*')
			->from(Phpfox::getT('module'))
			->where('product_id = \'' . $this->database()->escape($sProduct) . '\'')
			->execute('getRows');
		if (count($aModules))
		{
			$aModuleCache = array();
			$oXmlBuilder->addGroup('modules');			
			foreach ($aModules as $aModule)
			{
				$oXmlBuilder->addTag('module_id', $aModule['module_id']);
				$aModuleCache[$aModule['module_id']] = true;
			}
			$oXmlBuilder->closeGroup();
		}
		
		$oXmlBuilder->closeGroup();	
		
		$sDirectoryId = 'product_' . $aRow['product_id'] . '_' . uniqid();
		if (is_dir(PHPFOX_DIR_CACHE . $sDirectoryId))
		{
			Phpfox::getLib('file')->delete_directory(PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS);
		}
		
		$sUploadPath = PHPFOX_DIR_CACHE . $sDirectoryId . PHPFOX_DS . 'upload' . PHPFOX_DS;
		
		Phpfox::getLib('file')->mkdir($sUploadPath, true);
		Phpfox::getLib('file')->mkdir($sUploadPath . 'include' . PHPFOX_DS . 'xml' . PHPFOX_DS, true);	
		Phpfox::getLib('file')->write($sUploadPath . 'include' . PHPFOX_DS . 'xml' . PHPFOX_DS . $aRow['product_id'] . '.xml', $oXmlBuilder->output());	
	
		Phpfox::getService('admincp.module')->exportForModules($sProduct, false, (isset($aModuleCache) ? $aModuleCache : null), $sDirectoryId . PHPFOX_DS . 'upload' . PHPFOX_DS);	
		
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_product_product_export'))
		{
			eval($sPlugin);
		}
		
		return array(
			'name' => $aRow['product_id'] . (!empty($aRow['version']) ? '-' . $aRow['version'] : ''),
			'folder' => $sDirectoryId
		);
	}
	
	public function getDependencies($iId)
	{
		return $this->database()->select('*')
			->from(Phpfox::getT('product_dependency'))
			->where("product_id = '" . $this->database()->escape($iId) . "'")
			->execute('getSlaveRows');
	}	
	
	public function getInstalls($iId)
	{
		return $this->database()->select('*')
			->from(Phpfox::getT('product_install'))
			->where("product_id = '" . $this->database()->escape($iId) . "'")
			->order('version ASC')
			->execute('getSlaveRows');
	}

	public function getNewProductsForInstall()
	{
		$aNew = array();
		$hDir = opendir(PHPFOX_DIR_XML);
		while ($sFile = readdir($hDir))
		{
			if (substr($sFile, -4) == '.xml')
			{
				if (!$this->isProduct(substr_replace($sFile, '', -4)))
				{				
					$aProduct = Phpfox::getLib('xml.parser')->parse(file_get_contents(PHPFOX_DIR_XML . $sFile));					
					if (isset($aProduct['data']))
					{
						/*
						if (isset($aProduct['modules']))
						{
							foreach ($aProduct['modules'] as $sModule)
							{
								
							}
						}
						*/
						
						$aNew[] = $aProduct['data'];
					}
				}
			}
		}
		closedir($hDir);
		
		return $aNew;
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_product_product___call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function _get()
	{
		$aProducts = $this->database()->select('product.*')
			->from($this->_sTable, 'product')
			->order('product.is_core DESC, product.product_id ASC')
			->execute('getRows');
			
		$aCache = array();
		$iCnt = 2;
		foreach ($aProducts as $aProduct)
		{
			if ($aProduct['product_id'] == 'phpfox')
			{
				$aCache[1] = $aProduct;
				
				continue;
			}
			
			if ($aProduct['product_id'] == 'phpfox_installer')
			{
				$aCache[2] = $aProduct;
				
				continue;
			}			
			
			$iCnt++;
			
			$sXml = PHPFOX_DIR_INCLUDE . 'xml' . PHPFOX_DS . $aProduct['product_id'] . '.xml';
			if (file_exists($sXml))
			{
				$aXml = Phpfox::getLib('xml.parser')->parse(file_get_contents($sXml));
				if (isset($aXml['data']['version']) && version_compare($aXml['data']['version'], $aProduct['version'], '>'))
				{
					$aProduct['upgrade_version'] = $aXml['data']['version'];
				}
			}
			
			if (!empty($aProduct['latest_version']) && version_compare($aProduct['version'], $aProduct['latest_version'], '>='))
			{
				$aProduct['latest_version']	= 0;
			}
			
			$aCache[$iCnt] = $aProduct;
		}
		
		ksort($aCache);
		
		return $aCache;
	}
}

?>