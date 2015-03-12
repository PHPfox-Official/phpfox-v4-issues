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
<script type="text/javascript">
<!--
{literal}
function isMenu(bNoSpeed)
{
	if ($('#js_select_menu').val() == '0')
	{
		$('#js_add_menu_div').hide((bNoSpeed ? '' : 'slow'));
		return true;
	}
	
	$('#js_add_menu_div').show((bNoSpeed ? '' : 'slow'));
	return true;
}
{/literal}
-->
</script>
{$sCreateJs}
<form method="post" action="{url link="admincp.module.add"}" id="js_form" onsubmit="{$sGetJsForm}">
{if $bIsEdit}
<div><input type="hidden" name="module_id" value="{$aForms.module_id}" /></div>
{/if}
<div class="table_header">
	{phrase var='admincp.module_details'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.product'}:
	</div>
	<div class="table_right">
		<select name="val[product_id]">
		{foreach from=$aProducts item=aProduct}
			<option value="{$aProduct.product_id}" {value type='select' id='product_id' default=$aProduct.product_id}>{$aProduct.title}</option>
		{/foreach}
		</select>
		{help var='admincp.module_add_product'}
	</div>
	<div class="clear"></div>
</div>
{if PHPFOX_DEBUG}
<div class="table">
	<div class="table_left">
		{phrase var='admincp.core_module'}:
	</div>
	<div class="table_right">
		<label><input type="radio" name="val[is_core]" style="vertical-align:bottom;" value="1" {value type='radio' id='is_core' default='1'} />{phrase var='admincp.yes'}</label>
		<label><input type="radio" name="val[is_core]" style="vertical-align:bottom;" value="0" {value type='radio' id='is_core' default='0' selected=true} />{phrase var='admincp.no'}</label>
		{help var='admincp.module_add_core'}
	</div>
	<div class="clear"></div>
</div>
{/if}
<div class="table">
	<div class="table_left">
		{phrase var='admincp.module_id'}:
	</div>
	<div class="table_right">
	{if $bIsEdit}
		<div><input type="hidden" name="val[module_id]" value="{value type='input' id='module_id'}" size="40" id="name" maxlength="75" /></div>
		{$aForms.module_id|translate:'module'}
	{else}
		<input type="text" name="val[module_id]" value="{value type='input' id='module_id'}" size="40" id="name" maxlength="75" />	
		{help var='admincp.module_add_name'}
	{/if}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.add_menu'}:
	</div>
	<div class="table_right">
		<select name="val[is_menu]" id="js_select_menu" onchange="isMenu();">
			<option value="1" {value type='select' id='is_menu' default=1}>{phrase var='admincp.yes'}</option>
			<option value="0" {value type='select' id='is_menu' default=0}>{phrase var='admincp.no'}</option>
		</select>
		{help var='admincp.module_add_is_menu'}
	</div>
	<div class="clear"></div>
</div>
<div class="table" id="js_add_menu_div">
	<div class="table_left">
		{phrase var='admincp.sub_menu'}:
	</div>
	<div class="table_right">
		<script type="text/javascript">
		<!--
		function addMore()
		{literal}{{/literal}
			var iCnt = (parseInt($('#js_add_more_count').html()) + 1);
			var sHtml = '<div class="p_4" id="js_new_content' + iCnt + '">{phrase var='admincp.phrase'}: <input type="text" name="val[menu][' + iCnt + '][phrase]" value="" /> {phrase var='admincp.link'}: <input type="text" name="val[menu][' + iCnt + '][link]" value="" /> [ <a href="#" onclick="$(\\'#js_new_content' + iCnt + '\\').html(\\'\\'); return false;">{phrase var='admincp.remove'}</a> ]</div>';
			$('#js_add_more_div').append(sHtml);
			$('#js_add_more_count').html(iCnt);
			return false;
		{literal}}{/literal}
		-->
		</script>
		{for $i = 0; $i <= $iMenus; $i++}		
		{if $bIsEdit && isset($aMenus[$i].var_name)}
		<div id="jsmenu_{$aMenus[$i].var_name}">
		 <input type="hidden" name="val[menu][{$i}][phrase_var]" value="{$aMenus[$i].var_name}" />
		{/if}
		<div class="p_4">{phrase var='admincp.phrase'}: <input type="text" name="val[menu][{$i}][phrase]" value="{if isset($aMenus[$i].phrase)}{$aMenus[$i].phrase|clean}{/if}" /> {phrase var='admincp.link'}: <input type="text" name="val[menu][{$i}][link]" value="{if isset($aMenus[$i].phrase)}{$aMenus[$i].link|clean}{/if}" />{if $bIsEdit && isset($aMenus[$i].var_name)} <a href="#?call=admincp.module.deleteMenu&amp;var={$aMenus[$i].var_name}&amp;id={$aForms.module_id}" class="delete_link">{phrase var='admincp.delete'}</a>{/if}</div>
		{if $bIsEdit && isset($aMenus[$i].var_name)}
		</div>
		{/if}
		{/for}		
		<div id="js_add_more_div"></div>
		<div id="js_add_more_count" style="display:none;">{$iMenus}</div>
		<div class="p_4" style="padding-left:50px;">
			<a href="#" onclick="return addMore();">{phrase var='admincp.add_more'}</a>
		</div>
		{help var='admincp.module_add_menu'}
	</div>
	<div class="clear"></div>
</div>
<div class="table_header">
	{phrase var='admincp.language_package_details'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='admincp.info'}:
	</div>
	<div class="table_right_text">
		{foreach from=$aLanguages item=aLanguage}
		<b>{$aLanguage.title}</b>
		<div class="p_4">
			<textarea cols="50" rows="5" name="val[text][{$aLanguage.language_id}]">{if isset($aLanguage.text)}{$aLanguage.text}{/if}</textarea>
		</div>
		{/foreach}
		{if $bIsEdit && PHPFOX_DEVELOPER}
		<div class="p_4">
			{phrase var='admincp.overwrite_default_data'}: <label><input type="checkbox" name="val[text_default]" value="1" style="vertical-align:middle;" />{phrase var='admincp.yes'}</label>
		</div>
		{/if}
		{help var='admincp.module_add_info'}
	</div>
	<div class="clear"></div>
</div>
<div class="table_clear">
	<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
</div>
</form>
<script type="text/javascript">
	isMenu(true);
</script>