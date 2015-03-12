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
 * @package 		Phpfox_Service
 * @version 		$Id: callback.class.php 5016 2012-11-12 15:18:29Z Miguel_Espinoza $
 */
class Like_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	/**
	 * Action to take when user cancelled their account. Remove likes ("Joins" to pages too)
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{		
		// get all the items from this user		
		$aLikes = $this->database()->select('like_id, type_id, item_id')
			->from(Phpfox::getT('like'))
			->where('user_id = ' . $iUser)
			->execute('getSlaveRows');
				
		foreach ($aLikes as $aLike)
		{
			$sModule = $aLike['type_id'];
			$sExtra = '';
			if (strpos($sModule, '_') !== false)
			{
				$aParams = explode('_', $sModule);
				$sModule = $aParams[0];
				$sExtra = ucwords($aParams[1]);
			}
			if (Phpfox::hasCallback($sModule, 'deleteLike' . $sExtra))
			{
				Phpfox::callback($sModule.'.deleteLike' . $sExtra, $aLike['item_id']);
			}
		}
		
		$this->database()->delete(Phpfox::getT('like'), 'user_id = ' . $iUser);
		$this->database()->delete(Phpfox::getT('like_cache'), 'user_id = ' . $iUser);
		
		return true;
	}
	
	public function getNotificationSettings()
	{
		return array('like.new_like' => array(
				'phrase' => Phpfox::getPhrase('like.notification_for_likes'),
				'default' => 1
			)
		);
	}	
	
	/** This function catches all the "actions" (Dislike, and in the future maybe others)
	 * */
	public function getNotificationAction($aNotification)
	{
		//d($aNotification);die();
		// get the type of item that was marked ("blog", "photo"...)
		$aAction = $this->database()
			->select('*')
			->from(Phpfox::getT('action'))
			->where('action_id = ' . (int)$aNotification['item_id'])
			->limit(1)
			->execute('getSlaveRow');
		
		if (empty($aAction) || !isset($aAction['item_type_id']))
		{
			return false;
			throw new Exception ('No type for this action ('. print_r($aAction, true).')');
		}
		
		// Check if the module is a sub module
		if (preg_match('/(?P<module>[a-z]+)[_]?(?P<submodule>[a-z]{0,99})/i', $aAction['item_type_id'], $aMatch) < 1)
		{
			throw new Exception ('Malformed item_type');
		}
		
		// Call the module and get the title
		if (!Phpfox::isModule($aMatch['module']))
		{
			return false;
		}
		
		$aRow = Phpfox::getService($aMatch['module'])->getInfoForAction($aAction);
			
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			// {users} disliked {gender} own {item} "{title}"
			$sPhrase = Phpfox::getPhrase('like.users_disliked_gender_own_item_title', array(
				'users' => $sUsers, 
				'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 
				'title' => $sTitle,
				'item' => $aAction['item_type_id']
			));
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			// {users} liked your blog "{title}"
			$sPhrase = Phpfox::getPhrase('like.users_disliked_your_item_title', array(
				'users' => $sUsers, 
				'title' => $sTitle,
				'item' => $aAction['item_type_id']
			));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('like.users_disliked_users_item', array(
				'users' => $sUsers, 
				'row_full_name' => $aRow['full_name'], 
				'title' => $sTitle,
				'item' => $aAction['item_type_id']
			));
		}
			
		return array(
			'link' => $aRow['link'],
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
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
		if ($sPlugin = Phpfox_Plugin::get('like.service_callback__call'))
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