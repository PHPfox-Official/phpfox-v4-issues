<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1305 2009-12-08 02:51:17Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='admincp.states_provinces'}
</div>
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
	<tr>
		<th></th>
		<th style="width:20px;"></th>
		<th>{phrase var='admincp.name'}</th>		
	</tr>
{foreach from=$aChildren name=childs item=aChild}
	<tr class="checkRow{if is_int($phpfox.iteration.childs/2)} tr{else}{/if}">
		<td class="drag_handle"><input type="hidden" name="val[ordering][{$aChild.child_id}]" value="{$aChild.ordering}" /></td>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='admincp.manage'}">{img theme='misc/bullet_arrow_down.png'}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.core.country.child.add' id={$aChild.child_id}">{phrase var='admincp.edit'}</a></li>
					<li><a href="#" onclick="$(this).parents('.link_menu:first').hide(); tb_show('{phrase var='core.translate' phpfox_squote=true}', $.ajaxBox('core.admincp.countryChildTranslate', 'height=410&amp;width=600&child_id={$aChild.child_id}')); return false;">{phrase var='core.translate'}</a></li>
					<li><a href="{url link='admincp.core.country.child' id=$aChild.country_iso delete={$aChild.child_id}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='admincp.delete'}</a></li>
				</ul>
			</div>
		</td>			
		<td>{$aChild.name}</td>		
	</tr>
{/foreach}
</table>
<div class="table_clear">
	<input type="button" value="Delete All" class="button" onclick="if (confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}')) {left_curly} window.location.href = '{url link='admincp.core.country.child' id=$sParentId deleteall=true}'; {right_curly} return false;" />
</div>