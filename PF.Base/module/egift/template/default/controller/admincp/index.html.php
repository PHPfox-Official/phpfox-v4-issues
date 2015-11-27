<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="table_header">
	{phrase var='egift.add_egift'}
</div>
<form action="{url link='admincp.egift'}" method="post" enctype="multipart/form-data">
	<div class="table">
		<div class="table_left">
			{phrase var='egift.title'}:
		</div>
		<div class="table_right">
			<input type="text" id="title" name="upload[title]" value="{if (isset($aEdit))}{$aEdit.title}{/if}">
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
				{phrase var='egift.choose_file'}:
		</div>
		<div class="table_right">
			<input type="file" name="file">
			<div class="extra_info">
				{phrase var='egift.allowed_file_extensions_jpg_png_gif'}.
				{if isset($aEdit.category) && !empty($aEdit.category)}
					<input type="hidden" name="action" value="edit">
					<input type="hidden" name="upload[egift_id]" value="{$aEdit.egift_id}">
					<br />{phrase var='egift.uploading_a_picture_will_overwrite_the_current_one_for_this_item'}.
				{else}
					<input type="hidden" name="action" value="upload">
				{/if}
			</div>
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='egift.choose_category'}:
		</div>
		<div class="table_right">
			<select name="upload[category]">
				{if isset($aEdit.category) && !empty($aEdit.category)}
					<option value="{$aEdit.category.category_id}">{phrase var=$aEdit.category.phrase}</option>
				{/if}
				{foreach from=$aCategories item=aCategory key=iKey}
					{if isset($aEdit.category) && !empty($aEdit.category) && $aEdit.category.category_id == $aCategory.category_id}
					{else}
					<option value="{$aCategory.category_id}">{phrase var=$aCategory.phrase}</option>
					{/if}
					
				{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='egift.price'}:
		</div>
		<div class="table_right">
			{if isset($aEdit.category) && !empty($aEdit.category)}
			{module name='core.currency' currency_field_name=upload[currency] currency_value_upload[currency]=$aEdit.price}
			{else}
			{module name='core.currency' currency_field_name=upload[currency]}
			{/if}
		</div>
	</div>
	<div class="table_clear">
		<input type="submit" class="button" value="{if isset($aEdit.category)}{phrase var='egift.edit_egift'}{else}{phrase var='egift.add_egift'}{/if}" />
	</div>
</form>

<br />

<div class="table_header">
	{phrase var='egift.manage_egifts'}
</div>

{foreach from=$aEgifts key=sCategory item=aCategory}
<div class="table_header2">
	{phrase var='egift.category'}: {$sCategory}
</div>
<div class="table">
	<div class="table_row">
		{foreach from=$aCategory key=iKey item=aGift}
			{if $iKey%4 == 0}
				</div><div class="table_row">
			{/if}
			<div class="gift_cell" id="gift_cell_{$aGift.egift_id}">
				<div class="gift_title">
					{$aGift.title}
					<span id="gift_manage_{$aGift.egift_id}" class="hidden">
						<a href="{url link='admincp.egift' delete=$aGift.egift_id}" onclick="return confirm('{phrase var='core.are_you_sure'}');">
							{img theme='misc/delete.png' style='vertical-align:middle;'}
						</a>
						<a href="{url link='admincp.egift' edit=$aGift.egift_id}">
							{img theme='misc/page_white_edit.png' style='vertical-align:middle;'}
						</a>
					</span>
				</div>
				<div class="gift_image">
					{img id='js_photo_view_image' server_id=$aGift.server_id thickbox=true path='egift.url_egift' file=$aGift.file_path suffix='_120' max_width=120 max_height=120 title=$aGift.title time_stamp=true}
				</div>
				<div class="gift_prices">
					{foreach from=$aGift.price key=sCurrency item=iPrice}
						{$sCurrency}: {$iPrice} <br />
					{/foreach}
				</div>
			</div>
		{/foreach}			
		<div class="clear"></div>
	</div>
</div>
{foreachelse}
<div class="t_center">
	{phrase var='egift.no_gifts_have_been_added'}
</div>
{/foreach}
<div class="table_clear"></div>

