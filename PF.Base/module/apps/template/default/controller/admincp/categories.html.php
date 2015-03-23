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

<div id="categories_list">
	<div class="table_header">
		{phrase var='apps.categories'}
	</div>
	<table>
		<tr>
			<th style="width: 20px;"></th>
			<th style="width: 20px;"></th>
			<th>{phrase var='apps.category'}</th>
		</tr>
		
		{foreach from=$aCategories name=acategories item=aCategory}
			<tr class="{if !is_int($phpfox.iteration.acategories / 2)}tr{/if}" id="tr{$aCategory.category_id}">
				<td onclick="confirmDelete({$aCategory.category_id});"> {img theme='misc/delete.png'} </td>
				<td onclick="showEdit({$aCategory.category_id});"> {img theme='misc/page_white_edit.png'} </td>
				<td id="tdName{$aCategory.category_id}"> 
					<div id="catName{$aCategory.category_id}">
						{$aCategory.name}
					</div>
					<div id="catInput{$aCategory.category_id}" style="display: none;">
						<input type="text" id="txtName{$aCategory.category_id}" value="{$aCategory.name}">
						<input type="button" class="button" value="{phrase var='apps.update_name'}" onclick="updateName({$aCategory.category_id});">
					</div>
				</td>
			</tr>
		{/foreach}
	</table>	
	<div class="clear"></div>
</div>

<div class="table">
	<form action="{url link='admincp.apps.categories'}" method="post" >
		<div class="table_header"> {phrase var='apps.add_new_category'} </div>
		<div class="table_left">
			{phrase var='apps.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="newCategory">
		</div>
		<div class="table_clear">
			<input type="submit" value="{phrase var='apps.add_category'}" class="button">
		</div>
	</form>
</div>