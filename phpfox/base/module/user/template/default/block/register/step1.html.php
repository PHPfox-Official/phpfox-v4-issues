	<div id="js_register_step1">
		{plugin call='user.template_default_block_register_step1_3'}
		{if Phpfox::getParam('user.split_full_name')}
		<div><input type="hidden" name="val[full_name]" id="full_name" value="stock" size="30" /></div>
		<div class="table">
			<div class="table_left">
				<label for="first_name">{required}{phrase var='user.first_name'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[first_name]" id="first_name" value="{value type='input' id='first_name'}" size="30" />
			</div>			
		</div>		
		<div class="table">
			<div class="table_left">
				<label for="last_name">{required}{phrase var='user.last_name'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[last_name]" id="last_name" value="{value type='input' id='last_name'}" size="30" />
			</div>			
		</div>		
		<div class="separate"></div>
		{else}
		<div class="table">
			<div class="table_left">
				<label for="full_name">{required}{phrase var='user.full_name'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[full_name]" id="full_name" value="{value type='input' id='full_name'}" size="30" />
			</div>			
		</div>
		{/if}
		{if !Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up')}
		<div class="table">
			<div class="table_left">
				<label for="user_name">{required}{phrase var='user.choose_a_username'}:</label>
			</div>
			<div class="table_right">                           
				<input type="text" name="val[user_name]" id="user_name" onkeyup="$('.bt-wrapper').remove(); $(this).ajaxCall('user.showUserName');" {if Phpfox::getParam('user.suggest_usernames_on_registration')}onfocus="$('#btn_verify_username').slideDown()"{/if} title="{phrase var='user.your_username_is_used_to_easily_connect_to_your_profile'}" value="{value type='input' id='user_name'}" size="30" autocomplete="off" />				
				<div class="p_4">
					{url link=''}<strong id="js_signup_user_name">{phrase var='user.your_user_name'}</strong>/
				</div>
				<div id="js_user_name_error_message"></div>
				<div style="display:none;" id="js_verify_username"></div>
                {if Phpfox::getParam('user.suggest_usernames_on_registration')}
				<div class="p_4" style="display:none;" id="btn_verify_username">
					<a href="#" onclick="$(this).ajaxCall('user.verifyUserName', 'user_name='+$('#user_name').val(), 'GET'); return false;">{phrase var='user.check_availability'}</a>
				</div>
				{/if}
			</div>			
		</div>		
		{/if}
		{if Phpfox::getParam('user.reenter_email_on_signup')}
		<div class="separate"></div>
		{/if}
		<div class="table">
			<div class="table_left">
				<label for="email">{required}{phrase var='user.email'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[email]" id="email" value="{value type='input' id='email'}" size="30" />
			</div>			
		</div>
		{if Phpfox::getParam('user.reenter_email_on_signup')}
		<div class="table">
			<div class="table_left"></div>
			<div class="table_right">
				<strong>{phrase var='user.please_reenter_your_email_again_below'}</strong>
				<div class="p_top_8">
					<input type="text" name="val[confirm_email]" id="confirm_email" value="{value type='input' id='confirm_email'}" size="30" onblur="$('#js_form').ajaxCall('user.confirmEmail');" />
				</div>
				<div id="js_confirm_email_error" style="display:none;"><div class="error_message">{phrase var='user.email_s_do_not_match'}</div></div>
			</div>			
		</div>				
		<div class="separate"></div>
		{/if}

		{plugin call='user.template_default_block_register_step1_5'}
		<div class="table">
			<div class="table_left">
				<label for="password">{required}{phrase var='user.password'}:</label>
			</div>
			<div class="table_right">
				{if isset($bIsPosted)}
				<input type="password" name="val[password]" id="password" value="{value type='input' id='password'}" size="30" />
				{else}
				<input type="password" name="val[password]" id="password" value="" size="30" />
				{/if}
			</div>			
		</div>
		{plugin call='user.template_default_block_register_step1_4'}
	</div>