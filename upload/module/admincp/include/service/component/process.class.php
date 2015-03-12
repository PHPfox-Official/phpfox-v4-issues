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
 * @version 		$Id: process.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Admincp_Service_Component_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('component');
	}
	
	public function add($aVals, $iEditId = null)
	{	
		if (isset($aVals['module_id']) && !is_numeric($aVals['module_id']))
		{
			$aParts = explode('|', $aVals['module_id']);
			$aVals['module_id'] = $aParts[0];
		}
		
		if (isset($aVals['type']))
		{
			if ($aVals['type'] == 1)
			{
				$aVals['is_controller'] = 1;
				$aVals['is_block'] = 0;
			}
			else 
			{
				$aVals['is_controller'] = 0;
				$aVals['is_block'] = 1;
			}
			unset($aVals['type']);
		}
		
		if (isset($aVals['m_connection']) && empty($aVals['m_connection']))
		{
			$aVals['m_connection'] = null;
		}
		
		if ($iEditId === null)
		{		
			$this->database()->process(array(
				'component',
				'm_connection',
				'is_controller' => 'int',
				'is_block' => 'int',
				'module_id',
				'product_id',
				'is_active' => 'int'
			), $aVals)->insert($this->_sTable);
		}
		else 
		{
			$this->database()->process(array(
				'component',
				'm_connection',
				'is_controller' => 'int',
				'is_block' => 'int',
				'module_id',
				'product_id',
				'is_active' => 'int'
			), $aVals)->update($this->_sTable, 'component_id = ' . (int) $iEditId);
		}
		
		$this->cache()->remove('component');
		
		return true;
	}
	
	public function update($iId, $aVals)
	{
		return $this->add($aVals, $iId);
	}
	
	public function delete($iId)
	{
		$this->database()->delete($this->_sTable, 'component_id = ' . (int) $iId);
		
		$this->cache()->remove('component');
		
		return true;
	}
	
	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
	
		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'component_id = ' . (int) $iId);
		
		$this->cache()->remove('component');
	}	
	
	public function import($aVals, $bMissingOnly = false)
	{
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		
		$aCache = array();
		if ($bMissingOnly)
		{
			$aRows = $this->database()->select('component, m_connection')
				->from($this->_sTable)
				->execute('getRows', array(
					'free_result' => true
				));			
			foreach ($aRows as $aRow)
			{
				$aCache[md5($aRow['component'] . $aRow['m_connection'])] = $aRow['component'];
			}		
		}
		
		$aSql = array();		
		$aVals = (isset($aVals['component'][0]) ? $aVals['component'] : array($aVals['component']));			
		foreach ($aVals as $aVal)
		{
			if ($bMissingOnly && isset($aCache[md5($aVal['component'] . $aVal['m_connection'])]))
			{
				continue;
			}			
			
			$iModuleId = Phpfox::getLib('module')->getModuleId($aVal['module']);
			$aSql[] = array(	
				$aVal['component'],
				(empty($aVal['m_connection']) ? null : $aVal['m_connection']),
				$iModuleId,
				$iProductId,
				$aVal['is_controller'],
				$aVal['is_block'],
				1
			);
		}

		if ($aSql)
		{
			$this->database()->multiInsert($this->_sTable, array(
				'component',
				'm_connection',
				'module_id',
				'product_id',
				'is_controller',
				'is_block',				
				'is_active'
			), $aSql);				
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_component_process__call'))
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