<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Page
 * @version 		$Id: index.html.php 1194 2009-10-18 12:43:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPages)}
<div class="table_header">
	{phrase var='admincp.pages'}
</div>
<form method="post" action="{url link='admincp.page'}">
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='page.page'}</th>
		<th>{phrase var='page.created'}</th>
		<th style="width:60px;">{phrase var='page.active'}</th>
		<th>{phrase var='page.actions'}</th>
	</tr>
	{foreach from=$aPages key=iKey item=aPage}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td><a href="{url link=$aPage.title_url}" class="targetBlank">{if $aPage.is_phrase}{phrase var=$aPage.title}{else}{$aPage.title}{/if}</a></td>
		<td>{$aPage.added|date:'core.global_update_time'}</td>
		<td class="t_center">
			<div><input type="hidden" name="val[{$aPage.page_id}][title_url]" value="{$aPage.title_url}" /></div>
			<div><input type="checkbox" name="val[{$aPage.page_id}][is_active]" value="1" {if $aPage.is_active}checked="checked" {/if}/></div>
		</td>
		<td>
			<select name="action" class="goJump" style="width:140px;">
				<option value="">{phrase var='page.select_action'}</option>		
				<option value="{url link='admincp.page.add.' id=$aPage.page_id}">{phrase var='page.edit_page'}</option>
				{if $aPage.menu_id}
				<option value="{url link='admincp.menu.add.' id=$aPage.menu_id}">{phrase var='page.edit_page_menu'}</option>
				{/if}
				<option value="{url link='admincp.page.' delete=$aPage.page_id}" style="color:red;">{phrase var='page.delete'}</option>
			</select>
		</td>
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" value="{phrase var='admincp.update'}" class="button" />
	</div>
</form>
{else}
{phrase var='page.no_pages_have_been_added'}
<ul class="action">
	<li><a href="{url link='admincp.page.add'}">{phrase var='page.create_a_new_page'}</a></li>
</ul>
{/if}