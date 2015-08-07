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
<ul>
	{foreach from=$aFooterMenu key=iKey item=aMenu name=footer}
	<li{if $phpfox.iteration.footer == 1} class="first"{/if}><a href="{url link=''$aMenu.url''}" class="ajax_link{if $aMenu.url == 'mobile'} no_ajax_link{/if}">{phrase var=$aMenu.module'.'$aMenu.var_name}</a></li>
	{/foreach}
</ul>
<div class="copyright">
	<span>{param var='core.site_copyright'}</span>
	{if Phpfox::isTrial()}
	<div class="branding">
		{branding}
	</div>
	{/if}
</div>