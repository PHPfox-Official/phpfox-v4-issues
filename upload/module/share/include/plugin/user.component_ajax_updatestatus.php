<?php

	if (isset($aVals['connection']) && isset($aVals['connection']['facebook']) & $aVals['connection']['facebook'] == '1' && !empty($aVals['user_status']))
	{
		$this->call("FB.api('/me/feed', 'post', {message: '" . str_replace('\'', '\\\'', html_entity_decode($aVals['user_status'], null, 'UTF-8')) . "'}, function(response){});");		
	}
	
	if (isset($aVals['connection']) && isset($aVals['connection']['twitter']) & $aVals['connection']['twitter'] == '1' && !empty($aVals['user_status']))
	{		
		Phpfox::getLib('twitter')->post(html_entity_decode($aVals['user_status'], null, 'UTF-8'));		
	}	

 ?>