<?php
if (Phpfox::getParam('facebook.enable_facebook_connect'))
{
	$this->database()->select('fbconnect.fb_user_id, ')->leftJoin(Phpfox::getT('fbconnect'), 'fbconnect', 'fbconnect.user_id = u.user_id');
}
?>