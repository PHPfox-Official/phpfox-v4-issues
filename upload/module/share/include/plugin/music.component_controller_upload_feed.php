<?php
	if (isset($aVals['connection']) && isset($aVals['connection']['facebook']) & $aVals['connection']['facebook'] == '1')
	{
		echo "window.parent.FB.api('/me/feed', 'post', {link: '" . Phpfox::permalink('music', $aSong['song_id'], $aSong['title']) . "', message: '" . str_replace('\'', '\\\'', html_entity_decode($aVals['status_info'], null, 'UTF-8')) . "'}, function(response){});";
	}
	
	if (isset($aVals['connection']) && isset($aVals['connection']['twitter']) & $aVals['connection']['twitter'] == '1')
	{		
		Phpfox::getLib('twitter')->post(html_entity_decode($aVals['status_info'], null, 'UTF-8') . ' ' . Phpfox::permalink('music', $aSong['song_id'], $aSong['title']));		
	}
?>