<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: album.html.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_actual_upload_form">
	{$sCreateJs}
	<form method="post" action="{url link='current'}" enctype="multipart/form-data">
		{if $bIsEdit}
		<div><input type="hidden" name="album_edit_id" value="{$aForms.album_id}" /></div>
		{/if}
		
		<div id="js_upload_music_detail" class="page_section_menu_holder">
			<div class="table">
				<div class="table_left">
					{required}{phrase var='music.name'}:
				</div>
				<div class="table_right">
					<input type="text" name="val[name]" size="30" value="{value type='input' id='name'}" id="name" />
				</div>
			</div>
			<div class="table">
				<div class="table_left">
					{required}{phrase var='music.year'}:
				</div>
				<div class="table_right">
					<input type="text" name="val[year]" size="4" value="{value type='input' id='year'}" id="year" maxlength="4" />
					<div class="extra_info">
						{phrase var='music.eg_1982'}
					</div>
				</div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='music.description'}:
				</div>
				<div class="table_right">
					<textarea cols="40" rows="6" name="val[text]" id="text" style="height:50px;">{value type='textarea' id='text'}</textarea>
				</div>
			</div>
			
			
				<div class="table">
					<div class="table_left">
						{phrase var='music.photo'}:
					</div>
					<div class="table_right">
						{if $bIsEdit && !empty($aForms.image_path)}
						<div id="js_music_current_image">
							{img server_id=$aForms.server_id path='music.url_image' file=$aForms.image_path suffix='_120' max_width='120' max_height='120'}
							<div class="extra_info">
								{phrase var='music.click_a_href_onclick_javascript_here_a_to_delete_this_image_and_upload_a_new_one_in_its_p' javascript=$sJavaScriptEditLink}
							</div>
						</div>
						{/if}
						<div id="js_music_upload_image"{if $bIsEdit && !empty($aForms.image_path)} style="display:none;"{/if}>							
							<input type="file" name="image" />
							<div class="extra_info">
								{phrase var='music.you_can_upload_a_jpg_gif_or_png_file'}
							</div>
						</div>
					</div>
				</div>							
			
			{if Phpfox::isModule('privacy')}
			<div{if $bIsEdit && !empty($aForms.module_id)} style="display:none;"{/if}>			
				<div class="table">
					<div class="table_left">
						{phrase var='music.privacy'}:
					</div>
					<div class="table_right">	
						{module name='privacy.form' privacy_name='privacy' privacy_info='music.control_who_can_see_this_album_and_any_songs_connected_to_it'}
					</div>			
				</div>

				<div class="table">
					<div class="table_left">
						{phrase var='music.comment_privacy'}:
					</div>
					<div class="table_right">	
						{module name='privacy.form' privacy_name='privacy_comment' privacy_info='music.control_who_can_comment_on_this_album' privacy_no_custom=true}
					</div>			
				</div>
			</div>
			{/if}
			
			<div class="table_clear">
				<input type="submit" value="{if $bIsEdit}{phrase var='music.update'}{else}{phrase var='music.submit'}{/if}" class="button" />
			</div>
		</div>		
	</form>
	
	<form method="post" action="{url link='music.upload'}" enctype="multipart/form-data" onsubmit="return startProcess({$sGetJsForm}, false);" id="js_album_form" target="js_upload_frame">
		<div><input type="hidden" name="val[iframe]" value="1" /></div>		
		<div id="js_upload_music_track" class="page_section_menu_holder" style="display:none;">
			{if (($bIsEdit && $aForms.user_id == Phpfox::getUserId() && Phpfox::getUserParam('music.can_edit_own_albums')) || !$bIsEdit)}
			<div>
				<div id="js_music_upload_song">
					{template file='music.block.upload'}		
				</div>
			</div>
			{/if}
		</div>
	</form>
</div>