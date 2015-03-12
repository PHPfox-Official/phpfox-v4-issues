<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: display.html.php 4176 2012-05-16 10:49:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="activity_feed_form_share">
	<div class="activity_feed_form_share_process">{img theme='ajax/add.gif' class='v_middle'}</div>
	{if !isset($bSkipShare)}
		<ul class="activity_feed_form_attach">
			{if !Phpfox::isMobile()}
				<li class="share">{phrase var='feed.share'}:</li>
			{/if}
			{if isset($aFeedCallback.module)}
				<li><a href="#" style="background:url('{img theme='misc/comment_add.png' return_url=true}') no-repeat center left;" rel="global_attachment_status" class="active"><div>{phrase var='feed.post'}<span class="activity_feed_link_form_ajax">{$aFeedCallback.ajax_request}</span></div><div class="drop"></div></a></li>
			{elseif !isset($bFeedIsParentItem) && (!defined('PHPFOX_IS_USER_PROFILE') || (defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id) && $aUser.user_id == Phpfox::getUserId()))}
				<li><a href="#" style="background:url('{img theme='misc/application_add.png' return_url=true}') no-repeat center left;" rel="global_attachment_status" class="active"><div>{phrase var='feed.status'}<span class="activity_feed_link_form_ajax">user.updateStatus</span></div><div class="drop"></div></a></li>
			{else}
				<li><a href="#" style="background:url('{img theme='misc/comment_add.png' return_url=true}') no-repeat center left;" rel="global_attachment_status" class="active"><div>{phrase var='feed.post'}<span class="activity_feed_link_form_ajax">feed.addComment</span></div><div class="drop"></div></a></li>
			{/if}
			
			{foreach from=$aFeedStatusLinks item=aFeedStatusLink name=feedlinks}
			
			{if $phpfox.iteration.feedlinks == 3 && Phpfox::getService('profile')->timeline()}
			<li><a href="#" rel="view_more_link" class="timeline_view_more js_hover_title"><span class="js_hover_info">{phrase var='feed.view_more'}</span></a>
				<ul class="view_more_drop">
			{/if}
			
			
			
			{if isset($aFeedCallback.module) && $aFeedStatusLink.no_profile}
			{else}
				{if ($aFeedStatusLink.no_profile && !isset($bFeedIsParentItem) && (!defined('PHPFOX_IS_USER_PROFILE') || (defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id) && $aUser.user_id == Phpfox::getUserId()))) || !$aFeedStatusLink.no_profile}
					<li>
						<a href="#" style="background-image:url('{img theme='feed/'$aFeedStatusLink.icon'' return_url=true}'); background-repeat:no-repeat; background-position:{if Phpfox::getService('profile')->timeline() && $phpfox.iteration.feedlinks >= 3}5px center{else}center left{/if};" rel="global_attachment_{$aFeedStatusLink.module_id}"{if $aFeedStatusLink.no_input} class="no_text_input"{/if}>
							<div>
								{$aFeedStatusLink.title|convert}
								{if $aFeedStatusLink.is_frame}
									<span class="activity_feed_link_form">{if $aFeedStatusLink.module_id == 'video' && Phpfox::getParam('video.convert_servers_enable')}{$sVideoServerUrl}{else}{url link=''$aFeedStatusLink.module_id'.frame'}{/if}</span>
								{else}
									<span class="activity_feed_link_form_ajax">{$aFeedStatusLink.module_id}.{$aFeedStatusLink.ajax_request}</span>
								{/if}
								<span class="activity_feed_extra_info">{$aFeedStatusLink.description|convert}</span>
							</div>
							<div class="drop"></div>
						</a>
					</li>
				{/if}
			{/if}
			
			{if $phpfox.iteration.feedlinks == count($aFeedStatusLinks) && Phpfox::getService('profile')->timeline()}
				</ul>
			</li>			
			{/if}			
			
			{/foreach}		
		</ul>
	{/if}
	<div class="clear"></div>
</div>	

<div class="activity_feed_form">
	<form method="post" action="#" id="js_activity_feed_form" enctype="multipart/form-data">
		<div id="js_custom_privacy_input_holder"></div>
		{if Phpfox::getParam('video.convert_servers_enable') && isset($sCustomVideoHash)}
			<div><input type="hidden" name="_v_hash" value="{$sCustomVideoHash}" /></div>
		{/if}
		{if isset($aFeedCallback.module)}
			<div><input type="hidden" name="val[callback_item_id]" value="{$aFeedCallback.item_id}" /></div>
			<div><input type="hidden" name="val[callback_module]" value="{$aFeedCallback.module}" /></div>
			<div><input type="hidden" name="val[parent_user_id]" value="{$aFeedCallback.item_id}" /></div>
		{/if}
		{if isset($bFeedIsParentItem)}
			<div><input type="hidden" name="val[parent_table_change]" value="{$sFeedIsParentItemModule}" /></div>
		{/if}
		{if defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id) && $aUser.user_id != Phpfox::getUserId()}
			<div><input type="hidden" name="val[parent_user_id]" value="{$aUser.user_id}" /></div>
		{/if}
		{if isset($bForceFormOnly) && $bForceFormOnly}
			<div><input type="hidden" name="force_form" value="1" /></div>
		{/if}	
		<div class="activity_feed_form_holder">		
			
			<div id="activity_feed_upload_error" style="display:none;"><div class="error_message" id="activity_feed_upload_error_message"></div></div>
			
			<div class="global_attachment_holder_section" id="global_attachment_status" style="display:block;">
				<div id="global_attachment_status_value" style="display:none;">{if isset($aFeedCallback.module) || defined('PHPFOX_IS_USER_PROFILE')}{phrase var='feed.write_something'}{else}{phrase var='feed.what_s_on_your_mind'}{/if}</div>
				<textarea {if isset($aPage)} id="pageFeedTextarea" {else} {if isset($aEvent)} id="eventFeedTextarea" {else} {if isset($bOwnProfile) && $bOwnProfile == false}id="profileFeedTextarea" {/if}{/if}{/if} cols="60" rows="8" name="val[user_status]">{if isset($aFeedCallback.module) || defined('PHPFOX_IS_USER_PROFILE')}{phrase var='feed.write_something'}{else}{phrase var='feed.what_s_on_your_mind'}{/if}</textarea>
                {if isset($bLoadCheckIn) && $bLoadCheckIn == true}
                    <script type="text/javascript">
                        oTranslations['feed.at_location'] = "{phrase var='feed.at_location'}";
                    </script>
                    <div id="js_location_feedback"></div>
                {/if}
			</div>
			
			{foreach from=$aFeedStatusLinks item=aFeedStatusLink}
				{if !empty($aFeedStatusLink.module_block)}
					{module name=$aFeedStatusLink.module_block}			
				{/if}
			{/foreach}		
			{if Phpfox::isModule('egift')}
				{module name='egift.display'}
			{/if}
		</div>
		<div class="activity_feed_form_button">
			{if $bLoadCheckIn}
				<div id="js_location_input">
					<input type="text" id="hdn_location_name">
					<a href="#" onclick="$Core.Feed.resetLocation(); return false;">{phrase var='feed.not_here'}</a>
					<a href="#" onclick="$Core.Feed.cancelCheckIn(); return false;">{phrase var='feed.cancel_uppercase'}</a>
				</div>
			{/if}
			
			<div class="activity_feed_form_button_status_info">
				<textarea id="activity_feed_textarea_status_info" cols="60" rows="8" name="val[status_info]"></textarea>
			</div>
			<div class="activity_feed_form_button_position">
				
				{if ((defined('PHPFOX_IS_PAGES_VIEW') && $aPage.is_admin) || ((Phpfox::isModule('share') && !defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW') && !defined('PHPFOX_IS_EVENT_VIEW') && ((Phpfox::getParam('share.share_on_facebook') && Phpfox::getParam('facebook.facebook_app_id') && Phpfox::getParam('facebook.facebook_secret')) || Phpfox::getParam('share.share_on_twitter'))) || (defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id) && $aUser.user_id == Phpfox::getUserId() && Phpfox::getService('profile')->timeline() && Phpfox::getParam('feed.can_add_past_dates'))))}
					
					<div id="activity_feed_share_this_one">
						<ul>
							{if (Phpfox::isModule('share') && !defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW') && !defined('PHPFOX_IS_EVENT_VIEW') && ((Phpfox::getParam('share.share_on_facebook') && Phpfox::getParam('facebook.facebook_app_id') && Phpfox::getParam('facebook.facebook_secret')) || Phpfox::getParam('share.share_on_twitter')))}
							<li><a href="#" class="activity_feed_share_this_one_link parent feed_share_site js_hover_title" rel="feed_share_on_holder"><span class="js_hover_info">{phrase var='feed.share_this_on'}</span></a></li>
							{/if}
							{if ((defined('PHPFOX_IS_PAGES_VIEW') && $aPage.is_admin && Phpfox::getService('profile')->timeline()) || (defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id) && $aUser.user_id == Phpfox::getUserId() && Phpfox::getService('profile')->timeline() && Phpfox::getParam('feed.can_add_past_dates')))}
							<li>
								<a href="#" class="activity_feed_share_this_one_link parent feed_share_watch js_hover_title" rel="timeline_date_holder_share"><span class="js_hover_info">{phrase var='feed.set_a_date'}</span></a>
							</li>
							{/if}
							{if defined('PHPFOX_IS_PAGES_VIEW') && $aPage.is_admin && $aPage.page_id != Phpfox::getUserBy('profile_page_id')}
							<li>
								<div class="parent">
									<select name="custom_pages_post_as_page">
										<option value="{$aPage.page_id}">{phrase var='feed.post_as'}...</option>
										<option value="{$aPage.page_id}">{$aPage.full_name|clean|shorten:20:'...'}</option>
										<option value="0">{$sGlobalUserFullName|shorten:20:'...'}</option>
									</select>							
								</div>
							</li>
							{/if}						
							{if $bLoadCheckIn}
								{template file='feed.block.checkin'}						
							{/if}
						</ul>
						<div class="clear"></div>
					</div>
				
				{else}
					{if $bLoadCheckIn}						
						<div id="activity_feed_share_this_one">
							<ul>
								{template file='feed.block.checkin'}
								</ul>
						<div class="clear"></div>
						</div>						
					{/if}
				{/if}
				{if Phpfox::isModule('share')}
				<div class="feed_share_on_holder timeline_date_holder">						
					{if Phpfox::getParam('share.share_on_facebook') && Phpfox::getParam('facebook.facebook_app_id') && Phpfox::getParam('facebook.facebook_secret')}
					<div class="feed_share_on_item"><a href="#" onclick="$(this).toggleClass('active'); $.ajaxCall('share.connect', 'connect-id=facebook', 'GET'); return false;">{img theme='layout/facebook.png' class='v_middle'} {phrase var='feed.facebook'}</a></div>
					{/if}
					{if Phpfox::getParam('share.share_on_twitter')}
					<div class="feed_share_on_item"><a href="#" onclick="$(this).toggleClass('active'); $.ajaxCall('share.connect', 'connect-id=twitter', 'GET'); return false;">{img theme='layout/twitter.png' class='v_middle'} {phrase var='feed.twitter'}</a></div>
					{/if}
					<div class="clear"></div>
					<div><input type="hidden" name="val[connection][facebook]" value="0" id="js_share_connection_facebook" class="js_share_connection" /></div>
					<div><input type="hidden" name="val[connection][twitter]" value="0" id="js_share_connection_twitter" class="js_share_connection" /></div>
				</div>					
				{/if}
				{if ((defined('PHPFOX_IS_PAGES_VIEW') && $aPage.is_admin) || (defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id) && $aUser.user_id == Phpfox::getUserId() && Phpfox::getService('profile')->timeline() && Phpfox::getParam('feed.can_add_past_dates')))}
				<div class="timeline_date_holder_share timeline_date_holder">					
					<div class="t_center p_top_8">{img theme='ajax/add.gif'}</div>					
				</div>
				{/if}				
				
				<div class="activity_feed_form_button_position_button">
					<input type="submit" value="{phrase var='feed.share'}"  id="activity_feed_submit" class="button" />
				</div>				
				{if isset($aFeedCallback.module)}
				{else}
				{if !isset($bFeedIsParentItem) && (!defined('PHPFOX_IS_USER_PROFILE') || (defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id) && $aUser.user_id == Phpfox::getUserId()))}
				{module name='privacy.form' privacy_name='privacy' privacy_type='mini'}
				{/if}
				{/if}
				<div class="clear"></div>
			</div>
			
			
			
			{if Phpfox::getParam('feed.enable_check_in') && (Phpfox::getParam('core.ip_infodb_api_key') != '' || Phpfox::getParam('core.google_api_key') != '')}
				<div id="js_add_location">					
					<div><input type="hidden" id="val_location_latlng" name="val[location][latlng]"></div>
					<div><input type="hidden" id="val_location_name" name="val[location][name]"></div>
					<div id="js_add_location_suggestions" style="overflow-y: auto;"></div>
					<div id="js_feed_check_in_map"></div>
				</div>
			{/if}
				
				
				
		</div>			
	</form>
	<div class="activity_feed_form_iframe"></div>
</div>
