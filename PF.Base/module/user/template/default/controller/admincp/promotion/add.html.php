<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1601 2010-05-30 05:20:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if Phpfox::getParam('user.check_promotion_system')}
<div class="table_header">
	{phrase var='user.promotion_details'}
</div>
<form method="post" action="{url link='admincp.user.promotion.add'}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.promotion_id}" /></div>
{/if}
	<div class="table">
		<div class="table_left">
			{phrase var='user.user_group'}:
		</div>
		<div class="table_right">
			<select name="val[user_group_id]">
				<option value="">{phrase var='user.select'}:</option>
				{foreach from=$aUserGroups item=aUserGroup}
				<option value="{$aUserGroup.user_group_id}"{value id='user_group_id' type='select' default=$aUserGroup.user_group_id}>{$aUserGroup.title}</option>
				{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='user.activity_points'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[total_activity]" value="{value id='total_activity' type='input'}" size="10" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='user.days_registered'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[total_day]" value="{value id='total_day' type='input'}" size="5" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='user.move_user_to_user_group'}:
		</div>
		<div class="table_right">
			<select name="val[upgrade_user_group_id]">
				<option value="">{phrase var='user.select'}:</option>
				{foreach from=$aUserGroups item=aUserGroup}
				<option value="{$aUserGroup.user_group_id}"{value id='upgrade_user_group_id' type='select' default=$aUserGroup.user_group_id}>{$aUserGroup.title}</option>
				{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='user.submit'}" class="button" />
	</div>
</form>
{else}
<div class="message">
	{phrase var='user.before_you_can_use_this_feature_you_need_to_enable_the_option' link=$sEnableOptionLink}
</div>
{/if}