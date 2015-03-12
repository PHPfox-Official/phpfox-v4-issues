<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: active-admin.html.php 2826 2011-08-11 19:41:03Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aActiveAdmins name=admins item=aActiveAdmin}
	<div class="{if is_int($phpfox.iteration.admins/2)}row1{else}row2{/if}{if $phpfox.iteration.admins == 1} row_first{/if}">
		<div style="position:absolute; left:0px;" class="t_center">
			{img user=$aActiveAdmin suffix='_50_square' max_width=50 max_height=50}
		</div>
		<div style="margin-left:52px;">
			{$aActiveAdmin|user}
			<div class="extra_info">
				{$aActiveAdmin.in_admincp|date:'core.extended_global_time_stamp'}<br />
				{$aActiveAdmin.location}<br />
				{$aActiveAdmin.ip_address}
			</div>
		</div>		
	</div>
{/foreach}
