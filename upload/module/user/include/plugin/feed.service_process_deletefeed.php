<?php

if (Phpfox::getLib('request')->get('module') == '' && $aFeed['parent_user_id'] == Phpfox::getUserId())
{
	define('PHPFOX_FEED_CAN_DELETE', true);
}

?>
