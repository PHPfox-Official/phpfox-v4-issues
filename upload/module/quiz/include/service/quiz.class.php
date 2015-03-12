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
 * @version 		$Id: quiz.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Quiz_Service_Quiz extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('quiz');
	}

	/**
	 * This function checks the structure of the array that will be passed to either the
	 * update function or the add function. Promotes standarization of the inner handling
	 * of objects and checks for default answers
	 * @param array $aQuestions
	 * @return mixed String on invalid | true on valid
	 */
	public function checkStructure($aQuestions)
	{
		$iMinQuestions = Phpfox::getUserParam('quiz.min_questions');
		$iMaxQuestions = Phpfox::getUserParam('quiz.max_questions');
		$bEmptyQuestion = false;
		$aWrong = array();
		$iValidAnswers = 0; // this has to match or pass the iMinAnswers
		$iCorrectAnswersSet = 0; // this has to match or pass the count for questions
		$aError = array();
		$iQuestionCount = 0;
		foreach($aQuestions as &$aQuestion)
		{
			$iQuestionCount++;
			$aQuestion['iQuestionIndex'] = $iQuestionCount;
			// check that the answers are valid
			foreach ($aQuestion['answers'] as &$aAnswer)
			{				
				$aAnswer['answer'] = trim($aAnswer['answer']);				
				if (($aAnswer['answer'] == ''))
				{
					$aError[0] = Phpfox::getPhrase('quiz.we_do_not_allow_empty_answers');
				}
				$sAnswer = strtolower($aAnswer['answer']);
				$sAnswer = str_replace(Phpfox::getPhrase('quiz.answer') . ' ', '', $sAnswer);
				$sAnswer = str_replace('...','',$sAnswer);
				if (is_numeric($sAnswer) && !is_numeric($aAnswer['answer']) && (strpos($aAnswer['answer'], '...') !== false))
				{
					$aError[1] = Phpfox::getPhrase('quiz.we_do_not_allow_default_answers_answer', array('answer' => $aAnswer['answer']));
				}
				else
				{
					$iValidAnswers++;
				}
				
				// check for valid answer
				if (isset($aAnswer['is_correct']) && $aAnswer['is_correct'] == 1)
				{
					$iCorrectAnswersSet++;
				}
			} // checking answers
			
			// check that the title is not empty
			if (empty($aQuestion['question']))
			{
				$aError[2] = Phpfox::getPhrase('quiz.the_question_field_cannot_be_empty');
			}
		} // validate questions

		if( ($iCorrectAnswersSet < 1) || ($iCorrectAnswersSet < count($aQuestions)))
		{
			$aError[3] = Phpfox::getPhrase('quiz.you_need_to_set_at_least_one_correct_answer_per_question');
		}
		if ( (count($aQuestions) < $iMinQuestions) || (count($aQuestions) > $iMaxQuestions))
		{
			$aError[4] = Phpfox::getPhrase('quiz.you_need_to_add_a_minimum_of_min_and_a_maximum_of_max_questions_per_quiz_you_submitted_total', array(
					'min' => $iMinQuestions,
					'max' => $iMaxQuestions,
					'total' => (count($aQuestions))
				)
			);
		}
		if ($iValidAnswers < 2)
		{
			$aError[5] = Phpfox::getPhrase('quiz.you_need_to_add_a_minimum_of_2_answers_in_each_question');
		}
		
		if (!empty($aError))
		return array($aError, $aQuestions);

		return array(true, true);
	}
	
	/**
	 * This function gets quizzes for both the public area, and the profile section
	 * It needs to return a count of all the quizzes available
	 */
	public function get($aCond, $iPage = 1, $iPageSize = 10)
	{
		$iCnt =  0;
		$aRows = array();
		
		(($sPlugin = Phpfox_Plugin::get('quiz.service_quiz_get_start')) ? eval($sPlugin) : false);
		if (defined('PHPFOX_IS_USER_PROFILE') && Phpfox::getUserId())
		{
			if (Phpfox::isModule('privacy'))
			{
				$this->database()->select('p.item_id AS privacy_pass, ')
				->leftJoin(Phpfox::getT('privacy'), 'p', "p.item_id = q.quiz_id AND p.category_id = 'quiz' AND p.user_id = " . Phpfox::getUserId());
			}
			if (Phpfox::isModule('friend'))
			{
				$this->database()->select('f.friend_id AS is_friend, ')
				->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = q.user_id AND f.friend_user_id = " . Phpfox::getUserId());
			}
		}
		else
		{
			$aCond[] = 'AND (q.privacy = 1 OR (q.privacy != 1 && q.user_id = '.Phpfox::getUserId().'))';
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'q')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = q.user_id')
			->where($aCond)
			->group('q.quiz_id')
			->execute('getSlaveField');		

		$aRows = $this->database()->select("q.*, " .Phpfox::getUserField())
			->from($this->_sTable, 'q')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = q.user_id')
			->where($aCond)
			->order('q.time_stamp DESC')
			->group('q.quiz_id')
			->limit($iPage, $iPageSize, $iCnt)
			->execute('getSlaveRows');
		
		return array($iCnt, $aRows);
	}

	public function getQuizById($iId)
	{
		$aQuiz = $this->database()->select('*')->from(Phpfox::getT('quiz'))->where('quiz_id=' . (int)$iId)->execute('getSlaveRow');
		return $aQuiz;
	}
	/**
	 * Checks if a user has taken a quiz
	 * @param integer $iUser User identifier
	 * @param integer $sQuiz Quiz identifier
	 * @return boolean
	 */
	public function hasTakenQuiz($iUser, $sQuiz)
	{
		$iTaken = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('quiz_result'), 'qr')
			->join($this->_sTable, 'q', 'q.quiz_id = qr.quiz_id')
			->where('q.quiz_id = ' . (int) $sQuiz . ' AND qr.user_id = ' . (int)$iUser)
			->execute('getSlaveField');

		return ($iTaken > 0);

	}

	/**
	 * This function returns a single Quiz, to be viewed in a profile.quiz.quiz_url
	 * as long as someone has taken the quiz this function returns the score that user got
	 * as well as the user_name and user_id of the last one to take the quiz
	 * @param string $sUrl
	 * @param mixed $iUser int/false
	 * @param boolean $bIsTakingQuiz true => load the info needed to submit a form
	 */
	public function getQuizByUrl($sUrl, $iUser = false, $bIsTakingQuiz = false)
	{
		(($sPlugin = Phpfox_Plugin::get('quiz.service_quiz_getquizbyurl_start')) ? eval($sPlugin) : false);
		// check if this user can approve quizzes, in which case even if its a "to be moderated" it will show up
		if (Phpfox::isModule('track'))
		{
			$this->database()->select("quiz_track.item_id AS is_viewed, ")
			->leftJoin(Phpfox::getT('quiz_track'), 'quiz_track', 'quiz_track.item_id = q.quiz_id AND quiz_track.user_id = ' . Phpfox::getUserBy('user_id'));
		}
		
		if (Phpfox::isModule('friend'))
		{
			$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = q.user_id AND f.friend_user_id = " . Phpfox::getUserId());					
		}			
		else
		{
			$this->database()->select('0 as is_friend, ');
		}

		$bCanApprove = Phpfox::getUserParam('quiz.can_approve_quizzes') ? 1 : 0;		
		
		if(Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'quiz\' AND l.item_id = q.quiz_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aQuiz = $this->database()->select('q.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'q')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = q.user_id')
			->where('q.quiz_id = ' . (int) $sUrl . '')
			->execute('getSlaveRow');			
	
		// safety check
		if (empty($aQuiz))
		{
			return false;
		}
		
		if ($aQuiz['view_id'] == '1' && !$bCanApprove && $aQuiz['user_id'] != Phpfox::getUserId())
		{
			return false;
		}		

		if ($iUser == false && $bIsTakingQuiz == false)
		{
			// get the users who have taken this quiz
			$aAnswers = $this->database()->select('qa.*, qq.*')//, ' . Phpfox::getUserField())
				->from(Phpfox::getT('quiz_answer'), 'qa')
				->join(Phpfox::getT('quiz_question'), 'qq', 'qq.question_id = qa.question_id')
				->where('qq.quiz_id = ' . $aQuiz['quiz_id'])
				->order('qq.question_id ASC, qa.answer_id ASC')
				->execute('getSlaveRows');

			$aTotalAnswers = array();
			foreach ($aAnswers as $aAnswer)
			{
				$aTotalAnswers[$aAnswer['question_id']] = (isset($aTotalAnswers[$aAnswer['answer_id']])) ? $aTotalAnswers[$aAnswer['answer_id']] + 1: 0;
				//$aAnswer['total_answers']
			}
			$iTotalAnswers = count($aTotalAnswers);
			

			// now we get the user's results
			$aResults = $this->database()->select('qr.*, ' . Phpfox::getUserField())
				->from(Phpfox::getT('quiz_result'), 'qr')
				->join(Phpfox::getT('user'), 'u', 'qr.user_id = u.user_id')
				->where('qr.quiz_id = ' . $aQuiz['quiz_id'])
                ->order('time_stamp DESC')
				->execute('getSlaveRows');

			// now we "glue" those together by their answer_id
			/* now group it per user
			 * $aUser[ user_id ] =
			 *		user_info => array ( user_id, server_id, user_name, full_name, gender, user_image ),
			 *		total_correct => fetch this from db
			 *		user_correct => calculate this
			 *		success_percentage => calculate this
			 *		questions => array(
			 *			question => {question}
			 *			answers => array ( {answer_id_he_submitted} => array (
			 *				'text' => {answer},
			 *				'is_correct' => {is_correct})
			 *			)
			 *		)
			 * */
			$aTotalResults = array();
			$aCorrectPerUser = array();
			$aUsersAnswers = array();
			foreach ($aResults as $aResult)
			{
				// add the user info
				$aTotalResults[$aResult['user_id']]['user_info'] = array(
						'user_id' => $aResult['user_id'],
						'server_id' => (isset($aResult['server_id']) && !empty($aResult['server_id']))? $aResult['server_id'] : 0,
						'user_name' => $aResult['user_name'],
						'full_name' => $aResult['full_name'],
						'gender'	=> $aResult['gender'],
						'user_image'=> $aResult['user_image']
				);

				// user's correct answers
				if (!isset($aTotalResults[$aResult['user_id']]['total_correct']))
				{
					$aTotalResults[$aResult['user_id']]['total_correct'] = 0;
				}
				// total questions for the quiz
				//$aUsersAnswers[$aResult['quiz_id']] = $iTotalAnswers;

				// initialize the success percentage
				if (!isset($aTotalResults[$aResult['user_id']]['iSuccessPercentage']))
				{
					$aTotalResults[$aResult['user_id']]['iSuccessPercentage'] = 0;
				}
				// now check if the user answered correctly
				foreach ($aAnswers as $aAnswer)
				{					
					if ($aResult['answer_id'] == $aAnswer['answer_id'] && $aAnswer['is_correct'] == 1)
					{
						$aTotalResults[$aResult['user_id']]['total_correct']++;
					}
					$aTotalResults[$aResult['user_id']]['iTotalCorrectAnswers'] = $iTotalAnswers;
				}
				
				// and get the success percentage so far
				if ($aTotalResults[$aResult['user_id']]['total_correct'] > 0)
				{
					$iPerc = round((($aTotalResults[$aResult['user_id']]['total_correct'] /$aTotalResults[$aResult['user_id']]['iTotalCorrectAnswers']) * 100));
					
					$aTotalResults[$aResult['user_id']]['iSuccessPercentage'] = $iPerc;
				}
			}			
			$aQuiz['aTakenBy'] = $aTotalResults;
		}
		elseif ($bIsTakingQuiz == true)
		{
			// user will take the quiz so just get the questions and their answers
			$aAnswers = $this->database()->select('qq.question_id, qq.question, qa.answer_id, qa.answer')
			->from(Phpfox::getT('quiz_question'), 'qq')
			->join(Phpfox::getT('quiz_answer'), 'qa', 'qa.question_id = qq.question_id')
			->where('qq.quiz_id = ' . $aQuiz['quiz_id'])
			->order('qq.question_id ASC')
			->execute('getSlaveRows');
			// a little order
			$aQuestions = array();
			foreach ($aAnswers as $aAnswer)
			{
				$aQuestions[$aAnswer['question_id']]['question'] = $aAnswer['question'];
				$aQuestions[$aAnswer['question_id']]['answer'][$aAnswer['answer_id']] = $aAnswer['answer'];
			}
			$aQuiz['question'] = $aQuestions;

		}
		// this is if we need to get the general results of all the users who took this quiz
		// this could be an else but its implicit
		else
		{
			// only get the results of one user -> $iUser
			// first get all the answers
			$aAnswers = $this->database()->select('qq.question_id, qa.answer, qq.question, qa.answer_id')
			->from(Phpfox::getT('quiz_question'), 'qq')
			->join(Phpfox::getT('quiz_answer'), 'qa', 'qq.question_id = qa.question_id')
			->where('qa.is_correct = 1 AND qq.quiz_id = ' . $aQuiz['quiz_id'] . ' ')
			->order('qq.question_id ASC')
			->execute('getSlaveRows');

			$aResults = $this->database()->select('*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('quiz_result'), 'qr')
			->join(Phpfox::getT('quiz_answer'), 'qa', 'qa.answer_id = qr.answer_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = qr.user_id')
			->where('qr.user_id = ' . (int)($iUser) . ' AND qr.quiz_id = ' . $aQuiz['quiz_id'])
			->execute('getSlaveRows');

			if (empty($aResults))
			{
			    $sUserName = $this->database()->select('user_name')->from(Phpfox::getT('user'))->where('user_id = ' . (int)$iUser)->execute('getSlaveField');
			}
			$aUsersAnswers = array();
			$iTotalCorrect = 0;
			$iTotalAnswers = count($aAnswers);

			// now we check the user's answers vs the correct answers
			foreach ($aAnswers as $aAnswer)
			{
				// this is to initialize the array so any unanswered question caused by an edit will still show
				$aUsersAnswers[$aAnswer['question_id']]['correctAnswerText'] = $aAnswer['answer'];
				$aUsersAnswers[$aAnswer['question_id']]['userAnswerText'] = Phpfox::getPhrase('quiz.not_answered');
				$aUsersAnswers[$aAnswer['question_id']]['userAnswer'] = '1';
				$aUsersAnswers[$aAnswer['question_id']]['correctAnswer'] = '2';
				$aUsersAnswers[$aAnswer['question_id']]['questionText'] = $aAnswer['question'];
				$aUsersAnswers[$aAnswer['question_id']]['user_name'] = isset($aResults[0]['user_name']) ? $aResults[0]['user_name'] : $sUserName;

				foreach ($aResults as $aResult)
				{
					if ($aResult['question_id'] == $aAnswer['question_id'])
					{ // its the same question
						$aUsersAnswers[$aAnswer['question_id']] = array(
							'questionText' => $aAnswer['question'],
							'userAnswerText' => $aResult['answer'],
							'userAnswer' => $aResult['answer_id'],
							'correctAnswer' => $aAnswer['answer_id'],
							'correctAnswerText' => $aAnswer['answer'],
							'user_name' => $aResult['user_name'],
							'user_id' => $aResult['user_id'],
							'server_id' => $aResult['server_id'],
							'full_name' => $aResult['full_name'],
							'gender' => $aResult['gender'],
							'user_image' => $aResult['user_image'],
							'time_stamp' => $aResult['time_stamp']
						);
						if ($aResult['answer_id'] == $aAnswer['answer_id'])
						{
							$iTotalCorrect++;
						}
					}	
				}	
			}
			
			$aQuiz['results'] = $aUsersAnswers;
			$aQuiz['total_correct'] = $iTotalCorrect;
			$aQuiz['iTotalCorrectAnswers'] = $iTotalAnswers;
			$aQuiz['iSuccessPercentage'] = ($iTotalAnswers > 0) ? round(($iTotalCorrect / $iTotalAnswers) *100) : 0;
		
		}
	
		return $aQuiz;
	}

	/**
	 * Fetches a quiz ready to be edited
	 * @param integer $iQuiz The quiz identifier
	 * @return array
	 */
	public function getQuizToEdit($iQuiz)
	{
		/*
		 * This function returns an array like this:
		 * $array = array(
		 *		'quiz_id'
		 *		'title',
		 *		'user_id',
		 *		'description',
		 *		'quiz_question'
		 *				[] = array(
		 *					'question',
		 *					'answers' => array(id => answer1, answer => answer ), array()
		 * );
		 */
		// check permissions
		$iCurrent = Phpfox::getUserId();
		// check if can edit own items
		$bEditOwn = (Phpfox::getUserParam('quiz.can_edit_own_questions') || Phpfox::getUserParam('quiz.can_edit_own_title'));
		$bEditOthers = (Phpfox::getUserParam('quiz.can_edit_others_questions') || Phpfox::getUserParam('quiz.can_edit_others_title'));
		// check if user can edit anything
		if (!$bEditOthers && !$bEditOwn)
		{
			return false;
		}
		// then they can edit something
		// get the quiz and their questions
		$aQuiz = $this->database()->select('q.*, qq.question_id, qq.question, u.user_name')
			->from($this->_sTable, 'q')
			->join(Phpfox::getT('quiz_question'), 'qq', 'q.quiz_id = qq.quiz_id')
			->join(Phpfox::getT('user'), 'u', 'q.user_id = u.user_id') //useful to forward after the edit
			->order('qq.question_id ASC')
			->where('q.quiz_id = '. (int)$iQuiz)
			->execute('getSlaveRows');
		if (empty($aQuiz)) return array();
		
		// check for more permissions
		if ( ($iCurrent == $aQuiz[0]['user_id'] && (!Phpfox::getUserParam('quiz.can_edit_own_questions'))) &&
			($iCurrent != $aQuiz[0]['user_id'] && (!Phpfox::getUserParam('quiz.can_edit_others_questions'))))
		{
			return $aQuiz;
		}
		// now get the answers
		$sQuestions = '';
		foreach ($aQuiz as $aQuestion)
		{
			$sQuestions .= 'OR qa.question_id = ' . $aQuestion['question_id'] . ' ';
		}
		$sQuestions = substr($sQuestions, 3);
		$aAnswers = $this->database()->select('qa.answer_id, qa.answer, qa.is_correct, qa.question_id')
			->from(Phpfox::getT('quiz_answer'), 'qa')
			->order('qa.answer_id ASC')
			->where($sQuestions)
			->execute('getSlaveRows');

		// glue them
		foreach ($aAnswers as $aAnswer)
		{
			foreach ($aQuiz as $aKey => $aQuestions)
			{
				if ($aQuestions['question_id'] == $aAnswer['question_id'])
				{
					$aQuiz[$aKey]['answers'][] = $aAnswer;
				}
			}
		}
		
		$aFull = array();
		$aFull = $aQuiz[0];
		$aFull['questions'] = $aQuiz;
				
		return $aFull;
	}

	/**
	 * @deprecated To be removed
	 * @param <type> $iQuiz
	 */
	public function getResults($iQuiz)
	{
		// need to get the total count of answers, and the number of correct answers
		// per user
		$aAnswers = $this->database()->select('qr.*')
		->from(Phpfox::getT('quiz_result'), 'qr')
		->where('quiz_id = ' . (int)$iQuiz);
	}

	/**
	 * Gets the recent takers of a quiz
	 * @param string $sQuizUrl
	 * @return array
	 */
	public function getRecentTakers($sQuizUrl)
	{
		// we get only the latest `quiz.takers_to_show`
		$aCount = $this->database()->select('DISTINCT qr.user_id')
			->from(Phpfox::getT('quiz_result'), 'qr')
			->join($this->_sTable, 'q', 'q.quiz_id = ' . (int) $sQuizUrl)
			->order('qr.time_stamp DESC')
			->limit(Phpfox::getParam('quiz.takers_to_show'))
			->execute('getSlaveRows');
		
		// and make it a String so we can use it in the Results query
		$sUsers = '1=1 ';
		foreach ($aCount as $aUser)
		{
			$sUsers .= 'OR qr.user_id = '.$aUser['user_id'].' ';
		}
		//$sUsers = substr($sUsers, 3);
		
		$aResults = $this->database()->select('qr.*, q.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'q')
			->join(Phpfox::getT('quiz_result'), 'qr', 'q.quiz_id = qr.quiz_id')
			->join(Phpfox::getT('user'), 'u', 'qr.user_id = u.user_id')
			->order('qr.time_stamp DESC')
			->where('q.quiz_id = ' . (int) $sQuizUrl . ' AND (' . $sUsers . ')')
			->execute('getSlaveRows');

		if (empty($aResults))
		{
			return false;
		}

		$iQuizId = reset($aResults);
		$iQuizId = $iQuizId['quiz_id'];
		$aQuizzes = array();
		foreach ($aResults as $aUser)
		{
			$aQuizzes[$aUser['user_id']]['user_info'] = $aUser;
		}

		// we now have the user_id as $aQuizzes[quizTakerId], we need the correct answers
		$aAnswers = $this->database()->select('qa.*')
			->from(Phpfox::getT('quiz_answer'), 'qa')
			->join(Phpfox::getT('quiz_question'), 'qq', 'qa.question_id = qq.question_id')
			->where('qq.quiz_id = ' . $iQuizId)
			->execute('getSlaveRows');
		// now match the correct ones
		$iTotalCorrect = 0;
		foreach ($aAnswers as $aAnswer)
		{ // go through the correct answers
			if ($aAnswer['is_correct'] == 1 ) $iTotalCorrect++;
			foreach ($aResults as $aUserInput)
			{
				/*
				 * $aUser = array(
				 *		'total_correct' => Total correct answers in this quiz which is the same as count(questions)
				 *		'iUserCorrectAnswers => how many answers he submitted right. aAnswer[is_correct] == 1 && aAnswer[answer_id] == aUserInput[answer_id]
				 * );
				 */
				// Initialize
				$aQuizzes[$aUserInput['user_id']]['total_correct'] = $iTotalCorrect;
				if (!isset($aQuizzes[$aUserInput['user_id']]['iSuccessPercentage'])) // success percentage for the user
					$aQuizzes[$aUserInput['user_id']]['iSuccessPercentage'] = 0;
				if(!isset($aQuizzes[$aUserInput['user_id']]['iUserCorrectAnswers'])) // correct count for user input
					$aQuizzes[$aUserInput['user_id']]['iUserCorrectAnswers'] = 0;
				if (($aAnswer['answer_id'] == $aUserInput['answer_id']) && $aAnswer['is_correct'] == 1)
				{
					$aQuizzes[$aUserInput['user_id']]['iUserCorrectAnswers']++;
				}
				if ($iTotalCorrect > 0)
				{
					$iPerc = (($aQuizzes[$aUserInput['user_id']]['iUserCorrectAnswers'] / $iTotalCorrect) * 100);
				}
				else
				{
					$iPerc = 0;
				}
				$aQuizzes[$aUserInput['user_id']]['iSuccessPercentage'] = round($iPerc);
			}
		}
		
		return $aQuizzes;
	}

	/**
	 * Gets the recent takers of a quiz
	 * @param string $sQuizUrl
	 * @return array
	 */
	public function getRecentViewers($sQuizUrl)
	{
		$aQuizzes = $this->database()->select('' . Phpfox::getUserField())
		->from(Phpfox::getT('user'), 'u')
		->join(Phpfox::getT('quiz_track'), 'qt', 'qt.user_id = u.user_id')
		->join(Phpfox::getT('quiz'), 'q', 'q.title_url = \'' . $this->database()->escape($sQuizUrl) . '\'')
		->execute('getSlaveRows');

		return $aQuizzes;
	}
	
	public function getPendingTotal()
	{
		return (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('view_id = 1')
			->execute('getSlaveField');
	}		
	
	public function getInfoForAction($aItem)
	{
		if (is_numeric($aItem))
		{
			$aItem = array('item_id' => $aItem);
		}
		$aRow = $this->database()->select('q.quiz_id, q.title, q.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('quiz'), 'q')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = q.user_id')
			->where('q.quiz_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
			
		if (empty($aRow))
		{
			d($aRow);
			d($aItem);
			d(__FILE__ . ':' . __LINE__);
		}
		
		$aRow['link'] = Phpfox::getLib('url')->permalink('quiz', $aRow['quiz_id'], $aRow['title']);
		return $aRow;
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
		if ($sPlugin = Phpfox_Plugin::get('quiz.service_quiz__call'))
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
