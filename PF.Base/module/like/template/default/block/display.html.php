
{if Phpfox::getParam('like.show_user_photos')}
	<div class="activity_like_holder comment_mini" style="position:relative;">		
		<a href="#" class="like_count_link js_hover_title" onclick="return $Core.box('like.browse', 400, 'type_id={if isset($aFeed.like_type_id)}{$aFeed.like_type_id}{else}{$aFeed.type_id}{/if}&amp;item_id={$aFeed.item_id}');">			
			{$aFeed.feed_total_like|number_format}
			<span class="js_hover_info">
				{if defined('PHPFOX_IS_THEATER_MODE')}{phrase var='like.likes'}{else}{phrase var='like.people_who_like_this'}{/if}
			</span>
		</a>		
		{module name='like.displayactions' aFeed=$aFeed}		
		
		<div class="like_count_link_holder">
			{foreach from=$aFeed.likes name=likes item=aLikeRow}
				{img user=$aLikeRow suffix='_50_square' max_width=32 max_height=32 class='js_hover_title v_middle'}&nbsp;
			{/foreach}
		</div>
	</div>	
{else}

	{if !empty($aFeed.feed_like_phrase)}
	{if (isset($aFeed.feed_total_like) && $aFeed.feed_total_like)}<span class="activity_like_holder_total hide_it" onclick="return $Core.box('like.browse', 400, 'type_id={if isset($aFeed.like_type_id)}{$aFeed.like_type_id}{else}{$aFeed.type_id}{/if}&amp;item_id={$aFeed.item_id}');"><i>{$aFeed.feed_total_like|number_format}</i></span>{/if}
	<div class="activity_like_holder" id="activity_like_holder_{$aFeed.feed_id}">
		{$aFeed.feed_like_phrase}
	</div>
	{else}
	{/if}

{/if}
