<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1284 2009-11-27 23:44:31Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="message">
	{phrase var='admincp.database_size'}: {$iSize|filesize} - {phrase var='admincp.overhead'}: {$iOverhead|filesize} - {phrase var='admincp.total_tables'}: {$iCnt}
</div>

<form method="post" action="{url link='admincp.sql'}">
	<div class="table_header">
		{phrase var='admincp.sql_tables'}
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>	
		<th>{phrase var='admincp.table'}</th>
		<th class="t_center">{phrase var='admincp.records'}</th>
		<th class="t_center">{phrase var='admincp.size'}</th>
		<th class="t_center">{phrase var='admincp.overhead'}</th>
	</tr>
	{foreach from=$aItems key=iKey item=aItem}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td><input type="checkbox" name="tables[]" class="checkbox" value="{$aItem.Name}" id="js_id_row{$iKey}" /></td>
			<td>{$aItem.Name}</td>
			<td class="t_center">{$aItem.Rows}</td>
			<td class="t_center">{$aItem.Data_length|filesize}</td>
			<td class="t_center">{$aItem.Data_free|filesize}</td>
		</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" name="optimize" value="{phrase var='admincp.optimize_table_s'}" class="button sJsCheckBoxButton disabled" disabled="true" />
		<input type="submit" name="repair" value="{phrase var='admincp.repair_table_s'}" class="button sJsCheckBoxButton disabled" disabled="true" />
	</div>
</form>