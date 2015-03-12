<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='admincp.modules'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='admincp.type'}</th>
		<th class="t_center">{phrase var='admincp.actions'}</th>
	</tr>
{foreach from=$aLists key=iKey name=list item=aList}
	<tr class="checkRow{if is_int($phpfox.iteration.list/2)}{else} tr{/if}">
		<td>
			{$aList.name}
		</td>
		<td class="t_center"><a href="{url link='admincp.maintain.duplicate' table=$aList.table}">{phrase var='admincp.check'}</a></td>		
	</tr>
{/foreach}
</table>
<div class="table_clear"></div>