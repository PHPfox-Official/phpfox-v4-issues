<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.rss.group.add'}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.group_id}" /></div>
{/if}
	<div class="table_header">
		{phrase var='rss.group_details'}
	</div>
	{if !$bIsEdit}
	{module name='admincp.product.form'}
	{module name='admincp.module.form'}	
	{/if}
	<div class="table">
		<div class="table_left">
		{required}{phrase var='rss.name'}:
		</div>
		<div class="table_right">
			{if $bIsEdit}
			{module name='language.admincp.form' type='text' id='name_var' var_name=$aForms.name_var}
			{else}
			{module name='language.admincp.form' type='text' id='name_var'}
			{/if}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='rss.is_active'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='rss.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='rss.no'}</span>
			</div>
		</div>
		<div class="clear"></div>		
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='rss.submit'}" class="button" />
	</div>
</form>