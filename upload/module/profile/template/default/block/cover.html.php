<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Profile
 * @version 		$Id: header.html.php 3990 2012-03-09 15:28:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_cover_photo_iframe_loader_error"></div>
<div id="js_cover_photo_iframe_loader_upload" style="display:none;">{img theme='ajax/add.gif' class='v_middle'} {phrase var='user.uploading_image'}</div>
<form id="js_activity_feed_form" enctype="multipart/form-data" action="{url link='photo.frame'}" method="post" target="js_cover_photo_iframe_loader">
	<div><input type="hidden" name="val[action]" value="upload_photo_via_share" /></div>
	<div><input type="hidden" name="val[is_cover_photo]" value="1" /></div>
	{if isset($iPageId) && !empty($iPageId)}
		<div>
			<input type="hidden" name="val[page_id]" value="{$iPageId}" />
		</div>
	{/if}
	<div class="table">
		<div class="table_left">
			{phrase var='user.select_a_photo'}:
		</div>
		<div class="table_right">
			<div><input type="file" name="image[]" id="global_attachment_photo_file_input" value="" /></div>	
		</div>
	</div>
	<div class="table_clear">		
		<div><input type="submit" value="{phrase var='user.upload'}" class="button" onclick="$('#js_cover_photo_iframe_loader_error').hide(); $('#js_cover_photo_iframe_loader_upload').show(); $('#js_activity_feed_form').hide();" /></div>
	</div>	
	<iframe id="js_cover_photo_iframe_loader" name="js_cover_photo_iframe_loader" height="200" width="500" frameborder="1" style="display:none;"></iframe>
</form>