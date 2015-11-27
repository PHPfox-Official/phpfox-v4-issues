{if (($sAction == 'uninstall') && !$sFlag)}
<script type="text/javascript">
if(confirm('Are you sure?'))
{l}
	window.location = '{ url link='admincp.blog.installer.uninstall2'}';
{r}
</script>
{literal}
{/if}