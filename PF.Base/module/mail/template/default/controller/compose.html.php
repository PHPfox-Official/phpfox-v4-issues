<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Mail
 * @version 		$Id: compose.html.php 4921 2012-10-22 13:47:30Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}

<div id="js_ajax_compose_error_message"></div>
<div>
	<form method="post" action="{url link='mail.compose'}" id="js_form_mail">
	
	{if isset($iPageId)}
		<div><input type="hidden" name="val[page_id]" value="{$iPageId}"></div>
		<div><input type="hidden" name="val[sending_message]" value="{$iPageId}"></div>
	{/if}
	
	{token}
	<div><input type="hidden" name="val[attachment]" class="js_attachment" value="{value type='input' id='attachment'}" /></div>
	{if isset($bIsThreadForward) && $bIsThreadForward}
	<div><input type="hidden" name="val[forwards]" value="{$sThreadsToForward}" /></div>
	<div><input type="hidden" name="val[forward_thread_id]" value="{$sForwardThreadId}" /></div>
	{/if}
	{if PHPFOX_IS_AJAX && isset($aUser.user_id)}
	<div><input type="hidden" name="id" value="{$aUser.user_id}" /></div>
	<div><input type="hidden" name="val[to][]" value="{$aUser.user_id}" /></div>
	{else}
		<div class="table">
			<div class="table_left">
				{phrase var='mail.to'}:
			</div>
			<div class="table_right">					
				<div id="js_mail_search_friend_placement" style="width:410px;"></div>
				<div id="js_mail_search_friend"></div>
				<script type="text/javascript">
				var bRun = true;
				$Behavior.loadSearchFriendsCompose = function()
				{l}
					bRun = false;
					{if Phpfox::getUserParam('mail.restrict_message_to_friends') == true}
						$Core.searchFriends({l}
							'id': '#js_mail_search_friend',
							'placement': '#js_mail_search_friend_placement',
							'width': '{if Phpfox::isMobile()}90%{else}400px{/if}',
							'max_search': 10,
							'input_name': 'val[to]',
							'default_value': '{phrase var='mail.search_friends_by_their_name'}',
							'inline_bubble': true
						{r});		
					{else}
						$Core.searchFriends({l}
							'id': '#js_mail_search_friend',
							'placement': '#js_mail_search_friend_placement',
							'width': '{if Phpfox::isMobile()}90%{else}400px{/if}',
							'max_search': 10,
							'input_name': 'val[to]',
							'default_value': '{phrase var='mail.search_friends_by_their_name'}',
							'inline_bubble': true,
							'is_mail' : true
						{r});		
					{/if}	
				{r}
				// if (bRun)$Behavior.loadSearchFriendsCompose();
				</script>				
			</div>
		</div>
	{/if}
		{if !Phpfox::getParam('mail.threaded_mail_conversation')}
		<div class="table">
			<div class="table_right">
				<input type="text" name="val[subject]" id="subject" value="{if isset($iPageId)}{phrase var='mail.claiming_page_title' title=$aPage.title}{else}{value type='input' id='subject'}{/if}" size="40" style="{if Phpfox::isMobile()}width:90%;{else}width:400px;{/if}" tabindex="1" />
			</div>
			<div class="clear"></div>
		</div>
		{/if}
		<div class="table">
			<div class="table_right" id="js_compose_new_message">
				{editor id='message' enter=true}
			</div>
			<div class="clear"></div>
		</div>
		
		{if Phpfox::isModule('captcha') && Phpfox::getUserParam('mail.enable_captcha_on_mail')}
			{module name='captcha.form' sType='mail'}
		{/if}
	</form>
</div>


{if isset($sMessageClaim)}
	<script type="text/javascript">
		$('#js_compose_new_message #message').html('{$sMessageClaim}');
	</script>
{/if}
{literal}
<script>
	$Ready(function() {
		if ($('#js_compose_new_message #message').length) {
			$('#js_compose_new_message #message').focus().parents('form:first').submit(function() {
				$Core.processForm('#js_mail_compose_submit');
				$(this).ajaxCall('mail.composeProcess');
				return false;
			});
		}
	});
</script>
{/literal}