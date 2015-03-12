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
{if isset($sActivityFeedHeader)}
	{if !PHPFOX_IS_AJAX}
		<div class="mb_feed_header">
			{$sActivityFeedHeader}
		</div>
	{/if}
{/if}
{if isset($bForceFormOnly) && $bForceFormOnly}
	{template file='feed.block.form'}
{else}
	{if Phpfox::getService('profile')->timeline()}
		<div class="main_timeline {if isset($aUser.page_user_id)}content4 content_float{/if}" style="background:url('{img theme='layout/timeline.png' return_url=true}') repeat-y 50%;">
	{/if}

	{if Phpfox::isUser() && !PHPFOX_IS_AJAX && $sCustomViewType === null}
		{if (Phpfox::getUserBy('profile_page_id') > 0 && defined('PHPFOX_IS_USER_PROFILE')) 
			|| (isset($aFeedCallback.disable_share) && $aFeedCallback.disable_share) 
			|| (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'feed.share_on_wall'))
			|| (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getUserParam('profile.can_post_comment_on_profile') && $aUser.user_id != Phpfox::getUserId())
		}

		{else}
			{if !Phpfox::getService('profile')->timeline()}
				<div id="js_main_feed_holder">
					{template file='feed.block.form'}
				</div>
			{/if}
		{/if}
	{/if}

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
	{if Phpfox::getParam('feed.refresh_activity_feed') > 0 && Phpfox::getLib('module')->getFullControllerName() == 'core.index-member'}
		<div id="activity_feed_updates_link_holder">
			<a href="#" id="activity_feed_updates_link_single" class="activity_feed_updates_link" onclick="return $Core.loadMoreFeeds();">{phrase var='feed.1_new_update'}</a>
			<a href="#" id="activity_feed_updates_link_plural" class="activity_feed_updates_link" onclick="return $Core.loadMoreFeeds();">{phrase var='feed.span_id_js_new_update_view_span_new_updates'}</a>
		</div>
	{/if}
	{if Phpfox::isModule('captcha') && Phpfox::getUserParam('captcha.captcha_on_comment')}
		{module name='captcha.form' sType='comment' captcha_popup=true}
	{/if}
<div id="feed"><a name="feed"></a></div>
<div {if !$bIsHashTagPop}id="js_feed_content"{/if} class="js_feed_content">
	{if $sCustomViewType !== null}
		<h2>{$sCustomViewType}</h2>
	{/if}
	<div id="js_new_feed_update"></div>
	<div id="js_new_feed_comment"></div>
	
	{if Phpfox::getService('profile')->timeline()}
		{if isset($bNoLoadFeedContent)}
		{else}
			<div>
				{if PHPFOX_IS_AJAX && !empty($sLastDayInfo) && !Phpfox::getLib('request')->get('resettimeline')}
					<div class="timeline_date">
						<span>{$sLastDayInfo}</span>
					</div>
				{/if}
				<div class="timeline_left">			
					{if (!PHPFOX_IS_AJAX && Phpfox::getService('profile')->timeline()) || Phpfox::getLib('request')->get('resettimeline')}
						{if (Phpfox::isUser() && !PHPFOX_IS_AJAX && $sCustomViewType === null) || Phpfox::getLib('request')->get('resettimeline')}
							{if (Phpfox::getUserBy('profile_page_id') > 0 && defined('PHPFOX_IS_USER_PROFILE')) 
								|| (isset($aFeedCallback.disable_share) && $aFeedCallback.disable_share) 
								|| (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'feed.share_on_wall'))
								|| (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getUserParam('profile.can_post_comment_on_profile') && $aUser.user_id != Phpfox::getUserId())
							}

							{else}	
								<div class="timeline_feed_row">
									<div class="timeline_arrow_left">0</div>
									<div class="timeline_float_left">0</div>			
									<div class="timeline_holder">
										{template file='feed.block.form'}
									</div>
								</div>
								<div class="timeline_left_new"></div>
							{/if}
						{/if}
					{/if}
					{foreach from=$aFeedTimeline.left name=iFeed item=aFeed}
						<div class="timeline_feed_row">
							<div class="timeline_arrow_left">{$aFeed.feed_id}</div>
							<div class="timeline_float_left">{$aFeed.time_stamp|convert_time}</div>
							{template file='feed.block.timeline'}
						</div>		
					{/foreach}
				</div>
				<div class="timeline_right">
					{if !PHPFOX_IS_AJAX || Phpfox::getLib('request')->get('resettimeline')}
						<div class="timeline_feed_row">				
							{module name='friend.timeline'}
						</div>
					{/if}
					{foreach from=$aFeedTimeline.right name=iFeed item=aFeed}
						<div class="timeline_feed_row">
							<div class="timeline_arrow_right">{$aFeed.feed_id}</div>
							<div class="timeline_float_right">{$aFeed.time_stamp|convert_time}</div>
							{template file='feed.block.timeline'}
						</div>
					{/foreach}
				</div>		
				<div class="clear"></div>
			</div>	
	
			{if !PHPFOX_IS_AJAX}
				{foreach from=$aTimelineDates item=aTimelineDate}
					<div id="js_timeline_year_holder_{$aTimelineDate.year}"></div>
					{foreach from=$aTimelineDate.months item=aMonth}
						<div id="js_timeline_month_holder_{$aTimelineDate.year}_{$aMonth.id}"></div>
					{/foreach}
				{/foreach}
			{/if}
		
		{/if}	
			
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
					<a {if !PHPFOX_IS_AJAX && isset($bForceReloadOnPage) && $bForceReloadOnPage} style="text-indent:-1000px; overflow:hidden; background:transparent; border:0px;"{/if} href="{if Phpfox::getLib('module')->getFullControllerName() == 'core.index-visitor'}{url link='core.index-visitor' page=$iFeedNextPage}{else}{url link='current' page=$iFeedNextPage}{/if}" onclick="$(this).hide(); $('#feed_view_more_loader').show(); $.ajaxCall('feed.viewMore', 'page={$iFeedNextPage}{if defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id)}&profile_user_id={$aUser.user_id}{/if}{if isset($aFeedCallback.module)}&callback_module_id={$aFeedCallback.module}&callback_item_id={$aFeedCallback.item_id}{/if}&year={$sTimelineYear}&month={$sTimelineMonth}', 'GET'); return false;" class="global_view_more no_ajax_link">{phrase var='feed.view_more'}</a>
					{/if}
				</div>				
			{else}
				{if defined('PHPFOX_IS_USER_PROFILE') && Phpfox::getService('profile')->timeline()}
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
	{if Phpfox::getParam('feed.refresh_activity_feed') > 0 && Phpfox::getLib('module')->getFullControllerName() == 'core.index-member'}
		<script type="text/javascript">
			$Behavior.reloadActivity = function() {l} $Core.reloadActivityFeed();	{r};
		</script>
	{/if} 

	{if Phpfox::getService('profile')->timeline()}
		</div>
		{if isset($aUser.page_user_id)}
			<div id="right">
				{module name='feed.time'}
				{module name='ad.display' block_id='3'}
				{foreach from=$aLoadBlocks item=sBlock}
					{module name=$sBlock}
				{/foreach}
			</div>
		{/if}
	{/if}
{/if}
