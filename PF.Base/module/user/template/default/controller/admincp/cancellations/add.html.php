<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>

<form method="post" action="{url link='admincp.user.cancellations.add'}">
{if isset($aForms.delete_id)}
<input type="hidden" name="val[iDeleteId]" value="{$aForms.delete_id}">
{/if}
	<div class="table_header">
		{phrase var='user.add_new_option'}
	</div>
	{if !isset($aForms.delete_id)}
		{module name='admincp.product.form'}
		{module name='admincp.module.form'}
	{/if}
	<div class="table">
		<div class="table_left">
			{required}{phrase var='user.cancellation_reason'}:
		</div>
		<div class="table_right">
			{if isset($aForms.phrase_var)}
			{module name='language.admincp.form' type='text' id='phrase_var' var_name=$aForms.phrase_var}
			{else}
			{module name='language.admincp.form' type='text' id='phrase_var'}
			{/if}
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='user.is_active'}:
		</div>
		<div class="table_right">
			<div class="item_is_active_holder">
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='user.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='user.no'}</span>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='user.submit'}" class="button" />
	</div>
</form>