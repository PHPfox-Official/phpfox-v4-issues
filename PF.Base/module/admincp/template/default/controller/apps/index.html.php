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

	<div class="admincp_apps">
		<div>
			{foreach from=$modules item=app}
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

		<div>
			{foreach from=$aNewProducts item=product}
				{template file='admincp.block.product.install'}
			{/foreach}
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

		<div>
			{foreach from=$appsV4 item=app}
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
	</div>

{/if}