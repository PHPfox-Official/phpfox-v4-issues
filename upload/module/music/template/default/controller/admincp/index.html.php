<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 4702 2012-09-20 11:39:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.music'}">
	<table>
	<tr>
		<th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
		<th>{phrase var='music.name'}</th>		
	</tr>
	{foreach from=$aGenres key=iKey item=aGenre}
	<tr id="js_row{$aGenre.genre_id}" class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td><input type="checkbox" name="id[]" class="checkbox" value="{$aGenre.genre_id}" id="js_id_row{$aGenre.genre_id}" /></td>
		<td id="js_blog_edit_title{$aGenre.genre_id}"><a href="#?type=input&amp;id=js_blog_edit_title{$aGenre.genre_id}&amp;content=js_category{$aGenre.genre_id}&amp;call=music.updateGenre&amp;category_id={$aGenre.genre_id}" class="quickEdit" id="js_category{$aGenre.genre_id}">{$aGenre.name|clean|convert}</a></td>		
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" name="delete" value="{phrase var='music.delete_selected'}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" />
	</div>
</form>