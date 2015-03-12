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
 * @package 		Module_Like
 * @version 		$Id: process.class.php 7114 2014-02-17 19:38:37Z Raymond_Benc $
 */
class Like_Service_Process extends Phpfox_Service
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('like');
	}

	public function add($sType, $iItemId, $iUserId = null)
	{
		$bIsNotNull = false;
		if ($iUserId === null)
		{
			$iUserId = Phpfox::getUserId();
			$bIsNotNull = true;
		}
		if($sType == 'pages')
		{
			$bIsNotNull = false;
		}

		// check if iUserId can Like this item
		$aFeed = $this->database()->select('privacy, user_id')
			->from(Phpfox::getT('feed'))
			->where('item_id = ' . (int)$iItemId . ' AND type_id = "' . Phpfox::getLib('parse.input')->clean($sType) . '"')
			->execute('getSlaveRow');

		/* if (($sType != 'pages') && $sType != 'event' && empty($aFeed))
		{
			return Phpfox_Error::display('Item does not exist.');
		}
		*/
		if (!empty($aFeed) && isset($aFeed['privacy']) && !empty($aFeed['privacy']) && !empty($aFeed['user_id']) && $aFeed['user_id'] != $iUserId)
		{
			if ($aFeed['privacy'] == 1 && Phpfox::getService('friend')->isFriend($iUserId, $aFeed['user_id']) != true)
			{
				return Phpfox_Error::display('Not allowed to like this item.');
			}
			else if ($aFeed['privacy'] == 2 && Phpfox::getService('friend')->isFriendOfFriend($iUserId) != true)
			{
				return Phpfox_Error::display('Not allowed to like this item.');
			}
			else if ($aFeed['privacy'] == 3 && ($aFeed['user_id'] != Phpfox::getUserId()))
			{
				return Phpfox_Error::display('Not allowed to like this item.');
			}
			else if ($aFeed['privacy'] == 4 && ( $bCheck = Phpfox::getService('privacy')->check($sType, $iItemId, $aFeed['user_id'], $aFeed['privacy'], null, true)) != true)
			{
				return Phpfox_Error::display('Not allowed to like this item.');
			}
		}

		$iCheck = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('like'))
			->where('type_id = \'' . $this->database()->escape($sType) . '\' AND item_id = ' . (int) $iItemId . ' AND user_id = ' . $iUserId)
			->execute('getField');

		if ($iCheck)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('feed.you_have_already_liked_this_feed'));
		}

		$iCnt = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('like_cache'))
			->where('type_id = \'' . $this->database()->escape($sType) . '\' AND item_id = ' . (int) $iItemId . ' AND user_id = ' . (int) $iUserId)
			->execute('getSlaveField');

		$this->database()->insert($this->_sTable, array(
				'type_id' => $sType,
				'item_id' => (int) $iItemId,
				'user_id' => $iUserId,
				'time_stamp' => PHPFOX_TIME
			)
		);
		$iCnt = 0;
		if (!$iCnt)
		{
			$this->database()->insert(Phpfox::getT('like_cache'), array(
					'type_id' => $sType,
					'item_id' => (int) $iItemId,
					'user_id' => $iUserId
				)
			);
		}

		Phpfox::getService('feed.process')->clearCache($sType, $iItemId);

		if ($sPlugin = Phpfox_Plugin::get('like.service_process_add__1')){eval($sPlugin);}
		Phpfox::callback($sType . '.addLike', $iItemId, ($iCnt ? true : false), ($bIsNotNull ? null : $iUserId));

		return true;
	}

	public function delete($sType, $iItemId, $iUserId = 0)
	{
		if ($iUserId > 0 && $sType == 'pages')
		{
			if (!Phpfox::getService('pages')->isAdmin($iItemId))
			{
				return Phpfox_Error::set('Unable to remove this user.');
			}

			$this->database()->delete(Phpfox::getT('like'), 'type_id = \'' . $this->database()->escape($sType) . '\' AND item_id = ' . (int) $iItemId . ' AND user_id = ' . $iUserId);
		}
		else
		{
			$iUserId = 0;
			$this->database()->delete(Phpfox::getT('like'), 'type_id = \'' . $this->database()->escape($sType) . '\' AND item_id = ' . (int) $iItemId . ' AND user_id = ' . Phpfox::getUserId());
		}

		if ($sPlugin = Phpfox_Plugin::get('like.service_process_delete__1')){eval($sPlugin);}

		Phpfox::getService('feed.process')->clearCache($sType, $iItemId);

		Phpfox::callback($sType . '.deleteLike', $iItemId, $iUserId);

		return true;
	}

	public function doAction($sActionTypeId, $sItemTypeId, $iItemId, $sModuleId)
	{
		if (!Phpfox::isModule($sModuleId))
		{
			return false;
		}

		$oParse = Phpfox::getLib('parse.input');

		if ($sItemTypeId == 'feed_mini')
		{
			$sItemTypeId = 'comment';
		}

		if (Phpfox::getService('like')->didILike($sItemTypeId, $iItemId))
		{
			$this->delete($sItemTypeId, $iItemId, Phpfox::getUserId());
		}

		// Check if this user has already marked this item
		$iActionId = $this->database()->select('action_id')
			->from(Phpfox::getT('action'))
			->where('action_type_id = ' . (int)$sActionTypeId . ' AND item_type_id = "' . $oParse->clean($sItemTypeId) . '" AND item_id = ' . ((int)$iItemId) . ' AND user_id = ' . Phpfox::getUserId())
			->execute('getSlaveField');

		if ($iActionId > 0)
		{
			return true;
		}

		$sItemTypeId = str_replace('_', '-', $sItemTypeId);
		// Store the vote towards this action
		$iActionId = $this->database()->insert(Phpfox::getT('action'), array(
			'action_type_id' => (int)$sActionTypeId,
			'item_type_id' => $oParse->clean($sItemTypeId),
			'item_id' => (int)$iItemId,
			'user_id' => Phpfox::getUserId(),
			'time_stamp' => PHPFOX_TIME
		));

		// Update the total_<action> column
		$aCallbacks = Phpfox::callback($sModuleId . '.getActions');
		// find the callback for this

		foreach ($aCallbacks as $sActionName => $aAction)
		{
			if ($aAction['action_type_id'] != $sActionTypeId)
			{
				continue;
			}
			if (isset($aAction['item_type_id']) && $aAction['item_type_id'] != $sItemTypeId)
			{
				continue;
			}
			$aAction['item_id'] = $iItemId;
			$aRow = Phpfox::getService($sModuleId)->getInfoForAction($aAction);
			if (empty($aRow) || !isset($aRow['user_id']))
			{
				continue;
			}
			$this->database()->updateCounter($aAction['table'], $aAction['column_update'],$aAction['column_find'],  (int)$iItemId);

			// Add the notification
			/*
			if (Phpfox::isModule('notification'))
			{ 
				// get the owner of this item
				$iOwnerId = $this->database()
					->select('user_id')
					->from(Phpfox::getT($aAction['table']))
					->where($aAction['column_find'] .' = ' . (int)$iItemId)
					->execute('getSlaveField');
				
				if ($iOwnerId > 0)
				{
					Phpfox::getService('notification.process')->add('like_action', $iActionId, $iOwnerId);
				}
			}
			*/

			$aRow = Phpfox::getService($sModuleId)->getInfoForAction($aAction);
			if (empty($aRow) || !isset($aRow['user_id']))
			{
				//echo 'console.log("Line 157");';
				throw new Exception ('getInforForAction came empty for id '. $iItemId .' and module '. $sModuleId );
			}

			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('like.users_disliked_your_item_title', array(
					'users' => Phpfox::getUserBy('full_name'),
					'full_name' => Phpfox::getUserBy('full_name'),
					'link' => $aRow['link'],
					'title' => $aRow['title'],
					'item' => (isset($aAction['item_phrase']) ? $aAction['item_phrase'] : $sItemTypeId)
				)))
				->message(array('like.users_disliked_users_item_email', array(
					'users' =>  Phpfox::getUserBy('full_name'),
					'full_name' => Phpfox::getUserBy('full_name'),
					'link' => $aRow['link'],
					'title' => $aRow['title'],
					'item' => (isset($aAction['item_phrase']) ? $aAction['item_phrase'] : $sItemTypeId)
				)))
				->notification('like.new_like')
				->send();
			break ;
		}

		return true;
	}

	public function removeAction($sActionTypeId, $sItemTypeId, $iItemId, $sModuleId)
	{
		if (!isset($sActionTypeId)) return;
		if ($sItemTypeId == 'feed_mini')
		{
			$sItemTypeId = 'comment';
		}

		if (empty($sModuleId))
		{
			$sModuleId = $sActionTypeId;
		}
		$oParse = Phpfox::getLib('parse.input');
		// Check if this user has already marked this item
		$sWhere = 'action_type_id = ' . (int)$sActionTypeId . ' AND item_type_id = "' . $oParse->clean(str_replace('_', '-', $sItemTypeId)) . '" AND item_id = ' . ((int)$iItemId) . ' AND user_id = ' . Phpfox::getUserId();
		$this->database()->delete(Phpfox::getT('action'),
			$sWhere);

		// Update the total_<action> column
		$aCallbacks = Phpfox::callback($sModuleId . '.getActions');

		// find the callback for this 		
		foreach ($aCallbacks as $sActionName => $aAction)
		{
			if (isset($aAction['item_type_id']) && $aAction['item_type_id'] != $sItemTypeId)
			{
				continue;
			}
			if ($aAction['action_type_id'] == $sActionTypeId )
			{
				$this->database()->updateCounter($aAction['table'], $aAction['column_update'],$aAction['column_find'],  (int)$iItemId, true);
				break;
			}
		}
		return true;
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
		if ($sPlugin = Phpfox_Plugin::get('like.service_process__call'))
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