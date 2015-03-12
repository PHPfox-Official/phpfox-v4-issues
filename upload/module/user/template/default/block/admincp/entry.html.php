<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: entry.html.php 6891 2013-11-15 16:37:37Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div class="table">
		<div class="table_left">
		{required}{phrase var='user.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" value="{value type='input' id='title'}" size="40" maxlength="100" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='user.html_prefix'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[prefix]" value="{value type='input' id='prefix'}" size="20" maxlength="75" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='user.html_suffix'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[suffix]" value="{value type='input' id='suffix'}" size="20" maxlength="75" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='user.icon'}:
		</div>
		<div class="table_right">
			{if !empty($aForms.icon_ext)}
			<div id="js_group_icon">
				<div class="p_2">
					{img server_id=$aForms.server_id title=$aForms.title alt=$aForms.title file=$aForms.icon_ext path='core.url_icon'}
				</div>
				<div class="p_4">
					<a href="#" onclick="$('#js_group_upload_icon').show(); $('#js_group_icon').hide(); return false;">Change Icon</a>
				</div>
			</div>
			{/if}		
			<div id="js_group_upload_icon"{if !empty($aForms.icon_ext)} style="display:none;"{/if}>
				<input type="file" name="icon" size="30" />{if !empty($aForms.icon_ext)} - <a href="#" onclick="$('#js_group_upload_icon').hide(); $('#js_group_icon').show(); return false;">{phrase var='user.cancel'}</a>{/if}
				<div class="extra_info">
					{phrase var='user.you_can_upload_a_jpg_gif_or_png_file'}
					<br />
					{phrase var='user.the_advised_width_height_is_20_pixels'}
				</div>			
			</div>
		</div>
		<div class="clear"></div>
	</div>	
