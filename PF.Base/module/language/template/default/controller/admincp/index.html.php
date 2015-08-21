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
<div class="admincp_apps_holder">
	<section>
		<table cellpadding="0" cellspacing="0">
		{foreach from=$aLanguages key=iKey item=aLanguage}
			<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
					<td class="t_center" style="width:20px;">
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
			</tr>
		{/foreach}
		</table>
	</section>
	<section class="preview">
		<h1>Featured Language Packs</h1>
		<div class="phpfox_store_featured" data-type="language" data-parent="{url link='admincp.store' load='language'}"></div>
	</section>
</div>