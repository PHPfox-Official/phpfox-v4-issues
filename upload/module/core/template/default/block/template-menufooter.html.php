<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-menufooter.html.php 6413 2013-08-05 09:42:03Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !Phpfox::getUserBy('profile_page_id')}
	<ul id="footer_menu">
		{foreach from=$aFooterMenu key=iKey item=aMenu name=footer}
		<li{if $phpfox.iteration.footer == 1} class="first"{/if}><a href="{url link=''$aMenu.url''}" class="ajax_link{if $aMenu.url == 'mobile'} no_ajax_link{/if}">{phrase var=$aMenu.module'.'$aMenu.var_name}</a></li>
		{/foreach}					
		{if Phpfox::getUserParam('core.can_design_dnd')}
		<li>
			{if !Phpfox::getService('theme')->isInDnDMode()}
				<a href="#" onclick="$.ajaxCall('core.designdnd', 'enable=1&amp;inline=1'); return false;">
					{phrase var='core.enable_dnd_mode'}
				</a>
			{else}
				<a href="#" onclick="$.ajaxCall('core.designdnd', 'enable=2&amp;inline=1'); return false;">
					{phrase var='core.disable_dnd_mode'}
				</a>
			{/if}
		</li>
		{/if}
	</ul>
{/if}