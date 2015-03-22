<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: index.html.php 4445 2012-07-02 10:41:03Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $iTotalFriendRequests > 0}
<a href="{url link='friend.accept'}" class="global_notification_site">{if $iTotalFriendRequests == 1}{phrase var='friend.you_have_1_new_friend_request'}{else}{phrase var='friend.you_have_total_new_friend_requests' total=$iTotalFriendRequests}{/if}</a>
{/if}
{if $iList > 0 && !PHPFOX_IS_AJAX}
<div class="friend_list_holder">
	<div class="friend_list_form">
		<form method="post" action="#" class="friend_list_form_post">
			<div><input type="hidden" name="list_id" value="{$aList.list_id}" /></div>
			<div><input type="hidden" name="old_name" value="{$aList.name|clean}" class="friend_list_form_post_old" /></div>
			<input type="text" name="name" value="{$aList.name|clean}" size="30" class="friend_list_form_input" /> <span class="friend_list_edit_ajax">{img theme='ajax/add.gif'}</span>
		</form>
	</div>
	<a href="{url link='friend' dlist=$iList}" class="friend_list_delete">{phrase var='friend.delete_list'}</a>
	<ul>
		<li><a href="#" class="friend_list_edit_name" rel="{$iList}">{phrase var='friend.edit_name'}</a></li>
		<li>&middot;</li>
		<li{if $aList.is_profile} style="display:none;"{/if}><a href="#" class="friend_list_display_profile" rel="{$iList}">{phrase var='friend.display_on_profile'}</a></li>
		<li{if !$aList.is_profile} style="display:none;"{/if}><a href="#" class="friend_list_remove_profile" rel="{$iList}">{phrase var='friend.remove_from_profile'}</a></li>
		{if count($aFriends)}
		<li>&middot;</li>
		<li><a href="#" class="friend_list_change_order">{phrase var='friend.change_order'}</a></li>
		{/if}
	</ul>
</div>
{/if}
{if count($aFriends)}
{if !PHPFOX_IS_AJAX}
<form method="post" action="#" id="js_friend_list_order_form">	
	{if $iList > 0}
	<div><input type="hidden" name="list_id" value="{$iList}" /></div>
	{/if}
	<div id="js_friend_sort_holder">
{/if}
		{foreach from=$aFriends item=aFriend name=friend}		
		<div id="js_friend_{$aFriend.friend_id}" class="friend_row_holder js_selector_class_{$aFriend.friend_id} {if is_int($phpfox.iteration.friend/2)}row1{else}row2{/if}{if $phpfox.iteration.friend == 1 && !PHPFOX_IS_AJAX} row_first{/if}">
			<div><input type="hidden" name="friend_id[]" value="{$aFriend.friend_user_id}" class="js_friend_actual_user_id" /></div>
			<div class="friend_image" id="js_image_div_{$aFriend.friend_id}">	
				{img id='sJsUserImage_'$aFriend.friend_id'' user=$aFriend suffix='_50_square' max_width=50 max_height=50}
			</div>
			<div class="friend_user_name">
				{$aFriend|user:'':'':50} 
			</div>
			<div class="friend_action">
				<div class="js_friend_sort_handler js_friend_edit_order"></div>
				<div class="friend_action_holder">
					<div class="friend_action_edit_list_holder">
						<div class="js_friend_action_edit_list"{if !count($aFriend.lists)} style="display:none;"{/if}>
							<a href="#" class="friend_action_edit_list">{phrase var='friend.edit_lists'}</a>
							<ul class="friend_action_drop_down">
							{foreach from=$aFriend.lists name=lists item=aList}
								<li><a href="#" rel="{$aList.list_id}|{$aFriend.friend_user_id}"{if $aList.is_active} class="active"{/if}><span></span>{$aList.name|clean}</a></li>
							{/foreach}
							</ul>
						</div>
					</div>
					<a href="#" class="friend_action_delete js_hover_title" rel="{$aFriend.friend_id}"><span class="js_hover_info">{phrase var='friend.remove_this_friend'}</span></a>
				</div>				
			</div>			
		</div>
		{/foreach}
	{if !PHPFOX_IS_AJAX}
	<div id="js_view_more_friends"></div>		
	{/if}	
{if !PHPFOX_IS_AJAX}
	</div>	
	<div class="p_top_8 js_friend_edit_order js_friend_edit_order_submit">		
		<ul class="table_clear_button">
			<li><input type="submit" value="{phrase var='friend.save_changes'}" class="button" /></li>
			<li class="table_clear_ajax"></li>
		</ul>
		<div class="clear"></div>		
	</div>	
</form>
{/if}
{pager}
{else}

<div class="extra_info">
	{phrase var='friend.no_friends'}
</div>
{/if}