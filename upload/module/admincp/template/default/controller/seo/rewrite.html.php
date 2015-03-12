<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: nofollow.html.php 4165 2012-05-14 10:43:25Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header2">
	{phrase var='admincp.rewrite_url'}
</div>
	
<table class="" cellpadding="0" cellspacing="0">
	<tr id="tblHeader">
		<th id="thActions">
			
		</th>
		<th>
			{phrase var='admincp.this_url'}
		</th>
		<th>
			{phrase var='admincp.will_show_this_page'}
		</th>
	</tr>
	
	<tr id="trAddNew">
		<td colspan="3" id="tdAddNew" onclick="$Core.AdminCP.Rewrite.addNew();">
			{phrase var='admincp.add_new_rewrite'}
		</td>
	</tr>
	
	<tr id="templateEntry">
		<td>
			{img alt='Remove' theme='misc/delete.png' style='vertical-align: middle;' onclick='$Core.AdminCP.Rewrite.remove(this);'}
		</td>
		<td>
			<input type="text" value="{phrase var='core.original_url'}" class="sOriginal" onblur="$Core.AdminCP.Rewrite.checkOriginal(this)" />
			<span class="invalidOriginal">
				{img alt='Invalid Original URL' theme='misc/flag_red.png' style='vertical-align: middle;'}
			</span>
		</td>
		<td>
			<input type="text" value="{phrase var='core.replacement_url'}" onblur="$Core.AdminCP.Rewrite.checkReplacement(this)" class="sReplacement" />
		</td>
	</tr>
</table>

<div class="clear"></div>

<div id="feedback">
	<div class="left">
		<div id="processing">
			{img theme='ajax/small.gif'}
		</div>
		<div id="message"></div>
	</div>
	<div class="right">
		<input type="button" class="button" value="{phrase var='core.save'}" onclick="$Core.AdminCP.Rewrite.save();" />
	</div>
</div>




<script type="text/javascript">
	$Behavior.initRewrites = function()
	{l}
		$Core.AdminCP.Rewrite.init('{$jRewrites}');
	{r};
</script>