<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: deleteUser.html.php 2935 2011-08-31 07:05:39Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if Phpfox::getService('user')->isAdminUser('' . $iUserIdDelete . '')}
<div class="error_message">
	{phrase var='user.you_are_unable_to_delete_a_site_administrator'}
</div>
{else}
<div class="p_4">{phrase var='user.you_are_about_to_delete'}</div>
<div class="go_left">
	{img user=$aUser suffix='_50' max_width='50' max_height='50'}
</div>
<div style="margin-left:55px;">
	<div class="table">
		<div class="table_left" style="width:100px;">{phrase var='user.full_name'}:</div>
		<div class="table_right" style="margin-left:100px;">{$aUser.full_name}</div>
			
		<div class="table_left" style="width:100px;">{phrase var='user.user_name'}: </div>
		<div class="table_right" style="margin-left:100px;">{$aUser|user}</div>

		<div class="table_left" style="width:100px;">{phrase var='user.total_activity'}:</div>
		<div class="table_right" style="margin-left:100px;">{$aUser.activity_total}</div>
		
		<div class="table_left" style="width:100px;">{phrase var='user.joined'}:</div>
		<div class="table_right" style="margin-left:100px;">{$aUser.joined|date:'core.global_update_time'}</div>			
	</div>			
	
	<div class="table_clear">
		{phrase var='user.are_you_completely_sure_you_want_to_delete_this_user'}
		<input type="button" class="button" value="{phrase var='user.no_cancel'}" onclick="tb_remove();">
		<input type="button" class="button" value="{phrase var='user.yes_delete'}" onclick="$.ajaxCall('user.confirmedDelete', 'iUser={$aUser.user_id}');">
	</div>		
</div>	
<div class="clear"></div>
{/if}