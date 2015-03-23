{if $failed}
<div class="error_message">
	{$failed} file(s) failed.
</div>
<table>
	<tr>
		<th>File</th>
		<th>Type</th>
	</tr>
	{foreach from=$files name=files item=message key=file}
	<tr class="checkRow{if is_int($phpfox.iteration.files/2)} tr{else}{/if}">
		<td>{$file}</td>
		<td>{$message}</td>
	</tr>
	{/foreach}
</table>
{else}
<div class="valid_message" style="padding:10px;">
	All files have passed!
</div>
{/if}