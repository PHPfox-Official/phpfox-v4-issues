<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index-visitor-mobile.html.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link=''}">
	<div class="table">
		<div class="table_left">
			{if Phpfox::getParam('user.login_type') == 'user_name'}{phrase var='user.user_name'}{elseif Phpfox::getParam('user.login_type') == 'email'}{phrase var='user.email'}{else}{phrase var='user.login'}{/if}:
		</div>
		<div class="table_right">
			<input type="text" name="val[login]" value="" size="30" class="input_text" />
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='user.password'}:
		</div>
		<div class="table_right">
			<input type="password" name="val[password]" id="js_password" value="" size="30" class="input_text" />
		</div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='user.login_button'}" class="button" />
	</div>
</form>