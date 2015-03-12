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
 * @version 		$Id: ajax.class.php 6749 2013-10-08 13:04:25Z Miguel_Espinoza $
 */
class Mail_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	public function mailThreadAction()
	{
		
	}
	
	public function forwardThread()
	{
		
	}
	
	public function archive()
	{		
		foreach ((array) $this->get('item_moderate') as $iId)
		{
			Phpfox::getService('mail.process')->archiveThread($iId, ($this->get('action') == 'un-archive' ? '0' : '1'));
			
			$this->call('$("#js_message_'. $iId.'").slideUp("slow", function(){$(this).remove();});');
		}		
		
		$this->alert(($this->get('action') == 'un-archive' ? Phpfox::getPhrase('mail.messages_un_archived') : Phpfox::getPhrase('mail.messages_archived')), Phpfox::getPhrase('mail.moderation'), 300, 150, true);
		$this->hide('.moderation_process');			
	}
	
	public function viewMoreThreadMail()
	{
		list($aCon, $aMessages) = Phpfox::getService('mail')->getThreadedMail($this->get('thread_id'), $this->get('page'));
		if ($aCon === false || ($aCon !== false && !count($aMessages)))
		{
			$this->hide('#feed_view_more_loader');
			$this->hide('#js_mail_thread_view_more');
			
			return;
		}		
		
		$iCnt = 0;
		foreach ($aMessages as $aMail)
		{
			$iCnt++;
			Phpfox::getLib('template')->assign(array(
					'aMail' => $aMail,
					'aCon' => $aCon,
					'bIsLastMessage' => ($iCnt == count($aMessages) ? true : false)
				)
			)->getTemplate('mail.block.entry');				
		}
		
		$this->prepend('#mail_threaded_view_more_messages', $this->getContent(false));
		$this->call('$Core.mailThreadReset();');
		$this->call('$Core.loadInit();');
	}
	
	public function addThreadMail()
	{				
		$aVals = $this->get('val');
		
		if (($iNewId = Phpfox::getService('mail.process')->add($aVals)))
		{
			list($aCon, $aMessages) = Phpfox::getService('mail')->getThreadedMail($iNewId);
			
			$aMessages = array_reverse($aMessages);
			
			Phpfox::getLib('template')->assign(array(
					'aMail' => $aMessages[0],
					'aCon' => $aCon,
					'bIsLastMessage' => true
				)
			)->getTemplate('mail.block.entry');			
			
			$this->call('$(\'.mail_thread_holder\').removeClass(\'is_last_message\');');
			$this->append('#mail_threaded_new_message', $this->getContent(false));
			$this->call("$.scrollTo('.is_last_message:first');");
			$this->call("$('.mail_thread_form_holder').addClass('not_fixed');");
		}		
	}
	
	public function delete()
	{
		Phpfox::isUser(true);
		
		$sType = $this->get('type');		
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			Phpfox::getService('mail.process')->archiveThread($this->get('id'));
			$this->slideUp('#js_message_' . $this->get('id'));
		}
		else
		{
			if (($sType == 'trash' ? Phpfox::getService('mail.process')->deleteTrash($this->get('id')) : Phpfox::getService('mail.process')->delete($this->get('id'), ($sType == 'sentbox' ? true : false))))
			{
				$this->slideUp('#js_message_' . $this->get('id'));
			}
		}
	}
	
	public function newFolder()
	{
		Phpfox::isUser(true);
		$this->setTitle(Phpfox::getPhrase('mail.new_folder'));
		Phpfox::getBlock('mail.box.add');
	}
	
	public function move()
	{
		Phpfox::isUser(true);
				
		if (Phpfox::getService('mail.folder.process')->move($this->get('folder'), $this->get('item_moderate')))
		{
			$this->call('$Core.moderationLinkClear();');
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('mail', array('view' => 'box', 'id' => $this->get('folder'))) . '\';');
		}
	}	
	
	public function addFolder()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('mail.can_add_folders', true);
		
		$sFolder = $this->get('add_folder');

		if (Phpfox::getService('mail.folder')->reachedLimit()) // Did they reach their limit?
		{
			$this->html('#js_mail_folder_add_error', Phpfox::getPhrase('mail.you_have_reached_your_limit'), '.show()');
			$this->call('$Core.processForm(\'#js_mail_folder_add_submit\', true);');
		}		
		elseif (Phpfox::getService('mail.folder')->isFolder($sFolder)) // Is there already a folder like this one?
		{
			$this->html('#js_mail_folder_add_error', Phpfox::getPhrase('mail.folder_already_use', array('phpfox_squote' => true)), '.show()');
			$this->call('$Core.processForm(\'#js_mail_folder_add_submit\', true);');			
		}
		elseif (Phpfox::getLib('parse.format')->isEmpty($sFolder))
		{
			$this->html('#js_mail_folder_add_error', Phpfox::getPhrase('mail.provide_a_name_for_your_folder', array('phpfox_squote' => true)), '.show()');
			$this->call('$Core.processForm(\'#js_mail_folder_add_submit\', true);');						
		}
		else // Everything is okay, lets add the folder
		{			
			if ($iId = Phpfox::getService('mail.folder.process')->add($sFolder))
			{
				$sNew = Phpfox::getLib('parse.output')->clean(Phpfox::getLib('parse.input')->clean($sFolder, 255));

				$this->call('js_box_remove($(\'#js_mail_folder_add_error\'));');
				$this->alert(Phpfox::getPhrase('mail.folder_successfully_created'), Phpfox::getPhrase('mail.create_new_folder'), 400, 150, true);
				$this->append('.sub_section_menu ul', '<li><a href="' . Phpfox::getLib('url')->makeUrl('mail', array('view' => 'box', 'id' => $iId)) . '">' . str_replace("'", "\\'", Phpfox::getLib('parse.input')->clean($sNew)) . '</a></li>');
			}
		}
	}
	
	public function editFolders()
	{
		Phpfox::getBlock('mail.box.edit');
		$this->call("$('#js_mail_box_folders').hide();");			
		$this->html('#js_edit_folders', $this->getContent(false), '.show()');	
		$this->call('$Core.loadInit();');
	}
	
	public function updateFolder()
	{
	    $aVal = $this->get('val');	    
	    $sFolder = reset($aVal['name']);
	    if (Phpfox::getLib('parse.format')->isEmpty($sFolder))
	    {
		
		
	    	$this->call("$('#js_process_form_image').hide(); alert('" . Phpfox::getPhrase('mail.provide_a_name_for_your_folder', array('phpfox_squote' => true)) . "'); $('#js_edit_input_folder_1 :input').focus();");
	    }
	    elseif (Phpfox::getService('mail.folder.process')->update($aVal))
		{
			Phpfox::getBlock('mail.folder', array(
				'bIsAjax' => true
			));			
			
			$this->call("$('#js_mail_box_folders').parent().html('" . $this->getContent() . "').show(); $('#js_block_bottom_link_1').html('" . Phpfox::getPhrase('mail.edit_folders', array('phpfox_squote' => true)) . "'); \$Core.loadInit();");
		}
	}
	
	public function deleteFolder()
	{
		if (Phpfox::getService('mail.folder.process')->delete($this->get('id')))
		{
			Phpfox::addMessage(Phpfox::getPhrase('mail.folder_successfully_deleted'));
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('mail') . '\'');
		}
	}
	
	public function compose()
	{
		Phpfox::isUser(true);
		if (Phpfox::getUserParam('mail.can_compose_message') == false)
		{
			echo '<script type="text/javascript">window.location = "'. Phpfox::getLib('url')->makeUrl('subscribe') .'"; </script>';
			return;
		}
		$this->setTitle(Phpfox::getPhrase('mail.new_message'));
		
		Phpfox::getComponent('mail.compose', null, 'controller');		
		
		(($sPlugin = Phpfox_Plugin::get('mail.component_ajax_compose')) ? eval($sPlugin) : false);
		
		echo '<script type="text/javascript">$Core.loadInit();$Core.loadInit();</script>';
	}
	
	public function composeProcess()
	{
		Phpfox::isUser(true);
		
		$this->errorSet('#js_ajax_compose_error_message');
		
		$oObject = Phpfox::getComponent('mail.compose', null, 'controller');
		
		if ($oObject->getReturn())
		{
			$this->call('$(\'#\' + tb_get_active()).find(\'.js_box_content:first\').html(\'<div class="message">' . str_replace("'", "\\'", Phpfox::getPhrase('mail.your_message_was_successfully_sent')) . '</div>\'); setTimeout(\'tb_remove();\', 2000);');
		}
	}

	/**
	 * Allows reading a message given its id
	 * @return void
	 */
	public function readMessage()
	{
		define('PHPFOX_IS_ADMIN_NEW', true);
		
		// security checks
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getUserParam('mail.can_read_private_messages', true);
		
		$iId = $this->get('id');
		
		if (!is_numeric($iId))
		{
			return false;
		}
		
		$this->setTitle('Viewing Message');
		
		Phpfox::getBlock('mail.message');
	}

	/**
	 * delicate function, deletes a message from the mail and mail_text table
	 */
	public function deleteMessage()
	{
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getUserParam('mail.can_read_private_messages', true);

		$iId = $this->get('id');
		
		if (!is_numeric($iId))
		{
			return false;
		}
		Phpfox::getService('mail.process')->adminDelete($iId);
		$this->call('$("#js_mail_'.$iId.'").remove();');

	}
	
	public function getLatest()
	{
		if (!Phpfox::isUser())
		{
			$this->call('<script type="text/javascript">window.location.href = \'' . Phpfox::getLib('url')->makeUrl('user.login') . '\';</script>');
		}
		else
		{
			Phpfox::getBlock('mail.latest');
		}
	}
	
	public function toggleRead()
	{
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			Phpfox::getService('mail.process')->toggleThreadIsRead($this->get('id'));
		}
		else
		{
			if (Phpfox::getService('mail.process')->toggleRead($this->get('id')))
			{

			}
		}
	}
	
	public function moderation()
	{
		switch ($this->get('action'))
		{
			case 'delete':
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					if ($this->get('trash'))
					{
						Phpfox::getService('mail.process')->deleteTrash($iId);
					}
					else
					{
						Phpfox::getService('mail.process')->delete($iId, ($this->get('sent') ? true : false));
					}					
					//$this->slideUp('#js_message_' . $iId);
					$this->call('$("#js_message_'. $iId.'").slideUp("slow", function(){$(this).remove();});');
				}				
				$sMessage = Phpfox::getPhrase('mail.message_s_successfully_deleted');				
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');		
	}
	
	public function listFolders()
	{
		$this->setTitle(Phpfox::getPhrase('mail.select_folder'));		
		
		Phpfox::getBlock('mail.box.select');
	}
	
	public function markAllRead()
	{
		Phpfox::getService('mail.process')->markAllRead();
		$this->call('window.location.href=window.location.href');
	}
}

?>