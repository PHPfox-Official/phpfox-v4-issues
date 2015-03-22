<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1558 2010-05-04 12:51:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.core.currency.add'}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.currency_id}" /></div>
{/if}
	<div class="table_header">
		{phrase var='admincp.currency_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.currency_id'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[currency_id]" value="{value type='input' id='currency_id'}" size="5" maxlength="3" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.symbol'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[symbol]" value="{value type='input' id='symbol'}" size="5" maxlength="10" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.phrase'}:
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
			{phrase var='admincp.is_active'}:
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