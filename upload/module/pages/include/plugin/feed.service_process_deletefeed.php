<?php

if (Phpfox::getLib('request')->get('module') == 'pages')
{
	$aPage = Phpfox::getService('pages')->getPage($aFeed['parent_user_id']);
	if (isset($aPage['page_id']) && Phpfox::getService('pages')->isAdmin($aPage))
	{
		define('PHPFOX_FEED_CAN_DELETE', true);
	}
}

?>