<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Service
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Poke_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getNotification($aItem)
	{		
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aItem['user_name']),
			'message' => Phpfox::getPhrase('poke.full_name_has_poked_you', array('full_name' => $aItem['full_name']))
		);	
	}
	public function getNotificationLike($aNotification)
	{
		$aRow = $this->database()->select('b.poke_id, u.user_id, u.gender, u.user_name, u.full_name, u2.full_name AS to_full_name')	
			->from(Phpfox::getT('poke_data'), 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = b.to_user_id')
			->where('b.poke_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');		

		if (!isset($aRow['poke_id']))
		{			
			return false;
		}
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['to_full_name'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'] && !isset($aNotification['extra_users']))
		{
			$sPhrase = Phpfox::getPhrase('poke.users_liked_gender_poke_for_title', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => $sTitle));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('poke.users_liked_your_poke_for_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('poke.users_liked_span_class_drop_data_user_row_full_name_s_span_for_title', array('users' => $sUsers, 'row_full_name' => $aRow['full_name'], 'title' => $sTitle));
		}
		
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('poke-id' => $aRow['poke_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}	
	
	public function getNotificationComment($aNotification)
	{
		$aRow = $this->database()->select('b.poke_id, u.user_id, u.gender, u.user_name, u.full_name, u2.full_name AS to_full_name')	
			->from(Phpfox::getT('poke_data'), 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = b.to_user_id')
			->where('b.poke_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');		

		if (!isset($aRow['poke_id']))
		{			
			return false;
		}
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['to_full_name'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'] && !isset($aNotification['extra_users']))
		{
			$sPhrase = Phpfox::getPhrase('poke.users_commented_on_gender_poke_for_title', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => $sTitle));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('poke.users_commented_on_your_poke_for_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('poke.users_commented_on_span_class_drop_data_user_row_full_name_s_span_for_title', array('users' => $sUsers, 'row_full_name' => $aRow['full_name'], 'title' => $sTitle));
		}
		
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('poke-id' => $aRow['poke_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);		
	}	

	public function getActivityFeed($aItem)
	{
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'poke\' AND l.item_id = uc.poke_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aRow = $this->database()->select('uc.*, uc.total_like, uc.total_comment, u.user_name, u.full_name')
				->from(Phpfox::getT('poke_data'), 'uc')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = uc.to_user_id')
				->where('uc.poke_id = ' . (int) $aItem['item_id'])
				->execute('getSlaveRow');
		
		if (empty($aRow))
		{
			return false;		
		}
		
		$sLink = Phpfox::getLib('url')->makeUrl($aItem['user_name'], array('poke-id' => $aRow['poke_id']));
		$aReturn = array(
			'feed_link' => $sLink,
			'feed_title' => '',
			'feed_info' => Phpfox::getPhrase('poke.poked_a_href_link_full_name_a', array('link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']), 'full_name' => $aRow['full_name'])),
			'total_comment' => $aRow['total_comment'],			
			'feed_total_like' => $aRow['total_like'],
			'feed_is_liked' => isset($aRow['is_liked']) ? $aRow['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/user.png', 'return_url' => true)),
			'time_stamp' => $aItem['time_stamp'],
			'enable_like' => true,
			'comment_type_id' => 'poke',
			'like_type_id' => 'poke'
		);
		(($sPlugin = Phpfox_Plugin::get('poke.component_service_callback_getactivityfeed__1')) ? eval($sPlugin) : false);
		return $aReturn;
		
	}

	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('pd.poke_id, pd.user_id, u.user_name, u.user_name AS to_user_name, u2.full_name')
			->from(Phpfox::getT('poke_data'), 'pd')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = pd.user_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = pd.to_user_id')
			->where('pd.poke_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['poke_id']))
		{
			return false;
		}
		
		$this->database()->updateCount('like', 'type_id = \'poke\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'poke_data', 'poke_id = ' . (int) $iItemId);	
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('poke-id' => $aRow['poke_id']));
			$sLink2 = Phpfox::getLib('url')->makeUrl($aRow['to_user_name']);
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('poke.full_name_liked_one_of_your_pokes', array('full_name' => Phpfox::getUserBy('full_name'))))
				->message(array('poke.full_name_liked_when_you_poked_row_full_name', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'row_full_name' => $aRow['full_name'])))
				->notification('like.new_like')
				->send();
					
			Phpfox::getService('notification.process')->add('poke_like', $aRow['poke_id'], $aRow['user_id']);				
		}
	}
	
	public function deleteLike($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'poke\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'poke_data', 'poke_id = ' . (int) $iItemId);	
	}		
	
	public function getAjaxCommentVar()
	{
		return null;
	}
	
	public function getCommentItem($iId)
	{		
		$aRow = $this->database()->select('poke_id AS comment_item_id, f.user_id AS comment_user_id')
				->join(Phpfox::getT('feed'), 'f', 'f.item_id = cf.poke_id')
				->from(Phpfox::getT('poke_data'), 'cf')
				->where('cf.poke_id = ' . (int) $iId)
				->execute('getSlaveRow');

		$aRow['privacy_comment'] = '0';
		$aRow['comment_view_id'] = '0';

		if (!Phpfox::getService('comment')->canPostComment($aRow['comment_user_id'], $aRow['privacy_comment']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('poke.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));

			unset($aRow['comment_item_id']);
		}

		return $aRow;
	}
	
	public function addComment($aVals, $iUserId = null, $sUserName = null)
	{
		$aRow = $this->database()->select('cf.poke_id, u.full_name, u.gender, u.user_id, u.user_name')
				->from(Phpfox::getT('poke_data'), 'cf')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = cf.user_id')
				->where('cf.poke_id = ' . (int) $aVals['item_id'])
				->execute('getSlaveRow');
		
		if (!isset($aRow['poke_id']))
		{
			return false;
		}

		// Update the post counter if its not a comment put under moderation or if the person posting the comment is the owner of the item.
		if (empty($aVals['parent_id']))
		{
			$iCount = $this->database()->select('total_comment')
					->from(Phpfox::getT('poke_data'))
					->where('poke_id = ' . (int) $aVals['item_id'])
					->execute('getSlaveField');

			$this->database()->update(Phpfox::getT('poke_data'), array('total_comment' => ($iCount + 1)), 'poke_id = ' . (int)$aRow['poke_id']);
		}

		// Send the user an email
		$sLink = Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('poke-id' => $aRow['poke_id']));

		Phpfox::getService('comment.process')->notify(array(
					'user_id' => $aRow['user_id'],
					'item_id' => $aRow['poke_id'],
					'owner_subject' => Phpfox::getPhrase('poke.full_name_commented_on_your_poke', array('full_name' => Phpfox::getUserBy('full_name'))),
					'owner_message' => Phpfox::getPhrase('poke.full_name_commented_on_your_poke_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink)),
					'owner_notification' => 'comment.add_new_comment',
					'notify_id' => 'poke_comment',
					'mass_id' => 'poke_comment',
					'mass_subject' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('poke.full_name_commented_on_gender_poke', array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1))) : Phpfox::getPhrase('poke.full_name_commented_on_row_full_name_s_poke', array('full_name' => Phpfox::getUserBy('full_name'), 'row_full_name' => $aRow['full_name']))),
					'mass_message' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('poke.full_name_commented_on_gender_poke_to_see_the_comment_thread', array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'link' => $sLink)) : Phpfox::getPhrase('poke.full_name_commented_on_row_full_name_s_poke_message', array('full_name' => Phpfox::getUserBy('full_name'), 'row_full_name' => $aRow['full_name'], 'link' => $sLink)))
				)
		);
	}
	
	public function getProfileSettings()
	{
		return array(
			'poke.can_send_poke' => array(
				'phrase' => Phpfox::getPhrase('poke.can_send_pokes'),
				'anyone' => false
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
		if ($sPlugin = Phpfox_Plugin::get('poke.service_callback__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>
