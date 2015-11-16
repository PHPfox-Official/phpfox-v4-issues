{assign var=empty value=true}
{if PHPFOX_IS_AJAX && Phpfox_Request::instance()->get('theater') == 'true'}

{elseif isset($sFeedType) &&  $sFeedType == 'view___'}
<div class="feed_share_custom">	
	{if Phpfox::isModule('share') && Phpfox::getParam('share.share_twitter_link')}
	{assign var=empty value=false}
		<div class="feed_share_custom_block"><a href="http://twitter.com/share" class="twitter-share-button" data-url="{$aFeed.feed_link}" data-count="horizontal" data-via="{param var='feed.twitter_share_via'}">{phrase var='feed.tweet'}</a><script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script></div>
	{/if}
	{if Phpfox::isModule('share') && Phpfox::getParam('share.share_google_plus_one')}
	{assign var=empty value=false}
	<div class="feed_share_custom_block">
		<g:plusone href="{$aFeed.feed_link}" size="medium"></g:plusone>
		{literal}
			<script type="text/javascript">
			  (function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		{/literal}
	</div>
	{/if}
	{if Phpfox::isModule('share') && Phpfox::getParam('share.share_facebook_like')}
		{assign var=empty value=false}
		<div class="feed_share_custom_block">
			<iframe src="http{if Phpfox::getParam('core.force_https_secure_pages') && Phpfox::getParam('core.force_secure_site')}s{/if}://www.facebook.com/plugins/like.php?app_id={if Phpfox::getParam('facebook.facebook_app_id') != ''}{param var='facebook.facebook_app_id'}{else}156226084453194{/if}&amp;href={if !empty($aFeed.feed_link)}{$aFeed.feed_link}{else}{url link='current'}{/if}&amp;send=false&amp;layout=button_count&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;width=90&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:140px; height:21px;" allowTransparency="true"></iframe>					
		</div>
	{/if}				
	<div class="clear"></div>
</div>
{/if}

<ul>
	{if !Profile_Service_Profile::instance()->timeline()}
		{if !isset($aFeed.feed_mini)}		
			{if $aFeed.privacy > 0}
			{assign var=empty value=false}
			<li class="privacy_icon_holder"><div class="js_hover_title">{img theme='layout/privacy_icon.png' alt=$aFeed.privacy}<span class="js_hover_info">{if Phpfox::isModule('privacy')}{$aFeed.privacy|privacy_phrase}{else}Privacy {$aFeed.privacy}{/if}</span></div></li>
			{/if}
		{/if}
	{/if}

	{*
	{if Phpfox::isUser() && Phpfox::isModule('like') && isset($aFeed.like_type_id)}
		{if isset($aFeed.like_item_id)}
			{module name='like.link' like_type_id=$aFeed.like_type_id like_item_id=$aFeed.like_item_id like_is_liked=$aFeed.feed_is_liked}
		{else}
			{module name='like.link' like_type_id=$aFeed.like_type_id like_item_id=$aFeed.item_id like_is_liked=$aFeed.feed_is_liked}
		{/if}
	{/if}
	*}

	{*
	{if Phpfox::isUser() 
		&& Phpfox::isModule('comment') 
		&& Phpfox::getUserParam('feed.can_post_comment_on_feed')
		&& Phpfox::getUserParam('comment.can_post_comments')
		&& (isset($aFeed.comment_type_id) && $aFeed.can_post_comment) 
		|| (!isset($aFeed.comment_type_id) && isset($aFeed.total_comment))
		}				
	<li>
		<a href="{$aFeed.feed_link}add-comment/" class="{if (isset($sFeedType) && $sFeedType == 'mini') || (!isset($aFeed.comment_type_id) && isset($aFeed.total_comment))}{else}js_feed_entry_add_comment no_ajax_link{/if}">{phrase var='feed.comment'}</a>
	</li>
	{/if}
	*}

	{if Phpfox::isModule('share') && !isset($aFeed.no_share)}
		{assign var=empty value=false}
		{if $aFeed.privacy == '0' || $aFeed.privacy == '1' || $aFeed.privacy == '2'}
			{module name='share.link' type='feed' display='menu' url=$aFeed.feed_link title=$aFeed.feed_title sharefeedid=$aFeed.item_id sharemodule=$aFeed.type_id}
		{else}
			{module name='share.link' type='feed' display='menu' url=$aFeed.feed_link title=$aFeed.feed_title}
		{/if}
	{/if}
	{if Phpfox::isModule('report') && isset($aFeed.report_module) && isset($aFeed.force_report)}
		{assign var=empty value=false}
		<li><a href="#?call=report.add&amp;height=100&amp;width=400&amp;type={$aFeed.report_module}&amp;id={$aFeed.item_id}" class="inlinePopup activity_feed_report" title="{$aFeed.report_phrase}">{phrase var='feed.report'}</a></li>				
	{/if}

	{plugin call='feed.template_block_entry_2'}				
	{if Phpfox::isMobile() && ((defined('PHPFOX_FEED_CAN_DELETE')) || (Phpfox::getUserParam('feed.can_delete_own_feed') && $aFeed.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('feed.can_delete_other_feeds'))}
	{assign var=empty value=false}
	<li><a href="#" onclick="if (confirm(getPhrase('core.are_you_sure'))){l}$.ajaxCall('feed.delete', 'id={$aFeed.feed_id}{if isset($aFeedCallback.module)}&amp;module={$aFeedCallback.module}&amp;item={$aFeedCallback.item_id}{/if}', 'GET');{r} return false;">{phrase var='feed.delete'}</a></li>
	{/if}

	{plugin call='core.template_block_comment_border_new'}

</ul>
{if $empty}
<input type="hidden" class="comment_mini_link_like_empty" value="1" />
{/if}
<div class="clear"></div>		
