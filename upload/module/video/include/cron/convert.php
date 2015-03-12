<?php

if (PHP_SAPI != 'cli')
{
	exit('CLI only!');
}

$_SERVER['REMOTE_ADDR'] = '';
$_SERVER['HTTP_HOST'] = '';
$_SERVER['SERVER_NAME'] = '';

// ignore_user_abort(true);
define('PHPFOX', true);
define('PHPFOX_DS', DIRECTORY_SEPARATOR);
define('PHPFOX_DIR', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . PHPFOX_DS);
define('PHPFOX_NO_SESSION', true);
define('PHPFOX_NO_USER_SESSION', true);
define('PHPFOX_NO_CSRF', true);
define('PHPFOX_NO_PLUGINS', true);
define('PHPFOX_CLI', true);

if (!file_exists(PHPFOX_DIR . 'include' . PHPFOX_DS . 'init.inc.php'))
{
	exit("Unable to load main phpFox INIT.\n");
}

require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'init.inc.php');

if (file_exists(PHPFOX_DIR_CACHE . 'video.lock'))
{
	exit('Video conversion in process.');
}

Phpfox::getService('video.convert')->process();

exit;

?>