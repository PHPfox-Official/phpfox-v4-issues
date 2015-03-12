<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.share.add'}" enctype="multipart/form-data">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.site_id}" /></div>
{/if}
	<div class="table_header">
		{phrase var='share.site_info'}
	</div>
	<div class="table">
		<div class="table_left">
		{required}{phrase var='share.type'}:
		</div>
		<div class="table_right">
			<select name="val[type_id]">
				<option value="">{phrase var='share.select'}:</option>
				<option value="bookmark"{value id='type_id'] type='select' default='bookmark'}>{phrase var='share.bookmark'}</option>
				<option value="post"{value id='type_id'] type='select' default='post'}>{phrase var='share.post'}</option>
			</select>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
		{required}{phrase var='share.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" value="{value id='title' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
		{required}{phrase var='share.url'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[url]" value="{value id='url' type='input'}" size="40" style="width:95%;" />
			<div class="extra_info">
				{phrase var='share.you_can_pass_a_title_and_url_string_by_adding_the_following_replacements_br_url_url_of_the_item_br_title_title_of_the_item'}				
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
		{required}{phrase var='share.icon'}:
		</div>
		<div class="table_right">
		{if $bIsEdit}
			<div id="js_current_pic">
				<img src="{param var='share.url_image'}{$aForms.icon}" alt="{$aForms.title|clean}" />
				<div class="extra_info">
					<a href="#" onclick="$('#js_change_pic').show(); $('#js_current_pic').hide(); return false;">{phrase var='share.click_here_to_change_this_icon'}</a>
				</div>
			</div>
		{/if}
			<div id="js_change_pic"{if $bIsEdit} style="display:none;"{/if}>
				<input type="file" name="icon" size="30" />{if $bIsEdit} - <a href="#" onclick="$('#js_change_pic').hide(); $('#js_current_pic').show(); return false;">{phrase var='share.cancel'}</a>{/if}
				<div class="extra_info">
					{phrase var='share.you_can_upload_a_jpg_gif_or_png_file_br_advised_size_is_16x16_pixels'}
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{required}{phrase var='share.is_active'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='share.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='share.no'}</span>
			</div>
		</div>
		<div class="clear"></div>		
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='share.submit'}" class="button" />
	</div>
</form>