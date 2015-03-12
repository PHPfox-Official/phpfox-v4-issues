<module>
	<data>
		<module_id>facebook</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_facebook</phrase_var_name>
		<writable />
	</data>
	<setting_groups>
		<name module_id="facebook" version_id="2.0.4" var_name="setting_group_facebook_connect">facebook_connect</name>
	</setting_groups>
	<settings>
		<setting group="facebook_connect" module_id="facebook" is_hidden="0" type="string" var_name="facebook_app_id" phrase_var_name="setting_facebook_app_id" ordering="4" version_id="2.0.5" />
		<setting group="facebook_connect" module_id="facebook" is_hidden="0" type="boolean" var_name="enable_facebook_connect" phrase_var_name="setting_enable_facebook_connect" ordering="1" version_id="2.0.4">0</setting>
		<setting group="facebook_connect" module_id="facebook" is_hidden="0" type="string" var_name="facebook_secret" phrase_var_name="setting_facebook_secret" ordering="3" version_id="2.0.4" />
		<setting group="" module_id="facebook" is_hidden="1" type="boolean" var_name="facebook_like_event" phrase_var_name="setting_facebook_like_event" ordering="9" version_id="2.0.5dev1">1</setting>
		<setting group="" module_id="facebook" is_hidden="1" type="boolean" var_name="facebook_like_group" phrase_var_name="setting_facebook_like_group" ordering="8" version_id="2.0.5dev1">1</setting>
		<setting group="" module_id="facebook" is_hidden="1" type="boolean" var_name="facebook_like_video" phrase_var_name="setting_facebook_like_video" ordering="7" version_id="2.0.5dev1">1</setting>
		<setting group="" module_id="facebook" is_hidden="1" type="boolean" var_name="facebook_like_photo" phrase_var_name="setting_facebook_like_photo" ordering="6" version_id="2.0.5dev1">1</setting>
		<setting group="" module_id="facebook" is_hidden="1" type="boolean" var_name="facebook_like_blog" phrase_var_name="setting_facebook_like_blog" ordering="5" version_id="2.0.5dev1">1</setting>
		<setting group="facebook_connect" module_id="facebook" is_hidden="1" type="string" var_name="facebook_api_key" phrase_var_name="setting_facebook_api_key" ordering="2" version_id="2.0.4" />
		<setting group="" module_id="facebook" is_hidden="1" type="boolean" var_name="facebook_like_marketplace" phrase_var_name="setting_facebook_like_marketplace" ordering="10" version_id="2.0.5dev1">1</setting>
	</settings>
	<hooks>
		<hook module_id="facebook" hook_type="controller" module="facebook" call_name="facebook.component_controller_account_clean" added="1290072896" version_id="2.0.7" />
		<hook module_id="facebook" hook_type="controller" module="facebook" call_name="facebook.component_controller_sync_clean" added="1286546859" version_id="2.0.7" />
		<hook module_id="facebook" hook_type="controller" module="facebook" call_name="facebook.component_controller_email_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="facebook" hook_type="controller" module="facebook" call_name="facebook.component_controller_logout_mobile_clean" added="1268138234" version_id="2.0.4" />
		<hook module_id="facebook" hook_type="controller" module="facebook" call_name="facebook.component_controller_index_clean" added="1266260139" version_id="2.0.4" />
		<hook module_id="facebook" hook_type="controller" module="facebook" call_name="facebook.component_controller_logout_clean" added="1266260139" version_id="2.0.4" />
		<hook module_id="facebook" hook_type="service" module="facebook" call_name="facebook.service_facebook__call" added="1266260139" version_id="2.0.4" />
		<hook module_id="facebook" hook_type="service" module="facebook" call_name="facebook.service_api__call" added="1266260139" version_id="2.0.4" />
		<hook module_id="facebook" hook_type="service" module="facebook" call_name="facebook.service_callback__call" added="1266260139" version_id="2.0.4" />
		<hook module_id="facebook" hook_type="service" module="facebook" call_name="facebook.service_process__call" added="1266260139" version_id="2.0.4" />
		<hook module_id="facebook" hook_type="controller" module="facebook" call_name="facebook.component_controller_frame_clean" added="1290072896" version_id="2.0.7" />
		<hook module_id="facebook" hook_type="controller" module="facebook" call_name="facebook.component_controller_unlink_clean" added="1358258443" version_id="3.5.0beta1" />
	</hooks>
	<phrases>
		<phrase module_id="facebook" version_id="2.0.4" var_name="module_facebook" added="1264688556">Facebook Module</phrase>
		<phrase module_id="facebook" version_id="2.0.4" var_name="setting_group_facebook_connect" added="1264689344"><![CDATA[<title>Facebook Connect</title><info>Facebook Connect</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.4" var_name="setting_facebook_api_key" added="1264689434"><![CDATA[<title>Facebook API Key</title><info>Provide the API Key for your Facebook application.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.4" var_name="setting_facebook_secret" added="1264689485"><![CDATA[<title>Facebook Secret</title><info>Provide the secret key for your Facebook application.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.4" var_name="setting_enable_facebook_connect" added="1265987360"><![CDATA[<title>Enable Facebook Connect</title><info>Set this to <b>True</b> to enable Facebook connect.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.4" var_name="please_hold_while_you_are_redirected" added="1266261674">Please hold while you are redirected...</phrase>
		<phrase module_id="facebook" version_id="2.0.5" var_name="setting_facebook_app_id" added="1272970806"><![CDATA[<title>Application ID</title><info>Provide the Application ID for your Facebook application.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.5" var_name="facebook_connect" added="1273144993">Facebook Connect</phrase>
		<phrase module_id="facebook" version_id="2.0.5" var_name="the_email_you_have_associated_with_facebook_is_already_in_use" added="1273145141">The email you have associated with Facebook is already in use on our website and cannot be used with this account.</phrase>
		<phrase module_id="facebook" version_id="2.0.5dev1" var_name="setting_facebook_like_blog" added="1274191742"><![CDATA[<title>Enable Facebook Like Button (Blogs)</title><info>Enable to use the Facebook Like Button feature.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.5dev1" var_name="setting_facebook_like_photo" added="1274192408"><![CDATA[<title>Enable Facebook Like Button (Photo)</title><info>Enable to use the Facebook Like Button feature.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.5dev1" var_name="setting_facebook_like_video" added="1274193338"><![CDATA[<title>Enable Facebook Like Button (Video)</title><info>Enable to use the Facebook Like Button feature.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.5dev1" var_name="setting_facebook_like_group" added="1274193550"><![CDATA[<title>Enable Facebook Like Button (Groups)</title><info>Enable to use the Facebook Like Button feature.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.5dev1" var_name="setting_facebook_like_event" added="1274278715"><![CDATA[<title>Enable Facebook Like Button (Events)</title><info>Enable to use the Facebook Like Button feature.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.5dev1" var_name="setting_facebook_like_marketplace" added="1274278840"><![CDATA[<title>Enable Facebook Like Button (Marketplace)</title><info>Enable to use the Facebook Like Button feature.</info>]]></phrase>
		<phrase module_id="facebook" version_id="2.0.5" var_name="facebook_sync" added="1276427364">Facebook Sync</phrase>
		<phrase module_id="facebook" version_id="2.0.5" var_name="please_take_a_moment_to_sync_your_facebook_account_with_our_community" added="1276427380">Please take a moment to sync your Facebook account with our community.</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="or_login_with" added="1287493443">Or login with:</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="facebook_connect_account_issues" added="1289310719">Facebook Connect Account Issues</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="we_already_have_an_account_created_with_us" added="1289310877">We already have an account created with us with the same email you have on Facebook. Would you like to sync both accounts?</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="note_that_if_you_sync_both_accounts" added="1289314457">Note that if you sync both accounts you will not be able to use the original account here other then logging in with Facebook Connect.</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="yes_sync_both_accounts" added="1289314465">Yes, sync both accounts.</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="no_do_not_sync_both_accounts" added="1289314474">No, do not sync both accounts.</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="you_have_chosen_to_not_sync_both_accounts" added="1289314492">You have chosen to not sync both accounts. To complete this process please remove this Facebook Connection here:</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="unable_to_login" added="1289314532">Unable to login.</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="unable_to_fetch_your_facebook_account" added="1289314557">Unable to fetch your Facebook account.</phrase>
		<phrase module_id="facebook" version_id="2.0.7" var_name="unable_to_fetch_your_full_name_from_facebook" added="1289314585">Unable to fetch your full name from Facebook.</phrase>
		<phrase module_id="facebook" version_id="2.1.0beta2" var_name="your_account_is_synced_with_your_facebook_account" added="1301391778">Your account is synced with your Facebook account. Please login using Facebook Connect.</phrase>
		<phrase module_id="facebook" version_id="3.3.0rc1" var_name="connecting_to_facebook_please_hold" added="1341397384">Connecting to Facebook. Please hold...</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="successfully_unlinked_your_facebook_account" added="1348746543">Successfully unlinked your Facebook account.</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="unlink_facebook_connect" added="1348746553">Unlink Facebook Connect</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="facebook_unlink_info" added="1348746578">You are about to unlink the account you have with us from your Facebook account. In order to do this, you will have to have a valid email and password with us. To complete the process please fill out the form below.</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="email" added="1348746583">Email</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="submit" added="1348746593">Submit</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="enter_a_password" added="1348746608">Enter a password.</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="password" added="1348807956">Password</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="you_have_successfully_unlinked_your_facebook_account_from_our_site" added="1348809173">You have successfully unlinked your Facebook account from our site.</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="to_complete_this_process_make_sure_to_remove_our_app_from_your_facebook_account_you_can_do_this_here" added="1348809185">To complete this process make sure to remove our App from your Facebook account. You can do this here</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="our_app_seems_to_have_been_uninstalled" added="1348809200">Our app seems to have been uninstalled from your Facebook account. In order to continue using our site please unlink your account with us from your Facebook. In order to do this you will have to have a valid email and password with us. To complete the process please fill out the form below.</phrase>
		<phrase module_id="facebook" version_id="3.4.0beta2" var_name="unlink_facebook_account" added="1348809226">Unlink Facebook Account</phrase>
	</phrases>
	<tables><![CDATA[a:1:{s:16:"phpfox_fbconnect";a:2:{s:7:"COLUMNS";a:6:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"fb_user_id";a:4:{i:0;s:4:"BINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"share_feed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"send_email";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"is_proxy_email";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_unlinked";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}s:10:"fb_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"fb_user_id";}}}}]]></tables>
</module>