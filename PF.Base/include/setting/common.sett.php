<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: common.sett.php 7303 2014-05-07 17:43:19Z Fern $
 */

defined('PHPFOX') or exit('NO DICE!');

$_CONF['core.http'] = 'https://';
$_CONF['core.https'] = 'http://';

$_CONF['core.path'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' . $_CONF['core.host'] . $_CONF['core.folder'];

$_CONF['core.dir_file'] = PHPFOX_DIR . 'file' . PHPFOX_DS;
$_CONF['core.url_file'] = $_CONF['core.path'] . 'file/';
$_CONF['core.dir_cache'] = $_CONF['core.dir_file'] . 'cache' . PHPFOX_DS;
$_CONF['core.url_module'] = $_CONF['core.path'] . 'module/';

/* /file/ directories */
$_CONF['core.dir_pic'] = $_CONF['core.dir_file'] . 'pic' . PHPFOX_DS;
$_CONF['core.url_pic'] = $_CONF['core.url_file'] . 'pic/';

$_CONF['core.dir_attachment'] = $_CONF['core.dir_file'] . 'attachment' . PHPFOX_DS;
$_CONF['core.url_attachment'] = $_CONF['core.url_file'] . 'attachment/';

$_CONF['core.dir_emoticon'] = $_CONF['core.dir_pic'] . 'emoticon' . PHPFOX_DS;
$_CONF['core.url_emoticon'] = $_CONF['core.url_pic'] . 'emoticon/';

$_CONF['core.dir_user'] = $_CONF['core.dir_pic'] . 'user' . PHPFOX_DS;
$_CONF['core.url_user'] = $_CONF['core.url_pic'] . 'user/';

$_CONF['photo.dir_photo'] = $_CONF['core.dir_pic'] . 'photo' . PHPFOX_DS;
$_CONF['photo.url_photo'] = $_CONF['core.url_pic'] . 'photo/';

$_CONF['poll.dir_image'] = $_CONF['core.dir_pic'] . 'poll' . PHPFOX_DS;
$_CONF['poll.url_image'] = $_CONF['core.url_pic'] . 'poll/';

$_CONF['quiz.dir_image'] = $_CONF['core.dir_pic'] . 'quiz' . PHPFOX_DS;
$_CONF['quiz.url_image'] = $_CONF['core.url_pic'] . 'quiz/';

$_CONF['egift.dir_egift'] = $_CONF['core.dir_pic'] . 'egift' . PHPFOX_DS;
$_CONF['egift.url_egift'] = $_CONF['core.url_pic'] . 'egift/';

$_CONF['marketplace.dir_image'] = $_CONF['core.dir_pic'] . 'marketplace' . PHPFOX_DS;
$_CONF['marketplace.url_image'] = $_CONF['core.url_pic'] . 'marketplace/';

$_CONF['app.dir_image'] = $_CONF['core.dir_pic'] . 'app' . PHPFOX_DS;
$_CONF['app.url_image'] = $_CONF['core.url_pic'] . 'app/';

$_CONF['event.dir_image'] = $_CONF['core.dir_pic'] . 'event' . PHPFOX_DS;
$_CONF['event.url_image'] = $_CONF['core.url_pic'] . 'event/';

$_CONF['pages.dir_image'] = $_CONF['core.dir_pic'] . 'pages' . PHPFOX_DS;
$_CONF['pages.url_image'] = $_CONF['core.url_pic'] . 'pages/';

$_CONF['group.dir_image'] = $_CONF['core.dir_pic'] . 'group' . PHPFOX_DS;
$_CONF['group.url_image'] = $_CONF['core.url_pic'] . 'group/';

$_CONF['share.dir_image'] = $_CONF['core.dir_pic'] . 'bookmark' . PHPFOX_DS;
$_CONF['share.url_image'] = $_CONF['core.url_pic'] . 'bookmark/';

$_CONF['music.dir'] = $_CONF['core.dir_file'] . 'music' . PHPFOX_DS;
$_CONF['music.url'] = $_CONF['core.url_file'] . 'music/';

$_CONF['music.dir_image'] = $_CONF['core.dir_pic'] . 'music' . PHPFOX_DS;
$_CONF['music.url_image'] = $_CONF['core.url_pic'] . 'music/';

$_CONF['video.dir'] = $_CONF['core.dir_file'] . 'video' . PHPFOX_DS;
$_CONF['video.url'] = $_CONF['core.url_file'] . 'video/';

$_CONF['video.dir_image'] = $_CONF['core.dir_pic'] . 'video' . PHPFOX_DS;
$_CONF['video.url_image'] = $_CONF['core.url_pic'] . 'video/';

$_CONF['ad.dir_image'] = $_CONF['core.dir_pic'] . 'ad' . PHPFOX_DS;
$_CONF['ad.url_image'] = $_CONF['core.url_pic'] . 'ad/';

$_CONF['subscribe.dir_image'] = $_CONF['core.dir_pic'] . 'subscribe' . PHPFOX_DS;
$_CONF['subscribe.url_image'] = $_CONF['core.url_pic'] . 'subscribe/';

$_CONF['css.dir_cache'] = $_CONF['core.dir_file'] . 'css' . PHPFOX_DS;
$_CONF['css.url_cache'] = $_CONF['core.url_file'] . 'css/';

$_CONF['chat.dir_cache'] = $_CONF['core.dir_file'] . 'chat' . PHPFOX_DS;
$_CONF['chat.url_cache'] = $_CONF['core.url_file'] . 'chat/';

$_CONF['core.dir_watermark'] = $_CONF['core.dir_pic'] . 'watermark' . PHPFOX_DS;
$_CONF['core.url_watermark'] = $_CONF['core.url_pic'] . 'watermark/';

$_CONF['core.dir_icon'] = $_CONF['core.dir_pic'] . 'icon' . PHPFOX_DS;
$_CONF['core.url_icon'] = $_CONF['core.url_pic'] . 'icon/';

$_CONF['user.dir_user_spam'] = $_CONF['core.dir_pic'] . 'user' . PHPFOX_DS . 'spam_question' . PHPFOX_DS;
$_CONF['user.url_user_spam'] = $_CONF['core.url_pic'] . 'user' . PHPFOX_DS . 'spam_question/'; 

/* Static URLS */
$_CONF['core.dir_static'] = PHPFOX_DIR . 'static/';
$_CONF['core.url_static'] = $_CONF['core.path'] . 'static/';
$_CONF['core.url_static_script'] = $_CONF['core.url_static'] . 'jscript/';
$_CONF['core.url_static_css'] = $_CONF['core.url_static'] . 'style/';
$_CONF['core.url_static_image'] = $_CONF['core.url_static'] . 'image/';
$_CONF['core.url_misc'] = $_CONF['core.url_static_image'] . 'misc/';

// Name of the thumbnail directory
$_CONF['core.url_thumb'] = 'thumb/';

?>
