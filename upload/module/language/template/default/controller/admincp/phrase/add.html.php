<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Language
 * @version 		$Id: add.html.php 1161 2009-10-09 07:42:41Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $sCachePhrase}
<div class="p_4">
	<div class="p_4">	
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.php'}</b>:</div>
		<div><input type="text" name="php" value="Phpfox::getPhrase('{$sCachePhrase}')" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>
	<div class="p_4">	
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.php_single_quoted'}</b>:</div>
		<div><input type="text" name="php" value="' . Phpfox::getPhrase('{$sCachePhrase}') . '" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>	
	<div class="p_4">	
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.php_double_quoted'}</b>:</div>
		<div><input type="text" name="php" value="&quot; . Phpfox::getPhrase('{$sCachePhrase}') . &quot;" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>		
	<div class="p_4">
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.html'}</b>:</div>
		<div><input type="text" name="html" value="{literal}{{/literal}phrase var='{$sCachePhrase}'{literal}}{/literal}" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>
	<div class="p_4">
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.js'}</b>:</div>
		<div><input type="text" name="html" value="oTranslations['{$sCachePhrase}']" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>	
	<div class="p_4">
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.text'}</b>:</div>
		<div><input type="text" name="html" value="{$sCachePhrase}" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>		
</div>
{/if}
{$sCreateJs}
<form method="post" action="{url link='admincp.language.phrase.add' last-module=$sLastModuleId}" id="js_phrase_form" onsubmit="{$sGetJsForm}">
{token}
{if $sReturn}
<div><input type="hidden" name="return" value="{$sReturn}" /></div>
{/if}
{if $sVar}
<div><input type="hidden" name="val[is_help]" value="true" /></div>
{/if}
<div class="table_header">
	{phrase var='language.phrase_form'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='language.product'}:
	</div>
	<div class="table_right">
		<select name="val[product_id]">
		{foreach from=$aProducts item=aProduct}
			<option value="{$aProduct.product_id}">{$aProduct.title}</option>
		{/foreach}
		</select>
		{help var='admincp.language_add_phrase_product'}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='language.module'}:
	</div>
	<div class="table_right">
		<select name="val[module]">
		{foreach from=$aModules key=sModule item=iModuleId}
			<option value="{$iModuleId}|{$sModule}"{if !empty($sLastModuleId) && $sLastModuleId == $sModule} selected="selected"{/if}>{$sModule}</option>
		{/foreach}
		</select>
		{help var='admincp.language_add_phrase_module'}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='language.varname'}:
	</div>
	<div class="table_right">
		<input type="text" name="val[var_name]" value="{$sVar}" size="40" id="var_name" maxlength="100" />
		{help var='admincp.language_add_phrase_varname'}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='language.text'}:
	</div>
	<div class="table_right_text">
	{foreach from=$aLanguages item=aLanguage}
		<b>{$aLanguage.title}</b>
		<div class="p_4">
			<textarea cols="50" rows="8" name="val[text][{$aLanguage.language_id}]"></textarea>
			{help var='admincp.language_add_phrase_text'}
		</div>
	{/foreach}
	</div>
	<div class="clear"></div>
</div>
<div class="table_clear">
	<input type="submit" value="{phrase var='core.submit'}" class="button" />
</div>
</form>