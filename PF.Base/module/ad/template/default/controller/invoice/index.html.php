<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1581 2010-05-07 10:16:40Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aInvoices)}
<div class="extra_info">
	{phrase var='ad.you_do_not_have_any_invoices'}
</div>
{else}
<table class="default_table" cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='ad.id'}</th>
		<th>{phrase var='ad.status'}</th>	
		<th>{phrase var='ad.price'}</th>
		<th>{phrase var='ad.date'}</th>				
	</tr>
	{foreach from=$aInvoices item=aInvoice}
	<tr>
		<td class="t_center">{$aInvoice.invoice_id}</td>
		<td>{$aInvoice.status_phrase}{if $aInvoice.status === null} (<a href="{if $aInvoice.is_sponsor != 1}{url link='ad.add.completed' id=$aInvoice.ad_id}{else}{url link='ad.sponsor' pay=$aInvoice.ad_id}{/if}">{phrase var='ad.pay_now'}</a>){/if}</td>
		<td>{$aInvoice.price|currency:$aInvoice.currency_id}</td>
		<td>{$aInvoice.time_stamp|date}</td>
	</tr>
	{/foreach}
</table>
{/if}