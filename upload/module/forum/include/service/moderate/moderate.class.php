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
 * @version 		$Id: moderate.class.php 1599 2010-05-28 04:31:26Z Raymond_Benc $
 */
class Forum_Service_Moderate_Moderate extends Phpfox_Service 
{
	private $_aAccess = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('forum_moderator');
		
		$sCacheId = $this->cache()->set('forum_permission');
		
		if (!($this->_aAccess = $this->cache()->get($sCacheId)))
		{
			$aForums = $this->database()->select('forum_id')
				->from(Phpfox::getT('forum'))
				->execute('getRows');
				
			foreach ($aForums as $aForum)
			{
				$aModerators = $this->database()->select('moderator_id, user_id')
					->from($this->_sTable)
					->where('forum_id = ' . $aForum['forum_id'])
					->execute('getRows');
					
				foreach ($aModerators as $aModerator)
				{
					$aModeratorAccess = $this->database()->select('var_name')
						->from(Phpfox::getT('forum_moderator_access'))
						->where('moderator_id = ' . $aModerator['moderator_id'])
						->execute('getRows');
						
					foreach ($aModeratorAccess as $aAccess)		
					{
						$this->_aAccess[$aForum['forum_id']][$aModerator['user_id']][$aAccess['var_name']] = true;
					}
				}
			}
			
			$this->cache()->save($sCacheId, $this->_aAccess);
		}
	}
	
	public function hasAccess($iForumId, $sVar)
	{
		return ((Phpfox::getUserId() && isset($this->_aAccess[$iForumId][Phpfox::getUserId()][$sVar])) ? true : false);
	}
	
	public function getUserPerm($iForumid, $iUserId)
	{
		$aUserPerm = $this->database()->select('fm.moderator_id')
			->from($this->_sTable, 'fm')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fm.user_id')
			->where('fm.forum_id = ' . $iForumid . ' AND fm.user_id = ' . $iUserId)
			->execute('getRow');
		
		if (!isset($aUserPerm['moderator_id']))
		{
			return false;
		}
		
		$aPerms = $this->database()->select('var_name')
			->from(Phpfox::getT('forum_moderator_access'))
			->where('moderator_id = ' . $aUserPerm['moderator_id'])
			->execute('getRows');		
		
		$sPerms = '{';
		foreach ($aPerms as $aPerm)
		{
			$sPerms .= '' . $aPerm['var_name'] . ': true,';
		}
		$sPerms = rtrim($sPerms, ',') . '}';
		
		return $sPerms;
	}
	
	public function getForForum($iForumId)
	{
		return $this->database()->select('fm.moderator_id, ' . Phpfox::getUserField())
			->from($this->_sTable, 'fm')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fm.user_id')
			->where('fm.forum_id = ' . $iForumId)
			->execute('getRows');		
	}
	
	public function getPerms()
	{
		$aPerms = array(
			'edit_post' => array(
				'phrase' => Phpfox::getPhrase('forum.can_edit_posts'),
				'value' => true
			),		
			'delete_post' => array(
				'phrase' => Phpfox::getPhrase('forum.can_delete_posts'),
				'value' => false
			),
			'post_announcement' => array(
				'phrase' => Phpfox::getPhrase('forum.can_post_announcements'),
				'value' => true
			),
			'post_sticky' => array(
				'phrase' => Phpfox::getPhrase('forum.can_stick_threads'),
				'value' => true
			),
			'move_thread' => array(
				'phrase' => Phpfox::getPhrase('forum.can_move_threads'),
				'value' => true
			),
			'copy_thread' => array(
				'phrase' => Phpfox::getPhrase('forum.can_copy_threads'),
				'value' => false
			),
			'close_thread' => array(
				'phrase' => Phpfox::getPhrase('forum.can_close_threads'),
				'value' => false
			),
			'merge_thread' => array(
				'phrase' => Phpfox::getPhrase('forum.can_merge_threads'),
				'value' => false
			),
			'can_reply' => array(
				'phrase' => Phpfox::getPhrase('forum.can_reply_to_threads'),
				'value' => true
			),
			'add_thread' => array(
				'phrase' => Phpfox::getPhrase('forum.can_post_a_new_thread'),
				'value' => true
			),
			'approve_thread' => array(
				'phrase' => Phpfox::getPhrase('forum.can_approve_threads'),
				'value' => false
			),
			'approve_post' => array(
				'phrase' => Phpfox::getPhrase('forum.can_approve_posts'),
				'value' => false
			)				
		);			
		
		if ($sPlugin = Phpfox_Plugin::get('forum.service_moderate_moderate_getperms'))
		{
			eval($sPlugin);
		}		
		
		return $aPerms;
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_moderate_moderate__call'))
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