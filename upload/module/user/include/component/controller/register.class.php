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
 * @version 		$Id: register.class.php 7153 2014-02-24 16:10:37Z Fern $
 */
class User_Component_Controller_Register extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		if (!Phpfox::getParam('user.allow_user_registration'))
		{
			$this->url()->send('');	
		}
		
		define('PHPFOX_DONT_SAVE_PAGE', true);
		
		if (Phpfox::isUser())
		{
			$this->url()->send('profile');
		}

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => Phpfox::getService('user.register')->getValidation()));
		if ($aVals = $this->request()->getArray('val'))
		{
			if (Phpfox::isModule('invite') && Phpfox::getService('invite')->isInviteOnly())
			{
				if (Phpfox::getService('invite')->isValidInvite($aVals['invite_email']))
				{
					$iExpire = (Phpfox::getParam('invite.invite_expire') > 0 ? (Phpfox::getParam('invite.invite_expire')*60*60*24) : (7*60*60*24));
					
					Phpfox::setCookie('invite_only_pass', $aVals['invite_email'], PHPFOX_TIME + $iExpire);
					
					$this->url()->send('user.register');
				}
			}
			else 
			{
				if (!Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up'))
				{
					// http://www.phpfox.com/tracker/view/15155/
					$aVals['user_name'] = str_replace(' ', '-', $aVals['user_name']);
					$aVals['user_name'] = str_replace('_', '-', $aVals['user_name']);
					Phpfox::getService('user.validate')->user($aVals['user_name']);
				}		
				(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_1')) ? eval($sPlugin) : false);
	
				Phpfox::getService('user.validate')->email($aVals['email']);
				
				if (Phpfox::getParam('user.reenter_email_on_signup'))
				{
					if (empty($aVals['email']) || empty($aVals['confirm_email']))
					{
						Phpfox_Error::set(Phpfox::getPhrase('user.email_s_do_not_match'));
					}
					else
					{
						if ($aVals['email'] != $aVals['confirm_email'])
						{
							Phpfox_Error::set(Phpfox::getPhrase('user.email_s_do_not_match'));
						}
					}
				}	
				
				(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_2')) ? eval($sPlugin) : false);
				if ($oValid->isValid($aVals))
				{
					if ($iId = Phpfox::getService('user.process')->add($aVals))
					{
						if (Phpfox::getService('user.auth')->login($aVals['email'], $aVals['password']))
						{						
							if (is_array($iId))
							{
								(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_3')) ? eval($sPlugin) : false);
								$this->url()->forward($iId[0]);	
							}
							else 
							{
								$sRedirect = Phpfox::getParam('user.redirect_after_signup');
								
								if (!empty($sRedirect))
								{
									(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_4')) ? eval($sPlugin) : false);
									$this->url()->send($sRedirect);
								}
								
								if (Phpfox::getParam('user.multi_step_registration_form') && is_array(Phpfox::getParam('user.registration_steps')) && count(Phpfox::getParam('user.registration_steps')))
								{
									$aUrls = Phpfox::getParam('user.registration_steps');
									
									(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_5')) ? eval($sPlugin) : false);
									$this->url()->send($aUrls[0], 'register');
								}
								else 
								{
									(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_6')) ? eval($sPlugin) : false);
									if (Phpfox::getLib('session')->get('appinstall') != '')
									{
										$this->url()->send('apps.install.' . Phpfox::getLib('session')->get('appinstall'));
									}
									else
									{
										$this->url()->send('');
									}
								}
							}
						}
					}
					else 
					{
						if (Phpfox::getParam('user.multi_step_registration_form'))
						{
							$this->template()->assign('bIsPosted', true);
							(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_7')) ? eval($sPlugin) : false);
						}					
					}				
				}
				else
				{				
					$this->template()->assign(array(
							'bCorrectUsername' => (!Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up') ? Phpfox::getService('user.validate')->user($aVals['user_name']) : ''),
							'sUsername' => ((!Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up')) ? $aVals['user_name'] : ''),
							'iTimeZonePosted' => (isset($aVals['time_zone']) ? $aVals['time_zone'] : 0)
						)
					);
					
					if (Phpfox::getParam('user.multi_step_registration_form'))
					{
						$this->template()->assign('bIsPosted', true);
					}
					
					$this->setParam(array(
							'country_child_value' => (isset($aVals['country_iso']) ? $aVals['country_iso'] : 0),
							'country_child_id' => (isset($aVals['country_child_id']) ? $aVals['country_child_id'] : 0)
						)
					);				
				}
			}
		}	
		else
		{
			if (($sSentCookie = Phpfox::getCookie('invited_by_email_form')))
			{
				$this->template()->assign('aForms', array('email' => $sSentCookie));
			}			
		}

		$sTitle = Phpfox::getPhrase('user.sign_and_start_using_site', array('site' => Phpfox::getParam('core.site_title')));

		(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_8')) ? eval($sPlugin) : false);

		$this->template()->setTitle($sTitle)			
			// ->setBreadcrumb($sTitle)
			->setFullSite()
			->setPhrase(array(
					'user.continue'
				)
			)
			->setHeader('cache', array(
					'register.css' => 'module_user',
					'register.js' => 'module_user',					
					'country.js' => 'module_core'
				)
			)
			->assign(array(
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'sSiteUrl' => Phpfox::getParam('core.path'),
				'aTimeZones' => Phpfox::getService('core')->getTimeZones(),
				'aPackages' => (Phpfox::isModule('subscribe') ? Phpfox::getService('subscribe')->getPackages(true) : null),
				'aSettings' => Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), null, null, true),
				'sDobStart' => Phpfox::getParam('user.date_of_birth_start'),
				'sDobEnd' => Phpfox::getParam('user.date_of_birth_end'),
				'sJanrainUrl' => (Phpfox::isModule('janrain') ? Phpfox::getService('janrain')->getUrl() : ''),
				'sUserEmailCookie' => Phpfox::getCookie('invited_by_email_form'),
				'sSiteTitle' => Phpfox::getParam('core.site_title')
			)
		);
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_clean')) ? eval($sPlugin) : false);
	}
}

?>
