<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Friend
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Miguel_Espinoza $
 */

?>
{if !PHPFOX_IS_AJAX}
<div class="message">
	Send a gift to {$aUser.full_name} on {$aUser.gender|gender:1} birthday.
</div>
{/if}
<form action="{url link='current'}" onsubmit="$(this).ajaxCall('friend.sendCongrats'); return false;" method="post" name="js_frm_congratulate" id="js_form_congratulate">
	{plugin call='friend.template_block_congratulate_form'}	
	<div><input type="hidden" name="val[iUser]" value="{$iUser}" /></div>
	{if !PHPFOX_IS_AJAX}
	<div><input type="hidden" name="val[inline]" value="true" /></div>
	{/if}
	<div class="table">
		<div class="table_left">
			Message:
		</div>
		<div class="table_right">
			<textarea name="val[message]" cols="30" rows="4"></textarea>
		</div>
	</div>
	{module name='egift.display'}
	<div class="table_clear">
		<input type="submit" value="Send" class="button" />
		{if PHPFOX_IS_AJAX}
		<input type="button" value="{phrase var='friend.cancel'}" class="button button_off" onclick="tb_remove();" />
		{/if}
	</div>	
</form>