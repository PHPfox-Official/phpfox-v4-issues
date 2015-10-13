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
	{if (!$bIsUsersProfilePage && (count($aSubMenus) || isset($customMenu))) || !Phpfox::isUser()}
	<div class="breadcrumbs_menu">
		<ul>
			{if Phpfox::isUser()}
				{if (isset($customMenu))}
				<li>
					<a href="{$customMenu.url}" {$customMenu.extra}>
						{$customMenu.title}
					</a>
				</li>
				{/if}
				{foreach from=$aSubMenus key=iKey name=submenu item=aSubMenu}
				<li>
					<a href="{url link=$aSubMenu.url)}"{if (isset($aSubMenu.css_name))} class="{$aSubMenu.css_name} no_ajax"{/if}>
						{phrase var=$aSubMenu.module'.'$aSubMenu.var_name}
					</a>
				</li>
				{/foreach}
			{else}
        {if Phpfox::getParam('user.allow_user_registration')}
				  <li class="register_menu"><a href="{url link='user.register'}">Register</a></li>
        {/if}
				<li class="login_menu"><a href="{url link='user.login'}">Login</a></li>
			{/if}
		</ul>
	</div>
	{/if}