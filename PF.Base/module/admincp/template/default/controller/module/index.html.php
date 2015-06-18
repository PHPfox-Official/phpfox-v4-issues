<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: index.html.php 1300 2009-12-07 00:39:10Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $aModules}
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='admincp.name'}</th>
		<th>{phrase var='admincp.product'}</th>
		<th style="width:60px;">{phrase var='admincp.active'}</th>		
	</tr>	
	{foreach from=$aModules key=iKey item=aModule}
		{template file='admincp.block.module.entry'}
	{/foreach}
	</table>
	<div class="table_clear"></div>
{else}
<div class="message">
	No modules found.
</div>
{/if}