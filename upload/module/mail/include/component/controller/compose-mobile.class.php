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
 * @package 		Phpfox_Component
 * @version 		$Id: compose-mobile.class.php 2102 2010-11-09 15:36:59Z Miguel_Espinoza $
 */
class Mail_Component_Controller_Compose_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bFriendIsSelected = false;
		if (($iUserId = $this->request()->getInt('to')))
		{
			$aUser = Phpfox::getService('user')->getUser($iUserId, Phpfox::getUserField());			
			if (isset($aUser['user_id']))
			{
				//if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'mail.send_message'))
				if (!Phpfox::getService('mail')->canMessageUser($aUser['user_id']))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('mail.unable_to_send_a_private_message_to_this_user_at_the_moment'));
				}
				
				$bFriendIsSelected = true;
				
				$this->template()->assign('aUser', $aUser);
			}			
		}
		if (Phpfox::getParam('mail.spam_check_messages') && Phpfox::isSpammer())
		{
			return Phpfox_Error::display(Phpfox::getPhrase('mail.currently_your_account_is_marked_as_a_spammer'));
		}
		
		$aValidation = array(
			'subject' => Phpfox::getPhrase('mail.provide_subject_for_your_message'),
			'message' => Phpfox::getPhrase('mail.provide_message')
		);		

		$oValid = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_form', 
				'aParams' => $aValidation
			)
		);
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			// Lets make sure they are actually trying to send someone a message.			
			if (((!isset($aVals['to'])) || (isset($aVals['to']) && !count($aVals['to']))) && (!isset($aVals['copy_to_self']) || $aVals['copy_to_self'] != 1))
			{
				Phpfox_Error::set(Phpfox::getPhrase('mail.select_a_member_to_send_a_message_to'));
			}
						
			if ($oValid->isValid($aVals))
			{				
				if (Phpfox::getParam('mail.mail_hash_check'))
				{
					Phpfox::getLib('spam.hash', array(
								'table' => 'mail_hash',
								'total' => Phpfox::getParam('mail.total_mail_messages_to_check'),
								'time' => Phpfox::getParam('mail.total_minutes_to_wait_for_pm'),
								'content' => $aVals['message']
							)				
						)->isSpam();					
				}
				
				if (Phpfox::getParam('mail.spam_check_messages'))
				{
					if (Phpfox::getLib('spam')->check(array(
								'action' => 'isSpam',										
								'params' => array(
									'module' => 'comment',
									'content' => Phpfox::getLib('parse.input')->prepare($aVals['message'])
								)
							)
						)
					)
					{
						Phpfox_Error::set(Phpfox::getPhrase('mail.this_message_feels_like_spam_try_again'));
					}
				}				
				
				if (Phpfox_Error::isPassed())
				{
					$aIds = Phpfox::getService('mail.process')->add($aVals);
					
					$this->url()->send('mail.view' , array('id' => $aIds[0]));
				}
			}
		}			
		
		$this->template()->assign(array(
				'bMobileInboxIsActive' => true,			
				'bFriendIsSelected' => $bFriendIsSelected,	
				'aMobileSubMenus' => array(
					$this->url()->makeUrl('mail') => Phpfox::getPhrase('mail.mobile_messages'),
					$this->url()->makeUrl('mail', 'sent') => Phpfox::getPhrase('mail.sent'),
					$this->url()->makeUrl('mail', 'compose') => Phpfox::getPhrase('mail.compose')
				),
				'sActiveMobileSubMenu' => $this->url()->makeUrl('mail', 'compose')
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_compose_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>