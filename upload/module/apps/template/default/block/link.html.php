<?php

defined('PHPFOX') or exit('No dice!');
?>
{if Phpfox::getUserParam('apps.can_moderate_apps') || $aApp.user_id == Phpfox::getUserId()}
<li><a href="{url link='apps.add' id=$aApp.app_id}">{phrase var='apps.manage'}</a></li>
{/if}
{if isset($aApp.is_installed) && $aApp.is_installed}
	<li class="item_uninstall">
		<a href="{url link='apps' uninstall=$aApp.app_id}" onclick="return confirm('{phrase var='apps.are_you_sure' phpfox_squote=true}');" class="no_ajax_link">
			{phrase var='apps.uninstall'}
		</a>
	</li>
	<li class="item_permissions">
		<a href="#" onclick="tb_show('Customize Access', $.ajaxBox('apps.showSetPermissions', 'TB_inline=true&amp;height=450&amp;width=400&amp;id={$aApp.app_id}')); return false;">
		   {phrase var='apps.permissions'}
		</a>
	</li>
{/if}
{if Phpfox::getUserParam('apps.can_moderate_apps') || $aApp.user_id == Phpfox::getUserId()}
	<li class="item_delete">
		<a href="{url link='apps' delete=$aApp.app_id}" onclick="return confirm('{phrase var='apps.are_you_sure' phpfox_squote=true}');" class="no_ajax_link">
			{phrase var='apps.delete'}
		</a>
	</li>
{/if}