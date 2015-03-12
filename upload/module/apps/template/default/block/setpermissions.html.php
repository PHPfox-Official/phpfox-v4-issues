<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">
	function setPermissions()
	{literal}
	{
		var aDisallow = [];
		$('.select_var_name').each(function(){
			if ($(this).val() == 2)
			{
				aDisallow.push($(this).attr('id'));
			}
		});
		$.ajaxCall('apps.setPermissions', 'iAppId={/literal}{$aApp.app_id}{literal}&sDisallow=' + aDisallow.join(','));
	}
	{/literal}
</script>

{foreach from=$aPermissions item=aPermission}
<div class="table">
	<div class="table_left">
		{$aPermission.sPhrase}
	</div>
	<div class="table_right">
		<select class="select_var_name" id="{$aPermission.sVariable}">
			<option value="1"> {phrase var='apps.allow'} </option>
			<option value="2" {if $aPermission.disallow == true} selected="selected"{/if}> {phrase var='apps.not_allow'}</option>
		</select>
	</div>
</div>
{/foreach}

<div class="table_clear">
	<input type="button" class="button" value="{phrase var='apps.update'}" onclick="setPermissions();" />
</div>