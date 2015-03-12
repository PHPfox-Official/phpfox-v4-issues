<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: unlink.html.php 4854 2012-10-09 05:20:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bPass}
	{phrase var='facebook.you_have_successfully_unlinked_your_facebook_account_from_our_site'}<br /><br />
	<div class="message">
		{phrase var='facebook.to_complete_this_process_make_sure_to_remove_our_app_from_your_facebook_account_you_can_do_this_here'}:
		<br />
		<a href="http://www.facebook.com/settings/?tab=applications" target="_blank">http://www.facebook.com/settings/?tab=applications</a>
	</div>
{else}
<strong>
	{if $bNoApp}
	{phrase var='facebook.our_app_seems_to_have_been_uninstalled'}
	{else}
	{phrase var='facebook.facebook_unlink_info'}
	{/if}
</strong>
<div class="separate"></div>

<form method="post" action="#">
	<div class="table">
		<div class="table_left">
			{phrase var='facebook.email'}:
		</div>
		<div class="table_right">
			{$sCurrentEmail|clean}
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="table">
		<div class="table_left">
			{phrase var='facebook.password'}:
		</div>
		<div class="table_right">
			<input type="password" name="val[password]" value="" size="30" />
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="clear">
		<input type="submit" value="{phrase var='facebook.submit'}" class="button" />
	</div>
</form>
{/if}