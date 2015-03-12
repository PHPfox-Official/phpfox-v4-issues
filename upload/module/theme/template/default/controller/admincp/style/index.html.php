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
{if count($aStyles)}
<form method="post" action="{url link='admincp.theme'}">
	<div class="table_header">
		{phrase var='theme.styles'}
	</div>
	<table>
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='admincp.name'}</th>
		<th class="t_center" style="width:60px;">{phrase var='theme.default_manage'}</th>
		<th class="t_center" style="width:60px;">{phrase var='theme.active'}</th>
	</tr>
	{foreach from=$aStyles key=iKey item=aStyle}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.theme.style.add' id=$aStyle.style_id}">{phrase var='theme.edit_style'}</a></li>
					<li><a href="{url link='admincp.theme.style.css' id=$aStyle.style_id}">{phrase var='theme.edit_css'}</a></li>
					<li><a href="{url link='admincp.theme.style.logo' id=$aStyle.style_id}">{phrase var='theme.change_logo'}</a></li>
					<li><a href="{url link='admincp.theme.style.export' id=$aStyle.style_id}">{phrase var='theme.export_style'}</a></li>
					{if !$aStyle.is_default_style}
					<li><a href="{url link='admincp.theme.style' id=$aStyle.theme_id delete=$aStyle.style_id}" onclick="return confirm('{phrase var='theme.are_you_sure' phpfox_squote=true}');">{phrase var='theme.delete'}</a></li>
					{/if}
				</ul>
			</div>		
		</td>	
		<td>{$aStyle.name}</td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aStyle.is_default} style="display:none;"{/if}>
				<a href="#?call=theme.updateStyleDefaultState&amp;id={$aStyle.style_id}&amp;active=0" class="js_item_active_link js_remove_default" title="{phrase var='theme.remove_as_default'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aStyle.is_default} style="display:none;"{/if}>
				<a href="#?call=theme.updateStyleDefaultState&amp;id={$aStyle.style_id}&amp;active=1" class="js_item_active_link js_remove_default" title="{phrase var='theme.set_as_default'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>			
		<td class="t_center">
			<div class="js_item_is_active"{if !$aStyle.is_active} style="display:none;"{/if}>
				<a href="#?call=theme.updateStyleActivity&amp;id={$aStyle.style_id}&amp;active=0" class="js_item_active_link" title="{phrase var='theme.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aStyle.is_active} style="display:none;"{/if}>
				<a href="#?call=theme.updateStyleActivity&amp;id={$aStyle.style_id}&amp;active=1" class="js_item_active_link" title="{phrase var='theme.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>	
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" value="{phrase var='admincp.update'}" class="button" />
	</div>
</form>
{else}
<div class="message">
	{phrase var='theme.no_styles_found'}
</div>
<ul class="action">
	<li><a href="{url link='admincp.theme.style.add' theme=$aTheme.theme_id}">{phrase var='theme.create_a_new_style'}</a></li>
</ul>
{/if}