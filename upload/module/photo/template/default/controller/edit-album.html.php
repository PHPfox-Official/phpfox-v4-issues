<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: edit-album.html.php 3661 2011-12-05 15:42:26Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_photo_block_detail" class="js_photo_block page_section_menu_holder">
	<form method="post" action="{url link='photo.edit-album' id=$aForms.album_id}">
		<div id="js_custom_privacy_input_holder_album">
			{module name='privacy.build' privacy_item_id=$aForms.album_id privacy_module_id='photo_album'}
		</div>	
		{template file='photo.block.form-album'}
		<div class="table_clear">
			<input type="submit" value="{phrase var='photo.update'}" class="button" />
		</div>
	</form>
</div>

<div id="js_photo_block_photo" class="js_photo_block page_section_menu_holder" style="display:none;">
	<form method="post" action="{url link='photo.edit-album.photo' id=$aForms.album_id}">
		{foreach from=$aPhotos item=aForms}
			{template file='photo.block.edit-photo'}
		{/foreach}
	
		<div class="photo_table_clear">
			<input type="submit" value="{phrase var='photo.save_changes'}" class="button" />
		</div>
	</form>
</div>