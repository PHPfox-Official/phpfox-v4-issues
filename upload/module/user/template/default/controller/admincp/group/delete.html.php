<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: delete.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.user.group.delete'}">
<div><input type="hidden" name="val[delete_id]" value="{$aGroup.user_group_id}" /></div>
	{phrase var='user.are_you_sure_you_want_to_delete_the_user_group_title' title=$aGroup.title|clean}
	<div class="extra_info">
		{phrase var='user.b_notice_b_this_cannot_be_undone'}
	</div>
	
	{phrase var='user.b_yes_b_i_am_sure_move_any_members_that_belong_to_the_user_group_title_to' title=$aGroup.title|clean}:
	<div class="p_2">
		<select name="val[user_group_id]">
			{foreach from=$aGroups item=aUserGroup}
				{if $aUserGroup.user_group_id != $aGroup.user_group_id}
				<option value="{$aUserGroup.user_group_id}"{if $aUserGroup.user_group_id == 2} selected="selected"{/if}>{$aUserGroup.title|clean}</option>
				{/if}
			{/foreach}
		</select>
	</div>
	
	<input type="submit" value="{phrase var='user.delete_this_user_group'}" class="button" />.

	<br />
	
	<input type="button" value="{phrase var='user.no_thanks_get_me_out_of_here'}" class="button" onclick="window.location.href = '{url link='admincp.user.group'}';" />

</form>