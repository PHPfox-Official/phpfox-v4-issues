<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: entry.html.php 6480 2013-08-21 07:37:40Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">
	var sInProcess = '';
	function checkInProcess(sModuleId)
	{l}
		if (sInProcess == '')
		{l}
			sInProcess = sModuleId;
			return true;
		{r}
		return false;
	{r}
</script>
<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}{if isset($aModule.is_not_installed)} is_checked{/if}">
	<td class="t_center">
	{if isset($aModule.is_not_installed)}
		<a onclick="return checkInProcess('{$aModule.module_id}');" href="{url link='admincp.module' install=$aModule.module_id}" title="{phrase var='admincp.install_this_module'}">{img theme='misc/application_add.png'}</a>
	{else}
		<a href="#" class="js_drop_down_link" title="{phrase var='admincp.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
		<div class="link_menu">
			<ul>
				<li><a href="{url link='admincp.module.add.' id=$aModule.module_id}">{phrase var='admincp.edit'}</a></li>
				{if isset($aModule.total_setting) && $aModule.total_setting > 0}
				<li><a href="{url link='admincp.setting.edit' module-id=$aModule.module_id}">{phrase var='admincp.manage_settings'}</a></li>
				{/if}
				{if !$aModule.is_core}
				<li><a href="{url link='admincp.module' delete=$aModule.module_id}" onclick="return (confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}') && alert('{phrase var='admincp.uninstall_module_reminder'}'));">{phrase var='admincp.uninstall'}</a></li>					
				{/if}
			</ul>
		</div>		
	{/if}
	</td>
	<td>{$aModule.module_id|translate:'module'}</td>
	<td>{$aModule.product_title|translate:'product'}</td>
	<td class="t_center">
	{if isset($aModule.is_not_installed)}
		{img theme='misc/bullet_red.png' alt=''}
	{else}
	{if $aModule.is_core}
		{img theme='misc/bullet_green.png' alt=''}
	{else}		
		<div class="js_item_is_active"{if !$aModule.is_active} style="display:none;"{/if}>
			<a href="#?call=admincp.updateModuleActivity&amp;id={$aModule.module_id}&amp;active=0" class="js_item_active_link" title="{phrase var='admincp.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
		</div>
		<div class="js_item_is_not_active"{if $aModule.is_active} style="display:none;"{/if}>
			<a href="#?call=admincp.updateModuleActivity&amp;id={$aModule.module_id}&amp;active=1" class="js_item_active_link" title="{phrase var='admincp.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
		</div>		
	{/if}
	{/if}
	</td>
</tr>