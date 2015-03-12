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
 * @package  		Module_Poll
 * @version 		$Id: ajax.class.php 6472 2013-08-20 06:11:44Z Raymond_Benc $
 */
class Poll_Component_Ajax_Ajax extends Phpfox_Ajax
{
	/**
	 * Deletes the image in a poll by calling the process service's deleteImage function
	 * @param integer $iPoll Poll identifier
	 */
	public function deleteImage()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_ajax_deleteimage_start')) ? eval($sPlugin) : false);
		$iPoll = (int)$this->get('iPoll');
		if (Phpfox::getService('poll.process')->deleteImage($iPoll, Phpfox::getUserId()))
		{
			$this->call('$("#js_submit_upload_image").show();');
			$this->call('$("#js_event_current_image").remove();');
		}
		else
		{
			$this->call('$("#js_event_current_image").after("' . Phpfox::getPhrase('poll.an_error_occured_and_your_image_could_not_be_deleted_please_try_again') . '");');
		}
		(($sPlugin = Phpfox_Plugin::get('poll.component_ajax_deleteimage_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Adds a vote to a specific poll and sets the message to show according
	 * it also may show the poll result if the userParam is set to show it
	 */
	public function addVote()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_ajax_addvote_start')) ? eval($sPlugin) : false);

		Phpfox::isUser(true);
		
		$aVals = $this->get('val');
		
		// check if the poll is being moderated
		$bModerated = Phpfox::getService('poll')->isModerated((int)$aVals['poll_id']);
		
		if ($bModerated)
		{
			$this->call('$("#poll_holder_' . (int)$aVals['poll_id'] . '").html("' . Phpfox::getPhrase('poll.this_poll_is_being_moderated_and_no_votes_can_be_added_yet') . '");');			
		}
		else
		{			
			if (Phpfox::getService('poll.process')->addVote(Phpfox::getUserId(), (int) $aVals['poll_id'], (int) $aVals['answer']))
			{
				if (Phpfox::getUserParam('poll.view_poll_results_after_vote'))
				{
					Phpfox::getBlock('poll.vote', array('iPoll' => (int) $aVals['poll_id']));

					$this->remove('#vote_list_' . $aVals['poll_id']);
					$this->html('#vote_' . $aVals['poll_id'], $this->getContent(false));
				}
				else 
				{
					$this->alert(Phpfox::getPhrase('poll.your_vote_has_successfully_been_cast'));
				}
			}
			else 
			{
				$this->alert(implode(' ', Phpfox_Error::get()));
			}		
		}
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_ajax_addvote_end')) ? eval($sPlugin) : false);
	}

	/**
	 * Process moderation on a poll
	 */
	public function moderatePoll()
	{
		Phpfox::isUser(true);
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_ajax_moderatepoll_start')) ? eval($sPlugin) : false);
		
		$iPoll = (int) $this->get('iPoll');
		$iResult = (int) $this->get('iResult');		
		
		if ($iResult == 0)
		{
			Phpfox::getUserParam('poll.poll_can_moderate_polls', true);
			
			Phpfox::getService('poll.process')->moderatePoll($iPoll, $iResult);
			
			if ($this->get('inline'))
			{
				$this->alert(Phpfox::getPhrase('poll.poll_has_been_approved'), Phpfox::getPhrase('poll.poll_approved'), 300, 100, true);
				$this->hide('#js_item_bar_approve_image');
				$this->hide('.js_moderation_off'); 
				$this->show('.js_moderation_on');
			}			
			else 
			{
				$sCall = "$('#poll_holder_" . $iPoll . "').removeClass('row_moderate'); $('#poll_holder_" . $iPoll . "').find('.js_poll_approve_link').remove();";
				
				$this->call($sCall)
					->prepend('#poll_holder_' . (int) $iPoll, '<div class="valid_message" style="display:none;">' . Phpfox::getPhrase('poll.poll_successfully_approved') . '</div>')
					->call('$(\'#poll_holder_' . (int) $iPoll . '\').find(\'.valid_message\').slideDown();')
					->call('setTimeout("$(\'#poll_holder_' . (int) $iPoll . '\').find(\'.valid_message\').slideUp();", 2000);');							
			}
		}
		elseif ($iResult == 2)
		{
			if (Phpfox::getService('user.auth')->hasAccess('poll', 'poll_id', $iPoll, 'poll.poll_can_delete_own_polls', 'poll.poll_can_delete_others_polls') && Phpfox::getService('poll.process')->moderatePoll($iPoll, $iResult))
			{
				$this->call("$('.vote_holder_" . $iPoll . "').slideUp();")
					->append('#poll_holder_' . (int) $iPoll, '<div class="valid_message" style="display:none;">' . Phpfox::getPhrase('poll.poll_successfully_deleted') . '</div>')
					->call('$(\'#poll_holder_' . (int) $iPoll . '\').find(\'.valid_message\').show();')
					->call('setTimeout("$(\'#poll_holder_' . (int) $iPoll . '\').find(\'.valid_message\').slideUp();", 2000);');
			}
		}
		else
		{
			$this->call("$('#poll_holder_" . $iPoll . "').html('" . Phpfox::getPhrase('poll.there_was_a_problem_moderating_this_poll', array('phpfox_squote' => true)) . "');");
		}
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_ajax_moderatepoll_end')) ? eval($sPlugin) : false);
	}

	/**
	 * Shows the votes result in a poll
	 */
	public function pageVotes()
	{
		$this->setTitle(Phpfox::getPhrase('poll.poll_results'));
		Phpfox::getBlock('poll.votes');
	}

	/**
	 * Shows the newest polls
	 */
	public function getNew()
	{
		Phpfox::getBlock('poll.new');
		
		$this->html('#' . $this->get('id'), $this->getContent(false));
		$this->call('$(\'#' . $this->get('id') . '\').parents(\'.block:first\').find(\'.bottom li a\').attr(\'href\', \'' . Phpfox::getLib('url')->makeUrl('poll') . '\');');
	}

	public function add()
	{
		echo '<div style="position:relative;">';
		Phpfox::getComponent('poll.add', array(), 'controller');
		echo '</div>';
		echo $this->template()->getHeader();
		echo '<script type="text/javascript">$Core.loadInit();</script>';
	}
	
	public function addCustom()
	{
		$this->errorSet('#js_poll_form_msg');
		
		$aVals = $this->get('val');
		
		$mErrors = Phpfox::getService('poll')->checkStructure($aVals);
		if (is_array($mErrors))
		{
			foreach ($mErrors as $sError)
			{
				Phpfox_Error::set($sError);
			}
		}		
		
		if (Phpfox_Error::isPassed())
		{
			// check if question has a question mark
			if (strpos($aVals['question'], '?') === false)
			{
				$aVals['question'] = $aVals['question'] . '?';
			}
			
			if ((list($iId, $aPoll) = Phpfox::getService('poll.process')->add(Phpfox::getUserId(), $aVals)))
			{
				$this->val('#js_poll_id', $iId);
				$this->call('tb_remove();');	
				$this->html('#js_attach_poll_question', Phpfox::getLib('parse.output')->clean($aPoll['question']) . ' - <a href="#" onclick="$.ajaxCall(\'forum.deletePoll\', \'poll_id=' . $iId . '&amp;thread_id=\' + $(\'#js_poll_id\').val()); return false;" title="' . Phpfox::getPhrase('forum.click_to_delete_this_poll') . '">' . Phpfox::getPhrase('forum.delete') . '</a>');
				$this->hide('#js_attach_poll');
			}
		}
	}
	
	public function moderation()
	{
		Phpfox::isUser(true);	
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('poll.poll_can_moderate_polls', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('poll.process')->moderatePoll($iId, '0');
					$this->remove('#poll_holder_' . $iId);
				}	
				$this->updateCount();			
				$sMessage = Phpfox::getPhrase('poll.poll_s_successfully_approved');
				break;			
			case 'delete':
				Phpfox::getUserParam('poll.poll_can_moderate_polls', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('poll.process')->moderatePoll($iId, 2);
					$this->slideUp('#poll_holder_' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('poll.poll_s_successfully_deleted');
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}

	public function addViaStatusUpdate()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('poll.can_create_poll', true);		
		
		$this->error(false);
		
		$aVals = (array) $this->get('val');	
		
		$aVals['question'] = $aVals['poll_question'];
		
		$iFlood = Phpfox::getUserParam('poll.poll_flood_control');
		if ($iFlood != '0')
		{
			$aFlood = array(
				'action' => 'last_post', // The SPAM action
		 		'params' => array(
		 			'field' => 'time_stamp', // The time stamp field
		 			'table' => Phpfox::getT('poll'), // Database table we plan to check
		 			'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
					'time_stamp' => $iFlood * 60 // Seconds);	
				)
			);
			// actually check if flooding
			if (Phpfox::getLib('spam')->check($aFlood))
			{
				// Set an error
				Phpfox_Error::set(Phpfox::getPhrase('poll.poll_flood_control', array('x' => $iFlood)));
			}
		}		
		
		$mErrors = Phpfox::getService('poll')->checkStructure($aVals);
		if (is_array($mErrors))
		{
			foreach ($mErrors as $sError)
			{
				Phpfox_Error::set($sError);
			}
		}		
		
		$bIsError = false;
		if (Phpfox_Error::isPassed())
		{
			// check if question has a question mark
			if (strpos($aVals['question'], '?') === false)
			{
				$aVals['question'] = $aVals['question'] . '?';
			}			
			
			if (list($iPollId, $aPoll) = Phpfox::getService('poll.process')->add(Phpfox::getUserId(), $aVals))
			{
				$iId = Phpfox::getService('feed.process')->getLastId();
				
				(($sPlugin = Phpfox_Plugin::get('user.component_ajax_addviastatusupdate')) ? eval($sPlugin) : false);
			
				Phpfox::getService('feed')->processAjax($iId);
			}
			else 
			{
				$bIsError = true;
			}
			
		}
		else 
		{
			$bIsError = true;			
		}
		
		if ($bIsError)
		{
			$this->call('$Core.resetActivityFeedError(\'' . implode('<br />', Phpfox_Error::get()) . '\');');
		}
		else
		{
			$this->call('$("#global_attachment_poll input:text").val(" ");');
		}
	}
}

?>