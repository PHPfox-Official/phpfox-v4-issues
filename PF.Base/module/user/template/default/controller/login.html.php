<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: login.html.php 3445 2011-11-03 13:11:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<div class="main_break">
	<form method="post" action="{url link="user.login"}" id="js_login_form" onsubmit="{$sGetJsForm}">
		<div class="table">
			<div class="table_left">
				<label for="login">{if Phpfox::getParam('user.login_type') == 'user_name'}{phrase var='user.user_name'}{elseif Phpfox::getParam('user.login_type') == 'email'}{phrase var='user.email'}{else}{phrase var='user.login'}{/if}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[login]" id="login" value="{$sDefaultEmailInfo}" size="40" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="table">
			<div class="table_left">
				<label for="password">{phrase var='user.password'}:</label>
			</div>
			<div class="table_right">
				<input type="password" name="val[password]" id="password" value="" size="40" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="table_clear">
			<label><input type="checkbox" class="checkbox" name="val[remember_me]" value="" /> {phrase var='user.remember'}</label>
		</div>
		
		{plugin call='user.template_controller_login_end'}
		
		<div class="table_clear">
			<input type="submit" value="{phrase var='user.login_button'}" class="button" />{if Phpfox::getParam('user.allow_user_registration')} {phrase var='user.sign_for_site_name' url=$sSignUpPage name=$sSiteName}{/if}
			{plugin call='user.template.login_header_set_var'}
			{if isset($bCustomLogin)}
			<div class="p_top_8">
				{phrase var='user.or_login_with'}:
				<div class="p_top_4">					
					{plugin call='user.template_controller_login_block__end'}
				</div>
			</div>
			{/if}
		</div>
		
		<div class="table_clear">
			<a href="{url link='user.password.request'}">{phrase var='user.forgot_your_password'}</a>
		</div>	
	</form>	
</div>