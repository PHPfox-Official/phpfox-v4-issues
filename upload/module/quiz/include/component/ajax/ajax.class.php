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
 * @package  		Module_Quiz
 * @version 		$Id: ajax.class.php 3642 2011-12-02 10:01:15Z Miguel_Espinoza $
 */
class Quiz_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function deleteImage()
	{
		(($sPlugin = Phpfox_Plugin::get('quiz.component_ajax_deleteimage_start')) ? eval($sPlugin) : false);
		$iQuiz = (int)$this->get('iQuiz');
		if (Phpfox::getService('quiz.process')->deleteImage($iQuiz, Phpfox::getUserId()))
		{
			$this->call('$("#js_submit_upload_image").show();');
			$this->call('$("#js_event_current_image").remove();');
		}
		else
		{
			$this->call('$("#js_event_current_image").after("' . Phpfox::getPhrase('quiz.an_error_occured_and_your_image_could_not_be_deleted_please_try_again') . '");');
		}
		(($sPlugin = Phpfox_Plugin::get('quiz.component_ajax_deleteimage_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Validates the approval and calls the processing function
	 */
	public function approve()
	{
		Phpfox::getUserParam('quiz.can_approve_quizzes', true);

		$iQuiz = (int)$this->get('iQuiz');
		$bApproved = Phpfox::getService('quiz.process')->approveQuiz($iQuiz);

		if ($bApproved == true)
		{
			if ($this->get('inline'))
			{
				$this->alert(Phpfox::getPhrase('quiz.quiz_has_been_approved'), Phpfox::getPhrase('quiz.quiz_approved'), 300, 100, true);
				$this->hide('#js_item_bar_approve_image');
				$this->hide('.js_moderation_off'); 
				$this->show('.js_moderation_on');
			}
			else 
			{
				$this->removeClass('#js_quiz_' . $iQuiz, 'row_moderate');
				$this->removeClass('#js_quiz_created_' . $iQuiz, 'row_moderate');
				$this->remove('#js_awaiting_moderation_' . $iQuiz);
				$this->call('$("#js_message_' . $iQuiz . '").message("' . Phpfox::getPhrase('quiz.quiz_approved') . '", "valid").show("slow").fadeOut(5000);');
			}
		}
		else
		{
			$this->alert(Phpfox::getPhrase('quiz.an_error_kept_the_system_from_approving_the_quiz_please_try_again'));
		}
		
		return false;
	}
	
	public function moderation()
	{
		Phpfox::isUser(true);	
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('quiz.can_approve_quizzes', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('quiz.process')->approveQuiz($iId);
					$this->remove('#js_quiz_' . $iId);
				}	
				$this->updateCount();			
				$sMessage = Phpfox::getPhrase('quiz.quiz_zes_successfully_approved');
				break;			
			case 'delete':
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('quiz.process')->deleteQuiz($iId, Phpfox::getUserId());
					$this->slideUp('#js_quiz_' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('quiz.quiz_zes_successfully_deleted');
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}	

	/**
	 * This function deletes a quiz, if quiz.process->deleteQuiz returns true it also visually removes the
	 * quiz entry with a hide and then with a remove
	 * @return false
	 */
	public function delete()
	{
		$iQuiz = (int)$this->get('iQuiz');
		$bDeleted = Phpfox::getService('quiz.process')->deleteQuiz($iQuiz, Phpfox::getUserId());

		if ($bDeleted == true)
		{
			if ($this->get('type') == 'viewing')
			{
				Phpfox::addMessage(Phpfox::getPhrase('quiz.quiz_successfully_deleted'));
				
				$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('quiz') . '\';');
			}
			else 
			{
				$this->call('$("#js_quiz_' . $iQuiz . '").hide("slow", function(){$("#js_quiz_' . $iQuiz . '").remove();});')
					->call('$Core.quiz_moderate.decreaseCounters();');
			}
			
			return true;			
		}
		else
		{
			$this->alert(Phpfox::getPhrase('quiz.your_membership_does_not_allow_you_to_delete_this_quiz'));
		}
		return false;
	}

}

?>