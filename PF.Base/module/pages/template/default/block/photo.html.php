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

	<div class="pages_header_info set_to_fixed" data-class="pages_header_fixed">
		<div>
			<div class="pages_header_image">
				{img thickbox=true server_id=$aPage.image_server_id title=$aPage.title path='pages.url_image' file=$aPage.pages_image_path suffix='_120'}
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
			
			{if !$aPage.is_admin && Phpfox::getUserParam('pages.can_claim_page') && empty($aPage.claim_id)}
			<a href="#?call=contact.showQuickContact&amp;height=600&amp;width=600&amp;page_id={$aPage.page_id}" class="inlinePopup js_claim_page" title="{phrase var='pages.claim_page'}">
				{phrase var='pages.claim_page'}
			</a>
			{/if}
			
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

		{if !$bIsUsersProfilePage && count($aSubMenus)}
		<div class="breadcrumbs_menu">
			<ul>
				{foreach from=$aSubMenus key=iKey name=submenu item=aSubMenu}
				<li>
					<a href="{url link=$aSubMenu.url)}">
						{if (isset($aSubMenu.title))}
						{$aSubMenu.title}
						{else}
						{phrase var=$aSubMenu.module'.'$aSubMenu.var_name}
						{/if}
					</a>
				</li>
				{/foreach}
			</ul>
		</div>
		{/if}

		<div class="pages_menu">
			<ul>
				{foreach from=$aPageMenus item=aPageMenu}
				<li><a href="{$aPageMenu.url}">{$aPageMenu.phrase}</a></li>
				{/foreach}
			</ul>
		</div>
	</div>

	{if $aCoverPhoto !== false}
	<div class="pages_header_cover">
		{img server_id=$aCoverPhoto.server_id path='photo.url_photo' file=$aCoverPhoto.destination suffix='_1024' title=$aCoverPhoto.title}
	</div>
	{/if}

</div>