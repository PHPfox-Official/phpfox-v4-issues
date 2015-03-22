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
 * @package  		Module_Language
 * @version 		$Id: callback.class.php 1495 2010-03-05 15:45:57Z Raymond_Benc $
 */
class Language_Service_Callback extends Phpfox_Service
{
	public function  __construct()
	{
		$this->_sTable = Phpfox::getT('language');
	}

	public function massAdmincpProductDelete($sProduct)
	{
		$this->database()->delete(Phpfox::getT('language_phrase'), "product_id = '" . $this->database()->escape($sProduct) . "'");
	}

	public function massAdmincpModuleDelete($iModule)
	{
		$this->database()->delete(Phpfox::getT('language_phrase'), "module_id = '" . $this->database()->escape($iModule) . "'");
	}
	
	public function exportModule($sProduct, $sModule, $bCore)
	{
		return Phpfox::getService('language')->export('en', $sProduct, $sModule, true, $bCore);
	}
}

?>