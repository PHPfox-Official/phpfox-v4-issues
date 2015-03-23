<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: entry.html.php 1339 2009-12-19 00:37:55Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table">
	<div class="table_left">
		{phrase var='subscribe.purchase_id'}:
	</div>
	<div class="table_right_text">
		<a href="{url link='subscribe.view' id=$aPurchase.purchase_id}">{$aPurchase.purchase_id}</a>
	</div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='subscribe.membership'}:
	</div>
	<div class="table_right_text">
		{$aPurchase.title|convert|clean}
	</div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='subscribe.status'}:
	</div>
	<div class="table_right_text">
		{if $aPurchase.status == 'completed'}
		<span class="item_action_active">{phrase var='subscribe.active'}</span>
		{elseif $aPurchase.status == 'cancel'}
		<span class="item_action_cancel">{phrase var='subscribe.canceled'}</span>
		{elseif $aPurchase.status == 'pending'}
		<span class="item_action_pending_payment">{phrase var='subscribe.pending_payment'}</span>
		{else}
		<span class="item_action_pending_action">{phrase var='subscribe.pending_action'}</span>
		{/if}		
	</div>
</div>
<div class="table">
	<div class="table_left">
		{phrase var='subscribe.price'}:
	</div>
	<div class="table_right_text">
		{if isset($aPurchase.default_cost) && $aPurchase.default_cost != '0.00'}			
			{if isset($aPurchase.default_recurring_cost)}
				{$aPurchase.default_recurring_currency_id|currency_symbol}{$aPurchase.default_recurring_cost}
			{else}
				{$aPurchase.default_currency_id|currency_symbol}{$aPurchase.default_cost|number_format}
			{/if}
		{else}
			Free
		{/if}
	</div>
</div>
{if empty($aPurchase.status)}
<div class="t_right">
	<ul class="item_menu">
		<li><a href="#?call=subscribe.upgrade&amp;height=400&amp;width=400&amp;purchase_id={$aPurchase.purchase_id}" class="inlinePopup" title="{phrase var='subscribe.select_payment_gateway'}">{phrase var='subscribe.upgrade'}</a></li>
	</ul>
</div>
{/if}