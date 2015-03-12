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
 * @version 		$Id: profile.class.php 6587 2013-09-05 10:03:17Z Miguel_Espinoza $
 */
class Profile_Service_Profile extends Phpfox_Service 
{
	private $_iUserId = 0;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getProfileTitle($aRow)
	{
		$sTitleReplace = Phpfox::getParam('profile.profile_seo_for_meta_title');		
		if (!empty($sTitleReplace) && Phpfox::getService('user.privacy')->hasAccess($aRow['user_id'], 'profile.basic_info'))
		{
			preg_match_all('/\{(.*?)\}/i', $sTitleReplace, $aMatches);
			if (isset($aMatches[1]) && is_array($aMatches[1]))
			{
				foreach ($aMatches[1] as $sFind)
				{
					if ($sFind == 'gender_name' && !Phpfox::getUserGroupParam($aRow['user_group_id'], 'user.can_edit_gender_setting'))
					{
						unset($aRow[$sFind]);
					}
					
					if (!empty($aRow[$sFind]))
					{
						if ($sFind == 'location' && !empty($aRow[$sFind]))
						{
							if (isset($aRow['location_child']))
							{
								$aRow[$sFind] = $aRow[$sFind] . ' - ' . $aRow['location_child'];
							}
						}
						
						$sTitleReplace = str_replace('{' . $sFind . '}', $aRow[$sFind], $sTitleReplace);
					}
					else 
					{
						$sTitleReplace = str_replace('{' . $sFind . '} -', '', $sTitleReplace);
						$sTitleReplace = str_replace('{' . $sFind . '}', '', $sTitleReplace);
					}
				}
			}
			
			$sPageTitle = rtrim(trim($sTitleReplace), '-');			
		}		
		
		if (empty($sPageTitle))
		{
			$sPageTitle = $aRow['full_name'];
		}		
		
		return $sPageTitle;
	}
	
	public function timeline()
	{
		if (Phpfox::isMobile())
		{
			return false;
		}
		
		if (defined('PAGE_TIME_LINE') && PAGE_TIME_LINE)
		{
			return true;
		}
		
		$iUserId = Phpfox::getLib('request')->get('profile_user_id');
		
		
		if ((defined('PHPFOX_IS_USER_PROFILE') || !empty($iUserId)) && Phpfox::isModule('feed') && Phpfox::getParam('feed.force_timeline'))
		{
		    return true;
		}
		
		if (PHPFOX_IS_AJAX && (
				Phpfox::getLib('request')->get('action') == 'upload_photo_via_share' &&
				Phpfox::getLib('request')->get('callback_module') == 'pages' &&
				Phpfox::getService('pages')->timelineEnabled(Phpfox::getLib('request')->get('callback_item_id'))
			))
		{
			return true;
		}
		
		if (Phpfox::isModule('feed') && !Phpfox::getParam('feed.force_timeline'))
		{
			if (Phpfox::getParam('feed.timeline_optional') && PHPFOX_IS_AJAX && Phpfox::getLib('request')->get('profile_user_id') > 0)
			{
				$aUser = Phpfox::getService('user')->getUserObject(Phpfox::getLib('request')->get('profile_user_id'));
				if (isset($aUser->use_timeline) && $aUser->use_timeline)
				{
					return true;
				}
			}			
			
			if (!PHPFOX_IS_AJAX && Phpfox::getParam('feed.timeline_optional') && defined('PHPFOX_CURRENT_TIMELINE_PROFILE'))
			{
				$aUser = Phpfox::getService('user')->getUserObject(PHPFOX_CURRENT_TIMELINE_PROFILE);
				if (isset($aUser->use_timeline) && $aUser->use_timeline)
				{
					return true;
				}
			}		
			
			$aCore = Phpfox::getLib('request')->get('core');
			
			if (PHPFOX_IS_AJAX && Phpfox::getParam('feed.timeline_optional') && isset($aCore['profile_user_id']) && $aCore['profile_user_id'] > 0)
			{
				Phpfox::getService('user')->get($aCore['profile_user_id']);
				$aUser = Phpfox::getService('user')->getUserObject($aCore['profile_user_id']);
				if (isset($aUser->use_timeline) && $aUser->use_timeline)
				{
					return true;
				}
			}			
			return false;
		}
		
		return (defined('PHPFOX_IS_USER_PROFILE') ? true : false);
	}
	
	public function getProfileMenu($aUser)
	{
		$aMenus = array();
		if (Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'feed.view_wall'))
		{
			$aMenus[] = array(
				'phrase' => Phpfox::getPhrase('profile.wall'),
				'url' => 'profile' . ($aUser['landing_page'] == 'info' ? '.wall' : ''),
				'icon' => 'misc/comment.png'	
			);
		}
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('profile.info'),
			'url' => 'profile' . ($aUser['landing_page'] == 'info' ? '' : '.info' . (defined('PHPFOX_IN_DESIGN_MODE') ? '.design' : '')),
			'icon' => 'misc/application_view_list.png'	
		);	
		
		if (!Phpfox::getUserBy('profile_page_id') && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			$aModuleCalls = Phpfox::massCallback('getProfileMenu', $aUser);
			foreach ($aModuleCalls as $sModule => $aModuleCall)
			{
				if (!is_array($aModuleCall))
				{
					continue;
				}
				// $aMenus[] = $aModuleCall[0];
				$aMenus = array_merge($aMenus, $aModuleCall);
			}
		}
		
		foreach ($aMenus as $iKey => $aMenu)
		{
			$bSubIsSelected = false;
			if (isset($aMenu['sub_menu']))
			{
				foreach ((array) $aMenu['sub_menu'] as $iSubKey => $aSubMenu)
				{
					if ($this->request()->get('view'))
					{
						$sCurrent = 'profile.' . $this->request()->get('req2') . '.view_' . $this->request()->get('view');
					}
					else 
					{
						$sCurrent = 'profile.' . $this->request()->get('req2') . '.' . $this->request()->get('req3');
					}

					if ($sCurrent == $aSubMenu['url'])
					{
						$aMenus[$iKey]['sub_menu'][$iSubKey]['is_selected'] = true;
						$bSubIsSelected = true;
						break;	
					}
				}
			}

			if ($bSubIsSelected === false 
				&& (
					($aMenu['url'] == 'profile' . (Phpfox::getLib('request')->get('req2') ? '.' . Phpfox::getLib('request')->get('req2') : '') . (Phpfox::getLib('request')->get('req3') ? '.' . Phpfox::getLib('request')->get('req3') : ''))
					|| (Phpfox::getLib('request')->get('req2') == '' && $iKey === 0 && !Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'feed.view_wall'))					
				)
			)
			{
				$aMenus[$iKey]['is_selected'] = true;
			}
			
			if ($aMenu['url'] == 'profile.photo' && Phpfox::getLib('request')->get('req2') == 'photo' && (Phpfox::getLib('request')->get('req3') == 'albums' || Phpfox::getLib('request')->get('req3') == 'photos'))
			{
				$aMenus[$iKey]['is_selected'] = true;
			}
			
			$aMenus[$iKey]['actual_url'] = str_replace('.', '_', $aMenu['url']);
			
			if ($aMenu['url'] == 'profile')
			{
				$aMenus[$iKey]['url'] = $aUser['user_name'];
			}
			else 
			{
				$aMenus[$iKey]['url'] = $aUser['user_name'] . '.' . Phpfox::getLib('url')->doRewrite(preg_replace("/^profile\.(.*)$/i", "\\1", $aMenu['url']));
			}
		}		
		/* Reminder for purefan add a hook here */
		if ($sPlugin = Phpfox_Plugin::get('profile.service_profile_get_profile_menu'))
		{
			eval($sPlugin);
		}
		return $aMenus;	
	}
	
	public function setUserId($iUserId)
	{
		$this->_iUserId = (int) $iUserId;
	}
	
	public function getProfileUserId()
	{
		return (int) $this->_iUserId;
	}
	
    public function getInfoForAction($aItem)
    {
        if (isset($aItem['item_type_id']) && $aItem['item_type_id'] == 'user-status')
        {
            return Phpfox::getService('user')->getInfoForAction($aItem);
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
		if ($sPlugin = Phpfox_Plugin::get('profile.service_profile__call'))
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