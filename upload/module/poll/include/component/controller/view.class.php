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
 * @version 		$Id: view.class.php 3587 2011-11-28 07:14:49Z Raymond_Benc $
 */
class Poll_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('poll.can_access_polls', true);	
	
		(($sPlugin = Phpfox_Plugin::get('poll.component_controller_view_process_start')) ? eval($sPlugin) : false);

		// there are times when this controller is actually called
		// in the Poll_Component_Controller_Profile like when the poll
		// is in the profile
		$sSuffix = '_' . Phpfox::getParam('poll.poll_max_image_pic_size');

		$iPage = $this->request()->getInt('page', 0);
		$iPageSize = 10;

		// we need to make sure we're getting the
		if (!($iPoll = $this->request()->getInt('req2')))
		{
			$this->url()->send('poll');
		}
		
		if (Phpfox::isModule('notification') && Phpfox::isUser())
		{
			Phpfox::getService('notification.process')->delete('comment_poll', $this->request()->getInt('req2'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('poll_like', $this->request()->getInt('req2'), Phpfox::getUserId());
		}				

		// we need to load one poll
		$aPoll = Phpfox::getService('poll')->getPollByUrl($iPoll, $iPage, $iPageSize, true);
		
		Phpfox::getLib('pager')->set(array('ajax'=> 'poll.pageVotes', 'page' => 0, 'size' => Phpfox::getParam('poll.show_x_users_who_took_poll'), 'count' => $aPoll['total_votes']));
		
		if ($aPoll === false)
		{			
			return Phpfox_Error::display('Not a valid poll.');
		}
		
		if (Phpfox::getUserId() == $aPoll['user_id'] && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('poll_approved', $this->request()->getInt('req2'), Phpfox::getUserId());
		}		
		
		if (!isset($aPoll['is_friend']))
		{
			$aPoll['is_friend'] = 0;
		}
		
		Phpfox::getService('core.redirect')->check($aPoll['question']);
		if (Phpfox::isModule('privacy'))
		{
			Phpfox::getService('privacy')->check('poll', $aPoll['poll_id'], $aPoll['user_id'], $aPoll['privacy'], $aPoll['is_friend']);		
		}
		
		// set if we can show the poll results
		// is guest the owner of the poll
		$bIsOwner = $aPoll['user_id'] == Phpfox::getUserId();
		$bShowResults = false;
		if ($bIsOwner && Phpfox::getUserParam('poll.can_view_user_poll_results_own_poll') ||
			(!$bIsOwner && Phpfox::getUserParam('poll.can_view_user_poll_results_other_poll'))
		)
		{
			$bShowResults = true;
		}
		$this->template()->assign(array('bShowResults' => $bShowResults));

		if ($aPoll['view_id'] == 1)
		{
			if ((!Phpfox::getUserParam('poll.poll_can_moderate_polls') && $aPoll['user_id'] != Phpfox::getUserId()))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('poll.unable_to_view_this_poll'));
			}

			if ($sModerate = $this->request()->get('moderate'))
			{
				Phpfox::getUserParam('poll.poll_can_moderate_polls', true);
				switch ($sModerate)
				{
					case 'approve':
						if (Phpfox::getService('poll.process')->moderatePoll($aPoll['poll_id'], 0))
						{
							$this->url()->send($aUser['user_name'], array('poll', $aPoll['question_url']), Phpfox::getPhrase('poll.poll_successfully_approved'));
						}
						break;
					default:
						break;
				}
			}
		}

		// Track users
		if (Phpfox::isModule('track') && Phpfox::isUser() && (Phpfox::getUserId() != $aPoll['user_id']) && !$aPoll['poll_is_viewed'] && !Phpfox::getUserBy('is_invisible'))
		{
			Phpfox::getService('track.process')->add('poll', $aPoll['poll_id']);
			Phpfox::getService('poll.process')->updateView($aPoll['poll_id']);
		}
	
		if (Phpfox::isUser() && Phpfox::isModule('track') && Phpfox::getUserId() != $aPoll['user_id'] && $aPoll['poll_is_viewed'] && !Phpfox::getUserBy('is_invisible'))
		{
			Phpfox::getService('track.process')->update('poll_track', $aPoll['poll_id']);	
		}	
		
		// check editing permissions		
		$aPoll['bCanEdit'] = Phpfox::getService('poll')->bCanEdit($aPoll['user_id']);
		
		// Define params for "review views" block tracker
		$this->setParam(array(
				'sTrackType' => 'poll',
				'iTrackId' => $aPoll['poll_id'],
				'iTrackUserId' => $aPoll['user_id'],
				'aPoll' => $aPoll
			)
		);		
		
		$this->setParam('aFeed', array(				
				'comment_type_id' => 'poll',
				'privacy' => $aPoll['privacy'],
				'comment_privacy' => $aPoll['privacy_comment'],
				'like_type_id' => 'poll',
				'feed_is_liked' => $aPoll['is_liked'],
				'feed_is_friend' => $aPoll['is_friend'],
				'item_id' => $aPoll['poll_id'],
				'user_id' => $aPoll['user_id'],
				'total_comment' => $aPoll['total_comment'],
				'total_like' => $aPoll['total_like'],
				'feed_link' => $this->url()->permalink('poll', $aPoll['poll_id'], $aPoll['question']),
				'feed_title' => $aPoll['question'],
				'feed_display' => 'view',
				'feed_total_like' => $aPoll['total_like'],
				'report_module' => 'poll',
				'report_phrase' => Phpfox::getPhrase('poll.report_this_poll_lowercase')				
			)
		);				
		
		$this->template()->setTitle($aPoll['question'])			
			->setBreadcrumb(Phpfox::getPhrase('poll.polls'), $this->url()->makeUrl('poll'))
			->setBreadcrumb($aPoll['question'], $this->url()->permalink('poll', $aPoll['poll_id'], $aPoll['question']), true)
			->setMeta('keywords', $this->template()->getKeywords($aPoll['question']))
			->setMeta('description',  Phpfox::getPhrase('poll.full_name_s_poll_from_time_stamp_question', array(
						'full_name' => $aPoll['full_name'],
						'time_stamp' => Phpfox::getTime(Phpfox::getParam('core.description_time_stamp'), $aPoll['time_stamp']),
						'question' => $aPoll['question']
					)
				)
			)
			->setMeta('description', Phpfox::getParam('poll.poll_meta_description'))
			->setMeta('keywords', Phpfox::getParam('poll.poll_meta_keywords'))		
			->setHeader('cache', array(
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'quick_edit.js' => 'static_script',
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
					'poll.css' => 'module_poll',
					'feed.js' => 'module_feed'
					
			)
		)->setEditor(array(
				'load' => 'simple'
			)
		)->assign(array(
					'bIsViewingPoll' => true,
					'aPoll' => $aPoll,
					'sSuffix' => $sSuffix
			)
		);
		
		if (isset($aPoll['answer']) && is_array($aPoll['answer']))
		{
			foreach ($aPoll['answer'] as $aAnswer)
			{
				$this->template()->setMeta('keywords', $this->template()->getKeywords($aAnswer['answer']));
			}
		}

		(($sPlugin = Phpfox_Plugin::get('poll.component_controller_view_process_end')) ? eval($sPlugin) : false);
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>