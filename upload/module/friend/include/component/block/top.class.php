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
 * @package  		Module_Friend
 * @version 		$Id: top.class.php 1135 2009-10-05 12:59:10Z Miguel_Espinoza $
 */
class Friend_Component_Block_Top extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (!defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::isUser())
		{
			return false;
		}
		
		$aUser = $this->getParam('aUser');
		$iTotal = (int) Phpfox::getComponentSetting((defined('PHPFOX_IS_USER_PROFILE') ? $aUser['user_id'] : Phpfox::getUserId()), 'friend.friend_display_limit_profile', Phpfox::getParam('friend.friend_display_limit'));		
		$aTopFriends = Phpfox::getService('friend')->getTop((defined('PHPFOX_IS_USER_PROFILE') ? $aUser['user_id'] : Phpfox::getUserId()), $iTotal);
		$iCount = count($aTopFriends);
		
		if (defined('PHPFOX_IS_USER_PROFILE') && !$iCount)
		{
			return false;
		}		
		
		$this->template()->assign(array(
				'aTopFriends' => $aTopFriends
			)
		);	


		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			$this->template()->assign(array(
						'bMoveCursor' => false
					));
		}
		else
		{
			$this->template()->assign(array(
						'bMoveCursor' => true
					));
		}

		if (!$this->getParam('bIsAjax'))
		{
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('friend.top_friends'),
					'sBlockJsId' => 'top_friends'					
				)
			);
					
			$bCanEditSettings = false;
			if (defined('PHPFOX_IS_USER_PROFILE'))
			{
				if ($aUser['user_id'] == Phpfox::getUserId())
				{
					// $bCanEditSettings = true;
				}				
				$bCanEditSettings = false;
				
			}
			else 
			{
				$bCanEditSettings = true;				
			}
			
			if ($bCanEditSettings)
			{
				$this->template()->assign(array(
						'aEditBar' => array(
							'ajax_call' => 'friend.getEditBar',
							'params' => '&amp;type_id=profile&amp;no_delete_link=true&amp;is_edit_top=true'
						)			
					)
				);
			}
			
			return 'block';
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_top_clean')) ? eval($sPlugin) : false);
	}	
}

?>