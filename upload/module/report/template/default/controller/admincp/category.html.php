<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: category.html.php 1347 2009-12-22 18:10:30Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.report.category'}">
	{if count($aCategories)}
	<table>
	<tr>
		<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
		<th>{phrase var='report.category'}</th>
		<th>{phrase var='report.module'}</th>		
	</tr>	
	{foreach from=$aCategories key=iKey item=aCategory}
	<tr id="js_row{$aCategory.report_id}" class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td><input type="checkbox" name="id[]" class="checkbox" value="{$aCategory.report_id}" id="js_id_row{$aCategory.report_id}" /></td>
		<td><a href="{url link='admincp.report.add' id=$aCategory.report_id}">{$aCategory.message|convert|clean}</a></td>
		<td>{$aCategory.module_id|translate:'module'}</td>		
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" name="delete" value="{phrase var='report.delete_selected'}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" />		
	</div>
	{else}
	<div class="extra_info">
		{phrase var='report.no_categories'}
	</div>
	{/if}
</form>