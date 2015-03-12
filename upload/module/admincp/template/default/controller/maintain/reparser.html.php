<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: reparser.html.php 1194 2009-10-18 12:43:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!');

?>
{if isset($bInProcess)}
<div class="message">
	{phrase var='admincp.parsing_page_current_total_please_hold' current=$iCurrentPage total=$iTotalPages}
</div>
{else}
{if count($aReparserLists)}
<div class="table_header">
	{phrase var='admincp.modules'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='admincp.text_data'}</th>
		<th>{phrase var='admincp.records'}</th>
	</tr>
{foreach from=$aReparserLists key=sModule name=list item=aReparserList}
	<tr class="checkRow{if is_int($phpfox.iteration.list/2)}{else} tr{/if}">
		<td>
			<a href="{url link='admincp.maintain.reparser' module=$sModule}">{$aReparserList.name}</a>
		</td>
		<td class="t_center">{$aReparserList.total_record}</td>		
	</tr>
{/foreach}
</table>
<div class="table_clear"></div>
{else}
<div class="extra_info">
	{phrase var='admincp.there_is_no_data_to_parse'}
</div>
{/if}
{/if}