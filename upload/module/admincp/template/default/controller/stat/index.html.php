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
	{phrase var='admincp.stats'}
</div>
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
	<tr>
		<th></th>
		<th style="width:20px;"></th>
		<th>{phrase var='admincp.title'}</th>
		<th class="t_center" style="width:60px;">{phrase var='admincp.active'}</th>	
	</tr>
	{foreach from=$aStats key=iKey item=aStat}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="drag_handle"><input type="hidden" name="val[ordering][{$aStat.stat_id}]" value="{$aStat.ordering}" /></td>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.stat.add' id={$aStat.stat_id}">{phrase var='admincp.edit'}</a></li>		
					<li><a href="{url link='admincp.stat' delete={$aStat.stat_id}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='admincp.delete'}</a></li>					
				</ul>
			</div>		
		</td>	
		<td>{phrase var=$aStat.phrase_var}</td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aStat.is_active} style="display:none;"{/if}>
				<a href="#?call=core.updateStatActivity&amp;id={$aStat.stat_id}&amp;active=0" class="js_item_active_link" title="{phrase var='admincp.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aStat.is_active} style="display:none;"{/if}>
				<a href="#?call=core.updateStatActivity&amp;id={$aStat.stat_id}&amp;active=1" class="js_item_active_link" title="{phrase var='admincp.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>		
	</tr>
	{/foreach}
</table>