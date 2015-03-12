<?php
if (Phpfox::getParam('facebook.enable_facebook_connect') && (int) Phpfox::getUserBy('fb_user_id') > 0)
{
	if (Phpfox::getLib('request')->get('req1') == 'facebook' && Phpfox::getLib('request')->get('req2') == 'unlink')
	{
		
	}
	else
	{
		Phpfox::getLib('url')->send('facebook.logout');
	}
}
?>