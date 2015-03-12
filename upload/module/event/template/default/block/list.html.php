<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 6532 2013-08-29 11:15:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div id="js_event_item_holder">
{/if}
	{if count($aInvites)}
	{foreach from=$aInvites name=invites item=aInvite}	
		<div class="go_left t_center" style="width:30%; padding:4px;" id="js_event_guest_{$aInvite.invite_id}">			
			<div class="p_4">
				{if !$aInvite.invited_user_id}
					{$aInvite.invited_email|hide_email}
				{else}
					{$aInvite|user}
				{/if}		
			</div>
			<div class="js_mp_fix_holder" style="width:75px; margin:auto; position:relative;">
				{if (($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event')) && $aInvite.invited_user_id != $aEvent.user_id}
				<div style="position:absolute; right:0; margin:-2px -2px 0px 0px;">
					<a href="#" title="{phrase var='event.remove_this_person_from_the_guest_list'}" onclick="if (confirm('{phrase var='event.are_you_sure'}')) {literal}{{/literal} $.ajaxCall('event.deleteGuest', 'id={$aInvite.invite_id}'); $('#js_event_guest_{$aInvite.invite_id}').remove(); {literal}}{/literal} return false;">{img theme='misc/delete_hover.gif' alt=''}</a>
				</div>
				{/if}
				{if !$aInvite.invited_user_id}
				{img file='' suffix='_50_square' max_width=75 max_height=75 class='js_mp_fix_width'}
				{else}
				{img user=$aInvite suffix='_50_square' max_width=75 max_height=75 class='js_mp_fix_width'}
				{/if}
			</div>
		</div>
		{if is_int($phpfox.iteration.invites / 3)}
		<div class="clear"></div>
		{/if}	
	{/foreach}
	<div class="clear"></div>
	{else}
	<div class="extra_info">
	{if $iRsvp == 1}
		{phrase var='event.no_attendees'}
	{else}
		{phrase var='event.no_results'}
	{/if}
	</div>
	{/if}
	{pager}
{if !PHPFOX_IS_AJAX}
</div>
{/if}