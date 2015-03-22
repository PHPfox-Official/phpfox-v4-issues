<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Page
 * @version 		$Id: add.html.php 2847 2011-08-19 07:47:27Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link='admincp.page.add'}" id="js_form" onsubmit="{$sGetJsForm}">
	<div><input type="hidden" name="val[attachment]" id="js_attachment" value="{value type='input' id='attachment'}" /></div>
	{if $bIsEdit}
	<div><input type="hidden" name="page_id" value="{$aForms.page_id}" /></div>
	<div><input type="hidden" name="val[old_url]" value="{$aForms.title_url}" /></div>
	<div><input type="hidden" name="val[add_menu]" value="0" /></div>
	<div><input type="hidden" name="val[menu_id]" value="{$aForms.menu_id}" /></div>	
	{/if}
	<div class="table_header">
		{phrase var='page.details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.product'}:
		</div>
		<div class="table_right">
			<select name="val[product_id]">
			{foreach from=$aProducts item=aProduct}
				<option value="{$aProduct.product_id}"{value type='select' id='product_id' default=$aProduct.product_id}>{$aProduct.title}</option>
			{/foreach}
			</select>
			{help var='admincp.page_add_product'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.module'}:
		</div>
		<div class="table_right">
			<select name="val[module_id]">
				<option value="">{phrase var='page.select'}:</option>
			{foreach from=$aModules item=sModule}
				<option value="{$sModule}"{value type='select' id='module_id' default=$sModule}>{$sModule}</option>
			{/foreach}
			</select>
			{help var='admincp.page_add_product'}
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='page.page_title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" id="title" value="{value type='input' id='title'}" size="40" onblur="if ($('#title_url').val() == '' && this.value != '') $.ajaxCall('page.admincp.addUrl', 'title=' + this.value);" tabindex="1" />
			<div class="p_4">
				{phrase var='page.phrase_from_language_package'}
				<label><input type="radio" name="val[is_phrase]" id="is_phrase" value="1"{value type='radio' id='is_phrase' default='1'}/> {phrase var='admincp.yes'}</label>
				<label><input type="radio" name="val[is_phrase]" id="is_phrase" value="0"{value type='radio' id='is_phrase' default='0' selected=true}/> {phrase var='admincp.no'}</label>
			</div>
			{help var='admincp.page_add_title'}
		</div>
		<div class="clear"></div>
	</div>
	<div id="js_url_table" class="table"{if !$bIsEdit && !$bFormIsPosted} style="display:none;"{/if}>
		<div class="table_left">
			{phrase var='page.url_title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title_url]" id="title_url" value="{value type='input' id='title_url'}" size="40" />
			{help var='admincp.page_add_title_url'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.meta_keywords'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[keyword]" id="keyword" value="{value type='input' id='keyword'}" size="40" tabindex="2" />
			{help var='admincp.page_add_keyword'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.meta_description'}:
		</div>
		<div class="table_right">
			<textarea cols="35" rows="6" name="val[description]" id="description">{value type='textarea' id='description'}</textarea>
			{help var='admincp.page_add_description'}
		</div>
		<div class="clear"></div>
	</div>
	
	{if Phpfox::isModule('tag')}{module name='tag.add' sType='page' separate=false}{/if}
	
	<div class="table_header">
		{phrase var='page.options'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.active'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[is_active]" value="1"{value type='radio' id='is_active' default='1' selected=true}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[is_active]" value="0"{value type='radio' id='is_active' default='0'}/> {phrase var='admincp.no'}</label>
			{help var='admincp.page_add_is_active'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.use_entire_page'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[full_size]" value="1"{value type='radio' id='full_size' default='1' selected=true}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[full_size]" value="0"{value type='radio' id='full_size' default='0'}/> {phrase var='admincp.no'}</label>
			{help var='admincp.page_add_full_size'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.add_bookmark_links'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[has_bookmark]" value="1"{value type='radio' id='has_bookmark' default='1' selected=true}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[has_bookmark]" value="0"{value type='radio' id='has_bookmark' default='0'}/> {phrase var='admincp.no'}</label>
			{help var='admincp.page_add_bookmark'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.add_page_views'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[add_view]" value="1"{value type='radio' id='add_view' default='1'}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[add_view]" value="0"{value type='radio' id='add_view' default='0' selected=true}/> {phrase var='admincp.no'}</label>
			{help var='admincp.page_add_view'}
		</div>
		<div class="clear"></div>
	</div>
	{if !$bIsEdit}
	<div class="table">
		<div class="table_left">
			{phrase var='page.add_menu'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[add_menu]" value="1"{value type='radio' id='add_menu' default='1' selected=true}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[add_menu]" value="0"{value type='radio' id='add_menu' default='0'}/> {phrase var='admincp.no'}</label>
			{help var='admincp.page_add_menu'}
		</div>
		<div class="clear"></div>
	</div>
	{/if}
	<div class="table_header">
		{phrase var='admincp.user_group_access'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='page.allow_access'}:
		</div>
		<div class="table_right">
		{foreach from=$aUserGroups item=aUserGroup}
			<div class="p_4">
				<label><input type="checkbox" name="val[allow_access][]" value="{$aUserGroup.user_group_id}"{if isset($aAccess) && is_array($aAccess)}{if !in_array($aUserGroup.user_group_id, $aAccess)} checked="checked" {/if}{else} checked="checked" {/if}/> {$aUserGroup.title|convert|clean}</label>
			</div>
		{/foreach}
			{help var='admincp.page_add_access'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_header">
		{phrase var='page.page_data'}
	</div>
	<div class="table">
		<div class="table_span">
			{editor id='text' rows='20'}
			{plugin call='page.template_controller_admincp_add_editor'}
			<div class="p_4">			
				Parser: 
					<label><input type="checkbox" name="val[parse_bbcode]" value="1" checked="checked" class="v_middle" /> {phrase var='page.bbcode'}</label>
					<label><input type="checkbox" name="val[parse_emoticons]" value="1" checked="checked" class="v_middle" /> {phrase var='page.emoticons'}</label>
					<label><input type="checkbox" name="val[parse_breaks]" value="1" checked="checked" class="v_middle" /> {phrase var='page.add_smart_breaks'}</label>
					<label><input type="checkbox" name="val[parse_php]" value="1" checked="checked" class="v_middle" /> {phrase var='page.php'}</label>
			</div>
			{help var='admincp.page_add_data'}
		</div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='core.submit'}" class="button" />
</div>
</form>