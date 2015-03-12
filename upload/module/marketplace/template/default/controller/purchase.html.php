<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: purchase.html.php 1558 2010-05-04 12:51:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
{if $bInvoice}

<h3>{phrase var='marketplace.payment_methods'}</h3>
{module name='api.gateway.form'}

{else}
<div class="info">
	<div class="info_left">
		{phrase var='marketplace.item_you_re_buying'}:
	</div>
	<div class="info_right">
		{$aListing.title|clean}
	</div>		
</div>
<div class="info">
	<div class="info_left">
		{phrase var='marketplace.price'}:
	</div>
	<div class="info_right">
		{$aListing.price|clean}
	</div>		
</div>
	
<div class="separate"></div>

<div class="p_4">
	{phrase var='marketplace.by_clicking_on_the_button_below_you_commit_to_buy_this_item_from_the_seller'}
	<div class="p_4">
		<form method="post" action="{url link='marketplace.purchase'}">
			<div><input type="hidden" name="id" value="{$aListing.listing_id}" /></div>
			<div><input type="hidden" name="process" value="1" /></div>			
			<input type="submit" value="{phrase var='marketplace.commit_to_buy'}" class="button" />
		</form>
	</div>
</div>
{/if}