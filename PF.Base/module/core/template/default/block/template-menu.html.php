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
<nav class="site_menu">
	{plugin call='core.template_block_template_menu_1'}
	{if Phpfox::getUserBy('profile_page_id') <= 0 && isset($aMainMenus)}
	<ul>
		{plugin call='theme_template_core_menu_list'}
		{if ($iMenuCnt = 0)}{/if}
		{foreach from=$aMainMenus key=iKey item=aMainMenu name=menu}
      {if !isset($aMainMenu.is_force_hidden)}
      {iterate int=$iMenuCnt}
      {/if}
      {if $aMainMenu.url!='pages'}
        <li rel="menu{$aMainMenu.menu_id}" {if (isset($iTotalHide) && isset($iMenuCnt) && $iMenuCnt > $iTotalHide)} style="display:none;" {/if} {if (($aMainMenu.url == 'apps' && count($aInstalledApps)) || (isset($aMainMenu.children) && count($aMainMenu.children))) || (isset($aMainMenu.is_force_hidden))}class="{if isset($aMainMenu.is_force_hidden) && isset($iTotalHide)}is_force_hidden{else}explore{/if}{if ($aMainMenu.url == 'apps' && count($aInstalledApps))} explore_apps{/if}"{/if}>
          <a {if !isset($aMainMenu.no_link) || $aMainMenu.no_link != true}href="{url link=$aMainMenu.url}" {else} href="#" onclick="return false;" {/if} class="{if isset($aMainMenu.is_selected) && $aMainMenu.is_selected} menu_is_selected {/if}{if isset($aMainMenu.external) && $aMainMenu.external == true}no_ajax_link {/if}ajax_link">
          {if isset($aMainMenu.mobile_icon) && $aMainMenu.mobile_icon}<i class="fa fa-{$aMainMenu.mobile_icon}"></i>{/if}
          {phrase var=$aMainMenu.module'.'$aMainMenu.var_name}{if isset($aMainMenu.suffix)}{$aMainMenu.suffix}{/if}
          </a>
        </li>
      {/if}
		{/foreach}
	</ul>
	{/if}
  <div class="nav_pages_holder">
    <div class="nav_title">
      <a href="{url link='pages'}" class="browse">
        <i class="fa fa-th"></i>
        Pages
      </a>
      {if Phpfox::isUser()}
      <a href="{url link='pages.add'}" class="create">Create</a>
      {/if}
    </div>
    {if Phpfox::isUser() && isset($pages)}
      <div class="nav_pages">
        {foreach from=$pages item=page}
        <a href="{$page.link}" class="js_hover_title">
          {img server_id=$page.user_server_id title=$page.title|clean path='pages.url_image' file=$page.image_path suffix='_50' max_width=32 max_height=32}
          <span class="js_hover_info">{$page.title|clean}</span>
        </a>
        {/foreach}
      </div>
    {/if}
  </div>
</nav>