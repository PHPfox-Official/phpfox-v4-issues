<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: deleteUser.html.php 2137 2010-11-15 13:37:06Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="sFeedbackDeny" class="public_message"></div>
{phrase var='user.you_are_about_to_deny_user', link=$aUser.link user_name=$aUser.user_name}

<div class="table">
	<div class="table_above">
		Subject:
	</div>
	<div class="table_below">
		<input type="text" size="30" id="denySubject" name="denySubject" value="{left_curly}phrase var='user.deny_mail_subject'{right_curly}">
	</div>
	<div class="clear">	</div>
</div>
<div class="table">
	<div class="table_above">
		Message:
	</div>
	<div class="table_below">
		<textarea name="denyMessage" id="denyMessage" cols="30" rows="3">{left_curly}phrase var='user.deny_mail_message'{right_curly}</textarea>
	</div>
	<div class="clear"></div>
</div>
<div class="table_clear">
	<a href="#" onclick="$.ajaxCall('user.denyUser', 'sSubject='+$('#denySubject').val()+'&sMessage='+$('#denyMessage').val()+'&iUser={$aUser.user_id}&doReturn=0');return false;">
		{phrase var='user.deny_and_send_email'}</a>
	- <a href="#" onclick="$.ajaxCall('user.denyUser', 'sSubject='+$('#denySubject').val()+'&sMessage='+$('#denyMessage').val()+'&iUser={$aUser.user_id}&doReturn=1');return false;">{phrase var='user.deny_without_email'}</a>
	or
	<input type="button" onclick="tb_remove();" value="{phrase var='core.cancel'}"></div>


