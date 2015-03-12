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
 * @version 		$Id: privacy.class.php 4514 2012-07-17 10:38:33Z Miguel_Espinoza $
 */
class User_Component_Controller_Privacy extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		if (!Phpfox::getUserParam('user.can_control_notification_privacy') && !Phpfox::getUserParam('user.can_control_profile_privacy'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('user.privacy_settings_have_been_disabled_for_your_user_group'));
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('user.privacy.process')->update($aVals))
			{
				$this->url()->send('user.privacy', null, Phpfox::getPhrase('user.privacy_settings_successfully_updated'));
			}
		}

		list($aUserPrivacy, $aNotifications, $aProfiles, $aItems) = Phpfox::getService('user.privacy')->get();
		
		$aUserInfo = Phpfox::getService('user')->get(Phpfox::getUserId());		
		
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_index_process')) ? eval($sPlugin) : false);

			$aMenus = array(
				'profile' => Phpfox::getPhrase('user.profile'),
				'items' => Phpfox::getPhrase('user.items'),
				'notifications' => Phpfox::getPhrase('user.notifications'),
				'blocked' => Phpfox::getPhrase('user.blocked_users')				
			);
			
			if (!Phpfox::isModule('privacy'))
			{
				unset($aMenus['items']);
			}
			
			if (Phpfox::getUserParam('user.can_be_invisible'))
			{
				$aMenus['invisible'] = Phpfox::getPhrase('user.invisible_mode');
			}

			$this->template()->buildPageMenu('js_privacy_block', 
				$aMenus,
				array(
					'no_header_border' => true,
					'link' => $this->url()->makeUrl(Phpfox::getUserBy('user_name')),
					'phrase' => Phpfox::getPhrase('user.view_your_profile')
				)				
			);		
		
		
		if ($this->request()->get('view') == 'blocked')
		{
			$this->template()->assign(array('bGoToBlocked' => true));
		}
		$this->template()->setTitle(Phpfox::getPhrase('user.privacy_settings'))
			->setBreadcrumb(Phpfox::getPhrase('user.privacy_settings'))
			->setFullSite()
			->setHeader(array(
					'privacy.css' => 'module_user'
				)
			)
			->assign(array(
					'aForms' => $aUserPrivacy['privacy'],
					'aPrivacyNotifications' => $aNotifications,
					'aProfiles' => $aProfiles,
					'aUserPrivacy' => $aUserPrivacy,
					'aBlockedUsers' => Phpfox::getService('user.block')->get(),
					'aUserInfo' => $aUserInfo,
					'aItems' => $aItems
				)
			);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>