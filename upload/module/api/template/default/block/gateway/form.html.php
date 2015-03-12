<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: form.html.php 7119 2014-02-18 13:55:48Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{plugin call='api.template_block_gateway_form_start'}
{if count($aGateways)}
{foreach from=$aGateways name=gateways item=aGateway}
<form method="post" action="{$aGateway.form.url}"{if $aGateway.gateway_id == 'activitypoints'} onsubmit="$(this).ajaxCall('api.processActivityPayment'); return false;"{/if}
	{if $bIsThickBox}style="max-height: 400px; overflow: auto;"{/if}>
{foreach from=$aGateway.form.param key=sField item=sValue}
	<div><input type="hidden" name="{$sField}" value="{$sValue}" /></div>
{/foreach}
	<div class="{if is_int($phpfox.iteration.gateways/2)}row1{else}row2{/if}{if $phpfox.iteration.gateways == 1} row_first{/if}">
		<div class="gateway_title">{$aGateway.title}</div>
		<div class="extra_info">
			{$aGateway.description}
		</div>
		<div class="p_4 t_right">
			{if $aGateway.gateway_id == 'activitypoints'}
			{phrase var='user.purchase_points_info' yourpoints=$aGateway.yourpoints|number_format yourcost=$aGateway.yourcost|number_format}
			{/if}
			<input type="submit" value="{phrase var='api.purchase_with_gateway_name' gateway_name=$aGateway.title}" class="button" />
		</div>
	</div>
</form>
{/foreach}
{else}
<div class="extra_info">
	{phrase var='api.opps_no_payment_gateways_have_been_set_up_yet'}
</div>
{/if}
{plugin call='api.template_block_gateway_form_end'}
