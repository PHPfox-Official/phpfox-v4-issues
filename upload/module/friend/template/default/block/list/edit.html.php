<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: edit.html.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='current'}" id="js_edit_list_form">
{foreach from=$aLists item=aList}
<div class="p_4" id="js_edit_input_list_{$aList.list_id}">
	<input type="text" name="val[name][{$aList.list_id}]" value="{$aList.name|clean}" size="20" /> <a href="#?call=friend.deleteList&amp;id={$aList.list_id}" class="delete_link" title="{phrase var='friend.delete'}">{img theme='misc/delete.gif' alt_phrase='friend.delete' class='delete_hover'}</a>
</div>
{/foreach}
<div class="p_4">
	<input type="button" value="{phrase var='friend.update'}" class="button" id="js_submit_update_list" /> <input type="button" value="{phrase var='friend.cancel'}" class="button" id="js_cancel_edit_list" /> <span id="js_process_form_image"></span>
</div>
</form>