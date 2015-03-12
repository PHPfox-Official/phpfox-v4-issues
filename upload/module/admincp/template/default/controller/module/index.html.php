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
	<table cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="4" class="table_header">{phrase var='admincp.core_modules'}</td>
	</tr>
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='admincp.name'}</th>
		<th>{phrase var='admincp.product'}</th>
		<th style="width:60px;">{phrase var='admincp.active'}</th>
	</tr>	
	{foreach from=$aModules.core key=iKey item=aModule}
	{template file='admincp.block.module.entry'}
	{/foreach}
	<tr>
		<td colspan="4" class="table_header">{phrase var='admincp.modules'}</td>
	</tr>
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='admincp.name'}</th>
		<th>{phrase var='admincp.product'}</th>
		<th style="width:60px;">{phrase var='admincp.active'}</th>		
	</tr>	
	{foreach from=$aModules.3rdparty key=iKey item=aModule}
	{template file='admincp.block.module.entry'}
	{/foreach}
	</table>
	<div class="table_clear"></div>