<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: timeline.html.php 5458 2013-02-28 14:54:14Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="timeline_holder js_parent_feed_entry" id="js_item_feed_{$aFeed.feed_id}">
	
		{if !Phpfox::isMobile() && ((defined('PHPFOX_FEED_CAN_DELETE')) || (Phpfox::getUserParam('feed.can_delete_own_feed') && $aFeed.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('feed.can_delete_other_feeds'))}
			<div class="feed_delete_link"><a href="#" class="action_delete js_hover_title" onclick="$.ajaxCall('feed.delete', 'id={$aFeed.feed_id}{if isset($aFeedCallback.module)}&amp;module={$aFeedCallback.module}&amp;item={$aFeedCallback.item_id}{/if}', 'GET'); return false;"><span class="js_hover_info">{phrase var='feed.delete_this_feed'}</span></a></div>
		{/if}	
	
	<div>
		<div style="float:left;">
			{if !isset($aFeed.feed_mini)}		
				{if isset($aFeed.is_custom_app) && $aFeed.is_custom_app && ((isset($aFeed.view_id) && $aFeed.view_id == 7) || (isset($aFeed.gender) && $aFeed.gender < 1))}
				{img server_id=0 path='app.url_image' file=$aFeed.app_image_path suffix='_square' max_width=32 max_height=32}
				{else}
				{if isset($aFeed.user_name) && !empty($aFeed.user_name)}
					{img user=$aFeed suffix='_50_square' max_width=32 max_height=32}
				{else}
					{if !empty($aFeed.parent_user_name)}
					{img user=$aFeed suffix='_50_square' max_width=32 max_height=32 href=$aFeed.parent_user_name}
					{else}
					{img user=$aFeed suffix='_50_square' max_width=32 max_height=32 href=''}
					{/if}
				{/if}
				{/if}
			{/if}	
		</div>
		<div style="margin-left:36px; overflow:hidden; width:85%;" class="timeline_name_and_date_wrapper">
			{$aFeed|user:'':'':'user.maximum_length_for_full_name'}{if $aFeed.parent_feed_id > 0} {phrase var='feed.shared'}{else}{if isset($aFeed.parent_user)} {img theme='layout/arrow.png' class='v_middle'} {$aFeed.parent_user|user:'parent_':'':'user.maximum_length_for_full_name'} {/if}{if !empty($aFeed.feed_info)} {$aFeed.feed_info}{/if}{/if}
			<div class="extra_info timeline_date_1">
				{$aFeed.time_stamp|convert_time:'feed.feed_display_time_stamp'}
				{if $aFeed.privacy > 0 && ($aFeed.user_id == Phpfox::getUserId() || Phpfox::getUserParam('core.can_view_private_items'))}
				<div class="js_hover_title">{img theme='layout/privacy_icon.png' alt=$aFeed.privacy}<span class="js_hover_info">{if Phpfox::isModule('privacy')}{$aFeed.privacy|privacy_phrase}{else}Privacy {$aFeed.privacy} {/if}</span></div>
				{/if}
			</div>
		</div>
		
		<div class="clear"></div>
				
	{template file='feed.block.content'}
		
	</div>		
</div>
{if !PHPFOX_IS_AJAX && is_int($phpfox.iteration.iFeed/2)}
<div class="clear"></div>
{/if}