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
<div>
	<div class="error_message">{phrase var='user.are_you_completely_sure_you_want_to_delete_this_user'}</div>
	<div class="table_clear">
		<input type="button" class="button button_off" value="{phrase var='user.no_cancel'}" onclick="tb_remove();">
		<input type="button" class="button" value="{phrase var='user.yes_delete'}" onclick="$.ajaxCall('user.confirmedDelete', 'iUser={$aUser.user_id}');">
	</div>
</div>
{/if}