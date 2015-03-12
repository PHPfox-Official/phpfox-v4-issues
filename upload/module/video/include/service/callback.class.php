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
 * @package  		Module_Video
 * @version 		$Id: callback.class.php 7302 2014-05-07 16:21:59Z Fern $
 */
class Video_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('video');
	}	
	
	public function getSiteStatsForAdmin($iStartTime, $iEndTime)
	{
		$aCond = array();
		$aCond[] = 'in_process = 0 AND view_id = 0';
		if ($iStartTime > 0)
		{
			$aCond[] = 'AND time_stamp >= \'' . $this->database()->escape($iStartTime) . '\'';
		}	
		if ($iEndTime > 0)
		{
			$aCond[] = 'AND time_stamp <= \'' . $this->database()->escape($iEndTime) . '\'';
		}			
		
		$iCnt = (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where($aCond)
			->execute('getSlaveField');
		
		return array(
			'phrase' => 'video.videos',
			'total' => $iCnt
		);
	}	
	
	public function mobileMenu()
	{
		return array(
			'phrase' => Phpfox::getPhrase('video.videos'),
			'link' => Phpfox::getLib('url')->makeUrl('video'),
			'icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'mobile/small_videos.png'))
		);
	}	

	public function enableSponsor($aParams)
	{
	    return Phpfox::getService('video.process')->sponsor((int)$aParams['item_id'], 1);
	}

	public function getProfileLink()
	{
		return 'profile.video';
	}	
	
	public function getAjaxCommentVar()
	{
		return 'video.can_add_comment_on_video';
	}	
	
	public function getCommentItem($iId)
	{
		$aRow = $this->database()->select('video_id AS comment_item_id, privacy_comment, user_id AS comment_user_id, module_id AS parent_module_id')
			->from(Phpfox::getT('video'))
			->where('video_id = ' . (int) $iId)
			->execute('getSlaveRow');		
			
		$aRow['comment_view_id'] = '0';
		
		if (!Phpfox::getService('comment')->canPostComment($aRow['comment_user_id'], $aRow['privacy_comment']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('video.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
			
			unset($aRow['comment_item_id']);
		}
			
		return $aRow;
	}	
	
	public function getTagCloud()
	{
		return array(
			'link' => 'video',
			'category' => 'video'
		);
	}	

	/**
	 * Returns information related to a video for sponsoring purposes
	 * @param int $iId video_id
	 * @return array in the format:
	 * array(
	 *	'title' => 'item title',		    <-- required
	 *	'link'  => 'makeUrl()'ed link',		    <-- required
	 *	'paypal_msg' => 'message for paypal'	    <-- required
	 *	'item_id' => int			    <-- required
	 *	'error' => 'phrase if item doesnt exit'	    <-- optional
	 *	'extra' => 'description'		    <-- optional
	 *	'image' => 'path to an image',		    <-- optional
	 *	'image_dir' => 'photo.url_photo|...	    <-- optional (required if image)
	 *	'server_id' => 'value from DB'		    <-- optional (required if image)
	 * );
	 */
	public function getToSponsorInfo($iId)
	{
	    $aVideo = $this->database()->select('v.user_id, v.title, v.video_id as item_id, vt.text_parsed as extra,
		       v.image_path as image, v.image_server_id as server_id')
		    ->from(Phpfox::getT('video'),'v')
		    ->leftjoin(Phpfox::getT('video_text'), 'vt', 'vt.video_id = v.video_id')
		    ->where('v.video_id = ' . (int)$iId)
		    ->execute('getSlaveRow');
		
	    if (empty($aVideo))
	    {
			return array('error' => Phpfox::getPhrase('video.sponsor_error_not_found'));
	    }
	    
	    //$aVideo['link'] = Phpfox::getLib('url')->makeUrl('profile.video.'.$aVideo['title_url']);
		$aVideo['link'] = Phpfox::permalink('ad.sponsor', $aVideo['item_id'], $aVideo['title']);
	    $aVideo['paypal_msg'] = Phpfox::getPhrase('video.sponsor_paypal_message', array('sVideoTitle' => $aVideo['title']));//'Video Sponsor ' . $aVideo['title'];
	    $aVideo['title'] = Phpfox::getPhrase('video.sponsor_title', array('sVideoTitle' => $aVideo['title']));
	    $aVideo['image_dir'] = 'video.url_image';
	    $aVideo['image'] = sprintf($aVideo['image'],'_120');
		
	    return $aVideo;
	}

	public function getLink($aParams)
	{
	    $aVideo = $this->database()->select('u.user_name, v.title')
		    ->from(Phpfox::getT('video'),'v')
		    ->join(Phpfox::getT('user'), 'u', 'u.user_id = v.user_id')
		    ->where('v.video_id = ' . (int)$aParams['item_id'])
		    ->execute('getSlaveRow');
	    
		if (empty($aVideo))
	    {
			return false;
	    }
			
		$sLink = Phpfox::permalink('video', (int)$aParams['item_id'], $aVideo['title']);
	    return $sLink;//Phpfox::getLib('url')->makeUrl($aVideo['user_name'].'.video.' . $aVideo['title_url'] );
	}
	
	public function getActivityFeedComment($aRow)
	{
		if (!Phpfox::getUserParam('video.can_access_videos'))
		{
			return false;
		}		
		
		if (Phpfox::isUser())
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'feed_mini\' AND l.item_id = c.comment_id AND l.user_id = ' . Phpfox::getUserId());
		}		
		
		$aItem = $this->database()->select('b.video_id, b.image_server_id, b.image_path, b.title, b.time_stamp, b.privacy, b.total_comment, b.total_like, c.total_like, ct.text_parsed AS text, f.friend_id AS is_friend, vt.text_parsed, ' . Phpfox::getUserField())
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->join(Phpfox::getT('video'), 'b', 'c.type_id = \'video\' AND c.item_id = b.video_id AND c.view_id = 0')
			->join(Phpfox::getT('video_text'), 'vt', 'vt.video_id = b.video_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = b.user_id AND f.friend_user_id = " . Phpfox::getUserId())
			->where('c.comment_id = ' . (int) $aRow['item_id'])
			->execute('getSlaveRow');
		
		if (!isset($aItem['video_id']))
		{
			return false;
		}
		
		$sLink = Phpfox::permalink('video', $aItem['video_id'], $aItem['title']);
		$sUser = '<a href="' . Phpfox::getLib('url')->makeUrl($aItem['user_name']) . '">' . $aItem['full_name'] . '</a>';
		$sGender = Phpfox::getService('user')->gender($aItem['gender'], 1);
		
		if ($aRow['user_id'] == $aItem['user_id'])
		{
			$sMessage = Phpfox::getPhrase('video.posted_a_comment_on_gender_video',array('gender' => $sGender));
		}
		else
		{			
			$sMessage = Phpfox::getPhrase('video.posted_a_comment_on_user_name_s_video',array('user_name' => $sUser));
		}
		
		$aFeed = array(
			'feed_title' => $aItem['title'],
			'feed_content' => $aItem['text_parsed'],			
			'no_share' => true,
			'feed_info' => $sMessage,
			'feed_link' => $sLink,
			'feed_status' => $aItem['text'],
			'feed_total_like' => $aItem['total_like'],
			'feed_is_liked' => isset($aItem['is_liked']) ? $aItem['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'module/video.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],
			'like_type_id' => 'feed_mini'
		);

		$bCanViewItem = true;
		if ($aItem['privacy'] > 0)
		{
			$bCanViewItem = Phpfox::getService('privacy')->check('video', $aItem['video_id'], $aItem['user_id'], $aItem['privacy'], $aItem['is_friend'], true);
		}		
		
		if ($bCanViewItem)
		{
			if (!empty($aItem['image_path']))
			{
				$aFeed['feed_image'] = Phpfox::getLib('image.helper')->display(array(
						'server_id' => $aItem['image_server_id'],
						'path' => 'video.url_image',
						'file' => $aItem['image_path'],
						'suffix' => '_120',
						'max_width' => 120,
						'max_height' => 120					
					)
				);
			}

			$aFeed['feed_image_onclick'] = '$Core.box(\'video.play\', 700, \'id=' . $aItem['video_id'] . '&amp;feed_id=' . $aRow['feed_id'] . '&amp;popup=true\', \'GET\'); return false;';			
		}
		
		return $aFeed;		
	}	

	public function addComment($aVals, $iUserId = null, $sUserName = null)
	{
		$aRow = $this->database()->select('m.video_id, m.item_id, m.title, u.full_name, u.gender, u.user_id, u.user_name')
			->from($this->_sTable, 'm')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = m.user_id')
			->where('m.video_id = ' . (int) $aVals['item_id'])
			->execute('getSlaveRow');
			
		if (!isset($aRow['video_id']))
		{
			return Phpfox_Error::trigger('Invalid callback on video.');
		}
		
		if (empty($aRow['item_id']))
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add($aVals['type'] . '_comment', $aVals['comment_id']) : null);
		}		
		
		// Update the post counter if its not a comment put under moderation or if the person posting the comment is the owner of the item.
		if (empty($aVals['parent_id']))
		{
			$this->database()->updateCounter('video', 'total_comment', 'video_id', $aRow['video_id']);		
		}
		
		// Send the user an email
		$sLink = Phpfox::getLib('url')->permalink('video', $aRow['video_id'], $aRow['title']);
		
		Phpfox::getService('comment.process')->notify(array(
				'user_id' => $aRow['user_id'],
				'item_id' => $aRow['video_id'],
				'owner_subject' => Phpfox::getPhrase('video.full_name_commented_on_your_video_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $this->preParse()->clean($aRow['title'], 100))),
				'owner_message' => 
		    Phpfox::getPhrase('video.full_name_commented_on_your_video_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aRow['title'])),
				'owner_notification' => 'comment.add_new_comment',
				'notify_id' => 'comment_video',
				'mass_id' => 'video',
				'mass_subject' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('video.full_name_commented_on_gender_video',array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1)))			    
			    : 
			    Phpfox::getPhrase('video.full_name_commented_on_other_full_name_s_video',array('full_name' => Phpfox::getUserBy('full_name'), 'other_full_name' => $aRow['full_name']))),
				'mass_message' => (Phpfox::getUserId() == $aRow['user_id'] ? 
Phpfox::getPhrase('video.full_name_commented_on_gender_video_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => $aRow['title'], 'link' => $sLink))			    
			    : Phpfox::getPhrase('video.full_name_commented_on_other_full_name_s_video_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'other_full_name' => $aRow['full_name'], 'link' => $sLink, 'title' => $aRow['title'])))
			)
		);			
	}	
	
	public function updateCommentText($aVals, $sText)
	{
		
	}	
	
	public function getItemName($iId, $sName)
	{
		return '<a href="' . Phpfox::getLib('url')->makeUrl('comment.view', array('id' => $iId)) . '">' . Phpfox::getPhrase('video.on_name_s_video', array('name' => $sName)) . '</a>';
	}	
	
	public function deleteComment($iId)
	{
		$this->database()->updateCounter('video', 'total_comment', 'video_id', $iId, true);
	}	
	
	public function getCommentNewsFeed($aRow)
	{		
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		
		
		if ($aRow['owner_user_id'] == $aRow['item_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('video.a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_video_a', array(
					'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
					'full_name' => $this->preParse()->clean($aRow['owner_full_name']),
					'title_link' => $aRow['link']
				)
			);
		}
		else 
		{
			if ($aRow['item_user_id'] == Phpfox::getUserBy('user_id'))
			{
				$aRow['text'] = Phpfox::getPhrase('video.a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_video_a', array(
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
						'full_name' => $this->preParse()->clean($aRow['owner_full_name']),
						'title_link' => $aRow['link']				
					)
				);
			}
			else 
			{
				$aRow['text'] = Phpfox::getPhrase('video.a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link_item_user_name_s_a_a_href_title_link_video_a', array(
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
						'full_name' => $this->preParse()->clean($aRow['owner_full_name']),
						'title_link' => $aRow['link'],
						'item_user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['viewer_user_id'])),
						'item_user_name' => $this->preParse()->clean($aRow['viewer_full_name'])
					)
				);
			}
		}
			
		$aRow['text'] .= Phpfox::getService('feed')->quote($aRow['content']);
		
		return $aRow;
	}	
	
	public function getFeedRedirect($iId, $iChild = 0)
	{
		$aRow = $this->database()->select('m.video_id, m.title')
			->from($this->_sTable, 'm')
			->where('m.video_id = ' . (int) $iId)
			->execute('getSlaveRow');;
			
		if (!isset($aRow['video_id']))
		{
			return false;
		}
		
		return Phpfox::permalink('video', $aRow['video_id'], $aRow['title']);
	}	
	
	public function getReportRedirect($iId)
	{
		return $this->getFeedRedirect($iId);
	}
	
	public function getNewsFeed($aRow)
	{
		if ($sPlugin = Phpfox_Plugin::get('video.service_callback_getnewsfeed_start')){eval($sPlugin);}
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		
		
		$aRow['text'] = Phpfox::getPhrase('video.a_href_user_link_owner_full_name_a_added_a_new_video_a_href_title_link_title_a', array(
				'owner_full_name' => $this->preParse()->clean($aRow['owner_full_name']),
				'title' => Phpfox::getService('feed')->shortenTitle($aRow['content']),
				'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
				'title_link' => $aRow['link']
			)
		);
		
		$aRow['icon'] = 'module/video.png';
		$aRow['enable_like'] = true;
		
		return $aRow;
	}	
	
	public function groupMenu($sGroupUrl, $iGroupId)
	{
		if (!Phpfox::getService('group')->hasAccess($iGroupId, 'can_use_video'))
		{
			return false;
		}			
		
		return array(
				Phpfox::getPhrase('friend.videos') => array(
					'active' => 'video',
					'url' => Phpfox::getLib('url')->makeUrl('group', array($sGroupUrl, 'video')
				)
			)
		);
	}

	public function getWhatsNew()
	{
		return array(
			'video.videos' => array(
				'ajax' => '#video.getNew?id=js_new_item_holder',
				'id' => 'video',
				'block' => 'video.new'
			)
		);
	}

	public function getRatingData($iId)
	{
		return array(
			'field' => 'video_id',
			'table' => 'video',
			'table_rating' => 'video_rating'
		);
	}

	public function hideBlockProfile($sType)
	{
		return array(
			'table' => ($sType == 'profile' ? 'user_design_order' : '')
		);		
	}	
	
	public function getBlockDetailsProfile()
	{
		return array(
			'title' => Phpfox::getPhrase('video.videos')
		);
	}	

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		$aVideos = $this->database()
			->select('video_id')
			->from($this->_sTable)
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');

		if (empty($aVideos))
		{
			return false;
		}
		foreach ($aVideos as $aVideo)
		{
			Phpfox::getService('video.process')->delete($aVideo['video_id']);
		}
	}
	
	public function getGroupPosting()
	{
		return array(
			Phpfox::getPhrase('video.upload_videos') => 'can_upload_video'
		);
	}	
	
	public function getGroupAccess()
	{
		return array(
			Phpfox::getPhrase('video.view_videos') => 'can_use_video'
		);
	}		
	
	public function getItemView()
	{
		if (Phpfox::getLib('request')->get('req3') != '')
		{
			return true;
		}
	}		
	
	public function addTrack($iId, $iUserId = null)
	{
		$this->database()->insert(Phpfox::getT('video_track'), array(
				'item_id' => (int) $iId,
				'user_id' => Phpfox::getUserBy('user_id'),
				'ip_address' => Phpfox::getIp(true),
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		$this->database()->updateCounter('video', 'total_view', 'video_id', $iId);
	}

	public function getNotificationFeedApproved($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('video.your_video_title_has_been_approved', array('title' => Phpfox::getLib('parse.output')->shorten($aRow['item_title'], 20, '...'))),
			'link' => Phpfox::getLib('url')->makeUrl('video', array('redirect' => $aRow['item_id'])),
			'path' => 'video.url_image',
			'suffix' => '_120'
		);		
	}
	
	public function getGlobalPrivacySettings()
	{
		return array(
			'video.display_on_profile' => array(
				'phrase' => Phpfox::getPhrase('video.videos'),
				'default' => '0'				
			)
		);
	}

	public function pendingApproval()
	{
		return array(
			'phrase' => Phpfox::getPhrase('video.videos'),
			'value' => Phpfox::getService('video')->getPendingTotal(),
			'link' => Phpfox::getLib('url')->makeUrl('video', array('view' => 'pending'))
		);
	}
	
	public function legacyRedirect($aRequest)
	{
		if (isset($aRequest['listid']))
		{							
			$aItem = Phpfox::getService('core')->getLegacyUrl(array(
					'url_field' => 'name_url',
					'table' => 'video_category',
					'field' => 'upgrade_item_id',
					'id' => $aRequest['listid'],
					'user_id' => false
				)
			);					
						
			if ($aItem !== false)
			{
				return array('video', array('category', $aItem['name_url']));
			}														
		}
		
		if (isset($aRequest['id']))
		{							
			$aItem = Phpfox::getService('core')->getLegacyUrl(array(
					'url_field' => 'title_url',
					'table' => 'video',
					'field' => 'upgrade_item_id',
					'id' => $aRequest['id']					
				)
			);					
						
			if ($aItem !== false)
			{
				return array($aItem['user_name'], array('video', $aItem['title_url']));
			}														
		}		
		
		return 'video';
	}
	
	public function verifyFavorite($iItemId)
	{
		$aItem = $this->database()->select('i.video_id')
			->from(Phpfox::getT('video'), 'i')
			->where('i.video_id = ' . (int) $iItemId . ' AND i.view_id = 0')
			->execute('getSlaveRow');
			
		if (!isset($aItem['video_id']))
		{
			return false;
		}

		return true;
	}		
	
	public function getFavorite($aFavorites)
	{
		$oServiceVideoBrowse = Phpfox::getService('video.browse');		
		
		$oServiceVideoBrowse->condition('m.video_id IN(' . implode(',', $aFavorites) . ') AND m.in_process = 0 AND m.view_id = 0')
			->execute();	
			
		$aVideos = $oServiceVideoBrowse->get();
		
		foreach ($aVideos as $iKey => $aVideo)
		{
			$aVideos[$iKey]['image'] = Phpfox::getLib('image.helper')->display(array(
					'server_id' => $aVideo['image_server_id'],
					'path' => 'video.url_image',
					'file' => $aVideo['image_path'],
					'suffix' => '_120',
					'max_width' => 75,
					'max_height' => 75
				)
			);				
		}
		
		return array(
			'title' => Phpfox::getPhrase('video.videos'),
			'items' => $aVideos
		);		
	}
	
	public function getDashboardLinks()
	{
		$aLinks = array(
			'edit' => array(
				'phrase' => Phpfox::getPhrase('video.manage_videos'),
				'link' => 'profile.video',
				'image' => 'module/video_edit.png'
			)
		);
		$aUpload = array();
		if (Phpfox::getParam('video.show_share_and_upload_video_on_dashboard') != 'upload')
		{
			$aUpload[] = array(
				'phrase' => Phpfox::getPhrase('video.share_a_video'),
				'link' => 'video.share',
				'image' => 'module/video_add.png'
			);
		}
		
		if (Phpfox::getParam('video.allow_video_uploading') && (Phpfox::getParam('video.show_share_and_upload_video_on_dashboard') != 'share'))
		{
			$aUpload[] = array(
				'phrase' => Phpfox::getPhrase('video.upload_a_video'),
				'link' => 'video.upload',
				'image' => 'module/video_add.png'
			);
		}

		$aLinks['submit'] = $aUpload;		
		return $aLinks;
			
		
	}	
	
	public function reparserList()
	{
		return array(
			'name' => Phpfox::getPhrase('video.video_text'),
			'table' => 'video_text',
			'original' => 'text',
			'parsed' => 'text_parsed',
			'item_field' => 'video_id'
		);
	}

	public function getCommentNotificationFeed($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('video.full_name_wrote_a_comment_on_your_video', array(
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'full_name' => $aRow['full_name'],
					'link' => Phpfox::getLib('url')->makeUrl('video', array('redirect' => $aRow['item_id'])),
					'title' => Phpfox::getLib('parse.output')->shorten($aRow['item_title'], 20, '...')	
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('video', array('redirect' => $aRow['item_id'])),
			'path' => 'core.url_user',
			'suffix' => '_50'
		);	
	}

	public function getDashboardActivity()
	{
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
		
		return array(
			Phpfox::getPhrase('video.videos') => $aUser['activity_video']
		);
	}		

	public function globalSearch($sQuery, $bIsTagSearch = false)
	{
		$sCondition = 'p.in_process = 0 AND p.view_id = 0 AND p.item_id = 0 AND p.privacy = 0';
		if ($bIsTagSearch === false)
		{
			$sCondition .= ' AND (p.title LIKE \'%' . $this->database()->escape($sQuery) . '%\' OR pi.text_parsed LIKE \'%' . $this->database()->escape($sQuery) . '%\')';
		}
		
		if ($bIsTagSearch == true)
		{
			$this->database()->innerJoin(Phpfox::getT('tag'), 'tag', 'tag.item_id = p.video_id AND tag.category_id = \'video\' AND tag.tag_url = \'' . $this->database()->escape($sQuery) . '\'');
		}		
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('video_text'), 'pi', 'pi.video_id = p.video_id')
			->where($sCondition)
			->execute('getSlaveField');		
			
		if ($bIsTagSearch == true)
		{
			$this->database()->innerJoin(Phpfox::getT('tag'), 'tag', 'tag.item_id = p.video_id AND tag.category_id = \'video\' AND tag.tag_url = \'' . $this->database()->escape($sQuery) . '\'')->group('p.video_id');
		}			

		$aRows = $this->database()->select('p.title, p.title_url, p.time_stamp, p.image_path, p.image_server_id, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')			
			->join(Phpfox::getT('video_text'), 'pi', 'pi.video_id = p.video_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')						
			->where($sCondition)
			->limit(10)
			->order('p.time_stamp DESC')
			->execute('getSlaveRows');

		if (count($aRows))
		{
			$aResults = array();
			$aResults['total'] = $iCnt;
			$aResults['menu'] = Phpfox::getPhrase('video.videos');
			
			if ($bIsTagSearch == true)
			{
				$aResults['form'] = '<div><input type="button" value="' . Phpfox::getPhrase('video.view_more_videos') . '" class="search_button" onclick="window.location.href = \'' . Phpfox::getLib('url')->makeUrl('video', array('tag', $sQuery)) . '\';" /></div>';
			}
			else 
			{
				$aResults['form'] = '<form method="post" action="' . Phpfox::getLib('url')->makeUrl('video') . '"><div><input type="hidden" name="' . Phpfox::getTokenName() . '[security_token]" value="' . Phpfox::getService('log.session')->getToken() . '" /></div><div><input name="search[keyword]" value="' . Phpfox::getLib('parse.output')->clean($sQuery) . '" size="20" type="hidden" /></div><div><input type="submit" name="submit" value="' . Phpfox::getPhrase('video.view_more_videos') . '" class="search_button" /></div></form>';
			}			
			
			foreach ($aRows as $iKey => $aRow)
			{
				$aResults['results'][$iKey] = array(
					'title' => $aRow['title'],
					'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('video', $aRow['title_url'])),
					'image' => Phpfox::getLib('image.helper')->display(array(
							'server_id' => $aRow['image_server_id'],
							'title' => $aRow['title'],
							'path' => 'video.url_image',
							'file' => $aRow['image_path'],
							'suffix' => '_120',
							'max_width' => 75,
							'max_height' => 75
						)
					),
					'extra_info' => Phpfox::getPhrase('video.video_added_on_time_stamp_by_full_name', array(
							'link' => Phpfox::getLib('url')->makeUrl('video'),
							'time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aRow['time_stamp']),
							'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
							'full_name' => $this->preParse()->clean($aRow['full_name'])
						)
					)
				);
			}
			
			return $aResults;
		}
	}

	public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		return array(
			'phrase' => Phpfox::getPhrase('video.videos'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('video'))
				->where('view_id = 0 AND in_process = 0 AND time_stamp >= ' . $iToday)
				->execute('getSlaveField')
		);
	}
	
	public function updateCounterList()
	{
		$aList = array();		
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('video.update_video_view_count'),
			'id' => 'video-view-count'
		);	
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('video.update_tags_videos'),
			'id' => 'video-tag-update'
		);			
		
		$aList[] = array(
			'name' => Phpfox::getPhrase('video.update_user_video_count'),
			'id' => 'video-count'			
		);
		
		$aList[] = array(
			// Hardcoded phrase. We need to change it later.
			'name' => 'Update Video Thumbnails',
			'id' => 'video-thumbnails'			
		);		

		return $aList;
	}		
	
	public function updateCounter($iId, $iPage, $iPageLimit)
	{
		if ($iId == 'video-thumbnails')
		{		
			// get total videos
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('video'))
				->where("in_process = 0 AND image_path IS NOT NULL OR image_path != ''")
				->execute('getSlaveField');	
			
			// get the videos
			$aRows = $this->database()->select('m.video_id, m.is_stream, m.destination, m.server_id, m.image_path')
				->from(Phpfox::getT('video'), 'm')
				->where("m.in_process = 0 AND m.image_path IS NOT NULL OR m.image_path != ''")
				->limit($iPage, $iPageLimit, $iCnt)
				->execute('getSlaveRows');
			
			foreach ($aRows as $aRow)
			{		
				$sFilename = Phpfox::getParam('video.dir_image') . sprintf($aRow['image_path'], '_120');
				// Video streamed from sites like youtube
				if($aRow['is_stream'])
				{
					// get the video URL
					$sVideoURL = $this->database()->select('video_url')
						->from(Phpfox::getT('video_embed'))
						->where('video_id = ' . $aRow['video_id'])
						->execute('getSlaveField');
					
					if(!empty($sVideoURL))
					{
						$oGrab = Phpfox::getService('video.grab');
						// load the data to get the thumbnail
						$oGrab->get($sVideoURL);
						// get the thumbnail
						$oGrab->image($aRow['video_id'], true, $sFilename);
					}
				}
				// Video uploaded from a user computer
				else
				{
					// prepare locations
					$sImageLocation = Phpfox::getParam('video.dir_image') . $aRow['image_path'];
					$sVideoSource = Phpfox::getParam('video.dir') . $aRow['destination'];
					
					// If the video is html5 compliant
					if(Phpfox::getParam('video.upload_for_html5'))
					{
						// Change the extension to MP4.
						$sVideoSource = str_replace('flv', 'mp4', $sVideoSource);
					}
					
					// If the video was uploaded to the CDN and it cannot be found locally
					if (Phpfox::getParam('core.allow_cdn') && !empty($aVideo['server_id']))
					{
						// make it URL for FFMPEG to get the thumbnail
						$sVideoSource = '"' . Phpfox::getLib('cdn')->getUrl($sVideoSource, $aRow['server_id']) . '"';
					}
					
					// If the video is HTML5 compliant
					if(Phpfox::getParam('video.upload_for_html5'))
					{
						// there is no thumbnail
						if (!file_exists(sprintf($sImageLocation, '')))
						{
							// Create the thumbnail using FFMPEG at console level
							$sLastLineCode = exec(Phpfox::getParam('video.ffmpeg_path') . ' -ss 00:00:01 -i ' . $sVideoSource . ' -t 1 -s 480x300 ' . sprintf($sImageLocation, '') . ' 2>&1', $aOutput);
						}
					}
					// Normal FLV video
					else
					{
						// No thumbnail
						if (!file_exists(sprintf($sImageLocation, '')))
						{
							// Try this FFMPEG command first
							$sLastLineCode = exec(Phpfox::getParam('video.ffmpeg_path') . ' -y -i ' . $sVideoSource . ' -t 00:00:01 -r 1 -f mjpeg ' . sprintf($sImageLocation, '') . ' 2>&1', $aOutput);	
						}
						// Still no thumbnail
						if (!file_exists(sprintf($sImageLocation, '')))
						{
							// Trt this other FFMPEG command
							$sLastLineCode = exec(Phpfox::getParam('video.ffmpeg_path') . ' -y -i ' . $sVideoSource . ' -t 00:00:01 -r 1 -f image2 ' . sprintf($sImageLocation, '') . ' 2>&1', $aOutput);
						}
					}
					
					// Create the 120 pixel thumbnail that will be in use.
					Phpfox::getLib('image')->createThumbnail(sprintf($sImageLocation, ''), sprintf($sImageLocation, '_120'), 120, 120);
					Phpfox::getLib('image')->createThumbnail(sprintf($sImageLocation, ''), sprintf($sImageLocation, '_12090'), 120, 90, false);
					// http://www.phpfox.com/tracker/view/14924/
					Phpfox::getLib('image')->createThumbnail(sprintf($sImageLocation, ''), sprintf($sImageLocation, '_200'), 200, 200, false);
					// Remove the original image not resized
					Phpfox::getLib('file')->unlink(sprintf($sImageLocation, ''));    		    		
					
					// If still no thumbnail, and the ffmpeg_movie class exists
					if (class_exists('ffmpeg_movie') && !file_exists(sprintf($sImageLocation, '_120')))
					{
						// create new object
						$oFfmpegMovie = new ffmpeg_movie($sDestination);
						// If method "getFrame" exists for the ffmpeg_movie object
						if (is_object($oFfmpegMovie) && method_exists($oFfmpegMovie, 'getFrame'))
						{
							// Get the frame 24 => 1 second
							$oFrame = $oFfmpegMovie->getFrame(24);
							// If method "toGDImage" exists for the ffmpeg_movie object
							if (is_object($oFrame) && method_exists($oFrame, 'toGDImage'))
							{
								// Create a GD image
								$mImage = $oFrame->toGDImage();			
								if ($mImage)
								{
									// create the JPG thumbnail
									@imagejpeg($mImage, sprintf($sImageLocation, ''), 120);
									// remove the original image
									@imagedestroy($mImage);
								}
							}
						}
					}
				}
			}
			
			return $iCnt;
		}
				
		if ($iId == 'video-count')
		{
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('user'))
				->execute('getSlaveField');					

			$aRows = $this->database()->select('u.user_id')
				->from(Phpfox::getT('user'), 'u')
				->limit($iPage, $iPageLimit, $iCnt)
				->group('u.user_id')
				->execute('getSlaveRows');

			foreach ($aRows as $aRow)
			{
				$iTotalPhotos = $this->database()->select('COUNT(m.video_id)')
					->from(Phpfox::getT('video'), 'm')
					->where('m.in_process = 0 AND m.view_id = 0 AND m.item_id = 0 AND m.user_id = ' . $aRow['user_id'])
					->execute('getSlaveField');		

				$this->database()->update(Phpfox::getT('user_field'), array('total_video' => $iTotalPhotos), 'user_id = ' . $aRow['user_id']);			
			}	
			
			return $iCnt;
		}
		
		if ($iId == 'video-tag-update')
		{
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('tag'))
				->where('category_id = \'video\'')
				->execute('getSlaveField');			
				
			$aRows = $this->database()->select('m.tag_id, oc.video_id AS tag_item_id')
				->from(Phpfox::getT('tag'), 'm')
				->where('m.category_id = \'video\'')
				->leftJoin(Phpfox::getT('video'), 'oc', 'oc.video_id = m.item_id')
				->limit($iPage, $iPageLimit, $iCnt)
				->execute('getSlaveRows');			
			
			foreach ($aRows as $aRow)
			{
				if (empty($aRow['tag_item_id']))
				{
					$this->database()->delete(Phpfox::getT('tag'), 'tag_id = ' . $aRow['tag_id']);
				}
			}
			
			return $iCnt;
		}
		
		if (!file_exists(PHPFOX_DIR . 'include' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'server.sett.php'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('comment.your_old_v1_6_21_setting_file_must_exist', array('file' => 'include' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'server.sett.php')));
		}
		
		require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'server.sett.php');
		
		$sTable = (isset($_CONF['db']['prefix']) ? $_CONF['db']['prefix'] : '') . 'videos';
		
		if (!$this->database()->tableExists($sTable))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('comment.the_database_table_table_does_not_exist', array('table' => $sTable)));
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('video'))
			->execute('getSlaveField');			
			
		$aRows = $this->database()->select('m.video_id, m.total_view, oc.vid_total')
			->from(Phpfox::getT('video'), 'm')
			->join($sTable, 'oc', 'oc.vid_id = m.upgrade_item_id')
			->limit($iPage, $iPageLimit, $iCnt)
			->execute('getSlaveRows');
			
		foreach ($aRows as $aRow)
		{
			$this->database()->update(Phpfox::getT('video'), array('total_view' => ($aRow['total_view'] + $aRow['vid_total'])), 'video_id = ' . (int) $aRow['video_id']);
		}
			
		return $iCnt;
	}

	public function deleteGroup($iId)
	{
		$aRows = $this->database()->select('*')
			->from($this->_sTable)
			->where('module_id = \'group\' AND item_id = ' . (int) $iId)
			->execute('getRows');
			
		foreach ($aRows as $aRow)
		{
			Phpfox::getService('video.process')->delete($aRow['video_id'], $aRow);
		}
		
		return true;
	}		
	
	public function getFeedRedirectFeedLike($iId, $iChildId = 0)
	{
		return $this->getFeedRedirect($iChildId);
	}
	
	public function getNewsFeedFeedLike($aRow)
	{
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('video.a_href_user_link_full_name_a_likes_their_own_a_href_link_video_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => $aRow['link']
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('video.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_video_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'view_full_name' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name']),
					'view_user_link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name']),
					'link' => $aRow['link']			
				)
			);
		}
		
		$aRow['icon'] = 'misc/thumb_up.png';

		return $aRow;				
	}		

	public function getNotificationFeedNotifyLike($aRow)
	{		
		return array(
			'message' => Phpfox::getPhrase('video.a_href_user_link_full_name_a_likes_your_a_href_link_video_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('video', array('redirect' => $aRow['item_id']))
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('video', array('redirect' => $aRow['item_id']))			
		);				
	}	
	
	public function sendLikeEmail($iItemId)
	{
		return Phpfox::getPhrase('video.a_href_user_link_full_name_a_likes_your_a_href_link_video_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl('video', array('redirect' => $iItemId))
				)
			);
	}			
	
	public function getActivityPointField()
	{
		return array(
			Phpfox::getPhrase('video.videos') => 'activity_video'
		);
	}

	public function getRedirectComment($iId)
	{
		return $this->getFeedRedirect($iId);
	}	
	
	public function getSqlTitleField()
	{
		return array(
			array(
				'table' => 'video',
				'field' => 'title',
				'has_index' => 'title'
			),
			array(
				'table' => 'video_category',
				'field' => 'name'
			)
		);
	}	

	public function tabHasItems($iUser)
	{
		$iCount = $this->database()->select('COUNT(user_id)')
				->from($this->_sTable)
				->where('user_id = ' . (int)$iUser)
				->execute('getSlaveField');
		return $iCount > 0;
	}

	public function canShareItemOnFeed(){}

	public function getActivityFeedCustomChecks($aRow)
	{
		if ((defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'video.view_browse_videos'))
			|| (!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['custom_data_cache']['module_id'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aRow['custom_data_cache']['item_id'], 'video.view_browse_videos'))
		)
		{
			return false;
		}

		return $aRow;
	}

	public function getActivityFeed($aItem, $aCallback = null, $bIsChildItem = false)
	{				
		if (!Phpfox::getUserParam('video.can_access_videos'))
		{
			return false;
		}
		
		if ($aCallback === null)
		{
			$this->database()->select(Phpfox::getUserField('u', 'parent_') . ', ')->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = v.parent_user_id');
		}
		
		if ($bIsChildItem)
		{
			$this->database()->select(Phpfox::getUserField('u2') . ', ')->join(Phpfox::getT('user'), 'u2', 'u2.user_id = v.user_id');
		}

		if (Phpfox::getParam('video.vidly_support'))
		{
			$this->database()->select('vidly.vidly_url_id, ')->leftJoin(Phpfox::getT('vidly_url'), 'vidly', 'vidly.video_id = v.video_id');
		}
		
		if(Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'video\' AND l.item_id = v.video_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aRow = $this->database()->select('v.video_id, v.module_id, v.item_id, v.title, v.time_stamp, v.total_comment, v.total_like, v.image_path, v.image_server_id, vt.text_parsed')
			->from(Phpfox::getT('video'), 'v')
			->leftJoin(Phpfox::getT('video_text'), 'vt', 'vt.video_id = v.video_id')
			->where('v.video_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');		
		
		if (!isset($aRow['video_id']))
		{
			return false;
		}
		
		if ($bIsChildItem)
		{
			$aItem = $aRow;
		}		
		
		if ((defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'video.view_browse_videos'))
			|| (!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['module_id'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aRow['item_id'], 'video.view_browse_videos'))	
			)
		{
			return false;
		}			
		
		$aReturn = array(
			'feed_title' => $aRow['title'],
			// 'feed_info' => 'shared a video.',
			'feed_link' => Phpfox::permalink('video', $aRow['video_id'], $aRow['title']),
			'feed_content' => $aRow['text_parsed'],
			'total_comment' => $aRow['total_comment'],
			'feed_total_like' => $aRow['total_like'],
			'feed_is_liked' => (isset($aRow['is_liked']) ? $aRow['is_liked'] : false),
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'module/video.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],			
			'enable_like' => true,			
			'comment_type_id' => 'video',
			'like_type_id' => 'video',
			'custom_data_cache' => $aRow
		);
		
		if ($aRow['module_id'] == 'pages')
		{
			$aRow['parent_user_id'] = '';
			$aRow['parent_user_name'] = '';
		}		
		
		if (empty($aRow['parent_user_id']))
		{
			$aReturn['feed_info'] = Phpfox::getPhrase('feed.shared_a_video');
		}	
		
		if ($aCallback === null)
		{			
			if (!empty($aRow['parent_user_name']) && !defined('PHPFOX_IS_USER_PROFILE') && empty($_POST))
			{
				$aReturn['parent_user'] = Phpfox::getService('user')->getUserFields(true, $aRow, 'parent_');
			}
			
			if (!PHPFOX_IS_AJAX && defined('PHPFOX_IS_USER_PROFILE') && !empty($aRow['parent_user_name']) && $aRow['parent_user_id'] != Phpfox::getService('profile')->getProfileUserId())
			{
				$aReturn['feed_mini'] = true;
				$aReturn['feed_mini_content'] = Phpfox::getPhrase('feed.full_name_posted_a_href_link_a_video_a_on_a_href_profile_parent_full_name_a_s_a_href_profile_link_wall_a', array('full_name' => Phpfox::getService('user')->getFirstName($aItem['full_name']), 'link' => Phpfox::permalink('video', $aRow['video_id'], $aRow['title']), 'profile' => Phpfox::getLib('url')->makeUrl($aRow['parent_user_name']), 'parent_full_name' => $aRow['parent_full_name'], 'profile_link' => Phpfox::getLib('url')->makeUrl($aRow['parent_user_name'])));
				$aReturn['feed_title'] = '';
				unset($aReturn['feed_status'], $aReturn['feed_image'], $aReturn['feed_content']);
			}		
		}		
		
		if (!PHPFOX_IS_AJAX && defined('PHPFOX_IS_USER_PROFILE') && !empty($aRow['parent_user_name']) && $aRow['parent_user_id'] != Phpfox::getService('profile')->getProfileUserId())
		{
			
		}
		else
		{
			if (!empty($aRow['image_path']))
			{
				$sImage = Phpfox::getLib('image.helper')->display(array(
						'server_id' => $aRow['image_server_id'],
						'path' => 'video.url_image',
						'file' => $aRow['image_path'],
						'suffix' => '_120',
						'max_width' => 120,
						'max_height' => 120					
					)
				);

				$aReturn['feed_image'] = $sImage;
			}

			if (Phpfox::getParam('video.vidly_support') && !empty($aRow['vidly_url_id']))
			{
				$aReturn['feed_image'] = '<img src="https://vid.ly/' . $aRow['vidly_url_id'] . '/thumbnail1" alt="{$aVideo.title|clean}" style="max-width:120; max-height:90px;" />';
			}

			if (!Phpfox::isMobile())
			{
				$aReturn['feed_image_onclick'] = '$Core.box(\'video.play\', 700, \'id=' . $aRow['video_id'] . '&amp;feed_id=' . (isset($aItem['feed_id']) ? $aItem['feed_id'] : 0) . '&amp;popup=true\', \'GET\'); return false;';
			}
			else
			{
				$aReturn['no_target_blank'] = true;
			}
		}
		
		if ($bIsChildItem)
		{
			$aReturn = array_merge($aReturn, $aItem);
		}		
		
		(($sPlugin = Phpfox_Plugin::get('video.component_service_callback_getactivityfeed__1')) ? eval($sPlugin) : false);
		
		return $aReturn;
	}	
	
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('video_id, title, user_id')
			->from(Phpfox::getT('video'))
			->where('video_id = ' . (int) $iItemId)
			->execute('getSlaveRow');		
			
		if (!isset($aRow['video_id']))
		{
			return false;
		}
		
		$this->database()->updateCount('like', 'type_id = \'video\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'video', 'video_id = ' . (int) $iItemId);	
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::permalink('video', $aRow['video_id'], $aRow['title']);
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('video.full_name_liked_your_video_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aRow['title'])))
				->message(array('video.full_name_liked_your_video_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aRow['title'])))
				->notification('like.new_like')
				->send();
					
			Phpfox::getService('notification.process')->add('video_like', $aRow['video_id'], $aRow['user_id']);				
		}		
	}
	
	public function deleteLike($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'video\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'video', 'video_id = ' . (int) $iItemId);
	}	
	
	public function getNotificationLike($aNotification)
	{
		$aRow = $this->database()->select('v.video_id, v.title, v.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('video'), 'v')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = v.user_id')
			->where('v.video_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			
		if (!isset($aRow['video_id']))
		{
			return false;
		}			
			
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('video.user_name_liked_gender_own_video_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'title' =>Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1)));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('video.user_name_liked_your_video_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('video.user_name_liked_span_class_drop_data_user_full_name_s_span_video_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('video', $aRow['video_id'], $aRow['title']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);	
	}	
	
	public function getCommentNotification($aNotification)
	{
		$aRow = $this->database()->select('l.video_id, l.title, u.user_id, u.gender, u.user_name, u.full_name')	
			->from(Phpfox::getT('video'), 'l')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')
			->where('l.video_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'] && !isset($aNotification['extra_users']))
		{
			$sPhrase = Phpfox::getPhrase('video.user_name_commented_on_gender_video_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())
		{
			$sPhrase = Phpfox::getPhrase('video.user_name_commented_on_your_video_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('video.user_name_commented_on_span_class_drop_data_user_full_name_s_span_video_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('video', $aRow['video_id'], $aRow['title']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}	
	
	public function getNotificationApproved($aNotification)
	{
		$aRow = $this->database()->select('v.video_id, v.title, v.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('video'), 'v')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = v.user_id')
			->where('v.video_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');	

		if (!isset($aRow['video_id']))
		{
			return false;
		}
		
		$sPhrase = Phpfox::getPhrase('video.your_video_title_has_been_approved', array('title'=>Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('video', $aRow['video_id'], $aRow['title']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog'),
			'no_profile_image' => true
		);			
	}
	
	public function getAjaxProfileController()
	{
		return 'video.index';
	}
	
	public function getProfileMenu($aUser)
	{
		if (!Phpfox::getParam('profile.show_empty_tabs'))
		{		
			if (!isset($aUser['total_video']))
			{
				return false;
			}

			if (isset($aUser['total_video']) && (int) $aUser['total_video'] === 0)
			{
				return false;
			}
		}
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('profile.videos'),
			'url' => 'profile.video',
			'total' => (int) (isset($aUser['total_video']) ? $aUser['total_video'] : 0),
			'icon' => 'feed/video.png'
		);		
		
		return $aMenus;
	}
	
	public function getTotalItemCount($iUserId)
	{
		return array(
			'field' => 'total_video',
			'total' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('video'))->where('in_process = 0 AND view_id = 0 AND item_id = 0 AND user_id = ' . (int) $iUserId)->execute('getSlaveField')
		);	
	}	
	
	public function checkFeedShareLink()
	{
		if (Phpfox::isMobile())
		{
			return false;
		}		
		
		if (defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'video.share_videos'))
		{
			return false;
		}		
		
		if (!Phpfox::getParam('video.allow_video_uploading') || !Phpfox::getUserParam('video.can_upload_videos'))
		{
			return false;
		}
	}
	
	public function globalUnionSearch($sSearch)
	{
		$this->database()->select('item.video_id AS item_id, item.title AS item_title, item.time_stamp AS item_time_stamp, item.user_id AS item_user_id, \'video\' AS item_type_id, item.image_path AS item_photo, item.image_server_id AS item_photo_server')
			->from(Phpfox::getT('video'), 'item')
			->where('item.in_process = 0 AND item.view_id = 0 AND item.privacy = 0 AND ' . $this->database()->searchKeywords('item.title', $sSearch))
			->union();
	}
	
	public function getSearchInfo($aRow)
	{
		$aInfo = array();
		$aInfo['item_link'] = Phpfox::getLib('url')->permalink('video', $aRow['item_id'], $aRow['item_title']);
		$aInfo['item_name'] = Phpfox::getPhrase('search.video');
		
		$aInfo['item_display_photo'] = Phpfox::getLib('image.helper')->display(array(
				'server_id' => $aRow['item_photo_server'],
				'file' => $aRow['item_photo'],
				'path' => 'video.url_image',
				'suffix' => '_120',
				'max_width' => '120',
				'max_height' => '120'
				// 'return_url' => true
			)
		);		
		
		return $aInfo;
	}
	
	public function getSearchTitleInfo()
	{
		return array(
			'name' => Phpfox::getPhrase('search.videos')
		);
	}
	
	public function getPageSubMenu($aPage)
	{
		if (!Phpfox::getService('pages')->hasPerm($aPage['page_id'], 'video.share_videos'))
		{
			return null;
		}		
		
		return array(
			array(
				'phrase' => Phpfox::getPhrase('video.upload_share_a_video'),
				'url' => Phpfox::getLib('url')->makeUrl('video.add', array('module' => 'pages', 'item' => $aPage['page_id']))
			)
		);
	}	
	
	public function getPageMenu($aPage)
	{
		if (!Phpfox::getService('pages')->hasPerm($aPage['page_id'], 'video.view_browse_videos'))
		{
			return null;
		}
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('video.videos'),
			'url' => Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']) . 'video/',
			'icon' => 'feed/video.png',
			'landing' => 'video'
		);
		
		return $aMenus;
	}	
	
	public function getPagePerms()
	{
		$aPerms = array();
		
		$aPerms['video.share_videos'] = Phpfox::getPhrase('video.who_can_share_videos');
		$aPerms['video.view_browse_videos'] = Phpfox::getPhrase('video.who_can_view_browse_videos');
		
		return $aPerms;
	}
	
	public function canViewPageSection($iPage)
	{
		if (!Phpfox::getService('pages')->hasPerm($iPage, 'video.view_browse_videos'))
		{
			return false;
		}
		
		return true;
	}
	
	public function getCommentNotificationTag($aNotification)
	{
		$aRow = $this->database()->select('v.video_id, v.title, u.user_name, u.full_name')
					->from(Phpfox::getT('comment'), 'c')
					->join(Phpfox::getT('video'), 'v', 'v.video_id = c.item_id')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
					->where('c.comment_id = ' . (int)$aNotification['item_id'])
					->execute('getSlaveRow');
		
		
		$sPhrase = Phpfox::getPhrase('video.user_name_tagged_you_in_a_comment_in_a_video', array('user_name' => $aRow['full_name']));
		
		return array(
			'link' => Phpfox::getLib('url')->permalink('video', $aRow['video_id'], $aRow['title'])  . 'comment_'.$aNotification['item_id'],
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}
	
	public function getActions()
	{
		return array(
			'dislike' => array(
				'enabled' => true,
				'action_type_id' => 2, // 2 = dislike
				'phrase' => Phpfox::getPhrase('like.dislike'),
				'phrase_in_past_tense' => 'disliked',
				'item_type_id' => 'video', // used to differentiate between photo albums and photos for example.
				'table' => 'video',
				'item_phrase' => Phpfox::getPhrase('video.item_phrase'),
				'column_update' => 'total_dislike',
				'column_find' => 'video_id',
				'where_to_show' => array('video')
				)
		);
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
		if ($sPlugin = Phpfox_Plugin::get('video.service_callback__call'))
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
