<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: mini.html.php 6630 2013-09-12 09:24:48Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div id="js_comment_{$aComment.comment_id}" class="js_mini_feed_comment comment_mini js_mini_comment_item_{$aComment.item_id}">
		{if (Phpfox::getUserParam('comment.delete_own_comment') && Phpfox::getUserId() == $aComment.user_id) || Phpfox::getUserParam('comment.delete_user_comment') || (defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id) && $aUser.user_id == Phpfox::getUserId() && Phpfox::getUserParam('comment.can_delete_comments_posted_on_own_profile'))
		|| (defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getService('pages')->isAdmin('' . $aPage.page_id . ''))
		}
			<div class="feed_comment_delete_link">
				<a href="#" class="action_delete js_hover_title" onclick="$.ajaxCall('comment.InlineDelete', 'type_id={$aComment.type_id}&amp;comment_id={$aComment.comment_id}{if defined('PHPFOX_IS_THEATER_MODE')}&photo_theater=1{/if}', 'GET'); return false;">
					<span class="js_hover_info">
						{phrase var='comment.delete'}
					</span>
				</a>
			</div>
		{elseif Phpfox::getUserParam('comment.can_delete_comment_on_own_item')&& isset($aFeed) && isset($aFeed.feed_link) && $aFeed.user_id == Phpfox::getUserId()}
			<div class="feed_comment_delete_link">
				<a href="{$aFeed.feed_link}ownerdeletecmt_{$aComment.comment_id}/" class="action_delete js_hover_title sJsConfirm">
					<span class="js_hover_info">
						{if defined('PHPFOX_IS_THEATER_MODE')}
							{phrase var='comment.delete'}
						{else}
							{phrase var='comment.delete_this_comment'}
						{/if}
					</span>
				</a>
			</div>
		{/if}
		<div class="comment_mini_image">
			{if Phpfox::isMobile()}
				{img user=$aComment suffix='_50_square' max_width=32 max_height=32}
			{else}
				{img user=$aComment suffix='_50_square' max_width=32 max_height=32}
			{/if}
		</div>
		<div class="comment_mini_content">
			{$aComment|user:'':'':30}<div id="js_comment_text_{$aComment.comment_id}" class="comment_mini_text {if $aComment.view_id == '1'}row_moderate{/if}">{$aComment.text|feed_strip|shorten:'300':'comment.view_more':true|split:30|max_line}</div>			
			<div class="comment_mini_action">
				<ul>
					<li class="comment_mini_entry_time_stamp">{if isset($aComment.unix_time_stamp)}{$aComment.unix_time_stamp|convert_time:'comment.comment_time_stamp'}{else}{$aComment.time_stamp|convert_time:'comment.comment_time_stamp'}{/if}</li>
					<li><span>&middot;</span></li>
					{if !Phpfox::isMobile()}
						{if (Phpfox::getUserParam('comment.edit_own_comment') && Phpfox::getUserId() == $aComment.user_id) || Phpfox::getUserParam('comment.edit_user_comment')}
							<li>
								<a href="inline#?type=text&amp;&amp;simple=true&amp;id=js_comment_text_{$aComment.comment_id}&amp;call=comment.updateText&amp;comment_id={$aComment.comment_id}&amp;data=comment.getText" class="quickEdit">{phrase var='comment.edit'}</a>
							</li>
							<li><span>&middot;</span></li>
						{/if}
					{/if}				
					
					{if Phpfox::getParam('comment.comment_is_threaded') && Phpfox::getUserParam('feed.can_post_comment_on_feed')}
						{if (isset($aComment.iteration) && $aComment.iteration >= Phpfox::getParam('comment.total_child_comments')) || isset($bForceNoReply)}
						
						{else}
							<li><a href="#" class="js_comment_feed_new_reply" rel="{$aComment.comment_id}">{phrase var='comment.reply'}</a></li>
							<li><span>&middot;</span></li>
						{/if}
					{/if}
					
					{if Phpfox::isModule('report') && Phpfox::getUserParam('report.can_report_comments')}
						{if $aComment.user_id != Phpfox::getUserId()}
							<li><a href="#?call=report.add&amp;height=210&amp;width=400&amp;type=comment&amp;id={$aComment.comment_id}" class="inlinePopup" title="{phrase var='report.report_a_comment'}">{phrase var='report.report'}</a></li>
							<li><span>&middot;</span></li>
						{/if}
					{/if}						
					
					{module name='like.link' like_type_id='feed_mini' like_item_id=$aComment.comment_id like_is_liked=$aComment.is_liked like_is_custom=true}
					<li class="js_like_link_holder"{if $aComment.total_like == 0} style="display:none;"{/if}><span>&middot;</span></li>
					<li class="js_like_link_holder"{if $aComment.total_like == 0} style="display:none;"{/if}>
						<a href="#" onclick="return $Core.box('like.browse', 400, 'type_id=feed_mini&amp;item_id={$aComment.comment_id}');">
							<span class="js_like_link_holder_info">
								{if $aComment.total_like == 1}
									{phrase var='comment.1_person'}
								{else}
									{phrase var='comment.total_people' total=$aComment.total_like|number_format}
								{/if}
							</span>
						</a>
					</li>
					{if Phpfox::isModule('like')}
						{if Phpfox::getParam('like.allow_dislike')}
						<li class="js_dislike_link_holder"{if $aComment.total_dislike == 0} style="display:none;"{/if}><span>&middot;</span></li>
						<li class="js_dislike_link_holder"{if $aComment.total_dislike == 0} style="display:none;"{/if}>
							<a href="#" id="js_dislike_mini_a_{$aComment.comment_id}" onclick="return  $Core.box('like.browse', 400, 'type_id=feed_mini&amp;item_id={$aComment.comment_id}&amp;dislike=1');">
								{if $aComment.total_dislike == 1}
									{phrase var='comment.1_person'}
								{else}
									{phrase var='comment.total_people' total=$aComment.total_dislike|number_format}
								{/if}
							</a>
						</li>
						{/if}
					{/if}
					{if Phpfox::getUserParam('comment.can_moderate_comments') && $aComment.view_id == '1'}
						<li>
							<a href="#" onclick="$('#js_comment_text_{$aComment.comment_id}').removeClass('row_moderate'); $(this).remove(); $.ajaxCall('comment.moderateSpam', 'id={$aComment.comment_id}&amp;action=approve&amp;inacp=0'); return false;">{phrase var='comment.approve'}</a>					
						</li>
					{/if}				
				</ul>
				<div class="clear"></div>
			</div>
		</div>		
		<div id="js_comment_form_holder_{$aComment.comment_id}" class="js_comment_form_holder"></div>

		<div class="comment_mini_child_holder{if isset($aComment.children) && $aComment.children.total > 0} comment_mini_child_holder_padding{/if}">
			{if isset($aComment.children) && $aComment.children.total > 0}
				<div class="comment_mini_child_view_holder" id="comment_mini_child_view_holder_{$aComment.comment_id}">
					<a href="#" onclick="$.ajaxCall('comment.viewAllComments', 'comment_type_id={$aComment.type_id}&amp;item_id={$aComment.item_id}&amp;comment_id={$aComment.comment_id}', 'GET'); return false;">{phrase var='comment.view_total_more' total=$aComment.children.total|number_format}</a>
				</div>
			{/if}
			<div id="js_comment_children_holder_{$aComment.comment_id}" class="comment_mini_child_content">				
				{if isset($aComment.children) && count($aComment.children.comments)}
					{foreach from=$aComment.children.comments item=aCommentChilded}
						{module name='comment.mini' comment_custom=$aCommentChilded}
						<div id="js_feed_like_holder_{$aCommentChilded.comment_id}"> 
							{module name='like.displayactions' aChildFeed=$aCommentChilded}
						</div>
					{/foreach}
				{else}
					<div id="js_feed_like_holder_{$aComment.comment_id}"> </div>
				{/if}			
				
			</div>
		</div>		
		
	</div>
