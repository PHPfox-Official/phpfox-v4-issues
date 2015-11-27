<?php
if (Phpfox::getParam('facebook.enable_facebook_connect'))
{
	$this->database()->select('fbconnect.fb_user_id, fbconnect.is_unlinked AS fb_is_unlinked, fbconnect.share_feed AS fb_share_feed, fbconnect.send_email AS fb_send_email, ')->leftJoin(Phpfox::getT('fbconnect'), 'fbconnect', 'fbconnect.user_id = u.user_id');
}
?>