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
			</div>
		</section>

		<section class="preview">
			<div>
				{if $aNewProducts}
					<h1>Apps Pending Installation</h1>
					{foreach from=$aNewProducts item=product}
					{template file='admincp.block.product.install'}
					{/foreach}
				{/if}
			</div>
			<a href="http://store.moxi9.com/phpfox/apps" target="_blank">Find More Apps</a>
		</section>
	</div>

{/if}