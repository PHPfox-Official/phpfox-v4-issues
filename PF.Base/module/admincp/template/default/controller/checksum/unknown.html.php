{if isset($check)}
	{if $total}
	<div class="error_message">{$total} unknown file(s)</div>
	<table>
	{foreach from=$unknown name=files item=file}
		<tr class="checkRow{if is_int($phpfox.iteration.files/2)} tr{else}{/if}">
			<td>{$file}</td>
		</tr>
	{/foreach}
	</table>
	{else}
	<div class="valid_message" style="padding:10px;">
		Everything looks good!
	</div>
	{/if}
{else}
	<div id="checkFiles" data-url="{$url}">
		<i class="fa fa-spin fa-circle-o-notch"></i>
	</div>
	{literal}
	<script>
		var isChecked = false;
		$Ready(function() {
			if (isChecked) {
				return;
			}
			isChecked = true;
			$.ajax({
				url: $('#checkFiles').data('url'),
				contentType: 'application/json',
				success: function(e) {
					$('#checkFiles').html(e.content);
				}
			});
		});
	</script>
	{/literal}
{/if}