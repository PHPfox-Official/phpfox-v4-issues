<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Video
 * @version 		$Id: index.html.php 520 2009-05-13 14:57:05Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{item name='VideoGallery'}
{plugin call='video.template_block_entry_1'}
	<div class="js_video_parent main_video_div_container {if isset($aVideo.is_sponsor) && $aVideo.is_sponsor}row_sponsored_image{/if} {if isset($aVideo.is_featured) && $aVideo.is_featured}row_featured_image{/if}" id="js_video_id_{$aVideo.video_id}">
		<div class="video_width_holder">
			<div class="video_height_holder">
				<div class="js_outer_video_div js_mp_fix_holder image_hover_holder">
				{if ((Phpfox::getUserParam('video.can_edit_own_video') && $aVideo.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('video.can_edit_other_video'))
					|| ((Phpfox::getUserParam('video.can_delete_own_video') && $aVideo.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('video.can_delete_other_video'))
					|| (defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getService('pages')->isAdmin('' . $aPage.page_id . ''))
				}
					<a href="#" class="image_hover_menu_link">{phrase var='video.link'}</a>
					<div class="image_hover_menu">
						<ul>
						{if ((Phpfox::getUserParam('video.can_delete_own_video') && $aVideo.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('video.can_delete_other_video'))
						|| (defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getService('pages')->isAdmin('' . $aPage.page_id . ''))
						}
							<li class="item_delete"><a href="#" title="{phrase var='video.delete_this_video'}" onclick="if (confirm('{phrase var='video.are_you_sure' phpfox_squote=true}')) $.ajaxCall('video.delete', 'video_id={$aVideo.video_id}'); return false;">{phrase var='video.delete'}</a></li>
						{/if}

						{if !defined('PHPFOX_IS_PAGES_VIEW')}
						{if Phpfox::getUserParam('video.can_sponsor_video')}
							<li id="js_video_sponsor_{$aVideo.video_id}">
							    {if $aVideo.is_sponsor}
								<a href="#" title="{phrase var='video.unsponsor_this_video'}" onclick="$.ajaxCall('video.sponsor', 'video_id={$aVideo.video_id}&amp;type=0'); return false;">
								   {phrase var='video.un_sponsor'}
								</a>
							    {else}
								<a href="#" title="{phrase var='video.sponsor_this_video'}" onclick="$.ajaxCall('video.sponsor', 'video_id={$aVideo.video_id}&amp;type=1'); return false;">
								    {phrase var='video.sponsor'}
								</a>
							    {/if}
							</li>
						{/if}
						{if $aVideo.view_id != 2}
						{if Phpfox::getUserParam('video.can_feature_videos_')}
							<li id="js_feature_{$aVideo.video_id}"{if $aVideo.is_featured} style="display:none;"{/if}><a href="#" title="{phrase var='video.feature_this_video'}" onclick="$(this).parent().hide(); $('#js_unfeature_{$aVideo.video_id}').show(); $(this).parents('.js_video_parent:first').addClass('row_featured_image').find('.js_featured_video:first').show(); $.ajaxCall('video.feature', 'video_id={$aVideo.video_id}&amp;type=1'); return false;">{phrase var='video.feature'}</a></li>
							<li id="js_unfeature_{$aVideo.video_id}"{if !$aVideo.is_featured} style="display:none;"{/if}><a href="#" title="{phrase var='video.un_feature_this_video'}" onclick="$(this).parent().hide(); $('#js_feature_{$aVideo.video_id}').show(); $(this).parents('.js_video_parent:first').removeClass('row_featured_image').find('.js_featured_video:first').hide(); $.ajaxCall('video.feature', 'video_id={$aVideo.video_id}&amp;type=0'); return false;">{phrase var='video.un_feature'}</a></li>
						{/if}
						{/if}
						{/if}
						{if (Phpfox::getUserParam('video.can_edit_own_video') && $aVideo.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('video.can_edit_other_video')}
							<li><a href="{url link='video.edit' id=$aVideo.video_id}" title="{phrase var='video.edit_this_video'}">{phrase var='video.edit'}</a></li>
						{/if}
						{plugin call='video.template_block_entry_3'}
						</ul>
					</div>
				{/if}
				{if !empty($aVideo.duration)}
					<div class="video_duration">
						{$aVideo.duration}
					</div>
				{/if}

					{plugin call='video.template_block_entry_2'}
					{if isset($sPublicPhotoView) && $sPublicPhotoView == 'featured'}
					{else}
					<div class="js_featured_video row_featured_link"{if !$aVideo.is_featured} style="display:none;"{/if}>
						{phrase var='video.featured'}
					</div>
					{/if}
					<div class="row_pending_link"{if $aVideo.view_id != 2} style="display:none;"{/if}>
						{phrase var='video.pending'}
					</div>
					<div class="js_sponsor_video row_sponsored_link"{if !$aVideo.is_sponsor} style="display:none;"{/if}>
						{phrase var='video.sponsored'}
					</div>

					{if Phpfox::getUserParam('video.can_approve_videos') || Phpfox::getUserParam('video.can_delete_other_video')}
					<div class="video_moderate_link"><a href="#{$aVideo.video_id}" class="moderate_link" rel="video">{phrase var='video.moderate'}</a></div>
					{/if}
					<a href="{$aVideo.link}" class="js_video_title_{$aVideo.video_id}">
						{if !empty($aVideo.vidly_url_id) && Phpfox::getParam('video.vidly_support')}
							<img src="https://vid.ly/{$aVideo.vidly_url_id}/thumbnail1" alt="{$aVideo.title|clean}" style="max-width:120; max-height:90px;" class='js_mp_fix_width video_image_border' />
						{else}
						{if file_exists(sprintf($aVideo.image_path, '_12090'))}
							{img server_id=$aVideo.image_server_id path='video.url_image' file=$aVideo.image_path suffix='_12090' max_width=120 max_height=90 class='js_mp_fix_width video_image_border' title=$aVideo.title itemprop='image'}
						{else}
							{img server_id=$aVideo.image_server_id path='video.url_image' file=$aVideo.image_path suffix='_120' max_width=120 max_height=90 class='js_mp_fix_width video_image_border' title=$aVideo.title itemprop='image'}
						{/if}
						{/if}
					</a>
				</div>
			</div>
			{plugin call='video.template_block_entry_4'}
			<header>
				<h1 itemprop="name"><a href="{$aVideo.link}" class="row_sub_link js_video_title_{$aVideo.video_id}" id="js_video_title_{$aVideo.video_id}" itemprop="url">{$aVideo.title|clean|shorten:30:'...'|split:20}</a></h1>
			</header>
			<div class="extra_info_link">
				{if isset($sPublicPhotoView) && $sPublicPhotoView == 'most-discussed'}
					{phrase var='video.comments_total_comment' total_comment=$aVideo.total_comment}<br />
				{elseif isset($sPublicPhotoView) && $sPublicPhotoView == 'popular'}
					{phrase var='video.total_score_out_of_10' total_score=$aVideo.total_score|round} <br />
				{else}
				{if !empty($aVideo.total_view) && $aVideo.total_view > 0}
				<span itemprop="interactionCount">
				{if $aVideo.total_view == 1}
				{phrase var='video.1_view'}<br />
				{else}
				{phrase var='video.total_views' total=$aVideo.total_view}<br />
				{/if}
				</span>
				{/if}
				{/if}
				{if !defined('PHPFOX_IS_USER_PROFILEs')}
					{phrase var='video.by_full_name' full_name=$aVideo|user:'':'':20:'':'author'}
				{/if}
				{plugin call='video.template_block_entry_5'}
			</div>
		</div>
	</div>
	{if Phpfox::isMobile() || is_int($phpfox.iteration.videos/3)}
	<div class="clear"></div>
	{/if}
	{plugin call='video.template_block_entry_6'}
{/item}
