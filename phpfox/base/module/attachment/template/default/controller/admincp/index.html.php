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
	{phrase var='announcement.attachments_title'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='announcement.extension'}</th>
		<th>{phrase var='attachment.mime_type'}</th>
		<th class="t_center">{phrase var='attachment.image'}</th>
		<th class="t_center" style="width:60px;">{phrase var='admincp.active'}</th>
	</tr>
{foreach from=$aRows key=iKey item=aRow}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.attachment.add' id=$aRow.extension}">{phrase var='admincp.edit'}</a></li>		
					<li><a href="{url link='admincp.attachment' delete=$aRow.extension}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='admincp.delete'}</a></li>					
				</ul>
			</div>		
		</td>
		<td>{$aRow.extension}</td>
		<td>{$aRow.mime_type}</td>
		<td class="t_center">{if $aRow.is_image}{phrase var='admincp.yes'}{else}{phrase var='admincp.no'}{/if}</td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aRow.is_active} style="display:none;"{/if}>
				<a href="#?call=attachment.updateActivity&amp;id={$aRow.extension}&amp;active=0" class="js_item_active_link" title="{phrase var='admincp.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aRow.is_active} style="display:none;"{/if}>
				<a href="#?call=attachment.updateActivity&amp;id={$aRow.extension}&amp;active=1" class="js_item_active_link" title="{phrase var='admincp.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>		
	</tr>
{/foreach}
</table>