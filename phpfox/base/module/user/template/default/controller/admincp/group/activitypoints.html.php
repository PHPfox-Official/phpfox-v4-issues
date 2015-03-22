<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: add.html.php 1344 2009-12-21 19:50:14Z Raymond_Benc $
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="table_header">
	{phrase var='user.user_group_details'} ({$aUserGroup.title})
</div>

<form action="{url link='admincp.user.group.activitypoints' id=$aUserGroup.user_group_id}" method="post">
	<input type="hidden" name="val[igroup]" value="{$aUserGroup.user_group_id}">
	{foreach from=$aPoints key=sModule item=aPoint}
		<div class="table">
			<div class="table_left">
					{phrase var=$aPoint.module'.user_setting_points_'$aPoint.module}
			</div>
			<div class="table_right">
				<input type="text" name="val[module][{$aPoint.setting_id}]" value="{$aPoint.value_actual}" />
			</div>

		</div>
		<div class="clear"></div>
	{/foreach}

	<div class="table_clear">
		<input type="submit" value="{phrase var='core.submit'}" class="button" />
	</div>
</form>