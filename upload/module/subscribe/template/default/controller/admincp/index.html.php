<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPackages)}
<div class="table_header">
	{phrase var='subscribe.packages'}
</div>
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
<tr>
	<th></th>
	<th style="width:20px;"></th>
	<th>{phrase var='subscribe.title'}</th>
	<th class="t_center" style="width:120px;">{phrase var='subscribe.subscriptions'}</th>
	<th class="t_center" style="width:60px;">{phrase var='subscribe.active'}</th>	
</tr>
{foreach from=$aPackages key=iKey item=aPackage}
<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
	<td class="drag_handle"><input type="hidden" name="val[ordering][{$aPackage.package_id}]" value="{$aPackage.ordering}" /></td>
	<td class="t_center">
		<a href="#" class="js_drop_down_link" title="{phrase var='subscribe.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
		<div class="link_menu">
			<ul>
				<li><a href="{url link='admincp.subscribe.add' id={$aPackage.package_id}">{phrase var='subscribe.edit_package'}</a></li>		
				<li><a href="{url link='admincp.subscribe' delete={$aPackage.package_id}" onclick="return confirm('{phrase var='subscribe.are_you_sure' phpfox_squote=true}');">{phrase var='subscribe.delete_package'}</a></li>
				{if $aPackage.total_active > 0}
				<li><a href="{url link='admincp.subscribe.list' package=$aPackage.package_id status='completed'}">{phrase var='subscribe.view_active_subscriptions'}</a></li>
				<li><a href="{url link='admincp.user.browse' group=$aPackage.user_group_id}">{phrase var='subscribe.view_active_users'}</a></li>
				{/if}
			</ul>
		</div>		
	</td>	
	<td>{$aPackage.title|convert|clean}</td>
	<td class="t_center">{if $aPackage.total_active > 0}<a href="{url link='admincp.subscribe.list' package=$aPackage.package_id status='completed'}">{/if}{$aPackage.total_active}{if $aPackage.total_active > 0}</a>{/if}</td>
	<td class="t_center">
		<div class="js_item_is_active"{if !$aPackage.is_active} style="display:none;"{/if}>
			<a href="#?call=subscribe.updateActivity&amp;package_id={$aPackage.package_id}&amp;active=0" class="js_item_active_link" title="{phrase var='subscribe.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
		</div>
		<div class="js_item_is_not_active"{if $aPackage.is_active} style="display:none;"{/if}>
			<a href="#?call=subscribe.updateActivity&amp;package_id={$aPackage.package_id}&amp;active=1" class="js_item_active_link" title="{phrase var='subscribe.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
		</div>		
	</td>
</tr>
{/foreach}
</table>
{else}
<div class="extra_info">
	{phrase var='subscribe.no_packages_have_been_added'}
	<ul class="action">
		<li><a href="{url link='admincp.subscribe.add'}">{phrase var='subscribe.create_a_new_package'}</a></li>
	</ul>
</div>
{/if}