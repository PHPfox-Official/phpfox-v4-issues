<?php
if (Phpfox::getParam('facebook.enable_facebook_connect') && (int) Phpfox::getUserBy('fb_user_id') > 0)
{
	if (Phpfox_Request::instance()->get('req1') == 'facebook' && Phpfox_Request::instance()->get('req2') == 'unlink')
	{
		
	}
	else
	{
		Phpfox_Url::instance()->send('facebook.logout');
	}
}
?>