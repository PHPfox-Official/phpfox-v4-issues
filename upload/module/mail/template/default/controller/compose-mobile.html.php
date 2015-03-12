<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: compose-mobile.html.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='mail.compose'}">
	{if $bFriendIsSelected}
	<div><input type="hidden" name="val[to][]" value="{$aUser.user_id}" /></div>
	{/if}
	<div class="table">
		<div class="table_left">
			<a href="{url link='friend.select'}">{phrase var='mail.to'}</a>: {if $bFriendIsSelected}{$aUser.full_name|clean}{else}<a href="{url link='friend.select'}">{phrase var='mail.select_recipient'}</a>{/if}
		</div>		
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='mail.subject'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[subject]" value="{value type='input' id='subject'}" class="input_text" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='mail.message'}:
		</div>
		<div class="table_right">
			<textarea cols="60" rows="6" class="input_text" name="val[message]">{value type='textarea' id='message'}</textarea>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='mail.send'}" class="button" />
	</div>
</form>