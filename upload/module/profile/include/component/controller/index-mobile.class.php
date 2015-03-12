<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: index-mobile.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class Profile_Component_Controller_Index_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = Phpfox::getService('user')->get($this->request()->get('req1'), false);	
		
		if (!isset($aUser['user_id']))
		{
			return Phpfox::getLib('module')->setController('error.404');
		}
		
		define('PHPFOX_IS_USER_PROFILE', true);
		
		$sImage = Phpfox::getLib('image.helper')->display(array_merge(array('user' => Phpfox::getService('user')->getUserFields(true, $aUser)), array(
                    'title' => $aUser['full_name'],
                    'path' => 'core.url_user',
                    'file' => $aUser['user_image'],
                    'suffix' => '_120',
                    'max_width' => 120,
                    'max_height' => 120,
                    'no_default' => (Phpfox::getUserId() == $aUser['user_id'] ? false : true),                    
                    'no_link' => true
                )
			)
		);	
		
		$oUser = Phpfox::getService('user');
		
		$aUser['gender_name'] = $oUser->gender($aUser['gender']);
		$aUser['birthday_time_stamp'] = $aUser['birthday'];		
		$aUser['birthday'] = $oUser->age($aUser['birthday']);
		$aUser['location'] = Phpfox::getPhraseT(Phpfox::getService('core.country')->getCountry($aUser['country_iso']), 'country');	
		if (isset($aUser['country_child_id']) && $aUser['country_child_id'] > 0)
		{
			$aUser['location_child'] = Phpfox::getService('core.country')->getChild($aUser['country_child_id']);
		}		
		
		$this->setParam('aUser', $aUser);
		
		$this->template()
			->setMobileHeader(array(
					'profile.css' => 'style_css'
				)
			);				
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'profile.view_profile'))
		{			
			return Phpfox::getLib('module')->setController('profile.private');	
		}
		
		Phpfox::getUserParam('profile.can_view_users_profile', true);	
		
		$aProfileMenu = array(
			$this->url()->makeUrl($aUser['user_name']) => Phpfox::getPhrase('profile.wall')
		);
		
		if (Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'profile.basic_info'))
		{
			$aProfileMenu[$this->url()->makeUrl($aUser['user_name'], 'info')] = Phpfox::getPhrase('profile.info');
		}		
		
		$this->template()
			->assign(array(
				'aUser' => $aUser,
				'sProfileImage' => $sImage,
				'bMobileProfileIsActive' => true,
				'aMobileSubMenus' => $aProfileMenu,
				'sActiveMobileSubMenu' => $this->url()->makeUrl($aUser['user_name'], ($this->request()->get('req2') == '' ? null : $this->request()->get('req2')))
			)		
		);
		
		if ($this->request()->get('req2') == 'info')
		{
			return Phpfox::getLib('module')->setController('profile.info-mobile');
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{		
			Phpfox::isUser(true);		

			if (isset($aVals['status']))
			{				
				if (!empty($aVals['status']))
				{
					if ($iId = Phpfox::getService('user.process')->updateStatus(Phpfox::getUserId(), $aVals['status']))
					{
						$this->url()->send($aUser['user_name']);
					}
				}
			}
			else 
			{				
				Phpfox::getUserParam('comment.can_post_comments', true);
				
				if (!Phpfox::getService('user.privacy')->hasAccess($aVals['item_id'], 'comment.add_comment'))
				{	
					Phpfox_Error::set(Phpfox::getPhrase('feed.you_do_not_have_permission_to_add_a_comment_on_this_persons_profile'));
				}				
				
				if (($iFlood = Phpfox::getUserParam('comment.comment_post_flood_control')) !== 0)
				{
					$aFlood = array(
						'action' => 'last_post', // The SPAM action
						'params' => array(
							'field' => 'time_stamp', // The time stamp field
							'table' => Phpfox::getT('feed'), // Database table we plan to check
							'condition' => 'type_id = \'comment_profile_my\' AND user_id = ' . Phpfox::getUserId(), // Database WHERE query
							'time_stamp' => $iFlood * 60 // Seconds);	
						)
					);
						 			
					// actually check if flooding
					if (Phpfox::getLib('spam')->check($aFlood))
					{				
						Phpfox_Error::set(Phpfox::getPhrase('feed.posting_a_comment_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());
					}		
				}
				
				if (Phpfox::getLib('parse.format')->isEmpty($aVals['feed_text']))
				{
					Phpfox_Error::set(Phpfox::getPhrase('feed.add_some_text_to_your_comment'));					
				}	

				if (Phpfox_Error::isPassed() && ($iId = Phpfox::getService('feed.process')->addComment($aVals)))
				{
					$this->url()->send($aUser['user_name']);	
				}
			}
		}		
		
		$bHideFeedOnProfile = false;	
		if (Phpfox::isModule('feed'))
		{
			$iFeedPage = $this->request()->get('page', 1);
			
			list($iFeedCount, $aFeeds) = Phpfox::getService('feed')->get($aUser['user_id'], null, $iFeedPage);				
			
			if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'feed.display_on_profile'))
			{
				$iFeedCount = 0;
				$aFeeds = array();	
				$bHideFeedOnProfile = true;
			}
			
			$iTotalFeeds = (int) Phpfox::getComponentSetting(Phpfox::getUserId(), 'feed.feed_display_limit_dashboard', Phpfox::getParam('feed.feed_display_limit'));
			
			Phpfox::getLib('pager')->set(array('page' => $iFeedPage, 'size' => $iTotalFeeds, 'count' => $iFeedCount));
			
			$this->template()->setMobileHeader(array(					
						'feed.css' => 'module_feed'
					)
				)
				->assign(array(				
					'aFeeds' => $aFeeds					
				)
			);
		}
		
		$this->template()->assign(array('bHideFeedOnProfile' => $bHideFeedOnProfile));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('profile.component_controller_index_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>