<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: index.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPlugins)}
<form method="post" action="{url link='admincp.plugin'}">
	<table>
	<tr>
		<th>{phrase var='admincp.name'}</th>
		<th style="width:60px;">{phrase var='admincp.active'}</th>
		<th style="width:200px;">{phrase var='admincp.actions'}</th>
	</tr>
	{foreach from=$aPlugins key=iKey item=aPlugin}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td>{$aPlugin.title}</td>
		<td class="t_center">
			<div><input type="hidden" name="val[{$aPlugin.plugin_id}][id]" value="1" /></div>
			<div><input type="checkbox" name="val[{$aPlugin.plugin_id}][is_active]" value="1" {if $aPlugin.is_active}checked="checked" {/if}/></div>
		</td>
		<td>
			<select name="action" class="goJump" style="width:140px;">
				<option value="">{phrase var='admincp.select'}</option>		
				<option value="{url link='admincp.plugin.add' id=$aPlugin.plugin_id}">{phrase var='admincp.edit'}</option>
				<option value="{url link='admincp.plugin' delete=$aPlugin.plugin_id}" style="color:red;">{phrase var='admincp.delete'}</option>
			</select>
		</td>
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" value="{phrase var='admincp.update'}" class="button" />
	</div>
</form>
{else}
No plugins have been added.
<ul class="action">
	<li><a href="{url link='admincp.plugin.add'}">{phrase var='admincp.create_a_new_plugin'}</a></li>	
</ul>
{/if}