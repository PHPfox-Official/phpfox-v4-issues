<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 5387 2013-02-19 12:19:37Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='pages.category_details'}
</div>
<form method="post" action="{url link='admincp.pages.add'}">
	{if $bIsEdit}
	{if $bIsEdit && isset($aForms.category_id)}
	<div><input type="hidden" name="sub" value="{$iEditId}" /></div>
	{else}
	<div><input type="hidden" name="id" value="{$iEditId}" /></div>
	{/if}
	{/if}
	{if $bIsEdit && !isset($aForms.category_id)}{else}
	<div class="table">
		<div class="table_left">
			{phrase var='pages.parent_category'}:
		</div>
		<div class="table_right">
			<select name="val[type_id]" id="add_select">
				{if !$bIsEdit}
				<option value="0">{phrase var='pages.none'}</option>
				{/if}
				{foreach from=$aTypes item=aType}
				<option value="{$aType.type_id}"{value type='select' id='type_id' default=$aType.type_id}>{$aType.name|convert}</option>
				{/foreach}
			</select>
		</div>
		<div class="clear"></div>		
	</div>	
	{/if}
	<div class="table">
		<div class="table_left">
			{phrase var='pages.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value id='name' type='input'}" size="30" />
		</div>
		<div class="clear"></div>		
	</div>
	{if $bIsEdit && !isset($aForms.category_id)}{else}
	<div class="table" id="is_group" style="display: none;">
		<div class="table_left">
			{phrase var='pages.is_a_group'}
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[page_type]" value="1" {value type='radio' id='page_type' default='1'}/> {phrase var='pages.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[page_type]" value="0" {value type='radio' id='page_type' default='0' selected='true'}/> {phrase var='pages.no'}</span>
			</div>
			<div class="extra_info">
				{phrase var='pages.if_a_page_is_considered_a_group_it_will_require_users_to_become_members'}
			</div>
		</div>
		<div class="clear"></div>		
	</div>	
	{/if}
	<div class="table_clear">
		<input type="submit" value="{phrase var='pages.submit'}" class="button" />
	</div>
</form>