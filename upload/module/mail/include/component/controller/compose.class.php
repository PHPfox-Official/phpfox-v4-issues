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
 * @package  		Module_Mail
 * @version 		$Id: compose.class.php 4921 2012-10-22 13:47:30Z Miguel_Espinoza $
 */
class Mail_Component_Controller_Compose extends Phpfox_Component
{
	private $_bReturn = null;
	
	public function process()
	{			
		Phpfox::isUser(true);		
		Phpfox::getUserParam('mail.can_compose_message', true);		
		$bClaiming = ($this->getParam('page_id') != false);
		
		if (Phpfox::getParam('mail.spam_check_messages') && Phpfox::isSpammer())
		{			
			return Phpfox_Error::display(Phpfox::getPhrase('mail.currently_your_account_is_marked_as_a_spammer'));
		}
		
		$aVals = $this->request()->getArray('val');
		$bIsSending = isset($aVals['sending_message']);
		
		$aUser = array();
		if (($iUserId = $this->request()->get('id')) || ($iUserId = $this->getParam('id')))
		{
			$aUser = Phpfox::getService('user')->getUser($iUserId, Phpfox::getUserField());			
			if (isset($aUser['user_id']))
			{
				
				if ($bClaiming == false && $bIsSending != true && Phpfox::getService('mail')->canMessageUser($aUser['user_id']) == false)
				{
					return Phpfox_Error::display(Phpfox::getPhrase('mail.unable_to_send_a_private_message_to_this_user_at_the_moment'));
				}
				
				$this->template()->assign('aUser', $aUser);
				if ($bClaiming)
				{
					$aPage = Phpfox::getService('pages')->getPage($this->getParam('page_id'));					
					$this->template()->assign(array(
						'iPageId' => $this->getParam('page_id'),
						'aPage' => $aPage,
						'sMessageClaim' => Phpfox::getPhrase('mail.page_claim_message', array(
							'title' => $aPage['title'],
							'url' => Phpfox::permalink('pages', $aPage['page_id'], $aPage['title'])
						))));
				}
			}
			
			(($sPlugin = Phpfox_Plugin::get('mail.component_controller_compose_controller_to')) ? eval($sPlugin) : false);
		}
		
		$bIsThreadForward = false;
		$iThreadId = 0;
		if (($iThreadId = $this->request()->getInt('forward_thread_id')))
		{
			$bIsThreadForward = true;
		}
		
		$aValidation = array(
			'subject' => Phpfox::getPhrase('mail.provide_subject_for_your_message'),
			'message' => Phpfox::getPhrase('mail.provide_message')
		);		
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			unset($aValidation['subject']);
		}
		
		if (Phpfox::isModule('captcha') && Phpfox::getUserParam('mail.enable_captcha_on_mail'))
		{
			$aValidation['image_verification'] = Phpfox::getPhrase('captcha.complete_captcha_challenge');
		}		
		
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_compose_controller_validation')) ? eval($sPlugin) : false);

		$oValid = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_form', 
				'aParams' => $aValidation
			)
		);
		
		if (($aVals = $this->request()->getArray('val')))
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
					if ($bClaiming)
					{
						$aVals['claim_page'] = true;
					}
					if (($aIds = Phpfox::getService('mail.process')->add($aVals)))
					{
						if (isset($aVals['page_id']) && !empty($aVals['page_id']))
						{
							Phpfox::getLib('database')->insert(Phpfox::getT('pages_claim'),array('status_id' => '1', 'page_id' => ((int)$aVals['page_id']), 'user_id' => Phpfox::getUserId(), 'time_stamp' => PHPFOX_TIME ));
						}
						
						if (PHPFOX_IS_AJAX)
						{
							$this->_bReturn = true;
							
							return true;
						}
						
						if (Phpfox::getParam('mail.threaded_mail_conversation'))
						{
							$this->url()->send('mail.thread' , array('id' => $aIds));
						}
						else
						{
							if (count($aIds) > 1)
							{
								$this->url()->send('mail.view' , array('id' => base64_encode(serialize($aIds))));
							}
							elseif(isset($aIds[0]))
							{
								$this->url()->send('mail.view' , array('id' => $aIds[0]));
							}
						}
					}
					else 
					{
						if (PHPFOX_IS_AJAX)
						{
							$this->_bReturn = false;

							return false;
						}
					}					
				}
				else 
				{
					if (PHPFOX_IS_AJAX)
					{
						$this->_bReturn = false;
						
						return false;
					}
				}
			}
			else 
			{
				if (PHPFOX_IS_AJAX)
				{
					$this->_bReturn = false;
						
					return false;
				}				
			}
		}
		
		Phpfox::getService('mail')->buildMenu();
		if (Phpfox::isModule('friend'))
		{
			$this->template()->setPhrase(array('friend.loading'));
		}
		if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
		{
				Phpfox::getService('tinymce')->load();
				$sTinyMceCode = str_replace('\'', '\\\'', Phpfox::getService('tinymce')->getJsCode());
				$sTinyMceCode = str_replace( array("\r\n", "\n", "\r"), '', $sTinyMceCode);
				//break here so I know where I left
				//$this->template()->assign(array('sTinyMceCode' => $sTinyMceCode));
				
		}
		$this->template()->setTitle(Phpfox::getPhrase('mail.compose_new_message'))
			->setBreadcrumb(Phpfox::getPhrase('mail.mail'), $this->url()->makeUrl('mail'))
			->setBreadcrumb(Phpfox::getPhrase('mail.compose_new_message'), $this->url()->makeUrl('mail.compose'), true)
			->setPhrase(array(
					'mail.add_new_folder',
					'mail.adding_new_folder',
					'mail.view_folders',
					'mail.edit_folders',
					'mail.you_will_delete_every_message_in_this_folder',
					
				)
			)
			->setEditor()
			->setHeader('cache', array(
					'switch_legend.js' => 'static_script',
					'switch_menu.js' => 'static_script',			
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'mail.js' => 'module_mail',
					'pager.css' => 'style_css'
				)
			)
			->assign(array(
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'iMaxRecipients' => Phpfox::getUserParam('mail.send_message_to_max_users_each_time'),
				'bIsThreadForward' => $bIsThreadForward,
				'sThreadsToForward' => $this->request()->get('forwards'),
				'sForwardThreadId' => $iThreadId
			)
		);
			
		if (!Phpfox::getUserParam('mail.can_add_attachment_on_mail'))
		{
			$this->template()->assign('bNoAttachaFile', true);
		}
		
		$this->setParam('attachment_share', array(		
				'type' => 'mail',
				'inline' => true,
				'id' => 'js_form_mail'
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_compose_clean')) ? eval($sPlugin) : false);
	}
	
	public function getReturn()
	{
		if (!$this->_bReturn)
		{
			Phpfox::getLib('ajax')->call('$Core.processForm(\'#js_mail_compose_submit\', true);');
		}
		
		return $this->_bReturn;
	}
}

?>