<?php
if (Phpfox::getParam('facebook.enable_facebook_connect'))
{
	if (Phpfox::getUserBy('fb_user_id'))
	{
		unset($aValidation['email']);	
	}
}
?>