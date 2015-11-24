<module>
	<data>
		<module_id>user</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:1:{s:60:"user.admin_menu_phrase_var_user_anti_spam_security_questions";a:1:{s:3:"url";a:2:{i:0;s:4:"user";i:1;s:4:"spam";}}}]]></menu>
		<phrase_var_name>module_user</phrase_var_name>
		<writable><![CDATA[a:2:{i:0;s:14:"file/pic/user/";i:1;s:28:"file/pic/user/spam_question/";}]]></writable>
	</data>
	<menus>
		<menu module_id="user" parent_var_name="" m_connection="user.setting" var_name="menu_privacy_settings" ordering="34" url_value="user.privacy" version_id="2.0.0alpha1" disallow_access="" module="user" />
		<menu module_id="user" parent_var_name="" m_connection="main" var_name="menu_browse" ordering="3" url_value="user.browse" version_id="2.0.0alpha1" disallow_access="" module="user" mobile_icon="users" />
		<menu module_id="user" parent_var_name="" m_connection="main_right" var_name="menu_settings" ordering="5" url_value="user.setting" version_id="2.0.0alpha1" disallow_access="a:1:{i:0;s:1:&quot;3&quot;;}" module="user" />
		<menu module_id="user" parent_var_name="" m_connection="user.setting" var_name="menu_account_settings" ordering="20" url_value="user.setting" version_id="2.0.0alpha1" disallow_access="" module="user" />
		<menu module_id="user" parent_var_name="" m_connection="profile.my" var_name="menu_edit_profile_picture" ordering="3" url_value="user.photo" version_id="2.0.0alpha1" disallow_access="" module="user" />
		<menu module_id="user" parent_var_name="" m_connection="user.privacy" var_name="menu_account_settings" ordering="55" url_value="user.setting" version_id="2.0.0alpha2" disallow_access="" module="user" />
		<menu module_id="user" parent_var_name="" m_connection="user.privacy" var_name="menu_privacy_settings" ordering="57" url_value="user.privacy" version_id="2.0.0alpha2" disallow_access="" module="user" />
		<menu module_id="user" parent_var_name="" m_connection="profile.my" var_name="menu_edit_profile" ordering="2" url_value="user.profile" version_id="2.0.0alpha3" disallow_access="" module="user" />
		<menu module_id="user" parent_var_name="" m_connection="mobile" var_name="menu_user_members_532c28d5412dd75bf975fb951c740a30" ordering="126" url_value="user.browse" version_id="3.1.0rc1" disallow_access="" module="user" mobile_icon="small_groups.png" />
		<menu module_id="user" parent_var_name="menu_settings" m_connection="" var_name="menu_user_logout_4ee1a589029a67e7f1a00990a1786f46" ordering="109" url_value="user.logout" version_id="3.0.0Beta1" disallow_access="a:1:{i:0;s:1:&quot;3&quot;;}" module="user" />
		<menu module_id="user" parent_var_name="menu_settings" m_connection="" var_name="menu_user_account_settings_73c8da87d666df89aabd61620c81c24c" ordering="107" url_value="user.setting" version_id="3.0.0beta4" disallow_access="" module="user" />
		<menu module_id="user" parent_var_name="menu_settings" m_connection="" var_name="menu_user_privacy_settings_73c8da87d666df89aabd61620c81c24c" ordering="108" url_value="user.privacy" version_id="3.0.0beta4" disallow_access="" module="user" />
	</menus>
	<settings>
        <setting group="registration" module_id="user" is_hidden="0" type="array" var_name="global_genders" phrase_var_name="setting_global_genders" ordering="1" version_id="2.0.5dev2"><![CDATA[s:112:"array(
  0 => '1|core.his|profile.male|core.himself',
  1 => '2|core.her|profile.female|core.herself|female',
);";]]></setting>
		<setting group="" module_id="user" is_hidden="0" type="string" var_name="redirect_after_login" phrase_var_name="setting_redirect_after_login" ordering="2" version_id="2.0.0alpha1" />
		<setting group="" module_id="user" is_hidden="0" type="array" var_name="user_pic_sizes" phrase_var_name="setting_user_pic_sizes" ordering="1" version_id="2.0.0alpha1"><![CDATA[s:103:"array(
  0 => '20',
  1 => '50',
  2 => '60',
  3 => '75',
  4 => '100',
  5 => '120',
  6 => '200',
);";]]></setting>
		<setting group="" module_id="user" is_hidden="0" type="drop" var_name="login_type" phrase_var_name="setting_login_type" ordering="1" version_id="2.0.0alpha1"><![CDATA[a:2:{s:7:"default";s:5:"email";s:6:"values";a:3:{i:0;s:5:"email";i:1;s:9:"user_name";i:2;s:4:"both";}}]]></setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="profile_use_id" phrase_var_name="setting_profile_use_id" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="captcha_on_signup" phrase_var_name="setting_captcha_on_signup" ordering="9" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="user_profile_private_age" phrase_var_name="setting_user_profile_private_age" ordering="1" version_id="2.0.0beta4">0</setting>
		<setting group="spam" module_id="user" is_hidden="0" type="boolean" var_name="validate_full_name" phrase_var_name="setting_validate_full_name" ordering="12" version_id="2.0.0beta4">1</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="randomize_featured_members" phrase_var_name="setting_randomize_featured_members" ordering="1" version_id="2.0.0beta5">1</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="how_many_featured_members" phrase_var_name="setting_how_many_featured_members" ordering="1" version_id="2.0.0beta5">6</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="verify_email_at_signup" phrase_var_name="setting_verify_email_at_signup" ordering="3" version_id="2.0.0beta5">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="verify_email_timeout" phrase_var_name="setting_verify_email_timeout" ordering="1" version_id="2.0.0beta5">60</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="logout_after_change_email_if_verify" phrase_var_name="setting_logout_after_change_email_if_verify" ordering="1" version_id="2.0.0beta5">1</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="display_user_online_status" phrase_var_name="setting_display_user_online_status" ordering="1" version_id="2.0.0rc1">0</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="integer" var_name="min_length_for_username" phrase_var_name="setting_min_length_for_username" ordering="4" version_id="2.0.0rc2">5</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="integer" var_name="max_length_for_username" phrase_var_name="setting_max_length_for_username" ordering="5" version_id="2.0.0rc2">25</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="integer" var_name="on_signup_new_friend" phrase_var_name="setting_on_signup_new_friend" ordering="10" version_id="2.0.0rc4">0</setting>
		<setting group="spam" module_id="user" is_hidden="0" type="integer" var_name="check_status_updates" phrase_var_name="setting_check_status_updates" ordering="13" version_id="2.0.0rc5">1</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="string" var_name="redirect_after_signup" phrase_var_name="setting_redirect_after_signup" ordering="12" version_id="2.0.0rc10" />
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="date_of_birth_start" phrase_var_name="setting_date_of_birth_start" ordering="1" version_id="2.0.0rc11">1900</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="date_of_birth_end" phrase_var_name="setting_date_of_birth_end" ordering="1" version_id="2.0.0rc11">1997</setting>
		<setting group="" module_id="user" is_hidden="0" type="drop" var_name="user_browse_default_result" phrase_var_name="setting_user_browse_default_result" ordering="1" version_id="2.0.0rc12"><![CDATA[a:2:{s:7:"default";s:9:"full_name";s:6:"values";a:2:{i:0;s:9:"full_name";i:1;s:10:"last_login";}}]]></setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="remove_users_hidden_age" phrase_var_name="setting_remove_users_hidden_age" ordering="1" version_id="2.0.0rc12">0</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="drop" var_name="on_register_privacy_setting" phrase_var_name="setting_on_register_privacy_setting" ordering="11" version_id="2.0.0rc12"><![CDATA[a:2:{s:7:"default";s:6:"anyone";s:6:"values";a:4:{i:0;s:6:"anyone";i:1;s:7:"network";i:2;s:12:"friends_only";i:3;s:6:"no_one";}}]]></setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="min_count_for_top_rating" phrase_var_name="setting_min_count_for_top_rating" ordering="1" version_id="2.0.0">0</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="approve_users" phrase_var_name="setting_approve_users" ordering="13" version_id="2.0.5">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="drop" var_name="display_or_full_name" phrase_var_name="setting_display_or_full_name" ordering="1" version_id="2.0.5"><![CDATA[a:2:{s:7:"default";s:9:"full_name";s:6:"values";a:2:{i:0;s:9:"full_name";i:1;s:12:"display_name";}}]]></setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="disable_username_on_sign_up" phrase_var_name="setting_disable_username_on_sign_up" ordering="14" version_id="2.0.5dev1">1</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="check_promotion_system" phrase_var_name="setting_check_promotion_system" ordering="1" version_id="2.0.5dev2">0</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="allow_user_registration" phrase_var_name="setting_allow_user_registration" ordering="0" version_id="2.0.7">1</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="enable_user_tooltip" phrase_var_name="setting_enable_user_tooltip" ordering="1" version_id="2.1.0Beta1">1</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="brute_force_attempts_count" phrase_var_name="setting_brute_force_attempts_count" ordering="1" version_id="2.0.8">5</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="brute_force_time_check" phrase_var_name="setting_brute_force_time_check" ordering="1" version_id="2.0.8">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="brute_force_cool_down" phrase_var_name="setting_brute_force_cool_down" ordering="1" version_id="2.0.8">15</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="force_user_to_upload_on_sign_up" phrase_var_name="setting_force_user_to_upload_on_sign_up" ordering="15" version_id="2.1.0rc1">0</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="invite_only_community" phrase_var_name="setting_invite_only_community" ordering="17" version_id="3.0.0beta1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="enable_relationship_status" phrase_var_name="setting_enable_relationship_status" ordering="1" version_id="3.0.0beta4">1</setting>
		<setting group="" module_id="user" is_hidden="0" type="string" var_name="user_dob_month_day_year" phrase_var_name="setting_user_dob_month_day_year" ordering="1" version_id="3.0.0">F j, Y</setting>
		<setting group="" module_id="user" is_hidden="0" type="string" var_name="user_dob_month_day" phrase_var_name="setting_user_dob_month_day" ordering="2" version_id="3.0.0">F j</setting>
		<setting group="" module_id="user" is_hidden="0" type="drop" var_name="default_privacy_brithdate" phrase_var_name="setting_default_privacy_brithdate" ordering="1" version_id="3.1.0beta1"><![CDATA[a:2:{s:7:"default";s:13:"full_birthday";s:6:"values";a:4:{i:0;s:13:"full_birthday";i:1;s:9:"month_day";i:2;s:8:"show_age";i:3;s:4:"hide";}}]]></setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="no_show_activity_points" phrase_var_name="setting_no_show_activity_points" ordering="1" version_id="3.1.0beta1">1</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="shorter_password_reset_routine" phrase_var_name="setting_shorter_password_reset_routine" ordering="1" version_id="3.1.0rc1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="maximum_length_for_full_name" phrase_var_name="setting_maximum_length_for_full_name" ordering="1" version_id="3.3.0beta1">25</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="split_full_name" phrase_var_name="setting_split_full_name" ordering="1" version_id="3.4.0beta1">0</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="reenter_email_on_signup" phrase_var_name="setting_reenter_email_on_signup" ordering="19" version_id="3.4.0beta1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="string" var_name="points_conversion_rate" phrase_var_name="setting_points_conversion_rate" ordering="1" version_id="3.4.0beta1" />
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="can_purchase_with_points" phrase_var_name="setting_can_purchase_with_points" ordering="1" version_id="3.4.0beta1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="can_purchase_activity_points" phrase_var_name="setting_can_purchase_activity_points" ordering="1" version_id="3.4.0beta1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="prevent_profile_photo_cache" phrase_var_name="setting_prevent_profile_photo_cache" ordering="1" version_id="3.4.0beta2">0</setting>
		<setting group="registration" module_id="user" is_hidden="0" type="boolean" var_name="require_all_spam_questions_on_signup" phrase_var_name="setting_require_all_spam_questions_on_signup" ordering="20" version_id="3.5.0beta1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="cache_featured_users" phrase_var_name="setting_cache_featured_users" ordering="1" version_id="3.6.0rc1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="cache_user_inner_joins" phrase_var_name="setting_cache_user_inner_joins" ordering="2" version_id="3.6.0rc1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="integer" var_name="cache_recent_logged_in" phrase_var_name="setting_cache_recent_logged_in" ordering="3" version_id="3.6.0rc1">0</setting>
		<setting group="" module_id="user" is_hidden="0" type="boolean" var_name="disable_store_last_user" phrase_var_name="setting_disable_store_last_user" ordering="4" version_id="3.6.0rc1">0</setting>
		<setting group="registration" module_id="user" is_hidden="1" type="array" var_name="usernames_to_suggest" phrase_var_name="setting_usernames_to_suggest" ordering="6" version_id="2.0.0beta3"><![CDATA[s:34:"array('user', 'member', 'friend');";]]></setting>
		<setting group="registration" module_id="user" is_hidden="1" type="integer" var_name="how_many_usernames_to_suggest" phrase_var_name="setting_how_many_usernames_to_suggest" ordering="8" version_id="2.0.0beta3">4</setting>
		<setting group="registration" module_id="user" is_hidden="1" type="array" var_name="registration_steps" phrase_var_name="setting_registration_steps" ordering="2" version_id="2.0.0alpha2" />
		<setting group="registration" module_id="user" is_hidden="1" type="boolean" var_name="multi_step_registration_form" phrase_var_name="setting_multi_step_registration_form" ordering="1" version_id="2.0.0alpha2">0</setting>
		<setting group="" module_id="user" is_hidden="1" type="drop" var_name="user_browse_display_results_default" phrase_var_name="setting_user_browse_display_results_default" ordering="1" version_id="2.0.0alpha3"><![CDATA[a:2:{s:7:"default";s:17:"name_photo_detail";s:6:"values";a:2:{i:0;s:17:"name_photo_detail";i:1;s:10:"name_photo";}}]]></setting>
		<setting group="registration" module_id="user" is_hidden="1" type="boolean" var_name="suggest_usernames_on_registration" phrase_var_name="setting_suggest_usernames_on_registration" ordering="7" version_id="2.0.0rc10">0</setting>
		<setting group="registration" module_id="user" is_hidden="1" type="boolean" var_name="hide_main_menu" phrase_var_name="setting_hide_main_menu" ordering="16" version_id="3.0.0beta1">0</setting>
		<setting group="registration" module_id="user" is_hidden="1" type="boolean" var_name="new_user_terms_confirmation" phrase_var_name="setting_new_user_terms_confirmation" ordering="18" version_id="3.0.0beta3">0</setting>
		<setting group="" module_id="user" is_hidden="1" type="drop" var_name="login_module" phrase_var_name="setting_login_module" ordering="0" version_id="2.0.0alpha1"><![CDATA[a:2:{s:7:"default";s:6:"cookie";s:6:"values";a:2:{i:0;s:6:"cookie";i:1;s:7:"session";}}]]></setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="user.browse" module_id="user" component="filter" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="user.browse" module_id="user" component="featured" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="core.index-visitor" module_id="user" component="register" location="3" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title>User SignUp for Guests</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="core.index-visitor" module_id="user" component="featured" location="1" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title>Featured Users for Guests</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_login_ajax_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_group_setting_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_group_setting_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_setting_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_process_validation" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_browse__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_validate__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_group_setting_setting__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_group_setting_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_group_group__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_getuser_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_getuser_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_get_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_get_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_isuser" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_gender" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_getinlinesearch" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_field_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_space___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_space_update" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_space__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_activity_update" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_activity__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_add_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_add_extra" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_add_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_login_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_register" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_setting_process_validation" added="1231934944" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_password__call" added="1231934944" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_setting" added="1231934944" version_id="2.0.0alpha1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_profile_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_setting_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_new_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_filter_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_browse_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_privacy_privacy__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_privacy_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_register__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_group_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_profile_form" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_block_setting_form" added="1240692039" version_id="2.0.0beta1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_group_delete_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_add_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_browse_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_photo_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_signup_error_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_custom_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_block_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth___construct_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth___construct_query" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth___construct_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_block_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_block_block__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_admincp_setting_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_featured_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_password_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_featured__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_featured_feature_start" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_featured_feature_end" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.controller_browse_filter" added="1259160644" version_id="2.0.0rc9" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_browse_genders" added="1259173633" version_id="2.0.0rc9" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_browse_filter" added="1259173633" version_id="2.0.0rc9" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.block_login-block_process__start" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.block_login-block_process__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_login__start" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_login__no_user_name" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_login__password" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_login__cookie_start" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_login__cookie_end" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_login__end" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_logout__start" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_logout__end" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_browse_genders_top_users" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_login_block__start" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_login_block__end" added="1261572640" version_id="2.0.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_add_updatestatus" added="1266260139" version_id="2.0.4" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_setting_process_check" added="1266260139" version_id="2.0.4" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.controller_login_login_failed" added="1266260139" version_id="2.0.4" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_logout-mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_pending_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_verify_process_verify_pass" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_promotion_process__call" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_promotion_promotion__call" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_login_skip_email_verification" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_auth_handlestatus" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_ajax_updatestatus" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_ajax_getregistrationstep_pass" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_promotion_clean" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_verify_process_redirection" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_promotion_add_clean" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_promotion_index_clean" added="1276177474" version_id="2.0.5" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_add_check_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_update_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_update_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_update_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_updatesimple" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_updateusergroup" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_uploadimage" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_updateadvanced_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_updateadvanced_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_updatepassword" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_banuser" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_password_verifyrequest_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_password_verifyrequest_check_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_password_verifyrequest_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_cancellations_process_cancelaccount_invalid_password" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_callback_getnewsfeedstatus_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_callback_getnewsfeedphoto_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_callback_getnewsfeedjoined_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_getuserfields" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_photo_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_photo_2" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_photo_3" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_index_process" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_2" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_3" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_4" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_5" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_6" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_7" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_8" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_9" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_photo_10" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step2_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step2_2" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step2_3" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step2_4" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step2_5" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step2_6" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step2_7" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step2_8" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step1_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step1_2" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step1_3" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step1_4" added="1286546859" version_id="2.0.7" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_add" added="1288281378" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_add_feed" added="1290072896" version_id="2.0.7" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_getforedit" added="1290072896" version_id="2.0.7" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_admincp_ban_clean" added="1298455495" version_id="2.0.8" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_browse_get__start" added="1298902308" version_id="2.0.8" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_browse_get__cnt" added="1298902308" version_id="2.0.8" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_ajax_addviastatusupdate" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_images_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_login_header_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_register_top_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_tooltip_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_welcome_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_1" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_2" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_3" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_4" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_5" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_6" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_7" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_register_8" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_api__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_password_verifyrequest_2" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_password_verifyrequest_3" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_password_verifyrequest_4" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template.login_header_set_var" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template.login_header_custom" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_default_block_register_step1_5" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_browse_get__start_no_return" added="1320054335" version_id="3.0.0rc1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_tooltip_1" added="1323345487" version_id="3.0.0" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_profile_form_onsubmit" added="1323345487" version_id="3.0.0" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_block_tooltip_1" added="1323345637" version_id="3.0.0" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_block_tooltip_3" added="1323345637" version_id="3.0.0" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_block_tooltip_5" added="1323345637" version_id="3.0.0" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_block_tooltip_2" added="1323345637" version_id="3.0.0" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_browse_filter_process" added="1327938973" version_id="3.0.1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_browse_get__end" added="1327938973" version_id="3.0.1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_setting_settitle" added="1335951260" version_id="3.2.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_add_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="user" hook_type="template" module="user" call_name="user.template_controller_register_pre_captcha" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_process_add_updatestatus_end" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_processpoints_clean" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_purchasepoints_clean" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_completepoints_clean" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_user_getcurrency__1" added="1361532353" version_id="3.5.0" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_profile__1" added="1363075699" version_id="3.5.0" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_profile__2" added="1363075699" version_id="3.5.0" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_profile__3" added="1363075699" version_id="3.5.0" />
		<hook module_id="user" hook_type="controller" module="user" call_name="user.component_controller_browse__1" added="1363075699" version_id="3.5.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_activity_update_1" added="1372931660" version_id="3.6.0" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_browse_get_1" added="1378372973" version_id="3.7.0rc1" />
		<hook module_id="user" hook_type="service" module="user" call_name="user.service_featured_get_1" added="1378374384" version_id="3.7.0rc1" />
		<hook module_id="user" hook_type="component" module="user" call_name="user.component_block_login_header" added="1378803594" version_id="3.7.0rc1" />
	</hooks>
	<components>
		<component module_id="user" component="ajax" m_connection="" module="user" is_controller="0" is_block="0" is_active="1" />
		<component module_id="user" component="login-block" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="login" m_connection="user.login" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="admincp.group.index" m_connection="" module="user" is_controller="0" is_block="0" is_active="1" />
		<component module_id="user" component="admincp.group.add" m_connection="" module="user" is_controller="0" is_block="0" is_active="1" />
		<component module_id="user" component="logout" m_connection="user.logout" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="register" m_connection="user.register" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="admincp.group.setting" m_connection="" module="user" is_controller="0" is_block="0" is_active="1" />
		<component module_id="user" component="login-ajax" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="browse" m_connection="user.browse" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="setting" m_connection="user.setting" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="lost-password" m_connection="user.lost-password" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="photo" m_connection="user.photo" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="password.request" m_connection="user.password.request" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="password.verify" m_connection="user.password.verify" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="status" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="register" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="filter" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="privacy" m_connection="user.privacy" module="user" is_controller="1" is_block="0" is_active="1" />
		<component module_id="user" component="featured" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="register-top" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="cf_about_me" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="cf_who_i_d_like_to_meet" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="cf_interests" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="cf_music" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="cf_movies" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="cf_smoker" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
		<component module_id="user" component="cf_drinker" m_connection="" module="user" is_controller="0" is_block="1" is_active="1" />
	</components>
	<stats>
		<stat module_id="user" phrase_var="user.stat_title_1" stat_link="user.browse" stat_image="user.png" is_active="1"><![CDATA[$this->database()
->select('COUNT(u.user_id)')
->from(Phpfox::getT('user'), 'u')
->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id')
->where('u.status_id = 0 AND u.view_id = 0')
->execute('getSlaveField');]]></stat>
	</stats>
	<custom_field>
		<field group_name="user.custom_group_about_me" field_name="about_me" module_id="user" type_id="user_main" phrase_var_name="user.custom_about_me" type_name="MEDIUMTEXT" var_type="textarea" is_active="1" is_required="0" ordering="1" />
	</custom_field>
	<custom_group>
		<group module_id="user" type_id="user_profile" phrase_var_name="user.custom_group_about_me" is_active="1" ordering="1" />
	</custom_group>
	<phrases>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="log" added="1217034494">Log In</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="module_user" added="1219147645">User</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="username" added="1214844661">User Name</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="add_user_group_setting" added="1214789475">Add User Group Setting</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="setting_successfully_added" added="1214789508">Setting successfully added.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="select_varname" added="1214789526">Select a varname for your user setting.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="add_info_regarding_setting" added="1214789544">Add information regarding the user setting.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="setting_details" added="1214790399">Setting Details</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="product" added="1214790410">Product</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="module" added="1214790423">Module</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="varname" added="1214790434">Varname</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="type" added="1214790445">Type</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="user_group_values" added="1214790456">User Group Values</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="language_package_details" added="1214790470">Language Package Details</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="info" added="1214790493">Info</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="manage_user_settings" added="1214964403">Manage User Settings</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="user_group_updated" added="1214964439">User group updated.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="invalid_user_group" added="1214966740">Invalid user group.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="setting_successfully_updated" added="1214981663">Setting successfully updated.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="manage_user_groups" added="1214986555">Manage User Groups</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="default_user_groups" added="1214986645">Default User Groups</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="title" added="1214986655">Title</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="user" added="1214986664">User</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="actions" added="1214986673">Actions</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="select_action" added="1214986688">Select Action</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="edit" added="1214986699">Edit</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="manage_user_group" added="1214986755">Manage User Group</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="user_group_information" added="1214986781">User Group Information</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="title_for_user_group" added="1214986796">Title for the user group.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="user_group_settings" added="1214986808">User Group Settings</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="user_name" added="1218458106">User Name</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="email" added="1218458120">Email</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="login" added="1218458136">Login ID</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="password" added="1218458188">Password</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="remember" added="1218459828">Remember me</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="login_button" added="1218459855">Login</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="sign" added="1218459940">Sign Up</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="forgot_password" added="1218459951">Forgot Password?</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="site_name_login" added="1218461107">{name} Login</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="sign_for_site_name" added="1218461161"><![CDATA[or <a href="{url}">Sign up for {name}</a>]]></phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="forgot_your_password" added="1218464832">Forgot your password?</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="provide_your_user_name" added="1218464879">Provide your user name.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="provide_your_email" added="1218464891">Provide your email.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="provide_your_user_name_email" added="1218464903">Provide your user name or email.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="provide_your_password" added="1218464912">Provide your password.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="login_title" added="1218464970">Login</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="invalid_user_name" added="1218465012">Invalid User Name.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="invalid_email" added="1218465021">Invalid Email.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="invalid_login_id" added="1218465032">Invalid Login ID.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="invalid_password" added="1218465047">Invalid Password.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="you_need_logged_that" added="1218724550">You need to be logged in to do that.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="sign_and_start_using_site" added="1219836880">Sign Up and Start Using {site}</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="menu_browse" added="1231832504">Members</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="menu_settings" added="1231837038">Account</phrase>
		<phrase module_id="user" version_id="2.0.0alpha1" var_name="user_setting_can_add_user_group_setting" added="1214790898">Can add/edit settings for user groups?

Note: Enable this feature only if creating a plug-in or modifying the package.</phrase>
		<phrase module_id="user" version_id="2.0.0alpha2" var_name="user_setting_can_control_profile_privacy" added="1237552899">Can control privacy settings on their own profile?</phrase>
		<phrase module_id="user" version_id="2.0.0alpha2" var_name="user_setting_can_control_notification_privacy" added="1237552966">Can control notification privacy settings?</phrase>
		<phrase module_id="user" version_id="2.0.0alpha2" var_name="user_setting_can_override_user_privacy" added="1237553281">Can override a users privacy setting?</phrase>
		<phrase module_id="user" version_id="2.0.0alpha2" var_name="setting_multi_step_registration_form" added="1237571029"><![CDATA[<title>Multi-step Registration Form</title><info>Enabling this option will turn the registration process into multiple steps and using as few fields as we can on the first step to entice users to register.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0alpha2" var_name="user_setting_require_profile_image" added="1237573969">Users are required to upload a profile image?</phrase>
		<phrase module_id="user" version_id="2.0.0alpha2" var_name="setting_registration_steps" added="1237574533"><![CDATA[<title>Registration Steps</title><info>With this option you can add extra steps to the registration process.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0alpha3" var_name="menu_edit_profile" added="1238410664">Edit Profile</phrase>
		<phrase module_id="user" version_id="2.0.0alpha3" var_name="custom_group_about_me" added="1238671524">About Me</phrase>
		<phrase module_id="user" version_id="2.0.0alpha3" var_name="custom_about_me" added="1238671545">About Me</phrase>
		<phrase module_id="user" version_id="2.0.0beta3" var_name="setting_usernames_to_suggest" added="1244550909"><![CDATA[<title>Usernames to suggest</title><info>When users fail the username verification at signup several usernames will be suggested. 
The values here are the first part of those suggestions, (the second part is a random number).

Possible outcomes:
user234
member181
friend921</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta3" var_name="setting_how_many_usernames_to_suggest" added="1244551391"><![CDATA[<title>How many usernames to suggest</title><info>When users verify their username at signup they are presented with a list of valid usernames they can choose from, how many usernames to show in that list?</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0alpha3" var_name="setting_user_browse_display_results_default" added="1239092643"><![CDATA[<title>Browsing Users Display Results</title><info>Select <b>name_photo</b> if you would like to by default display the users name and photo only within the browse section. Select <b>name_photo_detail</b> if you would like to display the users name, photo and general details about the person within the browse section.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta2" var_name="user_setting_can_edit_gender_setting" added="1242643138">Can edit their gender?</phrase>
		<phrase module_id="user" version_id="2.0.0beta2" var_name="user_setting_custom_name_field" added="1242643942">Custom full name field</phrase>
		<phrase module_id="user" version_id="2.0.0beta2" var_name="user_setting_can_edit_dob" added="1242644281">Can edit date of birth?</phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="user_setting_can_edit_users" added="1244545054"><![CDATA[Can edit a users account?

<b>Notice:</b> Requires the ability to log into the AdminCP.]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="user_setting_can_stay_logged_in" added="1244557119">Can stay logged into the site?</phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="user_setting_can_change_other_user_picture" added="1244565702">Can change profile photos added by other users?</phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="user_setting_can_edit_other_user_privacy" added="1244566805">Can edit privacy settings for other users?</phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="user_setting_can_change_own_user_name" added="1244571194">Can change own user name?</phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="user_setting_total_times_can_change_user_name" added="1244571909">How many times can this user group edit their user name?</phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="setting_user_profile_private_age" added="1244573463"><![CDATA[<title>Force Profile Privacy</title><info>Define what age should a users profile be forced to be private regardless of their profile privacy setting. 

If the user's age is the the same or lower than the setting, only their friends will be able to see their profile and interact with them.

<b>Notice:</b> Set to "0" (without quotes) for no limit.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="user_setting_can_block_other_members" added="1244626170">Can block members?</phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="user_setting_can_be_blocked_by_others" added="1244626313">Can this user group be blocked by other users?</phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="setting_validate_full_name" added="1244645932"><![CDATA[<title>Validate Full/Display Name</title><info>Set to <b>True</b> if you would like to validate a users full name.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta4" var_name="stat_title_1" added="1245140437">Members</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="user_setting_can_feature" added="1246003244">Can members of this user group feature and unfeature members?</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="setting_randomize_featured_members" added="1246007440"><![CDATA[<title>Random featured members</title><info>Should featured members randomly show up?</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="setting_how_many_featured_members" added="1246007756"><![CDATA[<title>How Many Featured Members To Show</title><info>This setting tells how many featured members will be shown at one time.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="setting_verify_email_at_signup" added="1246354785"><![CDATA[<title>Verify Email At Signup</title><info>When a guest signs up, should they verify their email address?

If enabled an email will be sent with a special link to verify that is their address.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="setting_verify_email_timeout" added="1246355083"><![CDATA[<title>Verify Email Timeout</title><info>This setting tells how much time (in minutes) new members have in order to verify their email address.

Make sure your email server is well configured as this setting relies on the user being able to click the link sent when they signed up.

If your site allows changing email address and you require the new one to be verified as well this setting also applies in this case.

Set it to 0 to disable the timeout.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="user_setting_can_change_email" added="1246368069">Should members of this user group be allowed to change their email address?</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="setting_logout_after_change_email_if_verify" added="1246370838"><![CDATA[<title>Logout After Changing Email</title><info>If users must verify their email address, when they change their email address should they be logged out so they need to verify right away?

If you set this to no they will be able to use the site until they sign out, after that they will need to verify their email address.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="user_setting_can_verify_others_emails" added="1246447720"><![CDATA[Allow members of this user group to verify other's email address from the AdminCP -> Users -> Browse Users ?]]></phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="user_cancellation_6" added="1246619355">reason 3</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="user_cancellation_7" added="1246619366">reason 4</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="user_setting_can_delete_own_account" added="1246874203">Can members of this user group delete their own account?</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="user_setting_can_change_own_full_name" added="1247145812">Can members of this user group change their full name?</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="user_setting_total_times_can_change_own_full_name" added="1247145932">How many times can members of this user group change their full name?

Leave to 0 for unlimited</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="menu_account_settings" added="1247223348">Account Settings</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="menu_privacy_settings" added="1247223384">Privacy Settings</phrase>
		<phrase module_id="user" version_id="2.0.0beta5" var_name="menu_edit_profile_picture" added="1247226022">Edit Profile Picture</phrase>
		<phrase module_id="user" version_id="30" var_name="user_setting_can_delete_others_account" added="1247641642"><![CDATA[Can members of this user group delete other people's account?]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc1" var_name="user_setting_can_be_invisible" added="1248682127">Can select to be invisible?</phrase>
		<phrase module_id="user" version_id="2.0.0rc1" var_name="setting_display_user_online_status" added="1248697618"><![CDATA[<title>Display User Online Status</title><info>This produces an "is Online" message when the avatar is hovered over.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc1" var_name="user_setting_total_upload_space" added="1248951473"><![CDATA[The total amount of space a user can use when uploading to the server (eg. photos, videos, songs etc...) in megabytes (mb). Set to "0" for unlimited space.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc1" var_name="user_setting_force_cropping_tool_for_photos" added="1250774093"><![CDATA[Force users to use the cropping tool before completing the profile photo upload routine.

<b>Note:</b> This is used to make sure all photos on the site are correctly cropped.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc1" var_name="user_setting_max_upload_size_profile_photo" added="1250849063"><![CDATA[Max file size for profile photos uploaded in kilobits (kb).
(1000 kb = 1 mb)
For an unlimited size limit add "0" without quotes.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc2" var_name="setting_min_length_for_username" added="1253525527"><![CDATA[<title>Minimum Length for Username</title><info>Minimum Length for Username</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc2" var_name="setting_max_length_for_username" added="1253525598"><![CDATA[<title>Maximum Length for Username</title><info>Maximum Length for Username</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="your_password_has_been_sent_to_your_email" added="1255346076">Your password has been sent to your email.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="we_found_a_problem_with_your_request_please_try_again" added="1255346107">We found a problem with your request, please try again.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_cannot_rate_your_own_profile" added="1255346129">You cannot rate your own profile.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="this_username_is_available" added="1255346146">This username is available.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_successfully_blocked" added="1255346166">User successfully blocked.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_successfully_unblocked" added="1255346175">User successfully unblocked.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unfeature_user" added="1255346187">Unfeature User</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="feature_user" added="1255346203">Feature User</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="an_error_occured_and_this_operation_was_not_completed" added="1255346213">An error occurred and this operation was not completed.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="an_error_occured_and_this_user_could_not_be_verified" added="1255346223">An error occurred and this user could not be verified.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="an_error_occured_and_the_email_could_not_be_sent" added="1255346241">An error occurred and the email could not be sent.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="profile_photo_successfully_uploaded" added="1255346279">Profile photo successfully uploaded.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="done" added="1255346288">Done!</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="un_ban_user" added="1255346306">Un-Ban User</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="ban_user" added="1255346312">Ban User</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unable_to_find_this_member" added="1255346340">Unable to find this member.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unable_to_block_this_user" added="1255346349">Unable to block this user.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="view_all" added="1255346369">View All</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="featured_members" added="1255346377">Featured Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="set_browse_criteria" added="1255346405">Set Browse Criteria</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="basic" added="1255346411">Basic</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="advanced" added="1255346417">Advanced</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="option_updated_successfully" added="1255346509">Option updated successfully.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="option_added_successfully" added="1255346516">Option added successfully.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="item_not_found" added="1255346524">Item not found.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="add_cancellation_options" added="1255346532">Add Cancellation Options</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="view_feedback_on_cancellations" added="1255346545">View Feedback On Cancellations</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="option_deleted_successfully" added="1255346558">Option deleted successfully.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="manage_cancellation_options" added="1255346573">Manage Cancellation Options</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_groups" added="1255346596">User Groups</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="manage_settings" added="1255346613">Manage Settings</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_group_successfully_added" added="1255346624">User group successfully added.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="create_new_user_group" added="1255346647">Create New User Group</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="successfully_deleted_user_group" added="1255346670">Successfully deleted user group.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unable_to_find_the_user_group_you_want_to_delete" added="1255346678">Unable to find the user group you want to delete.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="not_allowed_to_delete_this_user_group" added="1255346686">Not allowed to delete this user group.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="delete_user_group" added="1255346693">Delete User Group</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_successfully_updated" added="1255346774">User successfully updated.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="basic_information" added="1255346782">Basic Information</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="display_name" added="1255346790">Display Name</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_group" added="1255346823">User Group</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="location" added="1255346829">Location</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="city" added="1255346835">City</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="zip_postal_code" added="1255346841">ZIP/Postal Code</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="gender" added="1255346847">Gender</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="date_of_birth" added="1255346856">Date of Birth</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="time_zone" added="1255346863">Time Zone</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="status" added="1255346869">Status</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="spam_count" added="1255346876">SPAM Count</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="editing_member" added="1255346886">Editing Member</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="browse_members" added="1255346893">Browse Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="add_new_member" added="1255346903">Add New Member</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="password_request_successfully_sent_check_your_email_to_verify_your_request" added="1255346930">Password request successfully sent. Check your email to verify your request.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="password_request" added="1255346939">Password Request</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="new_password_successfully_sent_check_your_email_to_use_your_new_password" added="1255346980">New password successfully sent. Check your email to use your new password.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="password_request_verification" added="1255346988">Password Request Verification</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="members_section_is_closed" added="1255347016">Members section is closed.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="joined" added="1255347023">Joined</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="last_login" added="1255347030">Last Login</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="email_name" added="1255347041"><![CDATA[Email & Name]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="name" added="1255347054">Name</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="men" added="1255347063">Men</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="women" added="1255347069">Women</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="both" added="1255347076">Both</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="all_members" added="1255347085">All Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="online" added="1255347097">Online</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="pending_verification_members" added="1255347106">Pending Verification Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="name_and_photo_only" added="1255347114">Name and Photo Only</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="name_photo_and_users_details" added="1255347122">Name, Photo and Users Details</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_still_need_to_verify_your_email_address" added="1255347174">You still need to verify your email address.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="logout" added="1255347189">Logout</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="lost_password" added="1255347198">Lost Password</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="upload_profile_picture" added="1255347236">Upload Profile Picture</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="edit_profile_picture" added="1255347246">Edit Profile Picture</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="privacy_settings_have_been_disabled_for_your_user_group" added="1255347263">Privacy settings have been disabled for your user group.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="privacy_settings_successfully_updated" added="1255347271">Privacy settings successfully updated.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="privacy_settings" added="1255347278">Privacy Settings</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="successfully_updated_full_name_profile" added="1255347302">Successfully updated {full_name} profile.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="edit_profile" added="1255347324">Edit Profile</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="cancel_account" added="1255347356">Cancel Account</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unable_to_edit_this_account" added="1255347370">Unable to edit this account.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_current_location" added="1255347378">Select current location.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_your_gender" added="1255347385">Select your gender.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_month_of_birth" added="1255347392">Select month of birth.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_day_of_birth" added="1255347399">Select day of birth.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_year_of_birth" added="1255347406">Select year of birth.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="zip_postal_code_is_invalid" added="1255347414">ZIP/Postal code is invalid.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="provide_your_full_name" added="1255347423">Provide your full name.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="provide_a_user_name" added="1255347430">Provide a user name.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="account_settings_updated" added="1255347439">Account settings updated.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="account_settings_updated_your_new_mail_address_requires_verification_and_an_email_has_been_sent_until_then_your_email_remains_the_same" added="1255347448">Account settings updated. Your new mail address requires verification and an email has been sent. Until then your email remains the same.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="email_updated_you_need_to_verify_your_new_email_address_before_logging_in" added="1255347456">Email updated. You need to verify your new email address before logging in.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="account_settings" added="1255347468">Account Settings</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="full_name" added="1255347477">Full Name</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="your_email_has_been_verified_please_log_in_with_the_information_you_provided_during_sign_up" added="1255347489">Your email has been verified, please log in with the information you provided during sign up.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="invalid_verification_link" added="1255347519">Invalid verification link.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="not_able_to_block_yourself" added="1255347588">Not able to block yourself.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_have_already_blocked_this_user" added="1255347597">You have already blocked this user.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_a_product" added="1255347628">Select a product.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_a_module" added="1255347636">Select a module.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_need_to_add_a_message_to_show" added="1255347643">You need to add a message to show.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_if_the_cancellation_option_is_active_or_not" added="1255347651">Select if the cancellation option is active or not.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="please_enter_your_password" added="1255347663">Please enter your password.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_are_not_allowed_to_delete_your_own_account" added="1255347672">You are not allowed to delete your own account.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="your_account_has_been_deleted" added="1255347685">Your account has been deleted.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="not_a_valid_request" added="1255347704">Not a valid request.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="provide_a_name_for_the_user_group" added="1255347780">Provide a name for the user group.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_an_inherit_user_group" added="1255347788">Select an inherit user group.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="email_verification_on_site_title" added="1255347882">Email Verification On {site_title}</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_registered_an_account_on_site_title_before" added="1255347957"><![CDATA[You registered an account on {site_title}, before being able to use your account you need to verify that this is your email address by clicking here:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="email_does_not_match_the_one_that_is_currently_in_use" added="1255348015">Email does not match the one that is currently in use.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_need_to_verify_your_email_address_before_logging_in" added="1255348029"><![CDATA[You need to verify your email address before logging in.

We sent a verification code to: <b>{email}</b>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_do_not_have_permission_to_modify_this_item" added="1255348044">You do not have permission to modify this item.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="members" added="1255348095">Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="view_more_members" added="1255348104">View More Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="a_href_link_member_a_joined_joined" added="1255348147"><![CDATA[<a href="{link}">Member</a> joined {joined}.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="a_href_link_full_name_a_updated_their_profile_picture" added="1255348200"><![CDATA[<a href="{link}">{full_name}</a> updated their profile picture.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="a_href_link_full_name_a_joined_the_community" added="1255348257"><![CDATA[<a href="{link}">{full_name}</a> joined the community.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="users_profile_main_section" added="1255348288">Users Profile - Main Section</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="users_profile_basic_information" added="1255348295">Users Profile - Basic Information</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="users_profile_side_panel" added="1255348303">Users Profile - Side Panel</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="users_profile" added="1255348313">Users Profile</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="account_info" added="1255348327">Account Info</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="activity" added="1255348333">Activity</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="users" added="1255348364">Users</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_activity" added="1255348378">User Activity</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="time_stamp" added="1255348396">Time Stamp</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="not_a_valid_email" added="1255348410">Not a valid email.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="password_request_for_site_title" added="1255348422">Password request for {site_title}</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_have_requested_for_us_to_send_you_a_new_password_for_site_title" added="1255348468"><![CDATA[You have requested for us to send you a new password for {site_title}.

To confirm this request, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="not_a_valid_password_request" added="1255348509">Not a valid password request.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="password_request_id_does_not_match" added="1255348517">Password request ID does not match.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="new_password_for_site_title" added="1255348541">New password for {site_title}</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_have_requested_for_us_to_send_you_a_new_password_for_site_title_with_password" added="1255348604"><![CDATA[You have requested for us to send you a new password for {site_title}.

Your new password is: {password}

To login, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="the_field_field_is_required" added="1255348655">The field `{field}` is required.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="not_a_valid_name" added="1255348671">Not a valid name.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_a_membership_package" added="1255348680">Select a membership package.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="please_verify_your_email_for_site_title" added="1255348711">Please verify your email for: {site_title}</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_registered_an_account_on_site_title_before_being_able_to_use_your_account_you_need_to_verify_that_this_is_your_email_address_by_clicking_here_a_href_link_link_a" added="1255348750"><![CDATA[You registered an account on {site_title}, before being able to use your account you need to verify that this is your email address by clicking here:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="not_a_valid_city" added="1255348792">Not a valid city.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="this_display_name_is_not_allowed_to_be_used" added="1255348815">This display name is not allowed to be used.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="add_some_text_to_share" added="1255348834">Add some text to share.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="fill_in_a_display_name" added="1255348849">Fill in a display name.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_a_user_group_for_this_user" added="1255348857">Select a user group for this user.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_a_location" added="1255348865">Select a location.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_a_gender" added="1255348872">Select a gender.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_a_date_of_birth" added="1255348880">Select a date of birth.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="username_is_required_and_can_only_contain_alphanumeric_characters_and_or_and_must_be_between_5_and_25_characters_long" added="1255348890">Username is required and can only contain alphanumeric characters and _ or - and must be between 5 and 25 characters long.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="provide_a_valid_email" added="1255348903">Provide a valid email.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="missing_old_password" added="1255348917">Missing old password.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="missing_new_password" added="1255348924">Missing new password.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="your_current_password_does_not_match_your_old_password" added="1255348932">Your current password does not match your old password.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_should_not_ban_yourself" added="1255348944">You should not ban yourself.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="provide_a_valid_password" added="1255348967">Provide a valid password.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="check_our_agreement_in_order_to_join_our_site" added="1255348975">Check our agreement in order to join our site.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="provide_a_valid_user_name" added="1255348982">Not a valid user name. User name can only contain alphanumeric characters and _ or - and must be between {min} and {max} characters long.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unable_to_upload_you_have_reached_your_limit_of_current_you_are_currently_using_total" added="1255349057">Unable to upload. You have reached your limit of {current}. You are currently using {total}.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unable_to_upload_you_have_reached_your_limit_of_limit_with_this_upload_you_will_be_using_total" added="1255349126">Unable to upload. You have reached your limit of {limit}. With this upload you will be using {total}.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unable_to_find_the_user_you_plan_to_edit" added="1255349166">Unable to find the user you plan to edit.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_name_is_already_in_use" added="1255349204">User name is already in use.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="this_username_is_not_allowed_to_be_used" added="1255349213">This username is not allowed to be used.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="email_is_invalid_and_cannot_be_used" added="1255349222">Email is invalid and cannot be used.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="this_email_is_not_allowed_to_be_used" added="1255349229">This email is not allowed to be used.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="loading_custom_fields" added="1255349270">Loading custom fields</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="continue" added="1255349314">Continue</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_are_about_to_delete" added="1255349645">You are about to delete...</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="total_activity" added="1255349689">Total Activity</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="are_you_completely_sure_you_want_to_delete_this_user" added="1255349704">Are you completely sure you want to delete this user?</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="no_cancel" added="1255349713">No, Cancel</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="yes_delete" added="1255349719">Yes, Delete</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="html_prefix" added="1255349733">HTML Prefix</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="html_suffix" added="1255349741">HTML Suffix</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="cancel" added="1255349841">cancel</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1255349851">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="the_advised_width_height_is_20_pixels" added="1255349861">The advised width/height is 20 pixels.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="yes" added="1255349896">Yes</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="no" added="1255349905">No</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="choose_a_username" added="1255349927">Choose a Username</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="your_username_is_used_to_easily_connect_to_your_profile" added="1255349938">Your username is used to easily connect to your profile.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="check_availability" added="1255349950">Check Availability</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="email_address" added="1255349958">Email Address</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="membership" added="1255350061">Membership</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select" added="1255350068">Select</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="free_normal" added="1255350074">(Free) Normal</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="membership_upgrades" added="1255350091">Membership Upgrades</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="click_here_to_learn_more_about_our_membership_upgrades" added="1255350114">Click here to learn more about our memberships.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="would_you_like_to_unblock_user_info" added="1255350478">Would you like to unblock {user_info}?</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="yes_unblock_this_user" added="1255350492">Yes, unblock this user.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="no_do_not_unblock_this_user" added="1255350499">No, do not unblock this user.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="are_you_sure_you_want_to_block_user_info" added="1255350513">Are you sure you want to block {user_info}?</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="yes_block_this_user" added="1255350542">Yes, block this user.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="no_do_not_block_this_user" added="1255350550">No, do not block this user.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="search_by_email_full_name_or_user_name" added="1255350564">Search by email, full name or user name.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="loading" added="1255350587">Loading</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="sorry_no_users_were_found" added="1255350630">Sorry, no users were found.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="use_selected" added="1255350638">Use Selected</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="cancel_uppercase" added="1255350654">Cancel</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="browse_for" added="1255350679">Browse For</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="between_ages" added="1255350686">Between Ages</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="located_within" added="1255350702">Located Within</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="keywords" added="1255350723">Keywords</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="within" added="1255350730">within</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="any" added="1255350747">Any</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="display_results_by" added="1255350759">Display Results By</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="sort_results_by" added="1255350765">Sort Results By</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="update" added="1255350772">Update</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="reset" added="1255350778">Reset</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="view_more" added="1255350805">View More</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="old_password" added="1255350815">Old Password</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="new_password" added="1255350820">New Password</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="select_an_image" added="1255350839">Select an Image</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="file" added="1255350845">File</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="upload_picture" added="1255350860">Upload Picture</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="anyone" added="1255350875">Anyone</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="network" added="1255350881">Network</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="friends_only" added="1255350888">Friends Only</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="no_one" added="1255350894">No One</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="go_advanced" added="1255350950">go advanced</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="username_is_not_available_here_are_other_suggestions_you_may_like" added="1255350959">Username is not available, here are other suggestions you may like.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="click_to_change_your_status" added="1255350982">Click to change your status.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="none" added="1255351003">(none)</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="a_href_onclick_js_user_status_form_ajaxcall_user_updatestatus_return_false_save_a_or_a_href_class_js_update_status_cancel_a" added="1255351064"><![CDATA[<a href="#" onclick="$('#js_user_status_form').ajaxCall('user.updateStatus'); return false;">save</a> or <a href="#" class="js_update_status">cancel</a>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="add_new_option" added="1255351089">Add New Option</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="cancellation_reason" added="1255351098">Cancellation Reason</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="is_active" added="1255351109">Is Active</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="submit" added="1255351131">Submit</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="e_mail" added="1255351154">E-Mail</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="reasons_given" added="1255351167">Reasons Given</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="feedback_text" added="1255351173">Feedback Text</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="deleted_on" added="1255351179">Deleted On</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="delete_feedback" added="1255351194">Delete Feedback</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="no_feedback_to_review" added="1255351204">No feedback to review</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="active" added="1255351222">Active</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="manage" added="1255351229">Manage</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="edit_reason" added="1255351236">Edit Reason</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="delete_reason" added="1255351242">Delete Reason</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="deactivate" added="1255351250">Deactivate</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="activate" added="1255351255">Activate</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="there_are_no_options_available" added="1255351286">There are no options available.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="click_here_to_add" added="1255351293">Click here to add.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_group_details" added="1255351302">User Group Details</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="inherit" added="1255351307">Inherit</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="add_user_group" added="1255351316">Add User Group</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="saving" added="1255351336">Saving</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="module_settings" added="1255351345">Module Settings</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="save" added="1255351360">Save</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="are_you_sure_you_want_to_delete_the_user_group_title" added="1255351390"><![CDATA[Are you sure you want to delete the user group "{title}"?]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="b_notice_b_this_cannot_be_undone" added="1255351405"><![CDATA[<b>Notice:</b> This cannot be undone.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="b_yes_b_i_am_sure_move_any_members_that_belong_to_the_user_group_title_to" added="1255351482"><![CDATA[<b>Yes</b>, I am sure. Move any members that belong to the user group "{title}" to]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="delete_this_user_group" added="1255351495">Delete this User Group</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="no_thanks_get_me_out_of_here" added="1255351502">No thanks, get me out of here.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="edit_user_group" added="1255351676">Edit User Group</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="custom_user_groups" added="1255351684">Custom User Groups</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="are_you_sure" added="1255351719">Are you sure?</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="delete" added="1255351726">Delete</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="n_a" added="1255351737">N/A</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="php" added="1255351754">PHP</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="check_the_box_to_confirm_that_you_want_to_edit_this_field" added="1255351792">Check the box to confirm that you want to edit this field.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="profile_picture" added="1255351809">Profile Picture</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="photo" added="1255351814">Photo</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="change_this_photo" added="1255351877">Change This Photo</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="profile_privacy" added="1255351942">Profile Privacy</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="notification" added="1255351949">Notification</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="custom_fields" added="1255351955">Custom Fields</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="request_new_password" added="1255351990">Request New Password</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="member_search" added="1255352000">Member Search</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="search" added="1255352006">Search</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="age_group" added="1255352048">Age Group</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="show_members" added="1255352055">Show Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="group" added="1255352125">Group</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="last_activity" added="1255352137">Last Activity</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="resend_verification_mail" added="1255352186">Resend Verification Mail</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="verify_this_user" added="1255352197">Verify this user</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="delete_user" added="1255352225">Delete User</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="verify" added="1255352242">(Verify)</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="view_all_the_activity_from_this_ip" added="1255352316">View all the activity from this IP.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="birthday" added="1255352341">Birthday</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="age" added="1255352346">Age</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="view_profile" added="1255352373">View Profile</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="send_message" added="1255352380">Send Message</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="add_full_name_as_your_friend" added="1255352392">Add {full_name} as your Friend.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="add_to_friends" added="1255352416">Add to Friends</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="un_feature_this_member" added="1255352431">Un-Feature this member.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unfeature" added="1255352438">Unfeature</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="feature_this_member" added="1255352446">Feature this member.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="feature" added="1255352454">Feature</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="unable_to_find_any_members_with_the_current_browse_criteria" added="1255352506">Unable to find any members with the current browse criteria.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="reset_browse_criteria" added="1255352511">Reset Browse Criteria</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_have_logged_out" added="1255352791">You have logged out.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="skip_this_step" added="1255352808">Skip This Step</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="thumbnail" added="1255352821">Thumbnail</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="profile_picture_cropping_tool" added="1255352829">Profile Picture Cropping Tool</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="avatar" added="1255352835">Avatar</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="the_image_you_uploaded_is_rather_small_so_we_are_unable_to_crop_it_however_you_can_still_save_this_image_if_you_want_to_use_it" added="1255352849">The image you uploaded is rather small so we are unable to crop it, however you can still save this image if you want to use it.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="save_avatar" added="1255352862">Save Avatar</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="click_and_drag_a_box_on_the_original_image_to_create_your_cropped_image" added="1255352881"><![CDATA[Click and drag a box on the "Original" image to create your cropped image, which can be seen under "Preview". Once you are ready click "Save Avatar" to create your cropped avatar. Avatars are used throughout the site.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="original" added="1255352892">Original</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="preview" added="1255352898">Preview</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="upload_a_new_profile_picture" added="1255353021">Upload a New Profile Picture</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="the_file_size_limit_is_file_size_if_your_upload_does_not_work_try_uploading_a_smaller_picture" added="1255353065">The file size limit is {file_size}. If your upload does not work, try uploading a smaller picture.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="invisible_mode" added="1255353140">Invisible Mode</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="invisible_mode_allows_you_to_browse_the_site_without_appearing_on_any_online_lists" added="1255353150"><![CDATA[Invisible mode allows you to browse the site without appearing on any "Online" lists.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="enable_invisible_mode" added="1255353157">Enable Invisible Mode</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="save_changes" added="1255353176">Save Changes</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="profile" added="1255353183">Profile</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="display_age_and_date_of_birth" added="1255353205">Display age and date of birth.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="display_age_and_day_month_of_birth" added="1255353212">Display age and day/month of birth.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="display_only_my_age" added="1255353221">Display only my age.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="display_only_day_month_of_birth" added="1255353228">Display only day/month of birth.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="hide_my_age_and_date_of_birth" added="1255353239">Hide my age and date of birth.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="notifications" added="1255353258">Notifications</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="blocked_users" added="1255353273">Blocked Users</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="check_the_boxes_to_unblock_users" added="1255353279">Check the boxes to unblock users.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="you_have_not_blocked_any_users" added="1255353290">You have not blocked any users.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="view_your_updated_profile" added="1255353335">View your updated profile.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="updating_profile" added="1255353348">Updating profile</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="no_custom_fields_have_been_added" added="1255353363">No custom fields have been added.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="add_a_new_custom_field" added="1255353370">Add a New Custom Field</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="i_have_read_and_agree_to_the_a_href_id_js_terms_of_use_terms_of_use_a_and_a_href_id_js_privacy_policy_privacy_policy_a" added="1255353746"><![CDATA[I have read and agree to the <a href="#" id="js_terms_of_use">Terms of Use</a> and <a href="#" id="js_privacy_policy">Privacy Policy</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="sign_up" added="1255353757">Sign Up</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="terms_of_use" added="1255353807">Terms of Use</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="privacy_policy" added="1255353814">Privacy Policy</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="are_you_sure_you_want_to_delete_your_account" added="1255353879">Are you sure you want to delete your account?</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="user_info_will_miss_you" added="1255353902">{user_info} will miss you.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="why_are_you_deleting_your_account" added="1255353918">Why are you deleting your account?</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="please_tell_us_why" added="1255353928">Please tell us why</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="enter_your_password" added="1255353935">Enter your password</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="are_you_absolutely_sure_this_operation_cannot_be_undone" added="1255353943">Are you absolutely sure? This operation cannot be undone.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="delete_my_account" added="1255353954">Delete My Account</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="total_user_change_out_of_total_user_name_changes" added="1255354010">{total_user_change} out of {total} user name changes.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="changing_your_email_address_requires_you_to_verify_your_new_email" added="1255354040">Changing your email address requires you to verify your new email.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="change_password" added="1255354053">Change Password</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="enable_dst_daylight_savings_time_detection" added="1255354117">Enable DST (Daylight Savings Time) detection.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="cancel_your_account" added="1255354151">Cancel your account</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="the_link_that_brought_you_here_is_not_valid_it_may_already_have_expired" added="1255354177"><![CDATA[<p>
		The link that brought you here is not valid, it may already have expired. Email verify links expire {time} after being sent.
	</p>
	<p> A new verification link has been sent to your email address, please verify your address on time </p>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="this_site_is_very_concerned_about_security" added="1255354208"><![CDATA[<p>This site is very concerned about security and therefore it requires you to verify your email address.</p>
		<p> An email has been sent to you, it contains a special link which verifies you and allows you to log in
			freely. This verification is required only once for this email address.</p>
		<p> Please check your email and verify your email address now. </p>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="primary_language" added="1255508010">Primary Language</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="edit_user" added="1255767831">Edit User</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="setting_on_signup_new_friend" added="1256302937"><![CDATA[<title>On Signup New Friend</title><info>If you select a user from the drop down this user will automatically become friends with any new member that registers.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="provide_a_name_that_is_not_representing_an_empty_name" added="1256498562">Provide a name that is not representing an empty name.</phrase>
		<phrase module_id="user" version_id="2.0.0rc4" var_name="email_is_not_valid" added="1256498658">Email is not valid.</phrase>
		<phrase module_id="user" version_id="2.0.0rc5" var_name="you_have_already_added_this_recently_try_adding_something_else" added="1256831625">You have already added this recently. Try adding something else.</phrase>
		<phrase module_id="user" version_id="2.0.0rc5" var_name="setting_check_status_updates" added="1256831739"><![CDATA[<title>Spam Check Status Updates</title><info>Define how many status updates should we check to see if the new status update the user is adding is similar and if one is we will guide them to add another status update.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="rating" added="1257148296">Rating</phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="confirm_password" added="1257149713">Confirm Password</phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="password_successfully_updated" added="1257149818">Password successfully updated.</phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="confirm_your_new_password" added="1257149930">Confirm your new password.</phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="your_confirmed_password_does_not_match_your_new_password" added="1257149968">Your confirmed password does not match your new password.</phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="search_for_members" added="1257171948">Search For Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="icon" added="1257255484">Icon</phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="complete_this_step_to_setup_your_personal_profile" added="1257262042">Complete this step to setup your personal profile.</phrase>
		<phrase module_id="user" version_id="2.0.0rc6" var_name="you_are_required_to_upload_a_profile_image" added="1257262086">You are required to upload a profile image.</phrase>
		<phrase module_id="user" version_id="2.0.0rc7" var_name="joined_time_stamp" added="1257931076">Joined {time_stamp}</phrase>
		<phrase module_id="user" version_id="2.0.0rc8" var_name="user_id" added="1258553081">User ID#</phrase>
		<phrase module_id="user" version_id="2.0.0rc8" var_name="provide_a_valid_email_address" added="1258742333">Provide a valid email address.</phrase>
		<phrase module_id="user" version_id="2.0.0rc8" var_name="new_members" added="1258756750">New Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc8" var_name="new_comments" added="1258756762">New Comments</phrase>
		<phrase module_id="user" version_id="2.0.0rc8" var_name="updating" added="1258899641">Updating</phrase>
		<phrase module_id="user" version_id="2.0.0rc8" var_name="total_full_name_change_out_of_allowed" added="1258984271">{total_full_name_change} out of {allowed}</phrase>
		<phrase module_id="user" version_id="2.0.0rc10" var_name="setting_redirect_after_signup" added="1259688625"><![CDATA[<title>Redirect After SignUp</title><info>Add the full path you want to send users right after they register. If you want to use our default routine just leave this blank.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc10" var_name="setting_suggest_usernames_on_registration" added="1259610406"><![CDATA[<title>Suggest Usernames At Registration</title><info>When enabled the guest will be shown a list of valid usernames if the one they attempted is not available.

This setting enables or disables "Usernames to suggest"</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="enable_dst_daylight_savings_time" added="1259938658">Enable DST (Daylight Savings Time)</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="setting_date_of_birth_start" added="1259943344"><![CDATA[<title>Date of Birth (Start)</title><info>Date of Birth (Start)</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="setting_date_of_birth_end" added="1259943587"><![CDATA[<title>Date of Birth (End)</title><info>Date of Birth (End)</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="your_user_name" added="1259960987">your-user-name</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="forum_signature" added="1260027584">Forum Signature</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="space_total_out_of_unlimited" added="1260197948"><![CDATA[{space_total} out of "unlimited"]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="space_total_out_of_total" added="1260198034">{space_total} out of {total} Mb</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="sorry_no_members_found" added="1260198777">Sorry, no members found.</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="user_setting_can_search_user_gender" added="1260199675">Can search a users gender using the browse filter?</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="user_setting_can_search_user_age" added="1260199727">Can search for users based on their age using the browse filter?</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="register_for_an_account" added="1260232205">Register for An Account</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="user_setting_can_browse_users_in_public" added="1260276391">Can browse users using the public browse section?</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="title_featured_members" added="1260209155">Featured Members</phrase>
		<phrase module_id="user" version_id="2.0.0rc11" var_name="title_who_s_online" added="1260209680"><![CDATA[Who's Online]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_that_they_joined_the_community" added="1260446167"><![CDATA[<a href="{user_link}">{full_name}</a> liked that they joined the community.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_that_a_href_view_user_link_view_full_name_a_a_href_link_joined_a_the_community" added="1260446507"><![CDATA[<a href="{user_link}">{full_name}</a> liked that <a href="{view_user_link}">{view_full_name}</a> joined the community.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_that_you_joined_the_community" added="1260460353"><![CDATA[<a href="{user_link}">{full_name}</a> liked that you joined the community.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_status_a" added="1260475316"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">status</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_a_href_link_status_a" added="1260476016"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">status</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_status_a" added="1260476034"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">status</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_profile_a_href_link_photo_a" added="1260479272"><![CDATA[<a href="{user_link}">{full_name}</a> likes your profile <a href="{link}">photo</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_profile_a_href_link_photo_a" added="1260479341"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own profile <a href="{link}">photo</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_profile_a_href_link_photo_a" added="1260479374"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s profile <a href="{link}">photo</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_a_href_link_comment_a" added="1260483339"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">comment</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="no_featured_members" added="1260813540">No featured members.</phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="there_are_no_members_online" added="1260813553">There are no members online.</phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="setting_user_browse_default_result" added="1260819672"><![CDATA[<title>Browsing Users Default Order</title><info>Select <b>full_name</b> to order members based on their full name in ascending order. Select <b>last_login</b> to order members based on their last activity, where the latest person to be active on the site is first.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="user_setting_can_edit_user_group_membership" added="1260825005"><![CDATA[Can modify a users "user group" status?]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="setting_remove_users_hidden_age" added="1260827335"><![CDATA[<title>User Age Privacy on Browse Section</title><info>Enable this option to remove users that have hidden their age from the browse section.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="setting_on_register_privacy_setting" added="1260914895"><![CDATA[<title>User Default Privacy Setting on Registration</title><info>With this setting you can control the default privacy setting for a user when they register. This will control how others view their profile.

anyone = Anyone can view their profile.

network = Only members of the site can view their profile.

friends_only = Only their friends can view their profile.

no_one = Nobody can view their profile.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0rc12" var_name="browse_filter_submit" added="1260981597">Submit</phrase>
		<phrase module_id="user" version_id="2.0.0" var_name="total_score_out_of_5" added="1261177339">{total_score} out of 5.</phrase>
		<phrase module_id="user" version_id="2.0.0" var_name="setting_min_count_for_top_rating" added="1261177451"><![CDATA[<title>Minimum Ratings for "Top Rated" Users</title><info>Define how many times a member must be rated on before they are listed on the "Top Rated" section.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.0" var_name="top_rated_members" added="1261178262">Top Rated Members</phrase>
		<phrase module_id="user" version_id="2.0.0" var_name="no_top_members_found" added="1261178695">No top members found.</phrase>
		<phrase module_id="user" version_id="2.0.0" var_name="all" added="1261179636">All</phrase>
		<phrase module_id="user" version_id="2.0.0" var_name="male" added="1261179642">Male</phrase>
		<phrase module_id="user" version_id="2.0.0" var_name="female" added="1261179649">Female</phrase>
		<phrase module_id="user" version_id="2.0.2" var_name="update_user_photos" added="1262110390">Update User Photos</phrase>
		<phrase module_id="user" version_id="2.0.2" var_name="total_score_out_of_10" added="1263212593">{total_score} out of 10</phrase>
		<phrase module_id="user" version_id="2.0.2" var_name="user_setting_can_view_if_a_user_is_invisible" added="1263216036"><![CDATA[Can view a users "Last Login" time stamp on their profile even if the user is logged as invisible?]]></phrase>
		<phrase module_id="user" version_id="2.0.4" var_name="total_activity_points" added="1266500173">Total Activity Points</phrase>
		<phrase module_id="user" version_id="2.0.4" var_name="activity_points" added="1266500821">Activity Points</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="setting_approve_users" added="1269284711"><![CDATA[<title>Approve Users</title><info>Enable this if you want to approve users before they can log into the site.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="your_account_is_pending_approval" added="1269285880">Your account is pending approval.</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="pending_approval" added="1269286717">Pending Approval</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="deny_user" added="1269286833">Deny User</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="approve_user" added="1269286895">Approve User</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="user_successfully_approved" added="1269350848">User successfully approved.</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="not_approved" added="1269350868">Not Approved</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="user_successfully_denied" added="1269350886">User successfully denied.</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="account_approved" added="1269351018">Account Approved</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="your_account_has_been_approved_on_site_title" added="1269351079"><![CDATA[Your account has been approved on {site_title}.

<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="users_pending_approval" added="1269352177">Users Pending Approval</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="user_setting_can_edit_currency" added="1271666567">Allow users to edit their default site currency?</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="preferred_currency" added="1271673716">Preferred Currency</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="show_prices_and_make_purchases_in_this_currency" added="1271673733">Show prices and make purchases in this currency.</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="payment_methods" added="1272279403">Payment Methods</phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="setting_display_or_full_name" added="1272872994"><![CDATA[<title>Display or Full Name</title><info>When a user registers on the site they can either enter their full name or display name. This setting controls what they should be entering.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.5" var_name="pending_email_verification" added="1273224031">Pending Email Verification</phrase>
		<phrase module_id="user" version_id="2.0.5dev1" var_name="setting_disable_username_on_sign_up" added="1274282432"><![CDATA[<title>Disable Username on Registration</title><info>If this is enabled it will disable the "Username" field on the registration form. The Username is used to create a vanity URL of users (eg. http://www.site.com/username). If this is disabled we will use their unique ID number to create their vanity URL. You can then enable a user group setting that can allow users to edit their username at a later time.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.5dev1" var_name="email_verification" added="1274636277">Email Verification</phrase>
		<phrase module_id="user" version_id="2.0.5dev1" var_name="mail_sent" added="1274637971">Mail Sent</phrase>
		<phrase module_id="user" version_id="2.0.5dev1" var_name="verification_email_sent" added="1274637981">Verification email sent.</phrase>
		<phrase module_id="user" version_id="2.0.5dev1" var_name="resend_verification_email" added="1274637994">Resend Verification Email</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="promotions" added="1275109970">Promotions</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="manage_promotions" added="1275110028">Manage Promotions</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="add_promotion" added="1275110053">Add Promotion</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="upgraded_user_group" added="1275112001">Upgraded User Group</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="total_days_registered" added="1275112016">Total Days Registered</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="no_promotions_found" added="1275112046">No promotions found.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="promotion_successfully_deleted" added="1275112057">Promotion successfully deleted.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="promotion_successfully_update" added="1275112080">Promotion successfully updated.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="promotion_successfully_added" added="1275112090">Promotion successfully added.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="editing_promotion" added="1275112127">Editing Promotion</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="promotion_details" added="1275112153">Promotion Details</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="days_registered" added="1275112186">Days Registered</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="move_user_to_user_group" added="1275112194">Move User to User Group</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="setting_check_promotion_system" added="1275113089"><![CDATA[<title>Check For Promotions</title><info>If you enable this option it will enable the promotion system and will run a check on users when they are logged into the site.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="congratulations_you_have_been_promoted_to_the_following_user_group_title" added="1275114389">Congratulations! You have been promoted to the following user group: {title}</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="before_you_can_use_this_feature_you_need_to_enable_the_option" added="1275114542"><![CDATA[Before you can use this feature you need to enable the option "Check For Promotions", which can be found <a href="{link}">here</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="user_s_successfully_deleted" added="1275116475">User(s) successfully deleted.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="delete_selected" added="1275116518">Delete Selected</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="user_s_successfully_banned" added="1275116738">User(s) successfully banned.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="user_s_successfully_un_banned" added="1275116766">User(s) successfully un-banned.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="ban_selected" added="1275116858">Ban Selected</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="un_ban_selected" added="1275116870">Un-Ban Selected</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="ban" added="1275179147">Ban</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="un_ban" added="1275179159">Un-Ban</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="with_selected" added="1275179181">With Selected</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="delete_user_full_name" added="1275179424">Delete user {full_name}</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="email_verification_s_sent" added="1275179908">Email verification(s) sent.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="user_s_verified" added="1275180138">User(s) verified.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="approve" added="1275180410">Approve</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="user_s_successfully_approved" added="1275180491">User(s) successfully approved.</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="ip_address" added="1275182314">IP Address</phrase>
		<phrase module_id="user" version_id="2.0.5dev2" var_name="user_link_full_name_commented_on_your_status" added="1275306747"><![CDATA[<a href="{user_link}">{full_name}</a> commented on one of your activity <a href="{link}">feeds</a>.]]></phrase>
		<phrase module_id="user" version_id="2.0.7" var_name="setting_allow_user_registration" added="1288616671"><![CDATA[<title>Allow User Registration</title><info>Enable this setting to allow public registration.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.7" var_name="user_setting_can_manage_user_group_settings" added="1289825772">Can manage user group settings?</phrase>
		<phrase module_id="user" version_id="2.0.7" var_name="user_setting_can_edit_user_group" added="1289825844">Can edit user groups?</phrase>
		<phrase module_id="user" version_id="2.0.7" var_name="user_setting_can_delete_user_group" added="1289826018">Can delete user group?</phrase>
		<phrase module_id="user" version_id="2.0.7" var_name="you_are_unable_to_delete_a_site_administrator" added="1289827215">You are unable to delete a site administrator.</phrase>
		<phrase module_id="user" version_id="2.0.7" var_name="you_are_unable_to_ban_a_site_administrator" added="1289827731">You are unable to ban a site administrator.</phrase>
		<phrase module_id="user" version_id="2.0.7" var_name="you_are_unable_to_edit_a_site_administrators_account" added="1289828060">You are unable to edit a site administrators account.</phrase>
		<phrase module_id="user" version_id="2.1.0Beta1" var_name="setting_enable_user_tooltip" added="1292335520"><![CDATA[<title>User AJAX Tooltip</title><info>Enable this setting to load an AJAX popup when hovering over certain member names that include the users profile image as well as some information about them.</info>]]></phrase>
		<phrase module_id="user" version_id="3.0.0Beta1" var_name="menu_user_logout_4ee1a589029a67e7f1a00990a1786f46" added="1295699471">Logout</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="inactive_member_email_subject" added="1296833975">We have missed you</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="inactive_member_email_body" added="1297074929"><![CDATA[<p>Hello {user_name},<br />
we have missed you at <a href="{site_url}">{site_name}</a> <br /><br />
Why not come and pay a visit to your friends, there's lots of catching up to do</p>]]></phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="there_are_a_total_of_icount_inactive_members" added="1297086852">There are a total of {iCount} inactive members</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="enter_a_number_of_days" added="1297087186">Enter a number of days</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="enter_a_number_to_size_each_batch" added="1297087223">Enter a number to size each batch</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="not_enough_users_to_mail" added="1297087333">Not enough users to mail</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="user_setting_can_member_snoop" added="1297692328">Can members of this user group log in as another user without entering a password?</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="log_in_as_this_user" added="1297697254">Log in as this user</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="member_snoop" added="1297697278">Member Snoop</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="member_snoop_text" added="1297697535"><![CDATA[You are about to log in as the user <a href="{user_link}" target="_blank">{user_name}</a> ({full_name}). This has the same effect as if you logged in with that user's password. When in this mode, all your actions will be	regarded as executed by {full_name}. <br /> To go back to your admin user you will need to log out and back in.]]></phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="abort_log_in_as_this_user" added="1297697736">Abort log in as this user</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="deny_mail_subject" added="1298464722">Your registration to {site_name} has been denied</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="deny_mail_message" added="1298464944">At this moment your profile does not meet the minimum requirements for our site. 
If you feel this is an error, feel free to contact us to {site_email}</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="you_are_about_to_deny_user" added="1298470496"><![CDATA[You are about to deny user <a href="{link}">{user_name}</a> from the site.
If you want to send an email to this user you may do it here]]></phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="deny_and_send_email" added="1298471061">Deny and send email</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="deny_without_email" added="1298471080">Deny without email</phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="setting_brute_force_attempts_count" added="1299680854"><![CDATA[<title>Brute Force Prevention: Attempts Count</title><info>How many attempts are allowed within the time limit? 

This setting is used together with "Brute Force Prevention: Time limit" to better protect your site from brute force login attempts. 

You define a time in minutes and how many failed attempts are allowed within that period of time, if a user fails to log in within that period of time, missing this many tries the account is locked for a certain time, this lock time is defined by the cool down time and during this time even if the correct log in is entered, access will be denied.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="setting_brute_force_time_check" added="1299681159"><![CDATA[<title>Brute Force Prevention: Time Limit</title><info>How many minutes back should the script check?
Set this to 0 if you do not want to run this check

This setting is used together with "Brute Force Prevention: Attempts Count" to better protect your site from brute force login attempts.</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="setting_brute_force_cool_down" added="1299682133"><![CDATA[<title>Brute Force Prevention: Cool Down</title><info>When an account has been locked due to a brute force check, how many minutes should the user wait before unlocking the account?</info>]]></phrase>
		<phrase module_id="user" version_id="2.0.8" var_name="brute_force_account_locked" added="1299683217"><![CDATA[Brute force attempt logged. Your account has been locked for {iCoolDown} minutes. If you forgot your password please use the <a href="{sForgotLink}">Forgot Password tool</a>.
You can try to log in again in {iUnlockTimeOut} minutes.]]></phrase>
		<phrase module_id="user" version_id="2.1.0beta1" var_name="that_user_does_not_exist" added="1300099212">That user does not exist</phrase>
		<phrase module_id="user" version_id="2.1.0beta1" var_name="email_is_in_use_and_user_can_login" added="1300891508"><![CDATA[There is already an account assigned with the email "{email}". If this is your email please login <a href="{link}">here</a>.]]></phrase>
		<phrase module_id="user" version_id="2.1.0rc1" var_name="setting_force_user_to_upload_on_sign_up" added="1301564621"><![CDATA[<title>Force Users to Upload Profile Image</title><info>Enable this option to force users to upload a profile image before they can register.</info>]]></phrase>
		<phrase module_id="user" version_id="2.1.0rc1" var_name="profile_image" added="1301564651">Profile Image</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="custom_relationship_status" added="1302872875">Relationship Status</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_single" added="1302872875">Single</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_in_a_relationship" added="1302872875">In a relationship</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_engaged" added="1302872875">Engaged</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_married" added="1302872875">Married</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_its_complicated" added="1302872875">Its complicated</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_in_an_open_relationship" added="1302872875">In an open relationship</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_widowed" added="1302872875">Widowed</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_separated" added="1302872875">Separated</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="cf_option_divorced" added="1302872875">Divorced</phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="setting_hide_main_menu" added="1306142141"><![CDATA[<title>Hide Main Menu</title><info>Enable this option to hide the main menu if a user is not logged into the site.</info>]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta1" var_name="setting_invite_only_community" added="1306476862"><![CDATA[<title>Invite Only</title><info>Enable this option if your community is an "invite only" community.</info>]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta3" var_name="setting_new_user_terms_confirmation" added="1315851732"><![CDATA[<title>Terms & Privacy Confirmation</title><info>Enable this option if users must confirm that they understand and have read over your sites terms and privacy policies.</info>]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta4" var_name="menu_user_account_settings_73c8da87d666df89aabd61620c81c24c" added="1317128919">Account Settings</phrase>
		<phrase module_id="user" version_id="3.0.0beta4" var_name="menu_user_privacy_settings_73c8da87d666df89aabd61620c81c24c" added="1317128967">Privacy Settings</phrase>
		<phrase module_id="user" version_id="3.0.0beta4" var_name="setting_enable_relationship_status" added="1317129649"><![CDATA[<title>Enable Relationships</title><info>If you would like your users to have the ability to set their relationship status on your community, enable this feature.</info>]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="1_mutual_friend" added="1319122856">1 mutual friend</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="total_mutual_friends" added="1319122869">{total} mutual friends</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="add_friend" added="1319122883">Add Friend</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="advanced_filters" added="1319122982">Advanced Filters</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="close_advanced_filters" added="1319122993">Close Advanced Filters</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="1_member" added="1319187425">1 member.</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="total_members" added="1319187451">{total} members.</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="1_person_likes_this" added="1319187466">1 person likes this.</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="total_people_like_this" added="1319187480">{total} people like this.</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="age_years_old" added="1319187501">{age} years old</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="mutual_friends_total" added="1319187520">Mutual Friends ({total})</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="add_as_friend" added="1319187556">Add as Friend</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="say_happy_birthday" added="1319187573">Say Happy Birthday</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="customize_how_other_users_interact_with_your_profile" added="1319465869">Customize how other users interact with your profile.</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="show_my_full_birthday_in_my_profile" added="1319466000">Show my full birthday in my profile.</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="show_only_month_amp_day_in_my_profile" added="1319466009"><![CDATA[Show only month &amp; day in my profile.]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="don_t_show_my_birthday_in_my_profile" added="1319466023"><![CDATA[Don't show my birthday in my profile.]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="customize_your_default_settings_for_when_sharing_new_items_on_the_site" added="1319466044">Customize your default settings for when sharing new items on the site. Note this only changes your default settings for future items and does not change any items you have already shared. To change the privacy settings on those items you can customize the items privacy by editing the item itself.</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="items" added="1319466075">Items</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_your_profile" added="1319466105">View Your Profile</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="send_you_a_message" added="1319466218">Send you a message</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="display_rss_subscribers_count" added="1319466235">Display RSS subscribers count</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="subscribe_to_your_rss_feed" added="1319466242">Subscribe to your RSS feed</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_who_recently_viewed_your_profile" added="1319466253">View who recently viewed your profile</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_your_friends" added="1319466263">View your friends</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="share_on_your_wall" added="1319466274">Share on your wall</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_your_wall" added="1319466288">View your wall</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="rate_your_profile" added="1319466306">Rate your profile</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_photos_within_your_profile" added="1319466316">View photos within your profile</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_your_profile_lowercase" added="1319466339">View your profile</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_your_basic_information" added="1319466348">View your basic information</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_your_profile_information" added="1319466355">View your profile information</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="view_your_location" added="1319466365">View your location</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="community" added="1319466425">Community</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="blogs" added="1319466527">Blogs</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="polls" added="1319466537">Polls</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="photos" added="1319466559">Photos</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="songs" added="1319466570">Songs</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="quizzes" added="1319466580">Quizzes</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="full_name_liked_your_status_update_content" added="1319468529">{full_name} liked one of your status updates.</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="full_name_liked_your_status_update_message" added="1319468654"><![CDATA[{full_name} liked your status update "<a href="{link}">{content}</a>"
To view this status update follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="full_name_liked_a_comment_you_posted_on_row_full_name_s_wall" added="1319468762"><![CDATA[{full_name} liked a comment you posted on {row_full_name}'s wall]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="full_name_liked_your_comment_message" added="1319529906"><![CDATA[{full_name} liked your comment "<a href="{link}">{content}</a>" that you posted on {row_full_name}'s wall.
To view this comment follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="full_name_liked_one_of_your_comments" added="1319529963">{full_name} liked one of your comments</phrase>
		<phrase module_id="user" version_id="3.0.0beta5" var_name="full_name_liked_your_comment_message_mini" added="1319530048"><![CDATA[{full_name} liked your comment "<a href="{link}">{content}</a>" that you posted.
To view this comment follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="it_s_free_and_always_will_be" added="1320060012"><![CDATA[It's free and always will be.]]></phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="ssitetitle_is_an_invite_only_community_enter_your_email_below_if_you_have_received_an_invitation" added="1320060060">{sSiteTitle} is an invite only community. Enter your email below if you have received an invitation.</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="ssitename_helps_you_connect_and_share_with_the_people_in_your_life" added="1320060210">{sSiteName} helps you connect and share with the people in your life.</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="i_am" added="1320060287">I am</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="ssitetitle_helps_you_connect_and_share_with_the_people_in_your_life" added="1320060853">{sSiteTitle} helps you connect and share with the people in your life.</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="join_ssitetitle_to_connect_with_friends_share_photos_and_create_your_own_profile" added="1320060918">Join {sSiteTitle} to connect with friends, share photos and create your own profile.</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="or_sign_up_with" added="1320060934">or sign up with</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="keep_me_logged_in" added="1320061093">Keep me logged in</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="login_singular" added="1320061124">Login</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="or_login_with" added="1320061134">or login with</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="sign_up_for_ssitetitle" added="1320061195">Sign Up for {sSiteTitle}</phrase>
		<phrase module_id="user" version_id="3.0.0rc1" var_name="menu_who_s_online" added="1320073476"><![CDATA[Who's Online]]></phrase>
		<phrase module_id="user" version_id="3.0.0rc2" var_name="profile_photo_successfully_updated" added="1321363890">Profile photo successfully updated.</phrase>
		<phrase module_id="user" version_id="3.0.0rc2" var_name="search_friends_by_their_name" added="1321365393">Search friends by their name...</phrase>
		<phrase module_id="user" version_id="3.0.0rc2" var_name="login_ajax" added="1321437272">Login</phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="full_name_commented_on_your_status_update" added="1322466364">{full_name} commented on your status update.</phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="get_information_about_a_user_based_on_the_user_id_you_pass_if_you_do_not_pass_the_user_id_we_will_return_information_about_the_user_that_is_currently_logged_in" added="1322730371">Get information about a user based on the user ID# you pass. If you do not pass the #{USER_ID} we will return information about the user that is currently logged in.</phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="user_name_liked_gender_own_status_update_title" added="1322730467"><![CDATA[{user_name} liked {gender} own status update "{title}"]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="user_name_liked_your_status_update_title" added="1322730568"><![CDATA[{user_name} liked your status update "{title}"]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="user_name_liked_span_class_drop_data_user_full_name_s_span_status_update_title" added="1322730676"><![CDATA[{user_name} liked <span class="drop_data_user">{full_name}'s</span> status update "{title}"]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="full_name_commented_on_your_status_update_title_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322732634"><![CDATA[{full_name} commented on your status update "{title}".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="full_name_commented_on_one_of_gender_status_updates" added="1322732711">{full_name} commented on one of {gender} status updates.</phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="full_name_commented_on_one_of_other_full_name_s_status_updates" added="1322732816"><![CDATA[{full_name} commented on one of {other_full_name}'s status updates.]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="full_name_commented_on_gender_status_update_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322732978"><![CDATA[{full_name} commented on {gender} status update "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_status_update_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322733117"><![CDATA[{full_name} commented on {other_full_name}'s status update "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1322733155">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="span_class_drop_data_user_full_name_span_commented_on_gender_status_update_title" added="1322733247"><![CDATA[<span class="drop_data_user">{full_name}</span> commented on {gender} status update "{title}"]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="span_class_drop_data_user_full_name_span_commented_on_your_status_update_title" added="1322733434"><![CDATA[<span class="drop_data_user">{full_name}</span> commented on your status update "{title}"]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="span_class_drop_data_user_full_name_span_commented_on_span_class_drop_data_user_other_full_name_s_span_status_update_title" added="1322733562"><![CDATA[<span class="drop_data_user">{full_name}</span> commented on <span class="drop_data_user">{other_full_name}'s</span> status update "{title}"]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="pending_confirmation" added="1323087876">Pending Confirmation</phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="setting_user_dob_month_day_year" added="1323244991"><![CDATA[<title>User D.O.B (Month, Day & Year)</title><info>Control how we display the users date of birth for the privacy setting "Show my full birthday in my profile".</info>]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="setting_user_dob_month_day" added="1323245329"><![CDATA[<title>User D.O.B (Month & Day)</title><info>Control how we display the users date of birth for the privacy setting "Show only month & day in my profile.".</info>]]></phrase>
		<phrase module_id="user" version_id="3.0.0" var_name="user_registration_has_been_disabled" added="1323687223">User registration has been disabled</phrase>
		<phrase module_id="user" version_id="3.1.0beta1" var_name="setting_default_privacy_brithdate" added="1330014202"><![CDATA[<title>Default Birthday Privacy Setting</title><info>Users can control their default privacy settings when it comes to how they want their birthdays to be displayed on their profile. When users sign up and have not chosen a privacy setting you can define a default setting for the site.

Here is a key of what the values stand for...
<b>full_birthday</b> = <i>Show full birthday</i>
<b>month_day</b> = <i>Show month & day</i>
<b>show_age</b> = <i>Only show the users age</i>
<b>hide</b> = <i>Hide users age/birthday</i></info>]]></phrase>
		<phrase module_id="user" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment" added="1331221510">{user_name} tagged you in a comment</phrase>
		<phrase module_id="user" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_status_update" added="1331221577">{user_name} tagged you in a status update</phrase>
		<phrase module_id="user" version_id="3.1.0beta1" var_name="setting_no_show_activity_points" added="1331554285"><![CDATA[<title>Show Activity Points on Dashboard</title><info>Enable this option to show the activity points displayed on the dashboard.</info>]]></phrase>
		<phrase module_id="user" version_id="3.1.0rc1" var_name="setting_shorter_password_reset_routine" added="1332231623"><![CDATA[<title>Shorter Password Reset Routine</title><info>If this is enabled when a user clicks on Forgot your password he will receive an email with a link, when clicking on the link he will be shown an input where to change the password. The site will not assign a new password to that user and the previous password will work until it has been reset.</info>]]></phrase>
		<phrase module_id="user" version_id="3.1.0rc1" var_name="request_expired_please_try_again" added="1332235241">Request expired. Please try again.</phrase>
		<phrase module_id="user" version_id="3.1.0rc1" var_name="menu_user_members_532c28d5412dd75bf975fb951c740a30" added="1332258017">Members</phrase>
		<phrase module_id="user" version_id="3.1.0" var_name="to" added="1332764521">to</phrase>
		<phrase module_id="user" version_id="3.1.0" var_name="with" added="1332765004">with</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="set_as_cover_photo" added="1334069903">Set as Cover Photo</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="set_this_photo_as_your_profile_cover_photo" added="1334069940">Set this photo as your profile cover photo.</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="add_a_cover" added="1334155780">Add a Cover</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="change_cover" added="1334155789">Change Cover</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="choose_from_photos" added="1334155795">Choose From Photos</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="upload_photo" added="1334155802">Upload Photo</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="reposition" added="1334155808">Reposition</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="remove" added="1334155814">Remove</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="drag_to_reposition_cover" added="1334155838">Drag to Reposition Cover</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="cancel_cover_photo" added="1334155858">Cancel</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="select_a_photo" added="1334155876">Select a Photo</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="upload" added="1334155888">Upload</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="status_updates" added="1334579416">Status Updates</phrase>
		<phrase module_id="user" version_id="3.2.0beta1" var_name="who_can_tag_me_in_written_contexts" added="1334583235">Who can tag me in written contexts?</phrase>
		<phrase module_id="user" version_id="3.3.0beta1" var_name="setting_maximum_length_for_full_name" added="1338899710"><![CDATA[<title>Maximum Length for Full Name</title><info>Maximum length for full name</info>]]></phrase>
		<phrase module_id="user" version_id="3.3.0beta1" var_name="please_shorten_full_name" added="1338900126">Please shorten your full name to a maximum of {iMax} characters.</phrase>
		<phrase module_id="user" version_id="3.3.0beta1" var_name="please_shorten_display_name" added="1338900157">Please shorten your display name to a maximum of {iMax} characters.</phrase>
		<phrase module_id="user" version_id="3.3.0beta1" var_name="timeline" added="1339425152">Timeline</phrase>
		<phrase module_id="user" version_id="3.3.0rc1" var_name="administrator" added="1341914231">Administrator</phrase>
		<phrase module_id="user" version_id="3.3.0rc1" var_name="registered_user" added="1341914250">Registered User</phrase>
		<phrase module_id="user" version_id="3.3.0rc1" var_name="guest" added="1341914265">Guest</phrase>
		<phrase module_id="user" version_id="3.3.0rc1" var_name="staff" added="1341914276">Staff</phrase>
		<phrase module_id="user" version_id="3.3.0rc1" var_name="banned" added="1341914289">Banned</phrase>
		<phrase module_id="user" version_id="3.3.0rc1" var_name="user_banned" added="1342606816">Banned</phrase>
		<phrase module_id="user" version_id="3.3.0" var_name="time_minutes" added="1343729369">{time} minutes</phrase>
		<phrase module_id="user" version_id="3.3.0" var_name="time_hour" added="1343729770">{time} hour</phrase>
		<phrase module_id="user" version_id="3.3.0" var_name="time_hours" added="1343729854">{time} hours</phrase>
		<phrase module_id="user" version_id="3.3.0" var_name="time_days" added="1343729890">{time} days</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="setting_split_full_name" added="1346150751"><![CDATA[<title>User split full name</title><info>Split user&#039;s full name into last name and first name</info>]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="email_s_do_not_match" added="1344506758"><![CDATA[Email&#039;s do not match.]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="please_reenter_your_email_again_below" added="1344506853">Please reenter your email again below.</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="landing_page" added="1344594677">Landing Page</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="wall" added="1344594702">Wall</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="profile_info" added="1344594709">Profile Info</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="please_fill_in_both_your_first_and_last_name" added="1344843606">Please fill in both your first and last name.</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="setting_points_conversion_rate" added="1347184539"><![CDATA[<title>Activity Points Conversion Rate</title><info>Define how much an activity point is worth for each available currency.</info>]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="setting_can_purchase_with_points" added="1347184559"><![CDATA[<title>Purchasing with Activity Points</title><info>Enable this option if you would like to allow users to be able to purchase items using their activity points.</info>]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="setting_reenter_email_on_signup" added="1347184582"><![CDATA[<title>Force Users to Reenter Email</title><info>Enable this option to add a new input field where users would have to reenter their email during the registration process to assure they are entering the correct email.</info>]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="you_can_purchase_this_with_your_activity_points" added="1347185085">You can purchase this with your activity points.</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="purchase_points_info" added="1347193409">You have {yourpoints} activity point(s). This will cost {yourcost} activity point(s).</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="not_enough_points" added="1347193470">You do not have enough points to purchase this item. You have a total of {total} activity point(s).</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="thank_you_for_your_purchase" added="1347864904">Thank you for your purchase.</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="how_many_points_would_you_like_to_purchase" added="1347864947">How many points would you like to purchase?</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="setting_can_purchase_activity_points" added="1347865412"><![CDATA[<title>Purchase Activity Points</title><info>If enabled, users will be allowed to purchase activity points.</info>]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="purchase_points" added="1347865587">Purchase Points</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="birth_date" added="1347948660">Birth Date</phrase>
		<phrase module_id="user" version_id="3.4.0beta1" var_name="unable_to_share_this_post_due_to_privacy_settings" added="1347968376">Unable to share this post due to privacy settings.</phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="uploading_image" added="1348124572">Uploading image...</phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="setting_prevent_profile_photo_cache" added="1348466690"><![CDATA[<title>Profile Photo Cache Prevention</title><info>Enable this option to force a users own profile photo from being cached. This will always assure the user will see the latest profile photo they uploaded.</info>]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="show_users_who_have_not_logged_in_for" added="1349077447">Show users who have not logged in for</phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="days" added="1349077455">days</phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="send_mails_in_batches_of" added="1349077461">Send mails in batches of</phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="enter_0_for_all_at_once" added="1349077468"><![CDATA[Enter 0 for "all at once"]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="this_feature_uses_the_language" added="1349077479"><![CDATA[This feature uses the language phrase "user.mail_inactive_users" to send an email.]]></phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="get_members_count" added="1349077486">Get Members Count</phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="process_mailing_job" added="1349077491">Process Mailing Job</phrase>
		<phrase module_id="user" version_id="3.4.0beta2" var_name="stop_mailing_job" added="1349077496">Stop Mailing Job</phrase>
		<phrase module_id="user" version_id="3.4.0rc1" var_name="user_setting_can_purchase_with_points" added="1349939638">Can purchase with activity points?</phrase>
		<phrase module_id="user" version_id="3.4.0" var_name="purchase_activity_points" added="1350916832">Purchase Activity Points</phrase>
		<phrase module_id="user" version_id="3.4.0" var_name="first_name" added="1351663285">First Name</phrase>
		<phrase module_id="user" version_id="3.4.0" var_name="last_name" added="1351663293">Last Name</phrase>
		<phrase module_id="user" version_id="3.5.0beta1" var_name="user_setting_hide_from_browse" added="1352114001"><![CDATA[If enabled, members of this user group will be able hide themselves from the Browse section when they enable "Invisible Mode" from Profile -> Privacy Settings]]></phrase>
		<phrase module_id="user" version_id="3.5.0beta1" var_name="anti_spam_security_questions" added="1352733835">Anti-Spam Security Questions</phrase>
		<phrase module_id="user" version_id="3.5.0beta1" var_name="admin_menu_phrase_var_user_anti_spam_security_questions" added="1352734459">Anti Spam Question</phrase>
		<phrase module_id="user" version_id="3.5.0beta1" var_name="setting_require_all_spam_questions_on_signup" added="1352881154"><![CDATA[<title>Spam Check Requires All Questions</title><info>If set to true visitors will have to answer all of the spam questions available before creating their account. 
If this setting is set to false visitors will have to answer only one question, chosen randomly by the site.</info>]]></phrase>
		<phrase module_id="user" version_id="3.5.0beta1" var_name="user_setting_can_search_by_zip" added="1352991266">Should members of this user group search other users in the site by Zip code?.
(This setting does not affect the AdminCP)</phrase>
		<phrase module_id="user" version_id="3.5.0beta1" var_name="question_deleted_succesfully" added="1355317204">Question deleted successfully</phrase>
		<phrase module_id="user" version_id="3.5.0beta2" var_name="please_enter_your_date_of_birth" added="1359455412">Please enter your date of birth.</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="if_your_site_uses_multiple_languages" added="1361781687"><![CDATA[If your site uses multiple languages you can <a href="{sSiteUsePhrase}">create a language phrase here</a>, and use it when adding the question or answers.]]></phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="add_new_question" added="1361782322">Add New Question</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="you_can_add_an_image_if_you_like" added="1361782332">You can add an image if you like</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="delete_image" added="1361782362">Delete Image</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="you_can_add_your_question_here" added="1361782431">You can add your question here</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="you_can_enter_the_html_code_for_a_language_phrase_for_example" added="1361782453">You can enter the HTML code for a language phrase, for example</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="now_add_at_least_one_valid_answer" added="1361782460">Now add at least one valid answer</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="add_more_answers" added="1361782471">Add more answers</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="you_can_use_html_code_for_language_phrases_for_example" added="1361782487">You can use HTML code for language phrases, for example</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="add_question" added="1361782497">Add Question</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="current_questions" added="1361782503">Current Questions</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="image" added="1361782510">Image</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="question" added="1361782515">Question</phrase>
		<phrase module_id="user" version_id="3.5.0" var_name="answers" added="1361782522">Answers</phrase>
		<phrase module_id="user" version_id="3.5.1" var_name="that_question_does_not_exist_all_hack_attempts_are_forbidden_and_logged" added="1366790871">That question does not exist. All hack attempts are forbidden and logged.</phrase>
		<phrase module_id="user" version_id="3.5.1" var_name="captcha_failed" added="1366790891">CAPTCHA failed</phrase>
		<phrase module_id="user" version_id="3.5.1" var_name="edit_question" added="1366802158">Edit Question</phrase>
		<phrase module_id="user" version_id="3.6.0rc1" var_name="setting_cache_featured_users" added="1371724982"><![CDATA[<title>Featured Users</title><info>This caches the list of featured users.</info>]]></phrase>
		<phrase module_id="user" version_id="3.6.0rc1" var_name="setting_cache_user_inner_joins" added="1371726974"><![CDATA[<title>Cache Users SQL INNER JOINS</title><info>Cache users INNER JOINS to stop querying the database for user details.</info>]]></phrase>
		<phrase module_id="user" version_id="3.6.0rc1" var_name="setting_cache_recent_logged_in" added="1371731813"><![CDATA[<title>Cache Recent Logins</title><info>Cache the users that have recently logged in. Setting is in minutes.</info>]]></phrase>
		<phrase module_id="user" version_id="3.6.0rc1" var_name="setting_disable_store_last_user" added="1371732187"><![CDATA[<title>Disable Last Time Stamp for Users</title><info>If enabled we don&#039;t store the last time a user visits the site.</info>]]></phrase>
		<phrase module_id="user" version_id="3.7.0beta2" var_name="view_more_search_options" added="1376308100">View More Search Options</phrase>
		<phrase module_id="user" version_id="3.7.4" var_name="reason" added="1386000511">Reason</phrase>
		<phrase module_id="user" version_id="3.7.5" var_name="cookie" added="1392650792">cookie</phrase>
		<phrase module_id="user" version_id="3.7.5" var_name="session" added="1392650797">session</phrase>
		<phrase module_id="user" version_id="3.7.5" var_name="name_photo_detail" added="1392650885"><![CDATA[Name, Photo & Details]]></phrase>
		<phrase module_id="user" version_id="3.7.5" var_name="name_photo" added="1392650908"><![CDATA[Name & Photo]]></phrase>
		<phrase module_id="user" version_id="3.7.5" var_name="full_birthday" added="1392651018">Full birthday</phrase>
		<phrase module_id="user" version_id="3.7.5" var_name="month_day" added="1392651040"><![CDATA[Month & Day]]></phrase>
		<phrase module_id="user" version_id="3.7.5" var_name="show_age" added="1392651054">Show age only</phrase>
		<phrase module_id="user" version_id="3.7.5" var_name="hide" added="1392651068">Hide</phrase>
		<phrase module_id="user" version_id="4.0.10" var_name="recently_active" added="1445849785">Recently Active</phrase>
		<phrase module_id="user" version_id="4.0.10" var_name="recommended_users" added="1445849885">Recommended Users</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="0" module="user" ordering="0">can_add_user_group_setting</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_control_profile_privacy</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_control_notification_privacy</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="1" module="user" ordering="0">can_override_user_privacy</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="0" user="0" guest="0" staff="0" module="user" ordering="0">require_profile_image</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_edit_gender_setting</setting>
		<setting is_admin_setting="0" module_id="user" type="string" admin="" user="" guest="" staff="" module="user" ordering="0">custom_name_field</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_edit_dob</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="1" module="user" ordering="0">can_edit_users</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_stay_logged_in</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="1" module="user" ordering="0">can_change_other_user_picture</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="1" module="user" ordering="0">can_edit_other_user_privacy</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="0" module="user" ordering="0">can_change_own_user_name</setting>
		<setting is_admin_setting="0" module_id="user" type="integer" admin="3" user="3" guest="3" staff="3" module="user" ordering="0">total_times_can_change_user_name</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_block_other_members</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="0" user="1" guest="1" staff="0" module="user" ordering="0">can_be_blocked_by_others</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="true" user="false" guest="false" staff="false" module="user" ordering="0">can_feature</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="true" user="true" guest="false" staff="true" module="user" ordering="0">can_change_email</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="true" user="false" guest="false" staff="true" module="user" ordering="0">can_verify_others_emails</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="false" user="true" guest="false" staff="false" module="user" ordering="0">can_delete_own_account</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="true" user="true" guest="false" staff="true" module="user" ordering="0">can_change_own_full_name</setting>
		<setting is_admin_setting="0" module_id="user" type="integer" admin="0" user="3" guest="1" staff="0" module="user" ordering="0">total_times_can_change_own_full_name</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="true" user="false" guest="false" staff="false" module="user" ordering="0">can_delete_others_account</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_be_invisible</setting>
		<setting is_admin_setting="0" module_id="user" type="integer" admin="0" user="0" guest="0" staff="0" module="user" ordering="0">total_upload_space</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="0" user="0" guest="0" staff="0" module="user" ordering="0">force_cropping_tool_for_photos</setting>
		<setting is_admin_setting="0" module_id="user" type="integer" admin="500" user="500" guest="500" staff="500" module="user" ordering="0">max_upload_size_profile_photo</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="1" staff="1" module="user" ordering="0">can_search_user_gender</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="1" staff="1" module="user" ordering="0">can_search_user_age</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="1" staff="1" module="user" ordering="0">can_browse_users_in_public</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="0" module="user" ordering="0">can_edit_user_group_membership</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="1" module="user" ordering="0">can_view_if_a_user_is_invisible</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_edit_currency</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="0" module="user" ordering="0">can_manage_user_group_settings</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="0" module="user" ordering="0">can_edit_user_group</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="0" guest="0" staff="0" module="user" ordering="0">can_delete_user_group</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="false" user="false" guest="false" staff="false" module="user" ordering="0">can_member_snoop</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="1" user="1" guest="0" staff="1" module="user" ordering="0">can_purchase_with_points</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="false" user="false" guest="false" staff="false" module="user" ordering="0">hide_from_browse</setting>
		<setting is_admin_setting="0" module_id="user" type="boolean" admin="true" user="true" guest="true" staff="true" module="user" ordering="0">can_search_by_zip</setting>
	</user_group_settings>
	<tables><![CDATA[a:36:{s:11:"phpfox_user";a:3:{s:7:"COLUMNS";a:33:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:15:"profile_page_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"user_group_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"status_id";a:4:{i:0;s:6:"TINT:2";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"user_name";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"full_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"password";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"password_salt";a:4:{i:0;s:6:"CHAR:3";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:5:"email";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"gender";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"birthday";a:4:{i:0;s:7:"CHAR:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"birthday_search";a:4:{i:0;s:4:"BINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"country_iso";a:4:{i:0;s:6:"CHAR:2";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"language_id";a:4:{i:0;s:8:"VCHAR:12";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"style_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"time_zone";a:4:{i:0;s:6:"CHAR:4";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"dst_check";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"joined";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"last_login";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"last_activity";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"user_image";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"hide_tip";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"status";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"footer_bar";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"invite_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"im_beep";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"im_hide";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"is_invisible";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_spam";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"last_ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"feed_sort";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"user_id";s:4:"KEYS";a:11:{s:9:"user_name";a:2:{i:0;s:5:"INDEX";i:1;s:9:"user_name";}s:5:"email";a:2:{i:0;s:5:"INDEX";i:1;s:5:"email";}s:10:"user_image";a:2:{i:0;s:5:"INDEX";i:1;s:10:"user_image";}s:13:"user_group_id";a:2:{i:0;s:5:"INDEX";i:1;s:13:"user_group_id";}s:11:"user_status";a:2:{i:0;s:5:"INDEX";i:1;s:9:"status_id";}s:10:"total_spam";a:2:{i:0;s:5:"INDEX";i:1;s:10:"total_spam";}s:9:"status_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"status_id";i:1;s:7:"view_id";}}s:11:"public_feed";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:9:"status_id";i:1;s:7:"view_id";i:2;s:13:"last_activity";}}s:11:"status_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:9:"status_id";i:1;s:7:"view_id";i:2;s:9:"full_name";}}s:7:"page_id";a:2:{i:0;s:5:"INDEX";i:1;s:15:"profile_page_id";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:9:"status_id";}}}}s:20:"phpfox_user_activity";a:2:{s:7:"COLUMNS";a:18:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"activity_blog";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:19:"activity_attachment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"activity_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"activity_photo";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:17:"activity_bulletin";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"activity_poll";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"activity_invite";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"activity_forum";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"activity_video";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"activity_total";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"activity_points";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"activity_quiz";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:19:"activity_music_song";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:20:"activity_marketplace";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"activity_event";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"activity_pages";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:22:"activity_points_gifted";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}}}s:19:"phpfox_user_blocked";a:3:{s:7:"COLUMNS";a:5:{s:8:"block_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"block_user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:8:"block_id";s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:13:"block_user_id";}}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:17:"phpfox_user_count";a:2:{s:7:"COLUMNS";a:7:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"mail_new";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"comment_pending";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"friend_request";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"group_invite";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"event_invite";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:18:"marketplace_invite";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}}}s:15:"phpfox_user_css";a:2:{s:7:"COLUMNS";a:5:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"css_selector";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:12:"css_property";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"css_value";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:20:"phpfox_user_css_code";a:2:{s:7:"COLUMNS";a:2:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"css_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}}}s:18:"phpfox_user_custom";a:2:{s:7:"COLUMNS";a:6:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"cf_about_me";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:20:"cf_record_label_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:20:"cf_record_label_type";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:22:"cf_relationship_status";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:23:"cf_which_best_describes";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}}}s:24:"phpfox_user_custom_value";a:2:{s:7:"COLUMNS";a:6:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"cf_about_me";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:20:"cf_record_label_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:20:"cf_record_label_type";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:22:"cf_relationship_status";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:23:"cf_which_best_describes";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}}}s:21:"phpfox_user_dashboard";a:2:{s:7:"COLUMNS";a:5:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"cache_id";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"block_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_hidden";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:9:"is_hidden";}}}}s:18:"phpfox_user_delete";a:3:{s:7:"COLUMNS";a:6:{s:9:"delete_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"phrase_var";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"delete_id";s:4:"KEYS";a:1:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:27:"phpfox_user_delete_feedback";a:3:{s:7:"COLUMNS";a:7:{s:11:"feedback_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"user_email";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"full_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"user_group_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"feedback_text";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"reasons_given";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"feedback_id";s:4:"KEYS";a:1:{s:10:"user_email";a:2:{i:0;s:5:"INDEX";i:1;s:10:"user_email";}}}s:24:"phpfox_user_design_order";a:2:{s:7:"COLUMNS";a:5:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"cache_id";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"block_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_hidden";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:20:"phpfox_user_featured";a:2:{s:7:"COLUMNS";a:2:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:6:"TINT:2";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"user_id";}s:17:"phpfox_user_field";a:2:{s:7:"COLUMNS";a:43:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"first_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"last_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"signature";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"signature_clean";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:17:"designer_style_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_friend";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_post";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:18:"total_profile_song";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_score";a:4:{i:0;s:9:"DECIMAL:4";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_rating";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:17:"total_user_change";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:22:"total_full_name_change";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"country_child_id";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"city_location";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"postal_code";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:12:"subscribe_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"dob_setting";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"birthday_range";a:4:{i:0;s:6:"CHAR:4";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"rss_count";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"css_hash";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:16:"newsletter_state";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"in_admincp";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"default_currency";a:4:{i:0;s:7:"VCHAR:3";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"total_blog";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_video";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_poll";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_quiz";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_event";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_song";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_listing";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_photo";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_pages";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:21:"brute_force_locked_at";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:16:"relation_data_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"relation_with";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"cover_photo";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"cover_photo_top";a:4:{i:0;s:7:"VCHAR:5";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:12:"use_timeline";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"landing_page";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"location_latlng";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}s:17:"designer_style_id";a:2:{i:0;s:5:"INDEX";i:1;s:17:"designer_style_id";}}}s:19:"phpfox_user_gateway";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"gateway_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"gateway_detail";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:17:"phpfox_user_group";a:3:{s:7:"COLUMNS";a:7:{s:13:"user_group_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"inherit_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_special";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"prefix";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"suffix";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"icon_ext";a:4:{i:0;s:7:"VCHAR:6";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:13:"user_group_id";s:4:"KEYS";a:2:{s:13:"user_group_id";a:2:{i:0;s:5:"INDEX";i:1;s:13:"user_group_id";}s:10:"is_special";a:2:{i:0;s:5:"INDEX";i:1;s:10:"is_special";}}}s:24:"phpfox_user_group_custom";a:3:{s:7:"COLUMNS";a:5:{s:10:"setting_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:13:"user_group_id";a:4:{i:0;s:6:"TINT:4";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"default_value";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"setting_id";s:4:"KEYS";a:1:{s:13:"user_group_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:13:"user_group_id";i:1;s:9:"module_id";i:2;s:4:"name";}}}}s:25:"phpfox_user_group_setting";a:3:{s:7:"COLUMNS";a:12:{s:10:"setting_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:16:"is_admin_setting";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_hidden";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"default_admin";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"default_user";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"default_guest";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"default_staff";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"setting_id";s:4:"KEYS";a:2:{s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"product_id";}s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"module_id";}}}s:20:"phpfox_user_inactive";a:2:{s:7:"COLUMNS";a:7:{s:6:"job_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:13:"days_inactive";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"batch_size";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"page_number";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"date_started";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_users";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"job_id";}s:14:"phpfox_user_ip";a:3:{s:7:"COLUMNS";a:5:{s:6:"ip_log";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"ip_log";s:4:"KEYS";a:4:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:10:"ip_address";a:2:{i:0;s:5:"INDEX";i:1;s:10:"ip_address";}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:10:"ip_address";}}s:9:"user_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"type_id";}}}}s:24:"phpfox_user_notification";a:2:{s:7:"COLUMNS";a:2:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:17:"user_notification";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:17:"user_notification";}}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:19:"phpfox_user_privacy";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"user_privacy";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"user_value";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:12:"user_privacy";}}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:21:"phpfox_user_promotion";a:3:{s:7:"COLUMNS";a:6:{s:12:"promotion_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:13:"user_group_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:21:"upgrade_user_group_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"total_activity";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"total_day";a:4:{i:0;s:7:"VCHAR:5";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:12:"promotion_id";s:4:"KEYS";a:1:{s:13:"user_group_id";a:2:{i:0;s:5:"INDEX";i:1;s:13:"user_group_id";}}}s:18:"phpfox_user_rating";a:3:{s:7:"COLUMNS";a:5:{s:7:"rate_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"rating";a:4:{i:0;s:9:"DECIMAL:4";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"rate_id";s:4:"KEYS";a:2:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}s:9:"item_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"item_id";}}}s:19:"phpfox_user_setting";a:2:{s:7:"COLUMNS";a:3:{s:13:"user_group_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"setting_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"value_actual";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:13:"user_group_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:13:"user_group_id";i:1;s:10:"setting_id";}}}}s:17:"phpfox_user_snoop";a:2:{s:7:"COLUMNS";a:3:{s:10:"time_stamp";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"logging_in_as";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:17:"phpfox_user_space";a:2:{s:7:"COLUMNS";a:13:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:16:"space_attachment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"space_photo";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"space_poll";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"space_quiz";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:17:"space_marketplace";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"space_event";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"space_group";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"space_music";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:17:"space_music_image";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"space_video";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"space_pages";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"space_total";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}}}s:17:"phpfox_user_track";a:2:{s:7:"COLUMNS";a:3:{s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}}}s:18:"phpfox_user_verify";a:2:{s:7:"COLUMNS";a:4:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"hash_code";a:4:{i:0;s:8:"VCHAR:52";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:6:"UINT:9";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"email";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:7:"user_id";}s:24:"phpfox_user_verify_error";a:2:{s:7:"COLUMNS";a:5:{s:8:"error_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"hash_code";a:4:{i:0;s:7:"CHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"email";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:6:"UINT:9";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"error_id";}s:18:"phpfox_user_status";a:3:{s:7:"COLUMNS";a:10:{s:9:"status_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"content";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"location_latlng";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"location_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:9:"status_id";s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:19:"phpfox_upload_track";a:2:{s:7:"COLUMNS";a:5:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:4:"hash";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"user_hash";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:33:"phpfox_user_custom_multiple_value";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"field_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"option_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:8:"field_id";}}}}s:23:"phpfox_user_custom_data";a:2:{s:7:"COLUMNS";a:4:{s:8:"field_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"user_id";}s:21:"phpfox_point_purchase";a:2:{s:7:"COLUMNS";a:7:{s:11:"purchase_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"currency_id";a:4:{i:0;s:6:"CHAR:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"price";a:4:{i:0;s:10:"DECIMAL:14";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"status";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_point";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"purchase_id";}s:16:"phpfox_user_spam";a:2:{s:7:"COLUMNS";a:6:{s:11:"question_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:15:"question_phrase";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"answers_phrases";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"image_path";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"case_sensitive";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"question_id";}}]]></tables>
	<install><![CDATA[
		$aRows = array(
			array(
				'user_group_id' => '1',
				'title' => 'Administrator',
				'is_special' => '1'
			),
			array(
				'user_group_id' => '2',
				'title' => 'Registered User',
				'is_special' => '1'
			),
			array(
				'user_group_id' => '3',
				'title' => 'Guest',
				'is_special' => '1'
			),
			array(
				'user_group_id' => '4',
				'title' => 'Staff',
				'is_special' => '1'
			)
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('user_group'), $aInsert);
		}		
		
		$iUserGroupId = Phpfox::getService('user.group.process')->add(array(
				'title' => 'Banned',
				'inherit_id' => 2
			)
		);	
		
		$this->database()->update(Phpfox::getT('setting'), array('value_actual' => $iUserGroupId), 'module_id = \'core\' AND var_name = \'banned_user_group_id\'');
		$this->database()->update(Phpfox::getT('user_group_custom'), array('default_value' => '1'), 'user_group_id = ' . (int) $iUserGroupId . ' AND module_id = \'core\' AND name = \'user_is_banned\'');			
	]]></install>
</module>