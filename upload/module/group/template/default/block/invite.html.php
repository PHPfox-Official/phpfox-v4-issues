<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: invite.html.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
{if count($aGroups)}
<form method="post" action="#" onsubmit="$(this).ajaxCall('group.processInvite'); return false;">
	<div><input type="hidden" name="val[user_id]" value="{$iUserId}" /></div>
	<div class="table">
		<div class="table_left">
			{phrase var='group.your_groups'}:
		</div>
		<div class="table_right">
			<select name="val[group_id]">
				<option value="">{phrase var='group.select'}:</option>
			{foreach from=$aGroups item=aGroup}
				<option value="{$aGroup.group_id}">{$aGroup.title|clean}</option>
			{/foreach}
			</select>
		</div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='group.invite'}" class="button" />
	</div>
</form>
{else}
<div class="extra_info">
	{phrase var='group.no_groups_available_for_this_user'}
	<ul class="action">
		<li><a href="{url link='group.add'}">{phrase var='group.create_a_new_group'}</a></li>
	</ul>
</div>
{/if}