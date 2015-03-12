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
 * @package  		Module_Profile
 * @version 		$Id: menu.class.php 5075 2012-12-07 12:49:53Z Miguel_Espinoza $
 * @deprecated 		v2.1.0beta1
 */
class Profile_Component_Block_Menu extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		return false;
		
		/*$aUser = $this->getParam('aUser');
		
		(($sPlugin = Phpfox_Plugin::get('profile.component_block_menu_process')) ? eval($sPlugin) : false);
		
		if (isset($bHideProfileBlockMenu))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'bIsBlocked' => (Phpfox::isUser() ? Phpfox::getService('user.block')->isBlocked(Phpfox::getUserId(), $aUser['user_id']) : false)
			)
		);*/
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('profile.component_block_menu_clean')) ? eval($sPlugin) : false);
	}
}

?>