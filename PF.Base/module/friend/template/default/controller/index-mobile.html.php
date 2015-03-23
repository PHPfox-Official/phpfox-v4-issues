<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index-mobile.html.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="search_bar">
	<form method="post" action="{url link='friend'}">
		<input type="text" name="search" value="" style="width:70%;" /> <input type="submit" value="{phrase var='friend.search'}" class="button" />
	</form>
</div>
{if $bIsFriendSelect}
<div class="message">
	{phrase var='mail.select_a_recipient_below'}:
</div>
{/if}
{if count($aFriends)}
{foreach from=$aFriends item=aFriend}
<div class="item">
	<div class="item_image">
	{if $bIsFriendSelect}
		<a href="{url link='mail.compose' to=$aFriend.user_id}">{img user=$aFriend suffix='_50_square' max_width=35 max_height=35 no_link=true}</a>
	{else}	
		{img user=$aFriend suffix='_50_square' max_width=35 max_height=35}
	{/if}
	</div>
	<div class="item_content">
	{if $bIsFriendSelect}
		<a href="{url link='mail.compose' to=$aFriend.user_id}">{$aFriend.full_name|clean}</a>
	{else}
		{$aFriend|user}
	{/if}
	</div>
	<div class="clear"></div>
</div>
{/foreach}
{pager}
{else}
{if $bIsSearch}
{phrase var='friend.no_search_results_found'}
{else}
{phrase var='friend.no_friends_found'}
{/if}
{/if}