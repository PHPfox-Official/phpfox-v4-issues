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
 * @version 		$Id: ban.class.php 7029 2014-01-08 14:30:56Z Fern $
 */
class Ban_Service_Ban extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('ban');	
	}
	
	public function getFilters($sType)
	{
		$aFilters = $this->database()->select('b.*, ' . Phpfox::getUserField())
						->from($this->_sTable, 'b')
						->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
						->where('b.type_id = \'' . $this->database()->escape($sType) . '\'')
						->execute('getRows');

		foreach ($aFilters as $iKey => $aFilter)
		{
			if (!empty($aFilter['user_groups_affected']))
			{
				$aUserGroups = unserialize($aFilter['user_groups_affected']);
				$aFilters[$iKey]['user_groups_affected'] = array();
				
				$sWhere = '';
				foreach ($aUserGroups as $iUserGroup)
				{
					$sWhere .= 'user_group_id = ' . $iUserGroup . ' OR ';
				}
				$sWhere = rtrim($sWhere, ' OR ');
				$aFilters[$iKey]['user_groups_affected'] = Phpfox::getService('user.group')->get($sWhere);
			}
		}
		return $aFilters;
	}
	
	public function check($sType, $sValue)
	{
		$sCacheId = $this->cache()->set('ban_' . $sType);
		$aFilters = array();
		if (!($aFilters = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('find_value')
				->from($this->_sTable)
				->where('type_id = \'' . $this->database()->escape($sType) . '\'')
				->execute('getRows');
				
			foreach ($aRows as $aRow)
			{
				$aFilters[trim($aRow['find_value'])] = true;
			}
			
			$this->cache()->save($sCacheId, $aFilters);
		}
		
		if ($sType == 'display_name')
		{
			$sValue = $this->preParse()->convert($sValue);
		}

		if (is_array($aFilters) && count($aFilters))
		{			
			foreach ($aFilters as $sFilter => $mValue)
			{
				$sFilter = str_replace('&#42;','*', $sFilter);
				if ($sType == 'ip')
				{
					$sFilter = preg_replace('%[^0-9.*]%', '', $sFilter);
					if ($sFilter == '*')
					{
						continue;
					}
				}				
				
				if (preg_match('/\*/i', $sFilter))
				{
					$sFilter = str_replace(array('.', '*'), array('\.', '(.*?)'), $sFilter);
					
					// http://www.phpfox.com/tracker/view/14967/
					if(preg_match('/http(s?):\/\//i', $sFilter))
					{
						$sFilter = str_replace('/', '\\/\\/', $sFilter);
					}
					
					if (preg_match('/^' . $sFilter . '$/i', $sValue))
					{
						return false;
					}
				}
				else 
				{					
					if (preg_match('/^' . $sFilter . '$/i', $sValue, $aMatches))
					{		
						return false;
					}					
				}
			}
		}		
		
		return true;
	}

	/**
	 * This function resembles $this->check but it also handles banning and is a more direct approach
	 * and handles redirection and db insertion
	 * This function is called in every Service as opposed to a Library mainly because there may be
	 * cases where it becomes too restrictive
	 * If the user groups affected is an empty array, it assumes that it affects every user group.
	 * This function has been implemented in the following services
	 *		- Blog.process (Add, update, updateBlogText, updateBlogTitle)
	 *		- Bulletin.process (Add, update)
	 *		- Comment.process (Add, updateText)
	 *		- Event.process (Add, massEmail, update)
	 *		- Forum.post.process (Add, update, updateText)
	 *		- Forum.thread.process (Add, update)
	 *		- Group.process (Add, update)
	 *		- Im.process (addText)
	 *		- Mail.process (Add)
	 *		- Marketplace.process (Add, update)
	 *		- Music.process (upload)
	 *		- Music.album.process (add, update)
	 *		- Music.genre.process (add, update)
	 *		- Music.song.process (setName)
	 *		- Newsletter.process (add)
	 *		- Page.process (add)
	 *		- Photo.process (add)
	 *		- Photo.album.process (add, updateTitle)
	 *		- Photo.category.process (add)
	 *		- Photo.tag.process (add)
	 *		- Poll.process (add, updateAnswer)
	 *		- Quiz.process (add, update)
	 *		- Share.process (add, sendEmails)
	 *		- Shoutbox.process (add)
	 *		- Video.process (update)
	 *		- Video.category.process (add)
	 *		- User.process (updateStatus:2.1.0 RC1)
	 * @param string $sValue
	 * @return false on fail. In some situations it doesnt help echo'ing here (comment)
	 */
	public function checkAutomaticBan($sValue)
	{
		
			/* Extra protection for admins so they dont get banned automatically. */
			if (Phpfox::isAdmin() || empty($sValue))
			{
				return true;
			}
			if (is_array($sValue))
			{
				$sValue = $this->_flatten($sValue);
			}
			$aFilters = $this->database()->select('*')
							->from($this->_sTable)
							->where('type_id = "word"')
							->execute('getRows');
			foreach ($aFilters as $iKey => $aFilter)
			{
				$aUserGroupsAffected = unserialize($aFilter['user_groups_affected']);

				if (is_array($aUserGroupsAffected) && !empty($aUserGroupsAffected) && in_array(Phpfox::getUserBy('user_group_id'), $aUserGroupsAffected) == false)
				{
					continue;
				}

				$sFilter = ''.str_replace('&#42;', '*', $aFilter['find_value']) .'';
				//$sFilter = str_replace(array(' *', '* '),'*', $sFilter);
				
				$bBan = false;
				$sFilter = str_replace("/", "\/", $sFilter);
				$sFilter = str_replace('&#42;', '*', $sFilter);
				if (preg_match('/\*/i', $sFilter))
				{
					$sFilter = str_replace(array('.', '*'), array('\.', '(.*?)'), $sFilter);

					$bBan = preg_match('/' . $sFilter . '/is', $sValue);
				}
				else
				{
					$bBan = preg_match("/(\W)". $sFilter ."(\W)/i", $sValue);
					if (!$bBan)
					{
						$bBan = preg_match("/^". $sFilter ."(\W)/i", $sValue);
					}
					if (!$bBan)
					{
						$bBan = preg_match("/(\W)". $sFilter ."$/i", $sValue);
					}
					if (!$bBan)
					{
						$bBan = preg_match("/^". $sFilter ."$/i", $sValue);
					}

				}
				if ($bBan)
				{
                                    
					if ($aFilter['days_banned'] === null)
					{
						return true;
					}
					$this->database()->insert(Phpfox::getT('ban_data'), array(
						'ban_id' => $aFilter['ban_id'],
						'user_id' => Phpfox::getUserId(),
						'start_time_stamp' => PHPFOX_TIME,
						'end_time_stamp' => $aFilter['days_banned'] > 0 ? PHPFOX_TIME + ($aFilter['days_banned'] * 86400) : 0,
						'return_user_group' => $aFilter['return_user_group'],
						'reason' => $aFilter['reason']
					));
					define('PHPFOX_USER_IS_BANNED', true);
					$aFilter['reason'] = str_replace('&#039;', "'", $aFilter['reason']);
					$sReason = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1',array(), false, null, '" . Phpfox::getUserBy('language_id') . "') . ''", $aFilter['reason']);
					
					// Related to issue 14487 this is a "best guess" fallback
					$iUserGroupId = Phpfox::getParam('core.banned_user_group_id');
					if ($iUserGroupId == 0)
					{
						$iUserGroupId = 5;
					}

					$this->database()->update(Phpfox::getT('user'),
							array('user_group_id' => $iUserGroupId)
							, 'user_id = ' . (int) Phpfox::getUserId());

					Phpfox::getService('user.auth')->logout();
					if (defined('PHPFOX_IS_AJAX') && PHPFOX_IS_AJAX)
					{						
						echo 'alert("' . $sReason . '");';
						echo 'window.location.reload(true);';
					}
					else
					{
						Phpfox::getLib('url')->send('', array(), $sReason);
					}
					return false;
				}
			}
			return true;
	}

	/**
	 * Simple function to recursively array_values. Used only with checkAutomaticBan
	 * @param array|string $aArr
	 * @return string 
	 */
	private function _flatten($aArr)
	{
		if (!is_array($aArr))
		{
			return $aArr;
		}
		$sStr = '';
		foreach ($aArr as $aA)
		{
			$sStr .= $this->_flatten($aA) . ' ';
		}
		return $sStr;
	}
	/**
	 * This function checks if $iUser is banned taking into account the user_group_id index and the ban_data table
	 * @param int $iUser
	 * @return array is_banned => bool, undefined|reason:string
	 */
	public function isUserBanned($aUser = array())
	{
		$aBanned = $this->database()->select('*')
				->from(Phpfox::getT('ban_data'))
				->where('user_id = ' . ( (!isset($aUser['user_id']) || $aUser['user_id'] == null) ? Phpfox::getUserId() : (int)$aUser['user_id'] ) . ' AND is_expired = 0')
				->execute('getSlaveRow');		
		
		/* Users banned in version 2.0 do not have a record in ban_data but belong to the banned user group */
		if (!isset($aBanned['user_id']) &&
				isset($aUser['user_group_id']) &&
				Phpfox::getService('user.group.setting')->getGroupParam($aUser['user_group_id'],'core.user_is_banned'))
		{
			return array('is_banned' => true);
		}

		/* Users banned in version 2.1 do have a record in ban_data where is_expired == 0 and the time stamp is
		   either 0 or in the future */
		if (isset($aBanned['is_expired']) && $aBanned['is_expired'] == 0 && isset($aBanned['end_time_stamp'])
				&& ($aBanned['end_time_stamp'] == 0 || $aBanned['end_time_stamp'] > PHPFOX_TIME))
		{
			return array_merge(array('is_banned' => true), $aBanned);
		}
		
		return array_merge(array('is_banned' => false), $aBanned);
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
		if ($sPlugin = Phpfox_Plugin::get('ban.service_ban__call'))
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
