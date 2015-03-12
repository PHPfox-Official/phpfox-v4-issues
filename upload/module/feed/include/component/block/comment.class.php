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
 * @package  		Module_Feed
 * @version 		$Id: comment.class.php 6714 2013-10-03 08:28:06Z Miguel_Espinoza $
 */
class Feed_Component_Block_Comment extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aFeed = $this->getParam('aFeed');
		$aFeed['feed_id'] = $aFeed['item_id'];
		$aFeed['is_view_item'] = true;
		$sFeedType = (isset($aFeed['feed_display']) ? $aFeed['feed_display'] : null);

		$bForceLoad = false;
		if (PHPFOX_IS_AJAX && Phpfox::getLib('module')->getFullControllerName() == 'photo.view')
		{
			// $bForceLoad = true;
		}

		if ((!PHPFOX_IS_AJAX || $bForceLoad) && $sFeedType == 'view' && Phpfox::isModule('comment') && Phpfox::getParam('comment.load_delayed_comments_items'))
		{
			// Prepare the param
			$sDelayedParam = urlencode(
				json_encode(
					array(
						'item_id' => $aFeed['item_id'],
						'total_like' => $aFeed['total_like'],
						'like_type_id' => $aFeed['like_type_id'],
						'total_comment' => $aFeed['total_comment'],
						'comment_type_id' => $aFeed['comment_type_id'],
						'privacy' => $aFeed['privacy'],
						'feed_link' => $aFeed['feed_link'],
						'feed_title' => $aFeed['feed_title'],
						'feed_display' => $aFeed['feed_display'],
					)
				)
			);
			$this->template()->assign(array(
				'sDelayedParam' => $sDelayedParam, 
				'sDelayedParamId' => rand(100,999)
			));
			
			return 'block';
		}
		else if (defined('PHPFOX_IS_AJAX') && PHPFOX_IS_AJAX && Phpfox::getLib('ajax')->get('delayedParam') != null)
		{
			$aFeed = json_decode(urldecode(Phpfox::getLib('ajax')->get('delayedParam')));
		}
		
		if (Phpfox::isModule('comment') && Phpfox::getUserParam('comment.can_delete_comment_on_own_item') && ($iOwnerDeleteCmt = $this->request()->getInt('ownerdeletecmt')) && isset($aFeed['user_id']) && $aFeed['user_id'] == Phpfox::getUserId())
		{
			if (Phpfox::getService('comment.process')->deleteInline($iOwnerDeleteCmt, $aFeed['comment_type_id'], true))
			{
				$this->url()->forward($aFeed['feed_link'], Phpfox::getPhrase('comment.comment_successfully_deleted'));
			}
		}

		$bCanPostComment = true;
		if (isset($aFeed['comment_privacy']) && $aFeed['user_id'] != Phpfox::getUserId() && (Phpfox::isModule('privacy') && !Phpfox::getUserParam('privacy.can_comment_on_all_items')))
		{
			switch ($aFeed['comment_privacy'])
			{
				case 1:					
					if ((int) $aFeed['feed_is_friend'] <= 0)
					{
						$bCanPostComment = false;						
					}
					break;
				case 2:
					if ((int) $aFeed['feed_is_friend'] > 0)
					{
						$bCanPostComment = true;
					}
					else 
					{
						if (!Phpfox::getService('friend')->isFriendOfFriend($aFeed['user_id']))
						{
							$bCanPostComment = false;	
						}
					}
					break;
				case 3:
					$bCanPostComment = false;
					break;
			}
		}
		$aFeed['can_post_comment'] = $bCanPostComment;
		
		if ( (int) $aFeed['total_like'] > 0 && Phpfox::isModule('like'))
		{
			$aFeed['likes'] = Phpfox::getService('like')->getLikesForFeed($aFeed['like_type_id'], $aFeed['item_id'], ((int) $aFeed['feed_is_liked'] > 0 ? true : false), Phpfox::getParam('feed.total_likes_to_display'));
		}
		
		$bHasBeenMarked = (Phpfox::isModule('like') ? Phpfox::getService('like')->hasBeenMarked(2, isset($aFeed['type_id']) ? $aFeed['type_id'] : $aFeed['like_type_id'], $aFeed['item_id']) : false);
		
		/* Quick check without the actions*/
		$aFeed['bShowEnterCommentBlock'] = false;
		
		if (Phpfox::isModule('like') && ((isset($aFeed['total_like']) && $aFeed['total_like'] > 0 && Phpfox::getParam('like.show_user_photos') == false) ||
				(isset($aFeed['total_comment']) && $aFeed['total_comment'] > 0) || 
				(Phpfox::getParam('like.allow_dislike') && Phpfox::isModule('like') && $bHasBeenMarked)
			))
		{
			$aFeed['bShowEnterCommentBlock'] = true;
		}
				
		$iPageLimit = 2;
		$mPager = null;
		$iCommentId = null;
		$bIsViewingComments = false;
		if (Phpfox::isModule('comment') && $sFeedType != 'mini')
		{	
			if ((int) $aFeed['total_comment'] > 0)
			{	
				if ($sFeedType == 'view')
				{
					$iPageLimit = Phpfox::getParam('comment.comment_page_limit');
					$mPager = $aFeed['total_comment'];
				}
				
				if ($this->request()->getInt('comment'))
				{
					$iCommentId = $this->request()->getInt('comment');
					$bIsViewingComments = true;
				}
							
				$aFeed['comments'] = Phpfox::getService('comment')->getCommentsForFeed($aFeed['comment_type_id'], $aFeed['item_id'], $iPageLimit, $mPager, $iCommentId);
			}
		}
		
		if ($sFeedType == 'view')
		{
			Phpfox::getLib('pager')->set(array(
					'ajax' => 'comment.viewMoreFeed', 
					'page' => Phpfox::getLib('request')->getInt('page'), 
					'size' => $iPageLimit, 
					'count' => $mPager,
					'phrase' => Phpfox::isModule('comment') ? Phpfox::getPhrase('comment.view_previous_comments') : '',
					'icon' => 'misc/comment.png',
					'aParams' => array(
						'comment_type_id' => $aFeed['comment_type_id'],
						'item_id' => $aFeed['item_id'],
						'append' => true,
						'pagelimit' => $iPageLimit,
						'total' => $mPager
					)
				)
			);
		}

		$aFeed['type_id'] = (!empty($aFeed['type_id']) ? $aFeed['type_id'] : (isset($aFeed['report_module']) ? $aFeed['report_module'] : ''));
		
		if ($aFeed['type_id'] == 'forum_reply') $aFeed['type_id'] = 'forum_post';
		
		if (!isset($aFeed['feed_like_phrase']) && Phpfox::isModule('like'))
		{
			Phpfox::getService('feed')->getPhraseForLikes($aFeed);
		}
		$this->template()->assign(array(
				'aFeed' => $aFeed,
				'sFeedType' => $sFeedType,
				'bIsViewingComments' => $bIsViewingComments
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_block_comment_clean')) ? eval($sPlugin) : false);
	}	
}

?>
