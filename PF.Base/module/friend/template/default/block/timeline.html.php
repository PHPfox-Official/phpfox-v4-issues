<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Profile
 * @version 		$Id: pic.html.php 3405 2011-11-01 11:05:18Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="timeline_holder">
	<div class="timeline_friendlist_title">
		<a href="{$sFriendsLink}" class="timeline_friendlist_link">{phrase var='friend.see_all'}</a>			
		{phrase var='friend.friends'}
		<div class="extra_info">
			{$aUser.total_friend|number_format}
		</div>
	</div>
	<div class="timeline_friendlist_content">
		{foreach from=$aFriends key=iKey name=friend item=aFriend}
		<div class="timeline_friendlist_row">
			<div class="timeline_friendlist_user">{$aFriend|user}</div>
			{img user=$aFriend suffix='_120_square' max_width=100 max_height=100}
		</div>
		{/foreach}
		<div class="clear"></div>
	</div>
</div>