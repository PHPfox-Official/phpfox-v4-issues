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
 * @package  		Module_Forum
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Forum_Component_Controller_Thread extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		define('PHPFOX_PAGER_FORCE_COUNT', true);
		
		Phpfox::getUserParam('forum.can_view_forum', true);		
		
		$iPage = $this->request()->getInt('page');
		$iPageSize = Phpfox::getParam('forum.total_posts_per_thread');			
		$aThreadCondition = array();
		$aCallback = $this->getParam('aCallback', null);
		
		if (($iPostRedirect = $this->request()->getInt('permalink')) && ($sUrl = Phpfox::getService('forum.callback')->getFeedRedirectPost($iPostRedirect)))
		{			
			$this->url()->forward(preg_replace('/\/post_(.*)\//i', '/view_\\1/', $sUrl));			
		}		
		
		if (Phpfox::isUser() && ($iView = $this->request()->getInt('view')) && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('forum_subscribed_post', $iView, Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('forum_post_like', $iView, Phpfox::getUserId());	
		}
		
		if (($iRedirect = $this->request()->getInt('redirect')) && ($aThread = Phpfox::getService('forum.thread')->getForRedirect($iRedirect)))
		{
			if ($aThread['group_id'] > 0)
			{
				$aCallback = Phpfox::callback('group.addForum', $aThread['group_id']);	
				if (isset($aCallback['module']))
				{
					$this->url()->send($aCallback['url_home'], array('forum', $aThread['title_url']));		
				}
			}
			$this->url()->send('forum', array($aThread['forum_url'] . '-' . $aThread['forum_id'], $aThread['title_url']));
		}

		$aThreadCondition[] = 'ft.thread_id = ' . $this->request()->getInt('req3') . '';
		
		$sPermaView = $this->request()->get('view', null);
		if ((int) $sPermaView <= 0)
		{
			$sPermaView = null;
		}
		
		list($iCnt, $aThread) = Phpfox::getService('forum.thread')->getThread($aThreadCondition, array(), 'fp.time_stamp ASC', $iPage, $iPageSize, $sPermaView);
		
		if (!isset($aThread['thread_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_thread'));
		}
		
		if ($aThread['group_id'] > 0)
		{
			$aCallback = Phpfox::callback('pages.addForum', $aThread['group_id']);	
			if (!Phpfox::getService('pages')->hasPerm($aThread['group_id'], 'forum.view_browse_forum'))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_thread'));
			}
		}		
		
		Phpfox::getService('core.redirect')->check($aThread['title'], 'req4');
		
		if ($aThread['view_id'] != '0' && $aThread['user_id'] != Phpfox::getUserId())
		{
			if (!Phpfox::getUserParam('forum.can_approve_forum_thread') && !Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'approve_thread'))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_thread'));
			}
		}
		
		if ($aCallback === null && !Phpfox::getService('forum')->hasAccess($aThread['forum_id'], 'can_view_forum'))
		{
            if (Phpfox::isUser())
            {
                return Phpfox_Error::display(Phpfox::getPhrase('forum.you_do_not_have_the_proper_permission_to_view_this_thread'));
            }
            else
            {
                return Phpfox_Error::display(Phpfox::getPhrase('forum.log_in_to_view_thread'));
            }
			
		}
		
		if ($aCallback === null && !Phpfox::getService('forum')->hasAccess($aThread['forum_id'], 'can_view_thread_content'))
		{
			$this->url()->send('forum', null, Phpfox::getPhrase('forum.you_do_not_have_the_proper_permission_to_view_this_thread'));
		}
	
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));	
			
		$aForum = Phpfox::getService('forum')			
			->id($aThread['forum_id'])
			->getForum();						
		
		if ($this->request()->get('approve') && (Phpfox::getUserParam('forum.can_approve_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'approve_thread')) && $aThread['view_id'])
		{
			$sCurrentUrl = $this->url()->permalink('forum.thread', $aThread['thread_id'], $aThread['title']);
			
			if (Phpfox::getService('forum.thread.process')->approve($aThread['thread_id'], $sCurrentUrl))
			{
				$this->url()->forward($sCurrentUrl);
			}
		}			
		
		if ($iPostId = $this->request()->getInt('post'))
		{
			$iCurrentPage = Phpfox::getService('forum.post')->getPostPage($aThread['thread_id'], $iPostId, $iPageSize);			
			
			$sFinalLink = $this->url()->permalink('forum.thread', $aThread['thread_id'], $aThread['title'], false, null, array('page' => $iCurrentPage));
			
			$this->url()->forward($sFinalLink . '#post' . $iPostId);
		}			
		
		if (!$aThread['is_seen'])
		{
			if ($aCallback === null)
			{
				Phpfox::getService('forum.process')->updateTrack($aForum['forum_id']);
			}
			Phpfox::getService('forum.thread.process')->updateTrack($aThread['thread_id']);
		}
		
		if (Phpfox::isModule('tag') && $aCallback === null)
		{
			$aTags = Phpfox::getService('tag')->getTagsById(($aCallback === null ? 'forum' : 'forum_group'), $aThread['thread_id']);				
			if (isset($aTags[$aThread['thread_id']]))
			{
				$aThread['tag_list'] = $aTags[$aThread['thread_id']];
			}
		}		
		
		// Add tags to meta keywords
		if (!empty($aThread['tag_list']) && $aThread['tag_list'] && Phpfox::isModule('tag'))
		{
			$this->template()->setMeta('keywords', Phpfox::getService('tag')->getKeywords($aThread['tag_list']));
		}		
		
		$this->setParam('iActiveForumId', $aForum['forum_id']);
		
		if (Phpfox::getParam('forum.rss_feed_on_each_forum'))
		{
			if ($aCallback === null)
			{
				$this->template()->setHeader('<link rel="alternate" type="application/rss+xml" title="' . Phpfox::getPhrase('forum.forum') . ': ' . $aForum['name'] . '" href="' . $this->url()->makeUrl('forum', array('rss', 'forum' => $aForum['forum_id'])) . '" />');
			}
			else 
			{
				$this->template()->setHeader('<link rel="alternate" type="application/rss+xml" title="' . Phpfox::getPhrase('forum.group_forum') . ': ' . $aCallback['title'] . '" href="' . $this->url()->makeUrl('forum', array('rss', 'group' => $aCallback['group_id'])) . '" />');				
			}
		}		
		
		if (Phpfox::getParam('forum.enable_rss_on_threads'))
		{
			$this->template()->setHeader('<link rel="alternate" type="application/rss+xml" title="' . Phpfox::getPhrase('forum.thread') . ': ' . $aThread['title'] . '" href="' . $this->url()->makeUrl('forum', array('rss', 'thread' => $aThread['thread_id'])) . '" />');
		}
		
		if ($aCallback === null)
		{
			$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.forum'), $this->url()->makeUrl('forum'))
				->setBreadcrumb($aForum['breadcrumb'])->setBreadcrumb(Phpfox::getLib('locale')->convert($aForum['name']), $this->url()->permalink('forum', $aForum['forum_id'], $aForum['name']));
		}	
		else 
		{
			$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.pages'), $this->url()->makeUrl('pages'));
			$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);
			$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.discussions'), $aCallback['url_home'] . 'forum/');
		}
		
		$bCanManageThread = false;		
		$bCanEditThread = false;
		$bCanDeleteThread = false;
		$bCanStickThread = false;
		$bCanCloseThread = false;
		$bCanMergeThread = false;
		if ($aCallback === null)
		{			
			if (((Phpfox::getUserParam('forum.can_edit_own_post') && $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_edit_other_posts') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'edit_post')))
			{
				$bCanEditThread = true;	
			}
			
			if ((Phpfox::getUserParam('forum.can_delete_own_post') && $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_delete_other_posts') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'delete_post'))
			{
				$bCanDeleteThread = true;
			}
			
			if ((Phpfox::getUserParam('forum.can_stick_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'post_sticky')))
			{
				$bCanStickThread = true;
			}
			
			if ((Phpfox::getUserParam('forum.can_close_a_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'close_thread')))
			{
				$bCanCloseThread = true;
			}
			
			if ((Phpfox::getUserParam('forum.can_merge_forum_threads') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'merge_thread')))
			{
				$bCanMergeThread = true;
			}
			
			if (
				((Phpfox::getUserParam('forum.can_edit_own_post') && $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_edit_other_posts') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'edit_post'))
				|| (Phpfox::getUserParam('forum.can_move_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'move_thread'))
				|| (Phpfox::getUserParam('forum.can_copy_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'copy_thread'))
				|| (Phpfox::getUserParam('forum.can_delete_own_post') && $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_delete_other_posts') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'delete_post')
				|| (Phpfox::getUserParam('forum.can_stick_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'post_sticky'))
				|| (Phpfox::getUserParam('forum.can_close_a_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'close_thread'))
				|| (Phpfox::getUserParam('forum.can_merge_forum_threads') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'merge_thread'))
			)
			{
				$bCanManageThread = true;	
			}
		}
		else 
		{
			if (Phpfox::getService('pages')->isAdmin($aCallback['item']))
			{
				$bCanEditThread = true;
				$bCanDeleteThread = true;
				$bCanStickThread = true;
				$bCanCloseThread = true;
				$bCanMergeThread = true;
				$bCanManageThread = true;
			}			
		}
		
		$bCanPurchaseSponsor = false;
		if ( 
		    ((Phpfox::getUserParam('forum.can_purchase_sponsor') && $aThread['user_id'] == Phpfox::getUserId())
		  || ($bCanCloseThread || $bCanStickThread)
		  || Phpfox::getUserParam('forum.can_sponsor_thread')
			) && !defined('PHPFOX_IS_GROUP_VIEW')) // sponsor is disabled in gorups
		{
		    $bCanPurchaseSponsor = true;
		}
		
        $sCurrentThreadLink = ($aCallback === null ? $this->url()->makeUrl('forum', array($aForum['name_url'] . '-' . $aForum['forum_id'], $aThread['title_url'])) : $this->url()->makeUrl($aCallback['url_home'], $aThread['title_url']));
        
        if (Phpfox::isModule('video'))
		{
			$this->template()->setHeader('cache', array(
					'player/flowplayer/flowplayer.js' => 'static_script',
					'player/' . Phpfox::getParam('core.default_music_player') . '/core.js' => 'static_script'	
				)
			);
		}
        
		$this->template()->setTitle($aThread['title'])						
			->setBreadcrumb($aThread['title'], $this->url()->permalink('forum.thread', $aThread['thread_id'], $aThread['title']), true)
			->setMeta('description', $aThread['title'] . ' - ' . $aForum['name'])
			->setMeta('keywords', $this->template()->getKeywords($aThread['title']))
			->setPhrase(array(
					'forum.provide_a_reply',
					'forum.adding_your_reply',
					'forum.are_you_sure',
					'forum.post_successfully_deleted'
				)
			)
			->setEditor()
			->setHeader('cache', array(
					'forum.css' => 'style_css',
					'pager.css' => 'style_css',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'quick_edit.js' => 'static_script',
					'forum.js' => 'module_forum',
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',					
					'switch_legend.js' => 'static_script',
					'switch_menu.js' => 'static_script',
					'comment.css' => 'style_css',
					'feed.js' => 'module_feed'
				)
			)
			->assign(array(
					'aThread' => $aThread,
					'iTotalPosts' => $iCnt,
					'sCurrentThreadLink' => $sCurrentThreadLink,
					'aCallback' => $aCallback,
					'bCanManageThread' => $bCanManageThread,
					'bCanEditThread' => $bCanEditThread,
					'bCanDeleteThread' => $bCanDeleteThread,
					'bCanStickThread' => $bCanStickThread,
					'bCanCloseThread' => $bCanCloseThread,
					'bCanMergeThread' => $bCanMergeThread,
					'bCanPurchaseSponsor' => $bCanPurchaseSponsor,
					'sPermaView' => $sPermaView,
					'aPoll' => (empty($aThread['poll']) ? false : $aThread['poll']),
					'bIsViewingPoll' => true,
					'bIsCustomPoll' => true,
					'sMicroPropType' => 'CreativeWork'
				)
			);
			
			$this->setParam('global_moderation', array(
					'name' => 'forumpost',
					'ajax' => 'forum.postModeration',
					'menu' => array(
						array(
							'phrase' => Phpfox::getPhrase('forum.delete'),
							'action' => 'delete'
						),
						array(
							'phrase' => Phpfox::getPhrase('forum.approve'),
							'action' => 'approve'
						)					
					)
				)
			);		
			
		Phpfox::getLib('parse.output')->setEmbedParser(array(
				'width' => 640,
				'height' => 360
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_thread_clean')) ? eval($sPlugin) : false);
	}
}

?>
