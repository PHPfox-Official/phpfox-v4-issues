<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-copyright.html.php 3056 2011-09-09 18:28:44Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{param var='core.site_copyright'} &middot; <a href="#" id="select_lang_pack">{if Phpfox::getParam('language.display_language_flag') && !empty($sLocaleFlagId)}<img src="{$sLocaleFlagId}" alt="{$sLocaleName}" class="v_middle" /> {/if}{$sLocaleName}</a> {product_branding}