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
 * @package  		Module_Blog
 * @version 		$Id: view.class.php 7019 2014-01-06 17:06:31Z Fern $
 */
class Blog_Component_Controller_View extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if ($this->request()->getInt('id'))
		{
			return Phpfox::getLib('module')->setController('error.404');
		}

		if (Phpfox::isUser() && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('comment_blog', $this->request()->getInt('req2'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('blog_like', $this->request()->getInt('req2'), Phpfox::getUserId());
		}
		
		Phpfox::getUserParam('blog.view_blogs', true);
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_view_process_start')) ? eval($sPlugin) : false);	
		
		$bIsProfile = $this->getParam('bIsProfile');		
		if ($bIsProfile === true)
		{
			$this->setParam(array(
					'bViewProfileBlog' => true,
					'sTagType' => 'blog'
				)
			);
		}
	
		$aItem = Phpfox::getService('blog')->getBlog($this->request()->getInt('req2'));

		if ( (!isset($aItem['blog_id'])) || 
			(isset($aItem['module_id']) && Phpfox::isModule($aItem['module_id']) != true))
		{			
			return Phpfox_Error::display(Phpfox::getPhrase('blog.blog_not_found'));
		}
		
		if (Phpfox::getUserId() == $aItem['user_id'] && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('blog_approved', $this->request()->getInt('req2'), Phpfox::getUserId());
		}				
		
		Phpfox::getService('core.redirect')->check($aItem['title']);
		if (Phpfox::isModule('privacy'))
		{
			Phpfox::getService('privacy')->check('blog', $aItem['blog_id'], $aItem['user_id'], $aItem['privacy'], $aItem['is_friend']);
		}
		
		// http://www.phpfox.com/tracker/view/14944/
		if((isset($aItem['module_id']) && $aItem['module_id'] == 'pages') && Phpfox::isModule($aItem['module_id']))
		{
			if(!Phpfox::getService('pages')->hasPerm($aItem['item_id'], 'blog.view_browse_blogs'))
			{
				Phpfox::getLib('url')->send('privacy.invalid');
			}
		}
		
		if (!Phpfox::getUserParam('blog.can_approve_blogs'))
		{
			if ($aItem['is_approved'] != '1' && $aItem['user_id'] != Phpfox::getUserId())
			{
				return Phpfox_Error::display(Phpfox::getPhrase('blog.blog_not_found'), 404);
			}
		}
		
		if ($aItem['post_status'] == 2 && Phpfox::getUserId() != $aItem['user_id'] && !Phpfox::getUserParam('blog.edit_user_blog'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('blog.blog_not_found'));
		}		
		
		if (Phpfox::isModule('track') && Phpfox::isUser() && Phpfox::getUserId() != $aItem['user_id'] && !$aItem['is_viewed'])
		{
			Phpfox::getService('track.process')->add('blog', $aItem['blog_id']);
			Phpfox::getService('blog.process')->updateView($aItem['blog_id']);
		}
		
		if (Phpfox::isUser() && Phpfox::isModule('track') && Phpfox::getUserId() != $aItem['user_id'] && $aItem['is_viewed'] && !Phpfox::getUserBy('is_invisible'))
		{
			Phpfox::getService('track.process')->update('blog_track', $aItem['blog_id']);	
		}		
		
		// Define params for "review views" block
		$this->setParam(array(
				'sTrackType' => 'blog',
				'iTrackId' => $aItem['blog_id'],
				'iTrackUserId' => $aItem['user_id']
			)
		);
		
		if ($sPassword = $this->request()->get('blog_password'))
		{			
			if (Phpfox::getUserParam('blog.can_view_password_protected_blog'))
			{
				if (Phpfox::getService('blog')->verifyPassword($aItem['blog_id'], $sPassword))
				{
					$this->url()->permalink('blog', $aItem['blog_id'], $aItem['title'], true);
				}
				else 
				{
					$this->url()->permalink('blog', $aItem['blog_id'], $aItem['title'], true, Phpfox::getPhrase('blog.password_is_invalid'));
				}			
			}
			else 
			{
				$this->url()->permalink('blog', $aItem['blog_id'], $aItem['title'], true, Phpfox::getPhrase('blog.unable_to_view_password_protected_blogs'));
			}
		}
		
		$aCategories = Phpfox::getService('blog.category')->getCategoriesById($aItem['blog_id']);
		
		if (Phpfox::isModule('tag'))
		{
			$aTags = Phpfox::getService('tag')->getTagsById('blog', $aItem['blog_id']);	
			if (isset($aTags[$aItem['blog_id']]))
			{
				$aItem['tag_list'] = $aTags[$aItem['blog_id']];
			}
		}

		if (isset($aCategories[$aItem['blog_id']]))
		{
			$sCategories = '';
			foreach ($aCategories[$aItem['blog_id']] as $iKey => $aCategory)
			{
				$sCategories .= ($iKey != 0 ? ',' : '') . ' <a href="' . ($aCategory['user_id'] ? $this->url()->permalink($aItem['user_name'] . '.blog.category', $aCategory['category_id'], $aCategory['category_name']) : $this->url()->permalink('blog.category', $aCategory['category_id'], $aCategory['category_name'])) . '">' . Phpfox::getLib('locale')->convert(Phpfox::getLib('parse.output')->clean($aCategory['category_name'])) . '</a>';
				
				$this->template()->setMeta('keywords', $aCategory['category_name']);
			}
		}

		if (isset($sCategories))
		{
			$aItem['info'] = Phpfox::getPhrase('blog.posted_x_by_x_in_x', array('date' => Phpfox::getTime(Phpfox::getParam('blog.blog_time_stamp'), $aItem['time_stamp']), 'link' => Phpfox::getLib('url')->makeUrl('profile', array($aItem['user_name'])), 'user' => $aItem, 'categories' => $sCategories));
		}
		else 
		{
			$aItem['info'] = Phpfox::getPhrase('blog.posted_x_by_x', array('date' => Phpfox::getTime(Phpfox::getParam('blog.blog_time_stamp'), $aItem['time_stamp']), 'link' => Phpfox::getLib('url')->makeUrl('profile', array($aItem['user_name'])), 'user' => $aItem));
		}		
		
		$aItem['bookmark_url'] = Phpfox::permalink('blog', $aItem['blog_id'], $aItem['title']);

		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_view_process_middle')) ? eval($sPlugin) : false);
		
		// Add tags to meta keywords
		if (!empty($aItem['tag_list']) && $aItem['tag_list'] && Phpfox::isModule('tag'))
		{
			$this->template()->setMeta('keywords', Phpfox::getService('tag')->getKeywords($aItem['tag_list']));
		}	
		
		if (isset($aItem['module_id']) && Phpfox::hasCallback($aItem['module_id'], 'getVideoDetails'))
		{
		    if ($aCallback = Phpfox::callback($aItem['module_id'] . '.getVideoDetails', $aItem))
			{
				$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home']);
				$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);	
				//$this->template()->setBreadcrumb()
			}
		}
		$this->setParam('aFeed', array(				
				'comment_type_id' => 'blog',
				'privacy' => $aItem['privacy'],
				'comment_privacy' => $aItem['privacy_comment'],
				'like_type_id' => 'blog',
				'feed_is_liked' => isset($aItem['is_liked']) ? $aItem['is_liked'] : false,
				'feed_is_friend' => $aItem['is_friend'],
				'item_id' => $aItem['blog_id'],
				'user_id' => $aItem['user_id'],
				'total_comment' => $aItem['total_comment'],
				'total_like' => $aItem['total_like'],
				'feed_link' => $aItem['bookmark_url'],
				'feed_title' => $aItem['title'],
				'feed_display' => 'view',
				'feed_total_like' => $aItem['total_like'],
				'report_module' => 'blog',
				'report_phrase' => Phpfox::getPhrase('blog.report_this_blog'),
				'time_stamp' => $aItem['time_stamp']
			)
		);		
		$sBreadcrumb = $this->url()->makeUrl('blog');
		if (isset($aCallback) && isset($aCallback['item_id']))
		{
		    $sBreadcrumb = $this->url()->makeUrl('pages.' . $aCallback['item_id'] .'.blog');
		}
		
		if (isset($aCallback) && isset($aCallback['module_id']) && $aCallback['module_id'] == 'pages')
		{
			$this->setParam('sTagListParentModule', $aItem['module_id']);
			$this->setParam('iTagListParentId', (int) $aItem['item_id']);
		}
		
		$this->template()->setTitle($aItem['title'])
		 	->setBreadCrumb(Phpfox::getPhrase('blog.blogs_title'), $sBreadcrumb)			
		 	->setBreadCrumb($aItem['title'], $this->url()->permalink('blog', $aItem['blog_id'], $aItem['title']), true)
			->setMeta('description', $aItem['title'] . '.')
			->setMeta('description', $aItem['text'] . '.')
			->setMeta('description', $aItem['info'] . '.')
			->setMeta('keywords', $this->template()->getKeywords($aItem['title']))	
			->assign(array(
					'aItem' => $aItem,
					'bBlogView' => true,
					'bIsProfile' => $bIsProfile,
					'sTagType' => ($bIsProfile === true ? 'blog_profile' : 'blog'),
					'iShorten' => Phpfox::getParam('blog.length_in_index'),
					'sMicroPropType' => 'BlogPosting'
				)
			)->setHeader('cache', array(
				'jquery/plugin/jquery.highlightFade.js' => 'static_script',
				'jquery/plugin/jquery.scrollTo.js' => 'static_script',
				'quick_edit.js' => 'static_script',
				'comment.css' => 'style_css',
				'pager.css' => 'style_css',
				'feed.js' => 'module_feed'
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
		
		if (Phpfox::getParam('blog.digg_integration'))
		{
			$this->template()->setHeader('<script type="text/javascript">$Behavior.blog_view_digg = function() {var s = document.createElement(\'SCRIPT\'), s1 = document.getElementsByTagName(\'SCRIPT\')[0];s.type = \'text/javascript\';s.async = true;s.src = \'http://widgets.digg.com/buttons.js\';s1.parentNode.insertBefore(s, s1);};</script>');
		}
		
		if ($this->request()->get('req4') == 'comment')
		{
			$this->template()->setHeader('<script type="text/javascript">var $bScrollToBlogComment = false; $Behavior.scrollToBlogComment = function () { if ($bScrollToBlogComment) { return; } $bScrollToBlogComment = true; if ($(\'#js_feed_comment_pager_' . $aItem['blog_id'] . '\').length > 0) { $.scrollTo(\'#js_feed_comment_pager_' . $aItem['blog_id'] . '\', 800); } }</script>');
		}
		
		if ($this->request()->get('req4') == 'add-comment')
		{
			$this->template()->setHeader('<script type="text/javascript">var $bScrollToBlogComment = false; $Behavior.scrollToBlogComment = function () { if ($bScrollToBlogComment) { return; } $bScrollToBlogComment = true; if ($(\'#js_feed_comment_form_' . $aItem['blog_id'] . '\').length > 0) { $.scrollTo(\'#js_feed_comment_form_' . $aItem['blog_id'] . '\', 800); $Core.commentFeedTextareaClick($(\'.js_comment_feed_textarea\')); } }</script>');
		}		
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_view_process_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>
