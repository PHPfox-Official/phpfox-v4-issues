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
 * @package  		Module_User
 * @version 		$Id: ajax.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class User_Component_Admincp_Ajax_Ajax extends Phpfox_Ajax
{	
	public function addSettingPhrase()
	{
		$sModule = '' . Phpfox::getLib('module')->getModuleId('admincp') . '|admincp';
		$sPhrase = Phpfox::getService('language.phrase.process')->add(array(
			'var_name' => 'user_setting_' . $this->get('var'),
			'product_id' => 1,
			'module' => $sModule,
			'text' => array(
				1 => $this->get('text')
			)
		));
		
		$this->html('#js_phrase' . $this->get('id'), $this->get('text'));
	}
}

?>