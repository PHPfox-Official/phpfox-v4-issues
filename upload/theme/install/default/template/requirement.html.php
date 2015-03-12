<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: requirement.html.php 2526 2011-04-13 18:15:51Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">
<!--
{literal}
	function showHiddenTags(oObj)
	{
		$(oObj).parents('.group_holder:first').find('.table_hidden').each(function()
		{			
			$(this).toggle();
		});
		
		return false;
	}
{/literal}
-->
</script>
{foreach from=$aChecks item=aGroup}
{if count($aGroup.checks)}
<div class="group_holder">	
	<div class="table_header">
		{$aGroup.title}
	</div>
	{foreach from=$aGroup.checks key=sCheck item=sValue}
	<div class="table{if isset($aGroup.hide) && !$sValue} table_hidden{/if}"{if isset($aGroup.hide) && !$sValue} style="display:none;"{/if}>
		<div class="table_left">
			{$sCheck}:
		</div>
		<div class="table_right">
		{if $sValue}{$aGroup.passed}{if $sCheck == 'include/setting/server.sett.php'} (Rename "include/setting/server.sett.php.new" to "include/setting/server.sett.php"){/if}{else}{$aGroup.failed}{/if}
		</div>
	</div>
	{/foreach}	
</div>
{/if}
{/foreach}
<div class="table_clear">
{if $bIsPassed}
	<form method="post" action="{url link=""$sUrl".requirement"}" id="install_form">
		<div><input type="hidden" name="val[passed]" value="1" /></div>
		<input type="submit" value="Proceed to next step" class="button" id="button" />
	</form>
{else}
	<input type="button" value="Refresh" onclick="window.location.href='{url link=""$sUrl".requirement"}';" class="button" />	
{/if}
</div>