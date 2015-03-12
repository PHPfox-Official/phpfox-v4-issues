<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Language
 * @version 		$Id: index.html.php 2023 2010-11-01 15:16:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='language.language_packages'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='language.language'}</th>
		<th>{phrase var='language.added'}</th>
		<th>{phrase var='language.created'}</th>
	</tr>
{foreach from=$aLanguages key=iKey item=aLanguage}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td class="t_center">
				<a href="#" class="js_drop_down_link" title="{phrase var='language.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						<li><a href="{url link="admincp.language.phrase" lang-id=""$aLanguage.language_id""}">{phrase var='language.manage_phrases'}</a></li>						
						<li><a href="{url link="admincp.language.add" id=""$aLanguage.language_id""}">{phrase var='language.edit_settings'}</a></li>
						<li><a href="{url link='admincp.language.missing' id=$aLanguage.language_id}">{phrase var='language.find_missing_phrases'}</a></li>
						<li><a href="{url link='admincp.language' export=$aLanguage.language_id}">{phrase var='language.export'}</a></li>
						<li><a href="{url link='admincp.language' export=$aLanguage.language_id custom='1'}">{phrase var='language.export_with_3rd_party_phrases'}</a></li>
						{if !$aLanguage.is_default}
						<li><a href="{url link="admincp.language" default=""$aLanguage.language_id""}">{phrase var='language.set_default'}</a></li>
						{if !$aLanguage.is_master}
						<li><a href="{url link="admincp.language.delete" id=""$aLanguage.language_id""}">{phrase var='language.delete'}</a></li>
						{/if}
						{/if}						
					</ul>
				</div>		
			</td>
		<td>{if $aLanguage.is_master}({phrase var='language.master'}) {/if}{$aLanguage.title}</td>
		<td>{$aLanguage.time_stamp|date:'core.global_update_time')}</td>
		<td>{if !empty($aLanguage.site)}<a href="{$aLanguage.site}" class="targetBlank">{/if}{if empty($aLanguage.created)}N/A{else}{$aLanguage.created|clean}{/if}{if !empty($aLanguage.site)}</a>{/if}</td>	
	</tr>
{/foreach}
</table>