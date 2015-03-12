<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

define('PHPFOX_DONT_SAVE_PAGE', true);

/**
 * This controller receives the link for verifying a member's email address
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_User
 * @version 		$Id: browse.class.php 719 2009-06-29 12:23:19Z Miguel_Espinoza $
 */
class User_Component_Controller_Verify extends Phpfox_Component
{
	/**
	 * Class process method which is used to execute this component.
	 */
	public function process()
	{
		$this->template()->setTitle(Phpfox::getPhrase('user.email_verification'))->setBreadcrumb(Phpfox::getPhrase('user.email_verification'))
			->assign(array(
					'iVerifyUserId' => Phpfox::getLib('session')->get('cache_user_id')
				)
			);
		
		$sHash = $this->request()->get('link', '');
		if ($sHash == '')
		{
			
		}
		elseif (Phpfox::getService('user.verify.process')->verify($sHash))
		{
			if ($sPlugin = Phpfox_Plugin::get('user.component_verify_process_redirection'))
			{
				eval($sPlugin);
			}				
			
			$sRedirect = Phpfox::getParam('user.redirect_after_signup');
							
			if (!empty($sRedirect))
			{
				Phpfox::getLib('session')->set('redirect', str_replace('.', '/', $sRedirect));
			}			
			
			if (Phpfox::isMobile())
			{
				$this->url()->send('mobile.user.login', null, Phpfox::getPhrase('user.your_email_has_been_verified_please_log_in_with_the_information_you_provided_during_sign_up'));
			}
			// send to the log in and say everything is ok
			Phpfox::getLib('session')->set('verified_do_redirect', '1');
			$this->url()->send('user.login', null, Phpfox::getPhrase('user.your_email_has_been_verified_please_log_in_with_the_information_you_provided_during_sign_up'));
		}
		else
		{
			//send to the log in and say there was an error
			Phpfox_Error::set(Phpfox::getPhrase('user.invalid_verification_link'));
			$iTime = Phpfox::getParam('user.verify_email_timeout');
			if ($iTime < 60)
			{
				$sTime = Phpfox::getPhrase('user.time_minutes', array('time' => $iTime));
			}
			elseif ($iTime < (60 * 60 * 24)) // one day
			{			
				$sTime = ($iTime == 60 ? Phpfox::getPhrase('user.time_hour', array('time' => round($iTime / 60))) : Phpfox::getPhrase('user.time_hours', array('time' => round($iTime / 60))));
			}
			else
			{
				$sTime = Phpfox::getPhrase('user.time_days', array('time' => $sTime));
			}
			Phpfox::getService('user.verify.process')->sendMail(Phpfox::getLib('session')->get('cache_user_id'));
			$this->template()->assign(array('sTime' => $sTime));
		}		
	}
}
?>