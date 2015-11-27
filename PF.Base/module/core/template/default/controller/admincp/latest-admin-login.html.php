<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: latest-admin-login.html.php 6189 2013-06-29 08:45:09Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='admincp.admins'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='admincp.user'}</th>
		<th>{phrase var='admincp.ip_address'}</th>
		<th style="width:70px;" class="t_center">{phrase var='admincp.attempt'}</th>
		<th>{phrase var='admincp.time_stamp'}</th>
	</tr>
{foreach from=$aUsers key=iKey item=aUser}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td>{$aUser|user}</td>
		<td>{$aUser.ip_address}</td>
		<td class="t_center">
			<a href="#" title="{phrase var='admincp.view_attempt'}: {$aUser.attempt}" onclick="tb_show('{phrase var='admincp.admincp_login_log' phpfox_squote=true}', $.ajaxBox('core.admincp.viewAdminLogin', 'height=410&amp;width=600&amp;login_id={$aUser.login_id}')); return false;">
			{if $aUser.is_failed}
				{img theme='misc/cross.png'}
			{else}
				{img theme='misc/tick.png'}
			{/if}
			</a>	
		</td>
		<td>{$aUser.time_stamp|date:'core.extended_global_time_stamp'}</td>
	</tr>
{/foreach}
</table>
{pager}