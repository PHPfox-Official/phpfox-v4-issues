
<div>
{foreach from=$themes item=theme}
	<a href="{url link='admincp.theme.manage' id=$theme.theme_id}">{$theme.name|clean}</a>
{/foreach}
</div>