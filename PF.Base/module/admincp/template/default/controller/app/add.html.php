<div class="js_box_actions">
	<div>
		Import File
		<span>
			<input type="file" name="file" class="ajax_upload" data-url="{url link='admincp.app.add'}">
		</span>
	</div>
</div>
<form method="post" action="{url link='admincp.app.add'}" class="ajax_post" id="create-app">
	<div class="vendor_create">
		<div class="table">
			<div class="table_right">
				<input type="text" name="val[name]" placeholder="App ID or Github URL" id="create-app-info">
			</div>
		</div>

		<div class="table_clear">
			<input type="submit" value="Submit" class="button" />
		</div>
		<pre id="debug_info" style="display:none; background:#0c0c0c; height:300px; overflow:auto; padding:10px; color:#fff; font-family:monospace; font-size:12px;"></pre>
	</div>
</form>
<script>
		var pingApp = '{url link='admincp.app.ping'}';
		{literal}
		var runPing = function() {
			var scriptUrl = pingApp + '?ping-no-session=1&url=' + encodeURIComponent($('#create-app-info').val()) + '&t=' + (new Date()).getTime();
			$('body').append('<script src="' + scriptUrl + '"><\/script>');
		};
		$Ready(function() {
			$('#create-app').submit(function() {
				$('.table_clear').hide();
				$('#debug_info').show();
				runPing();
			});
		});
		{/literal}
</script>