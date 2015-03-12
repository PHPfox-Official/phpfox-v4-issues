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
 * @version 		$Id: index.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class Mail_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);		
		
		$bIsInLegacyView = false;
		if (Phpfox::getParam('mail.threaded_mail_conversation') && $this->request()->get('legacy'))
		{				
			Phpfox::getLib('setting')->setParam('mail.threaded_mail_conversation', false);
			$bIsInLegacyView = true;			
		}
		
		$this->setParam('bIsInLegacyView', $bIsInLegacyView);
		
		if (($aItemModerate = $this->request()->get('item_moderate')))
		{
			$sFile = Phpfox::getService('mail')->getThreadsForExport($aItemModerate);
			
			Phpfox::getLib('file')->forceDownload($sFile, 'mail.xml');
		}
		
		$iPage = $this->request()->getInt('page');
		$iPageSize = 10;
		$bIsSentbox = ($this->request()->get('view') == 'sent' ? true : false);
		$bIsTrash = ($this->request()->get('view') == 'trash' ? true : false);
		$iPrivateBox = ($this->request()->get('view') == 'box' ? $this->request()->getInt('id') : false);

		$bIs = $this->getParam('bIsSentbox');
		
		if ($this->request()->get('action') == 'archive')
		{
			Phpfox::getService('mail.process')->archiveThread($this->request()->getInt('id'), 1);
			
			$this->url()->send('mail.trash', null, Phpfox::getPhrase('mail.message_successfully_archived'));
		}
		
		if ($this->request()->get('action') == 'forcedelete')
		{
			Phpfox::getService('mail.process')->archiveThread($this->request()->getInt('id'), 2);
				
			$this->url()->send('mail.trash', null, Phpfox::getPhrase('mail.conversation_successfully_deleted'));
		}		
		
		if ($this->request()->get('action') == 'unarchive')
		{
			Phpfox::getService('mail.process')->archiveThread($this->request()->getInt('id'), 0);
			
			$this->url()->send('mail', null, Phpfox::getPhrase('mail.message_successfully_unarchived'));
		}				
		
		if ($this->request()->get('action') == 'delete')
		{
			$iMailId = $this->request()->getInt('id');
			if (!is_int($iMailId) || empty($iMailId))
			{
				Phpfox_Error::set(Phpfox::getPhrase('mail.no_mail_specified'));
			}
			else
			{
				$bTrash = $this->getParam('bIsTrash');
				if (!isset($bTrash) || !is_bool($bTrash))
				{
					$bIsTrash = Phpfox::getService('mail')->isDeleted($iMailId);
				}
				if ($bIsTrash)
				{
					if (Phpfox::getService('mail.process')->deleteTrash($iMailId))
					{
						$this->url()->send('mail.trash', null, Phpfox::getPhrase('mail.mail_deleted_successfully'));
					}
					else
					{
						Phpfox_Error::set(Phpfox::getPhrase('mail.mail_could_not_be_deleted'));
					}
				}
				else
				{
					
					$bIsSent = $this->getParam('bIsSentbox');
					if (!isset($bIsSent) || !is_bool($bIsSent))
					{
						$bIsSentbox = Phpfox::getService('mail')->isSent($iMailId);
					}
					
					if (Phpfox::getService('mail.process')->delete($iMailId, $bIsSentbox))
					{						
						$this->url()->send($bIsSentbox == true ? 'mail.sentbox' : 'mail', null, Phpfox::getPhrase('mail.mail_deleted_successfully'));
					}
					else
					{
						Phpfox_Error::set(Phpfox::getPhrase('mail.mail_could_not_be_deleted'));
					}
				}

			}
		}

		if (($aVals = $this->request()->getArray('val')) && isset($aVals['action']))
		{
			if (isset($aVals['id']))
			{ //make sure there is at least one selected
				$oMailProcess = Phpfox::getService('mail.process');
				switch ($aVals['action'])
				{
					case 'unread':
						case 'read':
							foreach ($aVals['id'] as $iId)
							{
								$oMailProcess->toggleView($iId, ($aVals['action'] == 'unread' ? true : false));
							}

							$sMessage = Phpfox::getPhrase('mail.messages_updated');
							break;
						case 'delete':
							
							if (isset($aVals['select']) && $aVals['select'] == 'every')
							{
								$aMail = Phpfox::getService('mail')->getAllMailFromFolder(Phpfox::getUserId(),(int)$aVals['folder'], $bIsSentbox, $bIsTrash);
								$aVals['id'] = $aMail;
							}
							
							foreach ($aVals['id'] as $iId)
							{
								($bIsTrash ? $oMailProcess->deleteTrash($iId) : $oMailProcess->delete($iId, $bIsSentbox));
							}
						
							$sMessage = Phpfox::getPhrase('mail.messages_deleted');
							break;
						case 'undelete':
							foreach ($aVals['id'] as $iId)
							{
								$oMailProcess->undelete($iId);
							}
							$sMessage = Phpfox::getPhrase('mail.messages_updated');
							break;
					}


				}
				else
				{ // didnt select any message
					$sMessage = Phpfox::getPhrase('mail.error_you_did_not_select_any_message');

				}
				// define the mail box that the user was looking at
				$mSend = null;
				if ($bIsSentbox)
				{
					$mSend = array('sentbox');
				}
				elseif ($bIsTrash)
				{
					$mSend = array('trash');
				}
				elseif ($iPrivateBox)
				{
					$mSend = array('box', 'id' => $iPrivateBox);
				}

				// send the user to that folder with the message
				$this->url()->send('mail', $mSend, $sMessage);
			}
			
			$this->search()->set(array(
					'type' => 'mail',
					'field' => 'mail.mail_id',				
					'search_tool' => array(
						'table_alias' => 'm',
						'search' => array(
							'action' => $this->url()->makeUrl('mail', array('view' => $this->request()->get('view'), 'id' => $this->request()->get('id'))),
							'default_value' => Phpfox::getPhrase('mail.search_messages'),
							'name' => 'search',
							'field' => array('m.subject', 'm.preview')
						),
						'sort' => array(
							'latest' => array('m.time_stamp', Phpfox::getPhrase('mail.latest')),
							'most-viewed' => array('m.viewer_is_new', Phpfox::getPhrase('mail.unread_first'))
						),
						'show' => array(10, 15, 20)
					)
				)
			);		
			
			$iPageSize = $this->search()->getDisplay();

			$aFolders = Phpfox::getService('mail.folder')->get();

			$sUrl = '';
			$sFolder = '';
			if (Phpfox::getParam('mail.threaded_mail_conversation'))
			{				
				if ($bIsTrash)
				{
					$sUrl = $this->url()->makeUrl('mail.trash');					
					$this->search()->setCondition('AND m.owner_user_id = ' . Phpfox::getUserId() . ' AND m.is_archive = 1');
				}
				else
				{
					if ($bIsSentbox)
					{
						$sUrl = $this->url()->makeUrl('mail.sentbox');
					}
					else
					{					
						$sUrl = $this->url()->makeUrl('mail');						
					}					
					$this->search()->setCondition('AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.is_archive = 0');
				}
			}
			else
			{
				if ($bIsTrash)
				{
					$sFolder = Phpfox::getPhrase('mail.trash');
					$sUrl = $this->url()->makeUrl('mail.trash');
					$this->search()->setCondition('AND (m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = 1) OR (m.owner_user_id = ' . Phpfox::getUserId() . ' AND m.owner_type_id = 1)');					
					// $this->search()->setCondition('AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = 1');
				}
				elseif ($iPrivateBox)
				{
					if (isset($aFolders[$iPrivateBox]))
					{
						$sFolder = $aFolders[$iPrivateBox]['name'];
						$sUrl = $this->url()->makeUrl('mail.box', array('id' => (int) $iPrivateBox));
						$this->search()->setCondition('AND m.viewer_folder_id = ' . (int) $iPrivateBox . ' AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = 0');
					}
					else
					{
						$this->url()->send('mail', null, Phpfox::getPhrase('mail.mail_folder_does_not_exist'));
					}
				}
				else
				{
					if ($bIsSentbox)
					{
						$sFolder = Phpfox::getPhrase('mail.sent_messages');
						$sUrl = $this->url()->makeUrl('mail.sentbox');
						$this->search()->setCondition('AND m.owner_user_id = ' . Phpfox::getUserId() . ' AND m.owner_type_id = 0');
					}
					else
					{
						$sFolder = Phpfox::getPhrase('mail.inbox');
						$sUrl = $this->url()->makeUrl('mail');
						$this->search()->setCondition('AND m.viewer_folder_id = 0 AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = 0');
					}
				}
			}
			
			list($iCnt, $aRows, $aInputs) = Phpfox::getService('mail')->get($this->search()->getConditions(), $this->search()->getSort(), $this->search()->getPage(), $iPageSize, $bIsSentbox, $bIsTrash);

			Phpfox::getLib('pager')->set(array(
					'page' => $iPage,
					'size' => $iPageSize,
					'count' => $iCnt
				)
			);
			
		Phpfox::getService('mail')->buildMenu();
			
		$aActions = array();
		$aActions[] = array(
			'phrase' => Phpfox::getPhrase('mail.delete'),
			'action' => 'delete'
		);
		if (!$bIsSentbox && !$bIsInLegacyView)
		{
			$aActions[] = array(
				'phrase' => Phpfox::getPhrase('mail.move'),
				'action' => 'move'
			);
		}
		
		$aModeration = array(
				'name' => 'mail',
				'ajax' => 'mail.moderation',
				'menu' => $aActions
			);
			
		if ($bIsSentbox)
		{
			$aModeration['custom_fields'] = '<div><input type="hidden" name="sent" value="1" /></div>';
		}
		elseif ($bIsTrash)
		{
			$aModeration['custom_fields'] = '<div><input type="hidden" name="trash" value="1" /></div>';
		}
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$aModeration['ajax'] = 'mail.archive';
			
			$aMenuOptions = array();
			if ($bIsTrash)
			{
				$aMenuOptions = array(
					'phrase' => Phpfox::getPhrase('mail.un_archive'),
					'action' => 'un-archive'
				);
			}
			else
			{
				$aMenuOptions = array(
					'phrase' => Phpfox::getPhrase('mail.archive'),
					'action' => 'archive'
				);
			}
			
			$aModeration['menu'] = array($aMenuOptions,
				array(
					'phrase' => Phpfox::getPhrase('mail.export'),
					'action' => 'export'
				)					
			);
		}
			
		$this->setParam('global_moderation', $aModeration);			

		if (empty($sFolder))
		{
			$sFolder = Phpfox::getPhrase('mail.mail');
		}
		$iMailSpaceUsed = 0;
		if ((!Phpfox::getUserParam('mail.override_mail_box_limit') && Phpfox::getParam('mail.enable_mail_box_warning')))
		{
			$iMailSpaceUsed = Phpfox::getService('mail')->getSpaceUsed(Phpfox::getUserId());
			if ($iMailSpaceUsed > 100)
			{
				$iMailSpaceUsed = 100;
			}
		}		
		
			$this->template()->setTitle($sFolder)
				->setBreadcrumb(Phpfox::getPhrase('mail.mail'), $this->url()->makeUrl('mail'))
				->setPhrase(array(
						'mail.add_new_folder',
						'mail.adding_new_folder',
						'mail.view_folders',
						'mail.edit_folders',
						'mail.you_will_delete_every_message_in_this_folder',
						'mail.updating'
					)
				)
				->setHeader('cache', array(
						'jquery/plugin/jquery.highlightFade.js' => 'static_script',
						'quick_edit.js' => 'static_script',	
						'selector.js' => 'static_script',
						'mail.js' => 'module_mail',
						'pager.css' => 'style_css',
						'mail.css' => 'style_css'
					)
				)			
				->assign(array(
					'aMails' => $aRows,
					'bIsSentbox' => $bIsSentbox,
					'bIsTrash' => $bIsTrash,
					'aInputs' => $aInputs,
					'aFolders' => $aFolders,
					'iMailSpaceUsed' => $iMailSpaceUsed,
					'iMessageAge' => Phpfox::getParam('mail.message_age_to_delete'),
					'sUrl' => $sUrl,
					'iFolder' => (isset($aFolders[$iPrivateBox]['folder_id']) ? $aFolders[$iPrivateBox]['folder_id'] : 0),
					'iTotalMessages' => $iCnt,
					'sSiteName' => Phpfox::getParam('core.site_title'),
					'bIsInLegacyView' => $bIsInLegacyView
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>
