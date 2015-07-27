
<form method="post" action="{url link='current'}" class="ajax_post">
	<div><input type="hidden" name="theme" value="{$Theme.theme_id}"></div>
	{*
	<div class="table">
		<div class="table_right">
			<input type="text" name="val[folder]" placeholder="Unique ID">
		</div>
	</div>
	*}
	<div class="table">
		<div class="table_left">
			Clone from...
		</div>
		<div class="table_right">
			<select name="val[clone]">
			{foreach from=$flavors item=flavor}
				<option value="{$flavor.folder}">{$flavor.name}</option>
			{/foreach}
			</select>
		</div>
	</div>
	<div class="table">
		<div class="table_right">
			<input type="text" name="val[name]" placeholder="Name">
		</div>
	</div>
	<div class="table_clear">
		<input type="submit" class="button" value="Submit">
	</div>
</form>