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
 * @version 		$Id: invitations.class.php 3215 2011-10-05 14:40:56Z Raymond_Benc $
 */
class Invite_Component_Controller_Invitations extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		if ($iInvite = $this->request()->getInt('del'))
		{
			$bDel = Phpfox::getService('invite.process')->delete($iInvite, Phpfox::getUserId());
			if ($bDel)
			{
				$this->url()->send('invite.invitations', null, Phpfox::getPhrase('invite.invitation_deleted'));
			}
			$this->url()->send('invite.invitations', null, Phpfox::getPhrase('invite.invitation_not_found'));
		}
		elseif ($aInvite = $this->request()->get('val'))
		{
			$bDel = true;
			foreach ($aInvite as $iInvite)
			{
				$bDel = $bDel && Phpfox::getService('invite.process')->delete($iInvite, Phpfox::getUserId());
			}
			if ($bDel)
			{
				$this->url()->send('invite.invitations', null, Phpfox::getPhrase('invite.invitation_deleted'));
			}
			$this->url()->send('invite.invitations', null, Phpfox::getPhrase('invite.invitation_not_found'));
		}
		$iPage = $this->request()->getInt('page');
		$iPageSize = (int) Phpfox::getParam('invite.pendings_to_show_per_page');		

		list($iCnt, $aInvites) = Phpfox::getService('invite')->get(Phpfox::getUserId(), $iPage, $iPageSize);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
		
		$this->setParam('global_moderation', array(
				'name' => 'invitations',
				'ajax' => 'invite.moderation',
				'menu' => array(
					array(
						'phrase' => 'Delete',
						'action' => 'delete'
					)			
				)
			)
		);
		
		$this->template()->setTitle(Phpfox::getPhrase('invite.pending_invitations'))
			->setBreadcrumb(Phpfox::getPhrase('invite.pending_invitations'))
			->assign(array(
					'aInvites' => $aInvites,
					'iPage' => $iPage
				)
			)
			->setHeader('cache', array(
					'pager.css' => 'style_css',
					'pending.js' => 'module_invite'
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('invite.component_controller_invitations_clean')) ? eval($sPlugin) : false);
	}
}

?>