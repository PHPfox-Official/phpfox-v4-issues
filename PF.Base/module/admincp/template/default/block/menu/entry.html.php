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
	<td class="drag_handle">
		<input type="hidden" name="val[{$aMenu.menu_id}][ordering]" value="{$aMenu.ordering}" size="3" class="t_center" />
	</td>
	<td>{$aMenu.name}</td>
	<td>{$aMenu.url_value}</td>
	<td>
		<ul class="table_actions">
			<li><a href="{url link='admincp.menu.add.' id=$aMenu.menu_id}" class="popup"><i class="fa fa-edit"></i></a></li>
			<li><a href="{url link='admincp.menu.' delete=$aMenu.menu_id}" class="sJsConfirm"><i class="fa fa-remove"></i></a></li>
		</ul>
	</td>
</tr>