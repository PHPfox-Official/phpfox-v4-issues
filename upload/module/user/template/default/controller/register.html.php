<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: register.html.php 5143 2013-01-15 14:16:21Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{literal}
<script type="text/javascript">
$Behavior.termsAndPrivacy = function()
{
	$('#js_terms_of_use').click(function()
	{
		{/literal}
		tb_show('{phrase var='user.terms_of_use' phpfox_squote=true phpfox_squote=true phpfox_squote=true phpfox_squote=true phpfox_squote=true phpfox_squote=true}', $.ajaxBox('page.view', 'height=410&width=600&title=terms')); 
		{literal}
		return false;
	});
	
	$('#js_privacy_policy').click(function()
	{
		{/literal}
		tb_show('{phrase var='user.privacy_policy' phpfox_squote=true phpfox_squote=true phpfox_squote=true phpfox_squote=true phpfox_squote=true phpfox_squote=true}', $.ajaxBox('page.view', 'height=410&width=600&title=policy')); 
		{literal}
		return false;
	});
}
</script>
{/literal}

{if Phpfox::getLib('module')->getFullControllerName() == 'user.register' && Phpfox::isModule('invite')}
<div id="main_registration_form">

	<h1>{phrase var='user.sign_up_for_ssitetitle' sSiteTitle=$sSiteTitle}</h1>
	<div class="extra_info">
		{phrase var='user.join_ssitetitle_to_connect_with_friends_share_photos_and_create_your_own_profile' sSiteTitle=$sSiteTitle}
	</div>
	<div id="main_registration_form_holder">
		{if ((Phpfox::isModule('facebook') && Phpfox::getParam('facebook.enable_facebook_connect')) || (Phpfox::isModule('janrain') && Phpfox::getParam('janrain.enable_janrain_login'))) && !Phpfox::getService('invite')->isInviteOnly()}
		<div id="main_registration_custom">
			{phrase var='user.or_sign_up_with'}:
			{if Phpfox::isModule('facebook') && Phpfox::getParam('facebook.enable_facebook_connect')}
			<div class="header_login_block">
				<fb:login-button scope="publish_stream,email,user_birthday" v="2"></fb:login-button>
			</div>
			{/if}	
			{if Phpfox::isModule('janrain') && Phpfox::getParam('janrain.enable_janrain_login')}
			<div class="header_login_block">
				<a class="rpxnow" onclick="return false;" href="{$sJanrainUrl}">{img theme='layout/janrain-icons.png'}</a>
			</div>
			{/if}
		</div>
		{/if}
{/if}
{if Phpfox::getLib('module')->getFullControllerName() != 'user.register'}
<div class="user_register_holder">
	<div class="holder">
		<div class="user_register_intro">		
			{module name='user.welcome'}
		</div>
		<div class="user_register_form">

			{if Phpfox::getParam('user.allow_user_registration')}
			<div class="user_register_title">
				{phrase var='user.sign_up'}
				<div class="extra_info">
					{phrase var='user.it_s_free_and_always_will_be'}
				</div>
			</div>
			{/if}
{/if}
		{if Phpfox::isModule('invite') && Phpfox::getService('invite')->isInviteOnly()}
		<div class="main_break">
			<div class="extra_info">				
				{phrase var='user.ssitetitle_is_an_invite_only_community_enter_your_email_below_if_you_have_received_an_invitation' sSiteTitle=$sSiteTitle}
			</div>
			<div class="main_break">
				<form method="post" action="{url link='user.register'}">
					<div class="table">
						<div class="table_left">
							{phrase var='user.email'}:
						</div>
						<div class="table_right">
							<input type="text" name="val[invite_email]" value="" />
						</div>
					</div>
					<div class="table_clear">
						<input type="submit" value="{phrase var='user.submit'}" class="button_register" />
					</div>
				</form>
			</div>
		</div>
		{else}
		{if isset($sCreateJs)}
		{$sCreateJs}
		{/if}
		<div id="js_registration_process" class="t_center" style="display:none;">
			<div class="p_top_8">				
				{img theme='ajax/add.gif' alt=''}
			</div>
		</div>
		<div id="js_signup_error_message" style="width:350px;"></div>
		{if Phpfox::getParam('user.allow_user_registration')}
			<div class="main_break" id="js_registration_holder">	
				<form method="post" action="{url link='user.register'}" id="js_form" enctype="multipart/form-data">	
				{token}

					<div id="js_signup_block">
						{if isset($bIsPosted) || !Phpfox::getParam('user.multi_step_registration_form')}
						<div>
							{template file='user.block.register.step1'}
							{template file='user.block.register.step2'}
						</div>
						{else}
							{template file='user.block.register.step1'}			
						{/if}
					</div>		
					{plugin call='user.template_controller_register_pre_captcha'}
					{if Phpfox::isModule('captcha') && Phpfox::getParam('user.captcha_on_signup')}
					<div id="js_register_capthca_image"{if Phpfox::getParam('user.multi_step_registration_form') && !isset($bIsPosted)} style="display:none;"{/if}>
						{module name='captcha.form'}
					</div>
					{/if}			
					
					{if Phpfox::getParam('user.new_user_terms_confirmation')}
					<div id="js_register_accept">
						<div class="table">			
							<div class="table_clear">
								<input type="checkbox" name="val[agree]" id="agree" value="1" class="checkbox v_middle" {value type='checkbox' id='agree' default='1'}/> {required}{phrase var='user.i_have_read_and_agree_to_the_a_href_id_js_terms_of_use_terms_of_use_a_and_a_href_id_js_privacy_policy_privacy_policy_a'}					
							</div>			
						</div>	
					</div>					
					{/if}
					
					<div class="table_clear">
					{if isset($bIsPosted) || !Phpfox::getParam('user.multi_step_registration_form')}
						<input type="submit" value="{phrase var='user.sign_up'}" class="button_register" id="js_registration_submit" />
					{else}
						<input type="button" value="{phrase var='user.sign_up'}" class="button_register" id="js_registration_submit" onclick="$Core.registration.submitForm();" />
					{/if}
					</div>
				</form>
			</div>
			{/if}
		{/if}
{if Phpfox::getLib('module')->getFullControllerName() != 'user.register'}
		</div>
		<div class="clear"></div>
	</div>
	{module name='user.images'}
</div>
{/if}
{if Phpfox::getLib('module')->getFullControllerName() == 'user.register'}
	</div>
</div>
{/if}