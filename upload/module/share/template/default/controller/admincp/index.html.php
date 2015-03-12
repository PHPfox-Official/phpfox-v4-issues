<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='share.sites'}
</div>
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
	<tr>
		<th></th>
		<th style="width:20px;"></th>
		<th style="width:80px;">{phrase var='share.type'}</th>
		<th>{phrase var='share.name'}</th>
		<th class="t_center" style="width:60px;">{phrase var='share.active'}</th>
	</tr>
	{foreach from=$aSites key=iKey item=aSite}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="drag_handle"><input type="hidden" name="val[ordering][{$aSite.site_id}]" value="{$aSite.ordering}" /></td>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='share.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.share.add' id={$aSite.site_id}">{phrase var='share.edit'}</a></li>		
					<li><a href="{url link='admincp.share' delete={$aSite.site_id}" onclick="return confirm('{phrase var='share.are_you_sure' phpfox_squote=true}');">{phrase var='share.delete'}</a></li>					
				</ul>
			</div>		
		</td>
		<td>{$aSite.type_id}</td>
		<td>{$aSite.title}</td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aSite.is_active} style="display:none;"{/if}>
				<a href="#?call=share.updateActivity&amp;id={$aSite.site_id}&amp;active=0" class="js_item_active_link" title="{phrase var='share.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aSite.is_active} style="display:none;"{/if}>
				<a href="#?call=share.updateActivity&amp;id={$aSite.site_id}&amp;active=1" class="js_item_active_link" title="{phrase var='share.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>			
	</tr>
	{/foreach}	
</table>