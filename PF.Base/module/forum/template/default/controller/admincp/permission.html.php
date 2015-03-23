<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: permission.html.php 1678 2010-07-20 11:05:43Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='forum.user_groups'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='forum.user_group'}:
	</div>
	<div class="table_right">
		<select name="user_group_id" onchange="$('#js_display_perms').slideUp(); $('#js_form_user_group_id').val(this.value); $(this).ajaxCall('forum.loadPermissions', 'forum_id={$iForumId}');">
			<option value="">{phrase var='forum.select'}:</option>
		{foreach from=$aUserGroups item=aUserGroup}
			<option value="{$aUserGroup.user_group_id}">{$aUserGroup.title|clean}</option>
		{/foreach}
		</select>
		<div class="extra_info">
			{phrase var='forum.select_a_user_group_to_assign_special_permissions_for_this_specific_forum'}
		</div>
	</div>
	<div class="clear"></div>
</div>
<form method="post" action="#" onsubmit="$(this).ajaxCall('forum.savePerms'); return false;">	
	<div><input type="hidden" name="val[forum_id]" value="{$iForumId}" /></div>
	<div><input type="hidden" name="val[user_group_id]" value="" id="js_form_user_group_id" /></div>
	<div id="js_display_perms" style="display:none;">
		<div class="table_header">
			{phrase var='forum.forum_permissions'} - <span id="js_form_perm_group"></span>
		</div>
		<div id="js_display_list_perms"></div>
	</div>
	<div class="table_clear">
		<div id="js_save_perms" style="display:none;">
			<input name="save" type="submit" value="{phrase var='forum.save'}" class="button" />
			<input name="button "type="submit" value="{phrase var='forum.reset'}" class="button" onclick="$.ajaxCall('forum.permReset', 'forum_id={$iForumId}&amp;user_group_id=' + $('#js_form_user_group_id').val()); return false;" />
		</div>
	</div>
</form>