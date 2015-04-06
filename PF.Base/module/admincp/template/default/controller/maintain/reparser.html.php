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
<table cellpadding="0" cellspacing="0">
{foreach from=$aReparserLists key=sModule name=list item=aReparserList}
	<tr class="checkRow{if is_int($phpfox.iteration.list/2)}{else} tr{/if}">
		<td>
			{$aReparserList.name}
		</td>
		<td>
			<ul class="table_actions">
				<li>
					<a href="{url link='admincp.maintain.reparser' module=$sModule}">Run (records: {$aReparserList.total_record})</a>
				</li>
			</ul>
		</td>
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