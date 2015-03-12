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
 * @version 		$Id: register.class.php 3077 2011-09-12 18:27:31Z Raymond_Benc $
 */
class User_Service_Register extends Phpfox_Service 
{
	public function getValidation($sStep = null)
	{		
		$aValidation = array();

		if ($sStep == 1 || $sStep === null)
		{
			$aValidation['full_name'] = Phpfox::getPhrase('user.provide_your_full_name');
			$aValidation['email'] = array(
				'def' => 'email',
				'title' => Phpfox::getPhrase('user.provide_a_valid_email_address')
			);
			$aValidation['password'] = array(
				'def' => 'password',
				'title' => Phpfox::getPhrase('user.provide_a_valid_password')
			);
			
			if (Phpfox::getParam('user.new_user_terms_confirmation'))
			{
				$aValidation['agree'] = array(
					'def' => 'checkbox',
					'title' => Phpfox::getPhrase('user.check_our_agreement_in_order_to_join_our_site')
				);
			}
			
			if (!Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up'))
			{
				$aValidation['user_name'] = array(
					'def' => 'username',
					'title' => Phpfox::getPhrase('user.provide_a_valid_user_name', array('min' => Phpfox::getParam('user.min_length_for_username'), 'max' => Phpfox::getParam('user.max_length_for_username')))
				);		
			}
		}

		if ($sStep == 2 || $sStep === null)
		{
			if (Phpfox::getParam('core.registration_enable_dob'))
			{
				$aValidation['month'] = Phpfox::getPhrase('user.select_month_of_birth');
				$aValidation['day'] = Phpfox::getPhrase('user.select_day_of_birth');
				$aValidation['year'] = Phpfox::getPhrase('user.select_year_of_birth');
			}
			if (Phpfox::getParam('core.registration_enable_location'))
			{
				$aValidation['country_iso'] = Phpfox::getPhrase('user.select_current_location');
			}
			if (Phpfox::getParam('core.registration_enable_gender'))
			{
				$aValidation['gender'] = Phpfox::getPhrase('user.select_your_gender');	
			}
		}	
		
		if (Phpfox::isModule('captcha') && Phpfox::getParam('user.captcha_on_signup') && $sStep === null)
		{
			$aValidation['image_verification'] = Phpfox::getPhrase('captcha.complete_captcha_challenge');
		}
		
		return $aValidation;
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_register__call'))
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