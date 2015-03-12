<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Callbacks
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: callback.class.php 7164 2014-02-28 16:40:41Z Fern $
 */
class User_Service_Callback extends Phpfox_Service
{
	public function  __construct()
	{
		$this->_sTable = Phpfox::getT('user');
	}
	
	public function getActionsStatus()
	{
		return $this->getActions();	
	}
	
	// This function solves bug http://www.phpfox.com/tracker/view/14781/
	public function addLikePhoto($iItemId, $bDoNotSendEmail = false)
	{
		$this->database()->updateCount('like', 'type_id = \'user_photo\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'photo', 'photo_id = ' . (int) $iItemId);	
		return true;
	}
	
	// This function also solves bug http://www.phpfox.com/tracker/view/14781/
	public function deleteLikePhoto($iItemId, $bDoNotSendEmail = false)
	{
		$this->database()->updateCount('like', 'type_id = \'user_photo\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'photo', 'photo_id = ' . (int) $iItemId);	
		return true;
	}
	
	public function paymentApiCallback($aParams)
	{
		Phpfox::log('Module callback recieved: ' . var_export($aParams, true));
		
		$aRow = $this->database()->select('pp.*, ua.activity_points')
			->from(Phpfox::getT('point_purchase'), 'pp')
			->join(Phpfox::getT('user_activity'), 'ua', 'ua.user_id = pp.user_id')
			->where('pp.purchase_id = ' . (int) $aParams['item_number'])
			->execute('getSlaveRow');
		
		if (!isset($aRow['purchase_id']))
		{
			Phpfox::log('Unable to find this purchase.');
			
			return false;
		}
		
		if ($aParams['status'] == 'completed')
		{
			$iNewTotal = (int) ($aRow['activity_points'] + $aRow['total_point']);
			
			$this->database()->update(Phpfox::getT('point_purchase'), array('status' => '1'), 'purchase_id = ' . (int) $aRow['purchase_id']);
			$this->database()->update(Phpfox::getT('user_activity'), array('activity_points	' => $iNewTotal), 'user_id = ' . (int) $aRow['user_id']);
			
			Phpfox::log('Purchase completed. Giving the user #' . $aRow['user_id'] . ' ' . $iNewTotal . ' points.');
			
			return true;
		}
		
		Phpfox::log('Purchase was not paid.');
		
		return false;
	}
	
	public function getActivityFeedBirth($aRow)
	{
		$sLink = '';
		$aReturn = array(
			'no_share' => true,
			// 'feed_status' => $aRow['content'],
			'feed_title' => 'Born',
			'feed_link' => $sLink,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/application_add.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],			
			'enable_like' => false			
		);	
		
		return $aReturn;
	}
	
	public function getSiteStatsForAdmin($iStartTime, $iEndTime)
	{
		$aCond = array();
		$aCond[] = 'status_id = 0 AND view_id = 0';
		if ($iStartTime > 0)
		{
			$aCond[] = 'AND joined >= \'' . $this->database()->escape($iStartTime) . '\'';
		}	
		if ($iEndTime > 0)
		{
			$aCond[] = 'AND joined <= \'' . $this->database()->escape($iEndTime) . '\'';
		}			
		
		$iCnt = (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where($aCond)
			->execute('getSlaveField');
		
		$aCond = array();
		if ($iStartTime > 0)
		{
			$aCond[] = 'AND time_stamp >= \'' . $this->database()->escape($iStartTime) . '\'';
		}	
		if ($iEndTime > 0)
		{
			$aCond[] = 'AND time_stamp <= \'' . $this->database()->escape($iEndTime) . '\'';
		}			
		
		$iStatusCnt = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('user_status'))
			->where($aCond)
			->execute('getSlaveField');		
		
		return array(array(
				'phrase' => 'user.users',
				'total' => $iCnt
			),
			array(
				'phrase' => 'user.status_updates',
				'total' => $iStatusCnt
			)
		);
	}
	
	public function mobileMenu()
	{
		return array(
			'phrase' => Phpfox::getPhrase('user.members'),
			'link' => Phpfox::getLib('url')->makeUrl('user.browse'),
			'icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'mobile/small_groups.png'))
		);
	}	
	public function getNotificationTaggedStatus($aRow)
	{
		
		return array(
			'message' => Phpfox::getPhrase('user.user_name_tagged_you_in_a_status_update', array('user_name' => $aRow['full_name'])),			
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('status-id' => $aRow['item_id']))
		);			
	}
	public function getNotificationTaggedComment($aRow)
	{		
		
		return array(
			'message' => Phpfox::getPhrase('user.user_name_tagged_you_in_a_comment', array('user_name' => $aRow['full_name'])),			
			'link' => Phpfox::getLib('url')->makeUrl('comment.view', array($aRow['item_id']))
		);			
	}
	public function getCommentNotificationStatusTag($aRow) 
	{		
		
		return array(
			'message' => Phpfox::getPhrase('user.user_name_tagged_you_in_a_comment', array('user_name' => $aRow['full_name'])),
			'link' => Phpfox::getLib('url')->makeUrl('comment.view', array($aRow['item_id']))
		);			
	}
	public function massAdmincpProductDelete($sProduct)
	{
		$this->database()->delete(Phpfox::getT('user_group_setting'), "product_id = '" . $this->database()->escape($sProduct) . "'");
	}
	
	public function deleteCommentStatus($iId)
	{
		$this->database()->updateCounter('user_status', 'total_comment', 'status_id', $iId, true);
	}

	public function massAdmincpModuleDelete($iModule)
	{
		$this->database()->delete(Phpfox::getT('user_group_setting'), "module_id = '" . $this->database()->escape($iModule) . "'");
		$this->database()->delete(Phpfox::getT('user_group_custom'), "module_id = '" . $this->database()->escape($iModule) . "'");
	}

	public function globalSearch($sQuery, $bIsTagSearch = false)
	{
		if ($bIsTagSearch === true)
		{
			return;
		}
		
		$sKeywordSearch = '(u.full_name LIKE \'%' . Phpfox::getLib('database')->escape($sQuery) . '%\' OR (u.email LIKE \'%' . Phpfox::getLib('database')->escape($sQuery) . '@%\' OR u.email = \'' . Phpfox::getLib('database')->escape($sQuery) . '\'))';

		$iCnt = $this->database()->select('COUNT(*)')
		->from($this->_sTable, 'u')
		->where($sKeywordSearch)
		->execute('getSlaveField');

		$aUsers = $this->database()->select('u.joined, ' . Phpfox::getUserField())
		->from($this->_sTable, 'u')
		->where($sKeywordSearch)
		->limit(10)
		->order('u.joined DESC')
		->execute('getSlaveRows');

		if (count($aUsers))
		{
			$aResults = array();
			$aResults['total'] = $iCnt;
			$aResults['menu'] = Phpfox::getPhrase('user.members');
			$aResults['form'] = '<form method="post" action="' . Phpfox::getLib('url')->makeUrl('user.browse') . '"><div><input type="hidden" name="' . Phpfox::getTokenName() . '[security_token]" value="' . Phpfox::getService('log.session')->getToken() . '" /></div><div><input name="search[keyword]" value="' . Phpfox::getLib('parse.output')->clean($sQuery) . '" size="20" type="hidden" /></div><div><input type="hidden" name="search[type]" value="2" /></div><div><input type="submit" value="' . Phpfox::getPhrase('user.view_more_members') . '" class="search_button" /></div></form>';
			foreach ($aUsers as $iKey => $aUser)
			{
				$aResults['results'][$iKey] = array(
					'link' => Phpfox::getLib('url')->makeUrl($aUser['user_name']),
					'title' => $aUser['full_name'],					
					'image' => Phpfox::getLib('image.helper')->display(array(
							'user' => $aUser,
							'suffix' => '_50',
							'max_width' => 75,
							'max_height' => 75
						)
					),
					'extra_info' => Phpfox::getPhrase('user.a_href_link_member_a_joined_joined', array(
							'link' => Phpfox::getLib('url')->makeUrl('user.browse'),
							'joined' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aUser['joined'])
						)
					)
				);
			}

			return $aResults;
		}
	}

	public function getNewsFeedStatus($aRow)
	{
		if ($sPlugin = Phpfox_Plugin::get('user.service_callback_getnewsfeedstatus_start')){eval($sPlugin);}
		$oParseOutput = Phpfox::getLib('parse.output');

		$aRow['text'] = '<a href="' . Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']) . '">' . $aRow['owner_full_name'] . '</a> ' . Phpfox::getService('feed')->shortenText($oParseOutput->clean($aRow['content'])) . '';
		$aRow['icon'] = 'misc/user_feed.png';
		$aRow['enable_like'] = true;

		return $aRow;
	}

	public function getNewsFeedPhoto($aRow)
	{
		if ($sPlugin = Phpfox_Plugin::get('user.service_callback_getnewsfeedphoto_start')){eval($sPlugin);}
		$oParseOutput = Phpfox::getLib('parse.output');

		$aRow['text'] = Phpfox::getPhrase('user.a_href_link_full_name_a_updated_their_profile_picture', array(
				'link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
				'full_name' => $aRow['owner_full_name']
			)
		);

		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			$aImage = unserialize($aRow['content']);
			$sImage = Phpfox::getLib('image.helper')->display(array(
					'server_id' => $aImage['server_id'],
					'path' => 'core.url_user',
					'file' => $aImage['destination'],
					'suffix' => '_50',
					'max_width' => 75,
					'max_height' => 75,
					'style' => 'vertical-align:top; padding-right:5px;'
				)
			);
			$aRow['text'] .= '<div class="p_4"><a href="' . Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']) . '">' . $sImage . '</a></div>';
		}
		
		$aRow['icon'] = 'misc/profile_photo.png';
		$aRow['enable_like'] = true;
		
		return $aRow;
	}

	public function getNewsFeedJoined($aRow, $iUserId = null)
	{
		if ($sPlugin = Phpfox_Plugin::get('user.service_callback_getnewsfeedjoined_start')){eval($sPlugin);}
		$aRow['text'] = Phpfox::getPhrase('user.a_href_link_full_name_a_joined_the_community', array(
				'link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
				'full_name' => $aRow['owner_full_name']
			)
		);
		
		$aRow['icon'] = 'misc/user_add.png';
		$aRow['enable_like'] = true;
		
		return $aRow;
	}

	public function getCustomFieldLocations()
	{
		return array(
			'user_main' => Phpfox::getPhrase('user.users_profile_main_section'),
			'user_panel' => Phpfox::getPhrase('user.users_profile_basic_information')
			//'profile_panel' => Phpfox::getPhrase('user.users_profile_side_panel')
		);
	}

	public function getCustomGroups()
	{
		return array(
			'user_profile' => Phpfox::getPhrase('user.users_profile')
		);
	}

	public function groupMenu($sGroupUrl, $iGroupId)
	{
		if (!Phpfox::getService('group')->hasAccess($iGroupId, 'can_view_members'))
		{
			return false;
		}		
		
		return array(
				Phpfox::getPhrase('user.members') => array(
					'active' => 'member',
					'url' => Phpfox::getLib('url')->makeUrl('group', array($sGroupUrl, 'member')
				)
			)
		);
	}

	public function getDashboardMenus()
	{
		return array(
			'user.account_info' => '#core.info?id=js_core_dashboard',
			'user.activity' => '#core.activity?id=js_core_dashboard'
		);
	}

	public function getReportRedirect($iUserId)
	{
		$aUser = $this->database()->select('user_id, user_name')
		->from(Phpfox::getT('user'))
		->where('user_id = ' . (int) $iUserId)
		->execute('getSlaveRow');

		if (!isset($aUser['user_id']))
		{
			return false;
		}

		return Phpfox::getLib('url')->makeUrl($aUser['user_name']);
	}
	
	public function getReportRedirectStatus($iStatusId)
	{
		$aUser = $this->database()->select('u.user_name')
			->from(Phpfox::getT('user_status'), 'us')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = us.user_id')
			->where('us.status_id = ' . (int) $iStatusId)
			->execute('getSlaveRow');

		if (!isset($aUser['user_name']))
		{
			return false;
		}

		return Phpfox::getLib('url')->makeUrl($aUser['user_name'], array('status-id' => $iStatusId));
	}	

	public function getRatingData($iId)
	{
		return array(
			'field' => 'user_id',
			'table' => 'user_field',
			'table_rating' => 'user_rating'
		);
	}

	public function verifyFavorite($iItemId)
	{
		$aItem = $this->database()->select('i.user_id')
		->from($this->_sTable, 'i')
		->where('i.user_id = ' . (int) $iItemId)
		->execute('getSlaveRow');

		if (!isset($aItem['user_id']))
		{
			return false;
		}

		return true;
	}

	public function getFavorite($aFavorites)
	{
		$aItems = $this->database()->select('u.full_name AS title, u.joined AS time_stamp, ' . Phpfox::getUserField())
		->from($this->_sTable, 'u')
		->where('u.user_id IN(' . implode(',', $aFavorites) . ')')
		->execute('getSlaveRows');

		foreach ($aItems as $iKey => $aItem)
		{
			$aItems[$iKey]['image'] = Phpfox::getLib('image.helper')->display(array(
					'user' => $aItem,
					'suffix' => '_50',
					'max_width' => 75,
					'max_height' => 75,					
				)
			);

			$aItems[$iKey]['link'] = Phpfox::getLib('url')->makeUrl($aItem['user_name']);
			$aItems[$iKey]['extra_info'] = Phpfox::getPhrase('user.joined_time_stamp', array('time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aItem['time_stamp'])));
		}

		return array(
			'title' => Phpfox::getPhrase('user.members'),
			'items' => $aItems
		);
	}

	public function getDetailOnBlockUpdate()
	{
		return array(
			'table' => 'user_dashboard',
			'field' => 'user_id',
			'value' => Phpfox::getUserId()
		);
	}

	public function getDetailOnOrderUpdate()
	{
		return array(
			'table' => 'user_dashboard',
			'field' => 'user_id',
			'value' => Phpfox::getUserId()
		);
	}

	public function getDetailOnThemeUpdate()
	{
		Phpfox::getLib('session')->remove(Phpfox::getParam('core.theme_session_prefix') . 'theme');
		
		return array(
			'table' => 'user',
			'field' => 'style_id',
			'action' => 'user_id',
			'value' => Phpfox::getUserId(),
			'javascript' => '$(\'.style_submit_box\').hide(); $(\'.style_box\').removeClass(\'style_box_active\'); $(\'.style_box\').each(function(){ if($(this).hasClass(\'style_box_test\')) $(this).removeClass(\'style_box_test\').addClass(\'style_box_active\');  {} });'
		);
	}

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		Phpfox::getService('user.block.process')->delete($iUser);
		// delete featured entries
		$this->database()->delete(Phpfox::getT('user_featured'), 'user_id = ' . (int)$iUser);
		if (Phpfox::getParam('user.cache_featured_users'))
		{
			$this->cache()->remove('featured_users');
		}
		// This function takes care of all checks and queries if needed.
		Phpfox::getService('profile.process')->clearProfileCache( (int)$iUser );
		
		// http://www.phpfox.com/tracker/view/15193/
		Phpfox::getService('user.process')->removeProfilePic($iUser);

		$this->database()->delete(Phpfox::getT('user'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_activity'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_count'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_css'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_css_code'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_custom'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_custom_value'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_design_order'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_notification'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_space'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_track'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_field'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('user_verify'), 'user_id = ' . (int)$iUser);	
	}

	public function exportModule($sProductId, $sModule = null)
	{
		$iCnt = 0;
		$sOutput = '';
		$aSql = array();
		$aSql[] = "product_id = '" . $sProductId . "'";
		if ($sModule !== null)
		{
			$aSql[] = "AND module_id = '" . $sModule . "'";
		}

		$aRows = $this->database()->select('*')
			->from(Phpfox::getT('user_delete'))
			->where($aSql)
			->execute('getRows');

		if (count($aRows))
		{
			$iCnt++;
			$oXmlBuilder = Phpfox::getLib('xml.builder');
			$oXmlBuilder->addGroup('user_delete');
	
			foreach ($aRows as $aRow)
			{
				$oXmlBuilder->addTag('option', '', array(
						'module_id' => $aRow['module_id'],
						'phrase_var' => $aRow['phrase_var']
					)
				);
			}
			$oXmlBuilder->closeGroup();
		}
		
		(Phpfox::getService('user.group.setting')->export($sProductId, $sModule) ? $iCnt++ : null);

		return ($iCnt ? true : false);
	}

	public function installModule($sProduct, $sModule, $aModule)
	{
		if (isset($aModule['user_delete']))
		{
			$aRows = (isset($aModule['user_delete']['option'][1]) ? $aModule['user_delete']['option'] : array($aModule['user_delete']['option']));			
			foreach ($aRows as $aRow)
			{
				$this->database()->insert(Phpfox::getT('user_delete'), array(
						'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
						'product_id' => $sProduct,
						'phrase_var' => $aRow['phrase_var']
					)
				);
			}
		}
	}	
	
	public function spamCheck()
	{
		return array(
			'phrase' => Phpfox::getPhrase('user.users'),
			'value' => Phpfox::getService('user')->getSpamTotal(),
			'link' => Phpfox::getLib('url')->makeUrl('admincp.user.browse', array('view' => 'spam'))
		);		
	}	
	
	public function legacyRedirect($aRequest)
	{		
		if (isset($aRequest['mode']))
		{
			switch ($aRequest['mode'])
			{
				case 'online':
					return array('user.browse', array('view' => 'online'));
					break;				
				case 'featured':
					return array('user.browse', array('view' => 'featured'));
					break;
			}
		}

		if (isset($aRequest['req2']))
		{
			switch ($aRequest['req2'])
			{
				case 'gallery':
					return array($aRequest['name'], 'photo');
					break;
				case 'blogs':
					return array($aRequest['name'], 'blog');
					break;
			}
		}
		
		if (isset($aRequest['name']))
		{
			return $aRequest['name'];
		}		
		
		return 'user.browse';
	}

	public function ipSearch($sSearch)
	{
		$aRows = $this->database()->select('uip.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('user_ip'), 'uip')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = uip.user_id')
			->where('uip.ip_address = \'' . $this->database()->escape($sSearch) . '\'')
			->order('uip.time_stamp DESC')
			->limit(50)
			->execute('getSlaveRows');
			
		$aResults = array();
		foreach ($aRows as $aRow)
		{
			$aResults[] = array(
				$aRow['full_name'],
				$aRow['type_id'],
				Phpfox::getTime(Phpfox::getParam('core.extended_global_time_stamp'), $aRow['time_stamp'])
			);		
		}
		
		return array(
			'table' => Phpfox::getPhrase('user.user_activity'),
			'th' => array(
				Phpfox::getPhrase('user.name'),
				Phpfox::getPhrase('user.type'),
				Phpfox::getPhrase('user.time_stamp')
			),
			'results' => $aResults
		);
	}
	
	public function removeDuplicateList()
	{
		return array(
			'name' => Phpfox::getPhrase('admincp.user_group_settings'),
			'key' => 'setting_id',			
			'table' => 'user_group_setting',
			'search' => array(
				'module_id',
				'name'
			)					
		);	
	}
	
	public function pendingApproval()
	{
		return array(
			'phrase' => Phpfox::getPhrase('user.users_pending_approval'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('user'))
				->where('view_id = 1')
				->execute('getSlaveField'),
			'link' => Phpfox::getLib('url')->makeUrl('admincp.user.browse', array('view' => 'pending'))		
		);
	}
	
	public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				
		return array(
			'phrase' => Phpfox::getPhrase('user.members'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('user'))
				->where('status_id = 0 AND view_id = 0 AND joined >= ' . $iToday)
				->execute('getSlaveField')
		);
	}
	
	public function getNewsFeedJoined_FeedLike($aRow, $iUserId = null)
	{
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('user.a_href_user_link_full_name_a_liked_that_they_joined_the_community', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name'], array('feed' => $aRow['item_id']))
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('user.a_href_user_link_full_name_a_liked_that_a_href_view_user_link_view_full_name_a_a_href_link_joined_a_the_community', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'view_full_name' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name']),
					'view_user_link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name']),
					'link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name'], array('feed' => $aRow['item_id']))					
				)
			);
		}
		
		$aRow['icon'] = 'misc/thumb_up.png';

		return $aRow;		
	}
	
	public function getNotificationFeedJoined_NotifyLike($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('user.a_href_user_link_full_name_a_liked_that_you_joined_the_community', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('welcome' => 'me'))					
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('welcome' => 'me'))
		);			
	}
	
	public function sendLikeEmailJoined($iItemId)
	{
		return Phpfox::getPhrase('user.a_href_user_link_full_name_a_liked_that_you_joined_the_community', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name'), array('welcome' => 'me'))					
				)
			);		
	}
	
	public function getNewsFeedStatus_FeedLike($aRow)
	{
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('user.a_href_user_link_full_name_a_likes_their_own_a_href_link_status_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name'], array('feed' => $aRow['item_id'], 'flike' => 'status'))
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('user.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_status_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'view_full_name' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name']),
					'view_user_link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name']),
					'link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name'], array('feed' => $aRow['item_id'], 'flike' => 'status'))					
				)
			);
		}
		
		$aRow['icon'] = 'misc/thumb_up.png';

		return $aRow;	
	}
	
	public function getNotificationFeedStatus_NotifyLike($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('user.a_href_user_link_full_name_a_likes_your_a_href_link_status_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' =>  Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name'), array('feed' => $aRow['item_id'], 'flike' => 'status'))	
				)
			),
			'link' =>  Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name'), array('feed' => $aRow['item_id'], 'flike' => 'status'))
		);		
	}
	
	public function sendLikeEmailStatus($iItemId, $aFeed)
	{		
		return Phpfox::getPhrase('user.a_href_user_link_full_name_a_likes_your_a_href_link_status_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl($aFeed['user_name'], array('feed' => $aFeed['feed_id'], 'flike' => 'status'))
				)
			);		
	}	
	
	public function getNewsFeedPhoto_FeedLike($aRow)
	{
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('user.a_href_user_link_full_name_a_likes_their_own_profile_a_href_link_photo_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name'], array('feed' => $aRow['item_id'], 'flike' => 'photo'))
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('user.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_profile_a_href_link_photo_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'view_full_name' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name']),
					'view_user_link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name']),
					'link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name'], array('feed' => $aRow['item_id'], 'flike' => 'photo'))					
				)
			);
		}
		
		$aRow['icon'] = 'misc/thumb_up.png';

		return $aRow;	
	}
	
	public function getNotificationFeedPhoto_NotifyLike($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('user.a_href_user_link_full_name_a_likes_your_profile_a_href_link_photo_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' =>  Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name'), array('feed' => $aRow['item_id'], 'flike' => 'photo'))	
				)
			),
			'link' =>  Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name'), array('feed' => $aRow['item_id'], 'flike' => 'photo'))
		);		
	}	
	
	public function sendLikeEmailPhoto($iItemId, $aFeed)
	{		
		return Phpfox::getPhrase('user.a_href_user_link_full_name_a_likes_your_profile_a_href_link_photo_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl($aFeed['user_name'], array('feed' => $aFeed['feed_id'], 'flike' => 'photo'))
				)
			);		
	}	
	
	public function updateCounterList()
	{
		$aList = array();		
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('user.update_user_photos'),
			'id' => 'update-user-photo'			
		);			

		return $aList;
	}		
	
	public function updateCounter($iId, $iPage, $iPageLimit)
	{
		@ini_set('memory_limit', '100M');
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('user'))
			->where($this->database()->isNotNull('user_image'))
			->execute('getSlaveField');
			
		$aRows = $this->database()->select('user_id, user_image')
			->from(Phpfox::getT('user'))
			->where($this->database()->isNotNull('user_image'))			
			->limit($iPage, $iPageLimit, $iCnt)
			->execute('getSlaveRows');
			
		foreach ($aRows as $aRow)
		{
			if (preg_match("/\{file\/pic\/(.*)\/(.*)\.jpg\}/i", $aRow['user_image'], $aMatches))
			{
				$sPath = PHPFOX_DIR;
				$sImagePath = str_replace(array('{', '}'), '', $aRow['user_image']);	
			}
			else 
			{
				$sPath = Phpfox::getParam('core.dir_user');
				$sImagePath = $aRow['user_image'];
			}
			
			if (file_exists($sPath . sprintf($sImagePath, '')))
			{
				foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
				{
					if (!file_exists($sPath . sprintf($sImagePath, '_' . $iSize)))
					{
						Phpfox::getLib('image')->createThumbnail($sPath . sprintf($sImagePath, ''), $sPath . sprintf($sImagePath, '_' . $iSize), $iSize, $iSize);
					}
					
					if (!file_exists($sPath . sprintf($sImagePath, '_' . $iSize . '_square')))
					{
						Phpfox::getLib('image')->createThumbnail($sPath . sprintf($sImagePath, ''), $sPath . sprintf($sImagePath, '_' . $iSize . '_square'), $iSize, $iSize, true);
					}					
				}
			}
			else 
			{

			}
		}
			
		return $iCnt;
	}
	
	public function getFeedRedirectStatus($iId)
	{
		return $this->getReportRedirect($iId) . 'feed_' . Phpfox::getLib('request')->get('id') . '/#feed';		
	}
	
	public function getSqlTitleField()
	{
		return array(
			array(
			'table' => 'user',
			'field' => 'full_name',
			'has_index' => 'full_name'
				),
			array(
				'table' => 'user',
				'field' => 'status'
			)
		);
	}
	
	public function getActivityFeedPhoto($aItem)
	{			
		return array(
			'feed_title' => '',
			'feed_info' => Phpfox::getPhrase('feed.updated_gender_profile_photo', array('gender' => Phpfox::getService('user')->gender($aItem['gender'], 1))),
			'feed_link' => Phpfox::getLib('url')->makeUrl($aItem['user_name']),
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/report_user.png', 'return_url' => true)),
			'time_stamp' => $aItem['time_stamp'],			
			'enable_like' => false		
		);		
	}	
	
	public function getActivityFeedStatus($aItem)
	{		
		$sSelect = 'us.*';
		if (Phpfox::isModule('like'))
		{
			$sSelect .= ', l.like_id AS is_liked';
			$this->database()->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'user_status\' AND l.item_id = us.status_id AND l.user_id = ' . Phpfox::getUserId());
		}
		$aRow = $this->database()->select($sSelect)
			->from(Phpfox::getT('user_status'), 'us')
			->where('us.status_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');	
		
		if (empty($aRow))
		{
			return false;
		}
		
		if (!empty($aItem['content']))
		{
			if (!empty($aItem['content']))
			{
				$sLink = Phpfox::getLib('url')->makeUrl($aItem['user_name'], array('feed' => $aItem['feed_id']));

				$aReturn = array(
					'no_share' => true,
					'feed_status' => $aItem['content'],
					'feed_link' => $sLink,
					'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/application_add.png', 'return_url' => true)),
					'time_stamp' => $aItem['time_stamp'],			
					'enable_like' => false
							
				);	
				
				return $aReturn;
			}
			
			return false;
		}		
		
		$sLink = Phpfox::getLib('url')->makeUrl($aItem['user_name'], array('status-id' => $aRow['status_id']));
			
		$aReturn = array(
			//'no_share' => true,
			'feed_status' => $aRow['content'],
			'feed_title' => '',
			'feed_link' => $sLink,
			'total_comment' => $aRow['total_comment'],
			'feed_total_like' => $aRow['total_like'],
			'feed_is_liked' => isset($aRow['is_liked']) ? $aRow['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/application_add.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],			
			'enable_like' => true,			
			'comment_type_id' => 'user_status',
			'like_type_id' => 'user_status'			
		);	
		
		if (!empty($aRow['location_name']))
		{
			$aReturn['location_name'] = $aRow['location_name'];
		}
		if (!empty($aRow['location_latlng']))
		{
			$aReturn['location_latlng'] = json_decode($aRow['location_latlng'], true);
		}
		
		if (!empty($aItem['app_id']))
		{
			$aApp = $this->database()->select('app_title, app_id')->from(Phpfox::getT('app'))
					->where('app_id = ' . (int)$aItem['app_id'])
					->execute('getSlaveRow');
			
			if (empty($aApp))
			{
				return false;
			}
			$sLink = '<a href="' . Phpfox::permalink('apps', $aApp['app_id'], $aApp['app_title']) . '">' . $aApp['app_title'] . '</a>';
			$aReturn['app_link'] = $sLink;
		}
		
		return $aReturn;
	}
	
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		$this->database()->updateCount('like', 'type_id = \'user_status\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'user_status', 'status_id = ' . (int) $iItemId);	
	}	
	
	public function deleteLikeStatus($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'user_status\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'user_status', 'status_id = ' . (int) $iItemId);	
	}		
	
	/**
	 * This function is called when an App is using the API (api/api.class.php) to check which 
	 * privileges can the app run
	 * @return array 
	 */
	public function getApiPermissions()
	{
		$aPerms = array();
		
		$aPerms['get_full_name'] = Phpfox::getPhrase('apps.share_my_full_name');
		$aPerms['get_email'] = Phpfox::getPhrase('apps.share_my_email');
		$aPerms['update_status'] = Phpfox::getPhrase('apps.post_a_status_update_as_me');
		
		return $aPerms;
	}
	
	public function getApiSupportedMethods()
	{
		$aMethods = array();
		
		$aMethods[] = array(
			'call' => 'getUser',
			'requires' => array(
				'user_id' => 'user_id'
			),
			'detail' => Phpfox::getPhrase('user.get_information_about_a_user_based_on_the_user_id_you_pass_if_you_do_not_pass_the_user_id_we_will_return_information_about_the_user_that_is_currently_logged_in'),
			'type' => 'GET',			
			'response' => '{"api":{"total":0,"pages":0,"current_page":0},"output":{"user_id":"1","user_name":"john-doe","joined":"1314109907","gender":"Male","country_iso":"US","full_name":"John Doe","email":"john.doe@site.com","photo_50px":"http:\/\/[DOMAIN_REPLACE]\/file\/pic\/user\/2011\/08\/9d673759d1cf55c9cd0b0805dc32e68e_50.jpg","photo_50px_square":"http:\/\/[DOMAIN_REPLACE]\/file\/pic\/user\/2011\/08\/9d673759d1cf55c9cd0b0805dc32e68e_50_square.jpg","photo_120px":"http:\/\/[DOMAIN_REPLACE]\/file\/pic\/user\/2011\/08\/9d673759d1cf55c9cd0b0805dc32e68e_120.jpg","photo_original":"http:\/\/[DOMAIN_REPLACE]\/file\/pic\/user\/2011\/08\/9d673759d1cf55c9cd0b0805dc32e68e.jpg","profile_url":"http:\/\/[DOMAIN_REPLACE]\/index.php?do=\/john-doe\/"}}'			 
		);		
		
		return array(
			'module' => 'user', 
			'module_info' => '', 
			'methods' => $aMethods
		);
	}		
	
	public function getAjaxCommentVarStatus()
	{
		return null;
	}	
	
	public function addLikeStatus($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('us.status_id, us.content, us.user_id, u.user_name')
			->from(Phpfox::getT('user_status'), 'us')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = us.user_id')
			->where('us.status_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['status_id']))
		{
			return false;
		}
		
		$this->database()->updateCount('like', 'type_id = \'user_status\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'user_status', 'status_id = ' . (int) $iItemId);	
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('status-id' => $aRow['status_id']));
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('user.full_name_liked_your_status_update_content', array('full_name' => Phpfox::getUserBy('full_name'), 'content' => Phpfox::getLib('parse.output')->shorten($aRow['content'], 50, '...'))))
				->message(array('user.full_name_liked_your_status_update_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'content' => Phpfox::getLib('parse.output')->shorten($aRow['content'], 50, '...'))))
				->notification('like.new_like')
				->send();
					
			Phpfox::getService('notification.process')->add('user_status_like', $aRow['status_id'], $aRow['user_id']);
		}
	}	
	
	public function getNotificationStatus_Like($aNotification)
	{
		$aRow = $this->database()->select('us.status_id, us.content, us.user_id, u.gender, u.user_name, u.full_name')	
			->from(Phpfox::getT('user_status'), 'us')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = us.user_id')
			->where('us.status_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
		
		$aRow['content'] = Phpfox::getLib('parse.bbcode')->removeTagText($aRow['content']); 
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('user.user_name_liked_gender_own_status_update_title',	array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 				    'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 				    'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], Phpfox::getParam('notification.total_notification_title_length'), '...')));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('user.user_name_liked_your_status_update_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('user.user_name_liked_span_class_drop_data_user_full_name_s_span_status_update_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('status-id' => $aRow['status_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);	
	}		
	
	public function addCommentStatus($aVals, $iUserId = null, $sUserName = null)
	{		
		$aRow = $this->database()->select('us.status_id, us.content, u.full_name, u.gender, u.user_id, u.user_name')
			->from(Phpfox::getT('user_status'), 'us')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = us.user_id')
			->where('us.status_id = ' . (int) $aVals['item_id'])
			->execute('getSlaveRow');
			
		// Update the post counter if its not a comment put under moderation or if the person posting the comment is the owner of the item.
		if (empty($aVals['parent_id']))
		{
			$this->database()->updateCounter('user_status', 'total_comment', 'status_id', $aRow['status_id']);		
		}
		
		// Send the user an email
		$sLink = Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('status-id' => $aRow['status_id']));
		
		Phpfox::getService('comment.process')->notify(array(
				'user_id' => $aRow['user_id'],
				'item_id' => $aRow['status_id'],
				'owner_subject' => Phpfox::getPhrase('user.full_name_commented_on_your_status_update', array('full_name' => Phpfox::getUserBy('full_name'))),
				'owner_message' => Phpfox::getPhrase('user.full_name_commented_on_your_status_update_title_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], 50, '...'), 'link' => $sLink)),
				'owner_notification' => 'comment.add_new_comment',
				'notify_id' => 'comment_user_status',
				'mass_id' => 'user_status',
				'mass_subject' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('user.full_name_commented_on_one_of_gender_status_updates',array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1)))					
					:Phpfox::getPhrase('user.full_name_commented_on_one_of_other_full_name_s_status_updates',array('full_name' => Phpfox::getUserBy('full_name'), 'other_full_name' => $aRow['full_name']))),
				'mass_message' => (Phpfox::getUserId() == $aRow['user_id'] ? 
Phpfox::getPhrase('user.full_name_commented_on_gender_status_update_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'gender' =>Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], 50, '...'), 'link' => $sLink))						
					:Phpfox::getPhrase('user.full_name_commented_on_other_full_name_s_status_update_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'other_full_name' => $aRow['full_name'], 'link' => $sLink, 'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], 50, '...'))))
			)
		);		
	}		
	
	public function getCommentItemStatus($iId)
	{
		$aRow = $this->database()->select('status_id AS comment_item_id, privacy_comment, user_id AS comment_user_id')
			->from(Phpfox::getT('user_status'))
			->where('status_id = ' . (int) $iId)
			->execute('getSlaveRow');		
			
		$aRow['comment_view_id'] = '0';
		
		if (!Phpfox::getService('comment')->canPostComment($aRow['comment_user_id'], $aRow['privacy_comment']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('user.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
			
			unset($aRow['comment_item_id']);
		}
			
		return $aRow;
	}	
	
	public function getCommentNotificationStatus($aNotification)
	{
		$aRow = $this->database()->select('us.status_id, u.user_id, us.content, u.gender, u.user_name, u.full_name')	
			->from(Phpfox::getT('user_status'), 'us')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = us.user_id')
			->where('us.status_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			 
		$aRow['content'] = Phpfox::getLib('parse.bbcode')->removeTagText($aRow['content']); 
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('user.span_class_drop_data_user_full_name_span_commented_on_gender_status_update_title',array('full_name' => $aNotification['full_name'], 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], Phpfox::getParam('notification.total_notification_title_length'), '...')));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('user.span_class_drop_data_user_full_name_span_commented_on_your_status_update_title',array('full_name' => $aNotification['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('user.span_class_drop_data_user_full_name_span_commented_on_span_class_drop_data_user_other_full_name_s_span_status_update_title',array('full_name' => $aNotification['full_name'], 'other_full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['content'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('status-id' => $aRow['status_id'])),
			'message' => $sPhrase
		);
	}	
	
	public function globalUnionSearch($sSearch)
	{
		$this->database()->select('item.user_id AS item_id, item.full_name AS item_title, item.last_login AS item_time_stamp, item.user_id AS item_user_id, \'user\' AS item_type_id, \'\' AS item_photo, \'\' AS item_photo_server')
			->from(Phpfox::getT('user'), 'item')
			->where($this->database()->searchKeywords('item.full_name', $sSearch) . ' AND item.status_id = 0 AND item.view_id = 0')
			->union();
	}	
	
	public function getSearchInfo($aRow)
	{
		$aInfo = array();
		$aInfo['item_link'] = Phpfox::getLib('url')->makeUrl($aRow['user_name']);
		$aInfo['item_name'] = Phpfox::getPhrase('search.members');		
		
		return $aInfo;
	}	
	
	public function getSearchTitleInfo()
	{
		return array(
			'name' => Phpfox::getPhrase('search.members')
		);
	}	
	
	public function getRedirectCommentStatus($iId)
	{
		$aRow = $this->database()->select('us.*, u.user_name')
			->from(Phpfox::getT('user_status'), 'us')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = us.user_id')
			->where('us.status_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		return Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('status-id' => $aRow['status_id']));
	}
	
	public function getProfileSettings()
	{
		return array(
			'user.can_i_be_tagged' => array(
				'phrase' => Phpfox::getPhrase('user.who_can_tag_me_in_written_contexts'),
				//'default' => '0',
				//'no_user' => true,
				//'anyone' => true,
				
				
			)
		);
	}
	
	public function getActions()
	{
		return array(
			'dislike' => array(
				'enabled' => true,
				'action_type_id' => 2, // 2 = dislike
				'phrase' => Phpfox::getPhrase('like.dislike'),
				'phrase_in_past_tense' => 'disliked',
				'item_phrase' => Phpfox::getPhrase('comment.item_phrase'),
				'item_type_id' => 'user-status', // used to differentiate between photo albums and photos for example. This is not a phrase
				'table' => 'comment',
				'column_update' => 'total_dislike',
				'column_find' => 'comment_id',
				'where_to_show' => array('')			
			)
		);
	}
}

?>
