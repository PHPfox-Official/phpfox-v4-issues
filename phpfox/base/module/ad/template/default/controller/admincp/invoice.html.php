<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: invoice.html.php 2029 2010-11-01 16:57:31Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.ad.invoice'}">
	<div class="table_header">
		{phrase var='ad.invoice_filter'}
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='ad.status'}: 
		</div>
		<div class="table_right">
			{$aFilters.status}
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='ad.display'}: 
		</div>
		<div class="table_right">
			{$aFilters.display}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='ad.sort_by'}: 
		</div>
		<div class="table_right">
			{$aFilters.sort} {$aFilters.sort_by}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" name="search[submit]" value="{phrase var='core.submit'}" class="button" />
		<input type="submit" name="search[reset]" value="{phrase var='core.reset'}" class="button" />	
	</div>
</form>

<br />

{pager}

{if !count($aInvoices)}
<div class="extra_info">
	{phrase var='ad.there_are_no_invoices'}
</div>
{else}
<div class="table_header">
	{phrase var='ad.invoices'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='ad.id'}</th>
		<th>{phrase var='ad.status'}</th>	
		<th>{phrase var='ad.price'}</th>
		<th>{phrase var='ad.date'}</th>				
	</tr>
	{foreach from=$aInvoices key=iKey item=aInvoice}
	<tr {if is_int($iKey/2)} class="tr"{/if}>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='ad.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.ad.invoice' delete=$aInvoice.invoice_id}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='ad.delete'}</a></li>					
				</ul>
			</div>		
		</td>		
		<td class="t_center">{$aInvoice.invoice_id}</td>
		<td>{$aInvoice.status_phrase}</td>
		<td>{$aInvoice.price|currency:$aInvoice.currency_id}</td>
		<td>{$aInvoice.time_stamp|date}</td>
	</tr>
	{/foreach}
</table>
<div class="table_clear"></div>

{pager}

{/if}