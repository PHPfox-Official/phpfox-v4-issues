<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: counter.html.php 1335 2009-12-17 14:47:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bRefresh}
<div class="message">
	{phrase var='admincp.updating_counters_processing_page_current_out_of_page' current=$iCurrentPage page=$iTotalPages}
</div>
{else}
<div class="table_header">
	{phrase var='admincp.counters'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='admincp.type'}</th>
		<th class="t_center">{phrase var='admincp.actions'}</th>
	</tr>
{foreach from=$aLists key=sModule item=aSubLists}
	{foreach from=$aSubLists item=aList name=counters}
	<tr class="checkRow{if is_int($aList.count/2)}{else} tr{/if}">
		<td>
			{$aList.name}
		</td>
		<td class="t_center"><a href="{url link='admincp.maintain.counter' module=$sModule id=$aList.id}">{phrase var='admincp.update'}</a></td>
	</tr>
	{/foreach}
{/foreach}
</table>
<div class="table_clear"></div>
{/if}