<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Plugins
 * Our product is built around a plug-in system that allows 3rd party
 * code to easily hook onto our core library and other modules without
 * the need to modify its code. This class takes care of creating the 
 * hook enviroment.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: plugin.class.php 6599 2013-09-06 08:18:37Z Miguel_Espinoza $
 */
class Phpfox_Plugin
{
	/**
	 * ARRAY of plug-ins to be used.
	 *
	 * @var array
	 */
	public static $_aPlugins = array();
	
	/**
	 * List of all the hooks stored in the system.
	 *
	 * @var array
	 */
	private static $_aAllHooks = array();
	
	/**
	 * Variable is deprecated.
	 * 
	 * @deprecated 2.0.6
	 * @var array
	 */
	private static $_sCacheName = array();
	
	/**
	 * List of all the plug-in names.
	 *
	 * @var array
	 */
	private static $_aAvailablePlugins = array();
	
	/**
	 * Build and cache all the plug-ins for future use.
	 *
	 */
	public static function set()
	{		
		$aPlugins = array();	
		
		$oCache = Phpfox::getLib('cache');
		$iCacheId = $oCache->set(array('plugin', 'plugin'));
		
		if ((Phpfox::getParam('core.cache_plugins') && (!(self::$_aPlugins = $oCache->get($iCacheId)))) || !Phpfox::getParam('core.cache_plugins'))
		{
			$oDb = Phpfox::getLib('database');
			
			$aRows = $oDb->select('p.call_name, p.php_code')
				->from(Phpfox::getT('plugin'), 'p')
				->join(Phpfox::getT('product'), 'product', 'p.product_id = product.product_id AND product.is_active = 1')
				->join(Phpfox::getT('plugin_hook'), 'ph', 'ph.call_name = p.call_name AND ph.is_active = 1')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = p.module_id AND m.is_active = 1')
				->where('p.is_active = 1')
				->order('p.ordering ASC')
				->execute('getRows');				
			
			$oDb->freeResult();

			foreach ($aRows as $aRow)
			{
				$aRow['call_name'] = strtolower($aRow['call_name']);

				if (isset($aPlugins[$aRow['call_name']]))
				{
					$aPlugins[$aRow['call_name']] .= self::_cleanPhp($aRow['php_code']) . " ";
				}
				else 
				{			
					$aPlugins[$aRow['call_name']] = self::_cleanPhp($aRow['php_code']) . " ";
				}
			}
			
			$aModules = Phpfox::getLib('module')->getModules();
			foreach ($aModules as $sModule => $iModuleId)
			{
				if (is_dir(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_PLUGIN . PHPFOX_DS))
				{
			       	if (!Phpfox::isModule($sModule))
			       	{
			       		continue;
			       	}
					
					$rHooks = opendir(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_PLUGIN . PHPFOX_DS);
			       	while (($sHook = readdir($rHooks)) !== false)
					{
						if (substr($sHook, -4) != '.php')
						{
							continue;
						}
							
						$sHookContent = self::_cleanPhp(file_get_contents(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_PLUGIN . PHPFOX_DS . $sHook));
						$sHookVarName = substr_replace($sHook, '', -4);
						
						if (isset($aPlugins[$sHookVarName]))
						{
							$aPlugins[$sHookVarName] .= $sHookContent . " ";
						}
						else 
						{			
							$aPlugins[$sHookVarName] = $sHookContent . " ";
						}
					}	  
					closedir($rHooks); 
				}
			}

			$hPlugin = opendir(PHPFOX_DIR_PLUGIN);
			while ($sProduct = readdir($hPlugin))
			{
				if ($sProduct == '.' || $sProduct == '..')
				{
					continue;
				}
				
				if (is_dir(PHPFOX_DIR_PLUGIN . $sProduct))
				{
					if (!Phpfox::getService('admincp.product')->isProduct($sProduct))
					{
						continue;
					}
					
					$hProduct = opendir(PHPFOX_DIR_PLUGIN . $sProduct);
					while ($sHook = readdir($hProduct))
					{
						if (substr($sHook, -4) != '.php')
						{
							continue;
						}
							
						$sHookContent = self::_cleanPhp(file_get_contents(PHPFOX_DIR_PLUGIN . $sProduct . PHPFOX_DS . $sHook));	
						$sHookVarName = substr_replace($sHook, '', -4);
						
						if (isset($aPlugins[$sHookVarName]))
						{
							$aPlugins[$sHookVarName] .= $sHookContent . " ";
						}
						else 
						{			
							$aPlugins[$sHookVarName] = $sHookContent . " ";
						}
					}
					closedir($hProduct);
				}
			}

	        foreach (array_keys($aPlugins) as $sKey)
			{			
				self::$_aPlugins[$sKey] = $sKey;
				$iPluginCacheId = $oCache->set(array('plugin', 'plugin_data_' . $sKey));
				if ((Phpfox::getParam('core.cache_plugins') && (!$oCache->get($iPluginCacheId))) || !Phpfox::getParam('core.cache_plugins'))
				{
					$oCache->save($iPluginCacheId, $aPlugins[$sKey]);
				}
				$oCache->close($iPluginCacheId);
			}
			
			$oCache->save($iCacheId, self::$_aPlugins);	
		}
	}
	
	/**
	 * Get a specific plug-in.
	 *
	 * @param string $sCallName Name of the plug-in.
	 * @return mixed FALSE if we cannot find a plug-in, PHP code if we can which will then later be evaled.
	 */
	public static function get($sCallName)
	{
		$sCallName = str_replace('::', '_', $sCallName);
		$sCallName = strtolower($sCallName);
		
		if (isset(self::$_aPlugins[$sCallName]))
		{			
			$oCache = Phpfox::getLib('cache');
			$iCacheId = $oCache->set(array('plugin', 'plugin_data_' . self::$_aPlugins[$sCallName]));
			if (!($sPlugin = $oCache->get($iCacheId)))
			{
				// Do something, plug-in was not cached for some odd reason...
			}	
			$oCache->close($iCacheId);
				
			return $sPlugin;
		}	

		return false;		
	}
	
	/**
	 * Clean out any PHP that is causing problems when we eval the code.
	 *
	 * @param string $sHookContent PHP code to parse.
	 * @return string Fixed PHP code.
	 */
	private static function _cleanPhp($sHookContent)
	{
		$sHookContent = trim($sHookContent);		
		if (substr($sHookContent, 0, 5) == '<?php')
		{
			$sHookContent = substr_replace($sHookContent, '', 0, 5);
		}
		if (substr($sHookContent, 0, 2) == '<?')
		{
			$sHookContent = substr_replace($sHookContent, '', 0, 2);
		}
		if (substr($sHookContent, -2) == '?>')
		{
			$sHookContent = substr_replace($sHookContent, '', -2);
		}
		$sHookContent = trim($sHookContent);
		
		return $sHookContent;
	}
}

?>