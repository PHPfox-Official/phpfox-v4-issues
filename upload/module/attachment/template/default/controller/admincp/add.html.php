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
<div class="table_header">
	{phrase var='attachment.attachment_type_info'}
</div>
<form method="post" action="{url link='admincp.attachment.add'}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.extension}" /></div>
{/if}
	<div class="table">
		<div class="table_left">
			{phrase var='attachment.extension'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[extension]" value="{value id='extension' type='input'}" size="30" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='attachment.mime_type'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[mime_type]" value="{value id='mime_type' type='input'}" size="30" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='attachment.is_image'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_image]" value="1" {value type='radio' id='is_image' default='1'}/> {phrase var='admincp.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_image]" value="0" {value type='radio' id='is_image' default='0' selected='true'}/> {phrase var='admincp.no'}</span>
			</div>
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