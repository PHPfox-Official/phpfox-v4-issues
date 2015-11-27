{if (count($aListings))}
{foreach from=$aListings name=listings item=aListing}
	{module name='marketplace.rows'}
{/foreach}
{pager}
{/if}