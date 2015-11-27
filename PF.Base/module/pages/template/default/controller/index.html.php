<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 3990 2012-03-09 15:28:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bShowCategories}

	{if $aCategories}
	{foreach from=$aCategories item=aCategory}
	{if $aCategory.pages}
	<div class="block_clear">
		<div class="title"><a href="{$aCategory.link}">{$aCategory.name|clean}</a></div>
		<div class="content">
			{foreach from=$aCategory.pages item=aPage}
			<div class="user_rows">
				<div class="user_rows_image">
					<a href="{$aPage.link}">{img server_id=$aPage.profile_server_id title=$aPage.title path='pages.url_image' file=$aPage.image_path suffix='_120' max_width='120' max_height='120' is_page_image=true}</a>
				</div>
				<span class="pages_link_span"><a href="{$aPage.link}" class="link">{$aPage.title|clean}</a></span>
			</div>
			{/foreach}
		</div>
	</div>
	{/if}
	{/foreach}
	{else}
	<div class="extra_info">
		No pages
	</div>
	{/if}

{else}

{if count($aPages)}
{if $sView == 'my' && Phpfox::getUserBy('profile_page_id')}
<div class="message">
	{phrase var='pages.note_that_pages_displayed_here_are_pages_created_by_the_page' global_full_name=$sGlobalUserFullName|clean profile_full_name=$aGlobalProfilePageLogin.full_name|clean}
</div>
{/if}
{foreach from=$aPages name=pages item=aPage}
<div class="user_rows">
	<div class="user_rows_image">
		<a href="{$aPage.link}">{img server_id=$aPage.profile_server_id title=$aPage.title path='pages.url_image' file=$aPage.image_path suffix='_120' max_width='120' max_height='120' is_page_image=true}</a>
	</div>
	<span class="user_profile_link_span"><a href="{$aPage.link}" class="link">{$aPage.title|clean}</a></span>
</div>
{/foreach}

{pager}

{if Phpfox::getUserParam('pages.can_moderate_pages')}
{moderation}
{/if}

{else}
<div class="extra_info">
	{phrase var='pages.no_pages_found'}
</div>
{/if}

{/if}