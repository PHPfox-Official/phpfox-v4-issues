
<div class="item_view">
		<div class="item_info">
			{phrase var='photo.time_stamp_by_full_name' time_stamp=$aForms.time_stamp|convert_time full_name=$aForms|user:'':'':35:'':'author'}
			{if !empty($aForms.album_id)} {phrase var='photo.in'} <a href="{$aForms.album_url}">{$aForms.album_title|clean|split:45|shorten:75:'...'}</a>{/if}
		</div>
		{if (Phpfox::getUserParam('photo.can_edit_own_photo') && $aForms.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('photo.can_edit_other_photo')
		|| (Phpfox::getUserParam('photo.can_delete_own_photo') && $aForms.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('photo.can_delete_other_photos')
		}
		<div class="item_bar">
			<div class="item_bar_action_holder">
				{if $aForms.view_id == '1' && Phpfox::getUserParam('photo.can_approve_photos')}
				<a href="#" class="item_bar_approve item_bar_approve_image" onclick="return false;" style="display:none;" id="js_item_bar_approve_image">{img theme='ajax/add.gif'}</a>
				<a href="#" class="item_bar_approve" onclick="$(this).hide(); $('#js_item_bar_approve_image').show(); $.ajaxCall('photo.approve', 'inline=true&amp;id={$aForms.photo_id}'); return false;">{phrase var='photo.approve'}</a>
				{/if}
				<a href="#" class="item_bar_action"><span>{phrase var='photo.actions'}</span></a>
				<ul>
					{template file='photo.block.menu'}
				</ul>
			</div>
		</div>
		{/if}

	<div class="item_content">
		{$aForms.description|clean}
	</div>

	<div class="js_moderation_on">
		{module name='feed.comment'}
	</div>

</div>
<script type="text/javascript">
	$Behavior.tagPhoto = function() {l} $Core.photo_tag.init({l}{$sPhotoJsContent}{r}); {r};
	$Behavior.removeTagBox = function()
	{l}
	{literal}
	if ($('#noteform').length > 0)$('#noteform').hide(); if ($('#js_photo_view_image').length > 0 && typeof $('#js_photo_view_image').imgAreaSelect == 'function')$('#js_photo_view_image').imgAreaSelect({ hide: true });
	{/literal}
	{r};
	
	
	$Behavior.removeImgareaselectBox = function()
	{l}
	{literal}
	if ($('body#page_photo_view').length == 0) {
		$('.imgareaselect-outer').remove();
		$('.imgareaselect-selection').each(function() {
		   $(this).parent().remove();
		});
	}
	{/literal}
	{r};
</script>