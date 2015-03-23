<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{if !isset($aApp)}
<form action="{url link='apps.add'}" method="post" enctype="multipart/form-data">
	<div class="table">
		<div class="table_left">
			{phrase var='apps.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="app[name]" id="name" size="40" />
		</div>
	</div>
	
	<div class="table">
		<div class="table_left">
			{phrase var='apps.category'}:
		</div>
		<div class="table_right">
			<select name="app[category]">
				<option value="">{phrase var='apps.select'}:</option>
				{foreach from=$aCategories item=aCategory}
				<option value="{$aCategory.category_id}">{$aCategory.category_name|convert}</option>
				{/foreach}
			</select>
		</div>
	</div>	
	
	<div class="table_clear">
		<input type="submit" value="{phrase var='apps.submit'}" class="button">
	</div>
</form>
{else}
<form action="{url link='apps.add' id=$aApp.app_id}" method="post" enctype="multipart/form-data">
	<div><input type="hidden" name="val[app_id]" value="{$aApp.app_id}" /></div>
	<div id="js_apps_block_general" class="js_apps_block page_section_menu_holder">		
		
		<div class="table">
			<div class="table_left">
				{phrase var='apps.app_id'}:
			</div>
			<div class="table_right">
				{$aApp.public_key}
			</div>
		</div>		
		
		<div class="table">
			<div class="table_left">
				{phrase var='apps.title'}:
			</div>
			<div class="table_right">				
				<input type="text" name="val[title]" value="{value type='input' id='app_title'}" size="40" />
			</div>
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='apps.category'}:
			</div>
			<div class="table_right">
				<select name="val[category]">
					{foreach from=$aCategories item=aCategory}
						<option value="{$aCategory.category_id}" {if $aApp.category_id == $aCategory.category_id}selected="selected"{/if}>{$aCategory.category_name|convert}</option>
					{/foreach}
				</select>
			</div>
		</div>		
		<div class="table">
			<div class="table_left">
				{phrase var='apps.description'}:
			</div>
			<div class="table_right">				
				<textarea cols="40" rows="6" name="val[description]">{value type='textarea' id='app_description'}</textarea>
			</div>
		</div>		
		
		<div class="table">
			<div class="table_left">
				{phrase var='apps.will_your_app_be_on_this_site'}
			</div>
			<div class="table_right">				
				<div class="item_is_active_holder">		
					<span class="js_item_active item_is_active"><input type="radio" name="val[is_ext]" value="0" class="v_middle"{value type='radio' id='is_ext' default='0' selected='true'}/> {phrase var='apps.yes'}</span>
					<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_ext]" value="1" class="v_middle"{value type='radio' id='is_ext' default='1'}/> {phrase var='apps.no'}</span>
				</div>	
			</div>
		</div>			

	</div>

	<div id="js_apps_block_photo" class="js_apps_block page_section_menu_holder">
		<div class="table">
			<div class="table_left">
				{phrase var='apps.upload_new_picture'}:
			</div>
			<div class="right">
				{if !empty($aApp.image_path)}
				{img server_id=0 path='app.url_image' file=$aApp.image_path suffix='_square' max_width=75 max_height=75 title=$aApp.app_title} <br />
				{/if}
				<input type="file" name="image" />
			</div>
		</div>			
	</div>

	<div id="js_apps_block_url" class="js_apps_block page_section_menu_holder">
		<div class="table">
			<div class="table_left">
				{phrase var='apps.frame_url'}:
			</div>
			<div class="table_right">
				<input type="text" name="val[app_url]" value="{value type='input' id='app_url'}" size="80" />
				<div class="extra_info">
					{phrase var='apps.this_is_the_url_to_your_application'}
				</div>	
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='apps.return_url'}:
			</div>
			<div class="table_right">
				<input type="text" name="val[return_url]" value="{value type='input' id='return_url'}" size="80" />
				<div class="extra_info">
					{phrase var='apps.if_your_app_is_not_on_this_site_you_need_to_provide_return_url_for_authentication'}
				</div>	
			</div>
		</div>		
	</div>
	
	<div class="table_clear">
		<input type="submit" value="{phrase var='apps.update'}" class="button" />
	</div>
</form>
{/if}