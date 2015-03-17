{if isset($aPageSectionMenu) && count($aPageSectionMenu)}
<div class="page_section_menu page_section_menu_header">
	{if $aPageExtraLink !== null}
	<a href="{$aPageExtraLink.link}" class="page_section_menu_link">{$aPageExtraLink.phrase}</a>
	{/if}
	<ul>
	{foreach from=$aPageSectionMenu key=sPageSectionKey item=sPageSectionMenu name=pagesectionmenu}
		<li {if ($phpfox.iteration.pagesectionmenu == 1 && !$bPageIsFullLink) || ($bPageIsFullLink && $sPageSectionKey == $sPageCurrentUrl)} class="active"{/if}><a href="{if $bPageIsFullLink}{$sPageSectionKey}{else}#{/if}" {if !$bPageIsFullLink}rel="{$sPageSectionMenuName}_{$sPageSectionKey}"{/if}>{$sPageSectionMenu}</a></li>
	{/foreach}
	</ul>
	<div class="clear"></div>
</div>
{/if}
{section_menu_js}
