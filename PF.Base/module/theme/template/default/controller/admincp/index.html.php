
<div class="admincp_apps_holder">
	<section>
		<div class="themes">
		{foreach from=$themes item=theme}
			<article {$theme.image}>
				<h1>
					<a href="{url link='admincp.theme.manage' id=$theme.theme_id}">
						<span>{$theme.name|clean}</span>
						<em>Edit</em>
					</a>
				</h1>
			</article>
		{/foreach}
		</div>
	</section>

	<section class="preview">
		<a href="{url link='admincp.store' load='themes'}">Find More Themes</a>
	</section>
</div>