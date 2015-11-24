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
{if (!$bIsUsersProfilePage && (count($aSubMenus) || isset($customMenu))) && Phpfox::isUser()}
<div class="page_breadcrumbs_menu">
	{if Phpfox::isUser()}
	{if (isset($customMenu))}
	<a class="btn btn-sm btn-default" href="{$customMenu.url}" {$customMenu.extra}>
		+ {$customMenu.title}
	</a>
	{/if}
	{foreach from=$aSubMenus key=iKey name=submenu item=aSubMenu}
	<a href="{url link=$aSubMenu.url)}"{if (isset($aSubMenu.css_name))} class="btn btn-sm btn-danger {$aSubMenu.css_name} no_ajax"{else}class="btn btn-sm btn-danger"{/if}>
	+ {phrase var=$aSubMenu.module'.'$aSubMenu.var_name}
	</a>
	{/foreach}
	{else}
	{if Phpfox::getParam('user.allow_user_registration')}
<!--	<a class="btn btn-sm btn-default" href="{url link='user.register'}">Register</a>-->
	{/if}
<!--	<a class="btn btn-sm btn-default" href="{url link='user.login'}">Login</a>-->
	{/if}
</div>
{/if}


