<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: account.html.php 2100 2010-11-09 14:58:35Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $sErrorType == 'email'}
<div class="error_message">{phrase var='facebook.we_already_have_an_account_created_with_us'}</div>
<div class="extra_info">
	{phrase var='facebook.note_that_if_you_sync_both_accounts'}
</div>
<ul class="action">
	<li><a href="{url link='facebook.account' process='email'}" class="sJsConfirm">{phrase var='facebook.yes_sync_both_accounts'}</a></li>
	<li><a href="#" onclick="$('#js_do_not_sync').toggle(); return false;">{phrase var='facebook.no_do_not_sync_both_accounts'}</a></li>
</ul>
<div class="p_4" style="display:none;" id="js_do_not_sync">
	<div class="message">
		{phrase var='facebook.you_have_chosen_to_not_sync_both_accounts'}
		<div class="p_4">
			<a href="http://www.facebook.com/settings/?tab=applications&app_id={$sFacebookAppId}">http://www.facebook.com/settings/?tab=applications&amp;app_id={$sFacebookAppId}</a>
		</div>
	</div>
</div>
{elseif $sErrorType == 'no-login'}
<div class="error_message">
	{phrase var='facebook.unable_to_login'}
</div>
{elseif $sErrorType == 'no-account'}
<div class="error_message">
	{phrase var='facebook.unable_to_fetch_your_facebook_account'}
</div>
{elseif $sErrorType == 'full-name'}
<div class="error_message">
	{phrase var='facebook.unable_to_fetch_your_full_name_from_facebook'}
</div>
{/if}