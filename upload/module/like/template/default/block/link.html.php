<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: link.html.php 6671 2013-09-25 10:06:46Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<li class="li_action">
	<a href="#" onclick="$Core.Like.Actions.doLike({if $aLike.like_is_custom}1{else}0{/if}, '{$aLike.like_type_id}', {$aLike.like_item_id}, {if isset($aFeed.feed_id)}{$aFeed.feed_id}{else}0{/if}, this); return false;" class="js_like_link_toggle js_like_link_like"{if $aLike.like_is_liked} style="display:none;"{/if}>
		{phrase var='feed.like'}
	</a>
	<a href="#" onclick="$(this).parents('div:first').find('.js_like_link_like:first').show(); $(this).hide(); $.ajaxCall('like.delete', 'type_id={$aLike.like_type_id}&amp;item_id={$aLike.like_item_id}&amp;parent_id={if isset($aFeed.feed_id)}{$aFeed.feed_id}{else}{/if}{if $aLike.like_is_custom}&amp;custom_inline=1{/if}', 'GET'); return false;" class="js_like_link_toggle js_like_link_unlike"{if $aLike.like_is_liked}{else} style="display:none;"{/if}>{phrase var='feed.unlike'}</a>	
</li>

