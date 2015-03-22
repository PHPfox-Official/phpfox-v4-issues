<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: form.html.php 5477 2013-03-11 07:15:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
		{if isset($aForms.view_id) && $aForms.view_id == 1}
		<div class="message" style="width:85%;">
			{phrase var='photo.image_is_pending_approval'}
		</div>
		{/if}
		{if isset($aForms.server_id)}
		<div><input type="hidden" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[server_id]" value="{$aForms.server_id}" /></div>
		{/if}
		<div class="table">
			<div class="table_left">
				<label for="title">{phrase var='photo.title'}</label>:
			</div>
			<div class="table_right">
				<input type="text" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[title]" value="{if isset($aForms.title)}{$aForms.title|clean}{else}{value type='input' id='title'}{/if}" size="30" maxlength="150" onfocus="this.select();" />
			</div>			
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='photo.description'}:
			</div>
			<div class="table_right">
				<textarea cols="30" rows="4" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[description]">{if isset($aForms.description)}{$aForms.description|clean}{else}{value type='input' id='description'}{/if}</textarea>
			</div>			
		</div>		
		
		{if isset($aForms.group_id) && $aForms.group_id != '0'}
		
		{else}
		{if Phpfox::getService('photo.category')->hasCategories()}
		<div class="table">
			<div class="table_left">
				{phrase var='photo.category'}:
			</div>
			<div class="table_right js_category_list_holder">
				{if isset($aForms.photo_id)}<div class="js_photo_item_id" style="display:none;">{$aForms.photo_id}</div>{/if}				
				{if isset($aForms.category_list)}<div class="js_photo_active_items" style="display:none;">{$aForms.category_list}</div>{/if}
				{module name='photo.drop-down'}
			</div>			
		</div>	
		{/if}
		{/if}
	
		{if isset($aForms.group_id) && $aForms.group_id != '0'}
		
		{else}		
			{if Phpfox::isModule('tag') && Phpfox::getUserParam('photo.can_add_tags_on_photos')}{if isset($aForms.photo_id)}{module name='tag.add' sType='photo' separate=false id=$aForms.photo_id}{else}{module name='tag.add' sType='photo' separate=false}{/if}{/if}
		{/if}
			{if Phpfox::getUserParam('photo.can_add_mature_images')}
			<div class="table">
				<div class="table_left">
					{phrase var='photo.mature_content'}:
				</div>
				<div class="table_right">
					<label><input type="radio" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[mature]" value="2" style="vertical-align:middle;" class="checkbox"{value type='radio' id='mature' default='2'}/> {phrase var='photo.yes_strict'}</label>
					<label><input type="radio" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[mature]" value="1" style="vertical-align:middle;" class="checkbox"{value type='radio' id='mature' default='1'}/> {phrase var='photo.yes_warning'}</label>
					<label><input type="radio" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[mature]" value="0" style="vertical-align:middle;" class="checkbox"{value type='radio' id='mature' default='0' selected=true}/> {phrase var='photo.no'}</label>
				</div>			
			</div>
			{/if}
			
			{if Phpfox::getParam('photo.can_rate_on_photos') && Phpfox::getUserParam('photo.can_add_to_rating_module')}
			<div class="table js_public_rating">
				<div class="table_left">
					{phrase var='photo.public_rating'}:
				</div>
				<div class="table_right">
					<label><input type="radio" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[allow_rate]" value="1" style="vertical-align:middle;" class="checkbox"{value type='radio' id='allow_rate' default='1' selected=true}/> {phrase var='photo.yes'}</label>
					<label><input type="radio" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[allow_rate]" value="0" style="vertical-align:middle;" class="checkbox"{value type='radio' id='allow_rate' default='0'}/> {phrase var='photo.no'}</label>				
				</div>
			</div>
			{/if}			
			
			<div class="table">
				<div class="table_left">
					{phrase var='photo.download_enabled'}:
				</div>
				<div class="table_right">
					<label><input type="radio" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[allow_download]" value="1" style="vertical-align:middle;" class="checkbox"{value type='radio' id='allow_download' default='1' selected=true}/> {phrase var='photo.yes'}</label>
					<label><input type="radio" name="val{if isset($aForms.photo_id)}[{$aForms.photo_id}]{/if}[allow_download]" value="0" style="vertical-align:middle;" class="checkbox"{value type='radio' id='allow_download' default='0'}/> {phrase var='photo.no'}</label>
					<div class="extra_info">
						{phrase var='photo.enabling_this_option_will_allow_others_the_rights_to_download_this_photo'}
					</div>				
				</div>
			</div>