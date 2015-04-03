<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: index.html.php 2826 2011-08-11 19:41:03Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.menu' parent=$iParentId}">
	<table id="js_drag_drop" cellpadding="0" cellspacing="0">
	{if $iParentId === 0}
	{foreach from=$aMenus key=sType item=aMenusSub}
	<tr>
		<td colspan="5" class="table_header2">
			{$sType}	
		</td>
	</tr>
		{foreach from=$aMenusSub key=iKey item=aMenu}
			{template file='admincp.block.menu.entry'}
		{/foreach}
	{/foreach}
	{/if}
	</table>
</form>
