<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.theme.template.add'}">
	<div class="table_header">
		{phrase var='theme.template_info'}
	</div>	
	{module name='admincp.product.form' product_form_required=false}
	{*module name='admincp.module.form' module_form_required=false*}
	<div class="table">
		<div class="table_left">
			{phrase var='theme.group'}:
		</div>
		<div class="table_right">
			<select name="val[group_id]">
				<option value="layout"{value id='group_id' type='select' default='layout'}>{phrase var='theme.global_template'}</option>
				<optgroup label="Module">
				{foreach from=$aModules item=sModule}
					<option value="{$sModule}"{value id='group_id' type='select' default=$sModule}>{$sModule}</option>
				{/foreach}
				</optgroup>
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='theme.file_name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value id='name' type='input'}" size="30" />.html
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='theme.theme'}:
		</div>
		<div class="table_right">
			<select name="val[folder]">
				<option value="">{phrase var='theme.select'}:</option>
				{foreach from=$aThemes item=aTheme}
				<option value="{$aTheme.folder}"{value id='folder' type='select' default=$aTheme.folder}>{$aTheme.name}</option>
				{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='theme.type'}:
		</div>
		<div class="table_right">
			<select name="val[type_id]">
				<option value="">{phrase var='theme.select'}:</option>
				<option value="block"{value id='type_id' type='select' default='block'}>{phrase var='theme.block'}</option>
				<option value="controller"{value id='type_id' type='select' default='controller'}>{phrase var='theme.controller'}</option>
			</select>
			<div class="extra_info">
				{phrase var='theme.required_only_for_modular_templates'}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='theme.creator'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[full_name]" value="{value id='full_name' type='input'}" size="30" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_header">
		{phrase var='theme.html'}
	</div>	
	<div class="table t_center p_4">
		<textarea cols="50" rows="20" name="val[html_data]" id="js_template_content" style="width:95%;">{value id='html_data' type='textarea'}</textarea>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='theme.submit'}" class="button" />
	</div>
</form>