<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: quick-find.html.php 1400 2010-01-20 16:09:14Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="p_bottom_8">
	<form method="post" action="{url link='admincp.user.browse'}">
		<div><input type="hidden" name="search[type]" value="0" /></div>
		{phrase var='admincp.find_users'}:
		<div class="p_4">
			<input type="text" name="search[keyword]" value="" size="15" style="width:95%;" onfocus="$(this).parent().find('div:first').show();" /> 
			<div class="p_4" style="display:none;">
				<input type="submit" value="{phrase var='admincp.go'}" class="button" />
			</div>
		</div>
	</form>
</div>

<div class="p_bottom_8">
	{phrase var='admincp.manage_user_group_settings'}:
	<div class="p_4">
		<select name="user_group_id" style="width:95%;" onchange="window.location.href = '{url link='admincp.user.group.add'}id_' + this.value + '/setting_true/'; return false;">
			<option value="">{phrase var='admincp.select'}:</option>
			{foreach from=$aUserGroups item=aUserGroup}
				<option value="{$aUserGroup.user_group_id}">{$aUserGroup.title|convert|clean}</option>
			{/foreach}
		</select>	
	</div>
</div>

<div class="p_bottom_8">
	<form method="post" action="{url link='admincp.core.ip'}">
		{phrase var='admincp.search_ip_address'}:
		<div class="p_4">
			<input type="text" name="search" value="" size="15" style="width:95%;" onfocus="$(this).parent().find('div:first').show();" /> 
			<div class="p_4" style="display:none;">
				<input type="submit" value="{phrase var='admincp.go'}" class="button" />
			</div>
		</div>
	</form>
</div>

<div class="separate"></div>

<ul class="action" style="margin-left:0; padding-left:0; margin-bottom:0; padding-bottom:0;">
	{if Phpfox::isModule('announcement')}
	<li><a href="{url link='admincp.user.browse'}">{phrase var='announcement.manage_users'}</a></li>
	{/if}
	<li><a href="{url link='admincp.user.group'}">{phrase var='admincp.edit_user_groups'}</a></li>
	<li><a href="{url link='admincp.setting'}">{phrase var='admincp.edit_system_settings'}</a></li>	
	<li><a href="{url link='admincp.newsletter.add'}">{phrase var='admincp.send_newsletter'}</a></li>
	<li><a href="{url link='admincp.announcement.add'}">{phrase var='admincp.write_an_announcement'}</a></li>
</ul>