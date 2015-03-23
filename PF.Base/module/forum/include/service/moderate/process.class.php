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
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Forum_Service_Moderate_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('forum_moderator');
	}
	
	public function add($aVals)
	{
		$aUsers = array();
		$aModerators = $this->database()->select('user_id, moderator_id')
			->from($this->_sTable)
			->where('forum_id = ' . $aVals['forum'])
			->execute('getRows');
		foreach ($aModerators as $aModerator)
		{
			$aUsers[$aModerator['user_id']] = $aModerator['moderator_id'];
		}		
		
		if (empty($aVals['user_id']) && isset($aVals['users']) && is_array($aVals['users']) && count($aVals['users']))
		{
			foreach ($aVals['users'] as $iUserId)
			{
				if (isset($aUsers[$iUserId]))
				{
					// update
					$this->_update($aUsers[$iUserId]['moderator_id'], $aVals['param']);
				}
				else 
				{
					// insert	
					$this->_insert($aVals['forum'], $iUserId, $aVals['param']);
				}				
			}
		}
		
		if (!empty($aVals['user_id']) && is_numeric($aVals['user_id']))
		{
			if (isset($aUsers[$aVals['user_id']]))
			{
				// update
				$this->_update($aUsers[$aVals['user_id']]['moderator_id'], $aVals['param']);				
			}
			else 
			{
				$this->_insert($aVals['forum'], $aVals['user_id'], $aVals['param']);
			}				
		}
		
		$this->cache()->remove('forum', 'substr');
		
		return true;
	}
	
	public function delete($iId)
	{
		$this->database()->delete(Phpfox::getT('forum_moderator'), 'moderator_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('forum_moderator_access'), 'moderator_id = ' . (int) $iId);
		
		$this->cache()->remove('forum', 'substr');
	}
	
	private function _update($iModeratorId, $aDatas)
	{
		$this->database()->delete(Phpfox::getT('forum_moderator_access'), 'moderator_id = ' . $iModeratorId);
		
		foreach ($aDatas as $sVar => $mValue)
		{
			if ($mValue)
			{
				$this->database()->insert(Phpfox::getT('forum_moderator_access'), array('moderator_id' => $iModeratorId, 'var_name' => $sVar));
			}
		}		
	}
	
	private function _insert($iForumId, $iUserId, $aDatas)
	{
		$iId = $this->database()->insert($this->_sTable, array('forum_id' => $iForumId, 'user_id' => $iUserId));
		
		foreach ($aDatas as $sVar => $mValue)
		{
			if ($mValue)
			{
				$this->database()->insert(Phpfox::getT('forum_moderator_access'), array('moderator_id' => $iId, 'var_name' => $sVar));
			}
		}
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_moderate_process__call'))
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