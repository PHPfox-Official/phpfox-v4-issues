<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: email.html.php 6982 2013-12-10 13:22:50Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bCanSendEmails}
<script type="text/javascript">
{literal}
	function sendEmails(oObj)
	{
		$('#js_send_email_error_message').hide();
		
		if (empty($('#js_share_email').val()))
		{
			$('#js_send_email_error_message').show();
			
			return false;
		}
		$('#btnShareEmail').attr('disabled', 'disabled');
		$('#imgShareEmailLoading').show();
		$(oObj).ajaxCall('share.sendEmails');
		
		return false;
	}
{/literal}
</script>
<div>	
	<form method="post" action="#" onsubmit="return sendEmails(this);">
		<div class="p_4">
			<div id="js_send_email_error_message" class="error_message" style="display:none;">{phrase var='share.provide_an_e_mail_address'}</div>
			<div class="table">
				<div class="table_left">
					{phrase var='share.email_s'}:
				</div>
				<div class="table_right">
					<input type="text" name="val[to]" size="30" id="js_share_email" value="" />
					<div class="extra_info">
						{phrase var='share.separate_multiple_emails_with_a_comma'}
						{if $iEmailLimit > 0}
						<br />
						{phrase var='share.max_emails_limit' limit=$iEmailLimit}
						{/if}
					</div>
				</div>
			</div>			
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
				<input type="submit" id="btnShareEmail" value="{phrase var='share.send'}" class="button" />
				{img theme='ajax/small.gif' style="display:none" id="imgShareEmailLoading"}
			</div>
		</div>		
	</form>
</div>
{else}
<div class="label_flow p_4">	
	<div class="extra_info">
		{phrase var='share.you_are_unable_to_send_any_more_emails_we_have_a_limit_of_how_many_emails_can_be_sent_each_hour_br_current_limit_limit' limit=$iEmailLimit}
	</div>
</div>
{/if}