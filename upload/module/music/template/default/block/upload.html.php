<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: upload.html.php 4328 2012-06-25 13:49:41Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_music_form_holder">
	{if !$bIsEdit}
	<div class="message" style="font-weight:normal;">
		<p>
			{phrase var='music.you_retain_all_rights_in_your_music_that_you_upload_you_must_only_upload_music_in_which_you_own_all'}
		</p>
		<p>
			{phrase var='music.uploading_copyrighted_music_without_the_explicit_consent_of_the_copyright_owner_will_result_in_your'}
		</p>
	</div>		
	
	<div class="valid_message" id="js_music_upload_valid_message" style="display:none;">
		{phrase var='music.successfully_uploaded_the_mp3'}
	</div>	
			
	<div class="main_break"></div>
	{/if}
	{if isset($sModule) && $sModule}
	
	{else}
	<div id="js_custom_privacy_input_holder">
	{if $bIsEdit && Phpfox::isModule('privacy')}
		{if isset($bIsEditAlbum)}
		{module name='privacy.build' privacy_item_id=$aForms.album_id privacy_module_id='music_album'}
		{else}
		{module name='privacy.build' privacy_item_id=$aForms.song_id privacy_module_id='music_song'}
		{/if}
	{/if}
	</div>	
	{/if}
	{if isset($bIsEditAlbum) && $bIsEdit}
	<div><input type="hidden" name="val[inline]" value="1" /></div>
	<div><input type="hidden" name="val[album_id]" value="{$aForms.album_id}" /></div>
	{/if}
	
	{if !isset($bIsEditAlbum)}
	<div class="table">
		<div class="table_left">
			{if isset($aUploadAlbums) && count($aUploadAlbums)}
			{phrase var='music.album'}: 
			{else}
			{phrase var='music.album_name'}: 
			{/if}
		</div>
		<div class="table_right">
			{if isset($aUploadAlbums) && count($aUploadAlbums)}
			<select name="val[album_id]" id="music_album_id_select" onchange="if (empty(this.value)) {l} $('#js_song_privacy_holder').slideDown(); {r} else {l} $('#js_song_privacy_holder').slideUp(); {r}">
				<option value="">{phrase var='music.select'}:</option>
			{foreach from=$aUploadAlbums item=aAlbum}
				<option value="{$aAlbum.album_id}"{value type='select' id='album_id' default=$aAlbum.album_id}>{$aAlbum.name|clean}</option>
			{/foreach}
			</select>
			<div class="extra_info_link"><a href="#" onclick="$('#js_create_new_music_album').show(); $('#js_create_new_music_album input').focus(); return false;">{phrase var='music.or_create_a_new_album'}</a></div>
			<div id="js_create_new_music_album" class="p_top_8" style="display:none;">
				<input type="text" name="val[new_album_title]" value="{value type='input' id='new_album_title'}" size="30" />
			</div>
			{else}
			<input type="text" name="val[new_album_title]" value="{value type='input' id='new_album_title'}" size="30" /> <span class="extra_info">{phrase var='music.optional'}</span>
			{/if}
		</div>
	</div>	
	{/if}
	
	<div class="table song_name">
		<div class="table_left">
			{required}{phrase var='music.song_name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" value="{value type='input' id='title'}" size="30" id="title" />
		</div>
	</div>
	
	<div class="table song_name">
		<div class="table_left">
			{phrase var='music.genre'}:
		</div>
		<div class="table_right">
			<select name="val[genre_id]">
				<option value="">{phrase var='music.select'}:</option>
			{foreach from=$aGenres item=aGenre}
				<option value="{$aGenre.genre_id}"{value type='select' id='genre_id' default=$aGenre.genre_id}>{$aGenre.name|convert}</option>
			{/foreach}
			</select>
		</div>
	</div>	
	
	{if isset($sModule) && $sModule}
	
	{else}	
	{if $bIsEdit && $aForms.album_id > 0}
	
	{else}
	{if !isset($bIsEditAlbum) && Phpfox::isModule('privacy')}
	<div id="js_song_privacy_holder">
		<div class="table">
			<div class="table_left">
				{phrase var='music.privacy'}:
			</div>
			<div class="table_right">	
				{module name='privacy.form' privacy_name='privacy' privacy_info='music.control_who_can_see_this_song' default_privacy='music.default_privacy_setting'}
			</div>			
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='music.comment_privacy'}:
			</div>
			<div class="table_right">	
				{module name='privacy.form' privacy_name='privacy_comment' privacy_info='music.control_who_can_comment_on_this_song' privacy_no_custom=true}
			</div>			
		</div>
	</div>
	{/if}
	{/if}
	{/if}
	
	{if !isset($bIsEditAlbum) && $bIsEdit}
	
	{else}	
	{if isset($sMethod) && $sMethod == 'massuploader'}
	<div class="table mass_uploader_table">
		<div id="swf_music_upload_button_holder">
			<div class="swf_upload_holder">
				<div id="swf_music_upload_button"></div>
			</div>
			
			<div class="swf_upload_text_holder">
				<div class="swf_upload_progress"></div>
				<div class="swf_upload_text">
					{phrase var='music.select_mp3'}
				</div>
			</div>				
		</div>
		<div class="extra_info">
			{phrase var='music.max_file_size'}: {$iUploadLimit}
		</div>			
	</div>
	<div class="mass_uploader_link">{phrase var='music.upload_problems_try_the_basic_uploader' url=$sMethodUrl}</div>	
	{else}	
	<div><input type="hidden" name="val[method]" value="simple" /></div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='music.select_mp3'}:
		</div>
		<div class="table_right">		
			<div id="js_progress_uploader"></div>
			<div class="extra_info">
				{phrase var='music.max_file_size'}: {$iUploadLimit}
			</div>		
		</div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='music.upload'}" class="button" />
	</div>
	{/if}
	{/if}
</div>