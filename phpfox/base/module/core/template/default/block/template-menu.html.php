<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-menu.html.php 6937 2013-11-24 18:11:09Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<nav>
	{plugin call='core.template_block_template_menu_1'}
	{if Phpfox::getUserBy('profile_page_id') <= 0}
	<ul>
		{plugin call='theme_template_core_menu_list'}
		{if ($iMenuCnt = 0)}{/if}
		{foreach from=$aMainMenus key=iKey item=aMainMenu name=menu}
		{if !isset($aMainMenu.is_force_hidden)}
		{iterate int=$iMenuCnt}
		{/if}
		<li rel="menu{$aMainMenu.menu_id}" {if (isset($iTotalHide) && isset($iMenuCnt) && $iMenuCnt > $iTotalHide)} style="display:none;" {/if} {if (($aMainMenu.url == 'apps' && count($aInstalledApps)) || (isset($aMainMenu.children) && count($aMainMenu.children))) || (isset($aMainMenu.is_force_hidden))}class="{if isset($aMainMenu.is_force_hidden) && isset($iTotalHide)}is_force_hidden{else}explore{/if}{if ($aMainMenu.url == 'apps' && count($aInstalledApps))} explore_apps{/if}"{/if}>
			<a {if !isset($aMainMenu.no_link) || $aMainMenu.no_link != true}href="{url link=$aMainMenu.url}" {else} href="#" onclick="return false;" {/if} class="{if isset($aMainMenu.is_selected) && $aMainMenu.is_selected} menu_is_selected {/if}{if isset($aMainMenu.external) && $aMainMenu.external == true}no_ajax_link {/if}ajax_link">
			{if isset($aMainMenu.mobile_icon) && $aMainMenu.mobile_icon}<i class="fa fa-{$aMainMenu.mobile_icon}"></i>{/if}
			{phrase var=$aMainMenu.module'.'$aMainMenu.var_name}{if isset($aMainMenu.suffix)}{$aMainMenu.suffix}{/if}
			</a>
		</li>
		{/foreach}
	</ul>
	{/if}
</nav>