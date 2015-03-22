<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: entry.html.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($aGroups.items)}
{foreach from=$aGroups.items name=favorites item=aFavorite}
<div id="js_favorite_item_{$aFavorite.favorite_id}" class="{if is_int($phpfox.iteration.favorites/2)}row1{else}row2{/if}{if $phpfox.iteration.favorites == 1} row_first{/if} js_favorite_group_{$aGroups.title|clean_phrase} js_favorite_item">
	<div style="float:left; width:80px; text-align:center;">
	{if !empty($aFavorite.image)}
		<a href="{$aFavorite.link}">{$aFavorite.image}</a>
		{else}
		{img user=$aFavorite suffix='_50' max_width=75 max_height=75}
	{/if}
	</div>
	<div style="margin-left:85px; height:80px;">
		<a href="{$aFavorite.link}">{$aFavorite.title|clean}</a>
		<div class="extra_info">
		{if isset($aFavorite.extra_info)}
			{$aFavorite.extra_info}
		{else}
			{phrase var='favorite.added_by_user_on_time_stamp_phrase' user=$aFavorite}
		{/if}
		</div>
		<div class="t_right">
		{if isset($iFavoriteUserId) && $iFavoriteUserId == Phpfox::getUserId()}
			<ul class="item_menu">
				<li><a href="#" onclick="if (confirm('{phrase var='favorite.are_you_sure' phpfox_squote=true}')) {left_curly} $('#js_favorite_item_{$aFavorite.favorite_id}').remove(); $.ajaxCall('favorite.delete', 'favorite_id={$aFavorite.favorite_id}'); {right_curly} return false;">{phrase var='favorite.delete'}</a></li>
			</ul>
		{/if}
		</div>
	</div>	
	<div class="clear"></div>
</div>
{/foreach}
{/if}