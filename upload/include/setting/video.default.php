<?php

/**
 * #############################
 * 
 * #############################
 **/

$_CONF['video.upload_for_html5'] = false;
$_CONF['video.video_array_support'] = array(
		'mpg' => 'video/mpeg',
		'mpeg' => 'video/mpeg',			
		'wmv' => 'video/x-ms-wmv',
		'avi' => 'video/avi',
		'mov' => 'video/quicktime',
		'flv' => 'video/x-flv',
		'mp4' => 'video/mp4',
		'mov' => 'video/quicktime',
		'flv' => 'video/x-flv',
		'wmv' => 'video/x-ms-wmv',
		'mpg' => 'video/mpeg',
		'mpeg' => 'video/mpeg',
		'm4v' => 'video/x-m4v',
		'avi' => 'video/avi',
		'webm' => 'video/webm',
		'ogv' => 'video/ogg',
		'mkv' => 'video/x-matroska',
		'mts' => 'video/avchd'
	);

$_CONF['video.covert_mp4_exec'] = array(
		'/usr/local/bin/ffmpeg -i {SOURCE} -vcodec libx264 {DESTINATION}'
	);

$_CONF['video.covert_webm_exec'] = array(
		'/usr/local/bin/ffmpeg -i {SOURCE} -vcodec libvpx -acodec libvorbis -f webm {DESTINATION}'
	);

$_CONF['video.covert_ogg_exec'] = array(
		'/usr/local/bin/ffmpeg -i {SOURCE} -vcodec libtheora -acodec libvorbis {DESTINATION}'
	);

$_CONF['video.covert_mp4_image'] = array(
		'/usr/local/bin/ffmpeg -ss 0.5 -i {SOURCE} -t 1 -s 480x300 {DESTINATION}'
	);

$_CONF['video.convert_servers_enable'] = false;
$_CONF['video.convert_js_parent'] = '';
$_CONF['video.convert_servers'] = array(
			''
		);
$_CONF['video.convert_servers_secret'] = '';

?>
