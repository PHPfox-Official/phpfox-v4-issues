<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form action="{url link='admincp.user.ban' user=$aUser.user_id}" method="post">
	<div><input type="hidden" name="aBan[user]" value="{$aUser.user_id}"></div>
	<div class="table_header"> {phrase var='user.ban_user'} </div>
	<div class="table">
		<div class="table_left">
			{phrase var='ban.you_are_about_to_ban_the_user'}
		</div>
		<div class="table_right">
			{$aUser|user}
		</div>
		<div class="clear"></div>
	</div>
	{module name='ban.form' bShow=true bHideAffected=true}
	<div class="table_clear">
		<input type="submit" class="button" value="{phrase var='user.ban_user'}">
</div>
</form>