<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: form-album.html.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div class="table">
		<div class="table_left">
		{required}{phrase var='photo.name'}:
		</div>
		<div class="table_right">
			{if isset($aForms.album_id) && $aForms.profile_id > 0}
			<input type="hidden" name="val[name]" id="name" value="{phrase var='photo.profile_pictures'}" size="30" maxlength="150" />	
			{phrase var='photo.profile_pictures'}
			{else}
			<input type="text" name="val[name]" id="name" value="{value type='input' id='name'}" size="30" maxlength="150" />	
			{/if}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='photo.description'}:
		</div>
		<div class="table_right">
			<textarea name="val[description]" id="description" cols="40" rows="5">{value type='textarea' id='description'}</textarea>
		</div>
		<div class="clear"></div>
	</div>
	{if isset($sModule) && $sModule}
	
	{else}
	{if Phpfox::isModule('privacy')}
	<div class="table">
		<div class="table_left">
			{phrase var='photo.album_s_privacy'}:
		</div>
		<div class="table_right">	
			{module name='privacy.form' privacy_name='privacy' privacy_info='photo.control_who_can_see_this_photo_album_and_any_photos_associated_with_it' privacy_custom_id='js_custom_privacy_input_holder_album'}
		</div>			
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='photo.comment_privacy'}:
		</div>
		<div class="table_right">	
			{module name='privacy.form' privacy_name='privacy_comment' privacy_info='photo.control_who_can_comment_on_this_photo_album_and_any_photos_associated_with_it' privacy_no_custom=true}
		</div>			
	</div>
	{/if}
	{/if}