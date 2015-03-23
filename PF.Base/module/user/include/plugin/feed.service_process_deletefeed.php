<?php

if (Phpfox_Request::instance()->get('module') == '' && $aFeed['parent_user_id'] == Phpfox::getUserId())
{
	define('PHPFOX_FEED_CAN_DELETE', true);
}

?>
