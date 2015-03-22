<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: setting.html.php 1339 2009-12-19 00:37:55Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $sCacheSetting}
<div class="p_4">
	<div class="p_4">	
		<div class="go_left t_right" style="width:34px;"><b>{phrase var='user.php'}</b>:</div>
		<div><input type="text" name="php" value="Phpfox::getUserParam('{$sCacheSetting}')" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>
</div>
{/if}
{$sCreateJs}
<form method="post" action="{url link="admincp.user.group.setting"}" id="js_form" onsubmit="{$sGetJsForm}">
{token}
{if isset($aForms.setting_id)}
<div><input type="hidden" name="id" value="{$aForms.setting_id}" /></div>
{/if}
{if $iGroupId}
<div><input type="hidden" name="gid" value="{$iGroupId}" /></div>
{/if}
<div class="table_header">
	{phrase var='user.setting_details'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='user.product'}:
	</div>
	<div class="table_right">
		<select name="val[product_id]">
		{foreach from=$aProducts item=aProduct}
			<option value="{$aProduct.product_id}"{value type='select' id='product_id' default=$aProduct.product_id}>{$aProduct.title}</option>
		{/foreach}
		</select>
		{help var='admincp.user_add_setting_product'}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='user.module'}:
	</div>
	<div class="table_right">
		<select name="val[module]">
		{foreach from=$aModules key=sModule item=iModuleId}
			<option value="{$iModuleId}|{$sModule}"{value type='select' id='module' default=''$iModuleId'|'$sModule''}>{$sModule}</option>
		{/foreach}
		</select>
		{help var='admincp.user_add_setting_module'}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='user.varname'}:
	</div>
	<div class="table_right">
		<input type="text" name="val[name]" value="{value type='input' id='name'}" size="40" id="name" maxlength="250" />
		{help var='admincp.user_add_setting_name'}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='user.type'}:
	</div>
	<div class="table_right">
		<select name="val[type]">
		{foreach from=$aTypes item=sType}
			<option value="{$sType}"{value type='select' id='type' default=$sType}>{$sType}</option>
		{/foreach}
		</select>
		{help var='admincp.user_add_setting_type'}
	</div>
	<div class="clear"></div>
</div>
<div class="table_header">
	{phrase var='user.user_group_values'}
</div>
{foreach from=$aUserGroups item=aUserGroup}
<div class="table">
	<div class="table_left">
		{$aUserGroup.title|convert|clean}:
	</div>
	<div class="table_right">
		<input type="text" name="val[user_group][{$aUserGroup.user_group_id}]" value="{if isset($aUserGroup.value)}{$aUserGroup.value}{/if}" size="40" />
		{help var='admincp.user_add_setting_value'}
	</div>
	<div class="clear"></div>
</div>
{/foreach}
<div class="table_header">
	{phrase var='user.language_package_details'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='user.info'}:
	</div>
	<div class="table_right">
	{foreach from=$aLanguages item=aLanguage}
		<b>{$aLanguage.title}</b>
		<div class="p_4">
			<textarea cols="50" rows="5" name="val[text][{$aLanguage.language_id}]">{if isset($aLanguage.text)}{$aLanguage.text}{/if}</textarea>
		</div>
	{/foreach}
		{help var='admincp.user_add_setting_info'}
	</div>
	<div class="clear"></div>
</div>
<div class="table_clear">
	<input type="submit" value="{phrase var='core.submit'}" class="button" />
</div>
</form>