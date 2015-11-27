<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Processes if user accoutn is to be deleted.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_User
 * @version 		$Id: remove.html.php 6551 2013-08-30 10:50:19Z Raymond_Benc $
 */

?>

<div class="main_break">
	<div class="error_message">{phrase var='user.are_you_sure_you_want_to_delete_your_account'}</div>
	{if Phpfox::isModule('friend')}
		<table width="100%">
			<tr>
				{foreach from=$aFriends item=aFriend name=friends}
				<td align='center'>
					{img id='sJsUserImage_'$aFriend.friend_id'' user=$aFriend suffix='_120_square' max_width=1200 max_height=120}
					<br />
					{phrase var='user.user_info_will_miss_you' user_info=$aFriend|user}
				</td>
				{/foreach}
			</tr>
		</table>
	{/if}
</div>
<div class="clear"></div>
<div class="main_break">
	<form action="{url link='user.remove.confirm'}" method="post">
	<div class="table">
		{if !empty($aReasons)}
		<div class="table_left"> {phrase var='user.why_are_you_deleting_your_account'} {required} </div>
		<div class="table_right">
			{foreach from=$aReasons item=aReason name=reasons}
			<div class="p_2">
				<label>
					<input type="checkbox" name='val[reason][]' value="{$aReason.delete_id}" class="v_middle" /> {phrase var=user.$aReason.phrase_var}
				</label>
			</div>
			{/foreach}
		</div>
		{/if}

		<div class="table_clear"></div>
		<div class="table">
			<div class="table_left"> {phrase var='user.please_tell_us_why'}:</div>
			<div class="table_right">
				<textarea cols="40" rows="4" name="val[feedback_text]"></textarea>
			</div>
		</div>
		{if !Phpfox::getUserBy('fb_user_id') && !Phpfox::getUserBy('janrain_user_id')}
		<div class="table">
			<div class="table_left">
				{phrase var='user.enter_your_password'}:
			</div>
			<div class="table_right">
				<input type="password" name="val[password]" size="20" />
			</div>
		</div>
		{/if}		
		<div class="table_clear table_clear_button">
			<ul class="table_clear_button">
				<li><input type="submit" onclick="return confirm('{phrase var='user.are_you_absolutely_sure_this_operation_cannot_be_undone' phpfox_squote=true}');" class="button button_warning" value="{phrase var='user.delete_my_account'}" /></li>
				<li><input type="button" class="button button_off" onclick="window.location='{url link='user.setting'}'" value="{phrase var='user.cancel_uppercase'}" /></li>
			</ul>
		</div>
	</div>

	<div class="clear"></div>
</div>
</form>
