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
 * @package  		Module_User
 * @version 		$Id: user.class.php 7245 2014-03-31 19:24:29Z Fern $
 */
class User_Service_User extends Phpfox_Service 
{	
	private $_aUser = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('user');
	}
	
	public function getData($sSaveData, $iUserId = null)
	{
		static $aCache = array();
		
		if ($iUserId === null)
		{
			if (!Phpfox::isUser())
			{
				return false;
			}
		
			$iUserId = Phpfox::getUserId();
		}
		
		if (!isset($aCache[$iUserId]))
		{
			$aCache[$iUserId] = array();
			
			$sCacheId = $this->cache()->set(array('userdata', $iUserId));	
			$aCache[$iUserId] = (array) $this->cache()->get($sCacheId);			
		}
		
		if (isset($aCache[$iUserId][$sSaveData]))
		{
			return $aCache[$iUserId][$sSaveData];
		}
		
		return false;
	}
	
	public function getStaticInfo($iUserId)
	{
		static $aCachedUserInfo = array();
		
		if (isset($aCachedUserInfo[$iUserId]))
		{
			return $aCachedUserInfo[$iUserId];
		}
		
		$sInnerJoinCacheId = Phpfox::getLib('cache')->set(array('userjoin', $iUserId));
		$aCachedUserInfo[$iUserId] = Phpfox::getLib('cache')->get($sInnerJoinCacheId);
		if (!empty($aCachedUserInfo[$iUserId]))
		{
			return $aCachedUserInfo[$iUserId];
		}
		
		$aCachedUserInfo[$iUserId] = false;
		
		return false;
	}
	
	public function getCurrentName($iUserId, $sName)
	{
		static $aCachedUserInfo = array();
		if (Phpfox::getParam('user.cache_user_inner_joins'))
		{
			$aUser = $this->getStaticInfo($iUserId);
			if ($aUser !== false)
			{
				return $aUser['full_name'];
			}
			
			return $sName;
		}
		return $sName;
	}
	
	public function getByUserName($sUser)
	{	
		return $this->database()->select('u.*, user_field.*')
			->from($this->_sTable, 'u')
			->join(Phpfox::getT('user_field'), 'user_field', 'user_field.user_id = u.user_id')
			->where("u.user_name = '" . $this->database()->escape($sUser) . "'")
			->execute('getSlaveRow');
	}
	
	public function getUser($mUser, $sSelect = 'u.*', $bUserName = false)
	{
		(($sPlugin = Phpfox_Plugin::get('user.service_user_getuser_start')) ? eval($sPlugin) : false);
		
		if ($bUserName === false)
		{
			if ((int) $mUser === 0)
			{
				return false;
			}
		}
		else 
		{
			if (empty($mUser))
			{
				return false;
			}
		}		
		
		$aRow = $this->database()->select($sSelect)
			->from($this->_sTable, 'u')
			->where(($bUserName ? "u.full_name = '" . $this->database()->escape($mUser) . "'" : 'u.user_id = ' . (int) $mUser))
			->execute('getSlaveRow');
		
		(($sPlugin = Phpfox_Plugin::get('user.service_user_getuser_end')) ? eval($sPlugin) : false);
			
		return $aRow;
	}
	
	
	public function get($mName = null, $bUseId = true)
	{		
		static $aUser = array();
		
		if (isset($aUser[$mName]))
		{		
			return $aUser[$mName];
		}
		
		/*
		 * For this super caching we need to clear the profile cache when:
		 * 	- [Y] The admin changes anything related to the theme.
		 * 	- [Y] In designer the user changes the style
		 * 	- [Y] Updates the cover photo
		 * 	- [Tradeoff] User changes does any activity OR query here for `user_activity` 
		 */ 
		 
		if (Phpfox::getParam('profile.profile_caches_user') && Phpfox::getLib('request')->get('req2') == '')
		{
			// Any way to avoid this query?
			if ($bUseId != true)
			{
				if ($mName != Phpfox::getUserBy('user_name'))
				{
					$mName = $this->database()->select('user_id')->from(Phpfox::getT('user'))->where('user_name = "' . $this->database()->escape( $mName ) . '"')->execute('getSlaveField');
				}
				else
				{
					$mName = Phpfox::getUserId();
				}
				$bUseId = true;
			}
			$sCacheId = $this->cache()->set(array('profile',  'user_id_'  . $mName));
			if ( ($aCachedUser = $this->cache()->get($sCacheId)) && is_array($aCachedUser))
			{
				$aUser[$mName] = $aCachedUser;
				if (!isset($this->_aUser[ $aCachedUser['user_id'] ]))
				{
					$this->_aUser[ $aCachedUser['user_id'] ] = $aCachedUser;
				}
				return $aCachedUser;
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_user_get_start')) ? eval($sPlugin) : false);
		
		if (Phpfox::isUser() && Phpfox::getParam('profile.profile_caches') != true)
		{
			// Try to cache this one
			$this->database()->select('ut.item_id AS is_viewed, ')->leftJoin(Phpfox::getT('user_track'), 'ut', 'ut.item_id = u.user_id AND ut.user_id = ' . Phpfox::getUserId());
		}
		
		// This is only needed in the info page		
		if (Phpfox::getLib('request')->get('req2') == 'info')//&& Phpfox::getParam('rate.cache_rate_profiles'))
		{			
			// Implement later, we're on the profile.index right now. Lets do profile.info tomorrow			
			$this->database()->select('ur.rate_id AS has_rated, ')->leftJoin(Phpfox::getT('user_rating'), 'ur', 'ur.item_id = u.user_id AND ur.user_id = ' . Phpfox::getUserId());
		}


		$this->database()->join(Phpfox::getT('user_group'), 'ug', 'ug.user_group_id = u.user_group_id')
			->join(Phpfox::getT('user_space'), 'user_space', 'user_space.user_id = u.user_id')
			->join(Phpfox::getT('user_field'), 'user_field', 'user_field.user_id = u.user_id')
			->join(Phpfox::getT('user_activity'), 'user_activity', 'user_activity.user_id = u.user_id')
			->leftJoin(Phpfox::getT('theme_style'), 'ts', 'ts.style_id = user_field.designer_style_id AND ts.is_active = 1')
			->leftJoin(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id')
			->leftJoin(Phpfox::getT('user_featured'), 'uf', 'uf.user_id = u.user_id');
		
		// 	http://www.phpfox.com/tracker/view/15331/
		if (Phpfox::getParam('core.store_only_users_in_session'))
		{
			$this->database()->leftJoin(Phpfox::getT('session'), 'ls', 'ls.user_id = u.user_id');
		}
		else
		{
			$this->database()->leftJoin(Phpfox::getT('log_session'), 'ls', 'ls.user_id = u.user_id AND ls.im_hide = 0');
		}

		if (Phpfox::isModule('photo'))
		{
			$this->database()->select('p.photo_id as cover_photo_exists, ')->leftJoin(Phpfox::getT('photo'), 'p', 'p.photo_id = user_field.cover_photo');
		}

		$aRow = $this->database()->select('u.*, user_space.*, user_field.*, user_activity.*, ls.user_id AS is_online, ts.style_id AS designer_style_id, ts.folder AS designer_style_folder, t.folder AS designer_theme_folder, t.total_column, ts.l_width, ts.c_width, ts.r_width, t.parent_id AS theme_parent_id, ug.prefix, ug.suffix, ug.icon_ext, ug.title, uf.user_id as is_featured')
			->from($this->_sTable, 'u')
			->where(($bUseId ? "u.user_id = " . (int) $mName . "" : "u.user_name = '" . $this->database()->escape($mName) . "'"))
			->execute('getSlaveRow');
		
        
		(($sPlugin = Phpfox_Plugin::get('user.service_user_get_end')) ? eval($sPlugin) : false);
		if (isset($aRow['is_invisible']) && $aRow['is_invisible'])
		{
			$aRow['is_online'] = '0';
		}
		if (isset($aRow['cover_photo']) && ((int)$aRow['cover_photo'] > 0) && 
                (
                    (isset($aRow['cover_photo_exists']) && $aRow['cover_photo_exists'] != $aRow['cover_photo']) ||
                    (!isset($aRow['cover_photo_exists']))
                ))
        {
            $aRow['cover_photo'] = null;
        }
        
		$aUser[$mName] =& $aRow;			
			
		if (!isset($aUser[$mName]['user_name']))
		{
			return false;
		}		
		
		$aUser[$mName]['user_server_id'] = $aUser[$mName]['server_id'];		
		
		$aUser[$mName]['is_friend'] = false;
		$aUser[$mName]['is_friend_of_friend'] = false;
		$aUser[$mName]['is_friend_request'] = false;
		if (Phpfox::isUser() && Phpfox::isModule('friend') && Phpfox::getUserId() != $aUser[$mName]['user_id'])
		{
			$aUser[$mName]['is_friend'] = (Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aUser[$mName]['user_id']) ? true : false);				
			$aUser[$mName]['is_friend_of_friend'] = (Phpfox::getService('friend')->isFriendOfFriend($aUser[$mName]['user_id']) ? true : false);
			if (!$aUser[$mName]['is_friend'])
			{
				$aUser[$mName]['is_friend_request'] = (Phpfox::getService('friend.request')->isRequested(Phpfox::getUserId(), $aUser[$mName]['user_id']) ? 2 : false);
				if (!$aUser[$mName]['is_friend_request'])
				{
					$aUser[$mName]['is_friend_request'] = (Phpfox::getService('friend.request')->isRequested($aUser[$mName]['user_id'], Phpfox::getUserId()) ? 3 : false);
				}
			}			
		}				
		
		$this->_aUser[$aRow['user_id']] = $aUser[$mName];
		
		if (Phpfox::getParam('core.super_cache_system') )
		{
			$sCacheId = $this->cache()->set(array('profile', ($bUseId ? 'user_id_' : 'user_name_') . $mName));
			$this->cache()->save($sCacheId, $aUser[$mName]);
		}
		
		return $aUser[$mName];
	}	
	
	public function getUserObject($iUserId)
	{
		return (isset($this->_aUser[$iUserId]) ? (object) $this->_aUser[$iUserId] : false);
	}
	
	public function getForEdit($iUserId)
	{
		Phpfox::getUserParam('user.can_edit_users', true);
		
		(($sPlugin = Phpfox_Plugin::get('user.service_user_getforedit')) ? eval($sPlugin) : false);
		
		$aUser = $this->database()->select('u.*, uf.*, ua.*')
			->from($this->_sTable, 'u')
			->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id')
			->join(Phpfox::getT('user_activity'), 'ua', 'ua.user_id = u.user_id')
			->where('u.user_id = ' . (int) $iUserId)
			->execute('getRow');
			
		if (!isset($aUser['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.unable_to_find_the_user_you_plan_to_edit'));
		}
		
		return $aUser;
	}
	
	public function getNew($iLimit = 8)
	{
		return $this->database()->select(Phpfox::getUserField())
			->from($this->_sTable, 'u')
			->order('u.joined DESC')
			->where('u.profile_page_id = 0')
			->limit($iLimit)
			->execute('getSlaveRows');
	}
	
	public function getRandom($iLimit = 4)
	{
		return $this->database()->select(Phpfox::getUserField())
			->from($this->_sTable, 'u')
			->where('u.user_image IS NOT NULL AND view_id = 0')
			->order('RAND()')
			->limit($iLimit)
			->execute('getSlaveRows');
	}	
	
	public function isUser($mName, $bId = false)
	{
		(($sPlugin = Phpfox_Plugin::get('user.service_user_isuser')) ? eval($sPlugin) : false);
		
		return $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where(($bId ? "user_id = " . (int) $mName : "user_name = '" . $this->database()->escape($mName) . "'"))
			->execute('getField');
	}

	/**
	 * Gets the language_phrase variable names for the reasons available to show at account cancelation
	 * @return array
	 */
	public function getReasons()
	{
		$sCacheId = $this->cache()->set('user_cancellations');
		if (!($aReasons = $this->cache()->get($sCacheId)))
		{
			$aReasons = $this->database()->select('*')
				->from(Phpfox::getT('user_delete'))
				->order('ordering ASC')
				->where('is_active = 1')
				->execute('getSlaveRows');
				
			$this->cache()->save($sCacheId, $aReasons);
		}
		if (!isset($aReasons) || !is_array($aReasons))
		{
			$aReasons = array();
		}
		foreach ($aReasons as $iKey => $aReason)
		{
			if ($aReasons[$iKey]['is_active'] != 1)
			{
				unset($aReasons[$iKey]);
			}
		}
		return $aReasons;
	}

	public function gender($iGender, $iType = 0)
	{
		$sGender = false;
		foreach ((array) Phpfox::getParam('core.global_genders') as $iKey => $aGender)
		{
			if ($iGender == $iKey)
			{
				if ($iType == 2)
				{
					return Phpfox::getPhrase($aGender[2]);
				}
				return ($iType == 1 ? Phpfox::getPhrase($aGender[0]) : Phpfox::getPhrase($aGender[1]));
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_user_gender')) ? eval($sPlugin) : false);
		
		return $sGender;
	}

	/**
	 * Formats the date so its easier to search birthdates
	 * @param int $iDay
	 * @param int $iMonth
	 * @param int $iYear
	 * @return String
	 * @example buildAge(1,9,1980) returns: "09011980"
	 * @example buildAge("8","19",1980) returns false, there is no month 19th
	 * @example buildAge("8","11","1978") returns "11081978"
	 */
	public function buildAge($iDay, $iMonth, $iYear = null)
	{
		$iDay = (int)$iDay;
		$iMonth = (int)$iMonth;
		$iYear = ($iYear !== null) ? (int)$iYear : null;
		if ( (1 > $iDay || $iDay > 31) || (1 > $iMonth || $iMonth > 12) )
		{
				return false;
		}
		if ($iYear !== null)
		{
			return ($iMonth < 10 ? '0' . $iMonth : $iMonth) .($iDay < 10 ? '0' . $iDay : $iDay) . $iYear;
		}

		return ($iMonth < 10 ? '0' . $iMonth : $iMonth) .($iDay < 10 ? '0' . $iDay : $iDay);
	}

	/**
	 * Returns how old is a user based on its birthdate
	 * @param String $sAge
	 * @return int
	 */
	public function age($sAge)
	{
		if (!$sAge)
		{
			return $sAge;
		}
		$iYear = intval(substr($sAge,4));
		$iMonth = intval(substr($sAge,0,2));
		$iDay = intval(substr($sAge,2,2));
		$iAge = date('Y') - (int) $iYear;
		$iCurrDate = date('m') * 100 + date('d');
	    $iBirthDate = $iMonth * 100 + $iDay;
	    
	    if ($iCurrDate < $iBirthDate)
	    {
	        $iAge--;
	    }
	    
	    return $iAge;
	}
	
	public function getAgeArray($sAge)
	{
		return array(
			'day' => intval(substr($sAge, 2, 2)),
			'month' => intval(substr($sAge, 0, 2)),
			'year' => intval(substr($sAge, 4))
		);
	}

	public function getInlineSearch($sUser, $sOld)
	{
		(($sPlugin = Phpfox_Plugin::get('user.service_user_getinlinesearch')) ? eval($sPlugin) : false);

		$sOld = trim(rtrim($sOld, ','));	
		if (strpos($sOld, ','))
		{
			$sOld = explode(',', $sOld);
			$sOld = array_map('trim', $sOld);
		}
		
		$aRows = $this->database()->select('u.user_id, u.full_name AS tag_text, u.user_name, u.server_id, u.user_name, u.user_image')
			->from($this->_sTable, 'u')
			->join(Phpfox::getT('friend'), 'f', 'f.user_id = u.user_id AND f.friend_user_id = ' . Phpfox::getUserId())
			->where((strpos($sUser, '@') ? "u.email LIKE '" . $this->database()->escape($sUser) . "%'" : "(u.full_name LIKE '" . $this->database()->escape($sUser) . "%' OR u.user_name LIKE '" . $this->database()->escape($sUser) . "%')"))			
			->limit(0, 10)
			->execute('getSlaveRows');		
			
		foreach ($aRows as $iKey => $aRow)
		{			
			if ((is_array($sOld) && in_array($aRow['user_id'], $sOld) || (is_string($sOld) && $aRow['user_id'] === $sOld)))
			{				
				unset($aRows[$iKey]);
			}
		}
		
		return $aRows;
	}
	
	public function getLink($iUserId = null, $sUserName = null, $aParams = null)
	{
		if (($iUserId === null || $sUserName === null))
		{
			$aRow = $this->database()->select('user_id, user_name')
				->from($this->_sTable)
				->where(($iUserId === null ? "user_name = '" . $this->database()->escape($sUserName) . "'" : 'user_id = ' . (int) $iUserId))
				->execute('getSlaveRow');

			if (!isset($aRow['user_id']))
			{
				return Phpfox_Error::trigger('Not a valid user.', E_USER_ERROR);
			}
			
			$iUserId = $aRow['user_id'];
			$sUserName = $aRow['user_name'];
		}
		
		return Phpfox::getLib('url')->makeUrl($sUserName, $aParams);
	}
	
	/**
	 * Returns the first name of a users full name.
	 *
	 * Usage within a template:
	 * <code>
	 * {$sFullname|first_name}
	 * </code>
	 *
	 * Usage within a PHP class:
	 * <code>
	 * Phpfox::getService('user')->getFirstName($sFullName);
	 * </code>
	 * 
	 * @param string $sName Full name of the member.
	 * 
	 * @return string Returns the first part of the name.
	 */
	public function getFirstName($sName)
	{
		// Create an array based on a space between a persons name		
		$aParts = explode(' ', $sName);
		// Return the first part of the name, which is the first name
		return $aParts[0];
	}
	
	public function getUserFields($bReturnUserValues = false, &$aUser = null, $sPrefix = null, $iUserId = null)
	{
		$aFields = array(
			'user_id',
			'profile_page_id',
			'server_id',
			'user_name',
			'full_name',
			'gender',
			'user_image',
			'is_invisible',
			'user_group_id', // Fixes DRQ-307282 
			'language_id'
		);	
		
		if (Phpfox::getParam('user.display_user_online_status'))
		{
			$aFields[] = 'last_activity';
		}
		
		/* Return $aFields but about iUserId */
		if ($iUserId != null)
		{
			$aUser = $this->database()->select(implode(',', $aFields))
					->from(Phpfox::getT('user'))
					->where('user_id = ' . (int)$iUserId)
					->execute('getSlaveRow');
			
			return $aUser;
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_user_getuserfields')) ? eval($sPlugin) : false);
		
		if ($bReturnUserValues)
		{
			$aCache = array();
			foreach ($aFields as $sField)
			{
				if ($sPrefix !== null)
				{
					if ($sField == 'server_id')
					{
						$sField = 'user_' . $sPrefix . $sField;	
					}					
					else 
					{
						$sField = $sPrefix . $sField;
					}					
				}
				
				$aCache[$sField] = ($aUser === null ? Phpfox::getUserBy($sField) : $aUser[$sField]);
			}
			
			return $aCache;
		}
		
		return $aFields;	
	}	
	
	public function getSpamTotal()
	{
		return $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('user'))
			->where('total_spam > ' . (int) Phpfox::getParam('core.auto_deny_items'))
			->execute('getSlaveField');
	}
	
	public function getCredit()
	{
		static $sCredit = null;
		
		if ($sCredit === null)
		{
			if (Phpfox::getUserId())
			{
				$sCredit = $this->database()->select('uf.credit')
					->from(Phpfox::getT('user'), 'u')
					->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id')
					->where('u.user_id = ' . Phpfox::getUserId())
					->execute('getSlaveField');
			}
			else 
			{
				$sCredit = '0.00';
			}
		}
		
		return $sCredit;
	}
	
	public function getCurrency()
	{
		static $sCredit = null;
		if ($sPlugin = Phpfox_Plugin::get('user.service_user_getcurrency__1')){eval($sPlugin); if (isset($mReturnFromPlugin)){ return $mReturnFromPlugin; }}
        
		if ($sCredit === null)
		{
			if (Phpfox::getUserId())
			{
				$sCacheId = $this->cache()->set(array('currency', Phpfox::getUserId()));
				if (!($sCredit = $this->cache()->get($sCacheId)))
				{
					$sCredit = $this->database()->select('uf.default_currency')
						->from(Phpfox::getT('user'), 'u')
						->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id')
						->where('u.user_id = ' . Phpfox::getUserId())
						->execute('getSlaveField');
					
					if ($sCredit === null)
					{
						$sCredit = $this->database()->select('currency_id')
							->from(Phpfox::getT('currency'))
							->where('is_active = 1 AND is_default = 1')
							->execute('getField');
					}
					
					$this->cache()->save($sCacheId, $sCredit);
				}
			}
			else 
			{
				$sCredit = false;
			}
		}
		
		if ($sCredit == null)
		{
			return $this->database()->select('currency_id')
			    ->from(Phpfox::getT('currency'))
			    ->where('is_active = 1 AND is_default = 1')
			    ->execute('getField'); 
		}
		
		return $sCredit;
	}	
	
	public function isAdminUser($iUserId)
	{
		if (ADMIN_USER_ID == Phpfox::getUserBy('user_group_id'))
		{
			return false;
		}
		
		$sUserGroupId = $this->database()->select('user_group_id')
			->from(Phpfox::getT('user'))
			->where('user_id = ' . (int) $iUserId)
			->execute('getField');
		
		if ($sUserGroupId == ADMIN_USER_ID)
		{
			return true;
		}
			
		return false;
	}
	
	public function getProfileBirthDate($aUser)
	{
		static $aUserDetails = null;
		
		if (is_array($aUserDetails))
		{
			return $aUserDetails;
		}
		
		if ($aUserDetails === null)
		{
			$aUserDetails = array();
		}
		
		if (isset($aUser['dob_setting']) && !empty($aUser['birthday']) && $aUser['dob_setting'] != '3')
		{
			$aBirthDay = Phpfox::getService('user')->getAgeArray($aUser['birthday_time_stamp']);
			$sDateExtra = '';			
			
			// Take the adminCP setting user.default_privacy_brithdate
			if ($aUser['dob_setting'] == 0)
			{
				switch(Phpfox::getParam('user.default_privacy_brithdate'))
				{
					case 'show_age':
						$aUser['dob_setting'] = 2; break;
					case 'full_birthday':
						$aUser['dob_setting'] = 4; break;
					case 'month_day':
						$aUser['dob_setting'] = 1; break;
				}
			}
			
			$sPhrase = Phpfox::getPhrase('user.birth_date');
			switch($aUser['dob_setting'])
			{
				case '1':					
					$sDateExtra = Phpfox::getTime(Phpfox::getParam('user.user_dob_month_day'), mktime(0, 0, 0, $aBirthDay['month'], $aBirthDay['day'], $aBirthDay['year']), false);
					break;	
				case '2':
					$sDateExtra = $aUser['birthday'];
					$sPhrase = Phpfox::getPhrase('profile.age');
					break;
				default:
					$sDateExtra = Phpfox::getTime(Phpfox::getParam('user.user_dob_month_day_year'), mktime(0, 0, 0, $aBirthDay['month'], $aBirthDay['day'], $aBirthDay['year']), false);
					break;
			}
			$aUserDetails[$sPhrase] = $sDateExtra;
		}	
		
		return $aUserDetails;
	}


	/**
	 * Gets the count for how many members have been inactive since $iDyas
	 * @param int $iDays
	 * @return int inactive members since $iDays
	 */
	public function getInactiveMembersCount($iDays)
	{
		$iDays = (int)$iDays;
		
		$iCnt = $this->database()->select('COUNT(user_id)')
			->from(Phpfox::getT('user'))					
			->where('profile_page_id = 0 AND last_login < ' .(PHPFOX_TIME - ($iDays * 86400)))
			->execute('getSlaveField');
		
		return $iCnt;
	}

	public function getUserImages()
	{
		$sCacheId = $this->cache()->set(array('user', 'user_welcome_image'));
		
		if (!($aRows = $this->cache()->get($sCacheId, 60)))
		{
			$aRows = $this->database()->select(Phpfox::getUserField())
				->from(Phpfox::getT('user'), 'u')
				->where('is_invisible != 1 AND u.status_id = 0 AND u.view_id = 0 AND ' . $this->database()->isNotNull('u.user_image'))
				->limit(70)
				->order('u.last_activity DESC')
				->execute('getSlaveRows');
			
			$this->cache()->save($sCacheId, $aRows);
		}
		
		return $aRows;
	}
	
	public function getSpamQuestions()
	{
		$aQuestions = $this->database()->select('*')
			->from(Phpfox::getT('user_spam'))
			->execute('getSlaveRows');
		
		
		foreach ($aQuestions as $iKey => $aQuestion)
		{			
			$aQuestions[$iKey]['answers_phrases'] = json_decode($aQuestion['answers_phrases']);
		}
		
		
		return $aQuestions;
	}
	
	public function getInfoForAction($aItem)
	{
		if (is_numeric($aItem))
		{
			$aItem = array('item_id' => $aItem);
		}
		$aRow = $this->database()->select('us.status_id, us.content as title, us.user_id, u.gender, u.user_name, u.full_name')	
			->from(Phpfox::getT('user_status'), 'us')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = us.user_id')
			->where('us.status_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
						
		$aRow['link'] = Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('status_id' => $aRow['status_id']));
		return $aRow;
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_user__call'))
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
