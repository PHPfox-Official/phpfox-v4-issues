<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: setting.html.php 3826 2011-12-16 12:30:19Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>	{foreach from=$aModules key=iBlock item=aSubBlocks}
	<div class="table_header2">
		{phrase var='admincp.block_block_number' block_number=$iBlock}
	</div>
	<table class="js_drag_drop" cellpadding="0" cellspacing="0">
	{foreach from=$aSubBlocks key=iKey item=aBlock}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="drag_handle"><input type="hidden" name="val[ordering][{$aBlock.block_id}]" value="{$aBlock.ordering}" /></td>
		<td class="t_center" style="width:20px;">
			<a href="#" class="js_drop_down_link" title="{phrase var='admincp.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.block.add.' id=$aBlock.block_id}">{phrase var='admincp.edit'}</a></li>		
					<li><a href="{url link='admincp.block.' delete=$aBlock.block_id}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='admincp.delete'}</a></li>					
				</ul>
			</div>		
		</td>	
		<td>
		{if !empty($aBlock.title)}
			{$aBlock.title}
		{else}
		{if $aBlock.type_id > 0}
			{if $aBlock.type_id == 1}
			{phrase var='admincp.php_code'}
			{else}
			{phrase var='admincp.html_code'}
			{/if}
		{else}
			{$aBlock.module_name}::{$aBlock.component}
		{/if}
		{/if}
		</td>
		<td class="t_center" style="width:60px;">
			<div class="js_item_is_active"{if !$aBlock.is_active} style="display:none;"{/if}>
				<a href="#?call=admincp.updateBlockActivity&amp;id={$aBlock.block_id}&amp;active=0" class="js_item_active_link" title="{phrase var='admincp.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aBlock.is_active} style="display:none;"{/if}>
				<a href="#?call=admincp.updateBlockActivity&amp;id={$aBlock.block_id}&amp;active=1" class="js_item_active_link" title="{phrase var='admincp.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>		
	</tr>	
	{/foreach}
	</table>
	{/foreach}