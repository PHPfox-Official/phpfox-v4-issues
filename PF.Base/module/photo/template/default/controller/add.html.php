<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 6934 2013-11-22 14:26:35Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if false && Phpfox::isMobile()}
<div class="extra_info">
	{phrase var='photo.photos_unfortunately_cannot_be_uploaded_via_mobile_devices_at_this_moment'}
</div>
{else}
<div id="js_upload_error_message"></div>

<div id="js_photo_form_holder">
	<form method="post" action="{url link='photo.frame'}" id="js_photo_form" enctype="multipart/form-data" onsubmit="return startProcess(true, true);">
		
	{if $sModuleContainer}
		<div><input type="hidden" name="val[callback_module]" value="{$sModuleContainer}" /></div>
	{/if}
	{if $iItem}
		<div><input type="hidden" name="val[callback_item_id]" value="{$iItem}" /></div>
		<div><input type="hidden" name="val[group_id]" value="{$iItem}" /></div>
		<div><input type="hidden" name="val[parent_user_id]" value="{$iItem}" /></div>
	{/if}
		<div class="table">
			<div class="table_right">
				<div id="photo_selector">
					<div id="photo_selector_button">Select photos(s)</div>
					<div id="js_photo_upload_input"></div>
				</div>
				<div class="extra_info">
					{phrase var='photo.you_can_upload_a_jpg_gif_or_png_file'}
					{if $iMaxFileSize !== null}
					<br />
					{phrase var='photo.the_file_size_limit_is_file_size_if_your_upload_does_not_work_try_uploading_a_smaller_picture' file_size=$iMaxFileSize|filesize}
					{/if}
				</div>
			</div>
		</div>

	<div class="_form_extra">
		{plugin call='photo.template_controller_upload_form'}
		{if Phpfox::getUserParam('photo.can_create_photo_album')}
			<div class="table" id="album_table">
				<div class="table_left">
					{phrase var='photo.photo_album'}
				</div>
				<div class="table_right table_right_text">
					<span id="js_photo_albums"{if !count($aAlbums)} style="display:none;"{/if}>
						<select name="val[album_id]" id="js_photo_album_select" onchange="if (empty(this.value)) {l} $('#js_photo_privacy_holder').slideDown(); {r} else {l} $('#js_photo_privacy_holder').slideUp(); {r}">
							<option value="">{phrase var='photo.select_an_album'}:</option>
								{foreach from=$aAlbums item=aAlbum}
									<option value="{$aAlbum.album_id}"{if $iAlbumId == $aAlbum.album_id} selected="selected"{/if}>{$aAlbum.name|clean}</option>
								{/foreach}
						</select>
					</span> <a href="#" class="js_hover_title" onclick="$Core.box('photo.newAlbum', 500, 'module={$sModuleContainer}&amp;item={$iItem}'); return false;"><i class="fa fa-plus-square fa-2x"></i><span class="js_hover_info">{phrase var='photo.create_a_new_photo_album'}</span></a>
				</div>
			</div>		
		{/if}		
		
		{if !$sModuleContainer && Phpfox::getParam('photo.allow_photo_category_selection') && Phpfox::getService('photo.category')->hasCategories()}
		<div class="table">
			<div class="table_left">
				<label for="category">{phrase var='photo.category'}:</label>
			</div>
			<div class="table_right">
				{module name='photo.drop-down'}
			</div>
		</div>		
		{/if}
		
		<div class="table" id="js_photo_privacy_holder" {if $iAlbumId} style="display:none;"{/if}>
			{if $sModuleContainer}
			<div><input type="hidden" id="privacy" name="val[privacy]" value="0" /></div>
			<div><input type="hidden" id="privacy_comment" name="val[privacy_comment]" value="0" /></div>
			{else}
				{if Phpfox::isModule('privacy')}
					<div class="table">
						<div class="table_left">
							{phrase var='photo.photo_s_privacy'}:
						</div>
						<div class="table_right">	
							{module name='privacy.form' privacy_name='privacy' privacy_info='photo.control_who_can_see_these_photo_s' default_privacy='photo.default_privacy_setting'}
						</div>			
					</div>
					<div class="table" style="display:none;">
						<div class="table_left">
							{phrase var='photo.comment_privacy'}:
						</div>
						<div class="table_right">	
							{module name='privacy.form' privacy_name='privacy_comment' privacy_info='photo.control_who_can_comment_on_these_photo_s' privacy_no_custom=true}
						</div>			
					</div>		
				{/if}
			{/if}
		</div>

</div>

		
	</form>
</div>
<div id="js_photo_form_holder_loading" class="t_center" style="display:none;">
	{img theme='ajax/large.gif' alt='' class='v_middle'}
</div>
{/if}