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

	</div>
</div>