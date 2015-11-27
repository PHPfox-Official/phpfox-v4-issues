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
 * @version 		$Id: login-block.class.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
class User_Component_Block_Login_Block extends Phpfox_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{
		//Plugin call
		if ($sPlugin = Phpfox_Plugin::get('user.block_login-block_process__start'))
		{eval($sPlugin);}

		// If we are logged in lets not display the login block
		if (Phpfox::isUser())
		{
			return false;
		}

		$aFooter = array();
		$aFooter[Phpfox::getPhrase('user.forgot_password')] = $this->url()->makeUrl('user.password.request');
		
		// Assign the needed vars for the template
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('user.log'),
				'aFooter' =>  $aFooter,
				'sJanrainUrl' => (Phpfox::isModule('janrain') ? Phpfox::getService('janrain')->getUrl() : '')
			)
		);
		//Plugin call
		if ($sPlugin = Phpfox_Plugin::get('user.block_login-block_process__end'))
		{eval($sPlugin);}
		
		return 'block';
	}
}

?>