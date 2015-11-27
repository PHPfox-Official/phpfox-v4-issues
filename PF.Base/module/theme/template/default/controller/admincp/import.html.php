<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: import.html.php 4961 2012-10-29 07:11:34Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{if !Phpfox::getParam('core.is_auto_hosted')}
	<div class="table_header">
		{phrase var='theme.manual_install'}
	</div>
	{if count($aNewThemes)}
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>{phrase var='theme.theme'}</th>
			<th>{phrase var='theme.styles'}</th>
			<th>{phrase var='theme.version'}</th>
			<th>{phrase var='theme.created_by'}</th>
			<th>{phrase var='theme.parent_theme'}</th>
			<th style="width:100px;">{phrase var='theme.action'}</th>
		</tr>
		{foreach from=$aNewThemes key=iKey item=aTheme}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td>
				{if !empty($aTheme.website)}<a href="{$aTheme.website}" target="_blank">{/if}{$aTheme.name}</a>	{if !empty($aTheme.website)}</a>{/if}
			</td>
			<td class="t_center">{$aTheme.total_style}</td>
			<td>{if empty($aTheme.version)}N/A{else}{$aTheme.version}{/if}</td>
			<td>{if !empty($aTheme.website)}<a href="{$aTheme.website}" target="_blank">{/if}{if empty($aTheme.creator)}N/A{else}{$aTheme.creator}{/if}{if !empty($aTheme.website)}</a>{/if}</td>
			<td>{$aTheme.parent}</td>
			<td class="t_center"><a href="{url link='admincp.theme.import' install=$aTheme.folder}" title="{phrase var='theme.click_to_install_this_theme'}">{phrase var='theme.install'}</a></td>
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
	{/if}
	
	{if Phpfox::getParam('core.is_auto_hosted')}		
	<form method="post" action="{url link='admincp.theme.import'}" enctype="multipart/form-data">
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
	{/if}