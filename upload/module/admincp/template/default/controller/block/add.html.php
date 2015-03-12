<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: add.html.php 4622 2012-09-12 07:18:24Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{literal}
<script type="text/javascript">
<!--
	function changeBlockType(oObj)
	{
		$('.js_block_type').hide();
		$('.js_block_type_id_' + oObj.value).show();		
	}
-->
</script>
{/literal}
{$sCreateJs}
<form method="post" action="{url link="admincp.block.add"}" id="js_form" onsubmit="{$sGetJsForm}">
	{if $bIsEdit}
	<div><input type="hidden" name="block_id" value="{$aForms.block_id}" /></div>
	{/if}
	{if !Phpfox::getUserParam('admincp.can_view_product_options')}
	<div><input type="hidden" name="val[product_id]" value="1" /></div>
	{/if}	

	<div class="table_header">
		{phrase var='admincp.block_details'}
	</div>
	{if Phpfox::getUserParam('admincp.can_view_product_options')}
	{module name='admincp.product.form'}
	{/if}
	{module name='admincp.module.form' module_form_required=false}
	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" value="{value id='title' type='input'}" size="30" />
		</div>
	</div>	
	<div class="table"{if $bIsEdit} style="display:none;"{/if}>
		<div class="table_left">
			{phrase var='admincp.type'}:
		</div>
		<div class="table_right">
			<select name="val[type_id]" onchange="return changeBlockType(this);">
				<option value="0">{phrase var='admincp.select'}:</option>
				<option value="0"{value type='select' id='type_id' default='0'}>{phrase var='admincp.php_block_file'}</option>
				<option value="1"{value type='select' id='type_id' default='1'}>{phrase var='admincp.php_code'}</option>
				<option value="2"{value type='select' id='type_id' default='2'}>{phrase var='admincp.html_code'}</option>
			</select>
		</div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.controller'}:
		</div>
		<div class="table_right">
			<select name="val[m_connection]" id="m_connection">
			{if !$bIsEdit}
			<option value="">{phrase var='admincp.select'}:</option>
			{/if}
			<option value="">{phrase var='admincp.none_site_wide'}</option>
			{foreach from=$aControllers key=sName item=aController}
				<option value="{$sName}" style="font-weight:bold;"{value type='select' id='m_connection' default=$sName}>{$sName|translate:'module'}</option>
				{foreach from=$aController item=aCont}
					<option value="{$aCont.m_connection}"{value type='select' id='m_connection' default=$aCont.m_connection}>-- {$aCont.m_connection}</option>
				{/foreach}			
			{/foreach}
			</select>
			{help var='admincp.block_add_connection'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table js_block_type js_block_type_id_0"{if $bIsEdit && $aForms.type_id > 0} style="display:none;"{/if}>
		<div class="table_left">
			{phrase var='admincp.component'}:
		</div>
		<div class="table_right">
			<select name="val[component]" id="component">
			<option value="">{phrase var='admincp.select'}:</option>
			{foreach from=$aComponents key=sName item=aComponent}
				<option value="{$sName}" style="font-weight:bold;"{value type='select' id='m_connection' default=$sName}>{$sName|translate:'module'}</option>
				{foreach from=$aComponent item=aComp}
					<option value="{$sName}|{$aComp.component}"{value type='select' id='component' default=''$sName'|'$aComp.component''}>-- {$aComp.component}</option>
				{/foreach}
			{/foreach}
			</select>
			{help var='admincp.block_add_component'}
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.placement'}:
		</div>
		<div class="table_right">
			<select name="val[location]" id="location">	
				{for $i = 1; $i <= 13; $i++}
					<option value="{$i}"{value type='select' id='location' default=$i}>{phrase var='admincp.block' x=$i}</option>
				{/for}
			</select>{if Phpfox::getUserParam('theme.can_view_theme_sample')} <a href="#?call=theme.sample&amp;width=1300" class="inlinePopup" title="{phrase var='admincp.sample_layout'}">{phrase var='admincp.view_sample_layout'}</a>{/if}	
			{help var='admincp.block_add_placement'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table js_block_type js_block_type_id_0"{if $bIsEdit && $aForms.type_id > 0} style="display:none;"{/if}>
		<div class="table_left">
			{phrase var='admincp.can_drag_drop'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[can_move]" value="1"{value type='radio' id='can_move' default='1'}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[can_move]" value="0"{value type='radio' id='can_move' default='0' selected=true}/> {phrase var='admincp.no'}</label>			
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.active'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[is_active]" value="1"{value type='radio' id='is_active' default='1' selected=true}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[is_active]" value="0"{value type='radio' id='is_active' default='0'}/> {phrase var='admincp.no'}</label>
			{help var='admincp.block_add_active'}
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="js_block_type js_block_type_id_1 js_block_type_id_2"{if $bIsEdit && $aForms.type_id == 0} style="display:none;"{/if}>
		<div class="table_header">
			PHP/HTML Code (Optional)
		</div>
		<div class="table">
			<div class="table_span">
				<textarea name="val[source_code]" rows="20" cols="50" style="width:98%;" id="source_code">{value type='textarea' id='source_code'}</textarea>
			</div>
		</div>		
	</div>
	
	<div class="table_header">
		{phrase var='admincp.user_group_access'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.allow_access'}:
		</div>
		<div class="table_right">
		{foreach from=$aUserGroups item=aUserGroup}
			<div class="p_4">
				<label><input type="checkbox" name="val[allow_access][]" value="{$aUserGroup.user_group_id}"{if isset($aAccess) && is_array($aAccess)}{if !in_array($aUserGroup.user_group_id, $aAccess)} checked="checked" {/if}{else} checked="checked" {/if}/> {$aUserGroup.title|convert|clean}</label>
			</div>
		{/foreach}
			{help var='admincp.block_add_access'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='core.submit'}" class="button" />
	</div>
</form>