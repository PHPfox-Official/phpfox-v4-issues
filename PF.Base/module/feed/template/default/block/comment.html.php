{if (isset($showOnlyComments))}
{if (isset($aFeed.comments) && count($aFeed.comments))}
<a href="{url link='feed.comments'}?type={$aFeed.type_id}&id={$aFeed.item_id}&page={$nextIteration}{if defined('PHPFOX_FEED_STREAM_MODE')}&stream-mode=1{/if}" class="load_more_comments ajax"  onclick="$(this).addClass('active');"><i class="fa fa-spin fa-circle-o-notch"></i><span>View Previous Comments</span></a>
{foreach from=$aFeed.comments name=comments item=aComment}
{template file='comment.block.mini'}
{/foreach}
{/if}
{else}
{if isset($sDelayedParam)}
<script type="text/javascript">
	var bLoadDelayedComments = true;
	$Behavior.loadDelayedComments = function(){l}
        if (bLoadDelayedComments){l}
		    $.ajaxCall('feed.loadDelayedComments', 'feed={$sDelayedParam}', 'GET');
            bLoadDelayedComments = false;
    {r}
	{r}
</script>
<div id="js_load_delayed_comments">
	<div style="padding-top:10px;">
		{img theme='ajax/add.gif'}
	</div>
{else}
	{if isset($bIsViewingComments) && $bIsViewingComments}
		<div id="comment-view"><a name="#comment-view"></a></div>
		<div class="message js_feed_comment_border">
			{phrase var='comment.viewing_a_single_comment'}
			<a href="{$aFeed.feed_link}">{phrase var='comment.view_all_comments'}</a>
		</div>
		<script>
			{literal}
			$Ready(function() {
				var c = $('#comment-view');
				if (c.length && !c.hasClass('completed') && c.is(':visible')) {
					c.addClass('completed');
					$("html, body").animate({ scrollTop: (c.offset().top - 80) });
				}
			});
			{/literal}
		</script>
	{/if}

	{if isset($sFeedType)}
		<div class="js_parent_feed_entry parent_item_feed">
	{/if}

<div class="js_feed_comment_border">
    {plugin call='feed.template_block_comment_border'}


<div id="js_feed_like_holder_{$aFeed.type_id}_{$aFeed.item_id}" class="comment_mini_content_holder">
        <div class="comment_mini_content_holder_icon"{if isset($aFeed.marks) || (isset($aFeed.likes) && is_array($aFeed.likes)) || (isset($aFeed.total_comment) && $aFeed.total_comment > 0)}{else}{/if}></div>
			<div class="comment_mini_content_border">

				{if isset($aFeed.like_type_id)}
				<div class="feed_like_link">
					<ul>
						{if isset($aFeed.like_item_id)}
						{module name='like.link' like_type_id=$aFeed.like_type_id like_item_id=$aFeed.like_item_id like_is_liked=$aFeed.feed_is_liked}
						{else}
						{module name='like.link' like_type_id=$aFeed.like_type_id like_item_id=$aFeed.item_id like_is_liked=$aFeed.feed_is_liked}
						{/if}
					</ul>
				</div>
				{/if}

				<div class="js_comment_like_holder" id="js_feed_like_holder_{$aFeed.feed_id}">
				    <div id="js_like_body_{$aFeed.feed_id}">
					    {template file='like.block.display'}
				    </div>
			    </div>

				{if !isset($aFeed.feed_mini)}
				<a href="#" class="feed_options"></a>
				<div class="comment_mini_link_like">
					{template file='feed.block.link'}
				</div>
				{/if}

		{if  Phpfox::isModule('comment') && Phpfox::getParam('feed.allow_comments_on_feeds')}
		    <div id="js_feed_comment_post_{$aFeed.feed_id}" class="js_feed_comment_view_more_holder">

		{if isset($sFeedType) &&  $sFeedType == 'view'}

		{else}
			{*
		    {if isset($aFeed.comment_type_id) && isset($aFeed.total_comment) && (isset($sFeedType) &&  $sFeedType == 'mini' ? $aFeed.total_comment > 0 : $aFeed.total_comment > Phpfox::getParam('comment.total_comments_in_activity_feed'))}
			    <div class="comment_mini comment_mini_link_holder" id="js_feed_comment_view_more_link_{$aFeed.feed_id}">
				    <div class="comment_mini_link_image">
					    {img theme='misc/comment.png' class='v_middle'}
				    </div>
				    <div class="comment_mini_link_loader" id="js_feed_comment_ajax_link_{$aFeed.feed_id}" style="display:none;">{img theme='ajax/add.gif' class='v_middle'}</div>
				    <div class="comment_mini_link">
					    <a href="#" class="comment_mini_link_block comment_mini_link_block_hidden" style="display:none;" onclick="return false;">{phrase var='feed.loading'}</a>
					    <a href="{if isset($aFeed.feed_link_comment)}{$aFeed.feed_link_comment}{else}{$aFeed.feed_link}{/if}comment/"{if isset($sFeedType) &&  $sFeedType == 'mini'}{else}{if Phpfox::getParam('comment.total_amount_of_comments_to_load') > $aFeed.total_comment}onclick="$('#js_feed_comment_ajax_link_{$aFeed.feed_id}').show(); $(this).parent().find('.comment_mini_link_block_hidden').show(); $(this).hide(); $.ajaxCall('comment.viewMoreFeed', 'comment_type_id={$aFeed.comment_type_id}&amp;item_id={$aFeed.item_id}&amp;feed_id={$aFeed.feed_id}', 'GET'); return false;"{/if}{/if} class="comment_mini_link_block no_ajax_link">{phrase var='comment.view_all_total_left_comments' total_left=$aFeed.total_comment}</a>
				    </div>
			    </div>
		    {/if}
		    {if isset($aFeed.total_comment) && !isset($aFeed.comment_type_id) && $aFeed.total_comment > 0}
			    <div class="comment_mini comment_mini_link_holder" id="js_feed_comment_view_more_link_{$aFeed.feed_id}">
				    <div class="comment_mini_link_image">
					    {img theme='misc/comment.png' class='v_middle'}
				    </div>
				    <div class="comment_mini_link">
					    <a href="{if isset($aFeed.feed_link_comment)}{$aFeed.feed_link_comment}{else}{$aFeed.feed_link}{/if}comment/" class="comment_mini_link_block">{phrase var='comment.view_all_total_left_comments' total_left=$aFeed.total_comment}</a>
				    </div>
			    </div>
		    {/if}
			*}
		{/if}
		{if isset($aFeed.comments) && count($aFeed.comments)}
		<div>
			<div class="comment_pager_holder" id="js_feed_comment_pager_{$aFeed.type_id}{$aFeed.item_id}">
				{if $aFeed.total_comment > Phpfox::getParam('comment.comment_page_limit')}
				<a href="{url link='feed.comments'}?type={$aFeed.type_id}&id={$aFeed.item_id}&page=2{if defined('PHPFOX_FEED_STREAM_MODE')}&stream-mode=1{/if}" class="load_more_comments ajax"  onclick="$(this).addClass('active');"><i class="fa fa-spin fa-circle-o-notch"></i><span>View Previous Comments</span></a>
				{/if}
			</div>
			<div id="js_feed_comment_view_more_{$aFeed.feed_id}"{if defined('PHPFOX_FEED_STREAM_MODE')} class="comment-limit" data-limit="{if ($thisLimit = Phpfox::getParam('comment.total_comments_in_activity_feed'))}{$thisLimit}{/if}"{/if}>
			{foreach from=$aFeed.comments name=comments item=aComment}
				{template file='comment.block.mini'}
			{/foreach}
			</div><!-- // #js_feed_comment_view_more_{$aFeed.feed_id} -->
		</div>
		{else}
			<div id="js_feed_comment_view_more_{$aFeed.feed_id}"></div><!-- // #js_feed_comment_view_more_{$aFeed.feed_id} -->
		{/if}
		</div><!-- // #js_feed_comment_post_{$aFeed.feed_id} -->		
		{/if}		
		
		{if isset($sFeedType) &&  $sFeedType == 'mini'}
		
		{else}
		{if Phpfox::isModule('comment') 
			&& isset($aFeed.comment_type_id) 
			&& Phpfox::getParam('feed.allow_comments_on_feeds') 
			&& Phpfox::isUser() 
			&& $aFeed.can_post_comment
			&& Phpfox::getUserParam('feed.can_post_comment_on_feed')
		}
		<div class="js_feed_comment_form" {if isset($sFeedType) &&  $sFeedType == 'view'} id="js_feed_comment_form_{$aFeed.feed_id}"{/if}>
			<div class="js_comment_feed_textarea_browse"></div>
			<div class="{if isset($sFeedType) &&  $sFeedType == 'view'} feed_item_view{/if} comment_mini comment_mini_end">
				<form method="post" action="#" class="js_comment_feed_form">				
					<div><input type="hidden" name="val[type]" value="{$aFeed.comment_type_id}" /></div>			
					<div><input type="hidden" name="val[item_id]" value="{$aFeed.item_id}" /></div>
					<div><input type="hidden" name="val[parent_id]" value="0" class="js_feed_comment_parent_id" /></div>
					<div><input type="hidden" name="val[is_via_feed]" value="{$aFeed.feed_id}" /></div>
					{if defined('PHPFOX_IS_THEATER_MODE')}
					<div><input type="hidden" name="ajax_post_photo_theater" value="1" /></div>	
					{/if}
					{if Phpfox::isUser()}
					<div class="comment_mini_image"{if isset($sFeedType) &&  $sFeedType == 'view'} {else}style="display:none;"{/if}>
					{img user=$aGlobalUser suffix='_50_square' max_width='32' max_height='32'}
					</div>				
					{/if}	
					<div class="{if isset($sFeedType) &&  $sFeedType == 'view'}comment_mini_content {/if}comment_mini_textarea_holder">
						<div><input type="hidden" name="val[default_feed_value]" value="{phrase var='feed.write_a_comment'}" /></div>						
						<div class="js_comment_feed_value">{phrase var='feed.write_a_comment'}</div>
						<textarea cols="60" rows="4" name="val[text]" class="js_comment_feed_textarea" id="js_feed_comment_form_textarea_{$aFeed.feed_id}" placeholder="{phrase var='feed.write_a_comment'}"></textarea>
						<div class="js_feed_comment_process_form"><i class="fa fa-spin fa-circle-o-notch"></i></div>
					</div>
					{if !PHPFOX_IS_AJAX && !Phpfox::isMobile() && isset($sFeedType) &&  $sFeedType == 'view' && Phpfox::getUserParam('comment.wysiwyg_on_comments') && Phpfox::getParam('core.wysiwyg') == 'tiny_mce'}
					<div><input type="hidden" name="val[is_in_view]" value="1" /></div>
					<script type="text/javascript">
						 $Behavior.commentPreLoadTinymce = function(){l}
							customTinyMCE_init('js_feed_comment_form_textarea_{$aFeed.feed_id}');
							$Behavior.commentPreLoadTinymce = function(){l}{r}
							$Core.loadCommentButton();
						 {r}			
					</script>
					{/if}					
				</form>
			</div>
		</div>
		{/if}		
		{/if}
		
	</div><!-- // .comment_mini_content_border -->
</div><!-- // .comment_mini_content_holder -->



</div>
{if Phpfox::isModule('report') && isset($aFeed.report_module) && (isset($sFeedType) && $sFeedType != 'mini')}
<div class="report_this_item">
	<a href="{url link=''}#?call=report.add&amp;height=100&amp;width=400&amp;type={$aFeed.report_module}&amp;id={$aFeed.item_id}" class="item_bar_flag inlinePopup" title="{$aFeed.report_phrase}">{$aFeed.report_phrase}</a>
</div>
{if Phpfox::isModule('captcha') && Phpfox::getUserParam('captcha.captcha_on_comment')}
{module name='captcha.form' sType='comment' captcha_popup=true}
{/if}
{/if}
{if isset($sFeedType)}
</div>
{/if}
{/if}
{if isset($sDelayedParam)}
</div>
{/if}
{/if}