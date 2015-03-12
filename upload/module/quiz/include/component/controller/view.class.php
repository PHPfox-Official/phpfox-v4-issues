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
 * @package 		Phpfox_Component
 * @version 		$Id: view.class.php 7230 2014-03-26 21:14:12Z Fern $
 */
class Quiz_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('quiz.can_access_quiz', true);
		
		if (Phpfox::isModule('notification') && Phpfox::isUser())
		{
			Phpfox::getService('notification.process')->delete('comment_quiz', $this->request()->getInt('req2'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('quiz_like', $this->request()->getInt('req2'), Phpfox::getUserId());
		}			

		if ($this->request()->get('req4') && ($this->request()->get('req4') == 'answer'))
		{
			// check that this user has not taken the quiz yet
			$aVals = $this->request()->getArray('val');
			if (Phpfox::getService('quiz')->hasTakenQuiz(Phpfox::getUserId(), $this->request()->get('req2')))
			{
				Phpfox_Error::set(Phpfox::getPhrase('quiz.you_have_already_answered_this_quiz'));
			}
			elseif (!isset($aVals['answer']))// check to see all questions have been answered
			{
				Phpfox_Error::set(Phpfox::getPhrase('quiz.you_have_to_answer_the_questions_if_you_want_to_do_that')); 
			}
			else
			{
				Phpfox::isUser(true);
				// check if user is allowed to answer their own quiz
				$aQuizC = Phpfox::getService('quiz')->getQuizById($this->request()->get('req2'));
				if (!isset($aQuizC['user_id']) || empty($aQuizC['user_id']))
				{
					$this->url()->send('quiz', null, Phpfox::getPhrase('quiz.that_quiz_does_not_exist_or_its_awaiting_moderation'));
				}
				if (!Phpfox::getUserParam('quiz.can_answer_own_quiz') && $aQuizC['user_id'] == Phpfox::getUserId())
				{
					$this->url()->send('quiz', null, Phpfox::getPhrase('quiz.you_are_not_allowed_to_answer_your_own_quiz'));
				}
				$iScore = false;
				$iScore = Phpfox::getService('quiz.process')->answerQuiz($this->request()->get('req2'), $aVals['answer']);
				if ( is_numeric($iScore))
				{ // Answers submitted correctly
					$aUser = $this->getParam('aUser');
					$this->url()->permalink('quiz', $this->request()->get('req2'), $this->request()->get('req3'), true, Phpfox::getPhrase('quiz.your_answers_have_been_submitted_and_your_score_is_score', array('score' => $iScore)), array('results', 'id' => Phpfox::getUserId())); 
				}
				else
				{					
					Phpfox_Error::set($iScore);
				}
			}
		}
		
		$this->setParam('bViewingQuiz', true); 
		$aQuiz = array();
		$bShowResults = false;
		$bShowUsers = false;
		$bCanTakeQuiz = true;
		// $bShowResults == true -> only when viewing results for one user only
		// $bShowUsers == true -> when viewing all results from a quiz
		
		$sQuizUrl = $this->request()->get('req2');
		$sQuizUrl = Phpfox::getLib('parse.input')->clean($sQuizUrl);
		
		if ($this->request()->get('req4') == 'results')
		{
			$bHasTaken = Phpfox::getService('quiz')->hasTakenQuiz(Phpfox::getUserId(), $sQuizUrl);
			if ($bHasTaken)
			{
				$bCanTakeQuiz = false;
			}
			
			if ($iUser = $this->request()->getInt('id'))
			{
				// show the results of just one user				
				$aQuiz = Phpfox::getService('quiz')->getQuizByUrl($sQuizUrl, $iUser);
				$bShowResults = true;				
			}
			else 
			{
				$bShowUsers = true;				
				$aQuiz = Phpfox::getService('quiz')->getQuizByUrl($sQuizUrl, false);
			}
			
			// need it here to have the quiz' info
			if (!Phpfox::getUserParam('quiz.can_view_results_before_answering') && !$bHasTaken && ($aQuiz['user_id'] != Phpfox::getUserId()))
			{
				$this->url()->send($this->request()->get('req1') . '/' . $this->request()->get('req2') . '/' . $sQuizUrl, null, Phpfox::getPhrase('quiz.you_need_to_answer_the_quiz_before_looking_at_the_results'));
			}
			if (Phpfox::getUserParam('quiz.can_post_comment_on_quiz'))
			{
				$this->template()->assign(array('bShowInputComment' => true))
					->setHeader(array(
						'comment.css' => 'style_css',
						'jquery/plugin/jquery.scrollTo.js' => 'static_script',
						'pager.css' => 'style_css'
					)
				);
				if (Phpfox::getUserId())
				{
					$this->template()->setEditor(array(
							'load' => 'simple',
							'wysiwyg' => ((Phpfox::isModule('comment') && Phpfox::getParam('comment.wysiwyg_comments')) && Phpfox::getUserParam('comment.wysiwyg_on_comments'))
						)
					);
				}
			}
		}
		elseif ($this->request()->get('req4') == 'take')
		{
			$bShowResults = false;
			$bShowUsers = false;
			$bCanTakeQuiz = false;
			$aQuiz = Phpfox::getService('quiz')->getQuizByUrl($sQuizUrl, true, true);
		}
		else
		{
			if (Phpfox::getService('quiz')->hasTakenQuiz(Phpfox::getUserId(), $sQuizUrl))
			{
				$bCanTakeQuiz = false;
				$bShowResults = false;
				$bShowUsers = true;
				$aQuiz = Phpfox::getService('quiz')->getQuizByUrl($sQuizUrl, false);				
			}
			else
			{
				$bCanTakeQuiz = true;
				$aQuiz = Phpfox::getService('quiz')->getQuizByUrl($sQuizUrl, false, true);				
			}
			if (Phpfox::getUserParam('quiz.can_post_comment_on_quiz'))
			{
				$this->template()->assign(array('bShowInputComment' => true))
					->setHeader(array(
						'comment.css' => 'style_css',
						'jquery/plugin/jquery.scrollTo.js' => 'static_script',
						'pager.css' => 'style_css'
					)
				);
				if (Phpfox::getUserId())
				{
					$this->template()->setEditor(array(
							'load' => 'simple',
							'wysiwyg' => ((Phpfox::isModule('comment') && Phpfox::getParam('comment.wysiwyg_comments')) && Phpfox::getUserParam('comment.wysiwyg_on_comments'))
						)
					);
				}
			}
		}
		
		// crash control, in a perfect world this shouldnt happen
		if (empty($aQuiz))
		{
			$this->url()->send('quiz', null, Phpfox::getPhrase('quiz.that_quiz_does_not_exist_or_its_awaiting_moderation'));
		}
		
		if (Phpfox::getUserId() == $aQuiz['user_id'] && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('quiz_approved', $this->request()->getInt('req2'), Phpfox::getUserId());
		}			
		
		Phpfox::getService('core.redirect')->check($aQuiz['title']);
		if (Phpfox::isModule('privacy'))
		{
			if (!isset($aQuiz['is_friend']))
			{
				$aQuiz['is_friend'] = 0;
			}
			Phpfox::getService('privacy')->check('quiz', $aQuiz['quiz_id'], $aQuiz['user_id'], $aQuiz['privacy'], $aQuiz['is_friend']);			
		}
		
		// extra info: used for displaying results for one user
		if (isset($aQuiz['results'][0]))
		{
			$aQuiz['takerInfo']['userinfo'] = array(
				'user_name' => $aQuiz['results'][0]['user_name'],
				'user_id' => $aQuiz['results'][0]['user_id'],
				'server_id' => $aQuiz['results'][0]['server_id'],
				'full_name' => $aQuiz['results'][0]['full_name'],
				'gender' => $aQuiz['results'][0]['gender'],
				'user_image' => $aQuiz['results'][0]['user_image']
			);
			$aQuiz['takerInfo']['time_stamp'] = $aQuiz['results'][0]['time_stamp'];
		}
		
		if (!isset($aQuiz['is_viewed']))
		{
			$aQuiz['is_viewed'] = 0;
		}
		
		if (Phpfox::isUser() && (Phpfox::getUserId() != $aQuiz['user_id']) && !$aQuiz['is_viewed'] && !Phpfox::getUserBy('is_invisible'))
		{
			// the updateView should only happen when the user has submitted a
			Phpfox::getService('quiz.process')->updateView($aQuiz, Phpfox::getUserId());			
			if (Phpfox::isModule('track'))
			{
				Phpfox::getService('track.process')->add('quiz', $aQuiz['quiz_id']);
			}
		}
		
		if (Phpfox::isUser() && Phpfox::isModule('track') && Phpfox::getUserId() != $aQuiz['quiz_id'] && $aQuiz['is_viewed'] && !Phpfox::getUserBy('is_invisible'))
		{
			Phpfox::getService('track.process')->update('quiz_track', $aQuiz['quiz_id']);	
		}			
		
		if (isset($aQuiz['aTakenBy']))
		{
			$this->setParam('aTakers', $aQuiz['aTakenBy']);
		}
		
		if (Phpfox::isModule('notification') && $aQuiz['user_id'] == Phpfox::getUserId())
		{
			Phpfox::getService('notification.process')->delete('quiz_notifyLike', $aQuiz['quiz_id'], Phpfox::getUserId());
		}		
		
		/*
		 * the quiz_track table is used to track who has viewed the quiz
		 * the quiz_result to track who has taken the quiz.
		 */
		$this->setParam(array(
				'sTrackType' => 'quiz',
				'iTrackId' => $aQuiz['quiz_id'],
				'iTrackUserId' => $aQuiz['user_id']
			)
		);
		
		$this->setParam('aFeed', array(				
				'comment_type_id' => 'quiz',
				'privacy' => $aQuiz['privacy'],
				'comment_privacy' => $aQuiz['privacy_comment'],
				'like_type_id' => 'quiz',
				'feed_is_liked' => $aQuiz['is_liked'],
				'feed_is_friend' => $aQuiz['is_friend'],
				'item_id' => $aQuiz['quiz_id'],
				'user_id' => $aQuiz['user_id'],
				'total_comment' => $aQuiz['total_comment'],
				'total_like' => $aQuiz['total_like'],
				'feed_link' => $this->url()->permalink('quiz', $aQuiz['quiz_id'], $aQuiz['title']),
				'feed_title' => $aQuiz['title'],
				'feed_display' => 'view',
				'feed_total_like' => $aQuiz['total_like'],
				'report_module' => 'quiz',
				'report_phrase' => Phpfox::getPhrase('quiz.report_this_quiz')
			)
		);			
		
		$this->template()->setTitle($aQuiz['title'])
			->setTitle(Phpfox::getPhrase('quiz.quizzes'))
			->setBreadcrumb(Phpfox::getPhrase('quiz.quizzes'), $this->url()->makeUrl('quiz'))
			->setBreadcrumb($aQuiz['title'], $this->url()->permalink('quiz', $aQuiz['quiz_id'], $aQuiz['title']), true)
			->setMeta('description',  Phpfox::getPhrase('quiz.full_name_s_quiz_from_time_stamp_title', array(
						'full_name' => $aQuiz['full_name'],
						'time_stamp' => Phpfox::getTime(Phpfox::getParam('core.description_time_stamp'), $aQuiz['time_stamp']),
						'title' => $aQuiz['title']
					)
				)
			)
			->setMeta('keywords', $this->template()->getKeywords($aQuiz['title']))
			->setMeta('keywords', Phpfox::getParam('quiz.quiz_meta_keywords'))
			->setMeta('description', Phpfox::getParam('quiz.quiz_meta_description'))
			->assign(array(
				'bIsViewingQuiz' => true,
				'bShowResults' => $bShowResults,
				'bShowUsers' => $bShowUsers,
				'bCanTakeQuiz' => $bCanTakeQuiz,
				'aQuiz' => $aQuiz,
				'sSuffix' =>  '_' . Phpfox::getParam('quiz.quiz_max_image_pic_size')
			)
		)
		->setPhrase(array(
				'quiz.are_you_sure_you_want_to_delete_this_quiz'
			)
		)
		->setHeader('cache', array(
				'quiz.js' => 'module_quiz',
				'quick_edit.js' => 'static_script',
				'jquery/plugin/jquery.highlightFade.js' => 'static_script',
				'jquery/plugin/jquery.scrollTo.js' => 'static_script',
				'feed.js' => 'module_feed'
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('quiz.component_controller_view_process_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('quiz.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>
