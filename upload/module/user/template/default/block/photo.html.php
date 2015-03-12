<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='user.photo'}" enctype="multipart/form-data" target="js_upload_photo_frame">
	<div><input type="hidden" name="val[is_iframe]" value="1" /></div>
	<div><input type="hidden" name="val[user_id]" value="{$iUserId}" /></div>
	<div class="table_header">
		{phrase var='user.select_an_image'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='user.file'}:
		</div>
		<div class="table_right">
			<input type="file" name="image" />
			<div class="extra_info">
				{phrase var='user.you_can_upload_a_jpg_gif_or_png_file'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='user.upload_picture'}" class="button" name="val[uploaded]" />
	</div>
</form>

<iframe frameborder="1" name="js_upload_photo_frame" id="js_upload_photo_frame" style="width:100%; height:200px; display:none;"></iframe>