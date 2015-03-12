<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Emoticon
 * @version 		$Id: view.html.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */

?>
<form method="post" action="{url link='admincp.emoticon.view'}">
	<div><input type="hidden" name="id" value="{$sPackageId}" /></div>
	<div class="table_header">
		{phrase var='emoticon.emoticons'}
	</div>
	<table cellpadding="0" cellspacing="0" id="js_drag_drop">
		<tr>
			<th></th>
			<th style="width:20px"></th>
			<th>{phrase var='emoticon.title'}</th>
			<th class="t_center">{phrase var='emoticon.symbol'}</th>
			<th class="t_center">{phrase var='emoticon.image'}</th>
		</tr>
	{foreach from=$aPackage item=aEmoticon key=iKey name=emoticon}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" id="js_user_{$aEmoticon.emoticon_id}">
			<td class="drag_handle"><input type="hidden" name="val[ordering][{$aEmoticon.emoticon_id}]" value="{$aEmoticon.ordering}" /></td>
			<td class="t_center">
				<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						<li><a href="{url link='admincp.emoticon.add' id=$aEmoticon.emoticon_id}">{phrase var='emoticon.edit_emoticon'}</a></li>					
						<li><a href="{url link='admincp.emoticon.add' delete=$aEmoticon.emoticon_id}">{phrase var='emoticon.delete_emoticon'}</a></li>
					</ul>
				</div>
			</td>
			<td><input type="text" name="update[{$aEmoticon.emoticon_id}][title]" value="{$aEmoticon.title}" size="10" /></td>
			<td class="t_center"><input type="text" name="update[{$aEmoticon.emoticon_id}][text]" value="{$aEmoticon.text}" size="10" /></td>
			<td class="t_center"><img src="{$sUrlEmoticon}{$aEmoticon.package_path}/{$aEmoticon.image}" alt="{$aEmoticon.title}" style="vertical-align:middle;" /></td>
		</tr>
	{foreachelse}
		<tr>
			<td colspan="5">{phrase var='emoticon.this_package_contains_no_emoticons'}</td>
		</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" value="{phrase var='emoticon.update'}" class="button" />
	</div>
</form>