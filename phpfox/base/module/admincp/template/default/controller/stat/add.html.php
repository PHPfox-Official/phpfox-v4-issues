<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.stat.add'}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.stat_id}" /></div>
{/if}
	<div class="table_header">
		{phrase var='admincp.stat_details'}
	</div>
	{module name='admincp.product.form'}
	{module name='admincp.module.form'}
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.title'}:
		</div>
		<div class="table_right">
			{if $bIsEdit}
			{module name='language.admincp.form' type='text' id='phrase_var' var_name=$aForms.phrase_var}
			{else}
			{module name='language.admincp.form' type='text' id='phrase_var'}
			{/if}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.link'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[stat_link]" id="stat_link" value="{value id='stat_link' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.image'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[stat_image]" id="stat_image" value="{value id='stat_image' type='input'}" size="20" />
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.php_code'}:
		</div>
		<div class="table_right">
			<textarea cols="60" rows="8" name="val[php_code]">{value id='php_code' type='textarea'}</textarea>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.active'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='admincp.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='admincp.no'}</span>
			</div>
		</div>
		<div class="clear"></div>		
	</div>		
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
	</div>
</form>