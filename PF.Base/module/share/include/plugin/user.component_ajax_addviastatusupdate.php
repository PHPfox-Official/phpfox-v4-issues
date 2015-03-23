<?php

	if (isset($aVals['connection']) && isset($aVals['connection']['facebook']) & $aVals['connection']['facebook'] == '1')
	{
		$this->call("FB.api('/me/feed', 'post', {link: '" . Phpfox::permalink('poll', $iPollId, $aPoll['question']) . "', message: '" . str_replace('\'', '\\\'', html_entity_decode($aPoll['question'], null, 'UTF-8')) . "'}, function(response){});");		
	}
	
	if (isset($aVals['connection']) && isset($aVals['connection']['twitter']) & $aVals['connection']['twitter'] == '1')
	{		
		Phpfox::getLib('twitter')->post(html_entity_decode($aPoll['question'], null, 'UTF-8') . ' ' . Phpfox::permalink('poll', $iPollId, $aPoll['question']));		
	}

?>
