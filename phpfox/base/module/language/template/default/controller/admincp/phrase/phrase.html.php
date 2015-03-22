<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Language
 * @version 		$Id: phrase.html.php 7195 2014-03-17 15:54:31Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link="admincp.language.phrase"}">
{token}
<div class="table_header">
	{phrase var='language.search_filter'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='language.search_for_text'}: 
	</div>
	<div class="table_right">
		{$aFilters.search}
		<div class="p_4">
		{phrase var='language.search'}...
			<div class="p_4">
				{$aFilters.search_type}
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<div id="js_admincp_search_options" style="display:none;">
	<div class="table">
		<div class="table_left">
			{phrase var='language.language_packages'}:
		</div>
		<div class="table_right">
			{$aFilters.language_id}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='language.phrases'}:
		</div>
		<div class="table_right">
			{$aFilters.translate_type}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='language.module'}:
		</div>
		<div class="table_right">
			{$aFilters.module_id}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='language.display'}: 
		</div>
		<div class="table_right">
			{$aFilters.display}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='language.sort'}: 
		</div>
		<div class="table_right">
			{$aFilters.sort} {$aFilters.sort_by}
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="table_clear">	
	<div class="table_clear_more_options">
		<a href="#" onclick="$('#js_admincp_search_options').toggle(); return false;">{phrase var='language.view_more_search_options'}</a>	
	</div>	
	<input type="submit" name="search[submit]" value="{phrase var='core.submit'}" class="button" />	
</div>
</form>

{if count($aRows)}
<br />
{pager}
<div class="table_header">
{phrase var='language.phrases'}
</div>
<form method="post" action="{if $bIsForceLanguagePackage}{url link='admincp.language.phrase' search-id=$sSearchIdNormal search-rid=$sSearchId page=$iPage lang-id=$iLangId}{else}{url link='admincp.language.phrase' search-id=$sSearchIdNormal search-rid=$sSearchId page=$iPage}{/if}">
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" /></th>
		<th style="width:20%;">{phrase var='language.variable'}</th>
		{if !$iLangId}<th style="width:10%;">{phrase var='language.language'}</th>{/if}
		<th style="width:30%;">{phrase var='language.original'}</th>
		<th style="width:90%;">{phrase var='language.text'}</th>
	</tr>
	{foreach from=$aRows key=iKey item=aRow}
	<tr id="js_row{$aRow.phrase_id}" class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td><input type="checkbox" name="id[]" class="checkbox" value="{$aRow.phrase_id}" id="js_id_row{$aRow.phrase_id}" /></td>
		<td title="{$aRow.name}.{$aRow.var_name}">
			<input type="text" name="null" value="{$aRow.name}.{$aRow.var_name}" size="25" style="width:95%;" onfocus="tb_show('{phrase var='language.phrase_variables' phpfox_squote=true}', $.ajaxBox('language.sample', 'height=240&width=600&phrase={$aRow.name}.{$aRow.var_name}'));" />					
		</td>
		{if !$iLangId}<td>{$aRow.title}</td>{/if}
		<td>{$aRow.sample_text}</td>
		<td class="t_center{if $aRow.is_translated} is_translated{/if}"><textarea cols="30" rows="6" name="text[{$aRow.phrase_id}]" class="text" style="width:95%;">{$aRow.text|htmlspecialchars}</textarea></td>
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom table_hover_action">	
		<input type="submit" name="save_selected" value="{phrase var='language.save_selected'}" class="button disabled sJsCheckBoxButton" disabled="true" />
		<input type="submit" name="delete" value="{phrase var='language.delete_selected'}" class="button sJsConfirm disabled sJsCheckBoxButton" disabled="true" />
		<input type="submit" name="revert_selected" value="{phrase var='language.revert_selected_default'}" class="button sJsConfirm disabled sJsCheckBoxButton" disabled="true" />
		<input type="submit" name="save" value="{phrase var='language.save_all'}" class="button" />
	</div>
</form>
<br />
{pager}
{else}
<div class="p_4 t_center">
	{phrase var='language.phrases_found'}
</div>
{/if}
