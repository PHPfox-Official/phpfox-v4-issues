<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>brute_force_attempts_count</var_name>
			<phrase_var_name>setting_brute_force_attempts_count</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>5</value>
		</setting>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>brute_force_time_check</var_name>
			<phrase_var_name>setting_brute_force_time_check</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>brute_force_cool_down</var_name>
			<phrase_var_name>setting_brute_force_cool_down</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>15</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>inactive_member_email_subject</var_name>
			<added>1296833975</added>
			<value>We have missed you</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>inactive_member_email_body</var_name>
			<added>1297074929</added>
			<value><![CDATA[<p>Hello {user_name},<br />
we have missed you at <a href="{site_url}">{site_name}</a> <br /><br />
Why not come and pay a visit to your friends, there's lots of catching up to do</p>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>there_are_a_total_of_icount_inactive_members</var_name>
			<added>1297086852</added>
			<value>There are a totoal of {iCount} inactive members</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>enter_a_number_of_days</var_name>
			<added>1297087186</added>
			<value>Enter a number of days</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>enter_a_number_to_size_each_batch</var_name>
			<added>1297087223</added>
			<value>Enter a number to size each batch</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>not_enough_users_to_mail</var_name>
			<added>1297087333</added>
			<value>Not enough users to mail</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>user_setting_can_member_snoop</var_name>
			<added>1297692328</added>
			<value>Can members of this user group log in as another user without entering a password?</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>log_in_as_this_user</var_name>
			<added>1297697254</added>
			<value>Log in as this user</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>member_snoop</var_name>
			<added>1297697278</added>
			<value>Member Snoop</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>member_snoop_text</var_name>
			<added>1297697535</added>
			<value><![CDATA[You are about to log in as the user <a href="{user_link}" target="_blank">{user_name}</a> ({full_name}). This has the same effect as if you logged in with that user's password. When in this mode, all your actions will be	regarded as executed by {full_name}. <br /> To go back to your admin user you will need to log out and back in.]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>abort_log_in_as_this_user</var_name>
			<added>1297697736</added>
			<value>Abort log in as this user</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>deny_mail_subject</var_name>
			<added>1298464722</added>
			<value>Your registration to {site_name} has been denied</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>deny_mail_message</var_name>
			<added>1298464944</added>
			<value>At this moment your profile does not meet the minimum requirements for our site. 
If you feel this is an error, feel free to contact us to {site_email}</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>you_are_about_to_deny_user</var_name>
			<added>1298470496</added>
			<value><![CDATA[You are about to deny user <a href="{link}">{user_name}</a> from the site.
If you want to send an email to this user you may do it here]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>deny_and_send_email</var_name>
			<added>1298471061</added>
			<value>Deny and send email</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>deny_without_email</var_name>
			<added>1298471080</added>
			<value>Deny without email</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_brute_force_attempts_count</var_name>
			<added>1299680854</added>
			<value><![CDATA[<title>Brute Force Prevention: Attempts Count</title><info>How many attempts are allowed within the time limit? 

This setting is used together with "Brute Force Prevention: Time limit" to better protect your site from brute force login attempts. 

You define a time in minutes and how many failed attempts are allowed within that period of time, if a user fails to log in within that period of time, missing this many tries the account is locked for a certain time, this lock time is defined by the cool down time and during this time even if the correct log in is entered, access will be denied.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_brute_force_time_check</var_name>
			<added>1299681159</added>
			<value><![CDATA[<title>Brute Force Prevention: Time Limit</title><info>How many minutes back should the script check?
Set this to 0 if you do not want to run this check

This setting is used together with "Brute Force Prevention: Attempts Count" to better protect your site from brute force login attempts.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_brute_force_cool_down</var_name>
			<added>1299682133</added>
			<value><![CDATA[<title>Brute Force Prevention: Cool Down</title><info>When an account has been locked due to a brute force check, how many minutes should the user wait before unlocking the account?</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.8</version_id>
			<var_name>brute_force_account_locked</var_name>
			<added>1299683217</added>
			<value><![CDATA[Brute force attempt logged. Your account has been locked for {iCoolDown} minutes. If you forgot your password please use the <a href="{sForgotLink}">Forgot Password tool</a>.
You can try to log in again in {iUnlockTimeOut} minutes.]]></value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>user</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>user</module>
			<ordering>0</ordering>
			<value>can_member_snoop</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_admincp_ban_clean</call_name>
			<added>1298455495</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_browse_get__start</call_name>
			<added>1298902308</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_browse_get__cnt</call_name>
			<added>1298902308</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:17:"phpfox_user_field";a:1:{s:21:"brute_force_locked_at";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}s:7:"ADD_KEY";a:1:{s:14:"phpfox_user_ip";a:1:{s:9:"user_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"type_id";}}}}}]]></sql>
</upgrade>