<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 7121 2014-02-18 13:57:28Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.api.gateway.add'}">
	<div><input type="hidden" name="id" value="{$aForms.gateway_id}" /></div>	
	<div class="table_header">
		{phrase var='api.gateway_details'}
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='api.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" id="title" value="{value type='input' id='title'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='api.description'}:
		</div>
		<div class="table_right">
			<textarea cols="50" rows="6" name="val[description]" id="description">{value type='textarea' id='description'}</textarea>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.active'}:
		</div>
		<div class="table_right">
			<div class="item_is_active_holder">
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='admincp.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='admincp.no'}</span>
			</div>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='api.test_mode'}:
		</div>
		<div class="table_right">
			<div class="item_is_active_holder">
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_test]" value="1" {value type='radio' id='is_test' default='1' selected='true'}/> {phrase var='admincp.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_test]" value="0" {value type='radio' id='is_test' default='0'}/> {phrase var='admincp.no'}</span>
			</div>
		</div>
		<div class="clear"></div>
	</div>		
	{if is_array($aForms.custom)}
	{foreach from=$aForms.custom key=sFormField item=aCustom}
	<div class="table">
		<div class="table_left">
			{$aCustom.phrase}:
		</div>
		<div class="table_right">
			{if (isset($aCustom.type) && $aCustom.type == 'textarea')}
				<textarea name="val[setting][{$sFormField}]" cols="50" rows="8">{$aCustom.value|clean}</textarea>
			{else}
				<input type="text" name="val[setting][{$sFormField}]" id="title" value="{$aCustom.value|clean}" size="40" />
			{/if}
			{if !empty($aCustom.phrase_info)}
			<div class="extra_info">
				{$aCustom.phrase_info}
			</div>
			{/if}
		</div>
		<div class="clear"></div>
	</div>
	{/foreach}
	{/if}
	<div class="table_clear">
		<input type="submit" value="{phrase var='api.update'}" class="button" />
	</div>
</form>
