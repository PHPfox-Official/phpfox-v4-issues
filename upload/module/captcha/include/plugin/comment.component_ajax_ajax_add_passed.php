<?php
if (Phpfox::getParam('captcha.recaptcha') && $aVals['type'] != 'feed' && Phpfox::isModule('captcha') && Phpfox::getUserParam('captcha.captcha_on_comment'))
{
	require_once(PHPFOX_DIR_LIB . 'recaptcha' . PHPFOX_DS . 'recaptchalib.php');
	
	$this->call('Recaptcha.reload();');
}
?>