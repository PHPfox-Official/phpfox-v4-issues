<?php
	if (Phpfox::getParam('facebook.enable_facebook_connect') && Phpfox::getUserBy('fb_user_id'))
	{
		if (empty($aVals['email']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('user.provide_a_valid_email_address'));
		}
		else 
		{
			if (preg_match('/^apps\+(.*)@proxymail\.facebook\.com$/i', $aVals['email']))
			{
				
			}
			else 
			{
				Phpfox::getLib('validator')->verify('email', $aVals['email']);
			}
		}
	}
?>