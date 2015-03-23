<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: photo.html.php 6772 2013-10-11 10:44:06Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bIsRegistration}
<div class="t_right p_top_10" style="font-size:10pt; font-weight:bold;">
	<a href="{$sNextUrl}">{phrase var='user.skip_this_step'}</a>
</div>	
{/if}
<div class="main_break">
	{plugin call='user.template_controller_photo_1'}
	<div id="js_crop_tool">
		{plugin call='user.template_controller_photo_2'}
		{if (!empty($sProfileImage) && Phpfox::getUserBy('user_image')) || $bIsProcess}
			{if !$bIsProcess}
				<div style="float:left;">
					<strong>{phrase var='user.avatar'}:</strong>
					<div class="p_2" id="js_user_avatar">
						{$sImageAvatar}
					</div>
				</div>
				<div class="clear"></div>
			{/if}	
			
			{if ($bIsProcess) || (!$bIsProcess && $iImageWidth > 75 && $iImageHeight > 75)}
				<h3>{phrase var='user.profile_picture_cropping_tool'}</h3>
				{if ($bIsProcess && ($iImageWidth <= 75 || $iImageHeight <= 75))}
					{$sProfileImage}
					<div class="extra_info">
						{phrase var='user.the_image_you_uploaded_is_rather_small_so_we_are_unable_to_crop_it_however_you_can_still_save_this_image_if_you_want_to_use_it'}
					</div>	
					<form method="post" action="#" onsubmit="return $Core.photo_crop.save(this);">
						{plugin call='user.template_controller_photo_3'}
						<div><input type="hidden" name="in_process" value="{$sCacheImage}" /></div>
						<div><input type="hidden" name="val[skip_croping]" value="{$sCacheImage}" /></div>
						
						<input type="submit" value="{phrase var='user.save_avatar'}" id="js_save_profile_photo" class="button" /> <span id="js_photo_preview_ajax"></span>		
					</form>
				{else}
					<div class="extra_info">
						{plugin call='user.template_controller_photo_4'}
						{phrase var='user.click_and_drag_a_box_on_the_original_image_to_create_your_cropped_image'}
					</div>
					<div class="p_4">
						<div style="float:left; margin-right:10px;">
						<strong>{phrase var='user.original'}:</strong>
							<div class="p_2" style="position:relative;">
								{$sProfileImage}
							</div>
						</div>
						<div id="js_photo_preview" style="display:none;">
							<strong>{phrase var='user.preview'}:</strong>
							<div class="p_2">
								<div style="position:relative; overflow:hidden; width:75px; height:75px; border:1px #000 solid;">
									{$sProfileImage2}
								</div>		
							</div>
						</div>
						<br style="clear:both;"/>
						<form method="post" action="#" onsubmit="return $Core.photo_crop.save(this);">
							{plugin call='user.template_controller_photo_5'}
						{if $bIsProcess}
							<div><input type="hidden" name="in_process" value="{$sCacheImage}" /></div>
						{/if}		
							<div><input type="hidden" name="val[x1]" value="" id="x1" /></div>
							<div><input type="hidden" name="val[y1]" value="" id="y1" /></div>
							<div><input type="hidden" name="val[x2]" value="" id="x2" /></div>
							<div><input type="hidden" name="val[y2]" value="" id="y2" /></div>
							<div><input type="hidden" name="val[w]" value="" id="w" /></div>
							<div><input type="hidden" name="val[h]" value="" id="h" /></div>
							<div><input type="hidden" name="val[image_width]" value="{$iImageWidth}" /></div>
							<div><input type="hidden" name="val[image_height]" value="{$iImageHeight}" /></div>				
							<div style="margin-top:10px;">
								<input type="submit" value="{phrase var='user.save_avatar'}" id="js_save_profile_photo" class="button" /> <span id="js_photo_preview_ajax"></span>
							</div>
						</form>			
					</div>
				{/if}
			{/if}
		{/if}
		{plugin call='user.template_controller_photo_6'}
	</div>
	
{if !$bIsProcess}
	{plugin call='user.template_controller_photo_7'}
	{if !empty($sProfileImage)}
	<h3>{phrase var='user.upload_a_new_profile_picture'}</h3>
	{/if}
	<div id="js_upload_photo_form">
		{plugin call='user.template_controller_photo_8'}
		<div id="js_photo_form_holder">
			{plugin call='user.template_controller_photo_9'}
			<form method="post" action="{if $bIsRegistration}{url link='user.photo.register'}{else}{url link='user.photo'}{/if}" id="js_form" enctype="multipart/form-data" onsubmit="return startProcess(true, true);">		
				<div class="table">
					{plugin call='user.template_controller_photo_10'}
					<div class="table_left">
						<label for="image">{phrase var='user.select_an_image'}:</label>
					</div>
					<div class="table_right">				
						<div id="js_progress_uploader"></div>
						<div class="extra_info">
							{phrase var='user.you_can_upload_a_jpg_gif_or_png_file'}
							{if $iMaxFileSize !== null}
							<br />
							{phrase var='user.the_file_size_limit_is_file_size_if_your_upload_does_not_work_try_uploading_a_smaller_picture' file_size=$iMaxFileSize|filesize}
							{/if}						
						</div>				
					</div>
					<div class="clear"></div>
				</div>		
				<div class="table_clear">
					<input type="submit" value="{phrase var='user.upload_picture'}" class="button" name="val[uploaded]" />
				</div>		
			</form>
		</div>
		<div id="js_photo_form_holder_loading" class="t_center" style="display:none;">
			<span style="margin-left:4px; margin-right:4px; font-size:9pt; font-weight:normal;">
				{img theme='ajax/large.gif' alt='' class='v_middle'}
				{phrase var='core.uploading'}
			</span>
		</div>
	</div>	
{/if}	
	
</div>
