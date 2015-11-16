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
<div class="block">
	<form class="content" method="post" action="{url link="user.login"}" id="js_login_form" onsubmit="{$sGetJsForm}">
		<div class="table">
			<div class="table_right">
				<input class="form-control" placeholder="{if Phpfox::getParam('user.login_type') == 'user_name'}{phrase var='user.user_name'}{elseif Phpfox::getParam('user.login_type') == 'email'}Email{else}{phrase var='user.login'}{/if}:" type="{if Phpfox::getParam('user.login_type') == 'email'}email{else}text{/if}" name="val[login]" id="login" value="{$sDefaultEmailInfo}" size="40" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="table">
			<div class="table_right">
				<input class="form-control" placeholder="{phrase var='user.password'}" type="password" name="val[password]" id="password" value="" size="40" />
			</div>
			<div class="clear"></div>
		</div>
		
		{plugin call='user.template_controller_login_end'}
		
		<div class="table_clear">
			<button type="submit" class="button btn-sm btn-danger">
				{phrase var='user.login_button'}
				<i class="fa fa-sign-in"></i>
			</button>
			<div class="p_top_15 checkbox">
				<label><input type="checkbox" class="checkbox" name="val[remember_me]" value="" /> {phrase var='user.remember'}</label>
			</div>

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
	</form>

	<div class="bottom">
		<ul>
			<li><a href="{$sSignUpPage}">Register</a></li>
			<li><a href="{url link='user.password.request'}">{phrase var='user.forgot_your_password'}</a></li>
		</ul>
	</div>
</div>