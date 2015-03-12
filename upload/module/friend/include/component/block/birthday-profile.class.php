<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Module_Friend
 * @version 		$Id: birthday-profile.class.php 2875 2011-08-23 08:42:47Z Miguel_Espinoza $
 */
class Friend_Component_Block_Birthday_ProfileAssertToDelete extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		$aUser = $this->getParam('aUser');
		
		if ($aUser['user_id'] == Phpfox::getUserId())
		{
			return false;
		}
		
		if (!$aUser['is_user_birthday'])
		{
			return false;
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_birthday_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>