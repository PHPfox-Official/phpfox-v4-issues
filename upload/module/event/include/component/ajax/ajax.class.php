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
 * @package  		Module_Event
 * @version 		$Id: ajax.class.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
class Event_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function loadMiniForm()
	{
		Phpfox::getBlock('event.mini');
		
		$sContent = $this->getContent(false);
		$sContent = str_replace(array("\n", "\t"), '', $sContent);
		
		$this->html('.block_event_sub_holder', $sContent);
		$this->call('$Core.loadInit();');
	}
	
	public function deleteImage()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('event.process')->deleteImage($this->get('id')))
		{
			
		}
	}
	
	public function addRsvp()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('event.process')->addRsvp($this->get('id'), $this->get('rsvp'), Phpfox::getUserId()))
		{
			if ($this->get('rsvp') == 3)
			{
				$sRsvpMessage = Phpfox::getPhrase('event.not_attending');
			}
			elseif ($this->get('rsvp') == 2)
			{
				$sRsvpMessage = Phpfox::getPhrase('event.maybe_attending');
			}
			elseif ($this->get('rsvp') == 1)
			{
				$sRsvpMessage = Phpfox::getPhrase('event.attending');
			}
			
			if ($this->get('inline'))
			{
				$this->html('#js_event_rsvp_' . $this->get('id'), $sRsvpMessage);
				$this->hide('#js_event_rsvp_invite_image_' . $this->get('id'));
			}
			else 
			{
				$this->html('#js_event_rsvp_update', Phpfox::getPhrase('event.done'), '.fadeOut(5000);')
					->html('#js_event_rsvp_' . $this->get('id'), $sRsvpMessage)
					->call('$(\'#js_event_rsvp_button\').find(\'input:first\').attr(\'disabled\', false);')
					->call('tb_remove();');
				
				$this->call('$.ajaxCall(\'event.listGuests\', \'&rsvp=' . $this->get('rsvp') . '&id=' . $this->get('id') . '' . ($this->get('module') ? '&module=' . $this->get('module') . '&item=' . $this->get('item') . '' : '') . '\');')
					->call('$Behavior.event_ajax_1 = function(){ $(\'#js_block_border_event_list .menu:first ul li\').removeClass(\'active\'); $(\'#js_block_border_event_list .menu:first ul li a\').each(function() { var aParts = explode(\'rsvp=\', this.href); var aParts2 = explode(\'&\', aParts[1]); if (aParts2[0] == ' . $this->get('rsvp') . ') {  $(this).parent().addClass(\'active\'); } }); };');
			}
		}
	}
	
	public function listGuests()
	{
		Phpfox::getBlock('event.list');
		
		$this->html('#js_event_item_holder', $this->getContent(false));
	}
	
	public function browseList()
	{	
		Phpfox::getBlock('event.browse');
		
		if ((int) $this->get('page') > 0)
		{
			$this->html('#js_event_browse_guest_list', $this->getContent(false));
		}
		else 
		{
			$this->setTitle(Phpfox::getPhrase('event.guest_list'));	
		}
	}
	
	public function deleteGuest()
	{
		if (Phpfox::getService('event.process')->deleteGuest($this->get('id')))
		{
			
		}
	}
	
	public function delete()
	{
		if (Phpfox::getService('event.process')->delete($this->get('id')))
		{
			$this->call('$(\'#js_event_item_holder_' . $this->get('id') . '\').html(\'<div class="message" style="margin:0px;">' . Phpfox::getPhrase('event.successfully_deleted_event') . '</div>\').fadeOut(5000);');			
		}
	}
	
	public function rsvp()
	{
		Phpfox::getBlock('event.rsvp');
	}
	
	public function feature()
	{
		if (Phpfox::getService('event.process')->feature($this->get('event_id'), $this->get('type')))
		{
			
		}
	}	

	public function sponsor()
	{
	    if (Phpfox::getService('event.process')->sponsor($this->get('event_id'), $this->get('type')))
	    {
		if ($this->get('type') == '1')
		{
		    Phpfox::getService('ad.process')->addSponsor(array('module' => 'event', 'item_id' => $this->get('event_id')));
		    $this->call('$("#js_event_unsponsor_'.$this->get('event_id').'").show();');
		    $this->call('$("#js_event_sponsor_'.$this->get('event_id').'").hide();');
		    $this->addClass('#js_event_item_holder_'.$this->get('event_id'), 'row_sponsored');
			$this->show('#js_sponsor_phrase_' . $this->get('event_id'));
		    $this->alert(Phpfox::getPhrase('event.event_successfully_sponsored'));
		}
		else
		{
		    Phpfox::getService('ad.process')->deleteAdminSponsor('event', $this->get('event_id'));
		    $this->call('$("#js_event_unsponsor_'.$this->get('event_id').'").hide();');
		    $this->call('$("#js_event_sponsor_'.$this->get('event_id').'").show();');
		    $this->removeClass('#js_event_item_holder_'.$this->get('event_id'), 'row_sponsored');
			$this->hide('#js_sponsor_phrase_' . $this->get('event_id'));
		    $this->alert(Phpfox::getPhrase('event.event_successfully_un_sponsored'));
		}
	    }
	}
	
	public function approve()
	{
		if (Phpfox::getService('event.process')->approve($this->get('event_id')))
		{
			$this->alert(Phpfox::getPhrase('event.event_has_been_approved'), Phpfox::getPhrase('event.event_approved'), 300, 100, true);
			$this->hide('#js_item_bar_approve_image');
			$this->hide('.js_moderation_off'); 
			$this->show('.js_moderation_on');				
		}
	}
	
	public function moderation()
	{
		Phpfox::isUser(true);	
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('event.can_approve_events', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('event.process')->approve($iId);
					$this->remove('#js_event_item_holder_' . $iId);					
				}				
				$this->updateCount();
				$sMessage = Phpfox::getPhrase('event.event_s_successfully_approved');
				break;			
			case 'delete':
				Phpfox::getUserParam('event.can_delete_other_event', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('event.process')->delete($iId);
					$this->slideUp('#js_event_item_holder_' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('event.event_s_successfully_deleted');
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}	

	public function massEmail()
	{
		$iPage = $this->get('page', 1);
		$sSubject = $this->get('subject');
		$sText = $this->get('text');
		
		if ($iPage == 1 && !Phpfox::getService('event')->canSendEmails($this->get('id')))
		{
			$this->hide('#js_event_mass_mail_li');
			$this->alert(Phpfox::getPhrase('event.you_are_unable_to_send_out_any_mass_emails_at_the_moment'));
			
			return;
		}
		
		if (empty($sSubject) || empty($sText))
		{
			$this->hide('#js_event_mass_mail_li');
			$this->alert(Phpfox::getPhrase('event.fill_in_both_a_subject_and_text_for_your_mass_email'));
			
			return;
		}
		
		$iCnt = Phpfox::getService('event.process')->massEmail($this->get('id'), $iPage, $this->get('subject'), $this->get('text'));
		
		if ($iCnt === false)
		{
			$this->hide('#js_event_mass_mail_li');
			$this->alert(Phpfox::getPhrase('event.you_are_unable_to_send_a_mass_email_for_this_event'));
			
			return;
		}		
	
		Phpfox::getLib('pager')->set(array('ajax' => 'event.massEmail', 'page' => $iPage, 'size' => 20, 'count' => $iCnt));		
		
		if ($iPage < Phpfox::getLib('pager')->getLastPage())
		{
			$this->call('$.ajaxCall(\'event.massEmail\', \'id=' . $this->get('id') . '&page=' . ($iPage + 1) . '&subject=' . $this->get('subject') . '&text=' . $this->get('text') . '\');');
			
			$this->html('#js_event_mass_mail_send', Phpfox::getPhrase('event.email_progress_page_total', array('page' => $iPage, 'total' => Phpfox::getLib('pager')->getLastPage())));
		}
		else 
		{
			if (!Phpfox::getService('event')->canSendEmails($this->get('id'), true))
			{
				$this->hide('#js_send_email')
					->show('#js_send_email_fail')
					->html('#js_time_left', Phpfox::getTime(Phpfox::getParam('mail.mail_time_stamp'), Phpfox::getService('event')->getTimeLeft($this->get('id'))));
			}
			
			$this->hide('#js_event_mass_mail_li');
			$this->alert(Phpfox::getPhrase('event.done'));
		}
	}	
	
	public function removeInvite()
	{
		Phpfox::getService('event.process')->removeInvite($this->get('id'));
	}
	
	public function addFeedComment()
	{
		Phpfox::isUser(true);
		
		$aVals = (array) $this->get('val');	
		
		if (Phpfox::getLib('parse.format')->isEmpty($aVals['user_status']))
		{
			$this->alert(Phpfox::getPhrase('user.add_some_text_to_share'));
			$this->call('$Core.activityFeedProcess(false);');
			return;			
		}		
		
		$aEvent = Phpfox::getService('event')->getForEdit($aVals['callback_item_id'], true);
		
		if (!isset($aEvent['event_id']))
		{
			$this->alert(Phpfox::getPhrase('event.unable_to_find_the_event_you_are_trying_to_comment_on'));
			$this->call('$Core.activityFeedProcess(false);');
			return;
		}
		
		$sLink = Phpfox::permalink('event', $aEvent['event_id'], $aEvent['title']);
		$aCallback = array(
			'module' => 'event',
			'table_prefix' => 'event_',
			'link' => $sLink,
			'email_user_id' => $aEvent['user_id'],
			'subject' => Phpfox::getPhrase('event.full_name_wrote_a_comment_on_your_event_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aEvent['title'])),
			'message' => Phpfox::getPhrase('event.full_name_wrote_a_comment_on_your_event_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aEvent['title'])),
			'notification' => 'event_comment',
			'feed_id' => 'event_comment',
			'item_id' => $aEvent['event_id']
		);
		
		$aVals['parent_user_id'] = $aVals['callback_item_id'];
		
		if (isset($aVals['user_status']) && ($iId = Phpfox::getService('feed.process')->callback($aCallback)->addComment($aVals)))
		{
			Phpfox::getLib('database')->updateCounter('event', 'total_comment', 'event_id', $aEvent['event_id']);		
			
			Phpfox::getService('feed')->callback($aCallback)->processAjax($iId);
		}
		else 
		{
			$this->call('$Core.activityFeedProcess(false);');
		}		
	}	
}

?>