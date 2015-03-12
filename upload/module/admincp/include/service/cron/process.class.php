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
 * @version 		$Id: process.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Admincp_Service_Cron_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('cron');
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		if (!$iProductId)
		{
			$iProductId = 1;
		}
		
		$aCache = array();
		if ($bMissingOnly)
		{
			$aRows = $this->database()->select('file_name')
				->from($this->_sTable)
				->execute('getRows', array(
					'free_result' => true
				));			
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['file_name']] = $aRow['file_name'];
			}	
		}
		
		$aSql = array();		
		$aVals = (isset($aVals['cron'][0]) ? $aVals['cron'] : array($aVals['cron']));	
		foreach ($aVals as $aVal)
		{
			if ($bMissingOnly && in_array($aVal['file_name'], $aCache))
			{
				continue;
			}			
			
			$aSql[] = array(	
				$aVal['file_name'],
				$aVal['type_id'],
				$aVal['every'],
				$iProductId,
				1
			);
		}

		if ($aSql)
		{
			$this->database()->multiInsert($this->_sTable, array(
				'file_name',
				'type_id',
				'every',
				'product_id',
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_cron_process_call'))
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