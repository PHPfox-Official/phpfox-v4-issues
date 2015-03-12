<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: top.html.php 1135 2009-10-05 12:59:10Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_top_friends_list">
{if count($aTopFriends)}
	{foreach from=$aTopFriends key=iKey name=friend item=aTopFriend}
	<div id="user_{$aTopFriend.friend_id}" class="row1{if $phpfox.iteration.friend == 1} row_first{/if}" style="z-index:1; {if ($bMoveCursor == true)}cursor:move; {/if}position:relative;">
		<div style="position:absolute; right:5px; background:#195B85; font-size:16pt; font-weight:bold; color:#fff; padding:8px; z-index:10; text-align:center;" class="js_top_friend_iteration_count">{$phpfox.iteration.friend}</div>
		<div style="position:absolute;">
			{img user=$aTopFriend suffix='_50' max_width=50 max_height=50 style="cursor:move;"}
		</div>
		<div style="margin-left:55px; height:55px;">
				{$aTopFriend|user}		
		</div>
	</div>
	{/foreach}
{else}
	<div class="extra_info">
		{phrase var='friend.use_this_image_to_add_friends_to_your_top_friends_list'}: {img theme='misc/favorite_add.png' class='v_middle'}
	</div>
{/if}
</div>