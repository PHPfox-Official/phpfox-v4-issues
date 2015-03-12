<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='api.gateways'}
</div>
<table cellpadding="0" cellspacing="0">
<tr>
	<th style="width:20px;"></th>
	<th>{phrase var='api.title'}</th>
	<th class="t_center" style="width:100px;">{phrase var='api.test_mode'}</th>
	<th class="t_center" style="width:60px;">{phrase var='api.active'}</th>
</tr>
{foreach from=$aGateways key=iKey item=aGateway}
<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
	<td class="t_center">
		<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
		<div class="link_menu">
			<ul>
				<li><a href="{url link='admincp.api.gateway.add' id={$aGateway.gateway_id}">{phrase var='api.edit_gateway_settings'}</a></li>				
			</ul>
		</div>		
	</td>	
	<td>{$aGateway.title}</td>
	<td class="t_center">
		<div class="js_item_is_active"{if !$aGateway.is_test} style="display:none;"{/if}>
			<a href="#?call=api.updateGatewayTest&amp;gateway_id={$aGateway.gateway_id}&amp;active=0" class="js_item_active_link" title="{phrase var='api.disable_test_mode'}">{img theme='misc/bullet_green.png' alt=''}</a>
		</div>
		<div class="js_item_is_not_active"{if $aGateway.is_test} style="display:none;"{/if}>
			<a href="#?call=api.updateGatewayTest&amp;gateway_id={$aGateway.gateway_id}&amp;active=1" class="js_item_active_link" title="{phrase var='api.enable_test_mode'}">{img theme='misc/bullet_red.png' alt=''}</a>
		</div>		
	</td>	
	<td class="t_center">
		<div class="js_item_is_active"{if !$aGateway.is_active} style="display:none;"{/if}>
			<a href="#?call=api.updateGatewayActivity&amp;gateway_id={$aGateway.gateway_id}&amp;active=0" class="js_item_active_link" title="{phrase var='admincp.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
		</div>
		<div class="js_item_is_not_active"{if $aGateway.is_active} style="display:none;"{/if}>
			<a href="#?call=api.updateGatewayActivity&amp;gateway_id={$aGateway.gateway_id}&amp;active=1" class="js_item_active_link" title="{phrase var='admincp.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
		</div>		
	</td>
</tr>
{/foreach}
</table>