<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-logo.html.php 7042 2014-01-14 12:42:41Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
						{if !empty($sStyleLogo)}
						<a href="{url link=''}" id="logo"><img src="{$sStyleLogo}" alt="logo" class="v_middle" /></a>
						{else}
						<a href="{url link=''}" id="logo">{param var='core.site_title'}</a>
						{/if}
