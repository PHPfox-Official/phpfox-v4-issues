<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: add.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link="admincp.setting.group.add"}" id="js_setting_form" onsubmit="{$sGetJsForm}">
	<div class="table_header">
		{phrase var='admincp.group_information'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.product'}:
		</div>
		<div class="table_right">
			<select name="val[product_id]">
			{foreach from=$aProducts item=aProduct}
				<option value="{$aProduct.product_id}">{$aProduct.title}</option>
			{/foreach}
			</select>
			{help var='admincp.setting_group_add_product'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.module'}:
		</div>
		<div class="table_right">
			<select name="val[module_id]">
				<option value="">{phrase var='admincp.select'}:</option>
				{foreach from=$aModules key=sModule item=iModuleId}
					<option value="{$iModuleId}" {value type='select' id='module_id' default=$iModuleId}>{$sModule}</option>
				{/foreach}
			</select>		
			{help var='admincp.setting_add_group_module_id'}
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[var_name]" value="{value type='input' id='var_name'}" size="40" id="var_name" maxlength="75" />
			{help var='admincp.setting_group_add_product'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.info'}:
		</div>
		<div class="table_right_text">
			<textarea cols="50" rows="8" name="val[info]" id="info">{value type='textarea' id='info'}</textarea>
			{help var='admincp.setting_group_add_info'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
	</div>
</form>