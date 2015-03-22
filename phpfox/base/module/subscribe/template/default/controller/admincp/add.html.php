<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 4554 2012-07-23 08:44:50Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.subscribe.add'}" enctype="multipart/form-data">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.package_id}" /></div>
{/if}
	<div class="table_header">
		{phrase var='subscribe.subscription_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='subscribe.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" id="title" value="{value id='title' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='subscribe.description'}:
		</div>
		<div class="table_right">
			<textarea cols="60" rows="10" name="val[description]" id="description" style="width:95%;">{value id='description' type='textarea'}</textarea>
			<div class="extra_info">
				{phrase var='subscribe.description_will_be_parsed_as_html'}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='subscribe.image'}:
		</div>
		<div class="table_right">
			{if $bIsEdit && !empty($aForms.image_path)} 
			<div id="js_subscribe_image_holder">
				{img server_id=$aForms.server_id title=$aForms.title path='subscribe.url_image' file=$aForms.image_path suffix='_120' max_width='120' max_height='120'}
				<div class="extra_info">
					<a href="#" onclick="if (confirm('{phrase var='subscribe.are_you_sure'}')) {left_curly} $('#js_subscribe_image_holder').remove(); $('#js_subscribe_upload_image').show(); $.ajaxCall('subscribe.deleteImage', 'package_id={$aForms.package_id}'); {right_curly} return false;">{phrase var='subscribe.change_this_image'}</a>
				</div>
			</div>
			{/if}
			<div id="js_subscribe_upload_image"{if $bIsEdit && !empty($aForms.image_path)} style="display:none;"{/if}>
				<input type="file" name="image" size="20" />
				<div class="extra_info">
					{phrase var='subscribe.you_can_upload_a_jpg_gif_or_png_file'}
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{required}{phrase var='subscribe.user_group_on_success'}:
		</div>
		<div class="table_right">
			<select name="val[user_group_id]" id="user_group_id">
				<option value="">{phrase var='subscribe.select'}:</option>
			{foreach from=$aUserGroups item=aUserGroup}
				<option value="{$aUserGroup.user_group_id}"{value type='select' id='user_group_id' default=$aUserGroup.user_group_id}>{$aUserGroup.title|convert|clean}</option>
			{/foreach}
			</select>
			<div class="extra_info">
				{phrase var='subscribe.once_a_user_successfully_purchased_the_package_they_will_be_moved_to_this_user_group'}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{required}{phrase var='subscribe.user_group_on_failure'}:
		</div>
		<div class="table_right">
			<select name="val[fail_user_group]" id="fail_user_group">
				<option value="">{phrase var='subscribe.select'}:</option>
			{foreach from=$aUserGroups item=aUserGroup}
				<option value="{$aUserGroup.user_group_id}"{value type='select' id='fail_user_group' default=$aUserGroup.user_group_id}>{$aUserGroup.title|convert|clean}</option>
			{/foreach}
			</select>
			<div class="extra_info">
				{phrase var='subscribe.once_a_user_cancels_or_fails_to_pay_their_subscription_they_will_be_moved_to_this_user_group'}
			</div>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='subscribe.add_to_registration'}:
		</div>
		<div class="table_right">		
			<div class="item_is_active_holder">
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_registration]" value="1" {value type='radio' id='is_registration' default='1'}/> {phrase var='subscribe.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_registration]" value="0" {value type='radio' id='is_registration' default='0' selected='true'}/> {phrase var='subscribe.no'}</span>
			</div>	
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='subscribe.is_active'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='subscribe.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='subscribe.no'}</span>
			</div>
		</div>
		<div class="clear"></div>		
	</div>		
	<div class="table_header">
		{phrase var='subscribe.subscription_costs'}
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.show_price'}:
		</div>
		<div class="table_right">
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[show_price]" value="1" {value type='radio' id='show_price' default='1' selected='true'}/> {phrase var='subscribe.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[show_price]" value="0" {value type='radio' id='show_price' default='0'}/> {phrase var='subscribe.no'}</span>
			</div>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='subscribe.price'}:
		</div>
		<div class="table_right">
			{module name='core.currency' currency_field_name='val[cost]'}
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='subscribe.recurring'}:
		</div>
		<div class="table_right">			
			<div class="item_is_active_holder">
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_recurring]" value="1" {value type='radio' id='is_recurring' default='1'}/> {phrase var='subscribe.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_recurring]" value="0" {value type='radio' id='is_recurring' default='0' selected='true'}/> {phrase var='subscribe.no'}</span>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="js_subscribe_is_recurring">
		<div class="table">
			<div class="table_left">
				{phrase var='subscribe.recurring_price'}:
			</div>
			<div class="table_right">
				{module name='core.currency' currency_field_name='val[recurring_cost]'}
			</div>
			<div class="clear"></div>
		</div>		
		<div class="table">
			<div class="table_left">
				{phrase var='subscribe.recurring_period'}:
			</div>
			<div class="table_right">
				<select name="val[recurring_period]" id="recurring_period">
					<option value="">{phrase var='subscribe.select'}:</option>
					<option value="1"{value type='select' id='recurring_period' default='1'}>{phrase var='subscribe.monthly'}</option>
					<option value="2"{value type='select' id='recurring_period' default='2'}>{phrase var='subscribe.quarterly'}</option>
					<option value="3"{value type='select' id='recurring_period' default='3'}>{phrase var='subscribe.biannualy'}</option>
					<option value="4"{value type='select' id='recurring_period' default='4'}>{phrase var='subscribe.annually'}</option>
				</select>
			</div>
			<div class="clear"></div>
		</div>	
	</div>
	
	<div class="js_background_color">
		<div class="table">
			<div class="table_left">
				{phrase var='subscribe.background_color_for_the_comparison_page'}:
			</div>
			<div class="table_right">
				<input type="text" name="val[background_color]" id="title" value="{value id='background_color' type='input'}" size="40" />
			</div>
		</div>
	</div>
	
	<div class="table_clear">
		<input type="submit" value="{phrase var='subscribe.submit'}" class="button" />
	</div>
</form>