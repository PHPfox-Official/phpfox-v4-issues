<?php
$aFeed = Phpfox::getService('feed')->get(Phpfox::getUserId(), $iFeedId);

if (isset($aFeed[0]) && isset($aFeed[0]['feed_id']))
{
	if ($this->get('facebook_connection') == '1')
	{
		// http://www.phpfox.com/tracker/view/15405/
		$sTxt = $aFeed[0]['feed_status'];
		if(Phpfox::isModule('emoticon'))
		{
			$aPackages = Phpfox::getService('emoticon')->getPackages();
			foreach($aPackages as $aPackage)
			{
				$aEmoticons = Phpfox::getService('emoticon')->getEmoticons($aPackage['package_path']);
				foreach($aEmoticons as $aEmoticon)
				{
					// Original
					$sSearch = '<img src="' . Phpfox::getParam('core.url_emoticon') . $aEmoticon['package_path'] . '/' . $aEmoticon['image'] . '" alt="' . $aEmoticon['title'] . '" title="' . $aEmoticon['title'] . '" class="v_middle" />';
					$sTxt = str_replace($sSearch, $aEmoticon['text'], $sTxt);
					// Failsafe - Fallback
					$sSearch = '<img src="' . Phpfox::getParam('core.url_emoticon') . $aEmoticon['package_path'] . '/' . $aEmoticon['image'] . '" alt="' . $aEmoticon['title'] . '" title="' . $aEmoticon['title'] . '" title="v_middle" />';
					$sTxt = str_replace($sSearch, $aEmoticon['text'], $sTxt);
				}
			}
		}
		
		$this->call("FB.api('/me/feed', 'post', {link: '" . $aFeed[0]['feed_link'] . "', message: '" . str_replace('\'', '\\\'', html_entity_decode($sTxt, null, 'UTF-8')) . "'}, function(response){});");		
	}

	if ($this->get('twitter_connection') == '1')
	{		
		Phpfox::getLib('twitter')->post(html_entity_decode($aFeed[0]['feed_content'], null, 'UTF-8') . ' ' . $aFeed[0]['feed_link']);
	}
}
?>
