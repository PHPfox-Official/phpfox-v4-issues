<li><a href="{url link='pages.add' id=$aPage.page_id}">{phrase var='pages.manage'}</a></li>
{if Phpfox::getUserParam('pages.can_add_cover_photo_pages')}
<li>
	<a href="#" onclick="$(this).closest('ul').find('.cover_section_menu_item').toggleClass('hidden'); event.cancelBubble = true; if (event.stopPropagation) event.stopPropagation();return false;">
		{if empty($aPage.cover_photo_id)}
			{phrase var='user.add_a_cover'}
		{else}
			{phrase var='user.change_cover'}
		{/if}
	</a>
</li>
<li class="cover_section_menu_item hidden">
	<a href="{url link='pages.'$aPage.page_id}photo">
		{phrase var='user.choose_from_photos'}
	</a>
</li>
<li class="cover_section_menu_item hidden">
	<a href="#" onclick="$(this).closest('ul').find('.cover_section_menu_item').addClass('hidden'); $Core.box('profile.logo', 500, 'page_id={$aPage.page_id}'); return false;">
		{phrase var='user.upload_photo'}
	</a>
</li>
{if !empty($aPage.cover_photo_id)}
<li class="cover_section_menu_item hidden">
	<a role="button" onclick="repositionCoverPhoto('pages',{$aPage.page_id})">
		{phrase var='user.reposition'}
	</a>
</li>
<li class="cover_section_menu_item hidden">
	<a href="#" onclick="$(this).closest('ul').find('.cover_section_menu_item').addClass('hidden'); $.ajaxCall('pages.removeLogo', 'page_id={$aPage.page_id}'); return false;">
		{phrase var='user.remove'}
	</a>
</li>
{/if}
{/if}
{if Phpfox::getUserParam('pages.can_moderate_pages') || $aPage.user_id == Phpfox::getUserId()}
<li class="item_delete">
	<a href="{url link='pages' delete=$aPage.page_id}" onclick="return confirm('{phrase var='pages.are_you_sure'}');" class="no_ajax_link">
		{phrase var='pages.delete'}
	</a>
</li>
{/if}