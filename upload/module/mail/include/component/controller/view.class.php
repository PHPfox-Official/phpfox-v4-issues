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
 * @version 		$Id: view.class.php 4937 2012-10-23 07:55:25Z Raymond_Benc $
 */
class Mail_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		Phpfox::isUser(true);
		$bIsSentbox = false;
		$bIsTrash = false;
		$bIsCustomFolder = false;
		$iId = $this->request()->get('id');
		if (empty($iId))
		{
			$iId = $this->request()->get('req3');
		}		
			
		$oParseOutput = Phpfox::getLib('parse.output');
		$oMail = Phpfox::getService('mail');	
		
		if (!is_numeric($iId))
		{
			$aIds = unserialize(base64_decode($iId));
			$sIds = '';
			foreach ($aIds as $iMassId)
			{
				if (empty($iMassId))
				{
					continue;
				}
				
				if (!is_numeric($iMassId))
				{
					continue;
				}
				
				$sIds .= $iMassId . ',';
			}
			
			list($iCnt, $aMails, $aInputs) = $oMail->get(array("m.mail_id IN(" . rtrim($sIds, ',') . ")"), 'm.time_updated DESC', 0, 20, true);
			if (isset($aMails[0]))
			{
				$iId = $aMails[0]['mail_id'];
			}
			$this->template()->assign(array(
					'bMass' => true,
					'aMails' => $aMails
				)
			);
		}
		
		$aMail = $oMail->getMail($iId, true);

		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_view_process_start')) ? eval($sPlugin) : false);

		if (!isset($aMail['mail_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('mail.invalid_message'));
		}
		
		$bCanView = false;
		if (($aMail['viewer_user_id'] == Phpfox::getUserId()) || ($aMail['owner_user_id'] == Phpfox::getUserId()))
		{
			$bCanView = true;			
		}
		
		if ($bCanView === false)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('mail.invalid_message'));
		}
		
		if ($aMail['viewer_user_id'] == Phpfox::getUserId())
		{
			Phpfox::getService('mail.process')->toggleView($aMail['mail_id'], false);
		}
		
		$aValidation = array(
			'message' => Phpfox::getPhrase('mail.add_reply')
		);		
		
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_view_process_validation')) ? eval($sPlugin) : false);

		$oValid = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_form', 
				'aParams' => $aValidation
			)
		);
		
		if (($aVals = $this->request()->getArray('val')))
		{			
			if ($oValid->isValid($aVals))
			{
				$aVals['to'] = $aMail['owner_user_id'];
				
				if (($iNewId = Phpfox::getService('mail.process')->add($aVals)))
				{
					$this->url()->send('mail.view', array('id' => $iNewId));
				}
			}
		}		
		
		$sTitle = $oParseOutput->clean($aMail['subject'], 255);		
				
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_view_process_end')) ? eval($sPlugin) : false);

		$sFolder = Phpfox::getPhrase('mail.inbox');
		$sLink = $this->url()->makeUrl('mail', array('view' => 'inbox'));
		if (isset($aMail['folder_name']['name']))
		{
			$sFolder = $aMail['folder_name']['name'];
			$bIsCustomFolder = true;
			$sLink = $this->url()->makeUrl('mail', array('view' => 'box', 'id' => $aMail['folder_name']['folder_id']));
		}
		else 
		{
			if ($aMail['viewer_user_id'] != Phpfox::getUserId())
			{
				$sFolder = Phpfox::getPhrase('mail.sent_messages');
				$bIsSentbox = true;
				$sLink = $this->url()->makeUrl('mail', array('view' => 'sentbox'));
				if ($aMail['owner_type_id'] == 1)
				{
					$sFolder = Phpfox::getPhrase('mail.trash');
					$bIsTrash = true;
					$bIsActualTrash = true;					
					$sLink = $this->url()->makeUrl('mail', array('view' => 'trash'));
				}
				elseif ($aMail['owner_type_id'] == 3)
				{
					return Phpfox_Error::display(Phpfox::getPhrase('mail.invalid_message'));
				}
			}
			else 
			{
				if ($aMail['viewer_type_id'] == 1)
				{
					$sFolder = Phpfox::getPhrase('mail.trash');
					$bIsTrash = true;
					$sLink = $this->url()->makeUrl('mail', array('view' => 'trash'));
				}
				elseif ($aMail['viewer_type_id'] == 3)
				{
					return Phpfox_Error::display(Phpfox::getPhrase('mail.invalid_message'));
				}				
			}
		}
		
		if ($bIsSentbox && !isset($bIsActualTrash))
		{
			$this->request()->set('view', 'sent');
		}
		elseif ($bIsTrash)
		{
			$this->request()->set('view', 'trash');
		}
		/*
		elseif ($bIsCustomFolder)
		{
			$this->request()->set('view', 'box');
			$this->request()->set('id', '2');
		}		
		*/
		// check for attachments only if needed.
		if ($aMail['total_attachment'] > 0)
		{
			list($iCnt, $aAttachments) = Phpfox::getService('attachment')->get(array('AND attachment.item_id = ' . ($aMail['mass_id'] ? $aMail['mass_id'] : $aMail['mail_id']) . ' AND attachment.category_id = \'mail\' AND is_inline = 0'), 'attachment.attachment_id DESC', '', '', false);
			
			$this->template()->assign(array(
					'aAttachments' => $aAttachments					
				)
			);
		}
		

		$this->template()->setBreadcrumb(Phpfox::getPhrase('mail.mail'), $this->url()->makeUrl('mail'));					

		Phpfox::getService('mail')->buildMenu();
		
		$this->template()
			->setBreadcrumb($oParseOutput->split($sTitle, 50), $this->url()->makeUrl('mail.view', array('id' => $aMail['mail_id'])), true)	
			->setTitle(Phpfox::getPhrase('mail.message') . ': ' . $sTitle)
			->setPhrase(array(
					'mail.add_new_folder',
					'mail.adding_new_folder',
					'mail.view_folders',
					'mail.edit_folders',
					'mail.you_will_delete_every_message_in_this_folder'
				)
			)	
			->setEditor()			
			->setHeader('cache', array(
					'mail.js' => 'module_mail',
					'mail.css' => 'style_css'
				)
			)			
			->assign(array(
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'aMail' => $aMail,				
				'iPrevId' => $oMail->getPrev($aMail['time_updated'], $bIsSentbox, $bIsTrash),
				'iNextId' => $oMail->getNext($aMail['time_updated'], $bIsSentbox, $bIsTrash),
				'sSite' => Phpfox::getParam('core.site_title')
			)
		); 
		
		$this->setParam('attachment_share', array(		
				'type' => 'mail',
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
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>