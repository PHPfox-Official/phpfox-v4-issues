<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: friend.html.php 7020 2014-01-06 17:34:09Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">
{literal}
	function shareFriendContinue()
	{
		var iCnt = 0;
		$('.js_cached_friend_name').each(function()
		{
			iCnt++;
		});
		
		if (!iCnt)
		{
			{/literal}
			alert('{phrase var='share.need_to_select_some_friends_before_we_try_to_send_the_message' phpfox_squote=true}');
			{literal}
			return false;
		}
		
		$('#js_friend_search').hide();
		$('#js_friend_mail').show();
		
		return false;
	}
	
	function sendFriends(oObj)
	{
		$('#js_send_friends_error_message').hide();
		
		$('#btnShareFriends').attr('disabled', 'disabled');
		$('#imgShareFriendsLoading').show();
		$(oObj).ajaxCall('share.sendFriends');
		
		return false;
	}
{/literal}
</script>
<div>	
	<div id="js_friend_search">
		{module name='friend.search' friend_share=true input='to'}
		<div class="main_break t_right">
			<input type="button" value="{phrase var='share.continue'}" class="button" onclick="return shareFriendContinue();" />
		</div>		
	</div>
	<div id="js_friend_mail" style="display:none;">
		<form method="post" action="#" onsubmit="return sendFriends(this);">
			<div id="js_selected_friends" style="display:none;"></div>
			<div class="p_4">
				<div class="table">
					<div class="table_left">
						{phrase var='share.subject'}:
					</div>
					<div class="table_right">
						<input type="text" name="val[subject]" size="30" value="{phrase var='share.check_out'} {$sTitle|clean}" />
					</div>
				</div>	
				<div class="table">
					<div class="table_left">
						{phrase var='share.message'}:
					</div>
					<div class="table_right">
						<textarea cols="30" rows="10" name="val[message]" style="width:95%;">{$sMessage}</textarea>
					</div>
				</div>
				<div class="table_clear">
					<input type="submit" id="btnShareFriends" value="{phrase var='share.send'}" class="button" />
					{img theme='ajax/small.gif' style="display:none" id="imgShareFriendsLoading"}
				</div>
			</div>
		</form>
	</div>	
</div>
