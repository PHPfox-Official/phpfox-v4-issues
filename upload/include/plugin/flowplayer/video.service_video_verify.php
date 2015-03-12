<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: video.service_video_verify.php 1259 2009-11-17 21:40:32Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

if (Phpfox::getParam('core.default_music_player') == 'flowplayer' && !$aVideo['is_stream'])
{
	$sConfig = '{\'clip\':{';
	$sConfig .= '\'baseUrl\': \'' . Phpfox::getParam('video.url') . '\',';
	$sConfig .= '\'url\': \'' . $aVideo['destination'] . '\',';
	$sConfig .= '\'autoBuffering\': true,';
	$sConfig .= '\'autoPlay\': false';	
	$sConfig .= '}';
	$sConfig .= '}';

	$aVideo['embed_code'] = '<object width="430" height="344">';
	$aVideo['embed_code'] .= '<embed width="430" height="344" type="application/x-shockwave-flash" wmode="transparent" src="' . Phpfox::getParam('core.url_static_script') . 'player/flowplayer/flowplayer.swf?config=' . $sConfig . '"></embed>';
	$aVideo['embed_code'] .= '</object>';	
}
?>