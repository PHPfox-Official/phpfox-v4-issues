<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: request.class.php 6530 2013-08-29 11:09:03Z Miguel_Espinoza $
 */
class Friend_Component_Block_Request extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$sError = false;
		$iUserId = $this->getParam('user_id');		
		
		$aUser = Phpfox::getService('user')->getUser($iUserId, Phpfox::getUserField());
		
		if (Phpfox::getUserId() === $aUser['user_id'])
		{
			$sError = 'same_user';
		}
		elseif (Phpfox::getService('friend.request')->isRequested(Phpfox::getUserId(), $aUser['user_id']))
		{
			$sError = 'already_asked';
		}		
		elseif (Phpfox::getService('friend.request')->isRequested($aUser['user_id'], Phpfox::getUserId()))
		{
			$sError = 'user_asked_already';
		}	
		elseif (Phpfox::getService('friend')->isFriend($aUser['user_id'], Phpfox::getUserId()))
		{
			$sError = 'already_friends';
		}		
		
		$this->template()
			->setPhrase(array(
					'core.you_cannot_write_more_then_limit_characters',
					'core.you_have_limit_character_s_left'
				)
			)
			->setHeader(array(
					//'jquery/plugin/jquery.limitTextarea.js' => 'static_script'
				)
			)
			->assign(array(
				'aUser' => $aUser,
				'sError' => $sError,
				'aOptions' => Phpfox::getService('friend.list')->get(),
				'bSuggestion' => ($this->request()->get('suggestion') ? true : false),
				'bPageSuggestion' => ($this->request()->get('suggestion_page') ? true : false),
				'bInvite' => ($this->request()->get('invite') ? true : false)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_request_clean')) ? eval($sPlugin) : false);
	}
}

?>