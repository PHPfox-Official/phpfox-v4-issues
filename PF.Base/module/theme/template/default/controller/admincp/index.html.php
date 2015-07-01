
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
		<h1>Featured Themes</h1>
		<div class="phpfox_store_featured" data-type="themes"></div>
		<a href="{url link='admincp.store' load='themes'}" class="phpfox_store_view_more">Find More Themes</a>
	</section>
</div>