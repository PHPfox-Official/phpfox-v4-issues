<div id="js_add_new_category"></div>
{foreach from=$aItems item=aItem}
	{template file='blog.block.category-form'}
{foreachelse}
<div class="p_4">
	{phrase var='blog.no_categories_added'}
</div>
{/foreach}