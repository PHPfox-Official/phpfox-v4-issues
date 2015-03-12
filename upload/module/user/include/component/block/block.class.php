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
 * @package 		Phpfox_Component
 * @version 		$Id: block.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class User_Component_Block_Block extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aUser = Phpfox::getService('user')->getUser($this->request()->getInt('user_id'));
		
		if (!isset($aUser['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.unable_to_find_this_member'));
		}
		
		$bIsBlocked = Phpfox::getService('user.block')->isBlocked(Phpfox::getUserId(), $aUser['user_id']);
		
		if (!$bIsBlocked)
		{
			Phpfox::getUserParam('user.can_block_other_members', true);
			if (!Phpfox::getUserGroupParam($aUser['user_group_id'], 'user.can_be_blocked_by_others'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('user.unable_to_block_this_user'));
			}
		}
		
		$this->template()->assign(array(
				'aUser' => $aUser,
				'bIsBlocked' => $bIsBlocked
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_block_clean')) ? eval($sPlugin) : false);
	}
}

?>