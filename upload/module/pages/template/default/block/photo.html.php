<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="pages_header">

	{if $aCoverPhoto !== false}
	<div class="pages_header_cover">
		{img server_id=$aCoverPhoto.server_id path='photo.url_photo' file=$aCoverPhoto.destination suffix='_1024' title=$aCoverPhoto.title}
	</div>
	{/if}

	<div class="pages_header_info">
		<div>
			<div class="pages_header_image">
				{img thickbox=true server_id=$aPage.image_server_id title=$aPage.title path='core.url_user' file=$aPage.image_path suffix='_120_square'}
			</div>
		</div>
		<div>
			<header class="pages_header_name">
				<h1>{$aPage.title|clean}</h1>
				<ul>
					<li>{$aPage.category_name|convert}</li>
					<li>
						{$aPage.total_like} followers
					</li>
				</ul>
			</header>

			{template file='pages.block.joinpage'}
		</div>
	</div>

	{if !Phpfox::isMobile() && (Phpfox::getUserParam('pages.can_moderate_pages') || $aPage.is_admin)}
	<div class="item_bar">
		<div class="item_bar_action_holder">
			{if $aPage.view_id == '1' && Phpfox::getUserParam('pages.can_moderate_pages')}
			<a href="#" class="item_bar_approve item_bar_approve_image" onclick="return false;" style="display:none;" id="js_item_bar_approve_image">
				{img theme='ajax/add.gif'}
			</a>
			<a href="#" class="item_bar_approve" onclick="$(this).hide(); $('#js_item_bar_approve_image').show(); $.ajaxCall('pages.approve', 'page_id={$aPage.page_id}'); return false;">
				{phrase var='pages.approve'}
			</a>
			{/if}
			<a href="#" class="item_bar_action">
				<span>
					{phrase var='pages.actions'}
				</span>
			</a>
			<ul>
				{template file='pages.block.link'}
			</ul>
		</div>
	</div>
	{/if}

</div>

{*
<div class="profile_image">
    <div class="profile_image_holder">
		{if $aPage.is_app}
		{img server_id=$aPage.image_server_id path='app.url_image' file=$aPage.aApp.image_path suffix='_120' max_width='175' max_height='300' title=$aPage.aApp.app_title}
		{else}
			{if Phpfox::getParam('core.keep_non_square_images')}
				{img thickbox=true server_id=$aPage.image_server_id title=$aPage.title path='core.url_user' file=$aPage.image_path suffix='_120' max_width='175' max_height='300'}
			{else}
				{img thickbox=true server_id=$aPage.image_server_id title=$aPage.title path='core.url_user' file=$aPage.image_path suffix='_120_square' max_width='175' max_height='300'}
			{/if}
		{/if}
	</div>
	<div class="profile_no_timeline">

		{if isset($aPage.title)}
		{template file='pages.block.joinpage'}
		{/if}

	</div>
</div>
*}