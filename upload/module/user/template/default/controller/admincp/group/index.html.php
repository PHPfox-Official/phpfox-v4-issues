<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: index.html.php 2826 2011-08-11 19:41:03Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='user.default_user_groups'}
</div>
<table>
<tr>
	<th style="width:20px;"></th>
	<th>{phrase var='user.title'}</th>
	<th style="width:100px;">{phrase var='user.users'}</th>
</tr>
{foreach from=$aGroups.special key=iKey item=aGroup}
<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
	<td class="t_center">
		{if Phpfox::getUserParam('user.can_edit_user_group') || Phpfox::getUserParam('user.can_manage_user_group_settings')}
		<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
		<div class="link_menu">
			<ul>
				{if Phpfox::getUserParam('user.can_manage_user_group_settings')}
				<li><a href="{url link='admincp.user.group.add' id=$aGroup.user_group_id setting='true'}">{phrase var='user.manage_user_settings'}</a></li>
				{/if}
				{if Phpfox::getUserParam('user.can_edit_user_group')}
				<li><a href="{url link='admincp.user.group.add' id=$aGroup.user_group_id}">{phrase var='user.edit_user_group'}</a></li>				
				{/if}
				<li><a href="{url link='admincp.user.group.activitypoints' id=$aGroup.user_group_id}">{phrase var='core.manage_activity_points'}</a></li>
			</ul>
		</div>		
		{/if}
	</td>	
	<td>{$aGroup.title|convert|clean}</td>
	<td>{if $aGroup.user_group_id == 3}N/A{else}{$aGroup.total_users}{/if}</td>
</tr>
{/foreach}
</table>
{if isset($aGroups.custom)}
<div class="table_header">
	{phrase var='user.custom_user_groups'}
</div>
<table>
<tr>
	<th style="width:20px;"></th>
	<th>{phrase var='user.title'}</th>
	<th style="width:100px;">{phrase var='user.users'}</th>
</tr>
{foreach from=$aGroups.custom key=iKey item=aGroup}
<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
	<td class="t_center">
		{if Phpfox::getUserParam('user.can_edit_user_group') || Phpfox::getUserParam('user.can_manage_user_group_settings') || Phpfox::getUserParam('user.can_delete_user_group')}
		<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
		<div class="link_menu">
			<ul>
				{if Phpfox::getUserParam('user.can_manage_user_group_settings')}
				<li><a href="{url link='admincp.user.group.add' id=$aGroup.user_group_id setting='true'}">{phrase var='user.manage_user_settings'}</a></li>
				{/if}
				{if Phpfox::getUserParam('user.can_edit_user_group')}
				<li><a href="{url link='admincp.user.group.add' id=$aGroup.user_group_id}">{phrase var='user.edit_user_group'}</a></li>
				{/if}
				{if !$aGroup.is_special && Phpfox::getUserParam('user.can_delete_user_group')}
				<li><a href="{url link='admincp.user.group.delete' id=$aGroup.user_group_id}" onclick="return confirm('{phrase var='user.are_you_sure' phpfox_squote=true}');">{phrase var='user.delete'}</a></li>					
				{/if}
				<li><a href="{url link='admincp.user.group.activitypoints' id=$aGroup.user_group_id}">{phrase var='core.manage_activity_points'}</a></li>
			</ul>
		</div>	
		{/if}	
	</td>	
	<td>{$aGroup.title|convert|clean}</td>
	<td>{if $aGroup.user_group_id == 3}{phrase var='user.n_a'}{else}{$aGroup.total_users}{/if}</td>	
</tr>
{/foreach}
</table>
{/if}