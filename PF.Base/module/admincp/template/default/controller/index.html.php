{if isset($aNewProducts)}
<div class="dashboard clearfix mosaicflow_load" data-width="300">
	{foreach from=$aNewProducts item=product}
		{template file='admincp.block.product.install'}
	{/foreach}
	{block location='2'}
	{block location='3'}
	{block location='1'}
</div>
{else}

{/if}