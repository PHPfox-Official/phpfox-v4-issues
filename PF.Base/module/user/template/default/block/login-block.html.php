<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: login-block.html.php 5318 2013-02-04 10:38:35Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{plugin call='user.template_controller_login_block__start'}
<form method="post" action="{url link="user.login"}">
	<div class="table">
		<div class="table_right">
			<input placeholder="{if Phpfox::getParam('user.login_type') == 'user_name'}{phrase var='user.user_name'}{elseif Phpfox::getParam('user.login_type') == 'email'}{phrase var='user.email'}{else}{phrase var='user.login'}{/if}" type="text" name="val[login]" id="js_email" value="" size="30" />
		</div>
	</div>
	
	<div class="table">
		<div class="table_right main_user_pass">
			<div><input placeholder="{phrase var='user.password'}" type="password" name="val[password]" id="js_password" value="" size="30" /></div>
			<div><button><i class="fa fa-sign-in"></i></button></div>
		</div>
	</div>
	
	<div class="table_clear">
		{*<input type="submit" value="{phrase var='user.login_button'}" class="button btn-sm btn-danger" />*}
		<div class="user_rem_me">
			<label><input type="checkbox" name="val[remember_me]" value="" class="checkbox" /> {phrase var='user.remember'}</label>
		</div>
	</div>
</form>
{*
{if Phpfox::isModule('facebook') && Phpfox::getParam('facebook.enable_facebook_connect')}
<div class="p_top_8">	
	{phrase var='user.or_login_with'}:
	{if Phpfox::isModule('facebook') && Phpfox::getParam('facebook.enable_facebook_connect')}
	<div class="header_login_block"><div class="fbconnect_button"><fb:login-button scope="publish_stream,email,user_birthday" v="2"></fb:login-button></div></div>
	{/if}
</div>
{/if}
*}