
<div class="admincp_apps_holder">
	<section>
		<div class="themes">
		{foreach from=$themes item=theme}
			<article class="image_load" data-src="{$theme.image}">
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
		<a href="http://store.moxi9.com/phpfox/themes" target="_blank">Find More Themes</a>
	</section>
</div>