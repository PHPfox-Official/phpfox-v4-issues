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
{if $bImportPhrases}
	<div class="message">
		{phrase var='language.importing_phrases_please_hold'}
	</div>
{else}
	{if Phpfox::getParam('core.is_auto_hosted')}		
	<form method="post" action="{url link='admincp.language.import'}" enctype="multipart/form-data">
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
		<div class="table_clear">
			<input type="submit" value="Import" class="button" />
		</div>	
	</form>
	{else}
	<div class="table_header">
		{phrase var='language.manual_install'}
	</div>
	{if count($aNewLanguages)}
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>{phrase var='language.title'}</th>
			<th>{phrase var='language.created_by'}</th>
			<th style="width:100px;">{phrase var='language.action'}</th>
		</tr>
		{foreach from=$aNewLanguages key=iKey item=aLanguage}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td>
				{if !empty($aLanguage.site)}<a href="{$aLanguage.site}" target="_blank">{/if}{$aLanguage.title|clean}</a>{if !empty($aLanguage.site)}</a>{/if}
			</td>
			<td>{if !empty($aLanguage.site)}<a href="{$aLanguage.site}" target="_blank">{/if}{if empty($aLanguage.created)}N/A{else}{$aLanguage.created}{/if}{if !empty($aLanguage.site)}</a>{/if}</td>
			<td class="t_center"><a href="{url link='admincp.language.import' install=$aLanguage.language_id}" title="{phrase var='theme.click_to_install_this_theme'}">{phrase var='theme.install'}</a></td>
		</tr>
		{/foreach}
	</table>
	{else}
	<div class="table">
		<div class="message">
			{phrase var='language.nothing_new_to_install'}
		</div>	
	</div>	
	{/if}
	<div class="table_clear"></div>
	<br />
	{/if}
{/if}