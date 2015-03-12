<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Invite
 * @version 		$Id: index.html.php 2633 2011-05-30 13:57:44Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bIsRegistration}
<div class="t_right p_top_10" style="font-size:10pt; font-weight:bold;">
	<a href="{$sNextUrl}">{phrase var='invite.skip_this_step'}</a>
</div>	
{/if}
<div class="main_break">
	{if isset($aValid)}
	{if count($aValid)}
	{phrase var='invite.you_have_successfully_sent_an_invitation_to'}:
	<div class="p_4">
		<div class="label_flow" style="height:100px;">
		{foreach from=$aValid name=emails item=sEmail}
			<div class="{if is_int($phpfox.iteration.emails/2)}row1{else}row2{/if} {if $phpfox.iteration.emails == 1} row_first{/if}">{$sEmail}</div>
		{/foreach}
		</div>
	</div>
	<br />
	{/if}
	
	{if count($aInValid)}
	{phrase var='invite.the_following_emails_were_not_sent'}:
	<div class="p_4">
		<div class="label_flow" style="height:100px;">
		{foreach from=$aInValid name=emails item=sEmail}
			<div class="{if is_int($phpfox.iteration.emails/2)}row1{else}row2{/if} {if $phpfox.iteration.emails == 1} row_first{/if}">{$sEmail}</div>
		{/foreach}
		</div>
	</div>
	<br />
	{/if}	
	
	{if count($aUsers)}
	{phrase var='friend.the_following_users_are_already_a_member_of_our_community'}:
	<div class="p_4">
		<div class="label_flow" style="height:100px;">
		{foreach from=$aUsers name=users item=aUser}
			<div class="{if is_int($phpfox.iteration.users/2)}row1{else}row2{/if} {if $phpfox.iteration.users == 1} row_first{/if}" id="js_invite_user_{$aUser.user_id}">
		{if $aUser.user_id == Phpfox::getUserId()}
			{$aUser.email} - {phrase var='friend.that_s_you'}
		{else}			
			{$aUser.email} - {$aUser|user}{if !$aUser.friend_id} - <a href="#?call=friend.request&amp;user_id={$aUser.user_id}&amp;width=420&amp;height=250&amp;invite=true" class="inlinePopup" title="{phrase var='profile.add_to_friends'}">{phrase var='friend.add_to_friends'}</a>{/if}
		{/if}
			</div>
		{/foreach}
		</div>
	</div>	
	{/if}
	{else}
	{phrase var='invite.invite_your_friends_to_b_title_b' title=$sSiteTitle}
	<br />
	<br />
	{phrase var='invite.your_friend_will_automatically_be_added_to_your_friends_list_when_they_join'}
	{/if}
	
	{plugin call='invite.template_controller_index_h3_start'}
	
	<h3>{phrase var='invite.email_your_friends'}</h3>
	<form method="post" action="{if $bIsRegistration}{url link='invite.register'}{else}{url link='invite'}{/if}">
		<div class="table">
			<div class="table_left">
				{phrase var='invite.subject'}:
			</div>
			<div class="table_right_text">
				{phrase var='invite.full_name_invites_you_to_title' full_name=$sFullName title=$sSiteTitle}
			</div>
			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='invite.from'}:
			</div>
			<div class="table_right_text">
				{$sSiteEmail}
			</div>
			<div class="clear"></div>
		</div>
		<div class="table">
			<div class="table_left">
				<label for="emails">{phrase var='invite.to'}:</label>
			</div>
			<div class="table_right">
				<textarea cols="40" rows="3" id="emails" name="val[emails]" style="width:90%; height:20px;" onkeydown="$Core.resizeTextarea($(this));" onkeyup="$Core.resizeTextarea($(this));"></textarea>
				<div class="extra_info">
					{phrase var='invite.separate_multiple_emails_with_a_comma'}
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="table_clear">
			<input type="submit" value="{phrase var='invite.send_invitation_s'}" class="button" />
		</div>
	</form>
	
</div>