<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: menu.html.php 1252 2009-11-11 09:27:24Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="menu">
	<ul>
		<li><a href="{$sTopFriendOnlineLink}" class="first">{phrase var='friend.view_friends_online'}</a></li>
		{if $aUser.user_id != Phpfox::getUserId()}
		<li><a href="{url link=''$aUser.user_name'.friend.mutual'}">{phrase var='friend.mutual_friends'}</a></li>
		{/if}
		{if $aUser.user_id == Phpfox::getUserId()}
		<li><a href="{url link='friend'}">{phrase var='friend.edit_top_friends'}</a></li>		
		{/if}
	</ul>						
</div>