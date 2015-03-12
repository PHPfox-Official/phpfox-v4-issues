<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: latest-admin-login.html.php 1400 2010-01-20 16:09:14Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aLastAdmins name=lastadmins item=aLastAdmin}
<div class="{if is_int($phpfox.iteration.lastadmins/2)}row1{else}row2{/if}{if $phpfox.iteration.lastadmins == 1} row_first{/if}">
	<div style="position:absolute; right:0; margin-right:8px;">
		<a href="#" title="{phrase var='admincp.view_attempt'}: {$aLastAdmin.attempt}" onclick="tb_show('{phrase var='admincp.admincp_login_log' phpfox_squote=true}', $.ajaxBox('core.admincp.viewAdminLogin', 'height=410&amp;width=600&amp;login_id={$aLastAdmin.login_id}')); return false;">
		{if $aLastAdmin.is_failed}
			{img theme='misc/cross.png'}
		{else}
			{img theme='misc/tick.png'}
		{/if}
		</a>
	</div>
	{$aLastAdmin|user}
	<div class="extra_info">
		{$aLastAdmin.time_stamp|date:'core.extended_global_time_stamp'}<br />
		{$aLastAdmin.ip_address}
	</div>
</div>
{/foreach}