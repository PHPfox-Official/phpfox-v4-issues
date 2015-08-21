
<div class="admincp_apps_holder">

	{*
	{if ($newInstalls)}
	<section class="new_installs">
		<h1>Pending Installs</h1>
		<div class="themes">
			{foreach from=$newInstalls item=install}
			<article data-src="{$install.icon}" class="image_load">
			<h1>
				<a href="{url link='admincp.store' install=$install.id}">
					<span>{$install.name|clean}</span>
					<em>Install</em>
				</a>
			</h1>
			</article>
			{/foreach}
		</div>
	</section>
	{/if}
	*}

	<section>
		<div class="themes">
		{foreach from=$themes item=theme}
			<article {if ($theme.is_default)} id="is-default"{/if} {$theme.image}>
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
		<div class="phpfox_store_featured" data-type="themes" data-parent="{url link='admincp.store' load='themes'}"><i class="fa fa-spin fa-circle-o-notch"></i></div>
	</section>
</div>