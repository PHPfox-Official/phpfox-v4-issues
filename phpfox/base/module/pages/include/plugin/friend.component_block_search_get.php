<?php

if (Phpfox::isModule('pages') 
	&& 
		(
			(!PHPFOX_IS_AJAX && defined('PHPFOX_PAGES_EDIT_ID') && PHPFOX_PAGES_EDIT_ID > 0)
			||
			(PHPFOX_IS_AJAX && Phpfox_Request::instance()->get('friend_item_id') && define('PHPFOX_PAGES_EDIT_ID', Phpfox_Request::instance()->get('friend_item_id')))
		)
	&& count($aFriends))
{
	$aInvites = Phpfox::getService('pages')->getCurrentInvites(PHPFOX_PAGES_EDIT_ID);
	if (count($aInvites))
	{
		foreach ($aFriends as $iKey => $aFriend)
		{
			if (isset($aInvites[$aFriend['user_id']]))
			{
				$aFriends[$iKey]['is_active'] = true;
			}
		}
	}
}
?>