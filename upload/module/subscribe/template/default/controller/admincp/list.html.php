<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 1339 2009-12-19 00:37:55Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bIsSearching && !count($aPurchases)}
<div class="message">
	{phrase var='subscribe.could_not_find_any_purchase_orders_with_your_search_criteria'}
</div>
{/if}
<form method="post" action="{url link='admincp.subscribe.list'}">
	<div class="table_header">
		{phrase var='subscribe.filter'}
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='subscribe.status'}:
		</div>
		<div class="table_right">
			{filter key='status'}	
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='subscribe.sort_results_by'}:
		</div>
		<div class="table_right">
			{filter key='sort'}	
		</div>
		<div class="clear"></div>
	</div>			
	<div class="table_clear">		
		<input type="submit" value="{phrase var='subscribe.update'}" class="button" />
		{if $bIsSearching}
		<input type="submit" value="{phrase var='subscribe.reset'}" class="button" name="search[reset]" />
		{/if}
	</div>	
</form>
{if count($aPurchases)}
<br />

{pager}
<div class="table_header">
	{phrase var='subscribe.orders'}
</div>
<table cellpadding="0" cellspacing="0">
<tr>
	<th style="width:20px;"></th>
	<th class="t_center" style="width:100px;">{phrase var='subscribe.order_id'}</th>
	<th>{phrase var='subscribe.package'}</th>
	<th>{phrase var='subscribe.user'}</th>
	<th class="t_center" style="width:100px;">{phrase var='subscribe.price'}</th>
	<th style="width:300px;">{phrase var='subscribe.status'}</th>	
	<th>{phrase var='subscribe.time'}</th>	
</tr>
{foreach from=$aPurchases key=iKey item=aPurchase}
<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
	<td class="t_center">
		<a href="#" class="js_drop_down_link" title="{phrase var='subscribe.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
		<div class="link_menu">
			<ul>
				<li><a href="{url link='admincp.subscribe.list' delete={$aPurchase.purchase_id}" onclick="return confirm('{phrase var='subscribe.are_you_sure' phpfox_squote=true}');">{phrase var='subscribe.delete_order'}</a></li>				
			</ul>
		</div>		
	</td>	
	<td class="t_center">{$aPurchase.purchase_id}</td>
	<td><a href="{url link='admincp.subscribe.add' id=$aPurchase.package_id}">{$aPurchase.title|convert|clean}</a></td>
	<td>{$aPurchase|user}</td>
	<td class="t_center">
		{if isset($aPurchase.default_cost) && $aPurchase.default_cost != '0.00'}			
			{if isset($aPurchase.default_recurring_cost)}
				{$aPurchase.default_recurring_currency_id|currency_symbol}{$aPurchase.default_recurring_cost}
			{else}
			{$aPurchase.default_currency_id|currency_symbol}{$aPurchase.default_cost|number_format}
			{/if}
		{else}
		Free
		{/if}	
	</td>
	<td>
		<a href="#" class="form_select_active">
			{if $aPurchase.status == 'completed'}
			{phrase var='subscribe.active'}
			{elseif $aPurchase.status == 'cancel'}
			{phrase var='subscribe.canceled'}
			{elseif $aPurchase.status == 'pending'}
			{phrase var='subscribe.pending_payment'}
			{else}
			{phrase var='subscribe.pending_action'}
			{/if}
		</a>
		<ul class="form_select">
			<li><a href="#?call=subscribe.updatePurchase&amp;status=completed&amp;purchase_id={$aPurchase.purchase_id}">{phrase var='subscribe.active'}</a></li>
			<li><a href="#?call=subscribe.updatePurchase&amp;status=cancel&amp;purchase_id={$aPurchase.purchase_id}">{phrase var='subscribe.canceled'}</a></li>
			<li><a href="#?call=subscribe.updatePurchase&amp;status=pending&amp;purchase_id={$aPurchase.purchase_id}">{phrase var='subscribe.pending_payment'}</a></li>
			<li><a href="#?call=subscribe.updatePurchase&amp;status=&amp;purchase_id={$aPurchase.purchase_id}">{phrase var='subscribe.pending_action'}</a></li>
		</ul>
	</td>
	<td>{$aPurchase.time_stamp|date}</td>
</tr>
{/foreach}
</table>
{pager}
{else}
{if !$bIsSearching}
<div class="extra_info">
	{phrase var='subscribe.no_purchase_orders'}
</div>
{/if}
{/if}