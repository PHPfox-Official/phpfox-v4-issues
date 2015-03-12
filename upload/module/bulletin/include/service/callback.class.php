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
 * @package  		Module_Bulletin
 * @version 		$Id: callback.class.php 1802 2010-09-08 12:52:12Z Miguel_Espinoza $
 */
class Bulletin_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('bulletin');
	}
	
	public function getAttachmentField()
	{
		return array(
			'bulletin',
			'bulletin_id'
		);
	}
	
	public function getFeedRedirect($iId, $iChild = 0)
	{
		$aBulletin = $this->database()->select('b.bulletin_id, u.user_id, u.user_name')
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.bulletin_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aBulletin['bulletin_id']))
		{
			return false;
		}
			
		if ($iChild > 0)
		{
			return Phpfox::getLib('url')->makeUrl('bulletin.view', array('id' => $aBulletin['bulletin_id'], 'comment' => $iChild, '#comment-view'));
		}			
		return Phpfox::getLib('url')->makeUrl('bulletin.view', array('id' => $aBulletin['bulletin_id']));
	}	
	
	public function getCommentItemName()
	{
		return 'bulletin';
	}	
	
	public function getRedirectComment($iId)
	{
		return $this->getFeedRedirect($iId);
	}	
	
	public function getReportRedirect($iId)
	{
		return $this->getFeedRedirect($iId);
	}
	
	public function getAjaxCommentVar()
	{
		return 'bulletin.can_post_comment_on_bulletin';
	}	
	
	public function getCommentNewsFeed($aRow)
	{		
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		

		$aReplacements = array(
			'item_full_name' => $aRow['owner_full_name'],
			'item_user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['owner_user_id'])), 
			'title_link' => $aRow['link'], 
			'item_user_name' => $aRow['viewer_full_name'], 
			'item_user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['owner_user_id']))
		);
			
		if ($aRow['owner_user_id'] == $aRow['item_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('bulletin.user_added_a_new_comment_on_their_own_bulletin', $aReplacements);
		}
		else 
		{
			if ($aRow['item_user_id'] == Phpfox::getUserBy('user_id'))
			{
				$aRow['text'] = Phpfox::getPhrase('bulletin.item_full_name_added_a_new_comment_on_your_bulletin', $aReplacements);
			}
			else 
			{
				$aRow['text'] = Phpfox::getPhrase('bulletin.item_full_name_added_a_new_comment_on_item_user', $aReplacements);
			}
		}
			
		$aRow['text'] .= Phpfox::getService('feed')->quote($aRow['content']);
		
		return $aRow;
	}		
	
	public function addComment($aVals, $iUserId = null, $sUserName = null)
	{		
		$aBulletin = $this->database()->select('b.bulletin_id, u.full_name, u.user_id, u.user_name')
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.bulletin_id = ' . (int) $aVals['item_id'])
			->execute('getSlaveRow');
			
		// Update the post counter if its not a comment put under moderation or if the person posting the comment is the owner of the item.
		if ($aVals['comment_view_id'] != 2 || ($aVals['comment_view_id'] == 2 && $aVals['comment_user_id'] == $iUserId))
		{		
			Phpfox::getService('bulletin.process')->updateCounter($aVals['item_id'], 'total_comment');
			
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('comment_bulletin', $aVals['item_id'], $aVals['text_parsed'], $iUserId, $aBulletin['user_id'], $aVals['comment_id']) : null);
			
			// Send the user an email			
			$sLink = Phpfox::getLib('url')->makeUrl('bulletin.view', array('id' => $aBulletin['bulletin_id']));
			Phpfox::getLib('mail')->to($aBulletin['user_id'])
				->subject(array('bulletin.full_name_left_you_a_comment_on_site_title', array('full_name' => $sUserName, 'site_title' => Phpfox::getParam('core.site_title'))))
				->message(array('bulletin.full_name_left_you_a_comment_on_site_title_message', array('full_name' => $sUserName, 'site_title' => Phpfox::getParam('core.site_title'), 'link' => $sLink)))
				->notification('comment.add_new_comment')
				->send();
		}
		
		if ($aVals['comment_view_id'] == 2 && Phpfox::isModule('request') && !Phpfox::getUserParam('comment.approve_all_comments'))
		{
			$sLink = Phpfox::getLib('url')->makeUrl('request', '#comment');
			Phpfox::getLib('mail')->to($aBulletin['user_id'])
				->subject(array('bulletin.full_name_left_you_a_comment_on_site_title', array('full_name' => $sUserName, 'site_title' => Phpfox::getParam('core.site_title'))))
				->message(array('bulletin.full_name_left_you_a_comment_on_site_title_message_approve', array('full_name' => $sUserName, 'site_title' => Phpfox::getParam('core.site_title'), 'link' => $sLink)))
				->notification('comment.approve_new_comment')
				->send();
		}
	}	
	
	public function updateCommentText($aVals, $sText)
	{
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('comment_bulletin', $aVals['item_id'], $sText, $aVals['comment_id']) : null);
	}		

	public function getItemName($iId, $sName)
	{
		return '<a href="' . Phpfox::getLib('url')->makeUrl('comment.view', array('id' => $iId)) . '">' . Phpfox::getPhrase('bulletin.on_name_s_bulletin', array('name' => $sName)) . '</a>';
	}	
	
	public function deleteComment($iId)
	{
		Phpfox::getService('bulletin.process')->updateCounter($iId, 'total_comment', true);	
	}		
	
	public function processCommentModeration($sAction, $iId)
	{
		// Is this comment approved?
		if ($sAction == 'approve')
		{
			// Update the blog count
			Phpfox::getService('bulletin.process')->updateCounter($iId, 'total_comment');		
			
			// Get the blogs details so we can add it to our news feed
			$aBulletin = $this->database()->select('b.bulletin_id, b.user_id, ct.text_parsed, c.user_id AS comment_user_id, c.comment_id')			
				->from($this->_sTable, 'b')								
				->join(Phpfox::getT('comment'), 'c', 'c.type_id = \'bulletin\' AND c.item_id = b.bulletin_id')
				->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')				
				->where('b.bulletin_id = ' . (int) $iId)
				->execute('getSlaveRow');
				
			// Add to news feed			
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('comment_bulletin', $aBulletin['bulletin_id'], $aBulletin['text_parsed'], $aBulletin['comment_user_id'], $aBulletin['user_id'], $aBulletin['comment_id']) : null);
			
			// Send the user an email
			$sLink = Phpfox::getLib('url')->makeUrl('bulletin.view', array('id' => $aBulletin['bulletin_id']));
			
			Phpfox::getLib('mail')->to($aBulletin['comment_user_id'])
				->subject(array('bulletin.full_name_approved_your_comment_on_site_title', array('full_name' => Phpfox::getUserBy('full_name'), 'site_title' => Phpfox::getParam('core.site_title'))))
				->message(array('bulletin.full_name_approved_your_comment_on_site_title_message', array('full_name' => Phpfox::getUserBy('full_name'), 'site_title' => Phpfox::getParam('core.site_title'), 'link' => $sLink)))
				->notification('comment.approve_new_comment')
				->send();		
		}
	}	
	
	public function getCommentItem($iId)
	{
		return $this->database()->select('bulletin_id AS comment_item_id, allow_comment AS comment_view_id, user_id AS comment_user_id')
			->from($this->_sTable)
			->where('bulletin_id = ' . (int) $iId)
			->execute('getSlaveRow');
	}

	public function getNewsFeed($aRow)
	{
		if ($sPlugin = Phpfox_Plugin::get('bulletin.service_callback_getnewsfeed_start')){eval($sPlugin);}
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');				
		
		$aRow['text'] = Phpfox::getPhrase('bulletin.owner_full_name_added_a_new_bulletin', array(
				'owner_full_name' => $aRow['owner_full_name'], 
				'title' => Phpfox::getService('feed')->shortenTitle($aRow['content']), 
				'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])), 
				'title_link' => $aRow['link']
			)
		);
		
		$aRow['icon'] = 'module/bulletin.png';
		$aRow['enable_like'] = true;
		
		return $aRow;
	}	
	
	public function getBlockDetailsDisplay()
	{
		return array(
			'title' => Phpfox::getPhrase('bulletin.bulletins')
		);
	}
	
	public function hideBlockDisplay()
	{
		return array(
			'table' => 'user_dashboard'
		);				
	}

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		$aBulletins = $this->database()
			->select('bulletin_id')
			->from($this->_sTable)
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');

		foreach ($aBulletins as $aBulletin)
		{
			Phpfox::getService('bulletin.process')->delete($aBulletin['bulletin_id'], $iUser);
		}
	}
	
	public function reparserList()
	{
		return array(
			'name' => Phpfox::getPhrase('bulletin.bulletin_text'),
			'table' => 'bulletin_text',
			'original' => 'text',
			'parsed' => 'text_parsed',
			'item_field' => 'bulletin_id'
		);
	}

	public function getDashboardActivity()
	{
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
		
		return array(
			Phpfox::getPhrase('bulletin.bulletin_activity') => $aUser['activity_bulletin']
		);
	}

	public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		return array(
			'phrase' => Phpfox::getPhrase('bulletin.bulletins'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('bulletin'))
				->where('time_stamp >= ' . $iToday)
				->execute('getSlaveField')
		);
	}		
	
	public function getFeedRedirectFeedLike($iId, $iChildId = 0)
	{
		return $this->getFeedRedirect($iChildId);
	}
	
	public function getNewsFeedFeedLike($aRow)
	{
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('bulletin.a_href_user_link_full_name_a_likes_their_own_a_href_link_bulletin_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => $aRow['link']
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('bulletin.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_bulletin_a', array(
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
			'message' => Phpfox::getPhrase('bulletin.a_href_user_link_full_name_a_likes_your_a_href_link_bulletin_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('bulletin', array('view', 'id' => $aRow['item_id']))
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('bulletin', array('view', 'id' => $aRow['item_id']))
		);				
	}	
	
	public function sendLikeEmail($iItemId)
	{
		return Phpfox::getPhrase('bulletin.a_href_user_link_full_name_a_likes_your_a_href_link_bulletin_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl('bulletin', array('view', 'id' => $iItemId))
				)
			);
	}

	public function getActivityPointField()
	{
		return array(
			Phpfox::getPhrase('bulletin.bulletin_activity') => 'activity_bulletin'
		);
	}	
	
	public function pendingApproval()
	{
		return array(
			'phrase' => Phpfox::getPhrase('bulletin.bulletins'),
			'value' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('bulletin'))->where('view_id = 1')->execute('getSlaveField'),
			'link' => Phpfox::getLib('url')->makeUrl('bulletin', array('view' => 'approval'))
		);
	}	
	
	public function getSqlTitleField()
	{
		return array(
			'table' => 'bulletin',
			'field' => 'title'
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
		if ($sPlugin = Phpfox_Plugin::get('bulletin.service_callback__call'))
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