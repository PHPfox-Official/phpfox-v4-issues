<?php
if (Phpfox::getParam('janrain.enable_janrain_login'))
{
	Phpfox::getLib('template')->assign('bCustomLogin', true);
}
?>