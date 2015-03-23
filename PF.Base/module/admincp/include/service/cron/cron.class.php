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
 * @version 		$Id: cron.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Admincp_Service_Cron_Cron extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('cron');
	}
	
	public function export($sProductId, $sModuleId = null)
	{
		$aSql = array();
		if ($sModuleId !== null)
		{
			$aSql[] = "cron.module_id = '" . $sModuleId . "' AND";
		}
		$aSql[] = "cron.product_id = '" . $sProductId . "'";
		
		$aRows = $this->database()->select('cron.*, product.title AS product_name')
			->from($this->_sTable, 'cron')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = cron.product_id')
			->where($aSql)
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
		$oXmlBuilder->addGroup('crons');
			
		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addTag('cron', $aRow['php_code'], array(
					'module_id' => $aRow['module_id'],				
					'type_id' => $aRow['type_id'],
					'every' => $aRow['every']
				)
			);			
		}	
		$oXmlBuilder->closeGroup();
				
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_cron_cron__call'))
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