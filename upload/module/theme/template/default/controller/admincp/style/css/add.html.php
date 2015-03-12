<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.theme.style.css.add'}">
	<div class="table_header">
		{phrase var='theme.css_details'}
	</div>
	{module name='admincp.product.form'}
	{module name='admincp.module.form' module_form_required=false}
	<div class="table">
		<div class="table_left">
			{required}{phrase var='theme.style'}:
		</div>
		<div class="table_right">
			<select name="val[style_id]">
				<option value="">{phrase var='theme.select'}:</option>
			{foreach from=$aStyles item=aStyle}
				<option value="{$aStyle.style_id}"{value id='style_id' type='select' default=$aStyle.style_id}>{$aStyle.name}</option>
			{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='theme.file_name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[file_name]" value="{value id='file_name' type='input'}" />.css
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='theme.creator'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[full_name]" value="{value id='full_name' type='input'}" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_header">
		{phrase var='theme.css'}
	</div>	
	<div class="table t_center p_4">
		<textarea cols="50" rows="20" name="val[css_data]" id="js_template_content" style="width:95%;">{value id='css_data' type='textarea'}</textarea>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='theme.submit'}" class="button" />
	</div>
</form>