<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: pending.html.php 3642 2011-12-02 10:01:15Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPendingRequests)}
{foreach from=$aPendingRequests name=friend item=aFriend}
		<div class="friend_row_holder {if is_int($phpfox.iteration.friend/2)}row1{else}row2{/if}{if $phpfox.iteration.friend == 1 && !PHPFOX_IS_AJAX} row_first{/if}">
			<div class="friend_image">	
				{img user=$aFriend suffix='_50_square' max_width=50 max_height=50}
			</div>
			<div class="friend_user_name">
				{$aFriend|user} 
			</div>
			<div class="friend_action">
				<div class="js_friend_sort_handler js_friend_edit_order"></div>
				<div class="friend_action_holder">
					<a href="{url link='friend.pending' id=$aFriend.request_id}" class="friend_action_delete js_hover_title"><span class="js_hover_info">{phrase var='friend.remove_this_request'}</span></a>
				</div>				
			</div>			
		</div>
{/foreach}
{pager}
{else}
<div class="extra_info">
	{phrase var='friend.there_are_no_pending_friends_requests'}
</div>
{/if}