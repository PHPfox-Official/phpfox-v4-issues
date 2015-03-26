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