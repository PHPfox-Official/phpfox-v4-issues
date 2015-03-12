<?php
if (!PHPFOX_IS_AJAX)
{
	$mRedirectId = Phpfox::getService('subscribe.purchase')->getRedirectId();
	if (is_numeric($mRedirectId) && $mRedirectId > 0)
	{
		Phpfox::getLib('url')->send('subscribe.register', array('id' => $mRedirectId), Phpfox::getPhrase('subscribe.please_complete_your_purchase'));	
	}
}
?>