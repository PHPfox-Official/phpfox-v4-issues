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
 * @version 		$Id: process.class.php 6876 2013-11-12 10:48:57Z Miguel_Espinoza $
 */
class Blog_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('blog');
	}	
	
	public function add($aVals)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.service_process__start')) ? eval($sPlugin) : false);
		$oFilter = Phpfox::getLib('parse.input');		
		
		if (isset($aVals['module_id']) && $aVals['module_id'] == 'pages' && Phpfox::isModule('pages') && isset($aVals['item_id']))
		{
			$iPrivacy = Phpfox::callback('pages.inheritPrivacy', array('iPageId' => $aVals['item_id'], 'sParam' => 'blog.view_browse_blogs'));
			$aVals['privacy'] = $iPrivacy;
			$aVals['privacy_comment'] = $iPrivacy;
		}
		else if (isset($aVals['module_id']) && !empty($aVals['module_id']) && isset($aVals['item_id']) && !empty($aVals['item_id']) && 
			($aVals['privacy'] == 0 || $aVals['privacy_comment'] == 0) && Phpfox::hasCallback($aVals['module_id'], 'getItem'))
		{
			$aNewPrivacy = Phpfox::callback($aVals['module_id'] . '.getItem', $aVals['item_id']);
			
			if ($aVals['privacy'] == 0 && $aNewPrivacy['privacy'] != 0)
			{
				$aVals['privacy'] = $aNewPrivacy['privacy'];
			}
			if (isset($aNewPrivacy['privacy_comment']) && $aVals['privacy_comment'] == 0 && $aNewPrivacy['privacy_comment'] != 0)
			{
				$aVals['privacy_comment'] = $aNewPrivacy['privacy_comment'];
			}
			
		}
		
		// check if the user entered a forbidden word
		Phpfox::getService('ban')->checkAutomaticBan($aVals['text'] . ' ' . $aVals['title']);

		if (!Phpfox::getParam('blog.allow_links_in_blog_title'))
		{
			if (!Phpfox::getLib('validator')->check($aVals['title'], array('url')))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('blog.we_do_not_allow_links_in_titles'));
			}
		}		
		if (!isset($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		if (!isset($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}

		$sTitle = $oFilter->clean($aVals['title'], 255);
		
		$bHasAttachments = (!empty($aVals['attachment']) && Phpfox::getUserParam('attachment.can_attach_on_blog'));		
		if (!isset($aVals['post_status']))
		{
			$aVals['post_status'] = 1;
		}

		$aInsert = array(
			'user_id' => Phpfox::getUserId(),
			'title' => $sTitle,
			'time_stamp' => PHPFOX_TIME,
			'is_approved' => 1,
			'privacy' => (isset($aVals['privacy']) ? $aVals['privacy'] : '0'),
			'privacy_comment' => (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0'),
			'post_status' => (isset($aVals['post_status']) ? $aVals['post_status'] : '1'),
			'total_attachment' => ($bHasAttachments ? Phpfox::getService('attachment')->getCount($aVals['attachment']) : 0)
		);		
		if (isset($aVals['item_id']) && isset($aVals['module_id']))
		{
			$aInsert['item_id'] = (int)$aVals['item_id'];
			$aInsert['module_id'] = $oFilter->clean($aVals['module_id']);
		}
		
		
		$bIsSpam = false;
		if (Phpfox::getParam('blog.spam_check_blogs'))
		{
			if (Phpfox::getLib('spam')->check(array(
						'action' => 'isSpam',										
						'params' => array(
							'module' => 'blog',
							'content' => $oFilter->prepare($aVals['text'])
						)
					)
				)
			)
			{
				$aInsert['is_approved'] = '9';
				$bIsSpam = true;				
			}
		}
		
		if (Phpfox::getUserParam('blog.approve_blogs'))
		{
			$aInsert['is_approved'] = '0';
			$bIsSpam = true;
		}
		
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_add_start')) ? eval($sPlugin) : false);

		$iId = $this->database()->insert(Phpfox::getT('blog'), $aInsert);		
		
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_add_end')) ? eval($sPlugin) : false);
		
		$this->database()->insert(Phpfox::getT('blog_text'), array(
				'blog_id' => $iId,
				'text' => $oFilter->clean($aVals['text']),
				'text_parsed' => $oFilter->prepare($aVals['text'])
			)
		);
		
		if (!empty($aVals['selected_categories']))
		{
			Phpfox::getService('blog.category')->addCategoryForBlog($iId, explode(',', rtrim($aVals['selected_categories'], ',')), ($aVals['post_status'] == 1 ? true : false));
		}

		if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support') && Phpfox::getUserParam('tag.can_add_tags_on_blogs'))
		{
			Phpfox::getService('tag.process')->add('blog', $iId, Phpfox::getUserId(), $aVals['text'], true);
		}
		else
		{
			if (Phpfox::getUserParam('tag.can_add_tags_on_blogs') && Phpfox::isModule('tag') && isset($aVals['tag_list']) && ((is_array($aVals['tag_list']) && count($aVals['tag_list'])) || (!empty($aVals['tag_list']))))
			{
				Phpfox::getService('tag.process')->add('blog', $iId, Phpfox::getUserId(), $aVals['tag_list']);
			}
		}
		
		// If we uploaded any attachments make sure we update the 'item_id'
		if ($bHasAttachments)
		{
			Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], Phpfox::getUserId(), $iId);
		}		
	
		if ($bIsSpam === true)
		{			
			return $iId;
		}		
		
		if ($aVals['post_status'] == 1)
		{
			if (isset($aVals['module_id']) && $aVals['module_id'] == 'pages')
			{
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->callback(Phpfox::callback($aVals['module_id'] . '.getFeedDetails', $aVals['item_id']))->add('blog', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0), $aVals['item_id']) : null);
			}
			else
			{
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('blog', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0)) : null);
			}
			
			// Update user activity
			Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'blog', '+');
		}		
		
		if ($aVals['privacy'] == '4')
		{
			Phpfox::getService('privacy.process')->add('blog', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));			
		}		
		
		// $this->cache()->remove(array('user/' . Phpfox::getUserId(), 'blog_browse'), 'substr');
		
		(($sPlugin = Phpfox_Plugin::get('blog.service_process__end')) ? eval($sPlugin) : false);	
		
		return $iId;
	}
	
	public function update($iId, $iUserId, $aVals, &$aRow = null)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_update__start')) ? eval($sPlugin) : false);
		
		if (!isset($aVals['post_status']))
		{
			// $aVals['post_status'] = 1;
		}
		
		if (!isset($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		
		if (!isset($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}		

		$oFilter = Phpfox::getLib('parse.input');
		
		$bHasAttachments = (!empty($aVals['attachment']) && Phpfox::getUserParam('attachment.can_attach_on_blog') && $iUserId == Phpfox::getUserId());		
		Phpfox::getService('ban')->checkAutomaticBan($aVals['title'] . ' ' . $aVals['text']);
		if ($bHasAttachments)
		{
			Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], $iUserId, $iId);
		}

		$sTitle = $oFilter->clean($aVals['title'], 255);
		$aUpdate = array(
			'title' => $sTitle,
			'time_update' => PHPFOX_TIME,
			'is_approved' => 1,
			'privacy' => (isset($aVals['privacy']) ? $aVals['privacy'] : '0'),
			'privacy_comment' => (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0'),
			'post_status' => (isset($aVals['post_status']) ? $aVals['post_status'] : '1'),
			'total_attachment' => (Phpfox::isModule('attachment') ? Phpfox::getService('attachment')->getCountForItem($iId, 'blog') : '0')
		);		

		if ($aRow !== null && isset($aVals['post_status']) && $aRow['post_status'] == '2' && $aVals['post_status'] == '1')
		{
			$aUpdate['time_stamp'] = PHPFOX_TIME;	
		}
		
		if (Phpfox::getUserParam('blog.approve_blogs')) // if the blogs added by this user group need to be approved...
		{
			$aVals['is_approved'] = $aUpdate['is_approved'] = 0;
		}
		
		
		$bIsSpam = false;
		if (Phpfox::getParam('blog.spam_check_blogs'))
		{
			if (Phpfox::getLib('spam')->check(array(
						'action' => 'isSpam',										
						'params' => array(
							'module' => 'blog',
							'content' => $oFilter->prepare($aVals['text'])
						)
					)
				)
			)
			{
				$aInsert['is_approved'] = '9';
				$bIsSpam = true;				
			}
		}
	
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_update')) ? eval($sPlugin) : false);
		
		$this->database()->update(Phpfox::getT('blog'), $aUpdate, 'blog_id = ' . (int) $iId);	
		$this->database()->update(Phpfox::getT('blog_text'), array(
			'text' => $oFilter->clean($aVals['text']), 
			'text_parsed' => $oFilter->prepare($aVals["text"])
		), 'blog_id = ' . (int) $iId);
		
		Phpfox::getService('blog.category')->updateCategoryForBlog($iId, explode(',', rtrim($aVals['selected_categories'], ',')), ($aVals['post_status'] == 1 ? true : false));


		if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support') && Phpfox::getUserParam('tag.can_add_tags_on_blogs'))
		{
			Phpfox::getService('tag.process')->update('blog', $iId, Phpfox::getUserId(), $aVals['text'], true);
		}
		else
		{
			if (Phpfox::isModule('tag') && Phpfox::getUserParam('tag.can_add_tags_on_blogs'))
			{
				Phpfox::getService('tag.process')->update('blog', $iId, $iUserId, (!Phpfox::getLib('parse.format')->isEmpty($aVals['tag_list']) ? $aVals['tag_list'] : null));
			}
		}
				
		if ($aRow !== null && $aRow['post_status'] == '2' && $aVals['post_status'] == '1')
		{	
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('blog', $iId, $aVals['privacy'], $aVals['privacy_comment'], 0, $iUserId) : null);
			
			// Update user activity
			Phpfox::getService('user.activity')->update($iUserId, 'blog');			
		}
		else 
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('blog', $iId, $aVals['privacy'], $aVals['privacy_comment'], 0, $iUserId) : null);
		}		
		
		if (Phpfox::isModule('privacy'))
		{
			if ($aVals['privacy'] == '4')
			{
				Phpfox::getService('privacy.process')->update('blog', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));
			}
			else 
			{
				Phpfox::getService('privacy.process')->delete('blog', $iId);
			}			
		}
		
		// $this->cache()->remove(array('user/' . $iUserId, 'blog_browse'), 'substr');
		
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_update__end')) ? eval($sPlugin) : false);
		
		return $iId;
	}	
	
	public function updateBlogTitle($iId, $sTitle)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_updateblogtitle__start')) ? eval($sPlugin) : false);
		if (Phpfox::getService('blog')->hasAccess($iId, 'edit_own_blog', 'edit_user_blog'))
		{
			Phpfox::getService('ban')->checkAutomaticBan($sTitle);
			if (!Phpfox::getParam('blog.allow_links_in_blog_title'))
			{
				if (!Phpfox::getLib('validator')->check($sTitle, array('url')))
				{
					return Phpfox_Error::set(Phpfox::getPhrase('blog.we_do_not_allow_links_in_titles'));
				}
			}			
			
			$oFilter = Phpfox::getLib('parse.input');
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('blog', $iId, $oFilter->clean($sTitle, 255)) : null);

			$this->database()->update(Phpfox::getT('blog'), array(
				'title' => Phpfox::getLib('parse.input')->clean($sTitle, 255),
				"time_update" => PHPFOX_TIME
			), "blog_id = " . (int) $iId);
			
			return true;
		}
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_updateblogtitle__end')) ? eval($sPlugin) : false);
		return false;
	}
	
	public function updatePermaLink($iId, $sTitle)
	{
		if (Phpfox::getService('blog')->hasAccess($iId, 'edit_own_blog', 'edit_user_blog'))
		{		
			$this->database()->update(Phpfox::getT('blog'), array(
				"title_url" => Phpfox::getService('blog')->prepareTitle($sTitle),
			), "blog_id = " . (int)$iId);
			
			return true;
		}
		
		return false;
	}	
	
	public function updateBlogText($iId, $sText)
	{
		Phpfox::getService('ban')->checkAutomaticBan($sText);
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_updateblogtext__start')) ? eval($sPlugin) : false);
		if (Phpfox::getService('blog')->hasAccess($iId, 'edit_own_blog', 'edit_user_blog'))
		{
			$oFilter = Phpfox::getLib('parse.input');
			
			if (Phpfox::getParam('blog.spam_check_blogs'))
			{
				if (Phpfox::getLib('spam')->check(array(
							'action' => 'isSpam',										
							'params' => array(
								'module' => 'blog',
								'content' => Phpfox::getLib('parse.input')->prepare($sText)
							)
						)
					)
				)
				{
					$this->database()->update(Phpfox::getT('blog'), array('is_approved' => '9'), "blog_id = " . (int) $iId);					
					
					Phpfox_Error::set(Phpfox::getPhrase('blog.your_blog_has_been_marked_as_spam'));
				}
			}			
			
			$this->database()->update(Phpfox::getT('blog'), array(
				'time_update' => PHPFOX_TIME
			), "blog_id = " . (int) $iId);

			$this->database()->update(Phpfox::getT('blog_text'), array(
				'text' => $oFilter->clean($sText), "text_parsed" => $oFilter->prepare($sText)
			), "blog_id = " . (int) $iId);
			
			if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support') && Phpfox::getUserParam('tag.can_add_tags_on_blogs'))
			{
				Phpfox::getService('tag.process')->update('blog', $iId, Phpfox::getUserId(), $sText, true);
			}
			
			return true;
		}
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_updateblogtext__end')) ? eval($sPlugin) : false);
		return false;
	}
	
	public function deleteInline($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_deleteinline__start')) ? eval($sPlugin) : false);
		if (($iUserId = Phpfox::getService('blog')->hasAccess($iId, 'delete_own_blog', 'delete_user_blog')))
		{
			$aBlog = $this->database()->select('*')
				->from(Phpfox::getT('blog'))
				->where('blog_id = ' . (int) $iId)
				->execute('getSlaveRow');

			$this->delete($iId);
			
			(Phpfox::isModule('attachment') ? Phpfox::getService('attachment.process')->deleteForItem($iUserId, $iId, 'blog') : null);
			(Phpfox::isModule('comment') ? Phpfox::getService('comment.process')->deleteForItem($iUserId, $iId, 'blog') : null);
			(Phpfox::isModule('tag') ? Phpfox::getService('tag.process')->deleteForItem($iUserId, $iId, 'blog') : null);
			
			// Update user activity
			Phpfox::getService('user.activity')->update($iUserId, 'blog', '-');				
			
			if (Phpfox::isModule('tag'))
			{
				Phpfox::getService('tag.process')->deleteForItem(Phpfox::getUserId(), $iId, 'blog');
			}

			return $aBlog;
		}
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_deleteinline__end')) ? eval($sPlugin) : false);
		return false;
	}
	
	public function delete($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_delete__start')) ? eval($sPlugin) : false);
		$aBlog = Phpfox::getService('blog')->getBlogForEdit($iId);
		
		$this->database()->delete(Phpfox::getT('tag'), "category_id = 'blog' AND item_id = " . (int) $iId);
		
		$this->database()->delete(Phpfox::getT('blog'), "blog_id = " . (int) $iId);		
		$this->database()->delete(Phpfox::getT('blog_text'), "blog_id = " . (int) $iId);		
		$this->database()->delete(Phpfox::getT('blog_track'), 'item_id = ' . (int)$iId);
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('blog',(int) $iId) : null);
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('comment_blog', $iId) : null);		
		
		// Update user activity
		Phpfox::getService('user.activity')->update($aBlog['user_id'], 'blog', '-');
		
		$aRows = $this->database()->select('blog_id, category_id')
			->from(Phpfox::getT('blog_category_data'))
			->where('blog_id = ' . (int) $iId)
			->execute('getRows');
		
		if (count($aRows))
		{
			foreach ($aRows as $aRow)
			{
				$this->database()->delete(Phpfox::getT('blog_category_data'), "blog_id = " . (int) $aRow['blog_id'] . " AND category_id = " . (int) $aRow['category_id']);				
				$this->database()->updateCount('blog_category_data', 'category_id = ' . (int) $aRow['category_id'], 'used', 'blog_category', 'category_id = ' . (int) $aRow['category_id']);			
			}
		}	
		
		if (Phpfox::isModule('tag'))
		{
			$this->database()->delete(Phpfox::getT('tag'), 'item_id = ' . $aBlog['blog_id'] . ' AND category_id = "blog"', 1);		
			$this->cache()->remove('tag', 'substr');
		}
			
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_delete')) ? eval($sPlugin) : false);
	}
	
	public function updateView($iId)
	{
		$this->database()->query("
			UPDATE " . $this->_sTable . "
			SET total_view = total_view + 1
			WHERE blog_id = " . (int) $iId . "
		");			
		
		return true;
	}
	
	public function updateCounter($iId, $bMinus = false)
	{
		$this->database()->query("
			UPDATE " . $this->_sTable . "
			SET total_comment = total_comment " . ($bMinus ? "-" : "+") . " 1
			WHERE blog_id = " . (int) $iId . "
		");	
	}
	
	public function approve($iId)
	{
		Phpfox::getUserParam('blog.can_approve_blogs', true);
		
		$aBlog = $this->database()->select('b.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('blog'), 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.blog_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aBlog['blog_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('blog.the_blog_you_are_trying_to_approve_is_not_valid'));
		}
		
		if ($aBlog['is_approved'] == '1')
		{
			return false;
		}
		
		$this->database()->update(Phpfox::getT('blog'), array('is_approved' => '1', 'time_stamp' => PHPFOX_TIME), 'blog_id = ' . $aBlog['blog_id']);

		if (Phpfox::isModule('feed') && $aBlog['post_status'] == 1)
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('blog', $iId, $aBlog['privacy'], $aBlog['privacy_comment'], 0, $aBlog['user_id']) : null);
		}		
		
		if (Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->add('blog_approved', $aBlog['blog_id'], $aBlog['user_id']);
		}
		
		if ($aBlog['is_approved'] == '9')
		{
			$this->database()->updateCounter('user', 'total_spam', 'user_id', $aBlog['user_id'], true);
		}
		
		Phpfox::getService('user.activity')->update($aBlog['user_id'], 'blog');
		
		(($sPlugin = Phpfox_Plugin::get('blog.service_process_approve__1')) ? eval($sPlugin) : false);
		
		// Send the user an email
		$sLink = Phpfox::getLib('url')->permalink('blog', $aBlog['blog_id'], $aBlog['title']);
		Phpfox::getLib('mail')->to($aBlog['user_id'])
			->subject(array('blog.your_blog_has_been_approved_on_site_title', array('site_title' => Phpfox::getParam('core.site_title'))))
			->message(array('blog.your_blog_has_been_approved_on_site_title_message', array('site_title' => Phpfox::getParam('core.site_title'), 'link' => $sLink)))
			->notification('blog.blog_is_approved')
			->send();			
		
		return true;
	}
	
	public function __call($sMethod, $aArguments)
	{
		if ($sPlugin = Phpfox_Plugin::get('blog.service_process__call'))
		{
			return eval($sPlugin);
		}
		
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>