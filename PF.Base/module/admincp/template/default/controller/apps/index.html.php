{if isset($vendorCreated)}
	<i class="fa fa-spin fa-circle-o-notch"></i>
	{literal}
		<script>
			$Ready(function() {
				$Behavior.addDraggableToBoxes();
				$('.admin_action_menu .popup').trigger('click');
			});
		</script>
	{/literal}
{else}

	<div class="admincp_apps_holder">
		<section>
			<div class="admincp_apps">
				{if count($apps)}
				{foreach from=$apps item=app}
				<article>
					<h1>
						<a href="{url link='admincp.app' id=$app.id}">
							{$app.icon}
							<span>{$app.name|clean}</span>
						</a>
					</h1>
				</article>
				{/foreach}
				{else}
				<div class="message">
					No apps have been installed.
				</div>
				{/if}
			</div>
		</section>

		<section class="preview">
			{*
			<div>
				{if $aNewProducts}
					<h1>Apps Pending Installation</h1>
					{foreach from=$aNewProducts item=product}
					{template file='admincp.block.product.install'}
					{/foreach}
				{/if}
			</div>
			*}
			<div class="phpfox_store_featured" data-type="apps"></div>
			<a href="{url link='admincp.store' load='apps'}" class="phpfox_store_view_more">Find More Apps</a>
		</section>
	</div>

{/if}