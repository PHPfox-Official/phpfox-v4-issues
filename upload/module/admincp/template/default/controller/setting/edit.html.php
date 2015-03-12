<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: edit.html.php 7128 2014-02-19 13:21:59Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aSettings)}
<div class="p_4 t_right">
{phrase var='admincp.quick_jump'}:
<select name="jump" class="goJump">
		<option value="">Select</option>
		<optgroup label="{phrase var='admincp.global_settings'}">
			{foreach from=$aGroups item=aGroup}
				<option value="{url link="admincp.setting.edit" group-id=""$aGroup.group_id""}"{if $sSettingTitle == $aGroup.var_name} selected="selected"{/if}>{$aGroup.var_name}</option>
			{/foreach}
		</optgroup>
		<optgroup label="{phrase var='admincp.module_settings'}">
			{foreach from=$aModules item=aModule}
				<option value="{url link="admincp.setting.edit" module-id=""$aModule.module_id""}"{if $sSettingTitle == $aModule.module_id} selected="selected"{/if}>{$aModule.module_id}</option>
			{/foreach}
		</optgroup>		
		{if count($aProductGroups)}		
		<optgroup label="{phrase var='admincp.product_settings'}">
			{foreach from=$aProductGroups item=aProductGroup}
				<option value="{url link="admincp.setting.edit" product-id=""$aProductGroup.product_id""}"{if strtolower($sSettingTitle) == $aProductGroup.product_id} selected="selected"{/if}>{$aProductGroup.var_name}</option>
			{/foreach}
		</optgroup>		
		{/if}	
</select>
</div>
{literal}
<script type="text/javascript">
<!--
function addInput(oObj, sVarName)
{
{/literal}
	var sValue = $(oObj).parents('.js_array_holder:first').find('.js_add_to_array').val();
	var iCnt = (parseInt($(oObj).parents('.js_array_holder:first').find('#js_array_count').html()) + 1);
	$(oObj).parents('.js_array_holder:first').find('.js_array_data').append('<div class="p_4" id="js_array' + iCnt + '"><input type="text" name="val[value][' + sVarName + '][]" value="' + sValue + '" size="30" /> - <a href="#" onclick="$(this).parent().remove(); return false;">{phrase var='admincp.remove' phpfox_squote=true}</a></div>');
	$(oObj).parents('.js_array_holder:first').find('.js_array_count').html(iCnt);
	$(oObj).parents('.js_array_holder:first').find('.js_add_to_array').val('').focus();
	
	return false;
{literal}
}
-->
</script>
{/literal}
<form method="post" action="{url link='current'}" enctype="multipart/form-data">
{foreach from=$aSettings item=aSetting}
<div id="{$aSetting.var_name}"></div>
<div class="table_header2">
	{if PHPFOX_DEBUG}<div class="go_left"> <input type="text" name="val[order][{$aSetting.var_name}]" value="{$aSetting.ordering}" style="font-size:9pt; padding:0px; text-align:center;" onclick="this.select();" size="2" /> {/if} <a name="#{$aSetting.var_name}" style="color:#333333">{$aSetting.setting_title}</a>{if PHPFOX_DEBUG}</div><div class="t_right">{if isset($aSetting.group_title)} ({$aSetting.group_title}) {/if}<input type="text" name="param{$aSetting.var_name}" value="{$aSetting.module_id}.{$aSetting.var_name}" style="font-size:9pt; padding:0px;" onclick="this.select();" /></div>{/if}
</div>
<div class="table3">
	<div class="row_left">
		{$aSetting.setting_info} 
	</div>
	<div class="row_right" style="margin-bottom:20px;">
		{if $aSetting.type_id == 'multi_text'}
		{foreach from=$aSetting.values key=mKey item=sDropValue}
		<div class="p_4">
			{$mKey}: <input type="text" name="val[value][{$aSetting.var_name}][{$mKey}]" value="{$sDropValue|clean}" size="8" />
		</div>
		{/foreach}
		{elseif $aSetting.type_id == 'large_string'}
		<textarea cols="60" rows="8" name="val[value][{$aSetting.var_name}]">{$aSetting.value_actual|htmlspecialchars}</textarea>
		{elseif ($aSetting.type_id == 'string')}
		<div><input type="text" name="val[value][{$aSetting.var_name}]" value="{$aSetting.value_actual|clean}" size="40" /></div>		
		{elseif ($aSetting.type_id == 'password')}
		<div><input type="password" name="val[value][{$aSetting.var_name}]" value="{$aSetting.value_actual}" size="40" /></div>				
		{elseif ($aSetting.type_id == 'drop')}
		<div><input type="hidden" name="val[value][{$aSetting.var_name}][real]" value="{$aSetting.value_actual}" size="40" /></div>
		<select name="val[value][{$aSetting.var_name}][value]">
		{foreach from=$aSetting.values.values key=mKey item=sDropValue}
			<option value="{$sDropValue}" {if $aSetting.values.default == $sDropValue}selected="selected"{/if}>
				{if !empty($sDropValue) && !stripos( $sDropValue, ' ') && !stripos($sDropValue, '.')}
					{php}{$this->_aVars['sDropValue'] = strtolower($this->_aVars['sDropValue']);}{/php}
					{phrase var=$aSetting.module_id'.'$sDropValue}
				{else}
					{$sDropValue}
				{/if}
			</option>
		{/foreach}
		</select>
		{elseif ($aSetting.type_id == 'drop_with_key')}
		<select name="val[value][{$aSetting.var_name}]">
		{foreach from=$aSetting.values key=mKey item=sDropValue}
			<option value="{$mKey}"{if $aSetting.value_actual == $mKey} selected="selected"{/if}>{$sDropValue}</option>
		{/foreach}
		</select>	
		{elseif ($aSetting.type_id == 'integer')}
		<input type="text" name="val[value][{$aSetting.var_name}]" value="{$aSetting.value_actual}" size="40" onclick="this.select();" />
		{elseif ($aSetting.type_id == 'boolean')}		
		<select name="val[value][{$aSetting.var_name}]">
			<option value="1" {if $aSetting.value_actual == 1}selected="selected"{/if}>{phrase var='admincp.true'}</option>
			<option value="0" {if $aSetting.value_actual != 1}selected="selected"{/if}>{phrase var='admincp.false'}</option>
		</select>
		{elseif ($aSetting.type_id == 'array')}
		<div class="js_array_holder">
			{if is_array($aSetting.value_actual)}
			{foreach from=$aSetting.value_actual key=iKey item=sValue}
				<div class="p_4" class="js_array{$iKey}"><input type="text" name="val[value][{$aSetting.var_name}][]" value="{$sValue}" size="30" /> - <a href="#" onclick="if (confirm('{phrase var='core.are_you_sure'}')) {left_curly} $.ajaxCall('admincp.removeSettingFromArray', 'setting={$aSetting.var_name}&amp;value={$sValue}'); $(this).parent().remove(); {right_curly} return false;">{phrase var='admincp.remove'}</a></div>
			{/foreach}		
			{/if}
			<div class="js_array_data"></div>
			<div class="js_array_count" style="display:none;">{if isset($iKey)}{$iKey+1}{/if}</div>
			<br />
			<div class="p_4">
				<input type="text" name="" value="{phrase var='admincp.add_a_new_value'}" onclick="if(this.value=='{phrase var='admincp.add_a_new_value' phpfox_squote=true}')this.value='';" onblur="if(this.value=='')this.value='{phrase var='admincp.add_a_new_value' phpfox_squote=true}';" size="30" class="js_add_to_array" /> <input type="button" value="{phrase var='admincp.add'}" class="button" onclick="return addInput(this, '{$aSetting.var_name}');" />
			</div>
		</div>
		{/if}
	</div>
	<div class="clear"></div>
</div>
{if $aSetting.var_name == 'watermark_option'}
<div class="table_header2">
	{phrase var='admincp.image'}
</div>
<div class="table3">
	<div class="row_left">		
		{phrase var='admincp.your_current_watermark_image'}:
		<div class="p_4">
			<img src="{$sWatermarkImage}" alt="Watermark Image" />
		</div>
		<div class="p_4">
			{phrase var='admincp.b_notice_b_advised_image_is_a_transparent_png_with_a_max_width_height_of_52_pixels'}
		</div>
	</div>
	<div class="row_right" style="margin-bottom:20px;">
		<input type="file" name="watermark" size="30" />
		<div class="extra_info">
			{phrase var='admincp.you_can_upload_a_jpg_gif_or_png_file'}
		</div>
	</div>
	<div class="clear"></div>
</div>
{/if}
{/foreach}
<div class="table_clear table_hover_action">
	<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
</div>
</form>
{else}
<p>{phrase var='admincp.setting_group_avaliable_settings'}</p>
{/if}
