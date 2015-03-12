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
 * @package  		Module_Group
 * @version 		$Id: group.class.php 2710 2011-07-06 20:22:23Z Raymond_Benc $
 */
class Group_Service_Group extends Phpfox_Service 
{
	private $_aGroup = null;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('group');
	}
	
	public function getGroup($sGroup, $bUseId = false)
	{		
		if (Phpfox::isUser())
		{
			$this->database()->select('ei.invite_id, ei.member_id, ei.is_admin, ')->leftJoin(Phpfox::getT('group_invite'), 'ei', 'ei.group_id = e.group_id AND ei.invited_user_id = ' . Phpfox::getUserId());
		}
		
		$this->_aGroup = $this->database()->select('e.*, ' . (Phpfox::getParam('core.allow_html') ? 'et.description_parsed' : 'et.description') . ' AS description, ' . Phpfox::getUserField() . ', ts.style_id AS designer_style_id, ts.folder AS designer_style_folder, t.folder AS designer_theme_folder')
			->from($this->_sTable, 'e')		
			->join(Phpfox::getT('user'), 'u', 'u.user_id = e.user_id')
			->join(Phpfox::getT('group_text'), 'et', 'et.group_id = e.group_id')				
			->leftJoin(Phpfox::getT('theme_style'), 'ts', 'ts.style_id = e.designer_style_id')
			->leftJoin(Phpfox::getT('theme'), 't', 't.theme_id = ts.theme_id')			
			->where('e.title_url = \'' . $this->database()->escape($sGroup) . '\'')
			->execute('getRow');		
		
		if (!isset($this->_aGroup['group_id']))
		{
			return false;
		}		
		
		if (!Phpfox::isUser())
		{
			$this->_aGroup['invite_id'] = 0;
			$this->_aGroup['member_id'] = 0;
			$this->_aGroup['is_admin'] = 0;
		}
		
		$this->_aGroup['breadcrumb'] = Phpfox::getService('group.category')->getCategoriesById($this->_aGroup['group_id']);
		$this->_aGroup['bookmark_url'] = Phpfox::getLib('url')->makeUrl('group', $this->_aGroup['title_url']);			

		return $this->_aGroup;
	}	
	
	public function getMyGroups($iUserId)
	{		
		$aGroups = $this->database()->select('g.group_id, g.view_id, g.title, gio.invite_id, gi.is_admin')
			->from(Phpfox::getT('group_invite'), 'gi')
			->join($this->_sTable, 'g', 'g.group_id = gi.group_id')
			->leftJoin(Phpfox::getT('group_invite'), 'gio', 'gio.group_id = gi.group_id AND gio.invited_user_id = ' . (int) $iUserId)
			->where('gi.member_id = 1 AND gi.invited_user_id = ' . (int) Phpfox::getUserId())
			->execute('getSlaveRows');
		
		foreach ($aGroups as $iKey => $aGroup)
		{
			if ($aGroup['view_id'] == '2' && $aGroup['is_admin'] != '1')
			{
				unset($aGroups[$iKey]);
			}
			
			if ($aGroup['invite_id'])
			{
				unset($aGroups[$iKey]);
			}
		}
			
		return $aGroups;
	}
	
	public function getForEdit($iId)
	{
		$aGroup = $this->database()->select('e.*, et.description')
			->from($this->_sTable, 'e')		
			->join(Phpfox::getT('group_text'), 'et', 'et.group_id = e.group_id')	
			->where('e.group_id = ' . (int) $iId)
			->execute('getRow');
			
		if (($aGroup['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin($aGroup['group_id']))
		{			
			$aGroup['categories'] = Phpfox::getService('group.category')->getCategoryIds($aGroup['group_id']);
				
			return $aGroup;
		}
		
		return false;
	}	
	
	public function getAdmins($iGroup)
	{
		static $aAdmins = null;
		
		if ($aAdmins === null)
		{
			$aAdmins = $this->database()->select(Phpfox::getUserField() . ', g.user_id AS creator_id')
				->from(Phpfox::getT('group_invite'), 'gi')
				->join(Phpfox::getT('group'), 'g', 'g.group_id = gi.group_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = gi.invited_user_id')
				->where('gi.group_id = ' . (int) $iGroup . ' AND gi.is_admin = 1')				
				->execute('getSlaveRows');
				
			$aCache = array();
			foreach ($aAdmins as $iKey => $aAdmin)
			{
				if ($aAdmin['creator_id'] == $aAdmin['user_id'])
				{
					$aCache[] = $aAdmin;
					
					unset($aAdmins[$iKey]);
					
					break;
				}
			}
				
			$aAdmins = array_merge($aCache, $aAdmins);				
		}
		
		return $aAdmins;
	}
	
	public function getMembers($iGroup, $iType, $iPage = 0, $iPageSize = 8, $bIsAdmin = false)
	{
		$aInvites = array();
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('group_invite'))
			->where('group_id = ' . (int) $iGroup . ' AND member_id = ' . (int) $iType . ($bIsAdmin ? ' AND is_admin = 1' : ''))
			->execute('getSlaveField');
		
		if ($iCnt)
		{
			$aInvites = $this->database()->select('ei.*, ' . Phpfox::getUserField())
				->from(Phpfox::getT('group_invite'), 'ei')
				->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = ei.invited_user_id')
				->where('ei.group_id = ' . (int) $iGroup . ' AND ei.member_id = ' . (int) $iType . ($bIsAdmin ? ' AND is_admin = 1' : ''))
				->limit($iPage, $iPageSize, $iCnt)
				->order('ei.invite_id DESC')
				->execute('getSlaveRows');
		}
			
		return array($iCnt, $aInvites);
	}	
	
	public function getForProfileBlock($iUserId, $iLimit = 5)
	{		
		$aCond = array();
		$aCond[] = 'm.view_id IN(0,1)';
		if (Phpfox::getParam('group.group_profile_display') == 'both')
		{
			$this->database()->join(Phpfox::getT('group_invite'), 'ei', 'ei.group_id = m.group_id AND ei.member_id = 1 AND ei.invited_user_id = ' . (int) $iUserId);
		}
		else 
		{
			$aCond[] = ' AND m.user_id = ' . (int) $iUserId;
		}
		
		$aRows = $this->database()->select('m.title, m.title_url, m.short_description, m.time_stamp, m.image_path, m.server_id, m.total_member')
			->from($this->_sTable, 'm')			
			->where($aCond)
			->limit($iLimit)
			->order('m.time_stamp DESC')
			->execute('getSlaveRows');
			
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['group_url'] = Phpfox::getLib('url')->makeUrl('group', array($aRow['title_url'], 'member'));
		}
			
		return $aRows;
	}
	
	public function isAdmin($iGroupId)
	{
		static $aCache = null;
		
		if (Phpfox::getUserParam('group.can_manage_all_groups'))
		{
			return true;		
		}		
		
		if ($aCache === null)
		{
			$aCache = $this->database()->select('gi.is_admin, g.group_id')
				->from($this->_sTable, 'g')
				->join(Phpfox::getT('group_invite'), 'gi', 'gi.group_id = g.group_id AND gi.invited_user_id = ' . Phpfox::getUserId())
				->where('g.group_id = ' . (int) $iGroupId)
				->execute('getRow');			
		}
		
		if (!isset($aCache['group_id']))
		{
			return false;
		}		
		
		return ($aCache['is_admin'] ? true : false);
	}

	public function hasAccess($iGroupId, $sParam, $bMustBeMember = false)
	{
		if ($this->_aGroup === null)
		{
			$this->getGroup($iGroupId, true);
		}
		
		if (Phpfox::getUserParam('group.can_manage_all_groups'))
		{
			return true;		
		}			
		
		if (Phpfox::getUserParam('group.can_view_secret_group'))
		{
			return true;		
		}
		
		if (!isset($this->_aGroup['group_id']))
		{
			return false;
		}
		
		if ($bMustBeMember === true && $this->_aGroup['member_id'] != '1')
		{
			return false;
		}
		
		if ($this->_aGroup['view_id'] == '1' && (!$this->_aGroup['invite_id'] || ($this->_aGroup['invite_id'] && $this->_aGroup['member_id'] == '2')))
		{
			return false;
		}
		
		if ($this->_aGroup['view_id'] == '2' && (!$this->_aGroup['invite_id'] || ($this->_aGroup['invite_id'] && $this->_aGroup['member_id'] == '0')))
		{
			return false;
		}
		
		if ($this->_aGroup['view_id'] == '0')
		{
			static $aCache = null;
			
			if ($aCache === null)
			{
				$aCache = array();
				$aRows = $this->database()->select('var_name, access_value')
					->from(Phpfox::getT('group_access'))
					->where('group_id = ' . (int) $iGroupId)
					->execute('getRows');
				foreach ($aRows as $aRow)
				{
					$aCache[$aRow['var_name']] = (int) $aRow['access_value'];
				}
			}
			
			if (isset($aCache[$sParam]))
			{			
				if ($aCache[$sParam] === 2 && $this->_aGroup['member_id'] != '1')
				{
					return false;
				}
				elseif ($aCache[$sParam] === 3 && !$this->_aGroup['is_admin'])
				{
					return false;
				}
			}
		}
		
		return true;
	}
	
	public function checkAccess($iGroupId, $sVarName)
	{
		static $aCache = null;
			
		if ($aCache === null)
		{
			$aCache = array();
			$aRows = $this->database()->select('var_name, access_value')
				->from(Phpfox::getT('group_access'))
				->where('group_id = ' . (int) $iGroupId)
				->execute('getRows');
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['var_name']] = (int) $aRow['access_value'];
			}
		}
		
		return (isset($aCache[$sVarName]) ? (int) $aCache[$sVarName] : false);
	}
	
	public function getPopular()
	{
		$sCacheId = $this->cache()->set('group_popular');
		
		if (!($aGroups = $this->cache()->get($sCacheId, Phpfox::getParam('group.popular_group_cache'))))
		{
			$aGroups = $this->database()->select('*')
				->from($this->_sTable)
				->where('view_id IN(0,1)')
				->order('total_member DESC')
				->limit(Phpfox::getParam('group.limit_popular_groups'))
				->execute('getRows');
				
			$this->cache()->save($sCacheId, $aGroups);
		}
			
		return $aGroups;
	}

	public function getRandomSponsored()
	{
		if (!Phpfox::isModule('ad'))
		{
			return array();
		}
		$sCacheId = $this->cache()->set('group_sponsored');
		if (!($aGroups = $this->cache()->get($sCacheId)))
		{
			$aGroups = $this->database()->select('s.*, s.country_iso AS sponsor_country_iso, g.*')
				->from($this->_sTable,'g')
				->join(Phpfox::getT('ad_sponsor'), 's', 's.item_id = g.group_id')
				->where('is_sponsor = 1 AND s.module_id = "group"')
				->execute('getSlaveRows');
			$this->cache()->save($sCacheId, $aGroups);
		}
		$aGroups = Phpfox::getService('ad')->filterSponsor($aGroups);
		if (empty($aGroups) || !is_array($aGroups))
		{
			return array();
		}
		foreach ($aGroups as $iKey => $aGroup)
		{
			$aGroups[$iKey]['categories'] = Phpfox::getService('group.category')->getCategoriesById($aGroup['group_id']);
		}

		$iRand = rand(0, count($aGroups)-1);
		
		Phpfox::getService('ad.process')->addSponsorViewsCount($aGroups[$iRand]['group_id'],'group');
		return $aGroups[$iRand];
	}

	public function modifyGroupAccess($iGroup = null, $bPosting = false)
	{
		if ($iGroup !== null)
		{
			$aAccess = array();
			$aRows = $this->database()->select('var_name, access_value')
				->from(Phpfox::getT('group_access'))
				->where('group_id = ' . (int) $iGroup)
				->execute('getRows');
			foreach ($aRows as $aRow)
			{
				$aAccess[$aRow['var_name']] = (int) $aRow['access_value'];
			}					
		}
		
		$aCallbacks = Phpfox::massCallback(($bPosting ? 'getGroupPosting' : 'getGroupAccess'));
		$aCache = array();
		foreach ($aCallbacks as $sModule => $aRows)
		{
			foreach ($aRows as $sPhrase => $sParam)
			{
				$aCache[] = array(
					'phrase' => $sPhrase,
					'param' => $sParam,
					'value' => ($iGroup === null ? null : (isset($aAccess[$sParam]) ? $aAccess[$sParam] : null))
				);
			}
		}
		
		return $aCache;
	}
	
	public function getGroupIdFromInviteId($iInviteId)
	{
		return $this->database()->select('group_id')
			->from(Phpfox::getT('group_invite'))
			->where('invite_id = ' . (int) $iInviteId . ' AND invited_user_id = ' . Phpfox::getUserId())
			->execute('getSlaveField');
	}
	
	public function getInvites()
	{
		$aGroups = $this->database()->select('g.*, gi.invite_id, ' . Phpfox::getUserField())
			->from(Phpfox::getT('group_invite'), 'gi')			
			->join(Phpfox::getT('group'), 'g', 'g.group_id = gi.group_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = g.user_id')
			->where('gi.member_id != 1 AND gi.invited_user_id = ' . Phpfox::getUserId())
			->execute('getSlaveRows');
			
		return $aGroups;
	}
	
	public function isAlreadyInvited($iItemId, $aFriends)
	{
		if ((int) $iItemId === 0)
		{
			return false;
		}
		
		if (is_array($aFriends))
		{
			if (!count($aFriends))
			{
				return false;
			}			
			
			$sIds = '';
			foreach ($aFriends as $aFriend)
			{
				if (!isset($aFriend['user_id']))
				{
					continue;
				}
				
				$sIds[] = $aFriend['user_id'];
			}			
			
			$aInvites = $this->database()->select('invite_id, member_id, invited_user_id')
				->from(Phpfox::getT('group_invite'))
				->where('group_id = ' . (int) $iItemId . ' AND invited_user_id IN(' . implode(', ', $sIds) . ')')
				->execute('getSlaveRows');
			
			$aCache = array();
			foreach ($aInvites as $aInvite)
			{
				$aCache[$aInvite['invited_user_id']] = ($aInvite['member_id'] ? Phpfox::getPhrase('group.member') : Phpfox::getPhrase('group.invited')); // new phrases for http://forums.phpfox.com/project.php?issueid=5240
			}
			
			if (count($aCache))
			{
				return $aCache;
			}
		}
		
		return false;
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
		if ($sPlugin = Phpfox_Plugin::get('group.service_group__call'))
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