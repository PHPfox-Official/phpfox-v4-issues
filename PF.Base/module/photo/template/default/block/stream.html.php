
<div class="photos_view">
	{img id='js_photo_view_image' server_id=$aForms.server_id path='photo.url_photo' file=$aForms.destination suffix='_1024' title=$aForms.title}

	<div class="photos_actions">
		{phrase var='photo.in_this_photo'}: <span id="js_photo_in_this_photo"></span>
		<ul>
			{if (Phpfox::getUserParam('photo.can_edit_own_photo') && $aForms.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('photo.can_edit_other_photo')}
			<li>
				<a href="#" class="js_hover_title" onclick="$('#photo_view_ajax_loader').show(); $('#menu').remove(); $('#noteform').hide(); $('#js_photo_view_image').imgAreaSelect({left_curly} hide: true {right_curly}); $('#js_photo_view_holder').hide(); $.ajaxCall('photo.rotate', 'photo_id={$aForms.photo_id}&amp;photo_cmd=left&amp;currenturl=' + $('#js_current_page_url').html()); return false;">
					<span class="js_hover_info">{phrase var='photo.rotate_left'}</span>
					<i class="fa fa-rotate-left"></i>
				</a>
			</li>
			<li>
				<a href="#" class="js_hover_title" onclick="$('#photo_view_ajax_loader').show(); $('#menu').remove(); $('#noteform').hide(); $('#js_photo_view_image').imgAreaSelect({left_curly} hide: true {right_curly}); $('#js_photo_view_holder').hide(); $.ajaxCall('photo.rotate', 'photo_id={$aForms.photo_id}&amp;photo_cmd=right&amp;currenturl=' + $('#js_current_page_url').html()); return false;">
					<span class="js_hover_info">{phrase var='photo.rotate_right'}</span>
					<i class="fa fa-rotate-right"></i>
				</a>
			</li>
			{/if}
			<li class="photos_tag">
				<a href="#" id="js_tag_photo" class="js_hover_title">
					<span class="js_hover_info">{phrase var='photo.tag_this_photo'}</span>
					<i class="fa fa-tag"></i>
				</a>
			</li>
		</ul>
	</div>
</div>