<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Emoticon
 * @version 		$Id: index.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */

?>
<div class="table_header">
	{phrase var='emoticon.packages'}
</div>
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='emoticon.name'}</th>
		<th class="t_center" style="width:100px;">{phrase var='emoticon.emoticons'}</th>
		<th class="t_center" style="width:20px;">{phrase var='emoticon.active'}</th>
	</tr>

	{foreach from=$aPackages item=aPackage key=iKey}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">		
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>					
					<li><a href="{url link='admincp.emoticon.view' id={$aPackage.package_path}">{phrase var='emoticon.view_emoticons'}</a></li>
					<li><a href="{url link='admincp.emoticon.package.add' id={$aPackage.package_path}">{phrase var='emoticon.edit_package'}</a></li>									
					<li><a href="{url link='admincp.emoticon.file.export' id={$aPackage.package_path}">{phrase var='emoticon.export_package'}</a></li>
					<li><a href="{url link='admincp.emoticon.package' delete={$aPackage.package_path}" onclick="return confirm('{phrase var='emoticon.are_you_sure' phpfox_squote=true}');">{phrase var='emoticon.delete_package'}</a></li>
				</ul>
			</div>
		</td>
		<td>{$aPackage.package_name}</td>
		<td class="t_center"><a href="{url link='admincp.emoticon.view' id={$aPackage.package_path}">{$aPackage.total}</a></td>
		<td class="t_center">
			<div class="js_item_is_active" {if $aPackage.is_active != 1} style="display:none;"{/if}>
				 <a href="#?call=emoticon.updatePackageActivity&amp;id={$aPackage.package_path}&amp;active=0" class="js_item_active_link" title="{phrase var='emoticon.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active" {if $aPackage.is_active == 1} style="display:none;"{/if}>
				 <a href="#?call=emoticon.updatePackageActivity&amp;id={$aPackage.package_path}&amp;active=1" class="js_item_active_link" title="{phrase var='emoticon.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>
		</td>
	</tr>
		{foreachelse}
	<tr>
		<td colspan="5">
			{phrase var='emoticon.no_emoticons_in_this_package'}
		</td>
	</tr>
	{/foreach}
	</table>
