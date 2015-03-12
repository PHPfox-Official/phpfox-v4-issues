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