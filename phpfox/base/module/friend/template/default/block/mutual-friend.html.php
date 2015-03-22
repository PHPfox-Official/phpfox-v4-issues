<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: mutual-friend.html.php 2536 2011-04-14 19:37:29Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if defined('PHPFOX_IN_DESIGN_MODE')}
<div class="extra_info">
	{phrase var='friend.mutual_friends_will_be_listed_here'}
</div>
{else}
<div class="p_bottom_5" style="position:relative;">
	<a href="{url link=''$aUser.user_name'.friend.mutual'}">
{if $iTotalMutualFriends == 1}
	{phrase var='friend.1_friend_in_common'}
{else}
	{phrase var='friend.total_friends_in_common' total=$iTotalMutualFriends}
{/if}
	</a>
</div>
<div class="block_listing_inline">
	<ul>
{foreach from=$aMutualFriends key=iKey name=friend item=aFriend}
		<li>{img user=$aFriend suffix='_50_square' max_width=32 max_height=32 class='js_hover_title'}</li>	
{/foreach}
	</ul>
	<div class="clear"></div>
</div>
{/if}