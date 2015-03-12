<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: accept.html.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !isset($bIsFriendController)}
{if count($aFriends)}
<ul id="js_new_friend_holder_drop">
{/if}
{/if}
{if !count($aFriends)}
{if !isset($bIsFriendController)}
<div class="drop_data_empty">
{else}
<div class="extra_info">
{/if}
	{phrase var='friend.no_new_requests'}
</div>
{else}
{foreach from=$aFriends name=friends item=aFriend}
	{if !isset($bIsFriendController)}
	<li id="js_new_friend_request_{$aFriend.request_id}" class="holder_notify_drop_data with_padding{if $phpfox.iteration.friends == 1} first{/if} js_friend_request_{$aFriend.request_id}{if !$aFriend.is_seen} is_new{/if}">
	{else}
	<div class="row1 js_friend_request_{$aFriend.request_id} moderation_row">
	{/if}
			<div class="drop_data_image">
				{img user=$aFriend max_width='50' max_height='50' suffix='_50_square'}
				{if isset($bIsFriendController)}
				<a href="#{$aFriend.request_id}" class="moderate_link" rel="friend">{phrase var='friend.moderate'}</a>
				{/if}
			</div>
			<div class="drop_data_content">
				<div class="drop_data_user">
					<div class="drop_data_action">
						<div class="js_drop_data_add" style="display:none; padding-right:5px;">
							{img theme='ajax/add.gif'}
						</div>
						<div class="js_drop_data_button" id="drop_down_{$aFriend.request_id}">
							<ul class="table_clear_button">
								<li><input type="button" name="" value="{phrase var='friend.confirm'}" class="button" onclick="$(this).parents('.drop_data_action').find('.js_drop_data_add').show(); {if $aFriend.relation_data_id > 0} $.ajaxCall('custom.processRelationship', 'relation_data_id={$aFriend.relation_data_id}&amp;type=accept&amp;request_id={$aFriend.request_id}'); {else} $.ajaxCall('friend.processRequest', 'type=yes&amp;user_id={$aFriend.user_id}&amp;request_id={$aFriend.request_id}&amp;inline=true'); {/if}" /></li>
								<li><input type="button" name="" value="{phrase var='friend.deny'}" class="button button_off" onclick="$(this).parents('.drop_data_action').find('.js_drop_data_add').show(); {if $aFriend.relation_data_id > 0} $.ajaxCall('custom.processRelationship', 'relation_data_id={$aFriend.relation_data_id}&amp;type=deny&amp;request_id={$aFriend.request_id}'); {else} $.ajaxCall('friend.processRequest', 'type=no&amp;user_id={$aFriend.user_id}&amp;request_id={$aFriend.request_id}&amp;inline=true'); {/if}" /></li>
							</ul>
							<div class="clear"></div>
						</div>
					</div>
					<div style="width:120px;">
						{$aFriend|user}
						{if $aFriend.relation_data_id > 0}
                            <div class="extra_info_link">
                                {img theme='misc/heart.png' class='v_middle'} {phrase var='friend.relationship_request'}
                            </div>
						{else}
                            {if isset($aFriend.mutual_friends) && $aFriend.mutual_friends.total > 0}
                                <div class="extra_info_link">				
                                    <a href="#" onclick="$Core.box('friend.getMutualFriends', 300, 'user_id={$aFriend.friend_user_id}'); return false;">
                                    {if $aFriend.mutual_friends.total == 1}
                                    {phrase var='friend.1_mutual_friend'}
                                    {else}
                                    {phrase var='friend.total_mutual_friends' total=$aFriend.mutual_friends.total}
                                    {/if}
                                    </a>
                                </div>
                            {/if}
						{/if}
                        {plugin call='friend.template_block_accept__1'}
                        
						{if !empty($aFriend.message)}
						<div class="extra_info">
							{$aFriend.message|clean:false|shorten:20:'friend.view_more':true}
						</div>
						{/if}
					</div>
					<ul class="extra_info_middot" style="display:none;">
						<li><a href="#" onclick="$Core.composeMessage({l}user_id: {$aFriend.user_id}{r}); return false;">{phrase var='friend.send_a_message'}</a></li>
						<li>&middot;</li>
						<li><a href="{url link=$aFriend.user_name}">{phrase var='friend.view_profile'}</a></li>
					</ul>					
				</div>				
			</div>
			<div class="clear"></div>		
	{if !isset($bIsFriendController)}
	</li>
	{else}
	</div>
	{/if}
{/foreach}
{/if}
{if !isset($bIsFriendController)}
{if count($aFriends)}
</ul>

{literal}
<script type="text/javascript">	
	var $iTotalFriends = parseInt($('#js_total_new_friend_requests').html());
	var $iNewTotalFriends = 0;
	$('#js_new_friend_holder_drop li.holder_notify_drop_data').each(function()
	{
		$iNewTotalFriends++;
		// $aMailOldHistory[$(this).attr('id').replace('js_new_friend_request_', '')] = true;		
	});
	
	$iTotalFriends = parseInt(($iTotalFriends - $iNewTotalFriends));
	if ($iTotalFriends < 0)
	{
		$iTotalFriends = 0;
	}
	
	if ($iTotalFriends === 0)
	{
		$('#js_total_new_friend_requests').html('').hide();	
	}
	else
	{
		$('#js_total_new_friend_requests').html($iTotalFriends);
	}	
</script>
{/literal}

{/if}
<a href="{url link='friend.accept'}" class="holder_notify_drop_link">{phrase var='friend.see_all_friend_requests'}</a>
{/if}