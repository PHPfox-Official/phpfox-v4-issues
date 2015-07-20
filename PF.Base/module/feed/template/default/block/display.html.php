<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: display.html.php 7235 2014-03-27 18:22:43Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !$bIsHashTagPop && !PHPFOX_IS_AJAX && !empty($sIsHashTagSearch)}
	<h1 id="sHashTagValue">#{$sIsHashTagSearchValue|clean}</h1>
{/if}
{plugin call='feed.component_block_display_process_header'}

{if isset($bForceFormOnly) && $bForceFormOnly}
	{template file='feed.block.form'}
{else}

	{if Phpfox::isUser() && !PHPFOX_IS_AJAX && $sCustomViewType === null && $bUseFeedForm}
		<div id="js_main_feed_holder">
			{template file='feed.block.form'}
		</div>

		{if Phpfox::isUser() && !defined('PHPFOX_IS_USER_PROFILE') && !PHPFOX_IS_AJAX && !defined('PHPFOX_IS_PAGES_VIEW')}
		<div class="feed_sort_order">
			<a href="#" class="feed_sort_order_link">{phrase var='feed.sort'}</a>
			<div class="feed_sort_holder">
				<ul>
					<li><a href="#"{if !$iFeedUserSortOrder} class="active"{/if} rel="0">{phrase var='feed.top_stories'}</a></li>
					<li><a href="#"{if $iFeedUserSortOrder} class="active"{/if} rel="1">{phrase var='feed.most_recent'}</a></li>
				</ul>
			</div>
		</div>
		{/if}

		{if Phpfox::isModule('captcha') && Phpfox::getUserParam('captcha.captcha_on_comment')}
		{module name='captcha.form' sType='comment' captcha_popup=true}
		{/if}

	{/if}
	<div id="feed"><a name="feed"></a></div>

<div id="js_feed_content" class="js_feed_content">
	{if $sCustomViewType !== null}
		<h2>{$sCustomViewType}</h2>
	{/if}
	<div id="js_new_feed_update"></div>
	<div id="js_new_feed_comment"></div>


	{if isset($bStreamMode) && $bStreamMode}
	{foreach from=$aFeeds item=aFeed}
		<div class="feed_stream" data-feed-url="{if (isset($aFeedCallback.module))}{url link='feed.stream' id=$aFeed.feed_id module=$aFeedCallback.module item_id=$aFeedCallback.item_id}{else}{url link='feed.stream' id=$aFeed.feed_id}{/if}"></div>
	{/foreach}

	{else}
	
		{if isset($bNoLoadFeedContent)}
		{else}
			{foreach from=$aFeeds name=iFeed item=aFeed}
				{if isset($aFeed.feed_mini) && !isset($bHasRecentShow)}
					{if $bHasRecentShow = true}{/if}
					<div class="activity_recent_holder">
						<div class="activity_recent_title">
							{phrase var='feed.recent_activity'}
						</div>
				{/if}
				{if !isset($aFeed.feed_mini) && isset($bHasRecentShow)}
					</div>
					{unset var=$bHasRecentShow}
				{/if}
		
				<div class="js_feed_view_more_entry_holder">
					{template file='feed.block.entry'}
					{if isset($aFeed.more_feed_rows) && is_array($aFeed.more_feed_rows) && count($aFeed.more_feed_rows)}
						{foreach from=$aFeed.more_feed_rows item=aFeed}
							{if $bChildFeed = true}{/if}
							<div class="js_feed_view_more_entry" style="display:none;">
								{template file='feed.block.entry'}
							</div>
						{/foreach}
						{unset var=$bChildFeed}
					{/if}
				</div>
			{/foreach}
		{/if}

	{/if}
	
	{if isset($bHasRecentShow)}
		</div>
	{/if}	
	{if $sCustomViewType === null}
		{if defined('PHPFOX_IN_DESIGN_MODE')}		
		{else}
			{if count($aFeeds) || (isset($bForceReloadOnPage) && $bForceReloadOnPage)}
				<div id="feed_view_more">
					{if $bIsHashTagPop}
					{if count($aFeeds) > 8}
					<a href="{url link='hashtag'}{{$sIsHashTagSearch}/page_1/" class="global_view_more no_ajax_link" style="display:block;">{phrase var='feed.view_more'}</a>
					{/if}
					{else}
					<div id="js_feed_pass_info" style="display:none;">page={$iFeedNextPage}{if defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id)}&profile_user_id={$aUser.user_id}{/if}{if isset($aFeedCallback.module)}&callback_module_id={$aFeedCallback.module}&callback_item_id={$aFeedCallback.item_id}{/if}&year={$sTimelineYear}&month={$sTimelineMonth}{if !empty($sIsHashTagSearch)}&hashtagsearch={$sIsHashTagSearch}{/if}</div>
					<div id="feed_view_more_loader">{img theme='ajax/add.gif'}</div>
					<a {if !PHPFOX_IS_AJAX && isset($bForceReloadOnPage) && $bForceReloadOnPage} style="text-indent:-1000px; overflow:hidden; background:transparent; border:0px;"{/if} href="{if Phpfox_Module::instance()->getFullControllerName() == 'core.index-visitor'}{url link='core.index-visitor' page=$iFeedNextPage}{else}{url link='current' page=$iFeedNextPage}{/if}" onclick="$(this).hide(); $('#feed_view_more_loader').show(); $.ajaxCall('feed.viewMore', 'page={$iFeedNextPage}{if defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id)}&profile_user_id={$aUser.user_id}{/if}{if isset($aFeedCallback.module)}&callback_module_id={$aFeedCallback.module}&callback_item_id={$aFeedCallback.item_id}{/if}&year={$sTimelineYear}&month={$sTimelineMonth}', 'GET'); return false;" class="global_view_more no_ajax_link">{phrase var='feed.view_more'}</a>
					{/if}
				</div>				
			{else}
				{if defined('PHPFOX_IS_USER_PROFILE') && Profile_Service_Profile::instance()->timeline()}
					{module name='user.birth'}
				{else}
					<br />
					<div class="message js_no_feed_to_show">{phrase var='feed.there_are_no_new_feeds_to_view_at_this_time'}</div>
				{/if}
			{/if}
		{/if}
	{/if}
	{if !PHPFOX_IS_AJAX || (PHPFOX_IS_AJAX && count($aFeedVals))}
		</div>
	{/if}

	{if Phpfox::getParam('feed.refresh_activity_feed') > 0 && Phpfox_Module::instance()->getFullControllerName() == 'core.index-member'}
		<script type="text/javascript">
			$Behavior.reloadActivity = function() {l} $Core.reloadActivityFeed();	{r};
		</script>
	{/if}
{/if}