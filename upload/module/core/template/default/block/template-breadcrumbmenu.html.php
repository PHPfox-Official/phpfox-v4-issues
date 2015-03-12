<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{if !$bIsUsersProfilePage && count($aSubMenus)}
	{if Phpfox::isMobile()}
		{if count($aSubMenus) == 1}
			{foreach from=$aSubMenus key=iKey name=submenu item=aSubMenu}
			<a href="{url link=$aSubMenu.url}" class="mobile_section_menu">{phrase var='core.add'}</a>
			{/foreach}
		{else}
			<a href="#" class="mobile_section_menu" onclick="$('#section_menu').toggle(); return false;">{phrase var='core.add'}</a>
		{/if}
		
	{/if}
	<div id="section_menu"{if Phpfox::isMobile()} style="display:none;"{/if}>
		<ul>
			{foreach from=$aSubMenus key=iKey name=submenu item=aSubMenu}
			<li><a href="{url link=$aSubMenu.url)}" {if isset($aSubMenu.css_name)}class="{$aSubMenu.css_name} no_ajax_link"{/if}>{if substr($aSubMenu.url, -4) == '.add' || substr($aSubMenu.url, -7) == '.upload' || substr($aSubMenu.url, -8) == '.compose'}{img theme='layout/section_menu_add.png' class='v_middle'}{/if}{phrase var=$aSubMenu.module'.'$aSubMenu.var_name}</a></li>
			{/foreach}
		</ul>						
		<div class="clear"></div>
	</div>
	{if Phpfox::isMobile()}
	<div class="clear"></div>
	{/if}
	{/if}	