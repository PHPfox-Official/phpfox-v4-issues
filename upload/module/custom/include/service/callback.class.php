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
 * @package 		Phpfox_Service
 * @version 		$Id: callback.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Custom_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getCommentNotificationRelation_Tag()
	{
		
	}
	
	public function getCommentNotificationRelation($aNotification)
	{
		$aRow = $this->database()->select('c.*, u.user_name')
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = c.owner_user_id')
			->where('c.comment_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
		/*
		d($aRow);
		exit;
		 * 
		 *
		// return false;
		
		$aRow = $this->database()->select('b.blog_id, b.title, b.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('blog'), 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.blog_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
		
		if (!isset($aRow['blog_id']))
		{
			return false;
		}
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'] && !isset($aNotification['extra_users']))
		{
			$sPhrase = Phpfox::getPhrase('blog.users_commented_on_gender_blog_title', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => $sTitle));
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('blog.users_commented_on_your_blog_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('blog.users_commented_on_span_class_drop_data_user_row_full_name', array('users' => $sUsers, 'row_full_name' => $aRow['full_name'], 'title' => $sTitle));
		}*/
		if (empty($aRow['author']))
		{
			return false;
		}
		
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('feed' => $aRow['author'])),
			'message' => $aRow['user_name'] .' tagged you in a comment in a relationship update',
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}	
	
	public function exportModule($sProduct, $sModule)
	{
		return Phpfox::getService('custom')->export($sProduct, $sModule);
	}
	
	public function reparserList()
	{
		$aFields = $this->database()->select('*')
			->from(Phpfox::getT('custom_field'))
			->where('var_type IN(\'textarea\', \'text\')')
			->execute('getRows');
		
		$aCallback = array();
		foreach ($aFields as $aField)
		{
			if (!Phpfox::isModule($aField['module_id']))
			{
				continue;
			}
			
			$aCallback[] = array(
				'name' => Phpfox::getPhrase($aField['phrase_var_name']) . ' (' . Phpfox::getPhrase('admincp.custom_field') . ')',
				'table' => array('user_custom_value', 'user_custom'),
				'original' => 'cf_' . $aField['field_name'],
				'parsed' => 'cf_' . $aField['field_name'],
				'item_field' => 'user_id'
			);
		}	
		
		return $aCallback;
	}
	
	public function getRedirectCommentRelation($iId)
	{
		$aRow = $this->database()->select('crd.relation_data_id, u.user_name, f.feed_id')
					->from(Phpfox::getT('feed'), 'f')
					->join(Phpfox::getT('custom_relation_data'), 'crd', 'crd.user_id = f.user_id')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = f.user_id')
					->where('f.item_id = ' . $iId . " AND f.type_id = 'custom_relation'")
					->execute('getSlaveRow');

		return Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('feed' => $aRow['feed_id']));
	}
	
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		
		$aRow = $this->database()->select('field_id, phrase_var_name')
			->from(Phpfox::getT('custom_field'))
			->where('field_id = ' . (int) $iItemId)
			->execute('getSlaveRow');		
		
		if (!isset($aRow['field_id']))
		{
			return false;
		}
		
		$aFeed = $this->database()->select('f.*, u.user_name')
				->from(Phpfox::getT('feed'), 'f')
				->where('feed_id = ' . (int)Phpfox::getLib('request')->get('parent_id'))
				->join(Phpfox::getT('user'), 'u', 'u.user_id = f.user_id')
				->execute('getSlaveRow');
		
		/* Check if the field exists for the total_like*/
		$iExists = $this->database()->select('field_id')
				->from(Phpfox::getT('user_custom_data'))
				->where('field_id = ' . $iItemId . ' AND user_id = ' . $aFeed['user_id'])
				->execute('getSlaveField');
		if ($iExists > 0)
		{
			$this->database()->updateCount('like', 'type_id = \'custom\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'user_custom_data', 'field_id = ' . (int) $iItemId . ' AND user_id = ' . $aFeed['user_id']);	
		}
		else
		{
			$this->database()->insert(Phpfox::getT('user_custom_data'), array(
				'user_id' => $aFeed['user_id'],
				'field_id' => $iItemId,
				'total_like' => 1));
		}
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::getLib('url')->makeUrl($aFeed['user_name'], array('feed-id' => $aFeed['feed_id']));

			Phpfox::getLib('mail')->to($aFeed['user_id'])
					->subject(array('custom.full_name_liked_your_change_on_phrase_var_name', array('full_name' => Phpfox::getUserBy('full_name'), 'phrase_var_name' => Phpfox::getPhrase($aRow['phrase_var_name']))))
					->message(array('custom.full_name_liked_your_change_on_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'phrase_var_name' => Phpfox::getPhrase($aRow['phrase_var_name']))))
					->notification('like.new_like')
					->send();

			Phpfox::getService('notification.process')->add('custom_like', $aFeed['feed_id'], $aFeed['user_id']);
		}
	}

	public function deleteLike($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'custom\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'user_custom_data', 'field_id = ' . (int) $iItemId . ' AND user_id = ' . Phpfox::getUserId());
		
	}

	public function getNotificationLike($aNotification)
	{
		$aRow = $this->database()->select('b.field_id, b.phrase_var_name, owner.user_name, owner.user_id, owner.gender, owner.full_name')
				->from(Phpfox::getT('custom_field'), 'b')
			->join(Phpfox::getT('user'),'owner', 'owner.user_id = ' . (int)$aNotification['item_user_id'])
				->where('b.field_id = ' . (int) $aNotification['item_id'])
				->execute('getSlaveRow');
		
		if (!isset($aRow['user_id']))
		{
			return false;
		}		
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sTitle = Phpfox::getLib('parse.output')->shorten(Phpfox::getPhrase($aRow['phrase_var_name']), Phpfox::getParam('notification.total_notification_title_length'), '...');

		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('custom.users_liked_gender_own_profile_update_title', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => $sTitle));
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())
		{
			$sPhrase = Phpfox::getPhrase('custom.users_liked_your_profile_update_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else
		{
			$sPhrase = Phpfox::getPhrase('custom.users_liked_span_class_drop_data_user_row_full_name', array('users' => $sUsers, 'row_full_name' => $aRow['full_name'], 'title' => $sTitle));
		}

		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}

	/**
	 * This function passes the params to output an entry in the feed for when
	 * a user has changed the status of their relationship
	 * @param type $aFeed 
	 */
	public function getActivityFeedRelation($aFeed)
	{
		if ($aFeed['type_id'] == 'custom_relation' && $aFeed['user_id'] != Phpfox::getUserId())
		{
		    //return false;
		}
		if (Phpfox::getParam('user.enable_relationship_status') != true)
		{
			return false;
		}
		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'custom_relation\' AND l.item_id = crd.relation_data_id AND l.user_id = ' . Phpfox::getUserId());
		}		
		
		/* New status */
		$aRelation = $this->database()->select('crd.total_like, crd.total_comment, u.gender, cr.relation_id, 
				crd.status_id, crd.relation_data_id, cr.phrase_var_name, 
				u.user_id, u.full_name, u.user_name, 
				u2.user_id AS with_user_id, 
				u2.full_name as with_full_name, 
				u2.user_name as with_user_name')
				->from(Phpfox::getT('custom_relation_data'), 'crd')
				->join(Phpfox::getT('custom_relation'), 'cr', 'cr.relation_id = crd.relation_id')
				->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = crd.user_id')
				->leftJoin(Phpfox::getT('user'), 'u2', 'u2.user_id = crd.with_user_id')
				->where('crd.relation_data_id = ' . (int) $aFeed['item_id'])
				->execute('getSlaveRow');
		
		if (!isset($aRelation['relation_data_id']) || empty($aRelation['relation_data_id']))
		{
			return false;
		}	
		$aRelation['relation_with'] = ($aRelation['user_id'] == $aFeed['user_id']) ? 0 : 1;
		/* previous status */
		$sPrevious = $this->database()->select('cr.phrase_var_name')
				->from(Phpfox::getT('custom_relation'), 'cr')
				->join(Phpfox::getT('custom_relation_data'), 'crd', 'crd.relation_id = cr.relation_id')
				->where('crd.user_id = ' . $aFeed['user_id'] . ' AND crd.relation_data_id < ' . $aRelation['relation_data_id'] . '')
				->order('crd.relation_data_id DESC')
				->limit(1)
				->execute('getSlaveField');
		
		/* If this status is blank and the user did not have any other status before we 
		 * should not display this message as it happened when updating other custom field
		 */
		if ($sPrevious == '')
		{
			$iPrevious = $this->database()->select('relation_id')
					->from(Phpfox::getT('custom_relation_data'))
					->where('relation_data_id = ' . (int)$aFeed['item_id'])
					->execute('getSlaveField');
			if ($iPrevious == 1)
			{
				return false;
			}
		}
		
		/* Replacements for the phrase */
		$aReplace = array(
			'full_name' => $aRelation['full_name'],
			'user_name' => $aRelation['user_name'],
			'their' => Phpfox::getService('user')->gender($aRelation['gender'], 1),
			'sOldStatus' => Phpfox::getPhrase($sPrevious),
			'sNewStatus' => Phpfox::getPhrase($aRelation['phrase_var_name'])
		);
		
		/* we only need the previous state if the current phrase has {previous_status} in its text */
		//d($aRelation);die();
		$sPhrase = Phpfox::getService('custom')->getRelationshipPhrase($aRelation, $aFeed, $aReplace, $sPrevious);
		/* For now lets just send the user to the friend page */
		$sLink = Phpfox::getLib('url')->makeUrl($aRelation['user_name']) . 'feed_' . $aFeed['feed_id'] . '/';

		$aReturn = array(
			'feed_link' => $sLink,
			'feed_title' => '',
			'feed_info' => $sPhrase,
			'total_comment' => $aRelation['total_comment'],
			'feed_total_like' => $aRelation['total_like'],
			'feed_is_liked' => isset($aRelation['is_liked']) ? $aRelation['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/heart.png', 'return_url' => true)),
			'time_stamp' => $aFeed['time_stamp'],
			'enable_like' => true,
			'like_type_id' => 'custom_relation',
			'comment_type_id' => 'custom_relation'
		);
		//die();
		return $aReturn;
	}

	public function addCommentRelation($aVals, $iUserId = null, $sUserName = null)
	{
		if (Phpfox::getParam('user.enable_relationship_status') != true)
		{
			return Phpfox_Error::trigger('Relations are disabled');
		}
		$aRow = $this->database()->select('cr.phrase_var_name, cf.relation_data_id, f.feed_id, u.full_name, u.gender, u.user_id, u.user_name')
				->from(Phpfox::getT('custom_relation_data'), 'cf')
				->join(Phpfox::getT('custom_relation'), 'cr', 'cr.relation_id = cf.relation_id')
				->join(Phpfox::getT('feed'), 'f', 'f.feed_id = ' . $aVals['is_via_feed'])
				->join(Phpfox::getT('user'), 'u', 'u.user_id = f.user_id')
				->where('cf.relation_data_id = ' . (int) $aVals['item_id'])
				->execute('getSlaveRow');
		
		if (!isset($aRow['relation_data_id']))
		{
			return Phpfox_Error::trigger('Invalid callback on comment.');
		}

		// Update the post counter if its not a comment put under moderation or if the person posting the comment is the owner of the item.
		//$this->database()->updateCounter('user_custom_data', 'total_comment', 'field_id', $aRow['field_id'] . ' AND user_id = ' . $aRow['user_id']);				
		if (empty($aVals['parent_id']))
		{
			$iCount = $this->database()->select('total_comment')
					->from(Phpfox::getT('custom_relation_data'))
					->where('relation_data_id = ' . (int) $aRow['relation_data_id'])
					->execute('getSlaveField');

			$this->database()->update(Phpfox::getT('custom_relation_data'), array('total_comment' => ($iCount + 1)), 'relation_data_id = ' . (int) $aRow['relation_data_id']);
		}

		if (Phpfox::isModule('feed'))
		{
			Phpfox::getService('feed.process')->add('comment_relation', $aRow['relation_data_id']);
		}
		// Send the user an email
		$sLink = Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('feed-id' => $aRow['feed_id']));
		$sName = Phpfox::getUserBy('full_name');
		$sTitle = $this->preParse()->clean(Phpfox::getPhrase($aRow['phrase_var_name']), 100);
		$sContent = $this->preParse()->clean(Phpfox::getPhrase($aRow['phrase_var_name']), 100);
		$sGender = Phpfox::getService('user')->gender($aRow['gender'], 1);
		
		Phpfox::getService('comment.process')->notify(array(
			'user_id' => $aRow['user_id'],
			'item_id' => $aRow['relation_data_id'],
			'owner_subject' => Phpfox::getPhrase('custom.name_commented_on_your_profile_update_title', array('name' => $sName, 'title' => $sTitle)),
			'owner_message' => Phpfox::getPhrase('custom.name_commented_on_your_profile_update_a_href_link_content_a', array('name' => $sName, 'link' => $sLink, 'content' => $sContent)),
			'owner_notification' => 'comment.add_new_comment',
			'notify_id' => 'custom_comment_relation',
			'mass_id' => 'custom',
			'mass_subject' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('custom.name_commented_on_gender_profile_update', array('name' => $sName, 'gender' => $sGender)) : Phpfox::getPhrase('custom.name_commented_on_full_name_s_profile_update', array('name' => $sName, 'full_name' => $aRow['full_name']))),
			'mass_message' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('custom.user_commented_on_gender_profile_update_message', array('name' => $sName, 'gender' => $sGender, 'link' => $sLink, 'content' => $sContent)) : Phpfox::getPhrase('custom.name_commented_on_full_name_s_profile_update_message', array('name' => $sName, 'full_name' => $aRow['full_name'], 'link' => $sLink, 'content' => $sContent)))
				)
		);
	}

	public function addLikeRelation($iItemId, $bDoNotSendEmail = false)
	{
		if (Phpfox::getParam('user.enable_relationship_status') != true)
		{
			return false;
		}
		$aRow = $this->database()->select('crd.relation_data_id, crd.total_like, crd.user_id, cr.phrase_var_name')
				->from(Phpfox::getT('custom_relation_data'), 'crd')
				->join(Phpfox::getT('custom_relation'), 'cr', 'cr.relation_id = crd.relation_id')
				->where('crd.relation_data_id = ' . (int) $iItemId)
				->execute('getSlaveRow');
		
		if (!isset($aRow['relation_data_id']))
		{
			return false;
		}
		
		$aRow['title'] = Phpfox::getPhrase($aRow['phrase_var_name']);

		$this->database()->updateCount('like', 'type_id = \'custom_relation\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'custom_relation_data', 'relation_data_id = ' . (int) $iItemId);

		// if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::getLib('url')->makeUrl('friend'); //Phpfox::permalink('friend');

			Phpfox::getLib('mail')->to($aRow['user_id'])
					->subject(array('custom.full_name_liked_your_change_in_relationship_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aRow['title'])))
					->message(array('custom.full_name_liked_your_change_in_relationship_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aRow['title'])))
					->notification('like.new_like')
					->send();

			Phpfox::getService('notification.process')->add('custom_relation_like', $aRow['relation_data_id'], $aRow['user_id']);
		}
	}

	public function deleteLikeRelation($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'custom_relation\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'custom_relation_data', 'relation_data_id = ' . (int) $iItemId);
	}

	
	/**
	 * The return of this function eventually goes to addComment
	 * @param type $iId
	 * @return string 
	 */
	public function getCommentItemRelation($iId)
	{		
		$aRow = $this->database()->select('relation_data_id AS comment_item_id, f.user_id AS comment_user_id')
				->join(Phpfox::getT('feed'), 'f', 'f.item_id = cf.relation_data_id AND f.type_id = "custom_relation"')
				->from(Phpfox::getT('custom_relation_data'), 'cf')
				->where('cf.relation_data_id = ' . (int) $iId)
				->execute('getSlaveRow');

		$aRow['privacy_comment'] = '0';
		$aRow['comment_view_id'] = '0';

		if (!Phpfox::getService('comment')->canPostComment($aRow['comment_user_id'], $aRow['privacy_comment']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('custom.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));

			unset($aRow['comment_item_id']);
		}

		return $aRow;
	}
	
	public function getNotificationComment_Relation($aNotification)
	{
		if (Phpfox::getParam('user.enable_relationship_status') != true)
		{
			return false;
		}
		$aRow = $this->database()->select('l.relation_data_id, l.relation_data_id, cr.phrase_var_name, u.user_id, u.gender, u.user_name, u.full_name')	
			->from(Phpfox::getT('custom_relation_data'), 'l')
			->join(Phpfox::getT('custom_relation'), 'cr', 'cr.relation_id = l.relation_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')
			->where('l.relation_data_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
		
		$aRow['name'] = Phpfox::getPhrase($aRow['phrase_var_name']);
		
		if (!isset($aRow['relation_data_id']))
		{
			return false;
		}
		/* get the feed id */
		$iFeed = $this->database()->select('feed_id')
				->from(Phpfox::getT('feed'))
				->where('type_id = "custom_relation" AND item_id = ' . $aRow['relation_data_id'])
				->execute('getSlaveField');
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sGender = Phpfox::getService('user')->gender($aRow['gender'], 1);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['name'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'] && !isset($aNotification['extra_users']))
		{
			$sPhrase = Phpfox::getPhrase('custom.users_commented_on_gender_album_title', array('users' => $sUsers, 'gender' => $sGender, 'title' => $sTitle));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())
		{
			$sPhrase = Phpfox::getPhrase('custom.users_commented_on_your_relationship_status_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('custom.users_commented_on_span_class_drop_data_user_full_name_s_span_relationship_status_title', array('users' => $sUsers, 'full_name' =>  $aRow['full_name'], 'title' => $sTitle));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink($aRow['user_name'], 'feed_'. $iFeed),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}
	
	public function getNotificationRelation_Like($aNotification)
	{
		$aRow = $this->database()->select('ms.relation_data_id, cr.phrase_var_name, ms.user_id, u.gender, u.full_name, u.user_name')	
			->from(Phpfox::getT('custom_relation_data'), 'ms')
			->join(Phpfox::getT('custom_relation'), 'cr', 'cr.relation_id = ms.relation_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ms.user_id')
			->where('ms.relation_data_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');		
		
		if (!isset($aRow['relation_data_id']))
		{
			return false;
		}			
		
		$aRow['name'] = Phpfox::getPhrase($aRow['phrase_var_name']);
		
		/* get the feed id */
		$iFeed = $this->database()->select('feed_id')
				->from(Phpfox::getT('feed'))
				->where('type_id = "custom_relation" AND item_id = ' . $aRow['relation_data_id'])
				->execute('getSlaveField');
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sGender = Phpfox::getService('user')->gender($aRow['gender'], 1);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['name'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('custom.users_liked_gender_own_relationship_status_title', array('users' => $sUsers, 'gender' => $sGender, 'title' => $sTitle));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('custom.users_liked_your_relationship_status_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('custom.users_liked_span_class_drop_data_user_full_name_s_span_relationship_status_title', array('users' => $sUsers, 'full_name' => $aRow['full_name'], 'title' => $sTitle));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink($aRow['user_name'], 'feed_' . $iFeed),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);	
	}
	
	
	public function getActivityFeed($aItem)
	{
		$sLink = Phpfox::getLib('url')->makeUrl($aItem['user_name']);
		$aReturn = array(
			'feed_link' => $sLink,
			'feed_title' => '',
			'feed_info' => Phpfox::getPhrase('feed.updated_gender_profile_information', array('gender' => Phpfox::getService('user')->gender($aItem['gender'], 1))),
			//'total_comment' => $aRow['total_comment'],
			//'feed_total_like' => $aRow['total_like'],
			//'feed_is_liked' => isset($aRow['is_liked']) ? $aRow['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/page_edit.png', 'return_url' => true)),
			'time_stamp' => $aItem['time_stamp'],
			'enable_like' => false,
			//'comment_type_id' => 'custom',
			//'like_type_id' => 'custom'
		);
		(($sPlugin = Phpfox_Plugin::get('custom.component_service_callback_getactivityfeed__1')) ? eval($sPlugin) : false);
		return $aReturn;
		
	}
	public function getAjaxCommentVar()
	{
		return null;
	}

	public function getAjaxCommentVarRelation()
	{
		return null;
	}
	public function updateCounterList()
	{
		$aList = array();		
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('custom.import_custom_fields'),
			'id' => 'import-custom-fields'			
		);			

		return $aList;
	}
	public function updateCounter($iId, $iPage = null, $iPageLimit = null)
	{
	    if ($iId == 'import-custom-fields')
	    {		
		// get all the custom fields
		$aFields = $this->database()->select('*')
			->from(Phpfox::getT('custom_field'))
			->execute('getSlaveRows');
		$sWhere = '';
		foreach ($aFields as $aField)
		{
		    $sWhere .= '(component = "cf_' . $aField['field_name'] .'" AND module_id="' . $aField['module_id'] .'") OR ';
		}
		$sWhere = rtrim($sWhere, ' OR ') . '';
		// find all components so we dont duplicate them
		$aExistComponents = $this->database()->select('component, module_id, product_id')
			->from(Phpfox::getT('component'))
			->where($sWhere)
			->execute('getSlaveRows');
		// find all blocks 
		$aExistBlocks = $this->database()->select('component, module_id, product_id')
			->from(Phpfox::getT('block'))
			->where($sWhere)
			->execute('getSlaveRows');
		
		$aExistsBlock = array();
		$aExistsComponent = array();
		$aToAddBlock = array();
		$aToAddComponent = array();
		// loop so we know which ones we dont need
		foreach ($aFields as $aField)
		{
		   $iExistsComponent = $this->database()->select('component_id')
			   ->from(Phpfox::getT('component'))
			   ->where('component = "cf_' . $aField['field_name'] . '"' 
				   . ' AND product_id = "' . $aField['product_id'] .'"'
				   . ' AND module_id = "' . $aField['module_id'] .'"')
			    ->execute('getSlaveField');
		   if ($iExistsComponent < 1)
		   {
		       $this->database()->insert(Phpfox::getT('component'),array(
			    'component' => 'cf_' . $aField['field_name'],
			    'm_connection' => null,
			    'module_id' =>  $aField['module_id'],
			    'product_id' => $aField['product_id'],
			    'is_controller' => '0',
			    'is_block' => '1',
			    'is_active' => '1'
			));
		   }
			 
		   $iExistsBlock = $this->database()->select('block_id')
			   ->from(Phpfox::getT('block'))
			   ->where('component = "cf_' . $aField['field_name'] . '"' 
				   . ' AND product_id = "' . $aField['product_id'] .'"'
				   . ' AND module_id = "custom"')
			    ->execute('getSlaveField');
		   
		    if ($iExistsBlock < 1)
		    {
			
			$this->database()->insert(Phpfox::getT('block'), array(
			    'title' => Phpfox::getPhrase($aField['phrase_var_name']),
			    'type_id' => '0',
			    'm_connection' => 'profile.info',
			    'module_id' => 'custom',//$aField['module_id'],
			    'product_id' => $aField['product_id'],
			    'component' => 'cf_' . $aField['field_name'],
			    'location' => '2',
			    'is_active' => '1',
			    'ordering' => '10',
			    'disallow_access' => null,
			    'can_move' => '1',
			    'version_id' => '1'
			));
		    }
		}
		
		$this->cache()->remove();
	    }
	}	
	
	/**
	 * The return of this function eventually goes to addComment
	 * @param type $iId
	 * @return string 
	 */
	public function getCommentItem($iId)
	{
		
		$aRow = $this->database()->select('field_id AS comment_item_id, f.user_id AS comment_user_id')
				->join(Phpfox::getT('feed'), 'f', 'f.item_id = cf.field_id')
				->from(Phpfox::getT('custom_field'), 'cf')
				->where('cf.field_id = ' . (int) $iId)
				->execute('getSlaveRow');

		$aRow['privacy_comment'] = '0';
		$aRow['comment_view_id'] = '0';

		if (!Phpfox::getService('comment')->canPostComment($aRow['comment_user_id'], $aRow['privacy_comment']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('custom.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));

			unset($aRow['comment_item_id']);
		}

		return $aRow;
	}

	
	public function addComment($aVals, $iUserId = null, $sUserName = null)
	{
		$aRow = $this->database()->select('cf.field_id,f.feed_id, cf.phrase_var_name, u.full_name, u.gender, u.user_id, u.user_name')
				->from(Phpfox::getT('custom_field'), 'cf')
				->join(Phpfox::getT('feed'), 'f', 'f.item_id = cf.field_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = f.user_id')
				->where('cf.field_id = ' . (int) $aVals['item_id'])
				->execute('getSlaveRow');

		if (!isset($aRow['field_id']))
		{
			return Phpfox_Error::trigger(Phpfox::getPhrase('custom.invalid_callback_on_comment'));
		}

		// Update the post counter if its not a comment put under moderation or if the person posting the comment is the owner of the item.
		//$this->database()->updateCounter('user_custom_data', 'total_comment', 'field_id', $aRow['field_id'] . ' AND user_id = ' . $aRow['user_id']);				
		if (empty($aVals['parent_id']))
		{
			$iCount = $this->database()->select('total_comment')
					->from(Phpfox::getT('user_custom_data'))
					->where('field_id = ' . (int) $aVals['item_id'] . ' AND user_id = ' . $aRow['user_id'])
					->execute('getSlaveField');

			$this->database()->update(Phpfox::getT('user_custom_data'), 
					array('total_comment' => ($iCount + 1)), 'field_id = ' . (int)$aRow['field_id'] . ' AND user_id = ' . $aRow['user_id']);
		}

		if (Phpfox::isModule('feed'))
		{
			Phpfox::getService('feed.process')->add('comment_custom', $aVals['item_id']);
		}
		// Send the user an email
		$sLink = Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('feed-id' => $aRow['feed_id']));//Phpfox::getLib('url')->permalink('custom', $aRow['field_id'], Phpfox::getPhrase($aRow['phrase_var_name']));

		Phpfox::getService('comment.process')->notify(array(
			'user_id' => $aRow['user_id'],
			'item_id' => $aRow['field_id'],
			'owner_subject' => Phpfox::getPhrase('custom.full_name_commented_on_your_profile_update_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $this->preParse()->clean(Phpfox::getPhrase($aRow['phrase_var_name']), 100))),
			'owner_message' => Phpfox::getPhrase('custom.full_name_commented_on_your_profile_update_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => Phpfox::getPhrase($aRow['phrase_var_name']))),
			'owner_notification' => 'comment.add_new_comment',
			'notify_id' => 'comment_custom',
			'mass_id' => 'custom',
			'mass_subject' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('custom.full_name_commented_on_gender_profile_update', array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1))) : Phpfox::getPhrase('custom.full_name_commented_on_row_full_name_s_video', array('full_name' => Phpfox::getUserBy('full_name'), 'row_full_name' => $aRow['full_name']))),
			'mass_message' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('custom.full_name_commented_on_gender_profile_update_message', array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'link' => $sLink, 'title' => Phpfox::getPhrase($aRow['phrase_var_name']))) : Phpfox::getPhrase('custom.full_name_commented_on_row_full_name_s_profile_update', array('full_name' => Phpfox::getUserBy('full_name'), 'row_full_name' => $aRow['full_name'], 'link' => $sLink, 'title' => Phpfox::getPhrase($aRow['phrase_var_name']))))
				)
		);
	}

	public function deleteComment($iId)
	{
		//$this->database()->updateCounter('video', 'total_comment', 'video_id', $iId, true);
	}
	
	public function deleteCommentRelation($iId)
	{
		$this->database()->updateCounter('custom_relation_data', 'total_comment', 'relation_data_id', $iId, true);
	}

	public function getCommentNotification($aNotification)
	{
		$aRow = $this->database()->select('cf.field_id, cf.phrase_var_name, f.feed_id, u.user_id, u.gender, u.user_name, u.full_name')
				->from(Phpfox::getT('custom_field'), 'cf')
				->join(Phpfox::getT('feed'), 'f', 'f.item_id = cf.field_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = f.user_id')
				->where('cf.field_id = ' . (int) $aNotification['item_id'])
				->execute('getSlaveRow');

		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sGender = Phpfox::getService('user')->gender($aRow['gender'], 1);
		$sTitle = Phpfox::getLib('parse.output')->shorten(Phpfox::getPhrase($aRow['phrase_var_name']), Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'] && !isset($aNotification['extra_users']))
		{
			$sPhrase = Phpfox::getPhrase('custom.users_commented_on_gender_profile_update_title', array('users' => $sUsers, 'gender' => $sGender, 'title' =>$sTitle));
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())
		{
			$sPhrase = Phpfox::getPhrase('custom.users_commented_on_your_profile_update_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else
		{
			$sPhrase = Phpfox::getPhrase('custom.users_commented_on_span_class_drop_data_user_row_full_name_s_span_profile_update_title', array('users' => $sUsers, 'row_full_name' => $aRow['full_name'], 'title' => $sTitle));
		}

		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('feed-id' => $aRow['feed_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}
	
	/*
		This function checks user group settings when they are changed from the AdminCP. 
		Called from the function user.group.setting.process->update
		@return bool true if valid.
	*/
	public function isValidUserGroupSetting($aVal)
	{
		switch ($aVal['variable'])
		{
			case 'has_special_custom_fields':				
				$aGroup= Phpfox::getService('user.group')->getGroup($aVal['user_group_id']);
				$sTableName = Phpfox::getService('user.group.setting')->getGroupParam($aGroup['user_group_id'], 'custom.custom_table_name');
				if (!empty($sTableName) && 
						(
							$this->database()->tableExists($sTableName) ||
							$this->database()->tableExists(Phpfox::getT($sTableName))
						)
						&&
						(
							$this->database()->tableExists($sTableName .'_value') ||
							$this->database()->tableExists(Phpfox::getT($sTableName .'_value'))
						)
					)
				{
					return true;
				}
				$sTableName = Phpfox::getParam(array('db','prefix')) . 'user_group_custom_' . str_replace(' ', '_', strtolower($aGroup['title']));
								
				if ($this->database()->tableExists($sTableName) == false)
				{	
					$this->database()->createTable($sTableName, array(
						array(
							'name' => 'user_id',
							'type' => 'int(10)',
							'extra' => 'unsigned not null',
							'primary_key' => true
						)						
					));					
				}
				
				if ($this->database()->tableExists($sTableName .'_value') == false)
				{
					$this->database()->createTable($sTableName .'_value', array(
						array(
							'name' => 'user_id',
							'type' => 'int(10)',
							'extra' => 'unsigned not null',
							'primary_key' => true
						)						
					));
				}	
				$iSettingId = $this->database()
						->select('setting_id')
						->from(Phpfox::getT('user_group_setting'))
						->where('name = "custom_table_name" AND module_id = "custom"')
						->execute('getSlaveField');
						
				$aUpdate = array(
					'bDontClearCache' => true,
					'order' => array($iSettingId => '0'),
					'value_actual' => array($iSettingId => $sTableName),
					'param' => array($iSettingId => 'custom.custom_table_name'));
				
				Phpfox::getService('user.group.setting.process')->update($aVal['user_group_id'],$aUpdate);
				
				switch ($aVal['user_group_id'])
				{
					case 2:
						$this->database()->update(Phpfox::getT('user_group_setting'), array('is_hidden' => 1, 'default_user' => $sTableName), 'setting_id = ' . $iSettingId);
						break;
					case 1:
						$this->database()->update(Phpfox::getT('user_group_setting'), array('is_hidden' => 1, 'default_admin' => $sTableName), 'setting_id = ' . $iSettingId);
						break;
						
				}
				
				return true;				
			default:
				return true;
		}
	}

	public function getActionsRelation()
	{
		return $this->getActions();
	}
	
	public function getActions()
	{
		return array(
			'dislike' => array(
				'enabled' => true,
				'action_type_id' => 2, // sort of redundant given the key 
				'phrase' => Phpfox::getPhrase('like.dislike'),
				'phrase_in_past_tense' => 'disliked',
				'item_type_id' => 'custom_relation', // used internally to differentiate between photo albums and photos for example.
				'item_phrase' => Phpfox::getPhrase('profile.relationship_status'), // used to display to the user what kind of item is this
				'table' => 'custom_relation_data',
				'column_update' => 'total_dislike',
				'column_find' => 'relation_data_id',
				'where_to_show' => array('blog', '')
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
		if ($sPlugin = Phpfox_Plugin::get('custom.service_callback__call'))
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
