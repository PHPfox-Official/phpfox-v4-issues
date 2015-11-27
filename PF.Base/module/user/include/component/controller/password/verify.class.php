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
 * @version 		$Id: verify.class.php 4030 2012-03-20 12:28:59Z Miguel_Espinoza $
 */
class User_Component_Controller_Password_Verify extends Phpfox_Component 
{
	/**
	 * Process the controller
	 *
	 */
	public function process()
	{
		if (Phpfox::isUser())
		{
			$this->url()->send('');
		}		
		
		if ($sRequest = $this->request()->get('id'))
		{
			if ( ($aVals = $this->request()->getArray('val')))
			{
				if (!isset($aVals['newpassword']) || !isset($aVals['newpassword2']) || $aVals['newpassword'] != $aVals['newpassword2'])
				{
					Phpfox_Error::set(Phpfox::getPhrase('user.your_confirmed_password_does_not_match_your_new_password'));
				}
				else
				{
					if (Phpfox::getService('user.password')->updatePassword($sRequest, $aVals))
					{
						$this->url()->send('user.password.verify', null, Phpfox::getPhrase('user.password_successfully_updated'));
					}					
				}
			}
			// else
			{
				if (Phpfox::getParam('user.shorter_password_reset_routine'))
				{
					if (Phpfox::getService('user.password')->isValidRequest($sRequest) == true)
					{
						$this->template()->assign(array('sRequest' => $sRequest));
					}
					else
					{
					
					}
				}
				else
				{
					if (Phpfox::getService('user.password')->verifyRequest($sRequest))
					{
						$this->url()->send('user.password.verify', null, Phpfox::getPhrase('user.new_password_successfully_sent_check_your_email_to_use_your_new_password'));
					}
				}
			}
			
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('user.password_request_verification'))->setBreadcrumb(Phpfox::getPhrase('user.password_request_verification'));
	}
}

?>