<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: browse.html.php 2137 2010-11-15 13:37:06Z Raymond_Benc $
 * {* *}
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="warning">
	{phrase var='user.member_snoop_text' user_name=$user_name full_name=$full_name user_link=$user_link}
	<br /><br />
	<form action="{url link='admincp.user.snoop' user=$aUser.user_id}" method="post">
		<input type="hidden" name="action" value="proceed">
		<a class="button linkAway" href="{url link='admincp'}">{phrase var='user.abort_log_in_as_this_user'} </a>
		- <input type="submit" class="btnSubmit button" value="{phrase var='user.log'}">
	</form>
</div>
