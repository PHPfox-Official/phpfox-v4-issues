<li><a href="{url link='pages.add' id=$aPage.page_id}">{phrase var='pages.manage'}</a></li>
{if Phpfox::getUserParam('pages.can_design_pages') && isset($aPage.is_admin) && $aPage.is_admin}
	<li>
		<a href="{$aPage.link}designer/" class="no_ajax_link">
			{phrase var='pages.customize_design'}
		</a>
	</li>
{/if}
{if Phpfox::getUserParam('pages.can_moderate_pages') || $aPage.user_id == Phpfox::getUserId()}
	<li class="item_delete">
		<a href="{url link='pages' delete=$aPage.page_id}" onclick="return confirm('{phrase var='pages.are_you_sure'}');" class="no_ajax_link">
			{phrase var='pages.delete'}
		</a>
	</li>
{/if}
{if Phpfox::getUserParam('pages.can_add_cover_photo_pages')}
<li>
	<a href="#" onclick="$(this).parent().find('.cover_section_menu_drop:first').toggle(); event.cancelBubble = true; if (event.stopPropagation) event.stopPropagation();return false;">
		{if empty($aPage.cover_photo_id)}
			{phrase var='user.add_a_cover'}
		{else}
			{phrase var='user.change_cover'}
		{/if}
	</a>
	<div class="cover_section_menu_drop" style="display: none;">
		<ul style="display:block">
			<li>
				<a href="{url link='pages.'$aPage.page_id}photo">
					{phrase var='user.choose_from_photos'}
				</a>
			</li>
			<li>
				<a href="#" onclick="$(this).parent().find('.cover_section_menu_drop:first').hide(); $Core.box('profile.logo', 500, 'page_id={$aPage.page_id}'); return false;">
					{phrase var='user.upload_photo'}
				</a>
			</li>
			{if !empty($aPage.cover_photo_id)}
				<li>
					<a href="{$aPage.link}coverupdate_1">
						{phrase var='user.reposition'}
					</a>
				</li>
				<li>
					<a href="#" onclick="$(this).parent().find('.cover_section_menu_drop:first').hide(); $.ajaxCall('pages.removeLogo', 'page_id={$aPage.page_id}'); return false;">
						{phrase var='user.remove'}
					</a>
				</li>
			{/if}
		</ul>
	</div>
</li>
{/if}