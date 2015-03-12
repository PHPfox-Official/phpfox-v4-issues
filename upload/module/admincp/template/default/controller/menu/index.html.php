<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: index.html.php 2826 2011-08-11 19:41:03Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.menu' parent=$iParentId}">
	<table cellpadding="0" cellspacing="0">
	{if $iParentId === 0}
	<tr>
		<td colspan="5" class="table_header">
			{phrase var='admincp.menu_block'}
		</td>
	</tr>	
	{foreach from=$aMenus key=sType item=aMenusSub}
	<tr>
		<td colspan="5" class="table_header2">
			{$sType}	
		</td>
	</tr>
	<tr>
		<th style="width:60px;">{phrase var='admincp.order'}</th>
		<th>{phrase var='admincp.menu'}</th>
		<th>{phrase var='admincp.location'}</th>
		<th style="width:60px;">{phrase var='admincp.active'}</th>
		<th>{phrase var='admincp.actions'}</th>
	</tr>	
	{foreach from=$aMenusSub key=iKey item=aMenu}
	{template file='admincp.block.menu.entry'}
	{/foreach}
	{/foreach}
	{/if}
	<tr>
		<td colspan="5" class="table_header">
		{if $iParentId === 0}
			{phrase var='admincp.modules'}
			{else}
			Children: {phrase var=''$aParentMenu.module_id'.'$aParentMenu.var_name''}
		{/if}
		</td>
	</tr>
	{foreach from=$aModules key=sModule item=aMenusSub}
	{if $iParentId === 0}
	<tr>
		<td colspan="5" class="table_header2">
			{$sModule}	
		</td>
	</tr>
	{/if}
	<tr>
		<th style="width:60px;">{phrase var='admincp.order'}</th>
		<th>{phrase var='admincp.menu'}</th>
		<th>{phrase var='admincp.location'}</th>
		<th style="width:60px;">{phrase var='admincp.active'}</th>
		<th>{phrase var='admincp.actions'}</th>
	</tr>	
	{foreach from=$aMenusSub key=iKey item=aMenu}
	{template file='admincp.block.menu.entry'}
	{/foreach}
	{/foreach}
	</table>
	<div class="table_bottom table_hover_action">
		<input type="submit" value="{phrase var='admincp.update'}" class="button" />
	</div>
</form>
