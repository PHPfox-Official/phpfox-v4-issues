<?php
if (Phpfox::getParam('janrain.enable_janrain_login'))
{
	Phpfox_Template::instance()->assign('bCustomLogin', true);
}
?>