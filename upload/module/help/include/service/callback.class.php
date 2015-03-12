<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Callbacks
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Help
 * @version 		$Id: callback.class.php 833 2009-08-05 20:51:51Z Raymond_Benc $
 */
class Help_Service_Callback extends Phpfox_Service
{
	public function  __construct()
	{
		$this->_sTable = Phpfox::getT('help');
	}

	public function massAdmincpProductDelete($sProduct)
	{
		$this->database()->delete($this->_sTable, "product_id = '" . $this->database()->escape($sProduct) . "'");
	}

	public function massAdmincpModuleDelete($iModule)
	{
		$this->database()->delete($this->_sTable, "module_id = '" . $this->database()->escape($iModule) . "'");
	}
	
	public function exportModule($sProduct, $sModule)
	{
		return Phpfox::getService('help')->export($sProduct, $sModule);	
	}
}

?>