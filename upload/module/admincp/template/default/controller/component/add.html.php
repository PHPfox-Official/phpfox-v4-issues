<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: add.html.php 1344 2009-12-21 19:50:14Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{$sCreateJs}

{literal}
<script type="text/javascript">
<!--
function doHideConnection(sValue)
{
	if(sValue == "2")
	{
		$('#url_connection').hide();

	}
	else
	{
		$('#url_connection').show();
	}
}
-->
</script>
{/literal}
<form method="post" action="{url link="admincp.component.add"}" id="js_form" onsubmit="{$sGetJsForm}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.component_id}" /></div>
{/if}
	<div class="table_header">
		{phrase var='admincp.component_details'}
	</div>
	{if Phpfox::getUserParam('admincp.can_view_product_options')}
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.product'}:
		</div>
		<div class="table_right">
			<select name="val[product_id]" id="product_id">
			{foreach from=$aProducts item=aProduct}
				<option value="{$aProduct.product_id}"{value type='select' id='product_id' default=$aProduct.product_id}>{$aProduct.title}</option>
			{/foreach}
			</select>
			{help var='admincp.component_add_product'}
		</div>
		<div class="clear"></div>
	</div>
	{/if}
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.module'}:
		</div>
		<div class="table_right">
			<select name="val[module_id]" id="module_id">
			{foreach from=$aModules key=sModule item=iModuleId}
				<option value="{$iModuleId}|{$sModule}"{value type='select' id='module_id' default=$iModuleId}>{translate var=$sModule prefix='module'}</option>
			{/foreach}
			</select>
			{help var='admincp.component_add_module'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.component'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[component]" id="component" value="{value type='input' id='component'}" size="30" />
			{help var='admincp.component_add_componen'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.type'}:
		</div>
		<div class="table_right">
			<select name="val[type]" id="type" onchange="doHideConnection(this.value);">
				<option value="">{phrase var='admincp.select'}</option>
				<option value="1"{value type='select' id='type' default='1'}>{phrase var='admincp.controller'}</option>
				<option value="2"{value type='select' id='type' default='2'}>{phrase var='admincp.block_actual'}</option>
			</select>
			{help var='admincp.component_add_type'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table" id="url_connection"{if $bIsEdit && $aForms.type == '2'} style="display:none;"{/if}>
		<div class="table_left">
			{phrase var='admincp.url_connection'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[m_connection]" id="m_connection" value="{value type='input' id='m_connection'}" size="30" />
			{help var='admincp.component_add_connection'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.active'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[is_active]" value="1"{value type='radio' id='is_active' default='1' selected=true}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[is_active]" value="0"{value type='radio' id='is_active' default='0'}/> {phrase var='admincp.no'}</label>
			{help var='admincp.component_add_active'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		{if Phpfox::getParam('core.display_required')}
		<div class="go_left">
			{required} {phrase var='core.required_fields'}
		</div>
		<div class="t_right">
			<input type="submit" value="{phrase var='core.submit'}" class="button" />
		</div>
		<div class="clear"></div>
		{else}
			<input type="submit" value="{phrase var='core.submit'}" class="button" />
		{/if}
	</div>
</form>