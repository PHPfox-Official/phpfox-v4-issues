<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * User Settings
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			natio
 * @package  		Module_User
 * @version 		$Id: setting.class.php 5463 2013-03-01 08:37:09Z Miguel_Espinoza $
 */
class User_Component_Controller_Setting extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		
		Phpfox::isUser(true);
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
		$aVals = $this->request()->getArray('val');
		
		if (!isset($aUser['user_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('user.unable_to_edit_this_account'));
		}	
		
		/*if (!empty($aUser['signature']))
		{
			$aUser['signature'] = preg_replace("/<br\s*\/?>/is", "\n", $aUser['signature']);
		}*/
		
		/*$aValidation = array(			
			'country_iso' => Phpfox::getPhrase('user.select_current_location')					
		);	*/		
		
		if (Phpfox::getUserParam('user.can_change_email'))
		{
			$aValidation['email'] = array(
				'def' => 'email',
				'title' => Phpfox::getPhrase('user.provide_a_valid_email_address')
			);
		}
		
		/*if (Phpfox::getUserParam('user.can_edit_gender_setting'))
		{
			$aValidation['gender'] = Phpfox::getPhrase('user.select_your_gender');
		}*/
		
		/*if (Phpfox::getUserParam('user.can_edit_dob'))
		{
			$aValidation['month'] = Phpfox::getPhrase('user.select_month_of_birth');
			$aValidation['day'] = Phpfox::getPhrase('user.select_day_of_birth');
			$aValidation['year'] = Phpfox::getPhrase('user.select_year_of_birth');
		}	*/
		
		/*if (!empty($aVals['postal_code']))
		{
			$aValidation['postal_code'] = array('def' => 'zip', 'title' => Phpfox::getPhrase('user.zip_postal_code_is_invalid'));				
		}*/

		if (Phpfox::getUserParam('user.can_change_own_full_name'))
		{
			$aValidation['full_name'] = Phpfox::getPhrase('user.provide_your_full_name');
		}
		if (Phpfox::getUserParam('user.can_change_own_user_name') && !Phpfox::getParam('user.profile_use_id'))
		{
			$aValidation['user_name'] = array('def' => 'username', 'title' => Phpfox::getPhrase('user.provide_a_user_name'));
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_setting_process_validation')) ? eval($sPlugin) : false);

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));
		
		if (count($aVals))
		{			
			(($sPlugin = Phpfox_Plugin::get('user.component_controller_setting_process_check')) ? eval($sPlugin) : false);			
			
			if ($oValid->isValid($aVals))
			{
				$bAllowed = true;
				$sMessage = Phpfox::getPhrase('user.account_settings_updated');
				
				if (Phpfox::getUserParam('user.can_change_email') && $aUser['email'] != $aVals['email'])
				{					
					$bAllowed = Phpfox::getService('user.verify.process')->changeEmail($aUser, $aVals['email']);
					if (is_string($bAllowed))
					{						
						Phpfox_Error::set($bAllowed);
						$bAllowed = false;
					}
					
					if (Phpfox::getParam('user.verify_email_at_signup'))
					{
						$sMessage = Phpfox::getPhrase('user.account_settings_updated_your_new_mail_address_requires_verification_and_an_email_has_been_sent_until_then_your_email_remains_the_same');
						if (Phpfox::getParam('user.logout_after_change_email_if_verify'))
						{
							$this->url()->send('user.verify', null, Phpfox::getPhrase('user.email_updated_you_need_to_verify_your_new_email_address_before_logging_in'));	
						}
					}					
				}
				
				if ($bAllowed && ($iId = Phpfox::getService('user.process')->update(Phpfox::getUserId(), $aVals, array(
								'changes_allowed' => Phpfox::getUserParam('user.total_times_can_change_user_name'),
								'total_user_change' => $aUser['total_user_change'],
								'full_name_changes_allowed' => Phpfox::getUserParam('user.total_times_can_change_own_full_name'),
								'total_full_name_change' => $aUser['total_full_name_change'],
								'current_full_name' => $aUser['full_name']
							), true
						)
					)
				)
				{
					$this->url()->send('user.setting', null, $sMessage);
				}				
			}
		}		
		
		if (!empty($aUser['birthday']))
		{
			$aUser = array_merge($aUser, Phpfox::getService('user')->getAgeArray($aUser['birthday']));
		}		
		
		$aGateways = Phpfox::getService('api.gateway')->getActive();		
        if (!empty($aGateways))
		{
            $aGatewayValues = Phpfox::getService('api.gateway')->getUserGateways($aUser['user_id']);
            foreach ($aGateways as $iKey => $aGateway)
            {
                foreach ($aGateway['custom'] as $iCustomKey => $aCustom)
                {
                    if (isset($aGatewayValues[$aGateway['gateway_id']]['gateway'][$iCustomKey]))
                    {
                        $aGateways[$iKey]['custom'][$iCustomKey]['user_value'] = $aGatewayValues[$aGateway['gateway_id']]['gateway'][$iCustomKey];
                    }
                }
            }	
        }
        
		$aTimeZones = Phpfox::getService('core')->getTimeZones();
		if (count($aTimeZones) > 100) // we are using the php 5.3 way
		{
			$this->template()->setHeader('cache', array('setting.js' => 'module_user'));
		}
		$sFullNamePhrase = Phpfox::getUserParam('user.custom_name_field');	
		
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_setting_settitle')) ? eval($sPlugin) : false);
			
		if (Phpfox::getParam('user.split_full_name') && empty($aUser['first_name']) && empty($aUser['last_name']))
		{
			preg_match('/(.*) (.*)/', $aUser['full_name'], $aNameMatches);
			if (isset($aNameMatches[1]) && isset($aNameMatches[2]))
			{
				$aUser['first_name'] = $aNameMatches[1];
				$aUser['last_name'] = $aNameMatches[2];
			}
			else
			{
				$aUser['first_name'] = $aUser['full_name'];
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('user.account_settings'))
			->setBreadcrumb(Phpfox::getPhrase('user.account_settings'))
			->setFullSite()
			->setHeader('cache', array(
					'country.js' => 'module_core',
					'<script type="text/javascript">sSetTimeZone = "' . Phpfox::getUserBy('time_zone') . '";</script>'
				)
			)
			->assign(array(
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'aForms' => $aUser,
				'aTimeZones' => $aTimeZones,
				'sFullNamePhrase' => (empty($sFullNamePhrase) ? Phpfox::getPhrase('user.full_name') : Phpfox::getPhrase($sFullNamePhrase)),
				'iTotalChangesAllowed' => Phpfox::getUserParam('user.total_times_can_change_user_name'),
				'iTotalFullNameChangesAllowed' => Phpfox::getUserParam('user.total_times_can_change_own_full_name'),
				'aLanguages' => Phpfox::getService('language')->get(array('l.user_select = 1')),
				'sDobStart' => Phpfox::getParam('user.date_of_birth_start'),
				'sDobEnd' => Phpfox::getParam('user.date_of_birth_end'),
				'aCurrencies' => Phpfox::getService('core.currency')->get(),
				'aGateways' => $aGateways				
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_setting_clean')) ? eval($sPlugin) : false);
	}
}

?>