<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: view-mobile.class.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
class Feed_Component_Controller_View_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($aVals = $this->request()->getArray('val')))
		{		
			Phpfox::isUser(true);
			Phpfox::getUserParam('comment.can_post_comments', true);	
			
			if (($iFlood = Phpfox::getUserParam('comment.comment_post_flood_control')) !== 0)
			{
				$aFlood = array(
					'action' => 'last_post', // The SPAM action
					'params' => array(
						'field' => 'time_stamp', // The time stamp field
						'table' => Phpfox::getT('comment'), // Database table we plan to check
						'condition' => 'type_id = \'' . Phpfox::getLib('database')->escape($aVals['type']) . '\' AND user_id = ' . Phpfox::getUserId(), // Database WHERE query
						'time_stamp' => $iFlood * 60 // Seconds);	
					)
				);
					 			
				// actually check if flooding
				if (Phpfox::getLib('spam')->check($aFlood))
				{				
					Phpfox_Error::set(Phpfox::getPhrase('comment.posting_a_comment_a_little_too_soon_total_time', array('total_time' => Phpfox::getLib('spam')->getWaitTime())));				 				
				}		
			}					
			
			if (Phpfox::getLib('parse.format')->isEmpty($aVals['text']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('feed.add_some_text_to_your_comment'));
			}		
			
			if (Phpfox_Error::isPassed() && ($iId = Phpfox::getService('comment.process')->add($aVals)))
			{
				$this->url()->send('feed.view', array('id' => $this->request()->getInt('id')), Phpfox::getPhrase('feed.successfully_added_your_comment'));	
			}		
		}
		
		if (($iLikeType = $this->request()->getInt('liketype')))
		{
			if (Phpfox::getService('feed.process')->like($this->request()->getInt('id'), $iLikeType))
			{
				$this->url()->send('feed.view', array('id' => $this->request()->getInt('id')), ($iLikeType == '1' ? Phpfox::getPhrase('feed.successfully_liked_this_feed') : Phpfox::getPhrase('feed.successfully_unliked_this_feed')));
			}
		}
		
		list($iFeedCount, $aFeeds) = Phpfox::getService('feed')->get(null, $this->request()->getInt('id'), 1);
		
		$iCommentCnt = 0;
		$aComments = array();
		if (Phpfox::getParam('feed.allow_comments_on_feeds'))
		{
			list($iCommentCnt, $aComments) = Phpfox::getService('comment')->get('cmt.*', array(
				"AND cmt.type_id = 'feed'",
				'AND cmt.item_id = ' . (int) $aFeeds[0]['feed_id'],
				'AND cmt.view_id = 0'
			), 'cmt.time_stamp ASC');			
		}		
		
		if (!count($aFeeds))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('feed.not_a_valid_feed'));
		}
		
		$this->template()			
			->setMobileHeader(array(
					'feed.css' => 'module_feed'
				)
			)		
			->assign(array(
				'iFeedId' => $aFeeds[0]['feed_id'],
				'aFeeds' => $aFeeds,
				'aComments' => $aComments
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('feed.component_controller_view_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>