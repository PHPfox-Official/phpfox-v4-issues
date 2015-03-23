<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='rss.groups'}
</div>
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
	<tr>
		<th></th>
		<th style="width:20px;"></th>
		<th>{phrase var='rss.title'}</th>
		<th class="t_center" style="width:60px;">{phrase var='rss.active'}</th>	
	</tr>
	{foreach from=$aGroups key=iKey item=aGroup}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="drag_handle"><input type="hidden" name="val[ordering][{$aGroup.group_id}]" value="{$aGroup.ordering}" /></td>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.rss.group.add' id={$aGroup.group_id}">{phrase var='rss.edit_group'}</a></li>		
					<li><a href="{url link='admincp.rss.group' delete={$aGroup.group_id}" onclick="return confirm('{phrase var='rss.are_you_sure' phpfox_squote=true}');">{phrase var='rss.delete_group'}</a></li>		
				</ul>
			</div>		
		</td>	
		<td>{phrase var=$aGroup.name_var}</td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aGroup.is_active} style="display:none;"{/if}>
				<a href="#?call=core.updateStatActivity&amp;id={$aGroup.group_id}&amp;active=0" class="js_item_active_link" title="{phrase var='rss.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aGroup.is_active} style="display:none;"{/if}>
				<a href="#?call=core.updateStatActivity&amp;id={$aGroup.group_id}&amp;active=1" class="js_item_active_link" title="{phrase var='rss.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>		
	</tr>
	{/foreach}
</table>