<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: footer.html.php 1248 2009-11-04 08:17:53Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="favorite_menu">
	<ul>
		<li><a href="#" onclick="$(this).parents('ul:first').find('a').removeClass('active'); $(this).addClass('active'); $('#js_favorite_content_footer .js_favorite_item').show(); $('#js_favorite_content_footer .block .title').show(); return false;" class="active">{phrase var='favorite.recently_added'}</a></li>
		{foreach from=$aFavMenus item=sFavMenu}
		<li><a href="#{$sFavMenu|clean_phrase}" onclick="$(this).parents('ul:first').find('a').removeClass('active'); $(this).addClass('active'); $('#js_favorite_content_footer .js_favorite_item').hide(); $('#js_favorite_content_footer .js_favorite_group_{$sFavMenu|clean_phrase}').show(); $('#js_favorite_content_footer .block .title').hide(); return false;">{$sFavMenu}</a></li>
		{/foreach}
	</ul>
	<div class="clear"></div>
</div>
<div id="js_favorite_content_footer" class="footer_menu_content" style="overflow:auto; height:200px;">	
{if count($aFavorites)}
	{foreach from=$aFavorites item=aGroups}
		{module name='favorite.entry' favorite_title=$aGroups.title}	
	{/foreach}
{else}
	<div class="extra_info">
		{phrase var='favorite.you_do_not_have_any_items_or_users_listed_in_your_favorites_just_yet'}
	</div>
{/if}
</div>