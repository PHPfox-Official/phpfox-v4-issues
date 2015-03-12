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
 * @version 		$Id: process.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class Forum_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('forum');
	}
	
	public function updateCounter($iId, $sCounter, $bMinus = false, $iTotal = 1)
	{
		// Prevents http://www.phpfox.com/tracker/view/8968/
		if ($bMinus && $iTotal == 0)
		{
			$iTotal = 1;
		}
		
		$this->database()->update($this->_sTable, array(
				$sCounter => array('= ' . $sCounter . ' ' . ($bMinus ? '-' : '+'), $iTotal)
			), 'forum_id = ' . (int) $iId
		);
	}
	
	public function updateTrack($iForumId)
	{
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		foreach (Phpfox::getService('forum')->id($iForumId)->getParents() as $iId)
		{
			$this->database()->delete(Phpfox::getT('forum_track'), 'forum_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
			$this->database()->insert(Phpfox::getT('forum_track'), array(
					'forum_id' => $iId,
					'user_id' => Phpfox::getUserId(),
					'time_stamp' => PHPFOX_TIME
				)
			);
		}
	}
	
	public function updateOrder($aForums)
	{
		foreach ($aForums as $iForumId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => (int) $iOrder), 'forum_id = ' . (int) $iForumId);
		}
		
		$this->cache()->remove('forum');
		
		return true;
	}
	
	public function add($aVals)
	{
		$oParseInput = Phpfox::getLib('parse.input');
		
		$iOrder = $this->database()->select('ordering')
			->from($this->_sTable)
			->order('forum_id DESC')
			->execute('getField');
		
		$aInsert = array(
			'parent_id' => (empty($aVals['parent_id']) ? 0 : (int) $aVals['parent_id']),
			'is_category' => (isset($aVals['is_category']) ? (int) $aVals['is_category'] : 0),
			'is_closed' => (isset($aVals['is_closed']) ? (int) $aVals['is_closed'] : 0),
			'name' => $oParseInput->clean($aVals['name'], 255),
			'name_url' => $oParseInput->prepareTitle('forum', $aVals['name'], 'name_url', null, $this->_sTable),
			'description' => (empty($aVals['description']) ? null : $oParseInput->clean($aVals['description'])),
			'ordering' => ($iOrder + 1)
		);
		
		$iId = $this->database()->insert($this->_sTable, $aInsert);
		
		$this->cache()->remove('forum');
		// Plugin call
                if ($sPlugin = Phpfox_Plugin::get('forum.service_process_add__end')){eval($sPlugin);}
                
		return $iId;
	}
	
	public function update($iId, $aVals)
	{
		$oParseInput = Phpfox::getLib('parse.input');
		
		$aUpdate = array(
			'parent_id' => (empty($aVals['parent_id']) ? 0 : (int) $aVals['parent_id']),
			'is_category' => (isset($aVals['is_category']) ? (int) $aVals['is_category'] : 0),
			'is_closed' => (isset($aVals['is_closed']) ? (int) $aVals['is_closed'] : 0),
			'name' => $oParseInput->clean($aVals['name'], 255),			
			'description' => (empty($aVals['description']) ? null : $oParseInput->clean($aVals['description']))
		);
		
		$this->database()->update($this->_sTable, $aUpdate, 'forum_id = ' . (int) $iId);
		
		$this->cache()->remove('forum');		
		
		return true;
	}
	
	public function delete($iId)
	{
		$aForum = $this->database()->select('forum_id')
			->from($this->_sTable)
			->where('forum_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aForum['forum_id']))
		{
			return false;
		}
		
		$mChilds = Phpfox::getService('forum')->id($aForum['forum_id'])->getChildren();
		$mChilds[] = $aForum['forum_id'];
		
		if (is_array($mChilds))
		{
			foreach ($mChilds as $iChild)
			{
				$aThreads = $this->database()->select('thread_id')
					->from(Phpfox::getT('forum_thread'))
					->where('forum_id = ' . $iChild)
					->execute('getRows');					
					
				foreach ($aThreads as $aThread)
				{
					$this->database()->delete(Phpfox::getT('forum_thread'), 'thread_id = ' . $aThread['thread_id']);
					$this->database()->delete(Phpfox::getT('forum_thread_track'), 'thread_id = ' . $aThread['thread_id']);
					$this->database()->delete(Phpfox::getT('forum_announcement'), 'thread_id = ' . $aThread['thread_id']);
					
					$aPosts = $this->database()->select('post_id')
						->from(Phpfox::getT('forum_post'))
						->where('thread_id = ' . $aThread['thread_id'])
						->execute('getRows');
						
					foreach ($aPosts as $aPost)
					{
						$this->database()->delete(Phpfox::getT('forum_post'), 'post_id = ' . $aPost['post_id']);
						$this->database()->delete(Phpfox::getT('forum_post_text'), 'post_id = ' . $aPost['post_id']);
					}
				}
				
				$aMods = $this->database()->select('moderator_id')
					->from(Phpfox::getT('forum_moderator'))
					->where('forum_id = ' . $iChild)
					->execute('getRows');
					
				foreach ($aMods as $aMod)
				{
					$this->database()->delete(Phpfox::getT('forum_moderator'), 'moderator_id = ' . $aMod['moderator_id']);					
					$this->database()->delete(Phpfox::getT('forum_moderator_access'), 'moderator_id = ' . $aMod['moderator_id']);
				}
				
				$this->database()->delete(Phpfox::getT('forum_track'), 'forum_id = ' . $iChild);
				$this->database()->delete($this->_sTable, 'forum_id = ' . $iChild);
			}
		}		

		$this->cache()->remove('forum', 'substr');		
		
		return true;
	}
	
	public function updateLastPost($iForumId, $iThreadId = null)
	{
		// get the last post from this forum
		$aLastPost = $this->database()->select('ft.user_id as thread_user_id, fp.thread_id, fp.time_stamp, fp.update_time,fp.post_id, fp.user_id')
				->from(Phpfox::getT('forum_thread'), 'ft')
				->join(Phpfox::getT('forum_post'), 'fp', 'fp.thread_id = ft.thread_id')
				->where('ft.forum_id = ' . (int)$iForumId)
				->order('fp.time_stamp DESC')
				->limit(1)
				->execute('getSlaveRow');
		
		
		// get the parent forum
		$iParentForum = $this->database()->select('parent_id')
			->from(Phpfox::getT('forum'))
			->where('forum_id = ' . (int)$iForumId)
			->execute('getSlaveField');
		
		// update this forum with the last reply
		$aUpdate = array(
			'thread_id' => 0,
			'post_id' => 0,
			'last_user_id' => 0
		);
		
		if (isset($aLastPost['post_id']) && $aLastPost['post_id'] > 0)
		{
			$aUpdate = array(
				'thread_id' => $aLastPost['thread_id'],
				'post_id' => $aLastPost['post_id'],
				'last_user_id' => !empty($aLastPost['last_user_id']) ? $aLastPost['last_user_id'] : $aLastPost['thread_user_id']
			);
		}
		
		
		
		$this->database()->update(Phpfox::getT('forum'), $aUpdate, 'forum_id = ' . (int)$iForumId);
		
		
		if($iThreadId !== null)
		{
			// by now the last post should already have been deleted
			$aLastPost = $this->database()->select('thread_id, post_id, user_id, time_stamp, update_time')
				->from(Phpfox::getT('forum_post'))
				->where('thread_id = ' .(int)$iThreadId)
				->order('time_stamp DESC')
				->execute('getSlaveRow');
				
			$this->database()->update(Phpfox::getT('forum_thread'), array(
				'last_user_id' => $aLastPost['user_id'],
				'post_id' => $aLastPost['post_id']
			),
				'thread_id = ' . (int)$iThreadId
			);
			$aUpdate = array(
				'thread_id' => $aLastPost['thread_id'],
				'post_id' => $aLastPost['post_id'],
				'last_user_id' => $aLastPost['user_id']
			);
		}
		if ($iParentForum > 0)
		{
			$this->database()->update(Phpfox::getT('forum'), $aUpdate, 'forum_id = ' . (int)$iForumId);
		}
		
		return true;		
	}

	/**
	 * Save access permissions for a specific forum and user group.
	 * 1st parameter includes the following post array:
	 * - forum_id (INT)
	 * - user_group_id (INT)
	 * 
	 * @param array $aVals ARRAY of post values.
	 * @return bool TRUE on success, FALSE on failure.
	 */
	public function savePerms($aVals)
	{
		$this->database()->delete(Phpfox::getT('forum_access'), 'forum_id = ' . (int) $aVals['forum_id'] . ' AND user_group_id = ' . $aVals['user_group_id']);
		foreach ($aVals['perm'] as $sVar => $sValue)
		{
			$this->database()->insert(Phpfox::getT('forum_access'), array(
					'forum_id' => $aVals['forum_id'],
					'user_group_id' => $aVals['user_group_id'],
					'var_name' => $sVar,
					'var_value' => $sValue
				)
			);
		}
		$this->cache()->remove('forum_group_permission_' . $aVals['user_group_id'] . '_' . $aVals['forum_id']);
		
		return true;
	}
	
	/**
	 * Reset access permissions for a specific forum and user group.
	 *
	 * @param int $iForumId Forum ID#
	 * @param int $iUserGroupId User group ID#
	 * @return bool TRUE on success, FALSE on failure.
	 */
	public function resetPerms($iForumId, $iUserGroupId)
	{
		$this->database()->delete(Phpfox::getT('forum_access'), 'forum_id = ' . (int) $iForumId . ' AND user_group_id = ' . $iUserGroupId);	
		$this->cache()->remove('forum_group_permission_' . $iUserGroupId . '_' . $iForumId);
		
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_process__call'))
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