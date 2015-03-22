<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1572 2010-05-06 12:37:24Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='admincp.countries'}
</div>
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
	<tr>
		<th></th>
		<th style="width:20px;"></th>
		<th style="width:20px;">{phrase var='admincp.iso'}</th>		
		<th>{phrase var='admincp.name'}</th>		
		<th style="width:120px;">{phrase var='admincp.states_provinces'}</th>
	</tr>
{foreach from=$aCountries name=countries item=aCountry}
	<tr class="checkRow{if is_int($phpfox.iteration.countries/2)} tr{else}{/if}">
		<td class="drag_handle"><input type="hidden" name="val[ordering][{$aCountry.country_iso}]" value="{$aCountry.ordering}" /></td>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='admincp.manage'}">{img theme='misc/bullet_arrow_down.png'}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.core.country.add' id={$aCountry.country_iso}">{phrase var='admincp.edit'}</a></li>
					<li><a href="{url link='admincp.core.country.child.add' iso={$aCountry.country_iso}">{phrase var='admincp.add_state_province'}</a></li>
					{if $aCountry.total_children > 0}
					<li><a href="{url link='admincp.core.country.child' id={$aCountry.country_iso}">{phrase var='admincp.manage_states_provinces'}</a></li>					
					<li><a href="{url link='admincp.core.country' export={$aCountry.country_iso}">{phrase var='admincp.export'}</a></li>
					{/if}
					<li><a href="#" onclick="$(this).parents('.link_menu:first').hide(); tb_show('{phrase var='core.translate' phpfox_squote=true}', $.ajaxBox('core.admincp.countryTranslate', 'height=410&amp;width=600&country_iso={$aCountry.country_iso}')); return false;">{phrase var='core.translate'}</a></li>
					<li><a href="{url link='admincp.core.country' delete={$aCountry.country_iso}" onclick="return confirm('{phrase var='core.are_you_sure' phpfox_squote=true}');">{phrase var='admincp.delete'}</a></li>			
				</ul>
			</div>		
		</td>	
		<td class="t_center">{$aCountry.country_iso}</td>		
		<td>{$aCountry.name}</td>		
		<td class="t_center">{if $aCountry.total_children > 0}<a href="{url link='admincp.core.country.child' id={$aCountry.country_iso}">{/if}{$aCountry.total_children}{if $aCountry.total_children > 0}</a>{/if}</td>
	</tr>
{/foreach}
</table>