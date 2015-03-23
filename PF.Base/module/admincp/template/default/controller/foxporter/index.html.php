<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 2921 2011-08-29 17:35:44Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($aImportModules)}
<div class="table_header">
	{phrase var='admincp.modules'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:150px;">{phrase var='admincp.name'}</th>
		<th>{phrase var='admincp.description'}</th>
		<th style="width:150px;"></th>
	</tr>
{foreach from=$aImportModules name=modules key=sModule item=aModule}
	<tr{if !is_int($phpfox.iteration.modules/2)} class="tr"{/if}>
		<td style="width:150px;"><a href="{$aModule.link}" target="_blank">{$aModule.name}</a></td>
		<td>{$aModule.description}</td>
		<td style="width:150px;"><a href="{url link='admincp.foxporter' module=$sModule}" class="action_link">{phrase var='admincp.start_importing'}</a></td>
	</tr>
{/foreach}
</table>
<div class="table_clear"></div>
{else}
{if isset($aData.content)}
{$aData.content}
{else}
<div class="table_header">
	{phrase var='admincp.importing_data'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr class="tr">
		<td>{$aData.phrase}</td>
	</tr>
</table>
<div class="table_clear">
{if !isset($aData.completed)}
{if isset($aData.next_page)}
Please hold while we refresh to the next page.
<meta http-equiv="refresh" content="2;url={url link='admincp.foxporter' module=$sCurrentModule step=$aData.next page=$aData.next_page}"> 
{else}
{if $aData.next === false}
	<input type="button" onclick="window.location.href='{url link='current'}';" value="{phrase var='admincp.refresh'}" class="button" />
{else}
	<input type="button" onclick="window.location.href='{url link='admincp.foxporter' module=$sCurrentModule step=$aData.next}';" value="{phrase var='admincp.continue_to_the_next_step'}" class="button" />
{/if}
{/if}
{/if}
</div>
{/if}
{/if}