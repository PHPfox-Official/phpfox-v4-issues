<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div id="js_group_item_holder">
{/if}
	{if count($aMembers)}
	{foreach from=$aMembers name=members item=aMember}	
		<div class="go_left t_center" style="width:30%; padding:4px;" id="js_group_member_{$aMember.invite_id}">			
			<div class="p_4">
				{if !$aMember.invited_user_id}
					{$aMember.invited_email|hide_email}
				{else}
					{$aMember|user}
				{/if}		
			</div>
			<div class="js_mp_fix_holder image_hover_holder" style="width:110px;">
				{if ($aGroup.user_id == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin('' . $aGroup.group_id . '')}
				<div class="image_hover_menu">
					{if $aMember.member_id == '2' && $aMember.invited_user_id != Phpfox::getUserId()}
					<div><a href="#" onclick="$('#js_group_member_{$aMember.invite_id}').remove(); $.ajaxCall('group.joinGroup', 'id={$aGroup.group_id}&amp;approve={$aMember.invited_user_id}'); return false;"  title="{phrase var='group.approve_this_member_to_be_part_of_this_group'}">{img theme='misc/accept.png'}</a></div>
					{/if}				
					{if $aMember.invited_user_id != $aGroup.user_id && $aMember.invited_user_id != Phpfox::getUserId()}
					<div><a href="#" title="{phrase var='group.remove_this_person_from_the_group'}" onclick="if (confirm('{phrase var='group.are_you_sure' phpfox_squote=true}')) {literal}{{/literal} $.ajaxCall('group.deleteMember', 'id={$aMember.invite_id}'); $('#js_group_member_{$aMember.invite_id}').remove(); {literal}}{/literal} return false;">{img theme='misc/delete_hover.gif'}</a></div>
					{/if}					
					{if $aMember.invited_user_id != $aGroup.user_id && $aMember.invited_user_id != Phpfox::getUserId()}
					<div><a href="#" class="js_group_admin_add" title="{phrase var='group.add_this_person_as_an_admin_for_this_group'}" onclick="$(this).hide().parents('.image_hover_menu:first').find('.js_group_admin_remove:first').show(); $.ajaxCall('group.processAdmin', 'id={$aMember.invite_id}&amp;type=1'); return false;"{if $aMember.is_admin} style="display:none;"{/if}>{img theme='misc/user_add.png'}</a></div>
					<div><a href="#" class="js_group_admin_remove" title="{phrase var='group.remove_this_person_as_an_admin_for_this_group'}" onclick="$(this).hide().parents('.image_hover_menu:first').find('.js_group_admin_add:first').show(); $.ajaxCall('group.processAdmin', 'id={$aMember.invite_id}&amp;type=0'); return false;"{if !$aMember.is_admin} style="display:none;"{/if}>{img theme='misc/user_delete.png'}</a></div>
					{/if}
				</div>
				{/if}
				{if !$aMember.invited_user_id}
				{img file='' suffix='_75' max_width=75 max_height=75 class='js_mp_fix_width'}
				{else}
				{img user=$aMember suffix='_75' max_width=75 max_height=75 class='js_mp_fix_width'}
				{/if}
			</div>
		</div>
		{if is_int($phpfox.iteration.members / 3)}
		<div class="clear"></div>
		{/if}	
	{/foreach}
	<div class="clear"></div>
	{else}
	<div class="extra_info">
	{if $iType == 1}
		{phrase var='group.no_members'}
	{else}
		{phrase var='group.no_results'}
	{/if}
	</div>
	{/if}
	{pager}
{if !PHPFOX_IS_AJAX}
</div>
{/if}