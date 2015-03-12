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
 * @version 		$Id: forum.class.php 6865 2013-11-07 13:57:44Z Miguel_Espinoza $
 */
class Forum_Service_Forum extends Phpfox_Service 
{
	private $_aForums = array();
	
	private $_aLive = array();
	
	private $_iForumId = null;
	
	private $_aBuild = array();
	
	private $_iActive = null;	
	
	private $_aBreadcrumbs = array();
	
	private $_sParentList = '';
	
	private $_sChildren = '';
	
	private $_bIsFirst = false;
	
	private $_bHasCategory = false;
	
	private $_aStat = array(
		'thread' => 0,
		'post' => 0
	);
	
	private $_iEditId = 0;

	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('forum');	
	}
	
	public function id($iForumId)
	{
		$this->_iForumId = $iForumId;
		
		return $this;
	}
	
	public function live()
	{
		if (Phpfox::getParam('forum.forum_database_tracking'))
		{
			$this->database()->select('ftrack.forum_id AS is_seen, ftrack.time_stamp AS last_seen_time, ')->leftJoin(Phpfox::getT('forum_track'), 'ftrack', 'ftrack.forum_id = f.forum_id AND ftrack.user_id = ' . Phpfox::getUserId());
		}		

	$aLiveForums = $this->database()->select('f.forum_id, f.thread_id, f.total_thread, f.total_post, f.post_id, ft.title AS thread_title, ft.title_url AS thread_title_url, ft.time_update AS thread_time_stamp, ' . Phpfox::getUserField())		
			->from($this->_sTable, 'f')
			->leftJoin(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = f.thread_id')
			->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = f.last_user_id')
			->where('f.view_id = 0')
			->execute('getRows');
			
		foreach ($aLiveForums as $aForum)
		{
			$this->_aLive[$aForum['forum_id']] = $aForum;
		}

		return $this;	
	}
	
	public function first()
	{
		$this->_bIsFirst = true;
		
		return $this;
	}
	
	public function hasCategory()
	{
		return $this->_bHasCategory;
	}

	public function active($iActive)
	{
		$this->_iActive = $iActive;		
		
		return $this;
	}
	
	public function edit($iId)
	{
		$this->_iEditId = $iId;		
		
		return $this;
	}	
	
	public function getJumpTool($bIdOnly = false, $bIsEditing = false)
	{		
		return $this->_getFromCache()->_buildJump(0, $bIdOnly, 0, $bIsEditing);		
	}
	
	public function getAdminCpList()
	{		
		return $this->_getFromCache()->_buildAdminCp(0);		
	}	
	
	public function getForums()
	{		
		$aForums = $this->_getFromCache()->_buildForum(0);		
		
		$this->_aLive = array();
		
		if ($this->_iForumId !== null && isset($this->_aBuild[$this->_iForumId]))
		{			
			return $this->_aBuild[$this->_iForumId]['sub_forum'];
		}
				
		return $aForums;	
	}
	
	public function getChildren()
	{
		$this->_getFromCache();
		
		$this->_sChildren = '';
		$this->_getChildren($this->_iForumId);
		$this->_sChildren = rtrim($this->_sChildren, ',');
		
		if (empty($this->_sChildren))
		{
			return false;
		}
		
		return explode(',', $this->_sChildren);
	}	
	
	public function getParents()
	{
		$this->_getFromCache();
		
		$this->_sParentList = '';	
		
		if ($this->_aForums[$this->_iForumId]['parent_id'] > 0)
		{
			$this->_getParents($this->_aForums[$this->_iForumId]['parent_id']);	
		}		
		$this->_sParentList .= $this->_aForums[$this->_iForumId]['forum_id'];
		
		return explode(',', $this->_sParentList);
	}
	
	public function getForum()
	{
		$this->_getFromCache();
		
		if (!isset($this->_aForums[$this->_iForumId]))
		{
			return false;
		}
		
		$aForum = $this->_aForums[$this->_iForumId];
		$aForum['breadcrumb'] = array();
		
		if ($aForum['parent_id'] > 0)
		{
			$this->_getBreadcrumb($aForum['parent_id']);
			
			$aForum['breadcrumb'] = $this->_aBreadcrumbs;
		}	
		
		return $aForum;
	}
	
	public function getStats()
	{		
		return $this->_aStat;
	}
	
	public function getForumUrl($iId)
	{
		return $this->database()->select('name_url')
			->from($this->_sTable)
			->where('forum_id = ' . (int) $iId)
			->execute('getField');
	}
	
	public function getForEdit($iId)
	{
		return $this->database()->select('*')
			->from($this->_sTable)
			->where('forum_id = ' . (int) $iId)
			->execute('getRow');
	}
	
	public function getSearchFilter($bIsSearchQuery = false)		
	{
		$aPages = array(20, 25, 30, 35, 40, 45, 50);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}			
		
		$aSorts = array(
			'ft.time_update' => Phpfox::getPhrase('forum.post_time'),
			'u.full_name' => Phpfox::getPhrase('forum.author'),
			'ft.total_post' => Phpfox::getPhrase('forum.replies'),
			'ft.title' => Phpfox::getPhrase('forum.subject'),
			'ft.total_view' => Phpfox::getPhrase('forum.views')
		);
		
		$aFilters = array(
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '20'
			),
			'sort' => array(
				'type' => 'select',
				'options' => $aSorts,
				'default' => 'ft.time_update'
			),
			'sort_by' => array(
				'type' => 'select',
				'options' => array(
					'DESC' => Phpfox::getPhrase('core.descending'),
					'ASC' => Phpfox::getPhrase('core.ascending')
				),
				'default' => 'DESC'
			),
			'keyword' => array(
				'type' => 'input:text',
				'size' => '40'
			),
			'user' => array(
				'type' => 'input:text',
				'size' => '40'
			),
			'result' => array(
				'type' => 'input:radio',
				'options' => array(
					'0' => Phpfox::getPhrase('forum.threads'),
					'1' => Phpfox::getPhrase('forum.posts')
				)				
			),
			'days_prune' => array(
				'type' => 'select',
				'options' => array(
					'1' => Phpfox::getPhrase('forum.last_day'),
					'2' => Phpfox::getPhrase('forum.last_2_days'),	
					'7' => Phpfox::getPhrase('forum.last_week'),
					'10' => Phpfox::getPhrase('forum.last_10_days'),
					'14' => Phpfox::getPhrase('forum.last_2_weeks'),
					'30' => Phpfox::getPhrase('forum.last_month'),
					'45' => Phpfox::getPhrase('forum.last_45_days'),
					'60' => Phpfox::getPhrase('forum.last_2_months'),
					'75' => Phpfox::getPhrase('forum.last_75_days'),
					'100' => Phpfox::getPhrase('forum.last_100_days'),
					'365' => Phpfox::getPhrase('forum.last_year'),
					'-1' => Phpfox::getPhrase('forum.beginning')
				),
				'default_view' => '-1'
			)
		);
		
		$aSettings = array(
			'type' => 'forum',
			'filters' => $aFilters,
			'cache' => true,
			'field' => array(
				'depend' => 'result',
				'fields' => array('fp.post_id', 'ft.thread_id')
			)
		);
		
		if ($bIsSearchQuery)
		{
			$aSettings['search'] = array(
				'keyword',
				'user'
			);
		}
		
		return Phpfox::getLib('search')->set($aSettings);			
	}
	
	public function getForRss($iId)
	{
		$aForum = $this->id($iId)->getForum();
		
		if ($aForum === false)
		{
			return false;
		}		
		
		$aItems = Phpfox::getService('forum.thread')->getForRss(Phpfox::getParam('rss.total_rss_display'), ($aForum['forum_id'] . (is_array($this->getChildren()) ? ',' . implode(',', $this->getChildren()) : '')));
		
		$aRss = array(
			'href' => Phpfox::getLib('url')->makeUrl('forum', array($aForum['name_url'])),
			'title' => Phpfox::getPhrase('forum.latest_threads_in') . ': ' . $aForum['name'],
			'description' => Phpfox::getPhrase('forum.latest_threads_on') . ': ' . Phpfox::getParam('core.site_title'),
			'items' => $aItems
		);		
		
		return $aRss;
	}

	/**
	 * Get all the user group forum access params.
	 *
	 * @return array
	 */
	public function getAccess()
	{
		$aPerms = array(
			'can_view_forum' => array(
				'phrase' => Phpfox::getPhrase('forum.can_view_forum'),
				'value' => true
			),
			'can_view_thread_content' => array(
				'phrase' => Phpfox::getPhrase('forum.can_view_thread_content'),
				'value' => true
			)			
		);
		
		if ($sPlugin = Phpfox_Plugin::get('forum.service_forum_getaccess'))
		{
			eval($sPlugin);
		}			
		
		return $aPerms;
	}
	
	public function isPrivateForum($iForumId)
	{
		$aUserGroups = $this->database()->select('user_group_id')
			->from(Phpfox::getT('user_group'))
			->execute('getSlaveRows');	
		$aPerms = array();
		foreach ($aUserGroups as $aUserGroup)
		{
			$aPerms[] = $this->getUserGroupAccess($iForumId, $aUserGroup['user_group_id']);
		}
		
		$bIsPrivate = false;
		foreach ($aPerms as $aPerm)
		{
			if (!$aPerm['can_view_forum']['value'])	
			{
				$bIsPrivate = true;
				break;	
			}
		}
		
		return $bIsPrivate;
	}
	
	/**
	 * Get user group access for a specific user group and forum.
	 *
	 * @param int $iForumId Forum ID#
	 * @param int $iUserGroupId User gropu ID#
	 * @return array
	 */
	public function getUserGroupAccess($iForumId, $iUserGroupId)
	{
		$aPerms = $this->getAccess();
		$aRows = $this->database()->select('forum_id, var_name, var_value')
			->from(Phpfox::getT('forum_access'))
			->where('forum_id = ' . (int) $iForumId . ' AND user_group_id = ' . (int) $iUserGroupId)
			->execute('getSlaveRows');
		 foreach ($aRows as $aRow)
		 {
		 	$aPerms[$aRow['var_name']]['value'] = $aRow['var_value'];
		 }
		
		return $aPerms;
	}
	
	/**
	 * Get a specific access rule based on the user group of the user.
	 *
	 * @param string $sVar Variable for the rule.
	 * @return bool|string FALSE if rule does not exist.|String of forum ID# if rule exists.
	 */
	public function getCanViewForumAccess($sVar)
	{
		$sForums = '';
		$aRows = $this->database()->select('forum_id, var_value')
			->from(Phpfox::getT('forum_access'))
			->where('user_group_id = ' . (int) Phpfox::getUserBy('user_group_id') . ' AND var_name = \'' . $sVar . '\'')
			->execute('getSlaveRows');
		foreach ($aRows as $aRow)
		{
			if (!$aRow['var_value'])
			{
				$sForums .= $aRow['forum_id'] . ',';
			}
		}
		$sForums = rtrim($sForums, ',');
		
		return (empty($sForums) ? false : $sForums);
	}
	
	/**
	 * Checks if a user has access to a forum based on their user group and on the
	 * variable that represents the feature they are trying to use.
	 *
	 * @param int $iForumId Forum ID#
	 * @param string $sVar Variable name for the rule.
	 * @return bool TRUE if can use the feature, FALSE if user cannot use the feature.
	 */
	public function hasAccess($iForumId, $sVar)
	{
		static $aForumPerms = array();
		
		if (!isset($aForumPerms[$iForumId][Phpfox::getUserBy('user_group_id')]))
		{
			$aPerms = array();
			$sCacheId = $this->cache()->set('forum_group_permission_' . Phpfox::getUserBy('user_group_id') . '_' . $iForumId);
			if (!($aPerms = $this->cache()->get($sCacheId)))
			{
				$aUserGroupPerms = array();
				$aRows = $this->database()->select('*')
					->from(Phpfox::getT('forum_access'))
					->where('forum_id = ' . (int) $iForumId . ' AND user_group_id = ' . (int) Phpfox::getUserBy('user_group_id'))
					->execute('getSlaveRows');
				foreach ($aRows as $aRow)
				{
					$aUserGroupPerms[$aRow['var_name']] = ($aRow['var_value'] ? true : false);
				}
				
				foreach ($this->getAccess() as $sPerm => $aPerm)
				{
					if (isset($aUserGroupPerms[$sPerm]))
					{
						$aPerms[$sPerm] = $aUserGroupPerms[$sPerm];
						
						continue;
					}
					
					$aPerms[$sPerm] = $aPerm['value'];
				}		
				
				$this->cache()->save($sCacheId, $aPerms);
			}
			
			if ($sPlugin = Phpfox_Plugin::get('forum.service_forum_hasaccess'))
			{
				eval($sPlugin);
			}			
			
			$aForumPerms[$iForumId][Phpfox::getUserBy('user_group_id')] = $aPerms;
		}
		
		(($sPlugin = Phpfox_Plugin::get('forum.service_forum_hasaccess_check')) ? eval($sPlugin) : false);
		
		if (isset($bForceReturn))
		{
			return $bForceReturn;
		}
		
		return $aForumPerms[$iForumId][Phpfox::getUserBy('user_group_id')][$sVar];
	}
	
	public function buildMenu()
	{		
		$aFilterMenu = array(
			Phpfox::getPhrase('forum.forums') => '',
			Phpfox::getPhrase('forum.new_posts') => 'forum.search.view_new',
			Phpfox::getPhrase('forum.my_threads') => 'forum.search.view_my-thread',
			Phpfox::getPhrase('forum.subscribed_threads') => 'forum.search.view_subscribed'			
		);
		
		if (Phpfox::getUserParam('forum.can_approve_forum_thread'))
		{
			$aFilterMenu[] = true;
			
			$iPendingThreads = Phpfox::getService('forum.thread')->getPendingThread();
			if ($iPendingThreads)
			{
				$aFilterMenu[Phpfox::getPhrase('forum.pending_threads') . ' <span class="pending">' . $iPendingThreads . '</span>'] = 'forum.search.view_pending-thread';
			}			
			
			$iPendingPosts = Phpfox::getService('forum.post')->getPendingPost();
			if ($iPendingPosts)
			{
				$aFilterMenu[Phpfox::getPhrase('forum.pending_posts') . ' <span class="pending">' . $iPendingPosts . '</span>'] = 'forum.search.view_pending-post';
			}
		}
		
		Phpfox::getLib('template')->buildSectionMenu('forum', $aFilterMenu);			
	}
	
	private function _getParents($iId)
	{
		if (isset($this->_aForums[$iId]))
		{			
			if ($this->_aForums[$iId]['parent_id'] > 0)
			{
				$this->_getParents($this->_aForums[$iId]['parent_id']);	
			}
			$this->_sParentList .= $this->_aForums[$iId]['forum_id'] . ',';	
		}
	}
	
	private function _getBreadcrumb($iId)
	{
		if (isset($this->_aForums[$iId]))
		{			
			if ($this->_aForums[$iId]['parent_id'] > 0)
			{
				$this->_getBreadcrumb($this->_aForums[$iId]['parent_id']);	
			}
			$this->_aBreadcrumbs[] = array(Phpfox::getLib('locale')->convert($this->_aForums[$iId]['name']), Phpfox::getLib('url')->permalink('forum', $this->_aForums[$iId]['forum_id'], $this->_aForums[$iId]['name']));		
		}
	}
	
	private function _buildAdminCp($iForumId)
	{
		static $iCnt = 0;
		
		if ($iCnt === 0 && !count($this->_aForums))
		{
			return false;
		}		
		
		$sHtml = '<ul>' . "\n";			
		foreach ($this->_aForums as $aForum)
		{			
			if ($aForum['parent_id'] != $iForumId)
			{
				continue;
			}	

			$iCnt++;		
					
			$sHtml .= '<li><img src="' . Phpfox::getLib('template')->getStyle('image', 'misc/draggable.png') . '" alt="" /> <input type="hidden" name="order[' . $aForum['forum_id'] . ']" value="' . $iCnt . '" /> <a href="#?id=' . $aForum['forum_id'] . '" class="js_drop_down">' . Phpfox::getLib('locale')->convert($aForum['name']) . '</a>';
			$sHtml .= $this->_buildAdminCp($aForum['forum_id']) . '</li>' . "\n";			
		}
		$sHtml .= '</ul>' . "\n";
		
		return $sHtml;
	}	
	
	private function _buildJump($iForumId, $bIdOnly, $iCnt = 0, $bIsEditing = false)
	{		
		$sOptions = '';	
		
		foreach ($this->_aForums as $aForum)
		{			
			if ((int) $this->_iEditId > 0 && $this->_iEditId == $aForum['forum_id'])
			{
				continue;
			}
			
			if ($aForum['parent_id'] != $iForumId)
			{
				continue;
			}	
			
			if (!Phpfox::getService('forum')->hasAccess($aForum['forum_id'], 'can_view_forum'))
			{
				continue;
			}			
			
			$sExt = '';
			for ($i = 0; $i < $iCnt; $i++)
			{
				$sExt .= '&nbsp;&nbsp;&nbsp;';
			}			
			$sOptions .= '<option value="' . ($bIdOnly ? $aForum['forum_id'] : Phpfox::getLib('url')->permalink('forum', $aForum['forum_id'], $aForum['name'])) . '"' . ($this->_iActive == $aForum['forum_id'] ? ' selected="selected"' : '') . '>' . $sExt . Phpfox::getLib('locale')->convert($aForum['name']) . '</option>' . "\n";
			$sOptions .= $this->_buildJump($aForum['forum_id'], $bIdOnly, ($iCnt + 1));
		}
		
		return $sOptions;
	}
	
	private function _buildForum($iForumId)
	{	
		$oUrl = Phpfox::getLib('url');		
		$aForums = array();
		foreach ($this->_aForums as $aForum)
		{			
			if ($aForum['parent_id'] != $iForumId)
			{
				continue;
			}

			if (!Phpfox::getService('forum')->hasAccess($aForum['forum_id'], 'can_view_forum'))
			{
				continue;
			}
			
			if ($aForum['is_category'] && $this->_bHasCategory === false)
			{
				$this->_bHasCategory = true;
			}
								
			$aForum['sub_forum'] = $this->_buildForum($aForum['forum_id']);
			
			if (isset($this->_aLive[$aForum['forum_id']]))
			{				
				foreach ($this->_aLive[$aForum['forum_id']] as $sKey => $mValue)
				{
					if (isset($aForum[$sKey]))
					{						
						continue;
					}
					
					$aForum[$sKey] = $mValue;
				}
				
				if (!isset($aForum['is_seen']))
				{
					$aForum['is_seen'] = 0;
				}
				
				if (!$aForum['is_seen'])
				{					
					// User has signed up after the post so they have already seen the post
					if ((Phpfox::isUser() && Phpfox::getUserBy('joined') > $aForum['thread_time_stamp']) || (!Phpfox::isUser() && Phpfox::getCookie('visit') > $aForum['thread_time_stamp']))
					{
						$aForum['is_seen'] = 1;
					}
					elseif (($iLastTimeViewed = Phpfox::getLib('session')->getArray('forum_view', $aForum['thread_id'])) && (int) $iLastTimeViewed > $aForum['thread_time_stamp'])
					{						
						$aForum['is_seen'] = 1;
					}					
					// Checks if the post is older then our default active post time limit
					elseif (!empty($aForum['thread_time_stamp']) && ((PHPFOX_TIME - Phpfox::getParam('forum.keep_active_posts') * 60) > $aForum['thread_time_stamp']))
					{						
						$aForum['is_seen'] = 1;							
					}				
					elseif (!empty($aForum['thread_time_stamp']) && Phpfox::isUser() && $aForum['thread_time_stamp'] < Phpfox::getCookie('last_login'))
					{						
						$aForum['is_seen'] = 1;
					}
				}
				else 
				{					
					// New post was added
					if ($aForum['thread_time_stamp'] > $aForum['last_seen_time'])
					{
						$aForum['is_seen'] = 0;																
					}					
				}										
				
				if (!$aForum['parent_id'])
				{					
					$this->_aStat['thread'] += $aForum['total_thread'];				
					$this->_aStat['post'] += $aForum['total_post'];	
				}
			}
			
			if (isset($aForum['post_id']) && $aForum['post_id'])
			{
				$sLink = $oUrl->makeUrl('forum', array($aForum['name_url'] . '-' . $aForum['forum_id'], $aForum['thread_title_url'], 'post' => $aForum['post_id']));
			}
			else 
			{
				if (isset($aForum['thread_title_url']))
				{
					$sLink = $oUrl->makeUrl('forum', array($aForum['name_url'] . '-' . $aForum['forum_id'], $aForum['thread_title_url']));
				}
			}
			/*
			$aForum['last_posted_phrase'] = Phpfox::getPhrase('forum.by_user_link_on_time_stamp_phrase', array(
					'user' => $aForum,
					'link' => $sLink,
					'time_stamp_phrase' => Phpfox::getTime(Phpfox::getParam('forum.forum_time_stamp'), $aForum['thread_time_stamp'])
				)
			);
			*/
			$aForums[$aForum['forum_id']] = $aForum;
			
			if ($this->_iForumId !== null && $aForum['forum_id'] == $this->_iForumId)
			{
				$this->_aBuild[$aForum['forum_id']] = $aForum;
			}			
		}		
		
		return $aForums;
	}
			
	private function _getFromCache()
	{
		static $bIsSet = false;
		
		if ($bIsSet === true)
		{
			return $this;
		}
		
		$sCacheId = $this->cache()->set('forum');
		
		if (!($this->_aForums = $this->cache()->get($sCacheId)))
		{
			$aForums = $this->database()->select('f.forum_id, f.parent_id, f.view_id, f.is_category, f.name, f.name_url, f.description, f.is_closed')
				->from($this->_sTable, 'f')				
				->where('f.view_id = 0')
				->order('f.ordering ASC')
				->execute('getRows');
				
			foreach ($aForums as $aForum)
			{
				$aModerators = $this->database()->select(Phpfox::getUserField())
					->from(Phpfox::getT('forum_moderator'), 'fm')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = fm.user_id')
					->where('forum_id = ' . $aForum['forum_id'])
					->execute('getRows');
					
				foreach ($aModerators as $iModKey => $aModerator)
				{
					foreach ($aModerator as $sKey => $sValue)
					{
						$aForum['moderators'][$iModKey][$sKey] = $sValue;
					}
				}
				
				$this->_aForums[$aForum['forum_id']] = $aForum;
			}
			
			$this->cache()->save($sCacheId, $this->_aForums);
		}
		
		if (is_bool($this->_aForums))
		{
			$this->_aForums = array();
		}
		
		$bIsSet = true;
	
		return $this;
	}
	
	private function _getChildren($iParent)
	{
		foreach ($this->_aForums as $aForum)
		{
			if ($aForum['parent_id'] == $iParent)
			{
				$this->_sChildren .= $aForum['forum_id'] . ',';
				
				if ($this->_bIsFirst === false)
				{
					$this->_getChildren($aForum['forum_id']);
				}
			}
		}
	}
	
	public function getInfoForAction($aItem)
	{
		if (is_numeric($aItem))
		{
			$aItem = array('item_id' => $aItem);
		}
		$aRow = $this->database()->select('p.post_id, p.thread_id, p.title, pt.text_parsed, p.user_id, u.gender, u.full_name')	
			->from(PHpfox::getT('forum_post'), 'p')
			->join(Phpfox::getT('forum_post_text'), 'pt', 'pt.post_id = p.post_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('p.post_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
		
		if (empty($aRow['title']))
		{
			$aRow['title'] = $aRow['text_parsed'];
		}
		
		$aRow['link'] = Phpfox::getLib('url')->permalink('forum.thread', $aRow['thread_id'], $aRow['title']);
		return $aRow;
	}
	
	/**
	 * User groups may be denied access to specific forums. This function returns the forums for which this user group does not have access, 
	 * be it because cant view the forum or the contents of the threads. It is used in the controller forum.forum to filter searches by newest reply
	 */ 
	public function getForbiddenForums()
	{
		$aForums = $this->database()->select('forum_id')
			->from(Phpfox::getT('forum_access'))
			->where('var_value = 0 AND user_group_id = ' . Phpfox::getUserBy('user_group_id'))
			->execute('getSlaveRows');
		if (empty($aForums))
		{
			return array();
		}
		$aOut = array();
		foreach ($aForums as $aForum)
		{
			$aOut[] = $aForum['forum_id'];
		}
		return $aOut;
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_forum__call'))
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