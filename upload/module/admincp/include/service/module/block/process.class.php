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
class Admincp_Service_Module_Block_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('block');
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		
		$aCache = array();
		if ($bMissingOnly)
		{
			$aRows = $this->database()->select('m_connection, component')
				->from($this->_sTable)
				->execute('getRows', array(
					'free_result' => true
				));			
			foreach ($aRows as $aRow)
			{
				$aCache[md5($aRow['m_connection'] . $aRow['component'])] = $aRow['component'];
			}		
		}
		
		$aSql = array();		
		$aVals = (isset($aVals['block'][0]) ? $aVals['block'] : array($aVals['block']));			
		foreach ($aVals as $aVal)
		{
			if ($bMissingOnly && isset($aCache[md5($aVal['m_connection'] . $aVal['component'])]))
			{
				continue;
			}			
			
			$iModuleId = Phpfox::getLib('module')->getModuleId($aVal['module']);
			$aSql[] = array(	
				$aVal['type_id'],
				$aVal['m_connection'],
				$iModuleId,
				$iProductId,
				$aVal['component'],
				$aVal['location'],
				1,
				$aVal['ordering']						
			);
		}
			
		if ($aSql)
		{
			$this->database()->multiInsert($this->_sTable, array(
				'type_id',
				'm_connection',
				'module_id',
				'product_id',
				'component',
				'location',
				'is_active',				
				'ordering'
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_module_block_process__call'))
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