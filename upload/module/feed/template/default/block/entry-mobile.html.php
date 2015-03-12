<div class="feed{if $phpfox.iteration.feeds == 1} feed_first{/if}">

	<div class="feed_image">
		{img user=$aFeed  suffix='_50_square' max_width=50 max_height=50}	
	</div>		
	<div class="feed_content">
			{if $aFeed.type_id == 'comment_profile_my'}
			{if defined('PHPFOX_IS_USER_PROFILE') && $aUser.user_id == $aFeed.owner_user_id}
			{phrase var='feed.user_link_wrote' user=$aFeed user_prefix='viewer_'}
			{else}
			{if $aFeed.owner_user_id == $aFeed.viewer_user_id}
			{phrase var='feed.full_name_commented_on_their_own_profile' user_link=$aFeed.owner_user_link full_name=$aFeed.owner_full_name}
			{else}
			{phrase var='feed.viewer_full_name_wrote_on_owner_full_name_s_profile' viewer_full_name=$aFeed.viewer_full_name viewer_user_link=$aFeed.viewer_user_link owner_full_name=$aFeed.owner_full_name owner_user_link=$aFeed.owner_user_link}
			{/if}
			{/if}	
			{/if}
	
	<div>
		{if defined('PHPFOX_IS_USER_PROFILE') && $aFeed.type_id != 'comment_profile_my'}
		{if substr($aFeed.type_id, 0, 8) == 'comment_'}{img theme='misc/comment.png' class='v_middle'}	{/if}
		{if isset($aFeed.icon)}{img theme=$aFeed.icon class='v_middle'} {/if}
		{/if}
		{$aFeed.text}
	</div>
	<div class="feed_content_info">
		{if !defined('PHPFOX_IS_USER_PROFILE')}
		{if substr($aFeed.type_id, 0, 8) == 'comment_' && $aFeed.type_id != 'comment_profile_my_feedLike'}{img theme='misc/comment.png' class='v_middle'}	{/if}
		{if isset($aFeed.icon)}{img theme=$aFeed.icon class='v_middle'} {/if}
		{/if}	
		<span class="feed_time_stamp">{$aFeed.time_stamp|convert_time:'feed.feed_display_time_stamp'}</span>
		{if Phpfox::getParam('feed.allow_comments_on_feeds') && Phpfox::isUser() && Phpfox::isModule('comment')}
		<span>&nbsp;-&nbsp;<a href="{url link='feed.view' id=$aFeed.feed_id}">{if $aFeed.total_comments == 0}{phrase var='feed.comment'}{elseif $aFeed.total_comments == 1}{phrase var='feed.1_comment'}{else}{phrase var='feed.total_comments' total=$aFeed.total_comments}{/if}</a></span>
		{/if}
		{if Phpfox::isUser() && Phpfox::getParam('feed.enable_like_system') && (isset($aFeed.enable_like) || $aFeed.type_id == 'comment_profile_my')}
		<span>
			&nbsp;-&nbsp;
			<a href="{url link='feed.view' id=$aFeed.feed_id liketype=1}"{if isset($aFeed.is_liked) && $aFeed.is_liked} style="display:none;"{/if}>{phrase var='feed.like'}</a>
			<a href="{url link='feed.view' id=$aFeed.feed_id liketype=2}"{if isset($aFeed.is_liked) && $aFeed.is_liked}{else} style="display:none;"{/if}>{phrase var='feed.unlike'}</a>		
		</span>
		{/if}
		
		{if isset($aFeed.like_rows) && is_array($aFeed.like_rows) && count($aFeed.like_rows)}
			<div class="feed_like_holder">
			{template file='feed.block.like'}
			</div>
		{/if}
	</div>	
	
	</div>
	<div class="clear"></div>
	
</div>	