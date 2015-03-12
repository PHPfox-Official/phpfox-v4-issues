<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 4555 2012-07-23 08:45:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPackages)}
	{if isset($bIsOnSignup) && $bIsOnSignup}
		{phrase var='subscribe.on_sign_up_member_info'}
	{/if}
	{if Phpfox::isUser()}
		<div class="title">{phrase var='subscribe.your_membership_status'}: {$aGroup.title|convert}</div>
	{/if}
	{foreach from=$aPackages item=aPackage name=packages}
		{template file='subscribe.block.entry-package'}
	{/foreach}
	{if count($aPackages) >= 2}
	<a href="{url link='subscribe.compare'}" target="_blank" class="manage_subscriptions">{phrase var='subscribe.compare_subscription_packages'}</a><br />
	{/if}
{else}
	<div class="extra_info">
		{phrase var='subscribe.no_packages_available'}
	</div>
{/if}
{if Phpfox::isUser() && count($aPurchases)}
	<div class="title">{phrase var='subscribe.recent_orders'}</div>
	{foreach from=$aPurchases item=aPurchase name=purchases}
		<div class="{if is_int($phpfox.iteration.purchases/2)}row1{else}row2{/if}{if $phpfox.iteration.purchases == 1} row_first{/if}">
			{if $aPurchase.status == 'completed'}
				<span class="item_action_active">{phrase var='subscribe.active'}</span>
			{elseif $aPurchase.status == 'cancel'}
				<span class="item_action_cancel">{phrase var='subscribe.canceled'}</span>
			{elseif $aPurchase.status == 'pending'}
				<span class="item_action_pending_payment">{phrase var='subscribe.pending_payment'}</span>
			{else}
				<span class="item_action_pending_action">{phrase var='subscribe.pending_action'}</span>
			{/if} - <a href="{url link='subscribe.view' id=$aPurchase.purchase_id}">{phrase var='subscribe.order_purchase_id' purchase_id=$aPurchase.purchase_id} ({$aPurchase.title|convert|clean})</a>
			{if empty($aPurchase.status)}
			(<a href="#" onclick="tb_show('{phrase var='subscribe.select_payment_gateway' phpfox_squote=true}', $.ajaxBox('subscribe.upgrade', 'height=400&amp;width=400&amp;purchase_id={$aPurchase.purchase_id}')); return false;">{phrase var='subscribe.upgrade_now'}</a>)
			</div>
			{/if}	
			<div class="extra_info">
				{$aPurchase.time_stamp|date:'core.global_update_time'}
			</div>
		</div>
	{/foreach}

	<a href="{url link='subscribe.list'}" class="manage_subscriptions">{phrase var='subscribe.manage_subscriptions'}</a>

{/if}