<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: display.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="comment_mini">
	{img theme='misc/thumb_up.png' class='v_middle'}&nbsp;
	{if count($aFeed.like_rows) == 1}
	{if $aFeed.like_rows.0.user_id == Phpfox::getUserId()}{phrase var='feed.you_like_this'}{else}{phrase var='feed.user_link_likes_this' user_link=$aFeed.like_rows.0|user}{/if}
	{elseif count($aFeed.like_rows) == 2}
	{if $aFeed.like_rows.0.user_id == Phpfox::getUserId()}{phrase var='feed.you_and_user_link_like_this' user_link=$aFeed.like_rows.1|user}{else}{if $aFeed.like_rows.1.user_id == Phpfox::getUserId()}{phrase var='feed.you_and_user_link_like_this' user_link=$aFeed.like_rows.0|user}{else}{phrase var='feed.user_link_and_user_link_like_this' user_link_owner=$aFeed.like_rows.0|user user_link=$aFeed.like_rows.1|user}{/if}{/if}
	{else}
	{foreach from=$aFeed.like_rows name=likes item=aLikeRow}
		{if $phpfox.iteration.likes == count($aFeed.like_rows) && $aFeed.like_count <= 0} {phrase var='feed.and'} {/if}{if $aLikeRow.user_id == Phpfox::getUserId()}{phrase var='feed.you'}{else}{$aLikeRow|user}{/if}{if $phpfox.iteration.likes != count($aFeed.like_rows)},{/if} 
	{/foreach}
	{if $aFeed.like_count > 0} {phrase var='feed.and'} <a href="#" onclick="tb_show('{phrase var='feed.people_who_like_this' phpfox_squote=true}', $.ajaxBox('feed.likeList', 'height=410&amp;width=300&amp;feed_id={$aFeed.feed_id}')); return false;">{$aFeed.like_count} {if $aFeed.like_count == 1}{phrase var='feed.other_person'}{else}{phrase var='feed.others'}{/if}</a> {/if} {phrase var='feed.like_this'}.
	{/if}
</div>