<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: upload.html.php 527 2009-05-15 08:09:10Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

if (Phpfox::getParam('core.default_music_player') == 'flowplayer' && empty($aVideo['embed']))
{
	$sConfig = '{\'clip\':{';
	if (preg_match("/\{file\/videos\/(.*)\/(.*)\.flv\}/i", $aVideo['destination'], $aMatches))
	{
		$sConfig .= '\'baseUrl\': \'' . Phpfox::getParam('core.path') . '\',';
		$sConfig .= '\'url\': \'' . str_replace(array('{', '}'), '', $aMatches[0]) . '\',';
	}
	else
	{
		if ($aVideo['server_id'] && Phpfox::getParam('core.allow_cdn'))
		{
			$sBaseUrl = Phpfox::getLib('cdn')->getUrl(Phpfox::getParam('video.url'), $aVideo['server_id'], true);
			if (Phpfox::getParam('core.enable_amazon_expire_urls') && Phpfox::getParam('core.amazon_s3_expire_url_timeout') > 0)
			{
				$sBaseUrl = preg_replace('/?.+/', '', Phpfox::getLib('cdn')->getUrl(Phpfox::getParam('video.url'), $aVideo['server_id'], true));
			}
		
			$sConfig .= '\'baseUrl\': \'' . $sBaseUrl . '\',';
		}		
		else
		{
			$sConfig .= '\'baseUrl\': \'' . Phpfox::getParam('video.url') . '\',';
		}
		$sConfig .= '\'url\': \'' . $aVideo['destination'] . '\',';
	}
	$sConfig .= '\'autoBuffering\': true,';
	$sConfig .= '\'autoPlay\': false';
	$sConfig .= '}';
	$sConfig .= '}';

	$aVideo['embed'] = '<object width="640" height="390">';
	$aVideo['embed'] .= '<embed width="640" height="390" type="application/x-shockwave-flash" wmode="transparent" src="' . Phpfox::getParam('core.url_static_script') . 'player/flowplayer/flowplayer.swf?config=' . $sConfig . '"></embed>';
	$aVideo['embed'] .= '</object>';

	$aVideo['embed'] = htmlspecialchars($aVideo['embed']);
}
?>