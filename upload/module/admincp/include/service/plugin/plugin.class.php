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
 * @version 		$Id: plugin.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Admincp_Service_Plugin_Plugin extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('plugin');
	}
	
	public function export($sProductId, $sModuleId = null)
	{		
		$oXmlBuilder = Phpfox::getLib('xml.builder');		
		$iTotal = 0;
		$aWhere = array();
		$aCache = array();
		$aWhere[] = "p.product_id = '" . $sProductId . "'";
		if ($sModuleId !== null)
		{
			$aWhere[] = " AND p.module_id = '" . $sModuleId . "'";
		}		
		
		$aRows = $this->database()->select('p.*')
			->from(Phpfox::getT('plugin'), 'p')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = p.product_id')
			->leftJoin(Phpfox::getT('module'), 'm', "m.module_id = p.module_id")
			->where($aWhere)
			->execute('getRows');	
			
		foreach ($aRows as $aRow)
		{
			$iTotal++;		
		}		
		
		$hDir = opendir(PHPFOX_DIR_PLUGIN);
		 while ($sDir = readdir($hDir))
		 {		 	
		 	if ($sProductId != $sDir)
		 	{
		 		continue;
		 	}
		 	
		 	if (!Phpfox::getService('admincp.product')->isProduct($sDir))
		 	{
		 		continue;
		 	}
		 	
		 	$hPluginDir = opendir(PHPFOX_DIR_PLUGIN . $sDir);
		 	while ($sPlugin = readdir($hPluginDir))
		 	{
		 		if (substr($sPlugin, -4) != '.php')
		 		{
		 			continue;
		 		}
		 		
		 		$aParts = explode('.', $sPlugin);
		 		
		 		if (!isset($aParts[1]))
		 		{
		 			continue;
		 		}
		 		
		 		if ($sModuleId !== null && $sModuleId != $aParts[0])
		 		{
		 			continue;
		 		}
		 		
		 		if (!Phpfox::isModule($aParts[0]))
		 		{
		 			continue;
		 		}
		 		
		 		if ($sModuleId !== null && $sModuleId != $aParts[0])
		 		{
		 			continue;
		 		}
		 		
		 		$iTotal++;		 	
		 	}
		 	closedir($hPluginDir);
		 }
		 closedir($hDir);		

		if (!$iTotal)
		{				
			return false;
		}
		
		$oXmlBuilder->addGroup('plugins');
		
		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addTag('plugin', $aRow['php_code'], array(
					'module_id' => $aRow['module_id'],
					'product_id' => $sProductId,
					'call_name' => $aRow['call_name'],
					'title' => $aRow['title']
				)
			);			
		}			
		
		$hDir = opendir(PHPFOX_DIR_PLUGIN);
		 while ($sDir = readdir($hDir))
		 {		 	
		 	if ($sProductId != $sDir)
		 	{
		 		continue;
		 	}
		 	
		 	if (!Phpfox::getService('admincp.product')->isProduct($sDir))
		 	{
		 		continue;
		 	}
		 	
		 	$hPluginDir = opendir(PHPFOX_DIR_PLUGIN . $sDir);
		 	while ($sPlugin = readdir($hPluginDir))
		 	{
		 		if (substr($sPlugin, -4) != '.php')
		 		{
		 			continue;
		 		}
		 		
		 		$aParts = explode('.', $sPlugin);
		 		
		 		if (!isset($aParts[1]))
		 		{
		 			continue;
		 		}
		 		
		 		if ($sModuleId !== null && $sModuleId != $aParts[0])
		 		{
		 			continue;
		 		}
		 		
		 		if (!Phpfox::isModule($aParts[0]))
		 		{
		 			continue;
		 		}
		 		
		 		if ($sModuleId !== null && $sModuleId != $aParts[0])
		 		{
		 			continue;
		 		}
		 		
		 		$iTotal++;
		 		$sCode = file_get_contents(PHPFOX_DIR_PLUGIN . $sDir . PHPFOX_DS . $sPlugin);
		 		$sCallName = substr_replace($sPlugin, '', -4);
		 		
				$oXmlBuilder->addTag('plugin', $sCode, array(
						'module_id' => $aParts[0],
						'product_id' => $sProductId,
						'call_name' => $sCallName,
						'title' => $sCallName
					)
				);
		 	}
		 	closedir($hPluginDir);
		 }
		 closedir($hDir);			
		
		$oXmlBuilder->closeGroup();
	
		return true;
	}
	
	public function exportHooks($sProductId, $sModuleId = null)
	{
		$aWhere = array();
		$aWhere[] = "plugin_hook.product_id = '" . $sProductId . "'";
		if ($sModuleId !== null)
		{
			$aWhere[] = " AND plugin_hook.module_id = '" . $sModuleId . "'";
		}		
		
		$aRows = $this->database()->select('plugin_hook.*, product.title AS product_name, m.module_id AS module_name')
			->from(Phpfox::getT('plugin_hook'), 'plugin_hook')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = plugin_hook.product_id')
			->leftJoin(Phpfox::getT('module'), 'm', "m.module_id = plugin_hook.module_id")
			->where($aWhere)
			->execute('getRows');
		
		if (!isset($aRows[0]['product_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_does_not_have_any_settings'));
		}		
		
		if (!count($aRows))
		{
			return false;
		}		
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('hooks');
			
		$aCache = array();
		foreach ($aRows as $aRow)
		{
			if (isset($aCache[$aRow['call_name']]))
			{
				continue;
			}
			
			$aCache[$aRow['call_name']] = $aRow['call_name'];
			
			$oXmlBuilder->addTag('hook', '', array(
					'module_id' => $aRow['module_id'],
					'hook_type' => $aRow['hook_type'],
					'module' => $aRow['module_name'],
					'call_name' => $aRow['call_name'],
					'added' => $aRow['added'],
					'version_id' => $aRow['version_id']
				)
			);			
		}	
		$oXmlBuilder->closeGroup();

		return true;	
	}	
	
	public function get()
	{
		return $this->database()->select('p.*')
			->from($this->_sTable, 'p')
			->execute('getRows');
	}
	
	public function getForEdit($iId)
	{
		return $this->database()->select('p.*')
			->from($this->_sTable, 'p')
			->where('plugin_id =' . (int) $iId)
			->execute('getRow');
	}
	
	public function getHooks()
	{
		$aHooks = array();
		$aRows = $this->database()->select('ph.*')
			->from(Phpfox::getT('plugin_hook'), 'ph')
			->execute('getRows');
			
		foreach ($aRows as $aRow)
		{
			$aHooks[$aRow['hook_type']][$aRow['module_id']][] = $aRow;
		}		
			
		return $aHooks;
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_plugin_plugin___call'))
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