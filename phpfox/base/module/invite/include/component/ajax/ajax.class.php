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
 * @package  		Module_Invite
 * @version 		$Id: ajax.class.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
class Invite_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function moderation()
	{
		Phpfox::isUser(true);
		
		$aInvite = $this->get('item_moderate');
		if (is_array($aInvite) && count($aInvite))
		{
			foreach ($aInvite as $iInvite)
			{
				Phpfox::getService('invite.process')->delete($iInvite, Phpfox::getUserId());
				$this->remove('#js_invite_' . $iInvite);	
			}			
		}
		
		$this->alert(Phpfox::getPhrase('invite.successfully_removed_invites'), Phpfox::getPhrase('invite.moderation'), 300, 150, true);
		$this->hide('.moderation_process');				
	}
}

?>