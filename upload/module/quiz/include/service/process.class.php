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
 * @version 		$Id: process.class.php 5582 2013-03-28 08:33:43Z Raymond_Benc $
 */
class Quiz_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = PhpFox::getT('quiz');
	}

	/**
	 * submits one user's answers to a quiz
	 * @param integer $iUser
	 * @param array $aAnswers array('questionid' => 'answerid')
	 * @return mixed	int if ok (score), string on error
	 */
	public function answerQuiz($sQuiz, $aAnswers)
	{
		// security checks
		$iUser = Phpfox::getUserId();
		// we need to count how many questions are there for this quiz...

		// get the questions for this quiz
		$aDbQuiz = $this->database()->select('q.*, qq.*')
		->from($this->_sTable, 'q')
		->join(Phpfox::getT('quiz_question'), 'qq', 'qq.quiz_id = q.quiz_id')
		->where('q.quiz_id = ' . (int) $sQuiz)
		->execute('getSlaveRows');

		if ($aDbQuiz[0]['view_id'] == 1)
		{
			return Phpfox::getPhrase('quiz.you_cannot_answer_a_quiz_that_has_not_been_approved');
		}
		if (count($aDbQuiz) != count($aAnswers))
		{
			return Phpfox::getPhrase('quiz.you_need_to_answer_every_question');
		}

		// check if user can answer his own quizzes
		if (!Phpfox::getUserParam('quiz.can_answer_own_quiz'))
		{
			// check if its the same user
			if ($aDbQuiz[0]['user_id'] == $iUser)
			{
				return Phpfox::getPhrase('quiz.you_cannot_answer_your_own_quiz');
			}
		}
		// insert all the answers to the DB and build OR query
		$sQuestionsId = 'is_correct = 1 AND ( 1 = 2';
		foreach($aAnswers as $iQuestion => $iAnswer)
		{

			$this->database()->insert(Phpfox::getT('quiz_result'), array(
					'quiz_id' => $aDbQuiz[0]['quiz_id'],
					'question_id' => $iQuestion,
					'answer_id' => $iAnswer,
					'user_id' => $iUser,
					'time_stamp' => PHPFOX_TIME
				)
			);
			$sQuestionsId .= ' OR question_id = ' . $iQuestion;
		}

		//get the success for this quiz by this user
		$aCorrectAnswers = $this->database()->select('answer_id')
		->from(Phpfox::getT('quiz_answer'))
		->where($sQuestionsId . ')')
		->execute('getSlaveRows');

		$iTotalCorrect = 0;
		foreach($aCorrectAnswers as $iAnswerId)
		{
			$mSearch = array_search($iAnswerId['answer_id'], $aAnswers);

			if ( $mSearch !== false)
			{
				$iTotalCorrect++;
			}
		}
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_process_answerquiz_1')){eval($sPlugin);}
		
		return (int)( ($iTotalCorrect / count($aAnswers) )* 100);
	}

	/**
	 * Approves a quiz -> sets its view_id to 0
	 * @param int $iQuiz
	 * @return boolean true on success
	 */
	public function approveQuiz($iQuiz)
	{
		$aQuiz = $this->database()->select('*')
			->from(Phpfox::getT('quiz'))
			->where('quiz_id = ' . (int) $iQuiz)
			->execute('getSlaveRow');
			
		if (!isset($aQuiz['quiz_id']))
		{
			return false;
		}
		
		if (Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->add('quiz_approved', $aQuiz['quiz_id'], $aQuiz['user_id']);
		}		
		
		$bUpdate = $this->database()->update($this->_sTable, array('view_id' => '0', 'time_stamp' => PHPFOX_TIME), 'quiz_id = ' . (int) $iQuiz) == 1 ? true : false;

		// check if it had been added before
		if (Phpfox::isModule('feed'))
		{
		    (Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('quiz', $aQuiz['quiz_id'], $aQuiz['privacy'], (isset($aQuiz['privacy_comment']) ? (int) $aQuiz['privacy_comment'] : 0), 0, $aQuiz['user_id']) : null);
		}
		
		// Send the user an email
		$sLink = Phpfox::getLib('url')->permalink('quiz', $aQuiz['quiz_id'], $aQuiz['title']);
		Phpfox::getLib('mail')->to($aQuiz['user_id'])
			->subject('Your quiz "' . $aQuiz['title'] . '" has been approved')
			->message("Your quiz \"<a href=\"" . $sLink . "\">" . $aQuiz['title'] . "</a>\" has been approved.\nTo view this quiz follow the link below:\n<a href=\"" . $sLink . "\">" . $sLink . "</a>")				
			->send();		
			
		// Update user activity
		Phpfox::getService('user.activity')->update($aQuiz['user_id'], 'quiz');	
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_process_approvequiz_1')){eval($sPlugin);}
		return $bUpdate;
	}

	/**
	 * It deletes the existing questions and answers (if user has permission to edit that)
	 * and reinserts, it relies on JS to keep the indexes and runs one query to be able to
	 * compare users and set the title right on the "new" quiz.
	 * @param array $aQuiz This array holds all the information that is going to be the final quiz
	 * @return string on error | true on success
	 */
	public function update($aQuiz, $iUser)
	{
		// sanity check
		if (!isset($aQuiz) || empty($aQuiz))
		{
			return 'Corrupted input';
		}
		Phpfox::getService('ban')->checkAutomaticBan($aQuiz['title'] . ' ' . $aQuiz['description']);
		// check permissions
		$iCurrent = Phpfox::getUserId();
		$aOriginalQuiz = $this->database()
			->select('user_id, title, image_path')
			->from($this->_sTable)
			->where('quiz_id = '. (int)$aQuiz['quiz_id'])
			->execute('getSlaveRow');
		$iQuizOwner = $aOriginalQuiz['user_id'];

		// check if can edit own items
		$bGuestIsOwner = $iCurrent == $iQuizOwner;
		$bEditOwn = (Phpfox::getUserParam('quiz.can_edit_own_questions') || Phpfox::getUserParam('quiz.can_edit_own_title'));
		$bEditOthers = (Phpfox::getUserParam('quiz.can_edit_others_questions') || Phpfox::getUserParam('quiz.can_edit_others_title'));
		// check if user can edit anything
		if (!$bEditOthers && !$bEditOwn)
		{
			return Phpfox::getPhrase('quiz.you_do_not_have_the_permission_to_edit_this_quiz');
		}
		
		if (empty($aQuiz['privacy']))
		{
			$aQuiz['privacy'] = 0;
		}
		
		if (empty($aQuiz['privacy_comment']))
		{
			$aQuiz['privacy_comment'] = 0;
		}

		if (Phpfox::getUserParam('quiz.can_edit_others_title') && (!$bGuestIsOwner) ||
			Phpfox::getUserParam('quiz.can_edit_own_title') && ($bGuestIsOwner))
		{
			// update title, description and privacy
			$aUpdate = array(
				'privacy' => (isset($aQuiz['privacy']) ? $aQuiz['privacy'] : '0'),
				'privacy_comment' => (isset($aQuiz['privacy_comment']) ? $aQuiz['privacy_comment'] : '0'),
				'title' => Phpfox::getLib('parse.input')->clean($aQuiz['title']),
				'description' => Phpfox::getLib('parse.input')->clean($aQuiz['description'], 255)
			);
			
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('quiz', $aQuiz['quiz_id'], $aQuiz['privacy'], (isset($aQuiz['privacy_comment']) ? (int) $aQuiz['privacy_comment'] : 0)) : null);

			// Update picture
			if (Phpfox::getUserParam('quiz.can_upload_picture') && isset($_FILES['image']['name']) && ($_FILES['image']['name'] != ''))
			{
				$oFile = Phpfox::getLib('file');
				$oImage = Phpfox::getLib('image');
				$aImage = $oFile->load('image', array(
						'jpg',
						'gif',
						'png'
					)
				);

				if ($aImage !== false)
				{
					$sFileName = $oFile->upload('image', Phpfox::getParam('quiz.dir_image'), (int)$aQuiz['quiz_id']);
					// update the poll
					$aUpdate['image_path'] = $sFileName;
					$aUpdate['server_id'] = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
					// 'quiz_id = ' . (int)$aQuiz['quiz_id']);
					// now the thumbnails
					$iSize = Phpfox::getParam('quiz.quiz_max_image_pic_size');
					$oImage->createThumbnail(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);

					if (file_exists(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '')) && 
						file_exists(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '_' . $iSize)) &&
						isset($aOriginalQuiz['image_path']) && !empty($aOriginalQuiz['image_path']))
					{
						// delete the old picture						
							Phpfox::getLib('file')->unlink(Phpfox::getParam('quiz.dir_image') . sprintf($aOriginalQuiz['image_path'], ''));
							Phpfox::getLib('file')->unlink(Phpfox::getParam('quiz.dir_image') . sprintf($aOriginalQuiz['image_path'], '_' . $iSize));
							// get space used by current picture
							$iOldPictureSpaceUsed = (filesize(Phpfox::getParam('quiz.dir_image') . sprintf($aOriginalQuiz['image_path'], '')) + filesize(Phpfox::getParam('quiz.dir_image') . sprintf($aOriginalQuiz['image_path'], '_' . $iSize)));
							// decrease the count for the old picture
							Phpfox::getService('user.space')->update((int)$iUser, 'quiz', $iOldPictureSpaceUsed, '-');
					}

					// Update user space usage with the new picture
					Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'quiz', (filesize(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '')) + filesize(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '_' . $iSize))));
				}
			}

			$this->database()->update($this->_sTable, $aUpdate, 'quiz_id = ' . (int)$aQuiz['quiz_id']);
		}

		if (isset($aQuiz['q']) && ((Phpfox::getUserParam('quiz.can_edit_others_questions') && !$bGuestIsOwner) ||
				(Phpfox::getUserParam('quiz.can_edit_own_questions') && $bGuestIsOwner)))
		{

			// Step 1 : Delete all the questions from this quiz.
			$aFormerQuestions = $this->database()->select('qq.question_id')
			->from(Phpfox::getT('quiz_question'), 'qq')
			->where('qq.quiz_id = ' . (int)$aQuiz['quiz_id'])
			->execute('getSlaveRows');

			$sQuestionId = '';
			foreach ($aFormerQuestions as $aFormer)
			{
				$sQuestionId .= ' OR question_id = '.$aFormer['question_id'];
			}
			$sQuestionId = substr($sQuestionId, 4);

			// Step 1. Delete all current answers and questions
			$this->database()->delete(Phpfox::getT('quiz_question'), $sQuestionId);
			$this->database()->delete(Phpfox::getT('quiz_answer'), $sQuestionId);
			foreach ($aQuiz['q'] as $aKey => $aQuestion)
			{
				// Step 2. Insert the question
				$aQuestionInsert = array(
						'question' => $aQuestion['question'],
						'quiz_id' => $aQuiz['quiz_id']
				);

				// safer if we get the question_id from the answer
				$aFirstAnswer = reset($aQuestion['answers']);
				$iQuestionId = $aFirstAnswer['question_id'];
				if (isset($aQuestion['question_id']))
				{ // it means we're updating
					$aQuestionInsert['question_id'] = $iQuestionId;
				}
				$iQuestionId = $this->database()->insert(Phpfox::getT('quiz_question'), $aQuestionInsert);

				// Step 3 Insert the answers
				foreach ($aQuestion['answers'] as $aAnswer)
				{
					$aAnswerInsert = array(
						'question_id' => $iQuestionId,
						'answer' => $aAnswer['answer'],
						'is_correct' => $aAnswer['is_correct']
					);
					if (isset($aAnswer['answer_id']) && !empty($aAnswer['answer_id']))
					{
						// An update means Delete + Insert
						$aAnswerInsert['answer_id'] = $aAnswer['answer_id'];
					}
					$this->database()->insert(Phpfox::getT('quiz_answer'), $aAnswerInsert);
				} // end loop answers
			} // end loop questions
		} // end editing questions/answers
		
		if (Phpfox::isModule('privacy'))
		{
			if ($aQuiz['privacy'] == '4')
			{
				Phpfox::getService('privacy.process')->update('quiz', $aQuiz['quiz_id'], (isset($aQuiz['privacy_list']) ? $aQuiz['privacy_list'] : array()));
			}
			else 
			{
				Phpfox::getService('privacy.process')->delete('quiz', $aQuiz['quiz_id']);
			}			
		}
		
		Phpfox::getService('feed.process')->clearCache('quiz', $aQuiz['quiz_id']);
		
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_process_update_1')){eval($sPlugin);}
		
		if (isset($sTitleUrl))
		{
			return array(true, $sTitleUrl);
		}

		return array(true, false);
	}

	/**
	 * Deletes the image in a quiz
	 * @param integer $iQuiz Quiz identifier
	 * @param integer $iUser User identifier
	 * @return boolean
	 */
	public function deleteImage($iQuiz, $iUser)
	{
		$iUser = (int)$iUser;
		$iQuiz = (int)$iQuiz;
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_process_deleteimage_start'))eval($sPlugin);

		// get the name of the image:
		$sFileName = $this->database()->select('image_path')->from(Phpfox::getT('quiz'))->where('quiz_id = ' . $iQuiz)->execute('getSlaveField');

		// calculate space used
		if (!empty($sFileName))
		{
			$iSize = Phpfox::getParam('quiz.quiz_max_image_pic_size');
			// check if the file exists and get its size
			if (file_exists(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '')) && file_exists(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '_' . $iSize)))
			$iOldPictureSpaceUsed = (filesize(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '')) + filesize(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '_' . $iSize)));
			
			// CDN!
			$iServerId = $this->database()->select('server_id')->from(Phpfox::getT('quiz'))->where('quiz_id = ' . $iQuiz)->execute('getSlaveField');
			if (Phpfox::getParam('core.allow_cdn') && $iServerId > 0)
			{
				$iOldPictureSpaceUsed = 0;
				
				$aFilesToDelete = array(
					Phpfox::getParam('quiz.url_image') . sprintf($sFileName, ''),
					Phpfox::getParam('quiz.url_image') . sprintf($sFileName, '_' . $iSize)
				);
				
				foreach($aFilesToDelete as $sFilePath)
				{
					// Get the file size stored when the photo was uploaded
					$sTempUrl = Phpfox::getLib('cdn')->getUrl($sFilePath);
					
					$aHeaders = get_headers($sTempUrl, true);
					if(preg_match('/200 OK/i', $aHeaders[0]))
					{
						$iOldPictureSpaceUsed += (int) $aHeaders["Content-Length"];
					}
				}
			}
			
			// delete the old picture
			if (isset($iOldPictureSpaceUsed) && $iOldPictureSpaceUsed > 0)
			{
				Phpfox::getLib('file')->unlink(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, ''));
				Phpfox::getLib('file')->unlink(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '_' . $iSize));
				// decrease the count for the old picture
				Phpfox::getService('user.space')->update($iUser, 'quiz', $iOldPictureSpaceUsed, '-');
			}
			
			if ($sPlugin = Phpfox_Plugin::get('quiz.service_process_deleteimage_1')){eval($sPlugin);}
			
			if (!isset($bSkipDefaultReturn))
			{
				return $this->database()->update(Phpfox::getT('quiz'), array('image_path' => ''), 'quiz_id = ' . $iQuiz);
			}
		}
		
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_process_deleteimage_end'))eval($sPlugin);
		return true;
		
	}

	/**
	 * Updates the total comment counter
	 * @param integer $iId Quiz Id
	 * @param boolean $bMinus if true it decrements, if false it increses the counter
	 */
	public function updateCounter($iId, $bMinus = false)
	{
		$this->database()->query("
			UPDATE " . $this->_sTable . "
			SET total_comment = total_comment " . ($bMinus ? "-" : "+") . " 1
			WHERE quiz_id = " . (int) $iId . "
		");
	}
	
	/**
	 * Updates the counter of a quiz views (increments) if the current user has
	 * not seen it (avoid false positives)
	 *
	 * @param int $iId quiz_id
	 * @return true
	 */
	public function updateView(&$aQuiz, $iUser)
	{
		$iId = (int)$aQuiz['quiz_id'];
		$iCnt = $this->database()->select('COUNT(*)')
		->from(Phpfox::getT('quiz_track'))
		->where('item_id  = ' . (int)$iId . ' AND user_id = ' . (int)$iUser)
		->execute('getSlaveField');

		if ($iCnt <= 0)
		{
			$this->database()->query("
				UPDATE " . $this->_sTable . "
				SET total_view = total_view + 1
				WHERE quiz_id = " . (int) $iId . "
			");

			$aQuiz['total_view'] = $iCnt++; // purely visual, so the site shows the updated value

		}
		return true;
	}

	/**
	 * Deletes a quiz from the database along with its results, answers and questions
	 * @param int $iQuiz
	 * @param int $iUser User deleting the quiz (can be an admin or the quiz owner)
	 * @return boolean
	 */
	public function deleteQuiz($iQuiz, $iUser)
	{

		// we need to get all the questions by joining to the questions table
		$aAnswers = $this->database()->select('qq.question_id, q.user_id')
		->from(Phpfox::getT('quiz_question'), 'qq')
		->join($this->_sTable, 'q', 'q.quiz_id = ' . (int)$iQuiz)
		->where('qq.quiz_id  = ' . (int)$iQuiz)
		->execute('getSlaveRows');

		$sAnswers = "(1 = 2) ";
		$iUserId = 0;
		foreach($aAnswers as $aAnswer)
		{
			$sAnswers .= ' OR question_id = ' . $aAnswer['question_id'];
			$iUserId = $aAnswer['user_id'];
		}
		$isOwner = ($iUserId == $iUser);
		if (($isOwner && !Phpfox::getUserParam('quiz.can_delete_own_quiz') ||
				(!$isOwner && !Phpfox::getUserParam('quiz.can_delete_others_quizzes'))))
		{
			return false;
		}
		
		$this->deleteImage($iQuiz, $iUser);
		
		$bDel = true;
		$bDel = $bDel && $this->database()->delete($this->_sTable, 'quiz_id = ' . (int)$iQuiz);
		$bDel = $bDel && $this->database()->delete(Phpfox::getT('quiz_track'), 'item_id = ' . (int)$iQuiz);
		$bDel = $bDel && $this->database()->delete(Phpfox::getT('quiz_answer'), $sAnswers);
		$bDel = $bDel && $this->database()->delete(Phpfox::getT('quiz_question'), 'quiz_id = ' . (int)$iQuiz);
		$bDel = $bDel && $this->database()->delete(Phpfox::getT('quiz_result'), 'quiz_id = ' . (int)$iQuiz);

		// Update user activity
		Phpfox::getService('user.activity')->update($iUserId, 'quiz', '-');
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('quiz', $iQuiz) : null);
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('comment_quiz', $iQuiz) : null);
		
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_process_deletequiz_1')){eval($sPlugin);}
		
		return $bDel;
	}

	/**
	 *	Adds a new Quiz
	 * @param array $aVals
	 * @param int $iUser
	 * @return boolean
	 */
	public function add(&$aVals, $iUser)
	{
		// case where user had JS disabled
		if (!isset($aVals['q']))
		{
			return false;
		}
		/* check for banned words */
		foreach ($aVals['q'] as $aQuestions)
		{
			Phpfox::getService('ban')->checkAutomaticBan($aQuestions['question']);
			foreach($aQuestions['answers'] as $aAnswer)
			{
				Phpfox::getService('ban')->checkAutomaticBan($aAnswer['answer']);	
			}
		}
		Phpfox::getService('ban')->checkAutomaticBan($aVals['title'] . ' ' . $aVals['description']);

		if (empty($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		
		if (empty($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}
		
		// insert to the quiz table:
		$iQuizId = $this->database()->insert($this->_sTable, array(
				'view_id' => $aVals['view_id'] = Phpfox::getUserParam('quiz.new_quizzes_need_moderation') ? 1 : 0,
				'privacy' => (isset($aVals['privacy']) ? $aVals['privacy'] : '0'),
				'privacy_comment' => (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0'),
				'user_id' => (int)$iUser,
				'title' => Phpfox::getLib('parse.input')->clean($aVals['title']),
				'description' => Phpfox::getLib('parse.input')->clean($aVals['description'], 255),
				'time_stamp' => PHPFOX_TIME
			)
		);

		// now we insert the questions and the answers
		foreach($aVals['q'] as $aQuestions)
		{
			// first we need to insert the question to get its ID
			$iQuestionId = $this->database()->insert(Phpfox::getT('quiz_question'), array(
					'quiz_id' => $iQuizId,
					'question' => Phpfox::getLib('parse.input')->clean($aQuestions['question'])
				)
			);

			foreach($aQuestions['answers'] as $aAnswer)
			{
				$this->database()->insert(Phpfox::getT('quiz_answer'), array(
						'question_id' => $iQuestionId,
						'answer' => Phpfox::getLib('parse.input')->clean($aAnswer['answer']),
						'is_correct' => (int)$aAnswer['is_correct']
					)
				);
			}
		}

		// Picture upload
		if (Phpfox::getUserParam('quiz.can_upload_picture') && isset($_FILES['image']['name']) && ($_FILES['image']['name'] != ''))
		{
			$oFile = Phpfox::getLib('file');
			$oImage = Phpfox::getLib('image');
			$aImage = $oFile->load('image', array(
					'jpg',
					'gif',
					'png'
				)
			);

			if ($aImage !== false)
			{
				$sFileName = $oFile->upload('image', Phpfox::getParam('quiz.dir_image'), $iQuizId);				
				
				// update the poll
				$this->database()->update($this->_sTable, array('image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'quiz_id = ' . $iQuizId);
				// now the thumbnails
				$iSize = Phpfox::getParam('quiz.quiz_max_image_pic_size');

				$oImage->createThumbnail(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);

				// Update user space usage
				Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'quiz', (filesize(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '')) + filesize(Phpfox::getParam('quiz.dir_image') . sprintf($sFileName, '_' . $iSize))));
			}
		}
		
		if (!Phpfox::getUserParam('quiz.new_quizzes_need_moderation'))
		{
			if (Phpfox::isModule('feed'))
			{
			    (Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('quiz', $iQuizId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0)) : null);
			}
			
			// Update user activity
			Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'quiz');			
		}		

		if ($aVals['privacy'] == '4')
		{
			Phpfox::getService('privacy.process')->add('quiz', $iQuizId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));			
		}		
		
    	// Plugin call
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_process_add__end')){eval($sPlugin);}
		
		return $iQuizId;
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_process__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>
