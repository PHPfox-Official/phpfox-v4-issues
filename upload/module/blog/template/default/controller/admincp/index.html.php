<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: index.html.php 3072 2011-09-12 13:23:50Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

<form method="post" action="{url link="admincp.blog"}">
<div class="table_header">
	{phrase var='blog.search_filter'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='blog.search_for_text'}: 
	</div>
	<div class="table_right">
		{$aFilters.search}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='blog.search_for_user'}: 
	</div>
	<div class="table_right">
		{$aFilters.user}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='blog.created_user'}: 
	</div>
	<div class="table_right">
		{$aFilters.created_by}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='blog.display'}: 
	</div>
	<div class="table_right">
		{$aFilters.display}
	</div>
	<div class="clear"></div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='blog.sort'}: 
	</div>
	<div class="table_right">
		{$aFilters.sort} {$aFilters.sort_by}
	</div>
	<div class="clear"></div>
</div>
<div class="table_clear">
	<input type="submit" name="search[submit]" value="{phrase var='core.submit'}" class="button" />
	<input type="submit" name="search[reset]" value="{phrase var='core.reset'}" class="button" />	
</div>
</form>
{pager}
{if count($aCategories)}
{module name='help.info' phrase='blog.tip_delete_category'}
<form method="post" action="{url link='admincp.blog'}">
	<table>
	<tr>
		<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
		<th>{phrase var='blog.name'}</th>
		<th>{phrase var='blog.created_user'}</th>
		<th>{phrase var='blog.created'}</th>
		<th>{phrase var='blog.total_blogs'}</th>
	</tr>
	{foreach from=$aCategories key=iKey item=aCategory}
	<tr id="js_row{$aCategory.category_id}" class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td><input type="checkbox" name="id[]" class="checkbox" value="{$aCategory.category_id}" id="js_id_row{$aCategory.category_id}" /></td>
		<td id="js_blog_edit_title{$aCategory.category_id}"><a href="#?type=input&amp;id=js_blog_edit_title{$aCategory.category_id}&amp;content=js_category{$aCategory.category_id}&amp;call=blog.updateCategory&amp;category_id={$aCategory.category_id}&amp;user_id={$aCategory.user_id}" class="quickEdit" id="js_category{$aCategory.category_id}">{$aCategory.name|convert|clean}</a></td>
		<td>{if $aCategory.user_name}{$aCategory|user}{else}{phrase var='blog.system'}{/if}</td>
		<td>{$aCategory.added|date:'core.global_update_time'}</td>
		<td>{if $aCategory.used > 0}<a href="{$aCategory.link}" id="js_category_link{$aCategory.category_id}">{$aCategory.used}</a>{else}{phrase var='blog.none'}{/if}</td>
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" name="delete" value="{phrase var='blog.delete_selected'}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" />
	</div>
	{else}
	<div class="p_4">
		{phrase var='blog.no_blog_categories_have_been_created'} <a href="{url link='admincp.blog.add'}">{phrase var='blog.create_one_now'}</a>.
	</div>
	{/if}
</form>

{pager}