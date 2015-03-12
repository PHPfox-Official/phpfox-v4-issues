<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: ip.html.php 1025 2009-09-21 09:24:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aResults) && is_array($aResults)}
{foreach from=$aResults item=aResult}
<div class="table_header">
	{$aResult.table}
</div>
{if isset($aResult.th)}
<table cellpadding="0" cellspacing="0">
	<tr>
	{foreach from=$aResult.th item=sTh}
		<th>{$sTh}</th>
	{/foreach}
	</tr>
	{foreach from=$aResult.results key=iKey item=aValues}
	<tr{if is_int($iKey/2)} class="tr"{/if}>
	{foreach from=$aValues item=sValue}
		<td>{$sValue}</td>
	{/foreach}
	</tr>
	{/foreach}
</table>

{else}
{if isset($aResult.results)}
{foreach from=$aResult.results key=sKey item=sValue}
<div class="table">
	<div class="table_left">
		{$sKey}:
	</div>
	<div class="table_right">
		{$sValue}
	</div>
	<div class="clear"></div>
</div>
{/foreach}
{/if}
{/if}
<div class="table_clear"></div>
<br />
{/foreach}
{else}
<form method="post" action="{url link='admincp.core.ip'}">
	<div class="table_header">
		{phrase var='admincp.search'}
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.ip_address'}:
		</div>
		<div class="table_right">
			<input type="text" name="search" value="" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.search'}" class="button" />
	</div>
</form>
{/if}