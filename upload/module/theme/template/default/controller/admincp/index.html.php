<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Theme
 * @version 		$Id: index.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.theme'}">
	<div class="table_header">
		{phrase var='theme.themes'}
	</div>
	<table>
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='admincp.name'}</th>
		<th class="t_center">{phrase var='theme.styles'}</th>
		<th class="t_center" style="width:60px;">{phrase var='theme.active'}</th>
	</tr>
	{foreach from=$aThemes key=iKey item=aTheme}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='theme.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.theme.add' id=$aTheme.theme_id}">{phrase var='theme.edit_theme'}</a></li>
					<li><a href="{url link='admincp.theme.template' id=$aTheme.theme_id}">{phrase var='theme.edit_templates'}</a></li>		
					<li><a href="{url link='admincp.theme.style' id=$aTheme.theme_id}">{phrase var='theme.manage_styles'}</a></li>
					<li><a href="{url link='admincp.theme.style.add' theme=$aTheme.theme_id}">{phrase var='theme.create_style'}</a></li>
					<li><a href="{url link='admincp.theme.export' theme=$aTheme.theme_id}">{phrase var='theme.export_theme'}</a></li>
					{if $aTheme.folder != 'default'}
					<li><a href="{url link='admincp.theme' delete=$aTheme.theme_id}" onclick="return confirm('{phrase var='theme.are_you_sure' phpfox_squote=true}');">{phrase var='theme.delete'}</a></li>
					{/if}
				</ul>
			</div>		
		</td>	
		<td>{$aTheme.name}</td>
		<td class="t_center"><a href="{url link='admincp.theme.style' id=$aTheme.theme_id}">{$aTheme.total_style}</a></td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aTheme.is_active} style="display:none;"{/if}>
				<a href="#?call=theme.updateThemeActivity&amp;id={$aTheme.theme_id}&amp;active=0" class="js_item_active_link" title="{phrase var='theme.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aTheme.is_active} style="display:none;"{/if}>
				<a href="#?call=theme.updateThemeActivity&amp;id={$aTheme.theme_id}&amp;active=1" class="js_item_active_link" title="{phrase var='theme.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" value="{phrase var='admincp.update'}" class="button" />
	</div>
</form>