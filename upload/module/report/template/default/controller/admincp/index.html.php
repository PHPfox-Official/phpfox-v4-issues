<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='report.reports'}
</div>
<form method="post" action="{url link='admincp.report'}">
	{if count($aReports)}
	<table>
	<tr>
		<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
		<th>{phrase var='report.module'}</th>
		<th>{phrase var='report.category'}</th>
		<th>{phrase var='report.total'}</th>
		<th>{phrase var='report.date'}</th>
		<th>{phrase var='report.last_report'}</th>
		<th>{phrase var='report.feedback'}</th>
	</tr>	
	{foreach from=$aReports key=iKey item=aReport}
	<tr id="js_row{$aReport.data_id}" class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td><input type="checkbox" name="id[]" class="checkbox" value="{$aReport.data_id}" id="js_id_row{$aReport.data_id}" /></td>
		<td><a href="{url link='admincp.report' view=$aReport.data_id}">{$aReport.module_id|translate:'module'}</a></td>
		<td>{$aReport.message|convert|clean}</td>
		<td class="t_center"><a href="#" onclick="tb_show('Browse Reports', $.ajaxBox('report.browse', 'height=400&amp;width=600&amp;data_id={$aReport.data_id}')); return false;">{$aReport.total_report}</a></td>
		<td>{$aReport.added|date:'core.global_update_time'}</td>
		<td>{$aReport|user}</td>
		<td>{$aReport.feedback}</td>
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
	{* <input type="submit" name="delete" value="{phrase var='report.delete_selected'}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" /> *}
		<input type="submit" name="ignore" value="{phrase var='report.ignore_selected'}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" />
	</div>
	{else}
	<div class="extra_info">
		{phrase var='report.no_reports'}
	</div>
	{/if}
</form>

{pager}