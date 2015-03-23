<?php
if (Phpfox::getParam('facebook.enable_facebook_connect'))
{
	Phpfox_Template::instance()->assign('bCustomLogin', true);
}
?>