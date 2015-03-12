<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: edit.html.php 2502 2011-04-05 20:39:52Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !empty($sVideoMessage)}
<div class="message">
	{$sVideoMessage}
</div>
<div class="main_break"></div>
{/if}

<form method="post" action="{url link='video.edit'}" onsubmit="return startProcess(true, false);" enctype="multipart/form-data">
	<div><input type="hidden" name="id" value="{$aForms.video_id}" /></div>
	{if $sStep}
	<div><input type="hidden" name="val[step]" value="{$sStep}" /></div>
	{/if}
	{if !$sStep}
	<div><input type="hidden" name="val[action]" value="{$sAction}" id="js_video_add_action" /></div>
	{/if}	
	
	<div id="js_video_block_detail" class="js_video_block page_section_menu_holder">
		{template file='video.block.form'}
		
		<div class="table_clear">
			<input type="submit" value="{phrase var='video.save'}" class="button" />
		</div>		
	</div>
	
	<div id="js_video_block_photo" class="js_video_block page_section_menu_holder" style="display:none;">	
		<div id="js_video_block_photo_holder">
			<div class="table">
				<div class="table_left">
					{phrase var='video.video_photo'}:
				</div>
				<div class="table_right">
					{if !empty($aForms.image_path)}
					<div id="js_video_current_image">
						{img server_id=$aForms.image_server_id path='video.url_image' file=$aForms.image_path suffix='_120' max_width=120 max_height=120}
						<div class="extra_info">
							{phrase var='video.click_to_delete_this_image' on_delete_image=$sOnClickDeleteImage}
						</div>
						
					</div>
					{/if}
					<div id="js_video_upload_image"{if !empty($aForms.image_path)} style="display:none;"{/if}>
						<div id="js_progress_uploader"></div>
						<div class="extra_info">
							{phrase var='video.you_can_upload_a_jpg_gif_or_png_file'}
							{if $iMaxFileSize !== null}
							{phrase var='video.the_file_size_limit_is' iMaxFileSize_filesize=$iMaxFileSize_filesize}							
							{/if}						
						</div>
					</div>
				</div>
			</div>
			
			<div id="js_submit_upload_image" class="table_clear"{if !empty($aForms.image_path)} style="display:none;"{/if}>
				<input type="submit" value="{phrase var='video.save'}" class="button" />
			</div>
		</div>		
	</div>	
	

</form>