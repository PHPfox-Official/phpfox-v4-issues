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
 * @package  		Module_Help
 * @version 		$Id: help.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Help_Service_Help extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('help');
	}
	
	public function export($sProductId, $sModuleId = null)
	{
		$aSql = array();
		if ($sModuleId !== null)
		{
			$aSql[] = "help.module_id = '" .  $this->database()->escape($sModuleId) . "' AND";
		}
		$aSql[] = "help.product_id = '" . $this->database()->escape($sProductId) . "'";
		
		$aRows = $this->database()->select('help.*, product.title AS product_name')
			->from($this->_sTable, 'help')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = help.product_id')
			->where($aSql)
			->execute('getRows');
		
		if (!isset($aRows[0]['product_name']))
		{
			return false;
		}		
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('help');
			
		foreach ($aRows as $aSetting)
		{
			$oXmlBuilder->addTag('info', '', array(
					'module_id' => $aSetting['module_id'],
					'var_name' => $aSetting['var_name'],
					'added' => $aSetting['added']			
				)
			);			
		}	
		$oXmlBuilder->closeGroup();
				
		return false;
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
		if ($sPlugin = Phpfox_Plugin::get('help.service_help__call'))
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