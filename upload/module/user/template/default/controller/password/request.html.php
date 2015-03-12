<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: request.html.php 1245 2009-11-02 16:10:29Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break">
	<form method="post" action="{url link='user.password.request'}">
		<div class="table">
			<div class="table_left">
				<label for="email">{phrase var='user.email'}</label>:
			</div>
			<div class="table_right">
				<input type="text" name="email" id="email" value="" size="40" />
			</div>
			<div class="clear"></div>
		</div>
		{if Phpfox::isModule('captcha')}{module name='captcha.form' sType='lostpassword'}{/if}
		<div class="table_clear">
			<input type="submit" value="{phrase var='user.request_new_password'}" class="button" />
		</div>	
	</form>
</div>