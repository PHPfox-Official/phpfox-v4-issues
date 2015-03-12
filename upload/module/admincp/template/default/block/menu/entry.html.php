<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: entry.html.php 1300 2009-12-07 00:39:10Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?><tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
	<td class="t_center"><input type="text" name="val[{$aMenu.menu_id}][ordering]" value="{$aMenu.ordering}" size="3" class="t_center" /></td>
	<td>{$aMenu.name}</td>
	<td>{$aMenu.url_value}</td>
	<td class="t_center"><input type="checkbox" name="val[{$aMenu.menu_id}][is_active]" value="1" {if $aMenu.is_active}checked="checked" {/if}/></td>
	<td>
		<select name="action" class="goJump" style="width:140px;">
			<option value="">{phrase var='language.select_action'}</option>		
			<option value="{url link='admincp.menu.add.' id=$aMenu.menu_id}">{phrase var='admincp.edit'}</option>
			{if $aMenu.total_children > 0}
			<option value="{url link='admincp.menu' parent=$aMenu.menu_id}">{phrase var='admincp.manage_children_total_children' total_children=$aMenu.total_children}</option>
			{/if}
			<option value="{url link='admincp.menu.' delete=$aMenu.menu_id}" style="color:red;">{phrase var='admincp.delete'}</option>
		</select>
	</td>
</tr>