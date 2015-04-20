<div class="js_box_actions">
	<div>
		Import File
		<span>
			<input type="file" name="file" class="ajax_upload" data-url="{url link='admincp.app.add'}">
		</span>
	</div>
</div>
<form method="post" action="{url link='admincp.app.add'}" class="ajax_post">

	<div class="moxi9" data-call="vendor"></div>
	{literal}
	<script>
		$Ready(function() {
			$('.moxi9.success').each(function() {
				var t = $(this),
					obj = t.data('json');

				$('.vendor_create').show();
				$('.vendor_id').val(obj.name);

				t.remove();
			});
		});
	</script>
	{/literal}

	<div class="hide_it vendor_create">
		<div><input type="hidden" name="val[vendor]" placeholder="Vendor" class="vendor_id"></div>
		<div class="table">
			<div class="table_right">
				<input type="text" name="val[name]" placeholder="App Name">
			</div>
		</div>
		<div class="table_clear">
			<input type="submit" value="Submit" class="button" />
		</div>
	</div>
</form>
