<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: import.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div class="table_header">
		{phrase var='theme.manual_install'}
	</div>
	{if count($aNewStyles)}
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>{phrase var='theme.theme'}</th>
			<th>{phrase var='theme.version'}</th>
			<th>{phrase var='theme.created_by'}</th>
			<th>{phrase var='theme.parent_theme'}</th>
			<th style="width:100px;">{phrase var='theme.action'}</th>
		</tr>
		{foreach from=$aNewStyles key=iKey item=aStyle}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td>
				{if !empty($aStyle.website)}<a href="{$aStyle.website}" target="_blank">{/if}{$aStyle.name}</a>	{if !empty($aStyle.website)}</a>{/if}
			</td>
			<td>{if empty($aStyle.version)}{phrase var='theme.n_a'}{else}{$aStyle.version}{/if}</td>
			<td>{if !empty($aStyle.website)}<a href="{$aStyle.website}" target="_blank">{/if}{if empty($aStyle.creator)}{phrase var='theme.n_a'}{else}{$aStyle.creator}{/if}{if !empty($aStyle.website)}</a>{/if}</td>
			<td>{$aStyle.parent_theme}</td>
			<td class="t_center"><a href="{url link='admincp.theme.style.import' parent-theme=$aStyle.parent_theme install=$aStyle.folder}" title="{phrase var='theme.click_to_install_this_theme'}">{phrase var='theme.install'}</a></td>
		</tr>
		{/foreach}
	</table>
	{else}
	<div class="table">
		<div class="message">
			{phrase var='theme.nothing_new_to_install'}
		</div>	
	</div>	
	{/if}
	<div class="table_clear"></div>
	<br />

{*
{if Phpfox::getParam('core.ftp_enabled')}
<form method="post" action="{url link='admincp.theme.style.import'}" enctype="multipart/form-data">
	<div class="table_header">
		Import
	</div>
	<div class="table">
		<div class="table_left">
			File:
		</div>
		<div class="table_right">
			<input type="file" name="import" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			Overwrite:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="overwrite" value="1" /> Yes</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="overwrite" value="0" checked="checked" /> No</span>
			</div>			
		</div>
		<div class="clear"></div>		
	</div>		
	<div class="table_clear">
		<input type="submit" value="Import" class="button" />
	</div>
</form>
{else}
<div class="message">
	FTP support must be enabled in order to import styles.
</div>
<div class="extra_info">
	Click <a href="{url link='admincp.setting.edit' group-id='ftp'}">here</a> to enable FTP support.
</div>
{/if}
*}