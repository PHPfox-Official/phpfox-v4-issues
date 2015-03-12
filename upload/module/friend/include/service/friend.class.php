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
 * @package  		Module_Friend
 * @version 		$Id: friend.class.php 7274 2014-04-21 13:25:12Z Fern $
 */
class Friend_Service_Friend extends Phpfox_Service
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('friend');
	}

	public function get($aCond, $sSort = 'friend.time_stamp DESC', $iPage = '', $sLimit = '', $bCount = true, $bAddDetails = false, $bIsOnline = false, $iUserId = null, $bIncludeList = false, $iListId = 0)
	{
		$bSuperCache = false;
		$sSuperCacheId = '';
		// Not all calls to this function can be cached in the same way
		if ( (Phpfox::getParam('friend.cache_rand_list_of_friends') > 0) &&
			(is_string($aCond) && strpos($aCond, 'friend.is_page = 0 AND friend.user_id = ') !== false) &&
			($sSort == 'friend.is_top_friend DESC, friend.ordering ASC, RAND()') && 
			($iPage == 0)
			&& ($bIsOnline === false)
			)
		{
			$iUserId = str_replace('friend.is_page = 0 AND friend.user_id = ', '', $aCond);
			// the folder name has to be fixed so we can clear it from the add and delete functions
			$sCacheId = $this->cache()->set(array('friend_rand_6', $iUserId)); 
			$sSuperCacheId = $sCacheId;

			if ( ($aRows = $this->cache()->get($sCacheId, Phpfox::getParam('friend.cache_rand_list_of_friends'))))
			{
				if (is_bool($aRows))
				{
					return array();
				}

				return $aRows;
			}
			$bSuperCache = true;
		}
		
		$bIsListView = ((Phpfox::getLib('request')->get('view') == 'list' || (defined('PHPFOX_IS_USER_PROFILE') && Phpfox::getLib('request')->getInt('list'))) ? true : false);
		$iCnt = ($bCount ? 0 : 1);
		$aRows = array();
		
		if ($sPlugin = Phpfox_Plugin::get('friend.service_friend_get'))
		{
			eval($sPlugin);
		}		

		if ($bCount === true)
		{
			if ($bIsOnline === true)
			{
				if (Phpfox::getParam('core.store_only_users_in_session'))
				{
					$this->database()->join(Phpfox::getT('session'), 'ls', 'ls.user_id = friend.friend_user_id AND ls.last_activity > \'' . Phpfox::getService('log.session')->getActiveTime() . '\'');
				}
				else
				{
					$this->database()->join(Phpfox::getT('log_session'), 'ls', 'ls.user_id = friend.friend_user_id AND ls.last_activity > \'' . Phpfox::getService('log.session')->getActiveTime() . '\' AND ls.im_hide = 0');
				}
			}

			if ($iUserId !== null)
			{
				$this->database()->innerJoin('(SELECT friend_user_id FROM ' . Phpfox::getT('friend') . ' WHERE is_page = 0 AND user_id = ' . $iUserId . ')', 'sf', 'sf.friend_user_id = friend.friend_user_id');
			}
			
			if ($bIsListView)
			{
				$this->database()->join(Phpfox::getT('friend_list_data'), 'fld', 'fld.friend_user_id = friend.friend_user_id');
				$aCond[] = 'AND friend.user_id = ' . (int) Phpfox::getUserId() . ' AND friend.friend_user_id = fld.friend_user_id';				
			}
			
			if ((int) $iListId > 0)
			{
				$this->database()->innerJoin(Phpfox::getT('friend_list_data'), 'fld', 'fld.list_id = ' . (int) $iListId . ' AND fld.friend_user_id = friend.friend_user_id');
			}

			$iCnt = $this->database()->select('COUNT(DISTINCT u.user_id)')
				->from($this->_sTable, 'friend')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = friend.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
				->where($aCond)
				->execute('getSlaveField');
		}

		if ($iCnt)
		{
			if ($bAddDetails === true)
			{
				$this->database()->select('u.status, u.user_id, u.birthday, u.gender, u.country_iso AS location, ');
			}

			if ($bIsOnline === true)
			{
				if (Phpfox::getParam('core.store_only_users_in_session'))
				{
					$this->database()->select('ls.last_activity, ')->join(Phpfox::getT('session'), 'ls', 'ls.user_id = friend.friend_user_id AND ls.last_activity > \'' . Phpfox::getService('log.session')->getActiveTime() . '\'');
				}
				else
				{
					$this->database()->select('ls.last_activity, ')->join(Phpfox::getT('log_session'), 'ls', 'ls.user_id = friend.friend_user_id AND ls.last_activity > \'' . Phpfox::getService('log.session')->getActiveTime() . '\' AND ls.im_hide = 0');
				}
			}

			if ($iUserId !== null)
			{
				$this->database()->innerJoin('(SELECT friend_user_id FROM ' . Phpfox::getT('friend') . ' WHERE is_page = 0 AND user_id = ' . $iUserId . ')', 'sf', 'sf.friend_user_id = friend.friend_user_id');
			}
			
			if ($bIsListView)
			{
				$this->database()->join(Phpfox::getT('friend_list_data'), 'fld', 'fld.friend_user_id = friend.friend_user_id');		
				$aCond[] = 'AND friend.user_id = ' . (int) Phpfox::getUserId() . ' AND friend.friend_user_id = fld.friend_user_id';				
			}
			
			if ((int) $iListId > 0)
			{
				$this->database()->innerJoin(Phpfox::getT('friend_list_data'), 'fld', 'fld.list_id = ' . (int) $iListId . ' AND fld.friend_user_id = friend.friend_user_id');								
			}			

			$aRows = $this->database()->select('uf.dob_setting, friend.friend_id, friend.friend_user_id, friend.is_top_friend, friend.time_stamp, ' . Phpfox::getUserField())  
				->from($this->_sTable, 'friend')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = friend.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
				->join(Phpfox::getT('user_field'), 'uf', 'u.user_id = uf.user_id')  
				->where($aCond)
				->limit($iPage, $sLimit, $iCnt)
				->order($sSort)
				->group('u.user_id')
				->execute('getSlaveRows'); 		
				
			if ($bAddDetails === true)
			{
				$oUser = Phpfox::getService('user');
				$oCoreCountry = Phpfox::getService('core.country');
				foreach ($aRows as $iKey => $aRow)
				{
					$aBirthDay = Phpfox::getService('user')->getAgeArray($aRow['birthday']);
					
					$aRows[$iKey]['month'] = Phpfox::getLib('date')->getMonth($aBirthDay['month']);
					$aRows[$iKey]['day'] = $aBirthDay['day'];
					$aRows[$iKey]['year'] = $aBirthDay['year'];					
					$aRows[$iKey]['gender_phrase'] = $oUser->gender($aRow['gender']);
					$aRows[$iKey]['birthday'] = $oUser->age($aRow['birthday']);
					$aRows[$iKey]['location'] = $oCoreCountry->getCountry($aRow['location']);
				}
			}
			
			if ($bIncludeList)
			{
				foreach ($aRows as $iKey => $aRow)
				{
					$aRows[$iKey]['lists'] = Phpfox::getService('friend.list')->getListForUser($aRow['friend_user_id']);	
				}
			}
		}

		if ($bCount === false)
		{
			if ($bSuperCache == true)
			{
				$this->cache()->save($sSuperCacheId, $aRows);
			}
			return $aRows;
		}

		return array($iCnt, $aRows);
	}
	
	public function getFromCache($mAllowCustom = false, $sUserSearch = false)
	{
		$mAllowCustom = false;
		if (Phpfox::getUserBy('profile_page_id'))
		{
			$mAllowCustom = true;
		}
		
		if ($sUserSearch != false)
		{
			if (Phpfox::getUserParam('mail.restrict_message_to_friends') == true)
			{
				$this->database()->join($this->_sTable, 'f', 'u.user_id = f.friend_user_id AND f.user_id=' . Phpfox::getUserId());
			}
			
			$aRows = $this->database()->select('' . Phpfox::getUserField())
				->from(Phpfox::getT('user'),'u')
				->where('u.full_name LIKE "%'. Phpfox::getLib('parse.input')->clean($sUserSearch) .'%" AND u.profile_page_id = 0')
				->limit(Phpfox::getParam('friend.friend_cache_limit'))
				->order('u.last_activity DESC')
				->execute('getSlaveRows');
		}
		else
		{
			(($sPlugin = Phpfox_Plugin::get('friend.service_getfromcachequery')) ? eval($sPlugin) : false);
			
			if (!isset($bForceQuery))
			{
				$aRows = $this->database()->select('f.*, ' . Phpfox::getUserField())
					->from($this->_sTable, 'f')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id')
					->where(($mAllowCustom ? '' : 'f.is_page = 0 AND') . ' f.user_id = ' . Phpfox::getUserId())
					->limit(Phpfox::getParam('friend.friend_cache_limit'))
					->order('u.last_activity DESC')
					->execute('getSlaveRows');
			}
		}	

		foreach ($aRows as $iKey => $aRow)
		{		
			if (Phpfox::getUserId() == $aRow['user_id'])
			{
				unset($aRows[$iKey]);
				
				continue;
			}
			
			$aRows[$iKey]['full_name'] = html_entity_decode(Phpfox::getLib('parse.output')->split($aRow['full_name'], 20), null, 'UTF-8');						
			$aRows[$iKey]['user_profile'] = ($aRow['profile_page_id'] ? Phpfox::getService('pages')->getUrl($aRow['profile_page_id'], '', $aRow['user_name']) : Phpfox::getLib('url')->makeUrl($aRow['user_name']));
			$aRows[$iKey]['is_page'] = ($aRow['profile_page_id'] ? true : false);
			$aRows[$iKey]['user_image'] = Phpfox::getLib('image.helper')->display(array(
					'user' => $aRow,
					'suffix' => '_50_square',
					'max_height' => 50,
					'max_width' => 50,
					'return_url' => true
				)
			);
		}		
		
		return $aRows;
	}

	/**
	 * This function returns information about $iUser's friends' upcoming birthdays
	 * @param Int $iUser
	 * @return array
	 */
	public function getBirthdays($iUser)
	{
		// Phpfox::isUser(true);
		$iUser = (int)$iUser;

		// Calculate how many days in advance to check and
		$iDaysInAdvance = Phpfox::getParam('friend.days_to_check_for_birthday') >= 0 ? Phpfox::getParam('friend.days_to_check_for_birthday') : 0;
		$iThisMonth = date('m', Phpfox::getTime());
		$iToday = date('d', Phpfox::getTime());
		
		$iThisYear = date('Y', Phpfox::getTime());
		$iLastDayOfMonth = Phpfox::getLib('date')->lastDayOfMonth($iThisMonth);

		$sMonthUntil = $iThisMonth;
		$sDayUntil = $iToday;
		while($iDaysInAdvance > 0)
		{
			if ($sDayUntil > $iLastDayOfMonth)
			{
				if ($sMonthUntil < 12)
				{
					$sMonthUntil++;
				}
				else
				{
					$sMonthUntil = 1;
					$iLastDayOfMonth = Phpfox::getLib('date')->lastDayOfMonth($sMonthUntil, $iThisYear);
				}
				$sDayUntil = 0;
			}
			$iDaysInAdvance--;
			$sDayUntil++;
		}
		$sMonthUntil = $sMonthUntil[0] != '0' ? ($sMonthUntil < 10) ? '0'.$sMonthUntil : $sMonthUntil : $sMonthUntil;
		$sDayUntil = ($sDayUntil < 10) ? '0' . $sDayUntil : $sDayUntil;
		//$sBirthdays =  '"'.$iThisMonth . ''.$iToday . '" <= uf.birthday_range AND "'. $sMonthUntil . $sDayUntil . '" >= uf.birthday_range';
		if ($sMonthUntil < $iThisMonth) // its next year
		{
		    $sBirthdays =  '"'.$iThisMonth . ''.$iToday . '" <= uf.birthday_range OR "'. $sMonthUntil . $sDayUntil . '" >= uf.birthday_range';
		}
		else{
		    $sBirthdays =  '"'.$iThisMonth . ''.$iToday . '" <= uf.birthday_range AND "'. $sMonthUntil . $sDayUntil . '" >= uf.birthday_range';
		}

		// cache this query
		$aBirthdays = array();
		$sCacheId = $this->cache()->set('friend_birthday_' . $iUser);
		if (!($aBirthdays = $this->cache()->get($sCacheId, Phpfox::getParam('friend.birthdays_cache_time_out') * 60*60))) // cache is in hours
		{
			$aBirthdays = $this->database()->select('u.user_id, u.user_name, u.full_name, u.user_name, uf.dob_setting, u.birthday, fb.birthday_user_receiver')
				->from(Phpfox::getT('friend'), 'f')
				->join(Phpfox::getT('user'),' u', 'u.user_id = f.friend_user_id')
				->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id')
				->leftjoin(Phpfox::getT('friend_birthday'), 'fb', 'fb.birthday_user_receiver = u.user_id AND fb.time_stamp > '. (PHPFOX_TIME - 2629743)) /* Fixes (SHB-989762) */
				->where('f.user_id = ' . $iUser . ' AND (' . $sBirthdays . ') AND (uf.dob_setting != 2 AND uf.dob_setting != 3) AND fb.birthday_user_receiver IS NULL')
				->order('uf.birthday_range ASC')
				->limit(15)
				->execute('getSlaveRows');		
			$this->cache()->save($sCacheId, $aBirthdays);
		}
		if (!is_array($aBirthdays))
		{
			$aBirthdays = array();
		}
		/*{ (MJF-457673)
			$aFriends = $this->database()->select('u.user_id, u.user_name, f.friend_user_id as birthday_user_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id')
				->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = f.friend_user_id')
				->from($this->_sTable, 'f')
				->where('f.user_id = ' . $iUser . ' AND (' . $sBirthdays . ')')
				->limit(15)
				->order('u.birthday ASC')
				->group('f.friend_user_id')
				->execute('getSlaveRows');
			$this->cache()->save($sCacheId, $aFriends);
		}

		// another foreach to check if its congratulated already,
		if (!is_array($aFriends) || empty($aFriends)) return false;
		$sReceivers = '(uf.dob_setting != 2 AND uf.dob_setting != 3) AND (';
		foreach ($aFriends as $iKey => $aUser)
		{
		    $sReceivers .= 'u.user_id = ' . $aUser['user_id'] . ' OR ';
		}
		
		$sReceivers = substr($sReceivers, 0, strlen($sReceivers) - 4) .')';

		$aBirthdays = $this->database()->select('fb.birthday_user_receiver, fb.status_id, u.birthday, u.birthday_search, uf.dob_setting, ' .Phpfox::getUserField())
			->from(Phpfox::getT('user'), 'u')
			->leftjoin(Phpfox::getT('friend_birthday'), 'fb', 'fb.birthday_user_receiver = u.user_id AND fb.birthday_user_sender = ' . Phpfox::getUserId())
			->leftjoin(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id')
			->group('u.user_id') // added to try to prevent duplicated entries from showing up
			->where($sReceivers)
			->execute('getSlaveRows');*/

		foreach ($aBirthdays as $iKey => $aFriend)
		{
			// add when is their birthday and how old are they going to be
			$iAge = Phpfox::getService('user')->age($aFriend['birthday']);
			
			if (substr($aFriend['birthday'],0,2).'-'.substr($aFriend['birthday'],2,2) == date('m-d', Phpfox::getTime()))
			{
				$aBirthdays[$iKey]['new_age'] = $iAge;
			}
			else 
			{
				$aBirthdays[$iKey]['new_age'] = ($iAge + 1);
			}

			// Should fix ticket (ICC-452267)
			if (!isset($aFriend['birthday']) || empty($aFriend['birthday']))
			{
				$iDays = -1;
			}
			else
			{
				$iDays = Phpfox::getLib('date')->daysToDate($aFriend['birthday'], null, false);
			}

			if ($iDays < 0 || $aFriend['dob_setting'] == 2 || $aFriend['dob_setting'] == 3)
			{
				unset($aBirthdays[$iKey]);
				continue;
			}
			else
			{
				$aBirthdays[$iKey]['days_left'] = floor($iDays);
			}

			// do we show the age?
			if ($aFriend['dob_setting'] < 3 ) // 0 => age and dob; 1 => age and day/month; 2 => age
			{
			    $aBirthdays[$iKey]['show_age'] = true;
			}
			else
			{
			    $aBirthdays[$iKey]['show_age'] = false;
			}
			// fail safe
			$aBirthdays[$iKey]['birthdate'] = '';
			// $aFriend['birthday_search'] = Phpfox::getLib('date')->convertToGmt($aFriend['birthday_search']);
			// Format the birthdate according to the profile
			$aBirthDay = Phpfox::getService('user')->getAgeArray($aFriend['birthday']);
			if ($aFriend['dob_setting'] == 4)// just copy the arbitrary format on the browse.html
			{
			    //$aBirthdays[$iKey]['birthdate'] = Phpfox::getLib('date')->getMonth($aBirthDay['month']) . ' ' . $aBirthDay['day'];
			    //{$aUser.month} {$aUser.day}
				unset($aBirthDay['year']);
			}
			elseif($aFriend['dob_setting'] == 0)
			{
			    $aBirthdays[$iKey]['birthdate'] = Phpfox::getLib('date')->getMonth($aBirthDay['month']) . ' ' . $aBirthDay['day'] . ', ' . $aBirthDay['year'];
			}
			elseif ($aFriend['dob_setting'] == 1)
			{
				$aBirthdays[$iKey]['birthdate'] = Phpfox::getLib('date')->getMonth($aBirthDay['month']) . ' ' . $aBirthDay['day'];
			}
			// seems to fix bug http://www.phpfox.com/tracker/view/6070/
			//$aBirthdays[$iKey]['birthdate'] = date(Phpfox::getParam('core.profile_time_stamps'), Phpfox::getLib('date')->mktime(0,0,0,$aBirthDay['month'],$aBirthDay['day'], $aBirthDay['year']));
			
		}	

		$aReturnBirthday = array();
		foreach ($aBirthdays as $iBirthKey => $aBirthData)
		{
			$aReturnBirthday[$aBirthData['days_left']][] = $aBirthData;
		}	
		
		ksort($aReturnBirthday);

		return $aReturnBirthday;
	}

	/**
	 * This is a very failsafe function, if there is an id it gets the message but if its not set or equals zero
	 * it then can get all the messages since $iTime
	 * @param int $iUser user id
	 * @param int @iId Message id, used to fetch only one message
	 * @param int $iTime moment since we should fetch records onwards
	 * @return array
	 */
	public function getBirthdayMessages($iUser, $iId = 0, $iTime = 0)
	{
		$aWhere = array('fb.status_id = 1 AND fb.birthday_user_receiver = ' . (int)$iUser);
		if (isset($iId) && is_int($iId) && $iId > 0) $aWhere[] = 'AND birthday_id = ' . (int)$iId;
		elseif ($iTime > 0) $aWhere[] = 'AND fb.time_stamp >= ' . (int)$iTime;

		return $this->database()->select('fb.birthday_message, egift.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('friend_birthday'), 'fb')
			->leftjoin(Phpfox::getT('user'), 'u', 'u.user_id = fb.birthday_user_sender')
			->leftjoin(Phpfox::getT('egift'),'egift','egift.egift_id = fb.egift_id')
			->where($aWhere)
			->execute('getSlaveRows');
	}

	/**
	 * Checks if userA is friends with userB
	 *
	 * Here we are caching all the friends from $iUserId 
	 * 
	 * @param int $iUserId
	 * @param int $iFriendId
	 * @param boolean $bRedirect
	 * @return boolean
	 */
	public function isFriend($iUserId, $iFriendId, $bRedirect = false)
	{
		static $aCache = array();		
		
		if (isset($aCache[$iUserId][$iFriendId]))
		{
			if (!$aCache[$iUserId][$iFriendId] && $bRedirect)
			{
				Phpfox::getLib('url')->send('friend', 'request');
			}			
			
			return $aCache[$iUserId][$iFriendId];
		}

		if ($iFriendId === $iUserId)
		{
			return true;
		}
		
		if (Phpfox::getParam('friend.cache_is_friend'))
		{
			$sCacheId = $this->cache()->set(array('friend_is_friend', $iUserId . '_' . $iFriendId));
			if (($bFriend = $this->cache()->get($sCacheId)))
			{
				$bIsFriend = ((int)$bFriend > 0) || ($bFriend != '0');
				if (is_bool($bFriend))
				{
					$bIsFriend = false;
				}

				$aCache[$iUserId][$iFriendId] = ($bIsFriend);

				return $bIsFriend;
			}
		}
		
		$iCnt = $this->database()->select('/* friend.is_friend */COUNT(*)')
			->from($this->_sTable)
			->where('user_id = ' . (int) $iUserId . ' AND friend_user_id = ' . (int) $iFriendId)
			->execute('getField');

		if (Phpfox::getParam('friend.cache_is_friend'))
		{
			$sCacheId = $this->cache()->set(array('friend_is_friend', $iUserId . '_' . $iFriendId));
			$this->cache()->save($sCacheId, ((int)$iCnt) ); // Cannot store a boolean:true in case the cache picks it up wrong
		}
		if ($iCnt)
		{
			$aCache[$iUserId][$iFriendId] = true;

			return true;
		}
	
		if ($bRedirect)
		{
			Phpfox::getLib('url')->send('friend', 'request');
		}

		$aCache[$iUserId][$iFriendId] = false;

		return false;
	}

	public function getTop($iUserId, $iLimit = null)
	{
		$aFriends = $this->database()->select('f.friend_id, ' . Phpfox::getUserField())
			->from($this->_sTable, 'f')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_Id')
			->where('f.user_id = ' . (int) $iUserId . ' AND f.is_top_friend = 1')
			->order('f.ordering ASC, f.time_stamp DESC')
			->limit($iLimit)
			->execute('getSlaveRows');

		return $aFriends;
	}

	public function getMutualFriends($iUserId, $iLimit = 7, $bNoCount = false)
	{
		static $aCache = array();
		
		if (isset($aCache[$iUserId]))
		{
			return $aCache[$iUserId];
		}
		$iUserId = (int)$iUserId;
		
		if (Phpfox::getParam('friend.cache_mutual_friends') > 0)
		{
			$sCacheId = $this->cache()->set(array('mutual_friend', Phpfox::getUserId() . '_' . $iUserId));
			if (($aMutual = $this->cache()->get($sCacheId, Phpfox::getParam('friend.cache_mutual_friends') )) )
			{
				$aCache[$iUserId] = $aMutual;
				
				return $aMutual;
			}
		}
		
		$sExtra1 = '';
		$sExtra2 = '';
		
		if ($sPlugin = Phpfox_Plugin::get('friend.service_friend_getmutualfriends'))
		{
			 eval($sPlugin);
		}				
		
        /* http://www.phpfox.com/tracker/view/12737/ */
        if ($bNoCount == false)
        {
            $iCnt = $this->database()->select('count(f.user_id)')
                ->from(Phpfox::getT('friend'), 'f')
                ->join(Phpfox::getT('friend'), 'sf', 'sf.friend_user_id = f.friend_user_id AND sf.user_id = ' . (int)$iUserId . $sExtra1)
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id')
                ->where('f.is_page = 0 AND f.user_id = ' . Phpfox::getUserId() . $sExtra2)
                ->group('f.friend_user_id')
                ->execute('getSlaveRows');	
            $iCnt = count($iCnt);
            
        }
		$aRows = $this->database()->select(Phpfox::getUserField())
			->from(Phpfox::getT('friend'), 'f')
			->join(Phpfox::getT('friend'), 'sf', 'sf.friend_user_id = f.friend_user_id AND sf.user_id = ' . (int)$iUserId . $sExtra1)
			->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id')
			->where('f.is_page = 0 AND f.user_id = ' . Phpfox::getUserId() . $sExtra2)
			->order('f.time_stamp DESC')
			->group('f.friend_user_id')
			->limit($iLimit)
			->execute('getSlaveRows');	

		if (!$bNoCount)
		{
			//$iCnt = $this->database()->getField('SELECT FOUND_ROWS()');
		}
		
		if (Phpfox::getParam('friend.cache_mutual_friends') > 0)
		{
			$sCacheId = $this->cache()->set(array('mutual_friend', Phpfox::getUserId() . '_' . $iUserId));
			$this->cache()->save($sCacheId, array($iCnt, $aRows));
		}
		
		$aCache[$iUserId] = array($iCnt, $aRows);

		return array($iCnt, $aRows);
	}
	
	public function isFriendOfFriend($iUserId)
	{
		static $aCache = array();
		
		if (isset($aCache[$iUserId]))
		{
			return $aCache[$iUserId];
		}
		
		list($iCnt, $aRows) = $this->getMutualFriends($iUserId);

		$bReturn = ($iCnt ? true : false);
		
		$aCache[$iUserId] = $bReturn;
		
		return $bReturn;
	}
	
	/**
	 * Checks if we already sent a user a birthday notification.
	 *
	 * @param int $iUserId User ID of the sender
	 * @param int $iFriendId User ID of the friend to check
	 * @return bool TRUE for sent, FALSE for not sent
	 */
	public function isBirthdaySent($iUserId, $iFriendId)
	{
		return ((int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('friend_birthday'))
			->where('birthday_user_sender = ' . (int) $iUserId . ' AND birthday_user_receiver = ' . (int) $iFriendId)
			->execute('getSlaveField') ? true : false);
	}
	
	public function queryJoin($bNoQueryFriend)
	{
		if ($this->request()->get('view') == 'friend' || ($bNoQueryFriend === false && (Phpfox::getParam('core.friends_only_community') && $this->request()->get('view') == '')))
		{
			return true;
		}
		
		return false;
	}
	
	public function buildMenu()
	{
		// Add a hook with return here
		$aFilterMenu = array(
			Phpfox::getPhrase('friend.all_friends') => '',
			Phpfox::getPhrase('friend.incoming_requests') => 'friend.accept',
			Phpfox::getPhrase('friend.pending_requests') => 'friend.pending'
		);			
		
		$aFilterMenu[] = true;
		
		$aLists = Phpfox::getService('friend.list')->get();
		
		if (count($aLists))
		{			
			foreach ($aLists as $aList)
			{
				if (is_numeric($aList['name']))
				{
					$aList['name'] = 'phpfox_numeric_friend_list_'.$aList['name'];
				}
				$aFilterMenu[$aList['name']] = 'friend.view_list.id_' . $aList['list_id'];	
			}			
		}
		
		Phpfox::getLib('template')->buildSectionMenu('friend', $aFilterMenu);		
	}

	/*
		@param $aFriends array|string if string its meant for an IN select
	*/
	public function getFriendsOfFriends($aFriends = array())
	{
		if (!Phpfox::isUser())
		{
			return array();
		}
		
		if (is_array($aFriends) && !empty($aFriends))
		{
			$aMyFriends = $aFriends;
		}
		else if (is_string($aFriends) && !empty($aFriends))
		{
			$sIn = $aFriends;
		}
		else		
		{
			/*
			 * Not tested
			 * if (Phpfox::getParam('core.super_cache_system'))
			{
				$sCacheId = $this->cache()->set(array('friend', Phpfox::getUserId()));
				if ( !($aSuperCache = $this->cache()->get($sCacheId)))
				{
					$aSuperCache = $this->database()->select('*')
						->from($this->_sTable)
						->where('user_id = ' . Phpfox::getUserId())
						->execute('getSlaveRows');
					$this->cache()->save($sCacheId, $aSuperCache);
				}
				$aMyFriends = array();
				foreach ($aSuperCache as $aEntry)
				{
					$aMyFriends = $aEntry;
				}
			}
			else*/
			{
				$aMyFriends = $this->database()->select('friend_user_id')
					->from(Phpfox::getT('friend'))
					->where('user_id = ' . Phpfox::getUserId())
					->group('friend_user_id')
					->execute('getSlaveRows');
			}
		}
		
		if (isset($aMyFriends))
		{
			$sIn = '(';
			foreach ($aMyFriends as $aFriend)
			{
				$sIn .= $aFriend['friend_user_id'] .',';
			}
			$sIn = rtrim($sIn, ',') .')';
		}
		
		$aOfFriends = $this->database()->select('friend_user_id')
			->from(Phpfox::getT('friend'))
			->where('user_id IN ' . $sIn)
			->group('friend_user_id')
			->execute('getSlaveRows');
		
		$aFriendsOfFriends = array();
		foreach ($aOfFriends as $aUser)
		{
			$aFriendsOfFriends[] = $aUser['friend_user_id'];
		}
		return $aFriendsOfFriends;
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
		if ($sPlugin = Phpfox_Plugin::get('friend.service_friend___call'))
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
