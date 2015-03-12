<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: browse.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='report.reports'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='report.user'}</th>
		<th>{phrase var='report.category'}</th>
		<th>{phrase var='report.date'}</th>
	</tr>
{foreach from=$aReports item=aReport}
	<tr>
		<td>{$aReport|user}</td>
		<td>{$aReport.message|clean}</td>
		<td>{$aReport.added|date:'core.global_update_time'}</td>
	</tr>
{/foreach}
</table>