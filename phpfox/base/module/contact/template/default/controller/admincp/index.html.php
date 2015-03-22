<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Contact
 * @version 		$Id: index.html.php 1802 2010-09-08 12:52:12Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

?>

<form method="post" action="{url link='admincp.contact'}" id="admincp_contact_form_add">
<input type="hidden" name="action" value="add"/>
	<div class="table_header">
		{phrase var='contact.add_a_new_category'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='language.module_language'}:
		</div>
		<div class="table_right">
			<select>
				
				{foreach from=$aLanguages item=aLanguage}
				<option value="{$aLanguage.language_id}"> {$aLanguage.title} </option>
				{/foreach}

			</select>
		</div>
		<div class="clear"></div>
		
		<div class="table_left">
			{phrase var='contact.category'}:
		</div>
		<div class="table_right">
			<input type="text" id="new_category" name="new_category" value="" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='contact.add'}" class="button" />
	</div>
</form>

<br />

<div class="table_header">
	{phrase var='contact.manage_categories'}
</div>
<form method="post" id="admincp_contact_form_edit" action="{url link='admincp.contact'}">
	<table id="js_drag_drop">
	<tr>
		<th style="width:10px;">{phrase var='contact.order'}</th>
		
		<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
		
		<th>{phrase var='contact.category'}</th>
	</tr>
	{foreach from=$aCategories key=iKey item=aCategory}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="drag_handle"><input type="hidden" name="val[ordering][{$aCategory.category_id}]" value="{$aCategory.ordering}" /></td>
		<td><input type="checkbox" name="id[]" class="checkbox" value="{$aCategory.category_id}" id="js_id_row" /></td>
		
		<td><input type="text" name="title_{$aCategory.category_id}" value="{$aCategory.title}" size="40" /></td>
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" name="delete" value="{phrase var='contact.delete_selected'}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" />
		<input type="submit" name="update" value="{phrase var='contact.edit'}" class="button" />
	</div>
</form>