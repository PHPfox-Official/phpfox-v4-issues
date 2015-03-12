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
 * @version 		$Id: process.class.php 1643 2010-06-09 12:30:27Z Miguel_Espinoza $
 */
class Admincp_Service_Plugin_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('plugin');
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		
		if (!is_array($aVals))
		{
			return false;
		}
		
		$aCache = array();
		if ($bMissingOnly)
		{
			$aRows = $this->database()->select('call_name')
				->from(Phpfox::getT('plugin_hook'))
				->execute('getRows', array(
					'free_result' => true
				));			
			foreach ($aRows as $aRow)
			{
				$aCache[md5($aRow['call_name'])] = $aRow['call_name'];
			}		
		}
					
		$aSql = array();
		$aVals = (isset($aVals['hook'][0]) ? $aVals['hook'] : array($aVals['hook']));
		foreach ($aVals as $aVal)
		{
			if ($bMissingOnly && isset($aCache[md5($aVal['call_name'])]))
			{
				continue;
			}			
			
			$iModuleId = Phpfox::getLib('module')->getModuleId($aVal['module']);
			$aSql[] = array(	
				$aVal['hook_type'],
				$iModuleId,
				$iProductId,
				$aVal['call_name'],
				$aVal['added'],
				$aVal['version_id']						
			);
		}	
					
		if ($aSql)
		{		
			$this->database()->multiInsert(Phpfox::getT('plugin_hook'), array(
				'hook_type',
				'module_id',
				'product_id',
				'call_name',
				'added',
				'version_id'
			), $aSql);				
		}
		
		return true;
	}
	
	public function updateActive($aVals)
	{
		foreach ($aVals as $iId => $aVal)
		{
			$this->database()->update($this->_sTable, array('is_active' => (isset($aVal['is_active']) ? 1 : 0)), 'plugin_id = ' . (int) $iId);
		}		
		
		$this->cache()->remove();
		
		return true;
	}
	
	public function delete($iId)
	{
		$this->database()->delete($this->_sTable, 'plugin_id = ' . (int) $iId);
		
		$this->cache()->remove();
		
		return true;	
	}
	
	public function add($aVals, $bIsUpdate = false)
	{
		$aInsert = array(
			'module_id' => 'null',
			'product_id',
			'call_name',
			'title',
			'php_code',
			'is_active' => 'int'
		);
		$aVals['php_code'] = str_replace('\\','\\\\',$aVals['php_code']);
		if ($bIsUpdate)
		{
			$this->database()->process($aInsert, $aVals)->update($this->_sTable, 'plugin_id =' . (int) $aVals['plugin_id']);
		}
		else 
		{
			$this->database()->process($aInsert, $aVals)->insert($this->_sTable);
		}
		
		$this->cache()->remove();
		
		return true;
	}
	
	public function update($iId, $aVals)
	{
		$aVals['plugin_id'] = $iId;
		
		return $this->add($aVals, true);
	}
	
	public function addHook($aVals)
	{
		if ($this->database()->select('COUNT(*)')
			->from(Phpfox::getT('plugin_hook'))
			->where('call_name = \'' . $this->database()->escape($aVals['call_name']) . '\'')
			->execute('getField'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.hook_already_exists'));		
		}
		
		$this->database()->insert(Phpfox::getT('plugin_hook'), array(
				'hook_type' => $aVals['hook_type'],
				'module_id' => (empty($aVals['module_id']) ? null : $aVals['module_id']),
				'product_id' => $aVals['product_id'],
				'call_name' => $aVals['call_name'],
				'added' => PHPFOX_TIME,
				'version_id' => Phpfox::getId(),
				'is_active' => (int) $aVals['is_active']
			)
		);
		
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_plugin_process'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>