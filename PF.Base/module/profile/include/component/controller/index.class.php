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
 * @package  		Module_Profile
 * @version 		$Id: index.class.php 6215 2013-07-08 08:19:18Z Raymond_Benc $
 */
class Profile_Component_Controller_Index extends Phpfox_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{	

		// Dealing with legacy versions
		if (($sReg2Legacy = $this->request()->get('req2')))
		{			
			switch ($sReg2Legacy)
			{
				case 'gallery':
					$sLegacySend = 'photo';
					break;
				case 'blogs':
					$sLegacySend = 'blog';
					break;
				case 'guestbook':
					$sLegacySend = '#comment';
					break;			
				case 'friends':
					$sLegacySend = 'friend';
					break;	
				case 'favorites':
					$sLegacySend = 'favorite';
					break;
				case 'videos':
					$sLegacySend = 'video';
					break;					
			}

			if (isset($sLegacySend))
			{
				header ('HTTP/1.1 301 Moved Permanently');
				
				$this->url()->send($this->request()->get('req1'), $sLegacySend);
			}
		}
		
		$mUser = $this->request()->get('req1');
		$sSection = $this->request()->get('req2');
		if (!empty($sSection))
		{
			$sSection = $this->url()->reverseRewrite($sSection);
		}		
		
		(($sPlugin = Phpfox_Plugin::get('profile.component_controller_index_process_after_requests')) ? eval($sPlugin) : false);

		
		
		$bIsSubSection = false;
		if (!empty($sSection) && Phpfox::isModule($sSection) && $sSection != 'designer')
		{
			$bIsSubSection = true;
		}
		
		if (!$mUser)
		{			
			if (Phpfox::isUser())
			{				
				$this->url()->send('profile');
			}
			else 
			{
				Phpfox::isUser(true);
			}
		}
		
		// If we are unable to find a user lets make sure we return a 404 page not found error		
		$aRow = Phpfox::getService('user')->get($mUser, false);
		
		if ((!isset($aRow['user_id'])) || (isset($aRow['user_id']) && $aRow['profile_page_id']  > 0))
		{
			if (empty($aRow['profile_page_id']) && $this->request()->get('req2') !='' && Phpfox::isModule($this->request()->get('req2')))
			{
				if (preg_match('/profile-(.*)/i', $this->request()->get('req1'), $aProfileMatches))
				{
					if (isset($aProfileMatches[1]) && is_numeric($aProfileMatches[1]))
					{
						$aActualUser = Phpfox::getService('user')->getUser($aProfileMatches[1]);
						if (isset($aActualUser['user_id']))
						{
							$aAllRequests = $this->request()->getRequests();
							$aActualRequests = array();
							foreach ($aAllRequests as $mKey => $mValue)
							{
								if ($mKey == PHPFOX_GET_METHOD || $mValue == $this->request()->get('req1'))
								{
									continue;
								}
									
								if (substr($mKey, 0, 3) == 'req')
								{
									$aActualRequests[] = $mValue;
								}
								else 
								{
									$aActualRequests[$mKey] = $mValue;
								}
							}
								
							header ('HTTP/1.1 301 Moved Permanently');
				
							$this->url()->send($aActualUser['user_name'], $aActualRequests);
						}
					}
				}	
				
				// $this->url()->send(Phpfox::getUserBy('user_name'), $this->request()->get('req2'));
			}
			
			if (Phpfox::isModule('pages') && Phpfox::getService('pages')->isPage($this->request()->get('req1')))
			{
				return Phpfox_Module::instance()->setController('pages.view');
			}
			
			return Phpfox_Module::instance()->setController('error.404');
		}	
		if ( ( ($sSection == 'info' && $this->request()->get('req3') == 'design') || $sSection == 'designer') && $aRow['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('profile.can_custom_design_own_profile'))
		{
			define('PHPFOX_IN_DESIGN_MODE', true);
			define('PHPFOX_CAN_MOVE_BLOCKS', true);			
		}		
		$oUser = Phpfox::getService('user');

		if (empty($aRow['dob_setting']))
		{
			switch (Phpfox::getParam('user.default_privacy_brithdate'))
			{
				case 'month_day':
					$aRow['dob_setting'] =  '1';
					break;
				case 'show_age':
					$aRow['dob_setting'] =  '2';
					break;	
				case 'hide':
					$aRow['dob_setting'] =  '3';
					break;					
			}				
		}		
		$aRow['gender_name'] = $oUser->gender($aRow['gender']);
		$aRow['birthday_time_stamp'] = $aRow['birthday'];	
		$aRow['birthday'] = $oUser->age($aRow['birthday']);
		$aRow['location'] = Phpfox::getPhraseT(Phpfox::getService('core.country')->getCountry($aRow['country_iso']), 'country');
		if (isset($aRow['country_child_id']) && $aRow['country_child_id'] > 0)
		{
			$aRow['location_child'] = Phpfox::getService('core.country')->getChild($aRow['country_child_id']);
		}	
		$aRow['birthdate_display'] = Phpfox::getService('user')->getProfileBirthDate($aRow);
		$aRow['is_user_birthday'] = ((empty($aRow['birthday_time_stamp']) ? false : (int) floor(Phpfox::getLib('date')->daysToDate($aRow['birthday_time_stamp'], null, false)) === 0 ? true : false));
		if (empty($aRow['landing_page']))
		{
			$aRow['landing_page'] = 'wall';
		}
		
		$this->setParam('aUser', $aRow);
		define('PHPFOX_CURRENT_TIMELINE_PROFILE', $aRow['user_id']);
		$this->template()->setHeader('cache', array(
					'profile.css' => 'style_css'
				)
			)		
			->assign(array(
				'aUser' => $aRow,
				'aProfileLinks' => Profile_Service_Profile::instance()->getProfileMenu($aRow),
				'bIsBlocked' => (Phpfox::isUser() ? Phpfox::getService('user.block')->isBlocked(Phpfox::getUserId(), $aRow['user_id']) : false),
				'bOwnProfile' => $aRow['user_id'] == Phpfox::getUserId()
			)
		);

		if (Phpfox::getService('user.block')->isBlocked($aRow['user_id'], Phpfox::getUserId()) && !Phpfox::getUserParam('user.can_override_user_privacy'))
		{
			return Phpfox_Module::instance()->setController('profile.private');
		}

		Phpfox::getUserParam('profile.can_view_users_profile', true);
		
		// Set it globaly that we are viewing a users profile, sometimes variables don't help.
		if (!defined('PHPFOX_IS_USER_PROFILE'))
		{
			define('PHPFOX_IS_USER_PROFILE', true);
		}		
		
		if ($aRow['designer_style_id'])
		{			
			$this->template()->setHeader('<script type="text/javascript">bCanByPassClick = true; sClickProfileName = \'' . $aRow['user_name'] . '\';</script>')
					->setStyle(array(
						'style_id' => $aRow['designer_style_id'],
						'style_folder_name' => $aRow['designer_style_folder'],
						'theme_folder_name' => $aRow['designer_theme_folder'],
						'theme_parent_id' => $aRow['theme_parent_id'],
						'total_column' => $aRow['total_column'],
						'l_width' => $aRow['l_width'],
						'c_width' => $aRow['c_width'],
						'r_width' => $aRow['r_width']
					)
				);
		}		
		
		if (!empty($aRow['css_hash']))
		{
			define('PHPFOX_TEMPLATE_CSS_FILE', Theme_Service_Theme::instance()->getCss(array(
							'table' => 'user_css',
							'field' => 'user_id',
							'value' => $aRow['user_id'],
							'hash' => $aRow['css_hash'],
							'table_code' => 'user_css_code'				
						)
					)
			);
		}		
		
		(($sPlugin = Phpfox_Plugin::get('profile.component_controller_index_process_is_sub_section')) ? eval($sPlugin) : false);
		
		if ( ((Phpfox::isModule('friend') && Phpfox::getParam('friend.friends_only_profile')) )
			&& empty($aRow['is_friend'])
			&& !Phpfox::getUserParam('user.can_override_user_privacy')
			&& $aRow['user_id'] != Phpfox::getUserId()
		)
		{
			return Phpfox_Module::instance()->setController('profile.private');
		}		
		
		if ($bIsSubSection === true)
		{
			$this->template()->setUrl(Phpfox::callback($sSection . '.getProfileLink'));

			return Phpfox_Module::instance()->setController($sSection . '.profile');
		}
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aRow['user_id'], 'profile.view_profile'))
		{
			return Phpfox_Module::instance()->setController('profile.private');
		}				
		
		Profile_Service_Profile::instance()->setUserId($aRow['user_id']);
		
		(($sPlugin = Phpfox_Plugin::get('profile.component_controller_index_process_start')) ? eval($sPlugin) : false);

		if (!isset($aRow['is_viewed']))
		{
			$aRow['is_viewed'] = 0;
		}

		if ( Phpfox::getParam('profile.profile_caches') != true &&
			(Phpfox::isUser() && Phpfox::getUserId() != $aRow['user_id'] &&
			(!$aRow['is_viewed']) &&
			!Phpfox::getUserBy('is_invisible')))
		{
			if (Phpfox::isModule('track'))
			{
				Phpfox::getService('track.process')->add('profile', $aRow['user_id']);
			}
			Phpfox::getService('user.field.process')->update($aRow['user_id'], 'total_view', ($aRow['total_view'] + 1));
		}
		
		if (Phpfox::getParam('profile.profile_caches') != true && isset($aRow['is_viewed']) && Phpfox::isUser() && Phpfox::isModule('track') && Phpfox::getUserId() != $aRow['user_id'] && $aRow['is_viewed'] && !Phpfox::getUserBy('is_invisible'))
		{
			Phpfox::getService('track.process')->update('user_track', $aRow['user_id']);
		}
		
		$this->setParam(array(
				'sTrackType' => 'profile',
				'iTrackId' => $aRow['user_id'],
				'iTrackUserId' => $aRow['user_id']				
			)
		);

		$this->template()->assign(array(
                'bIsUserProfileIndexPage' => true
			)
		);		
		
		Phpfox_Module::instance()->setCacheBlockData(array(
				'table' => 'user_design_order',
				'field' => 'user_id',
				'item_id' => $aRow['user_id'],
				'controller' => 'profile.' . ($this->request()->get('req2') == 'info' ? 'info' : 'index')
			)
		);				
		
		if (Phpfox::isModule('rss') && Phpfox::getService('user.privacy')->hasAccess($aRow['user_id'], 'rss.can_subscribe_profile'))
		{
			$this->template()->setHeader('<link rel="alternate" type="application/rss+xml" title="' . Phpfox::getPhrase('profile.updates_from') . ': ' . Phpfox::getLib('parse.output')->clean($aRow['full_name']) . '" href="' . $this->url()->makeUrl($aRow['user_name'], array('rss')) . '" />');
			$this->template()->assign('bShowRssFeedForUser', true);
		}
		
		(($sPlugin = Phpfox_Plugin::get('profile.component_controller_index_process_section')) ? eval($sPlugin) : false);				

		//define('PHPFOX_CAN_MOVE_BLOCKS', true);
		
		$this->setParam(array(
				'bIsProfileIndex' => true,
				'sType' => 'profile',
				'iItemId' => $aRow['user_id'],
				'iTotal' => $aRow['total_comment'],
				'user_id' => $aRow['user_id'],
				'user_group_id' => $aRow['user_group_id'],
				'edit_user_id' => $aRow['user_id'],
				'item_id' => $aRow['user_id']				
			)
		);
		
		if ($this->request()->get('req2') == 'info' 
			|| !Phpfox::getService('user.privacy')->hasAccess($aRow['user_id'], 'feed.view_wall')
			|| ($aRow['landing_page'] == 'info' && empty($sSection))
			)
		{
			if (!$this->request()->get('status-id')
				&& !$this->request()->get('comment-id')
				&& !$this->request()->get('link-id')
				&& !$this->request()->get('plink-id')
				&& !$this->request()->get('poke-id')
				&& !$this->request()->get('feed')
				)
			{
				return Phpfox_Module::instance()->setController('profile.info');
			}
		}		
		
		$sPageTitle = Profile_Service_Profile::instance()->getProfileTitle($aRow);
		
		if (!defined('PHPFOX_IS_USER_PROFILE_INDEX'))
		{
			define('PHPFOX_IS_USER_PROFILE_INDEX', true);
		}	
		
		if ($aRow['user_id'] == Phpfox::getUserId())
		{
			define('PHPFOX_FEED_CAN_DELETE', true);
		}
		
		define('PHPFOX_CURRENT_USER_PROFILE', $aRow['user_id']);
		
		$sDescription = Phpfox::getPhrase('profile.full_name_is_on_site_title', array(
						'full_name' => $aRow['full_name'],
						'location' => $aRow['location'] . (empty($aRow['location_child']) ? '' : ', ' . $aRow['location_child']),
						'site_title' => Phpfox::getParam('core.site_title'),
						'meta_description_profile' => Phpfox::getParam('core.meta_description_profile'),
						'total_friend' => $aRow['total_friend']
					)
				);
		
		if (($iLinkId = $this->request()->get('link-id')) && ($aLinkShare = Link_Service_Link::instance()->getLinkById($iLinkId)) && isset($aLinkShare['link_id']))
		{
			$sPageTitle = $aLinkShare['title'];
			$sDescription = $aLinkShare['description'];
			$this->template()->setMeta('og:image', $aLinkShare['image']);			
		}
		
		$this->template()->setTitle($sPageTitle)
			->setMeta('description', $sDescription)
			->setEditor(array(
					'load' => 'simple',
					'wysiwyg' => ((Phpfox::isModule('comment') && Phpfox::getParam('comment.wysiwyg_comments')) && Phpfox::getUserParam('comment.wysiwyg_on_comments'))
				)
			)
			->setUrl('profile')
			->setHeader('cache', array(
					'feed.js' => 'module_feed',
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'quick_edit.js' => 'static_script',
					'jquery/plugin/jquery.highlightFade.js' => 'static_script'
				)
			);		
			
		(($sPlugin = Phpfox_Plugin::get('profile.component_controller_index_set_header')) ? eval($sPlugin) : false);
			
		if (Phpfox::isModule('video'))
		{
			$this->template()->setHeader('cache', array('video.css' => 'module_video'));
		}
		if ($sSection == 'designer')
		{			
			if ($aRow['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('profile.can_custom_design_own_profile'))
			{				
				if (($iTestStyle = $this->request()->get('test_style_id')))
				{
					if (Phpfox_Template::instance()->testStyle($iTestStyle))
					{
						
					}
				}
				
				$aDesigner = array(
					'current_style_id' => $aRow['designer_style_id'],
					'design_header' => Phpfox::getPhrase('profile.profile_designer'),
					'current_page' => $this->url()->makeUrl($aRow['user_name']),
					'design_page' => $this->url()->makeUrl($aRow['user_name'], 'designer'),
					'block' => 'profile.index',				
					'item_id' => $aRow['user_id'],
					'type_id' => 'profile',
					'css_code' => Theme_Service_Theme::instance()->getCssCode(array(
							'table_code' => 'user_css_code',
							'field' => 'user_id',
							'value' => $aRow['user_id']
						)
					)
				);
				
				$this->setParam('aDesigner', $aDesigner);
				
				(($sCmd = Phpfox_Template::instance()->getXml('design_css')) ? eval($sCmd) : null);
				
				if (isset($aAdvanced))
				{
				    Theme_Service_Theme::instance()->getDesignValues($aAdvanced, array(
						'table' => 'user_css',
						'field' => 'user_id',
						'value' => $aRow['user_id']						
					    )
				    );
				}								
				
				
				$this->template()
						->setPhrase(array(
								'theme.are_you_sure'
							)
						)
						->setImage(array(
								'css_edit_background' => 'layout/css_edit_background.png'
							)
						)
						->setHeader('cache', array(
							// 'jquery/plugin/jquery.bgiframe.js' => 'static_script',
							'jquery/ui.js' => 'static_script',							
							'style.css' => 'style_css',
							'select.js' => 'module_theme',
							'design.js' => 'module_theme',										
							'colorpicker.js' => 'static_script',
							'colorpicker.css' => 'style_css',
							'colorpicker/js/colorpicker.js' => 'static_script',
							'switch_legend.js' => 'static_script',
							'switch_menu.js' => 'static_script',
							'designer.js' => 'module_profile'
						)
					)
					->setHeader('cache', array(
							'design.js' => 'style_script'
						)
					)
					->setHeader(array(
							Phpfox::getLib('parse.css')->getJavaScript(),
							//'<script type="text/javascript">$Behavior.profile_controller_designon_update_2 = function(){ console.log("Creating designOnUpdate");function designOnUpdate() { $Core.design.updateSorting(); } };</script>',		
							//'<script type="text/javascript">$Behavior.profile_design_init_2 = function() { $Core.design.init({type_id: \'profile\'}); };</script>'
						)
					)
					;			
				
				if (isset($aAdvanced))
				{
				    $this->template()->assign(array(
						'aAdvanced' => $aAdvanced				
					)		
				    );
				}
				
				if (Phpfox::getParam('profile.can_drag_drop_blocks_on_profile'))
				{					
					$this->template()->setHeader('cache', array(
							'sort.js' => 'module_theme'
						)
					);
				}
			}
		}						
		else 
		{
			if (Phpfox::getParam('profile.can_drag_drop_blocks_on_profile') && $aRow['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('profile.can_custom_design_own_profile'))
			{				
				$this->template()->setHeader(array(						
						'jquery/ui.js' => 'static_script',
						'sort.js' => 'module_theme',
						'design.js' => 'module_theme',				
						'<script type="text/javascript">$Behavior.profile_controller_designonupdate_3 = function() { function designOnUpdate() { $Core.design.updateSorting(); } };</script>',
						'<script type="text/javascript">$Behavior.profile_controller_init_3 = function() { $Core.design.init({type_id: \'profile\'}); };</script>'
					)
				);	
			}			
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('profile.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>