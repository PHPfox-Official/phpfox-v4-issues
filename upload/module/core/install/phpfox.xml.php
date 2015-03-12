<module>
	<data>
		<module_id>core</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name />
		<writable><![CDATA[a:8:{i:0;s:11:"file/cache/";i:1;s:10:"file/gzip/";i:2;s:9:"file/log/";i:3;s:12:"file/static/";i:4;s:13:"file/session/";i:5;s:19:"file/pic/watermark/";i:6;s:14:"file/pic/icon/";i:7;s:31:"include/setting/server.sett.php";}]]></writable>
	</data>
	<menus>
		<menu module_id="core" parent_var_name="" m_connection="main" var_name="menu_home" ordering="2" url_value="" version_id="2.0.0alpha1" disallow_access="" module="core" />
		<menu module_id="core" parent_var_name="" m_connection="main_right" var_name="menu_admincp" ordering="1" url_value="admincp" version_id="2.0.0alpha1" disallow_access="" module="core" />
		<menu module_id="core" parent_var_name="" m_connection="footer" var_name="menu_about" ordering="17" url_value="about" version_id="2.0.0alpha1" disallow_access="" module="core" />
		<menu module_id="core" parent_var_name="" m_connection="footer" var_name="menu_privacy" ordering="18" url_value="policy" version_id="2.0.0alpha1" disallow_access="" module="core" />
		<menu module_id="core" parent_var_name="" m_connection="" var_name="menu_log_out" ordering="10" url_value="user.logout" version_id="2.0.0alpha1" disallow_access="a:1:{i:0;s:1:&quot;3&quot;;}" module="core" />
		<menu module_id="core" parent_var_name="" m_connection="friend.index" var_name="menu_core_create_a_list_a441eadc1389cdf0ffe6c4f8babdd66e" ordering="101" url_value="#friend-add-list" version_id="3.0.0beta1" disallow_access="" module="core" />
	</menus>
	<setting_groups>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_cookie">cookie</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_development">development</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_content_formatting">formatting</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_archive_handler">archive_handler</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_cron">cron</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_admin_control_panel">admin_control_panel</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_general">general</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_time_stamps">time_stamps</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_server_settings">server_settings</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_forms">group_forms</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_mail">mail</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_ftp">ftp</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_cache">cache</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_search_engine_optimization">search_engine_optimization</name>
		<name module_id="core" version_id="2.0.0alpha1" var_name="setting_group_debug">debug</name>
		<name module_id="core" version_id="2.0.0beta4" var_name="setting_group_spam">spam</name>
		<name module_id="core" version_id="2.0.0beta4" var_name="setting_group_site_offlineonline">site_offline_online</name>
		<name module_id="core" version_id="2.0.0beta4" var_name="setting_group_site_statistics">site_statistics</name>
		<name module_id="core" version_id="2.0.0rc1" var_name="setting_group_image_processing">image_processing</name>
		<name module_id="core" version_id="2.0.0rc1" var_name="setting_group_registration">registration</name>
		<name module_id="core" version_id="2.0.5" var_name="setting_group_currency">currency</name>
		<name module_id="core" version_id="2.0.5" var_name="setting_group_cdn_content_delivery_network">cdn_content_delivery_network</name>
		<name module_id="core" version_id="2.0.7" var_name="setting_group_ip_infodb">ip_infodb</name>
		<name module_id="core" version_id="3.6.0rc1" var_name="setting_group_security">security</name>
	</setting_groups>
	<settings>
		<setting group="server_settings" module_id="core" is_hidden="0" type="boolean" var_name="use_gzip" phrase_var_name="setting_use_gzip" ordering="3" version_id="2.0.0alpha1">1</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="integer" var_name="gzip_level" phrase_var_name="setting_gzip_level" ordering="4" version_id="2.0.0alpha1">1</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="string" var_name="global_update_time" phrase_var_name="setting_global_update_time" ordering="1" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="general" module_id="core" is_hidden="0" type="string" var_name="title_delim" phrase_var_name="setting_title_delim" ordering="4" version_id="2.0.0alpha1"><![CDATA[&raquo;]]></setting>
		<setting group="general" module_id="core" is_hidden="0" type="string" var_name="site_title" phrase_var_name="setting_site_title" ordering="1" version_id="2.0.0alpha1">SiteName</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="integer" var_name="ip_check" phrase_var_name="setting_ip_check" ordering="5" version_id="2.0.0alpha1">1</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="string" var_name="profile_time_stamps" phrase_var_name="setting_profile_time_stamps" ordering="8" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="cookie" module_id="core" is_hidden="0" type="string" var_name="session_prefix" phrase_var_name="setting_session_prefix" ordering="0" version_id="2.0.0alpha1">core</setting>
		<setting group="general" module_id="core" is_hidden="0" type="large_string" var_name="keywords" phrase_var_name="setting_keywords" ordering="5" version_id="2.0.0alpha1">social networking</setting>
		<setting group="general" module_id="core" is_hidden="0" type="large_string" var_name="description" phrase_var_name="setting_description" ordering="6" version_id="2.0.0alpha1">Some information about your site...</setting>
		<setting group="development" module_id="core" is_hidden="0" type="boolean" var_name="log_missing_images" phrase_var_name="setting_log_missing_images" ordering="0" version_id="2.0.0alpha1">0</setting>
		<setting group="cookie" module_id="core" is_hidden="0" type="string" var_name="cookie_path" phrase_var_name="setting_cookie_path" ordering="0" version_id="2.0.0alpha1">/</setting>
		<setting group="cookie" module_id="core" is_hidden="0" type="string" var_name="cookie_domain" phrase_var_name="setting_cookie_domain" ordering="0" version_id="2.0.0alpha1" />
		<setting group="formatting" module_id="core" is_hidden="0" type="drop" var_name="wysiwyg" phrase_var_name="setting_wysiwyg" ordering="0" version_id="2.0.0alpha1"><![CDATA[a:2:{s:7:"default";s:7:"default";s:6:"values";a:3:{i:0;s:7:"default";i:1;s:7:"tinymce";i:2;s:9:"fckeditor";}}]]></setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="boolean" var_name="allow_html" phrase_var_name="setting_allow_html" ordering="0" version_id="2.0.0alpha1">1</setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="large_string" var_name="allowed_html" phrase_var_name="setting_allowed_html" ordering="0" version_id="2.0.0alpha1"><![CDATA[<p><br><br /><strong><em><u><ul><li><font><ol><img><div><span><blockquote><strike><sub><sup><h1><h2><h3><h4><h5><h6><a><b><i><hr><tt><s><center><big><abbr><pre><small><object><embed><param><code>]]></setting>
		<setting group="archive_handler" module_id="core" is_hidden="0" type="string" var_name="unzip_path" phrase_var_name="setting_unzip_path" ordering="0" version_id="2.0.0alpha1">/usr/bin/unzip</setting>
		<setting group="cron" module_id="core" is_hidden="0" type="boolean" var_name="cron" phrase_var_name="setting_cron" ordering="0" version_id="2.0.0alpha1">1</setting>
		<setting group="archive_handler" module_id="core" is_hidden="0" type="string" var_name="tar_path" phrase_var_name="setting_tar_path" ordering="0" version_id="2.0.0alpha1">/bin/tar</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="drop" var_name="csrf_protection_level" phrase_var_name="setting_csrf_protection_level" ordering="4" version_id="2.0.0alpha1"><![CDATA[a:2:{s:7:"default";s:6:"medium";s:6:"values";a:3:{i:0;s:6:"medium";i:1;s:4:"high";i:2;s:3:"low";}}]]></setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="boolean" var_name="build_file_dir" phrase_var_name="setting_build_file_dir" ordering="5" version_id="2.0.0alpha1">1</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="string" var_name="build_format" phrase_var_name="setting_build_format" ordering="6" version_id="2.0.0alpha1">Y/m</setting>
		<setting group="archive_handler" module_id="core" is_hidden="0" type="string" var_name="zip_path" phrase_var_name="setting_zip_path" ordering="1" version_id="2.0.0alpha1">/usr/bin/zip</setting>
		<setting group="general" module_id="core" is_hidden="0" type="string" var_name="site_copyright" phrase_var_name="setting_site_copyright" ordering="3" version_id="2.0.0alpha1"><![CDATA[SiteName &copy;]]></setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="string" var_name="default_time_zone_offset" phrase_var_name="setting_default_time_zone_offset" ordering="0" version_id="2.0.0alpha1">0</setting>
		<setting group="mail" module_id="core" is_hidden="0" type="drop" var_name="method" phrase_var_name="setting_method" ordering="1" version_id="2.0.0alpha1"><![CDATA[a:2:{s:7:"default";s:4:"mail";s:6:"values";a:2:{i:0;s:4:"mail";i:1;s:4:"smtp";}}]]></setting>
		<setting group="mail" module_id="core" is_hidden="0" type="string" var_name="mailsmtphost" phrase_var_name="setting_mailsmtphost" ordering="5" version_id="2.0.0alpha1" />
		<setting group="mail" module_id="core" is_hidden="0" type="boolean" var_name="mail_smtp_authentication" phrase_var_name="setting_mail_smtp_authentication" ordering="6" version_id="2.0.0alpha1">0</setting>
		<setting group="mail" module_id="core" is_hidden="0" type="string" var_name="mail_smtp_username" phrase_var_name="setting_mail_smtp_username" ordering="7" version_id="2.0.0alpha1" />
		<setting group="mail" module_id="core" is_hidden="0" type="string" var_name="mail_smtp_password" phrase_var_name="setting_mail_smtp_password" ordering="8" version_id="2.0.0alpha1" />
		<setting group="mail" module_id="core" is_hidden="0" type="string" var_name="mail_from_name" phrase_var_name="setting_mail_from_name" ordering="2" version_id="2.0.0alpha1">null</setting>
		<setting group="mail" module_id="core" is_hidden="0" type="string" var_name="email_from_email" phrase_var_name="setting_email_from_email" ordering="3" version_id="2.0.0alpha1" />
		<setting group="mail" module_id="core" is_hidden="0" type="large_string" var_name="mail_signature" phrase_var_name="setting_mail_signature" ordering="4" version_id="2.0.0alpha1">Kind Regards,
Site Name</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="boolean" var_name="log_site_activity" phrase_var_name="setting_log_site_activity" ordering="7" version_id="2.0.0alpha1">0</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="boolean" var_name="cache_js_css" phrase_var_name="setting_cache_js_css" ordering="8" version_id="2.0.0alpha1">0</setting>
		<setting group="development" module_id="core" is_hidden="0" type="boolean" var_name="cache_plugins" phrase_var_name="setting_cache_plugins" ordering="1" version_id="2.0.0alpha1">1</setting>
		<setting group="search_engine_optimization" module_id="core" is_hidden="0" type="integer" var_name="crop_seo_url" phrase_var_name="setting_crop_seo_url" ordering="6" version_id="2.0.0alpha1">75</setting>
		<setting group="search_engine_optimization" module_id="core" is_hidden="0" type="integer" var_name="meta_description_limit" phrase_var_name="setting_meta_description_limit" ordering="1" version_id="2.0.0alpha1">500</setting>
		<setting group="search_engine_optimization" module_id="core" is_hidden="0" type="integer" var_name="meta_keyword_limit" phrase_var_name="setting_meta_keyword_limit" ordering="2" version_id="2.0.0alpha1">900</setting>
		<setting group="search_engine_optimization" module_id="core" is_hidden="0" type="string" var_name="description_time_stamp" phrase_var_name="setting_description_time_stamp" ordering="3" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="mail" module_id="core" is_hidden="0" type="boolean" var_name="use_dnscheck" phrase_var_name="setting_use_dnscheck" ordering="8" version_id="2.0.0alpha1">0</setting>
		<setting group="debug" module_id="core" is_hidden="0" type="drop" var_name="admin_debug_mode" phrase_var_name="setting_admin_debug_mode" ordering="1" version_id="2.0.0alpha1"><![CDATA[a:2:{s:7:"default";s:7:"level_0";s:6:"values";a:4:{i:0;s:7:"level_0";i:1;s:7:"level_1";i:2;s:7:"level_2";i:3;s:7:"level_3";}}]]></setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="boolean" var_name="replace_url_with_links" phrase_var_name="setting_replace_url_with_links" ordering="1" version_id="2.0.0alpha3">0</setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="integer" var_name="shorten_parsed_url_links" phrase_var_name="setting_shorten_parsed_url_links" ordering="2" version_id="2.0.0alpha3">50</setting>
		<setting group="" module_id="core" is_hidden="0" type="string" var_name="default_music_player" phrase_var_name="setting_default_music_player" ordering="1" version_id="2.0.0beta1">flowplayer</setting>
		<setting group="site_offline_online" module_id="core" is_hidden="0" type="boolean" var_name="site_is_offline" phrase_var_name="setting_site_is_offline" ordering="1" version_id="2.0.0beta4">0</setting>
		<setting group="site_offline_online" module_id="core" is_hidden="0" type="large_string" var_name="site_offline_message" phrase_var_name="setting_site_offline_message" ordering="2" version_id="2.0.0beta4" />
		<setting group="site_offline_online" module_id="core" is_hidden="0" type="boolean" var_name="site_offline_no_template" phrase_var_name="setting_site_offline_no_template" ordering="3" version_id="2.0.0beta4">0</setting>
		<setting group="site_statistics" module_id="core" is_hidden="0" type="boolean" var_name="cache_site_stats" phrase_var_name="setting_cache_site_stats" ordering="1" version_id="2.0.0beta4">1</setting>
		<setting group="site_statistics" module_id="core" is_hidden="0" type="integer" var_name="site_stat_update_time" phrase_var_name="setting_site_stat_update_time" ordering="2" version_id="2.0.0beta4">60</setting>
		<setting group="site_statistics" module_id="core" is_hidden="0" type="boolean" var_name="display_site_stats" phrase_var_name="setting_display_site_stats" ordering="3" version_id="2.0.0beta4">1</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="boolean" var_name="identify_dst" phrase_var_name="setting_identify_dst" ordering="9" version_id="2.0.0beta5">1</setting>
		<setting group="image_processing" module_id="core" is_hidden="0" type="drop" var_name="watermark_option" phrase_var_name="setting_watermark_option" ordering="1" version_id="2.0.0rc1"><![CDATA[a:2:{s:7:"default";s:4:"none";s:6:"values";a:3:{i:0;s:4:"none";i:1;s:5:"image";i:2;s:4:"text";}}]]></setting>
		<setting group="image_processing" module_id="core" is_hidden="0" type="integer" var_name="watermark_opacity" phrase_var_name="setting_watermark_opacity" ordering="3" version_id="2.0.0rc1">100</setting>
		<setting group="image_processing" module_id="core" is_hidden="0" type="drop" var_name="watermark_image_position" phrase_var_name="setting_watermark_image_position" ordering="4" version_id="2.0.0rc1"><![CDATA[a:2:{s:7:"default";s:12:"bottom_right";s:6:"values";a:4:{i:0;s:12:"bottom_right";i:1;s:11:"bottom_left";i:2;s:8:"top_left";i:3;s:9:"top_right";}}]]></setting>
		<setting group="image_processing" module_id="core" is_hidden="0" type="string" var_name="image_text" phrase_var_name="setting_image_text" ordering="6" version_id="2.0.0rc1">www.yoursite.com</setting>
		<setting group="registration" module_id="core" is_hidden="0" type="boolean" var_name="registration_enable_dob" phrase_var_name="setting_registration_enable_dob" ordering="13" version_id="2.0.0rc1">1</setting>
		<setting group="registration" module_id="core" is_hidden="0" type="boolean" var_name="registration_enable_gender" phrase_var_name="setting_registration_enable_gender" ordering="14" version_id="2.0.0rc1">1</setting>
		<setting group="registration" module_id="core" is_hidden="0" type="boolean" var_name="registration_enable_location" phrase_var_name="setting_registration_enable_location" ordering="15" version_id="2.0.0rc1">0</setting>
		<setting group="registration" module_id="core" is_hidden="0" type="boolean" var_name="registration_enable_timezone" phrase_var_name="setting_registration_enable_timezone" ordering="16" version_id="2.0.0rc1">0</setting>
		<setting group="spam" module_id="core" is_hidden="0" type="boolean" var_name="enable_spam_check" phrase_var_name="setting_enable_spam_check" ordering="3" version_id="2.0.0rc1">0</setting>
		<setting group="spam" module_id="core" is_hidden="0" type="string" var_name="akismet_url" phrase_var_name="setting_akismet_url" ordering="1" version_id="2.0.0rc1" />
		<setting group="spam" module_id="core" is_hidden="0" type="string" var_name="akismet_password" phrase_var_name="setting_akismet_password" ordering="2" version_id="2.0.0rc1" />
		<setting group="spam" module_id="core" is_hidden="0" type="integer" var_name="auto_deny_items" phrase_var_name="setting_auto_deny_items" ordering="11" version_id="2.0.0rc1">10</setting>
		<setting group="spam" module_id="core" is_hidden="0" type="integer" var_name="auto_ban_spammer" phrase_var_name="setting_auto_ban_spammer" ordering="15" version_id="2.0.0rc1">0</setting>
		<setting group="spam" module_id="core" is_hidden="0" type="boolean" var_name="warn_on_external_links" phrase_var_name="setting_warn_on_external_links" ordering="4" version_id="2.0.0rc1">0</setting>
		<setting group="spam" module_id="core" is_hidden="0" type="boolean" var_name="disable_all_external_urls" phrase_var_name="setting_disable_all_external_urls" ordering="16" version_id="2.0.0rc1">0</setting>
		<setting group="spam" module_id="core" is_hidden="0" type="large_string" var_name="url_spam_white_list" phrase_var_name="setting_url_spam_white_list" ordering="17" version_id="2.0.0rc1">*.yahoo.com, *.google.*</setting>
		<setting group="spam" module_id="core" is_hidden="0" type="boolean" var_name="disable_all_external_emails" phrase_var_name="setting_disable_all_external_emails" ordering="18" version_id="2.0.0rc1">0</setting>
		<setting group="spam" module_id="core" is_hidden="0" type="large_string" var_name="email_white_list" phrase_var_name="setting_email_white_list" ordering="19" version_id="2.0.0rc1">*@yahoo.com, *@google.com</setting>
		<setting group="" module_id="core" is_hidden="0" type="boolean" var_name="redirect_guest_on_same_page" phrase_var_name="setting_redirect_guest_on_same_page" ordering="1" version_id="2.0.0rc1">1</setting>
		<setting group="general" module_id="core" is_hidden="0" type="large_string" var_name="meta_description_profile" phrase_var_name="setting_meta_description_profile" ordering="8" version_id="2.0.0rc1">Site Name gives people the power to share and makes the world more open and connected.</setting>
		<setting group="search_engine_optimization" module_id="core" is_hidden="0" type="large_string" var_name="words_remove_in_keywords" phrase_var_name="setting_words_remove_in_keywords" ordering="4" version_id="2.0.0rc1">and, i, in</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="boolean" var_name="enable_getid3_check" phrase_var_name="setting_enable_getid3_check" ordering="9" version_id="2.0.0rc2">0</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="string" var_name="extended_global_time_stamp" phrase_var_name="setting_extended_global_time_stamp" ordering="10" version_id="2.0.0rc2">M j, g:i a</setting>
		<setting group="" module_id="core" is_hidden="0" type="boolean" var_name="can_move_on_a_y_and_x_axis" phrase_var_name="setting_can_move_on_a_y_and_x_axis" ordering="1" version_id="2.0.0rc4">0</setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="boolean" var_name="resize_images" phrase_var_name="setting_resize_images" ordering="3" version_id="2.0.0rc4">0</setting>
		<setting group="mail" module_id="core" is_hidden="0" type="integer" var_name="mail_smtp_port" phrase_var_name="setting_mail_smtp_port" ordering="9" version_id="2.0.0rc9">25</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="string" var_name="conver_time_to_string" phrase_var_name="setting_conver_time_to_string" ordering="11" version_id="2.0.0rc10">g:i a</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="string" var_name="global_welcome_time_stamp" phrase_var_name="setting_global_welcome_time_stamp" ordering="12" version_id="2.0.0rc10">l, F j, Y g:i A</setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="boolean" var_name="resize_embed_video" phrase_var_name="setting_resize_embed_video" ordering="4" version_id="2.0.0rc11">0</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="string" var_name="footer_watch_time_stamp" phrase_var_name="setting_footer_watch_time_stamp" ordering="13" version_id="2.0.0rc12">g:i A</setting>
		<setting group="" module_id="core" is_hidden="0" type="integer" var_name="categories_to_show_at_first" phrase_var_name="setting_categories_to_show_at_first" ordering="1" version_id="2.0.0rc12">5</setting>
		<setting group="general" module_id="core" is_hidden="0" type="string" var_name="global_site_title" phrase_var_name="setting_global_site_title" ordering="2" version_id="2.0.0">Social Networking Community</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="string" var_name="footer_bar_tool_tip_time_stamp" phrase_var_name="setting_footer_bar_tool_tip_time_stamp" ordering="14" version_id="2.0.2">l, F j, Y g:i A</setting>
		<setting group="currency" module_id="core" is_hidden="0" type="string" var_name="exchange_rate_api_key" phrase_var_name="setting_exchange_rate_api_key" ordering="1" version_id="2.0.5" />
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="amazon_access_key" phrase_var_name="setting_amazon_access_key" ordering="2" version_id="2.0.5" />
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="amazon_secret_key" phrase_var_name="setting_amazon_secret_key" ordering="3" version_id="2.0.5" />
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="amazon_bucket" phrase_var_name="setting_amazon_bucket" ordering="4" version_id="2.0.5" />
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="boolean" var_name="amazon_bucket_created" phrase_var_name="setting_amazon_bucket_created" ordering="5" version_id="2.0.5">0</setting>
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="boolean" var_name="allow_cdn" phrase_var_name="setting_allow_cdn" ordering="1" version_id="2.0.5">0</setting>
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="cdn_cname" phrase_var_name="setting_cdn_cname" ordering="6" version_id="2.0.5" />
		<setting group="server_settings" module_id="core" is_hidden="0" type="boolean" var_name="force_https_secure_pages" phrase_var_name="setting_force_https_secure_pages" ordering="10" version_id="2.0.5dev1">0</setting>
		<setting group="" module_id="core" is_hidden="0" type="array" var_name="global_genders" phrase_var_name="setting_global_genders" ordering="1" version_id="2.0.5dev2"><![CDATA[s:112:"array(
  0 => '1|core.his|profile.male|core.himself',
  1 => '2|core.her|profile.female|core.herself|female',
);";]]></setting>
		<setting group="ip_infodb" module_id="core" is_hidden="0" type="string" var_name="ip_infodb_api_key" phrase_var_name="setting_ip_infodb_api_key" ordering="1" version_id="2.0.7" />
		<setting group="general" module_id="core" is_hidden="0" type="boolean" var_name="friends_only_community" phrase_var_name="setting_friends_only_community" ordering="10" version_id="2.1.0Beta1">0</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="boolean" var_name="site_wide_ajax_browsing" phrase_var_name="setting_site_wide_ajax_browsing" ordering="1" version_id="2.1.0Beta1">0</setting>
		<setting group="general" module_id="core" is_hidden="0" type="boolean" var_name="section_privacy_item_browsing" phrase_var_name="setting_section_privacy_item_browsing" ordering="9" version_id="3.0.0Beta1">0</setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="drop" var_name="date_field_order" phrase_var_name="setting_date_field_order" ordering="15" version_id="3.0.0Beta1"><![CDATA[a:2:{s:7:"default";s:3:"MDY";s:6:"values";a:3:{i:0;s:3:"MDY";i:1;s:3:"DMY";i:2;s:3:"YMD";}}]]></setting>
		<setting group="time_stamps" module_id="core" is_hidden="0" type="boolean" var_name="use_jquery_datepicker" phrase_var_name="setting_use_jquery_datepicker" ordering="16" version_id="3.0.0Beta1">1</setting>
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="boolean" var_name="cdn_amazon_https" phrase_var_name="setting_cdn_amazon_https" ordering="7" version_id="2.1.0beta2">0</setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="boolean" var_name="allow_html_in_activity_feed" phrase_var_name="setting_allow_html_in_activity_feed" ordering="6" version_id="3.0.0beta3">0</setting>
		<setting group="server_settings" module_id="core" is_hidden="0" type="boolean" var_name="disable_hash_bang_support" phrase_var_name="setting_disable_hash_bang_support" ordering="14" version_id="3.0.0beta3">0</setting>
		<setting group="general" module_id="core" is_hidden="0" type="boolean" var_name="display_older_ie_error" phrase_var_name="setting_display_older_ie_error" ordering="15" version_id="3.0.0rc1">1</setting>
		<setting group="general" module_id="core" is_hidden="0" type="boolean" var_name="disable_ie_warning" phrase_var_name="setting_disable_ie_warning" ordering="16" version_id="3.0.1">0</setting>
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="cdn_service" phrase_var_name="setting_cdn_service" ordering="8" version_id="3.1.0beta1" />
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="boolean" var_name="enable_amazon_expire_urls" phrase_var_name="setting_enable_amazon_expire_urls" ordering="9" version_id="3.1.0rc1">0</setting>
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="integer" var_name="amazon_s3_expire_url_timeout" phrase_var_name="setting_amazon_s3_expire_url_timeout" ordering="10" version_id="3.1.0rc1">60</setting>
		<setting group="general" module_id="core" is_hidden="0" type="string" var_name="official_launch_of_site" phrase_var_name="setting_official_launch_of_site" ordering="17" version_id="3.2.0beta1">1/1/2012</setting>
		<setting group="search_engine_optimization" module_id="core" is_hidden="0" type="boolean" var_name="no_follow_on_external_links" phrase_var_name="setting_no_follow_on_external_links" ordering="7" version_id="3.3.0beta1">0</setting>
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="rackspace_username" phrase_var_name="setting_rackspace_username" ordering="11" version_id="3.3.0beta1" />
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="rackspace_key" phrase_var_name="setting_rackspace_key" ordering="12" version_id="3.3.0beta1" />
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="rackspace_container" phrase_var_name="setting_rackspace_container" ordering="13" version_id="3.3.0beta1" />
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="string" var_name="rackspace_url" phrase_var_name="setting_rackspace_url" ordering="14" version_id="3.3.0beta1" />
		<setting group="" module_id="core" is_hidden="0" type="boolean" var_name="keep_files_in_server" phrase_var_name="setting_keep_files_in_server" ordering="15" version_id="3.5.0beta1">0</setting>
		<setting group="" module_id="core" is_hidden="0" type="string" var_name="google_api_key" phrase_var_name="setting_google_api_key" ordering="1" version_id="3.5.0beta1" />
		<setting group="formatting" module_id="core" is_hidden="0" type="integer" var_name="activity_feed_line_breaks" phrase_var_name="setting_activity_feed_line_breaks" ordering="7" version_id="3.5.0">0</setting>
		<setting group="cache" module_id="core" is_hidden="0" type="boolean" var_name="defer_loading_user_images" phrase_var_name="setting_defer_loading_user_images" ordering="1" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="core" is_hidden="0" type="boolean" var_name="defer_loading_images" phrase_var_name="setting_defer_loading_images" ordering="2" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="core" is_hidden="0" type="boolean" var_name="keep_non_square_images" phrase_var_name="setting_keep_non_square_images" ordering="3" version_id="3.6.0rc1">1</setting>
		<setting group="cache" module_id="core" is_hidden="0" type="array" var_name="controllers_to_load_delayed" phrase_var_name="setting_controllers_to_load_delayed" ordering="4" version_id="3.6.0rc1"><![CDATA[s:8:"array();";]]></setting>
		<setting group="cache" module_id="core" is_hidden="0" type="boolean" var_name="super_cache_system" phrase_var_name="setting_super_cache_system" ordering="5" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="core" is_hidden="0" type="boolean" var_name="store_only_users_in_session" phrase_var_name="setting_store_only_users_in_session" ordering="6" version_id="3.6.0rc1">0</setting>
		<setting group="cdn_content_delivery_network" module_id="core" is_hidden="0" type="boolean" var_name="push_jscss_to_cdn" phrase_var_name="setting_push_jscss_to_cdn" ordering="16" version_id="3.6.0rc1">0</setting>
		<setting group="search_engine_optimization" module_id="core" is_hidden="0" type="boolean" var_name="include_site_title_all_pages" phrase_var_name="setting_include_site_title_all_pages" ordering="8" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="core" is_hidden="0" type="boolean" var_name="force_404_check" phrase_var_name="setting_force_404_check" ordering="7" version_id="3.6.0rc1">0</setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="boolean" var_name="enable_html_purifier" phrase_var_name="setting_enable_html_purifier" ordering="8" version_id="3.6.0rc1">1</setting>
		<setting group="security" module_id="core" is_hidden="0" type="boolean" var_name="force_secure_site" phrase_var_name="setting_force_secure_site" ordering="1" version_id="3.6.0rc1">0</setting>
		<setting group="security" module_id="core" is_hidden="0" type="boolean" var_name="use_custom_cookie_names" phrase_var_name="setting_use_custom_cookie_names" ordering="2" version_id="3.6.0rc1">0</setting>
		<setting group="security" module_id="core" is_hidden="0" type="string" var_name="custom_cookie_names_hash" phrase_var_name="setting_custom_cookie_names_hash" ordering="3" version_id="3.6.0rc1">s6ks763s5h3)s</setting>
		<setting group="security" module_id="core" is_hidden="0" type="string" var_name="protect_admincp_with_ips" phrase_var_name="setting_protect_admincp_with_ips" ordering="4" version_id="3.6.0rc1" />
		<setting group="security" module_id="core" is_hidden="0" type="boolean" var_name="auth_user_via_session" phrase_var_name="setting_auth_user_via_session" ordering="5" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="core" is_hidden="0" type="boolean" var_name="include_ip_sub_id_hash" phrase_var_name="setting_include_ip_sub_id_hash" ordering="8" version_id="3.6.0rc1">0</setting>
		<setting group="security" module_id="core" is_hidden="0" type="string" var_name="id_hash_salt" phrase_var_name="setting_id_hash_salt" ordering="6" version_id="3.6.0rc1">iysduyt623rts</setting>
		<setting group="security" module_id="core" is_hidden="0" type="boolean" var_name="check_body_for_text" phrase_var_name="setting_check_body_for_text" ordering="7" version_id="3.6.0rc1">0</setting>
		<setting group="security" module_id="core" is_hidden="0" type="string" var_name="check_body_regex" phrase_var_name="setting_check_body_regex" ordering="8" version_id="3.6.0rc1">/oParams/i</setting>
		<setting group="security" module_id="core" is_hidden="0" type="string" var_name="check_body_offline_message" phrase_var_name="setting_check_body_offline_message" ordering="9" version_id="3.6.0rc1">Site is under maintenance.</setting>
		<setting group="security" module_id="core" is_hidden="0" type="string" var_name="check_body_header" phrase_var_name="setting_check_body_header" ordering="10" version_id="3.6.0rc1">HTTP/1.0 500 Internal Server Error</setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="large_string" var_name="html_purifier_allowed_html" phrase_var_name="setting_html_purifier_allowed_html" ordering="9" version_id="3.6.0rc1"><![CDATA[br,p,i,em,u,ul,li,font,ol,div[class|style],span[id|class|style],blockquote,strike,b,strong,img[src|alt|class|height|width],a[class|href|rel|target],iframe[src|width|height|frameborder],object[width|height|data],param[name|value],embed[src|type|allowscriptaccess|allowfullscreen|width|height]]]></setting>
		<setting group="formatting" module_id="core" is_hidden="0" type="large_string" var_name="html_purifier_allowed_iframes" phrase_var_name="setting_html_purifier_allowed_iframes" ordering="10" version_id="3.6.0rc1">%^http://(www.youtube.com/embed/|player.vimeo.com/video/)%</setting>
		<setting group="registration" module_id="core" is_hidden="0" type="boolean" var_name="city_in_registration" phrase_var_name="setting_city_in_registration" ordering="17" version_id="3.7.0beta1">0</setting>
		<setting group="image_processing" module_id="core" is_hidden="0" type="string" var_name="watermark_image" phrase_var_name="setting_watermark_image" ordering="2" version_id="2.0.0rc1">watermark%s.png</setting>
		<setting group="formatting" module_id="core" is_hidden="1" type="boolean" var_name="xhtml_valid" phrase_var_name="setting_xhtml_valid" ordering="0" version_id="2.0.0alpha1">0</setting>
		<setting group="ftp" module_id="core" is_hidden="1" type="string" var_name="ftp_host" phrase_var_name="setting_host" ordering="2" version_id="2.0.0alpha1" />
		<setting group="ftp" module_id="core" is_hidden="1" type="string" var_name="ftp_username" phrase_var_name="setting_username" ordering="3" version_id="2.0.0alpha1" />
		<setting group="ftp" module_id="core" is_hidden="1" type="password" var_name="ftp_password" phrase_var_name="setting_password" ordering="4" version_id="2.0.0alpha1" />
		<setting group="ftp" module_id="core" is_hidden="1" type="boolean" var_name="ftp_enabled" phrase_var_name="setting_ftp_enabled" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="ftp" module_id="core" is_hidden="1" type="string" var_name="ftp_dir_path" phrase_var_name="setting_ftp_dir_path" ordering="5" version_id="2.0.0rc1" />
		<setting group="" module_id="core" is_hidden="1" type="integer" var_name="banned_user_group_id" phrase_var_name="setting_banned_user_group_id" ordering="1" version_id="2.0.0rc1">0</setting>
		<setting group="image_processing" module_id="core" is_hidden="1" type="string" var_name="image_text_hex" phrase_var_name="setting_image_text_hex" ordering="5" version_id="2.0.0rc1">000000</setting>
		<setting group="server_settings" module_id="core" is_hidden="1" type="boolean" var_name="include_master_files" phrase_var_name="setting_include_master_files" ordering="15" version_id="3.6.0rc1">0</setting>
		<setting group="" module_id="core" is_hidden="1" type="boolean" var_name="use_md5_for_file_names" phrase_var_name="setting_use_md5_for_file_names" ordering="1" version_id="3.2.0rc1">1</setting>
		<setting group="formatting" module_id="core" is_hidden="1" type="boolean" var_name="enabled_edit_area" phrase_var_name="setting_enabled_edit_area" ordering="5" version_id="2.0.7">0</setting>
		<setting group="server_settings" module_id="core" is_hidden="1" type="boolean" var_name="load_jquery_from_google_cdn" phrase_var_name="setting_load_jquery_from_google_cdn" ordering="11" version_id="2.1.0Beta1">0</setting>
		<setting group="server_settings" module_id="core" is_hidden="1" type="string" var_name="jquery_google_cdn_version" phrase_var_name="setting_jquery_google_cdn_version" ordering="12" version_id="2.1.0Beta1">1.4.4</setting>
		<setting group="server_settings" module_id="core" is_hidden="1" type="string" var_name="jquery_ui_google_cdn_version" phrase_var_name="setting_jquery_ui_google_cdn_version" ordering="13" version_id="2.1.0Beta1">1.8.7</setting>
		<setting group="general" module_id="core" is_hidden="1" type="boolean" var_name="display_required" phrase_var_name="setting_display_required" ordering="12" version_id="2.0.0alpha1">1</setting>
		<setting group="general" module_id="core" is_hidden="1" type="string" var_name="required_symbol" phrase_var_name="setting_required_symbol" ordering="14" version_id="2.0.0alpha1"><![CDATA[&#42;]]></setting>
		<setting group="general" module_id="core" is_hidden="1" type="boolean" var_name="enable_footer_bar" phrase_var_name="setting_enable_footer_bar" ordering="9" version_id="2.0.0beta3">1</setting>
		<setting group="general" module_id="core" is_hidden="1" type="boolean" var_name="no_more_ie6" phrase_var_name="setting_no_more_ie6" ordering="11" version_id="2.0.0rc11">0</setting>
		<setting group="general" module_id="core" is_hidden="1" type="string" var_name="footer_bar_site_name" phrase_var_name="setting_footer_bar_site_name" ordering="5" version_id="2.0.0beta3">Site Name</setting>
		<setting group="general" module_id="core" is_hidden="1" type="drop" var_name="item_view_area" phrase_var_name="setting_item_view_area" ordering="1" version_id="2.0.0rc1"><![CDATA[a:2:{s:7:"default";s:6:"public";s:6:"values";a:2:{i:0;s:6:"public";i:1;s:8:" profile";}}]]></setting>
		<setting group="general" module_id="core" is_hidden="1" type="boolean" var_name="is_personal_site" phrase_var_name="setting_is_personal_site" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="core" is_hidden="1" type="boolean" var_name="branding" phrase_var_name="setting_branding" ordering="0" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="default_lang_id" phrase_var_name="setting_default_lang_id" ordering="0" version_id="2.0.0alpha1">en</setting>
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="default_theme_name" phrase_var_name="setting_default_theme_name" ordering="0" version_id="2.0.0alpha1">default</setting>
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="default_style_name" phrase_var_name="setting_default_style_name" ordering="0" version_id="2.0.0alpha1">default</setting>
		<setting group="" module_id="core" is_hidden="1" type="integer" var_name="default_style_id" phrase_var_name="setting_default_style_id" ordering="0" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="module_forum" phrase_var_name="setting_module_forum" ordering="0" version_id="2.0.0alpha1">forum</setting>
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="module_core" phrase_var_name="setting_module_core" ordering="0" version_id="2.0.0alpha1">core</setting>
		<setting group="" module_id="core" is_hidden="1" type="large_string" var_name="global_admincp_note" phrase_var_name="setting_global_admincp_note" ordering="1" version_id="2.0.0rc1">Save your notes here...</setting>
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="phpfox_version" phrase_var_name="setting_phpfox_version" ordering="1" version_id="2.0.0rc1">2.0.0rc2</setting>
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="theme_session_prefix" phrase_var_name="setting_theme_session_prefix" ordering="1" version_id="2.0.0rc3">486256453</setting>
		<setting group="" module_id="core" is_hidden="1" type="integer" var_name="css_edit_id" phrase_var_name="setting_css_edit_id" ordering="1" version_id="2.0.2">1</setting>
		<setting group="" module_id="core" is_hidden="1" type="integer" var_name="phpfox_total_users_online_mark" phrase_var_name="setting_phpfox_total_users_online_mark" ordering="1" version_id="2.0.7" />
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="phpfox_total_users_online_history" phrase_var_name="setting_phpfox_total_users_online_history" ordering="1" version_id="2.0.7" />
		<setting group="" module_id="core" is_hidden="1" type="boolean" var_name="phpfox_is_hosted" phrase_var_name="setting_phpfox_is_hosted" ordering="1" version_id="2.0.7">0</setting>
		<setting group="" module_id="core" is_hidden="1" type="string" var_name="phpfox_max_users_online" phrase_var_name="setting_phpfox_max_users_online" ordering="1" version_id="2.0.7">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="core.index-member" module_id="core" component="welcome" location="7" is_active="1" ordering="10" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="core.index-member" module_id="core" component="stat" location="1" is_active="0" ordering="4" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="admincp.index" module_id="core" component="note" location="2" is_active="1" ordering="2" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="admincp.index" module_id="core" component="active-admin" location="1" is_active="1" ordering="2" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="admincp.index" module_id="core" component="news" location="2" is_active="1" ordering="3" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="admincp.index" module_id="core" component="site-stat" location="3" is_active="1" ordering="1" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="admincp.index" module_id="core" component="latest-admin-login" location="1" is_active="1" ordering="3" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_message_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_country_country__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_country_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_preview_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_core__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="user_genders" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_getheader_language" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_getheader_setting" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_getheader" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="cron_exec" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="cron_construct" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="run" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="validator_construct" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode_construct" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="spam_methods" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="cron_start" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="cron_end" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="library" module="core" call_name="init" added="1242299671" version_id="2.0.0beta2" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_dashboard_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_footer_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_info_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_country_child_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_new_setting_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_currency_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_activity_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_block__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_callback__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_currency__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_ftp_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_site_stat_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_view_admincp_login_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_active_admin_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_twitter_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_latest_admin_login_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_note_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_news_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_quick_find_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_stat_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_country_import_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_country_index_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_country_child_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_country_child_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_country_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_phpinfo_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_branding_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_ip_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_online_guest_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_latest_admin_login_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_system_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_redirect_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_offline_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_admincp_process__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_admincp_admincp__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_country_child_process__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_stat_process__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_stat_stat__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_category_category__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_process_addGender_start" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_process_addGender_end" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_load__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_system__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_index_visitor_start" added="1259173633" version_id="2.0.0rc9" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_index_member_start" added="1259173633" version_id="2.0.0rc9" />
		<hook module_id="core" hook_type="library" module="core" call_name="locale_contruct__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_translate_child_country_clean" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_translate_country_clean" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_holder_clean" added="1261572640" version_id="2.0.0" />
		<hook module_id="core" hook_type="template" module="core" call_name="theme_template_body__end" added="1261572988" version_id="2.0.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="session_remove__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_core_getgenders__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="set_defined_controller" added="1263388996" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="run_start" added="1263388996" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="get_controller" added="1263388996" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="check_url_is_array" added="1263388996" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="request_get" added="1263388996" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_gettemplatefile" added="1263388996" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="component_pre_process" added="1263389358" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="component_post_process" added="1263389358" version_id="2.0.2" />
		<hook module_id="core" hook_type="library" module="core" call_name="set_controller_else_end" added="1264437857" version_id="2.0.3" />
		<hook module_id="core" hook_type="library" module="core" call_name="mail_send_query" added="1266260139" version_id="2.0.4" />
		<hook module_id="core" hook_type="library" module="core" call_name="mail_send_call" added="1266260139" version_id="2.0.4" />
		<hook module_id="core" hook_type="library" module="core" call_name="file_upload_start" added="1266260157" version_id="2.0.4" />
		<hook module_id="core" hook_type="library" module="core" call_name="check_url_is_array_return" added="1267629983" version_id="2.0.4" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_index_visitor_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_index_member_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="core" hook_type="library" module="core" call_name="hash_sethash__end" added="1268138234" version_id="2.0.4" />
		<hook module_id="core" hook_type="library" module="core" call_name="validator_check_routine_default" added="1271160844" version_id="2.0.5" />
		<hook module_id="core" hook_type="library" module="core" call_name="phpfox_parse_output_parse__start" added="1271160844" version_id="2.0.5" />
		<hook module_id="core" hook_type="library" module="core" call_name="editor_get" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_input_construct" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_input__removeevilattributes" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_currency__construct" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_currency_process__call" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_currency_add_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_currency_index_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="core" hook_type="library" module="core" call_name="module_getcomponent_handle_block_position" added="1276177474" version_id="2.0.5" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_parsefunction_block_end_if" added="1276177474" version_id="2.0.5" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_core_getsecurepages" added="1276177474" version_id="2.0.5" />
		<hook module_id="core" hook_type="library" module="core" call_name="ajax__construct" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="ajax_process" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="ajax_html" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="ajax_prepend" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="ajax_append" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="ajax_getcontent" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="ajax_getdata" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="ajax__ajaxsafe" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="module_setcontroller_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="module_setcontroller_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="module_getcontrollertemplate" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="get_module_blocks" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="module_getcomponent_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="module_getcomponent_gettemplate" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="image_helper_display_notfound" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_template_setbreadcrump" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_gettemplate" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="archive__construct" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="archive_export_set" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="archive_export_download" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_output_fiximagewidth" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode_preparse_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode_parse_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode_quote_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode_quote_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_currency_getcurrency" added="1286546859" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_getstaticversion" added="1290072896" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode__image" added="1290072896" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_gettitle" added="1290094336" version_id="2.0.7" />
		<hook module_id="core" hook_type="library" module="core" call_name="editor_construct" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="image_helper_display_start" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode__code1" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode__code2" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="parse_bbcode__code3" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="url_getdomain_1" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="librayr_url__send_switch" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block__clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_category_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_moderation_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_body_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_breadcrumblist_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_breadcrumbmenu_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_contentclass_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_copyright_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template-footer_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_holdername_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_logo_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_menu_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_menuaccount_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template-menufooter_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_menusub_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.component_block_template_notification_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_redirect_process__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="template" module="core" call_name="core.template_block_comment_border_new" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_admincp_stat_clean" added="1335951260" version_id="3.2.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_template_getstyle_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_template_getlayoutfile_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_template_getmenu_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_module_getmoduleblocks_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_file_file_upload_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_file_file_upload_2" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_file_file_upload_3" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_ismobile" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="component" module="core" call_name="core.template_block_template_menu_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="controller" module="core" call_name="core.component_controller_full_clean" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="core" hook_type="library" module="core" call_name="template_template_getmenu_2" added="1361180401" version_id="3.5.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_phpfox_getuserid__1" added="1361180401" version_id="3.5.0rc1" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_currency_contruct__1" added="1361532353" version_id="3.5.0" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_currency_getforedit__1" added="1361532353" version_id="3.5.0" />
		<hook module_id="core" hook_type="service" module="core" call_name="core.service_currency_getforbrowse__1" added="1361532353" version_id="3.5.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_locale_phrase_not_found" added="1361776392" version_id="3.5.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_module_getservice_1" added="1363075699" version_id="3.5.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_module_getcomponent_1" added="1363075699" version_id="3.5.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_module_getcomponent_2" added="1363075699" version_id="3.5.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_template_cache_compile__1" added="1363075699" version_id="3.5.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_template_cache_parse__1" added="1363075699" version_id="3.5.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_getlibclass_1" added="1363075699" version_id="3.5.0" />
		<hook module_id="core" hook_type="library" module="core" call_name="mail_send_call_2" added="1372757268" version_id="3.6.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="mail_send_call_3" added="1372757268" version_id="3.6.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="mail_send_call_4" added="1378372973" version_id="3.7.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="get_master_files" added="1378374384" version_id="3.7.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="get_service_1" added="1378455278" version_id="3.7.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_getlibclass_0" added="1378455278" version_id="3.7.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="library_phpfox_getlib_0" added="1378455278" version_id="3.7.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="run_get_header_file_1" added="1378455278" version_id="3.7.0rc1" />
		<hook module_id="core" hook_type="library" module="core" call_name="request_is_mobile" added="1384771085" version_id="3.7.3" />
	</hooks>
	<components>
		<component module_id="core" component="index-member" m_connection="core.index-member" module="core" is_controller="1" is_block="0" is_active="1" />
		<component module_id="core" component="index-visitor" m_connection="core.index-visitor" module="core" is_controller="1" is_block="0" is_active="1" />
		<component module_id="core" component="welcome" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="new" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="dashboard" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="stat" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="note" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="active-admin" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="news" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="twitter" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="site-stat" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="latest-admin-login" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
		<component module_id="core" component="quick-find" m_connection="" module="core" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_cookie" added="1213866358"><![CDATA[<title>Cookies</title><info>Cookie Information</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_cookie_path" added="1213869795"><![CDATA[<title>Path to Save Cookies</title><info>The path to which the cookie is saved. If you run more than one site on the same domain, it will be necessary to set this to the individual directories of your site. Otherwise, just leave it as / .

Please note that your path should always end in a forward-slash; for example '/community/', '/site/' etc.

<b>Entering an invalid setting can leave you unable to login to your site.</b></info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_cookie_domain" added="1213869928"><![CDATA[<title>Cookie Domain</title><info>This option sets the domain on which the cookie is active. The most common reason to change this setting is that you have two different urls to your site, i.e. example.com and community.example.com. To allow users to stay logged into the site if they visit via either url, you would set this to .example.com (note the domain begins with a dot.

You most likely want to leave this setting blank as entering an invalid setting can leave you unable to login to your site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_development" added="1213871855"><![CDATA[<title>Development</title><info>Sample Information</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_log_missing_images" added="1213872261"><![CDATA[<title>Log Missing Image</title><info>Find and log any missing images into a log file. This could be used during the development of a new module or plug-in. 

If you are running a live site make sure this setting is disabled.

Note the relative location of the log file is: /file/log/phpfox_missing_images.log</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_attachment_valid_images" added="1213872474"><![CDATA[<title>Create Thumbnails</title><info>Define what file extensions we should create thumbnails for when a user uploads an image attachment.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_attachment_max_thumbnail" added="1213872657"><![CDATA[<title>Thumbnail Width/Height</title><info>Define the width and height of the thumbnail that will be created after a user uploads an image. If the image uploaded is smaller then the specified width/height it will not create a thumbnail for the image.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_attachment_max_medium" added="1213872836"><![CDATA[<title>Medium Thumbnail Width/Height</title><info>Define the width and height of the medium thumbnail that will be created after a user uploads an image. If the image uploaded is smaller then the specified width/height it will not create a medium thumbnail for the image.

Note that the medium thumbnail is displayed on the website instead of the original image to save bandwidth.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_attachment_upload_bars" added="1213872933"><![CDATA[<title>Upload Inputs</title><info>Define how many upload inputs should be displayed when a user is uploading attachments for an item.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_content_formatting" added="1213873063"><![CDATA[<title>Content Formatting</title><info>Format Info</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_wysiwyg" added="1213874080"><![CDATA[<title>WYSIWYG Editor</title><info>Select a default WYSIWYG editor.

WYSIWYG (What You See Is What You Get)</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_allow_html" added="1213875281"><![CDATA[<title>Allow HTML</title><info>Set this to <b>True</b> if you would like to allow HTML on your site. Note that even with this setting enabled by default we only allow certain HTML tags we feel that will not harm your site. You can add more HTML tags by modifying the setting <b>sAllowedHtmlTags</b> which can be found in this setting group.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_allowed_html" added="1213875545"><![CDATA[<title>Allowed HTML Tags</title><info>We provide a set of HTML tags we feel will give your users the ability to format their content without harming your site. 

You are free to add more HTML tags you deem necessary. If you do add more tags note that we have taken steps to prevent injections from JavaScript for example so adding more tags should not cause a security risk, it can however alter the way your site looks.

To add more tags simply add the tag you wish either to the end or front of the provided tags.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_xhtml_valid" added="1213875737"><![CDATA[<title>XHTML Valid</title><info>Set this to <b>True</b> if you would like us to try to clean up the content being added by your users and attempt to make the site XHTML valid.

Note that enabling this feature will use extra resources in order to parse all the data being added and remove or fix any unwanted HTML errors. Keeping this feature disabled on large sites would be best unless you really desire your site to be XHTML valid.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_wysiwyg_comments" added="1213876086"><![CDATA[<title>Enable WYSIWYG</title><info>Set this to <b>True</b> if you would like to enable the usage of a WYSIWYG editor when users add a comment on an item or another users profile. 

Note that in order for this setting to take affect you must be using a WYSIWYG editor other then the <b>default</b> editor.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_comment_page_limit" added="1213876191"><![CDATA[<title>Page Limit</title><info>Define how many comments will be displayed on a page before we add a pagination so users can continue to browse to other pages to view the rest of the comments.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_keep_active_posts" added="1213876414"><![CDATA[<title>Active Posts</title><info>Define how long we should keep posts active in minutes. 

Note that if a post passes this limit it will be displayed on the site normally, however if a post is active there will be some form of letting the user know that they have not viewed the specific thread or forum. Depending on the theme you are using this is usually identified by images and formating the title of the thread or forum to be bold.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_use_hot_threads" added="1213876606"><![CDATA[<title>Display Hot Threads</title><info>Set this to <b>True</b> if you would like to display <b>Hot Threads</b> in your forums. 

Hot Threads are defined by the setting <setting>iHotThreadPosts</setting> or <setting>iHotThreadViews</setting>. 

Depending on those settings it will consider if a thread is popular by how many posts or views a thread has and if it surpassed the settings mentioned earlier it will be considered a <b>Hot Thread</b>.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_hot_thread_posts" added="1213876728"><![CDATA[<title>Hot Thread Limit (Posts)</title><info>Define how many threads must be added before a thread can be considered to be a <b>Hot Thread</b>.

Note that if the setting <setting>bUseHotThreads</setting> is disabled this setting will have no affect on your site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_hot_thread_views" added="1213876942"><![CDATA[<title>Hot Thread Limit (Views)</title><info>Define how many thread views must be added before a thread can be considered to be a <b>Hot Thread</b>.

Note that if the setting <setting>bUseHotThreads</setting> is disabled this setting will have no affect on your site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_login_module" added="1213877180"><![CDATA[<title>User Login Method</title><info>Login method used when a user logs into a site.

<b>Cookies</b> will store the information we need to keep a user logged in on their end, while a <b>Session</b> will store this information on your server.

Note that if a user logs into the site with the "Remember Me" box ticked it will automatically use a <b>Cookie</b> to set the users session.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_active_session" added="1213877388"><![CDATA[<title>Active Session</title><info>Define how long a user is displayed as active on the site in minutes. 

If a user is inactive longer then the specified setting they will be removed from the online session table. When this is done they will no longer appear to be online when other members view their profile. If the user suddenly becomes active after their session expired a new session will automatically be created.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_tag_min_display" added="1213877642"><![CDATA[<title>Minimum Display</title><info>Define how many tags must be added before they can be displayed to the public.

Higher this setting if you do want to display a tag cloud with only a few tags.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_tag_max_font_size" added="1213877692"><![CDATA[<title>Maximum Font Size</title><info>Define the font size for the most added/used tags on the site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_tag_min_font_size" added="1213877749"><![CDATA[<title>Minimum Font Size</title><info>Define the font size for the least used tags on the site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_tag_cache_tag_cloud" added="1213877937"><![CDATA[<title>Cache</title><info>Define how long we should cache tag clouds that are displayed on sections that use them.

Note that this setting must be defined in minutes.

It is important to cache tag clouds as this removes a query to the database that can be rather memory extensive.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_top_bloggers_display_limit" added="1213878007"><![CDATA[<title>Top Bloggers Limit</title><info>Define the limit of how many <b>Top Bloggers</b> can be displayed when viewing the blog section.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_top_bloggers_min_post" added="1213878115"><![CDATA[<title>Blog Count for Top Bloggers</title><info>Before a user can be considered to be a <b>Top Blogger</b> they must enter X amount of blog(s) where X is the value of this setting.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_cache_top_bloggers" added="1213878273"><![CDATA[<title>Cache Top Bloggers</title><info>Set this to <b>True</b> if we should cache the <b>Top Bloggers</b>. It always a good idea to cache such things as there is no need to run an extra query to the database to find out which users are the <b>Top Bloggers</b> as this requires counting all of the blogs added.

Note that the setting <setting>cache_top_bloggers_limit</setting> controls how long to keep the cache.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_cache_top_bloggers_limit" added="1213878370"><![CDATA[<title>Top Bloggers Cache Time</title><info>Define how long we should keep the cache for the <b>Top Bloggers</b>.

Note this setting will have not affect if the setting <setting>cache_top_bloggers</setting> is disabled.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_display_post_count_in_top_bloggers" added="1213878461"><![CDATA[<title>Display Post Count for Top Bloggers</title><info>Set this to <b>True</b> if you would like to display the post count besides the names of each of the <b>Top Bloggers</b>.

Note that this feature relies on the theme you are using and if the theme is not the default theme provided this might not be displayed.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_archive_handler" added="1214047385"><![CDATA[<title>Archive Handler</title><info>Control how the Archive class handles archives that need to be either extracted or created.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_unzip_path" added="1214047692"><![CDATA[<title>Unzip Path</title><info>Full path to where the binary for <b>unzip</b> is located. 

If you are unsure you can try to add the following:
[code]
unzip
[/code]

If the above does not work you will need to ask your host or run the following command via command line:
[code]
whereis unzip
[/code]</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_lang_pack_helper" added="1214050525"><![CDATA[<title>Language Package Helper</title><info>If enabled this option will add brackets surrounding a phrase, which can be used to identify which phrases have not been added into the core language package. Hard coded phrases will not have brackets.



If a phrase is hard coded in the source the site will be unable to translate that specific phrase.

It is best to use this feature during development or creating of a new language package. 

Example of how a phrase will look once this setting is enabled:
[quote]
{This is a sample}
[/quote]</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_cron" added="1214137439"><![CDATA[<title>Cron</title><info>Control the time-based scheduling service provided.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_cron" added="1214137712"><![CDATA[<title>Cron Jobs</title><info>Set to <b>True</b> to enable <b>Cron Jobs</b> to actively run in the background of your site.

If you have access to setup a crontab this method is preferred but will require access to your server. Once a crontab is setup you can disable this feature.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_feed_time_layout" added="1214141052"><![CDATA[<title>Time Layout</title><info>Control how old feeds can be by getting feeds that are <b>X</b> minutes, hours, days or months old.

<b>X</b> is defined by the setting <setting>display_feeds_from</setting>.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_display_feeds_from" added="1214141228"><![CDATA[<title>Time Limit</title><info>This setting is used in conjunction with the setting <setting>feed_time_layout</setting>.

Here you must define a number which will control how old a news feed can be.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_feed_only_friends" added="1214141288"><![CDATA[<title>Friends Only</title><info>Set to <b>True</b> if you would like news feed to only be displayed to the user and their friends.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_feed_display_limit" added="1214141651"><![CDATA[<title>Display Limit</title><info>Limit how many feeds should be displayed within the main news feed.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_captcha_code" added="1214232656"><![CDATA[<title>Captcha String</title><info>Alphanumeric characters that will be part of the Captcha routine.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_captcha_limit" added="1214232699"><![CDATA[<title>Character Limit</title><info>Limit how many characters will be displayed in the Captcha image.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_captcha_use_font" added="1214233090"><![CDATA[<title>Use Font (TTF)</title><info>If enabled and if your server supports the PHP function [link=http://se.php.net/imagettftext]imagettftext[/link] the Captcha routine will use a TTF (True Type Font) to create the text instead of using the default image processing string function.

The font that will be used is controlled by the setting <setting>captcha_font</setting>:</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_captcha_font" added="1214233276"><![CDATA[<title>True Type Font</title><info>Select which TTF (True Type Font) you would like to use for your Captcha image.

Note the setting <setting>captcha_font</setting> must be enabled in order to use this option.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_default_lang_id" added="1214236511"><![CDATA[<title>Default Language ID</title><info>Control the default language ID for the site. Note this setting is handled within the script and in most cases should <b>not</b> be modified.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_default_theme_name" added="1214236595"><![CDATA[<title>Default Theme Name</title><info>Default Theme Name</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_default_style_name" added="1214236614"><![CDATA[<title>Default Style Name</title><info>Default Style Name</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_default_style_id" added="1214236630"><![CDATA[<title>Default Style ID</title><info>Default Style ID</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_module_forum" added="1214236808"><![CDATA[<title>Default forum module URL</title><info>If the forum module name is different this setting must be updated.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_admin_control_panel" added="1214236854"><![CDATA[<title>Admin Control Panel</title><info>Manage settings for the Admin CP.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_admin_cp" added="1214237032"><![CDATA[<title>Admin CP Location</title><info>Location of the Admin CP. Change this to secure your Admin CP.

By default the setting is <b>admincp</b> so the final URL will be:
[quote]
http://www.yoursite.com/admincp/
[/quote]

Note the above example is when short URL's is enabled.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_general" added="1214237167"><![CDATA[<title>General</title><info>Manage general settings.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_global_update_time" added="1214237553"><![CDATA[<title>Global Time Stamp</title><info>Each module has items that are displayed and use our time stamp settings to display the date the way we would like.

If a module does not specify a time stamp setting it will use the default time stamp layout which is controlled with this setting.

For a better understanding on how to modify this setting and what the string values stand for you can follow up on the PHP date() function [link=http://se2.php.net/date]here[/link].</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_time_stamps" added="1214312574"><![CDATA[<title>Time Stamps</title><info>Control global and module time stamps.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_server_settings" added="1214312832"><![CDATA[<title>Server Settings</title><info>Manage server settings and optimization options.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_use_gzip" added="1214313174"><![CDATA[<title>GZIP HTML Output</title><info>Selecting <b>True</b> will enable the option to GZIP compress the HTML output of pages, thus reducing bandwidth requirements. This will be only used on clients that support it, and are HTTP 1.1 compliant. There will be a small performance overhead.

This feature requires the ZLIB library.

If you are already using <b>mod_gzip</b> or <b>mod_deflate</b> on your server, do not enable this option.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_gzip_level" added="1214313244"><![CDATA[<title>GZIP Compression Level</title><info>Set the level of GZIP compression that will take place on the output. 0=none; 9=max.

We strongly recommend that you use level 1 for optimum results.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_title_delim" added="1214313635"><![CDATA[<title>Site Title Delimiter</title><info>This value will be used as the delimiter to separate titles being added for each page on the site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_site_title" added="1214313887"><![CDATA[<title>Site Name</title><info>Name of your site. This will appear on every page.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_branding" added="1214314014"><![CDATA[<title>phpFox Branding Removal</title><info>Set to <b>True</b> to remove phpFox branding.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_ip_check" added="1214314158"><![CDATA[<title>Session IP Octet Length Check</title><info>Select the subnet mask which reflects the level of checking you wish to run against IP addresses when a session is being fetched.

This is useful if you have a large number of users who are behind transparent proxies and have an IP address that can change randomly between request such as AOL.

The more this is decreased the greater the security risk from session hijacking.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_session_prefix" added="1214314437"><![CDATA[<title>Cookie Prefix</title><info>Prefix for cookies and PHP sessions being set by the script. 

<b>Warning</b>: This value can only contain alphanumeric characters (eg. a-zA-Z0-9)

Note that everyone will be forced to login again for security reasons.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_keywords" added="1214314561"><![CDATA[<title>Meta Keywords</title><info>Enter the meta keywords for all pages. These are used by search engines to index your pages with more relevance.

Note that certain modules or pages have their own meta keyword settings and if those are set they will override this setting.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_description" added="1214314637"><![CDATA[<title>Meta Description</title><info>Enter the meta description for all pages. This is used by search engines to index your pages more relevantly.

Note that certain modules or pages have their own meta keyword settings and if those are set they will override this setting.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_tar_path" added="1214323414"><![CDATA[<title>Tar Path</title><info>Full path to where the binary for tar is located.

If you are unsure you can try to add the following:
[code]
tar
[/code]

If the above does not work you will need to ask your host or run the following command via command line:
[code]
whereis tar
[/code]</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_csrf_protection_level" added="1214854966"><![CDATA[<title>CSRF Protection Level</title><info>Select the Cross Site Forgery Request (CSRF) prevention level you want on your site.

<b>Low</b>
Minimal prevention for CSRF attacks.

<b>Medium</b>
Each user will have a unique token ID which will be static as long as they use the same browser for that session. 

<b>High</b>
Each user will have a unique token ID which will be changed on each page they visit thus giving them a random ID on each page refresh. This method offers full protection against CSRF attacks, however since the token is random the user can only browse your site with one browser window. If they would for example use a browser that supports tabs and would use a 2nd tab and would then attempt to submit a form they might get a CSRF attack error message since their last token was from the previous tab they had open.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_is_personal_site" added="1215181158"><![CDATA[<title>Personal Site</title><info>If set to <b>Yes</b> the site will be treated as your personal web site and items such as blogs will only be viewable from the public area and not from personal profiles.

Only enable this feature if you do not plan on having a social networking community and only plan to add your personal items.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_module_core" added="1215411477"><![CDATA[<title>Core Module</title><info>Specify the core module. Changing this could cause severe problems on the site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_build_file_dir" added="1215412887"><![CDATA[<title>Build Directories</title><info>If set to <b>True</b> and items are added to the <b>file/</b> directory they will be placed in separate folders for organization and security purposes. The <b>file/</b> folder is used to store cached data or items uploaded by users.

You can define how the directories will be built using the setting <setting>build_format</setting>.

By default directories will be built using the <b>Year/Month</b> format. If an image would be uploaded on January 1st 2008 it would be placed in the folder: file/pic/photo/2008/01/

<b>Notice:</b> If you have PHP [link="http://se.php.net/features.safe-mode"]Safe Mode[/link] enabled this feature might not work unless the <b>file/</b> folder belongs to the same UID (owner) as the script.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_build_format" added="1215414328"><![CDATA[<title>Build Format</title><info>This setting controls how the setting <setting>build_format</setting> functions.

This setting uses the PHP [link="http://se2.php.net/date"]date()[/link] function to control how directories are created within the <b>file/</b> folder.

By default we use <b>Y/m</b>. <b>Y</b> stands for a full numeric representation of a year, 4 digits (Eg. 2008). <b>m</b> stands for a numeric representation of a month, with leading zeros (Eg. 01).

For more information regarding this setting you may follow up on the PHP function [link="http://se2.php.net/date"]here[/link].</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_blog_time_stamp" added="1215414980"><![CDATA[<title>Blog</title><info>Controls time stamps for blog entries.

If using the default setting and the default template the time stamp will appear under each blog title and will look similar to:
[quote]
Posted June 22, 2008 by Raymond Benc
[/quote]</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_comment_time_stamp" added="1215415183"><![CDATA[<title>Comments</title><info>Controls time stamps for each comment being posted on the site.

If using the default setting and template the time stamp will appear under the posters user name
[quote]
Raymond Benc wrote
[/quote]
and will be similar to:
[quote]
June 22, 2008 
[/quote]</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_forum_time_stamp" added="1215415254"><![CDATA[<title>Forum</title><info>Default forum time stamp</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_forum_post_time_stamp" added="1215415278"><![CDATA[<title>Forum Post</title><info>Default forum time stamp</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_forum_post_today_time_stamp" added="1215415308"><![CDATA[<title>Forum Post (Today)</title><info>More info coming...</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_forum_post_yesterday_time_stamp" added="1215415343"><![CDATA[<title>Forum Post (Yesterday)</title><info>More info coming...</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_forum_post_join_date" added="1215415367"><![CDATA[<title>Forum Post User Join</title><info>More info coming...</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_zip_path" added="1215418009"><![CDATA[<title>Zip Path</title><info>Full path to where the binary for <b>zip</b> is located.

If you are unsure you can try to add the following:
[code]
zip
[/code]

If the above does not work you will need to ask your host or run the following command via command line:
[code]
whereis zip
[/code]</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_cache_phrases" added="1216087500"><![CDATA[<title>Page Cache</title><info>If set to <b>Yes</b>, phrases from language packages will be cached based on the page being viewed instead of the conventional method which caches all phrases and splits them up into the modules they belong to. 

The module cache method is good during your development period, however once your site is live and you don't plan to make any changes to the language package enabling this setting to cache phrases on a per page basis is a good idea.

This will in return save the total memory consumption as phrases are cached into memory (depending on your cache method) and loading several modules on one page can be a waste when you may only need 20 phrases from 3 different modules.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_site_copyright" added="1217035523"><![CDATA[<title>Copyright</title><info>Add your sites copyright.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_comment_is_threaded" added="1217198416"><![CDATA[<title>Thread Display</title><info>If set to <b>True</b> comments will be displayed in a thread format allowing users to reply to specific comments instead of the general item they are commenting on.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_forms" added="1217804478"><![CDATA[<title>Forms</title><info>Manage settings for general forms being used on the site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_display_required" added="1217804762"><![CDATA[<title>Display Required Fields</title><info>When set to <b>True</b> forms that have both optional and "required" fields will have a asterisk (depending on what is set for the setting <setting>required_symbol</setting>).</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_required_symbol" added="1217804932"><![CDATA[<title>Required Field Symbol</title><info>On forms that have fields that are required we add a symbol to distinguish which fields are required and which are not. Change this setting will change that symbol which by default is an asterisk.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_blog_display_user_post_count" added="1217808470"><![CDATA[<title>Display Post Count for Categories (Personal)</title><info>If set to <b>True</b> we will display a users post count for a specific category. This will be displayed on their profile, blog and when browsing their own blogs.

Notice: This will add an extra strain to your server if set to <b>True</b>.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_default_time_zone_offset" added="1218452027"><![CDATA[<title>Default Time Zone</title><info>Select the default time zone for guests and new users.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_login_type" added="1218457359"><![CDATA[<title>User Login Method</title><info>Select the method you would like your users to use when logging into the site.

<b>user_name</b>
Must use their user name.

<b>email</b>
Must use their email.

<b>both</b>
Can use either email or user name.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_redirect_after_login" added="1218465807"><![CDATA[<title>URL Redirect After Login</title><info>After a user has logged in and they have not requested a page to visit you can set a default redirection URL, which will send them to this specific page right after they login. 

If you add an external link be sure to add "http://" (without quotes) otherwise the URL will be treated as an internal link.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_profile_time_stamps" added="1219668321"><![CDATA[<title>Profile</title><info>Profile time stamps</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_user_pic_sizes" added="1219836551"><![CDATA[<title>User Pic Sizes</title><info>User Pic Sizes</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_mail_time_stamp" added="1220427478"><![CDATA[<title>Mail</title><info>Mail</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_profile_use_id" added="1221724040"><![CDATA[<title>Profile User ID Connection</title><info>Set to <b>True</b> if you would like to have user profiles connected via their user ID#. Set to <b>False</b> if you would like to have user profiles connected via their user name. 

Note if you connect via their user ID# you will allow your members the ability to use non-supported characters which are not allowed if connecting a profile with their user name.

<b>Warning:</b> This action cannot be reversed.
This setting may lock users out if you force log in by their user names
</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_sample_2" added="1221824783"><![CDATA[<title>Sample 2</title><info>Sample 2</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_bsample" added="1221824814"><![CDATA[<title>This is a test</title><info>Yet another test...</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_captcha_on_signup" added="1221831949"><![CDATA[<title>Captcha on Registration</title><info>Enable this option to add a captcha routine to the registration process. This will help against spam.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="menu_home" added="1214844661">Home</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="submit" added="1212101943">Submit</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="save" added="1212102572">Save</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="delete" added="1212102630">Delete</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="revert_to_default" added="1212102649">Revert to Default</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="version" added="1212102733">Version {version}</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="display_from_x_to_x_of_x" added="1212103558"><![CDATA[Displaying <span id="js_pager_from">{from}</span> to <span id="js_pager_to">{to}</span> of <span id="js_pager_total">{total}</span>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="page_x_of_x" added="1212103641">Page {current} of {total}</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="first" added="1212103722">First</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="previous" added="1212103739">Previous</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="next" added="1212103757">Next</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="last" added="1212103772">Last</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="edit" added="1212118102">Edit</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="go" added="1212118345">Go</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="are_you_sure" added="1212121584">Are you sure?</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="yes" added="1212122361">Yes</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="no" added="1212122479">No</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="cancel" added="1212123142">Cancel</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="go_advanced" added="1212123181">Go Advanced</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="processing" added="1212123329">Processing</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="admin" added="1214836995">No Admin</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="select" added="1214997333">Select</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="per_page" added="1214997439">{total} per page</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="time" added="1214997726">Time</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="descending" added="1214997737">Descending</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="ascending" added="1214997748">Ascending</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="searching" added="1215125431">Searching</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="reset" added="1215128051">Reset</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="invalid_search_id" added="1215128221">Invalid search ID#</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="search_results_found" added="1215128235">No search results found.</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="menu_admincp" added="1217034328">AdminCP</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="menu_log_out" added="1217034457">Logout</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="copyright" added="1217035991">Copyright</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="required_fields" added="1217808842">Required Fields</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="search" added="1217946769">Search</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="bold" added="1218198100">Bold</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="italic" added="1218198441">Italic</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="underline" added="1218198452">Underline</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="toggle" added="1218200954">Toggle</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="user_name" added="1218458075">User Name</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="close" added="1218534881">Close</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="quote" added="1218724993">Quote</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="originally_posted" added="1218725011">Originally posted by</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="code" added="1218725027">Code</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="notice" added="1218793387">Notice</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_mail" added="1230344425"><![CDATA[<title>Mail</title><info>Mail Settings...</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_method" added="1230345982"><![CDATA[<title>Send Mail Method</title><info>Select the method you would like your emails to be sent it, which is either using the default PHP mail() function or SMTP.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_mailsmtphost" added="1230347643"><![CDATA[<title>SMTP Host</title><info>If SMTP is enabled, set the SMTP server host here.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_mail_smtp_authentication" added="1230347719"><![CDATA[<title>SMTP Authentication</title><info>SMTP Authentication</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_mail_smtp_username" added="1230347911"><![CDATA[<title>SMTP Username</title><info>SMTP Username</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_mail_smtp_password" added="1230347969"><![CDATA[<title>SMTP Password</title><info>SMTP Password</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_mail_from_name" added="1230348032"><![CDATA[<title>From</title><info>This is the name displayed when users receive emails from this site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_email_from_email" added="1230348559"><![CDATA[<title>Email</title><info>This is the default email used when sending out emails and it will be the email users will see in their email.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_mail_signature" added="1230350155"><![CDATA[<title>Signature</title><info>This is the signature added to the bottom of each email that is sent from this site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_log_site_activity" added="1230487661"><![CDATA[<title>Log Site Activity</title><info>Set to "true" to log all site activity, which can be used at a later time to create general site statistics or keep track of a specific users activity.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_cache_js_css" added="1230600110"><![CDATA[<title>Cache JavaScript & CSS</title><info>Set to <b>True</b> to cache all JavaScript and CSS into one file to speed up your site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="about" added="1231338537">About Us</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="menu_about" added="1231338606">About</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="privacy_policy" added="1231339019">Privacy Policy</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="menu_privacy" added="1231339074">Privacy</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_cache_plugins" added="1231410765"><![CDATA[<title>Cache Plugins</title><info>Enable this setting if all plug-ins should be cached. It is advised to enable this on live sites.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_host" added="1232702227"><![CDATA[<title>FTP Host</title><info>FTP Host</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_username" added="1232702303"><![CDATA[<title>FTP Username</title><info>FTP Username</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_password" added="1232702336"><![CDATA[<title>FTP Password</title><info>FTP Password</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_ftp_enabled" added="1232957270"><![CDATA[<title>Enable FTP Support</title><info>Enable FTP Support</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="terms_use" added="1232965159">Terms of Use</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_ftp" added="1232702186"><![CDATA[<title>FTP</title><info>Control your FTP (File Transport Protocol) details.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="user_setting_can_view_update_info" added="1214975478"><![CDATA[Can view "Update" information on items?

Note: This information usually displays the user name of the last person that modified an item and the time it took place.]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="user_setting_can_view_private_items" added="1214976287">Can view private items posted on the site. 

Such items are created by a member and are marked as private so only that member can view the item and members that have this option enabled.</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="user_setting_can_add_new_setting" added="1214976515">Can add new product settings.

Enable this feature only if development is in progress and changes are being made to the product.</phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_cache" added="1234519823"><![CDATA[<title>Cache</title><info>All cache related variables</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_crop_seo_url" added="1235137384"><![CDATA[<title>Crop URLs</title><info>Crop URL for SEO</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_search_engine_optimization" added="1235377937"><![CDATA[<title>Search Engine Optimization</title><info>Search Engine Optimization</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_meta_description_limit" added="1235378018"><![CDATA[<title>Meta Description Limit</title><info>Define the maximum number of characters that can be used in a meta description tag.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_meta_keyword_limit" added="1235378131"><![CDATA[<title>Meta Keyword Limit</title><info>Define the maximum number of characters that can be used in a meta keyword tag.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_description_time_stamp" added="1235378894"><![CDATA[<title>Meta Description Time Stamp</title><info>Meta Description Time Stamp</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_use_dnscheck" added="1236199706"><![CDATA[<title>Use DNSCheck in email validation</title><info>http://php.net/checkdnsrr

This value tells if the script should validate the email addresses using checkdnsrr.

This function may not be available in some windows default installations. However even if this setting is enabled if the function does not exist the site will not fail, it will only skip that part of the validation.

There is some undocumented (but technically possible) slow down on using this feature, so while it adds extra security to your site it could also become a bottleneck. Use carefully.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_group_debug" added="1237059507"><![CDATA[<title>Debug</title><info>Debug Settings</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha1" var_name="setting_admin_debug_mode" added="1237059838"><![CDATA[<title>Debug Level</title><info>Control the debug output at the bottom for the site.

<b>Level Information</b>

<b>Level 0</b> = Debug is disabled.

<b>Level 1</b> = Enables PHP error reporting, page generation times and query count.

<b>Level 2</b> = Includes <i>Level 1</i>, server usage, session and cookie information.

<b>Level 3</b> = Includes <i>Level 1</i>, <i>Level 2</i> and SQL queries.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha3" var_name="setting_replace_url_with_links" added="1239104515"><![CDATA[<title>Replace URL with Links</title><info>Set to <b>True</b> if you would like to automatically replace URL strings to anchor links.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0alpha3" var_name="setting_shorten_parsed_url_links" added="1239104765"><![CDATA[<title>Shorten Parsed URL Links</title><info>If the option to parse URL strings to links is enabled then you can control how long the URL string should be before you shorten it.

<b>Note:</b> Set to <b>0</b> to have no limit.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta2" var_name="module_report" added="1242580237">Reports</phrase>
		<phrase module_id="core" version_id="2.0.0beta1" var_name="setting_default_music_player" added="1240746034"><![CDATA[<title>Default Music Player</title><info>Default Music Player</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta3" var_name="setting_footer_bar_site_name" added="1243328927"><![CDATA[<title>Footer Bar Site Name</title><info>The name defined here will be displayed on the sites footer bar.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta3" var_name="setting_enable_footer_bar" added="1243433757"><![CDATA[<title>Enable Footer Bar</title><info>Set to <b>True</b> if you would like to enable the site wide footer bar.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_group_spam" added="1244645871"><![CDATA[<title>Spam</title><info>Spam</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_site_is_offline" added="1245096405"><![CDATA[<title>Site is offline?</title><info>Select <b>True</b> to turn your site offline.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_site_offline_message" added="1245096657"><![CDATA[<title>Offline Message</title><info>Message that will be displayed to guests when the site is offline.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_site_offline_no_template" added="1245096756"><![CDATA[<title>Blank Template</title><info>Select <b>True</b> if you would like to use a blank template when displaying the site offline.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="user_setting_can_view_site_offline" added="1245096916">Can view the site even when its set to offline?</phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_group_site_offlineonline" added="1245148890"><![CDATA[<title>Site Offline/Online</title><info>Site Offline/Online</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_group_site_statistics" added="1245148969"><![CDATA[<title>Site Statistics</title><info>Site Statistics</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_cache_site_stats" added="1245149101"><![CDATA[<title>Cache Site Stats</title><info>Set to <b>True</b> if site stats should be cached.

<b>Notice:</b> It is highly advised to cache site stats as it requires a large set of queries to the database across numerous tables.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_site_stat_update_time" added="1245149670"><![CDATA[<title>Update Stats Cache (Minutes)</title><info>Define in minutes how long to wait until we need to re-cache the site statistics.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta4" var_name="setting_display_site_stats" added="1245149863"><![CDATA[<title>Display Site Stats</title><info>Set to <b>True</b> to display the sites statistics publicly within the sites user dashboard.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta5" var_name="setting_identify_dst" added="1246304944"><![CDATA[<title>DST</title><info>DST</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta5" var_name="user_cancellation_9" added="1247140918"><![CDATA[I don't find this site useful]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta5" var_name="user_cancellation_10" added="1247140937">I have a privacy concern</phrase>
		<phrase module_id="core" version_id="2.0.0beta5" var_name="user_cancellation_11" added="1247140968"><![CDATA[I don't understand how to use this site.]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta5" var_name="user_cancellation_12" added="1247141061"><![CDATA[I'm getting too much email from this site.]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta5" var_name="user_cancellation_13" added="1247141084"><![CDATA[I'm getting too much spam or too many friend requests]]></phrase>
		<phrase module_id="core" version_id="2.0.0beta5" var_name="user_cancellation_14" added="1247141103"><![CDATA[I'm bored with this site.]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="phpfox_branding_removal" added="1248788055">Branding Removal</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_item_view_area" added="1248967239"><![CDATA[<title>Item Location</title><info>Select <b>public</b> if you would like all items to be displayed within a public section or select <b>profile</b> to have items displayed on a users profile. 

It is advised to select this option once as this greatly effects how search engines pick up pages on the site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_ftp_dir_path" added="1249534880"><![CDATA[<title>FTP Directory Path</title><info>Supply the full path to the scripts root directory.

If you are unsure on the full path, you can click <a href="#" onclick="tb_show('FTP Path Search', $.ajaxBox('core.ftpPathSearch', 'height=410&width=700')); return false;">here</a> for help on finding the correct full path.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_country" added="1249592745">Countries</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_country_manager" added="1249592782">Country Manager</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_country_import" added="1249592834">Import</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_country_add" added="1249592927">Add Country</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_country_child_add" added="1249592955">Add State/Province</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="user_setting_user_is_banned" added="1249620562"><![CDATA[Group banned from logging into the site and interacting with other members. 

<b>Note:</b> This option is intended only for "Banned" usergroup.]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_banned_user_group_id" added="1249622743"><![CDATA[<title>Banned User Group ID</title><info>Banned User Group ID</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_group_image_processing" added="1249707453"><![CDATA[<title>Image Processing</title><info>Image Processing</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_watermark_option" added="1249707671"><![CDATA[<title>Image Watermark</title><info>Certain areas allow image watermarking. If such sections have image watermarking enabled this option must be enabled.

If you select "image", this will add a small watermark image to each image that is uploaded. If you select "text" this will add the text defined in this section.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_watermark_image" added="1249707937"><![CDATA[<title>Watermark Image Name</title><info>Watermark Image Name</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_watermark_opacity" added="1249710065"><![CDATA[<title>Watermark Opacity</title><info>The opacity of an image can range from 1-100.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_watermark_image_position" added="1249710197"><![CDATA[<title>Watermark Position</title><info>Select a position to place the watermark.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_image_text_hex" added="1249710513"><![CDATA[<title>Watermark Text Color</title><info>(HEX COLORS Example: 000000)</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_image_text" added="1249710554"><![CDATA[<title>Watermark Text</title><info>Watermark Text</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_group_registration" added="1250761161"><![CDATA[<title>Registration</title><info>Registration</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_registration_enable_dob" added="1250761283"><![CDATA[<title>Date of Birth</title><info>Enable this so users can register their date of birth when signing up for the site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_registration_enable_gender" added="1250761528"><![CDATA[<title>Gender Field</title><info>Enable this so users can register their gender when signing up for the site. </info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_registration_enable_location" added="1250761639"><![CDATA[<title>Location</title><info>Enable this so users can register their location when signing up for the site. </info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_registration_enable_timezone" added="1250761716"><![CDATA[<title>Timezone</title><info>Enable this so users can register their timezone when signing up for the site. </info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="kind_regards_phpfox" added="1250847533">Kind Regards,
Site Admins</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_global_admincp_note" added="1250924099"><![CDATA[<title>Global AdminCP Note</title><info>Global AdminCP Note</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_online" added="1251100890">Online</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_online_members" added="1251100922">Members</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_online_guests" added="1251100953">Guests/Bots</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="admincp_menu_system_overview" added="1251104897">System Overview</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_enable_spam_check" added="1251183206"><![CDATA[<title>Enable Spam Check</title><info>Enable Spam Check</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_akismet_url" added="1251183367"><![CDATA[<title>Akismet URL</title><info><a href="http://akismet.com/">Akismet</a> URL. This is full path to your site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_akismet_password" added="1251183407"><![CDATA[<title>Akismet API Key</title><info><a href="http://akismet.com/">Akismet</a>  API key is a private key Akismet provides when you register for an account with them.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="user_setting_is_spam_free" added="1251184321"><![CDATA[Set to <b>True</b> if this user group should never be checked for spamming.]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_auto_deny_items" added="1251199652"><![CDATA[<title>SPAM Count</title><info>Define how many items a user can attempt to SPAM before anything they add will not be checked as we will consider that it is SPAM.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_auto_ban_spammer" added="1251200209"><![CDATA[<title>Auto Ban Spammers</title><info>Define how many times a user can SPAM before they are automatically banned.

<b>Notice:</b> Set this to "0" (without quotes) to disable this setting.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_warn_on_external_links" added="1251207145"><![CDATA[<title>External Links Warning</title><info>Warn users when they have clicked on a link that will direct them to another site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_disable_all_external_urls" added="1251275581"><![CDATA[<title>Disable All External URL's</title><info>Enable this feature to remove all external links from the site. 

<b>Notice:</b> Sites added to the "URL White List" will be allowed.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_url_spam_white_list" added="1251275716"><![CDATA[<title>URL White List</title><info>Add sites that you want to allow in external links.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_disable_all_external_emails" added="1251276234"><![CDATA[<title>Disable All External Emails</title><info>Enable this feature to remove all external emails from the site.

Notice: Sites added to the "Email White List" will be allowed.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_email_white_list" added="1251276292"><![CDATA[<title>Email White List</title><info>Add sites that you want to allow in external emails.</info>]]></phrase>
		<phrase module_id="core" version_id="ASD" var_name="setting_phpfox_version" added="1251285789"><![CDATA[<title>Version</title><info>Version</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="user_setting_can_view_twitter_updates" added="1251800495">Can view corporate twitter updates?</phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="user_setting_can_view_news_updates" added="1251800546"><![CDATA[Can view corporate news & updates?]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_redirect_guest_on_same_page" added="1251815780"><![CDATA[<title>Same Page Redirection After Login/Registration</title><info>Enable this option to redirect guests to the same page they were visiting after they have logged into or registered.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_meta_description_profile" added="1252056488"><![CDATA[<title>Meta Description Profile</title><info>This is the meta description provided on a users profile that is included with their personal information. It is advised for this to not be too long in order to leave room for the users personal information.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc1" var_name="setting_words_remove_in_keywords" added="1252131710"><![CDATA[<title>Keyword String Removal</title><info>Define words here that should not show up within meta keywords. Each word should be comma separated.

<b>Notice:</b> The search is case insensitive.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="update" added="1252756715">Update</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="total_items" added="1253083301">Total Items</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="activity_points" added="1253083311">Activity Points</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="dashboard" added="1253083344">Dashboard</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="membership" added="1253083384">Membership</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="profile_views" added="1253083407">Profile Views</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="space_used" added="1253083418">Space Used</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="member_since" added="1253083428">Member Since</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="what_s_new" added="1253083513"><![CDATA[What's New]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="site_stats" added="1253083687">Site Stats</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="customize_dashboard" added="1253084413">Customize Dashboard</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="quick_links" added="1253085095">Quick Links</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="module_is_not_a_valid_module" added="1253085115">{module} is not a valid module.</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="state_province" added="1253085649">State/Province</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="what_is_on_your_mind" added="1253085696">What is on your mind?</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="click_to_change_profile_photo" added="1253085719">Click to change profile photo.</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="last_login" added="1253085749">Last Login</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="submit_links" added="1253085762">Submit Links</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="manage_links" added="1253085771">Manage Links</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="logout" added="1253085794">Logout</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="click_to_view_your_profile" added="1253085803">Click to view your profile.</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="click_to_change_your_profile_photo" added="1253085818">Click to change your profile photo.</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="click_to_change_your_status" added="1253085836">Click to change your status.</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="status" added="1253085850">Status</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="link_save_or_cancel" added="1253085874"><![CDATA[<a href="#" onclick="$('#js_user_status_form').ajaxCall('user.updateStatus'); return false;">save</a> or <a href="#" class="js_update_status">cancel</a>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="start_search" added="1253085894">Start search...</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="favorites" added="1253085935">Favorites</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="hide_the_footer_bar" added="1253085957">Hide the Footer Bar</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="show_the_footer_bar" added="1253085989">Show the Footer Bar</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="ftp_path" added="1253086005">FTP path</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="change_your_time_zone_preference" added="1253086694">Change your time zone preference.</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="welcome_name" added="1253087071">Welcome, {name}!</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="share" added="1253108437">Share</phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="setting_enable_getid3_check" added="1253267285"><![CDATA[<title>Use getID3 for Files Uploaded</title><info>getID3 is a 3rd party library that helps us verify the meta contents of a file that is uploaded to the server to confirm if the file that is being uploaded contains data that is related to what we are allowing to be uploaded (eg. photo, mp3's, videos etc...).</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc2" var_name="setting_extended_global_time_stamp" added="1253522109"><![CDATA[<title>Extended Global Time Stamp</title><info>Extended Global Time Stamp</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc3" var_name="setting_theme_session_prefix" added="1254810114"><![CDATA[<title>Theme Session Prefix</title><info>Theme Session Prefix</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="edit_this_block" added="1255709562">Edit this Block</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="remove_this_block" added="1255709579">Remove this Block</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="hello" added="1255709619">Hello</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="hello_name" added="1255709649">Hello {name}</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="the_site_is_currently_in_offline_mode" added="1255709707"><![CDATA[The site is currently in "Offline Mode".]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="explore" added="1255709725">Explore</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="add_a_video" added="1255710109">Add a Video</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="enter_the_url_of_your_link" added="1255710193">Enter the URL of your link</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="enter_the_url_of_your_image" added="1255710214">Enter the URL of your image</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="add_a_link" added="1255710241">Add a Link</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="add_a_photo" added="1255710256">Add a Photo</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="toggle_fullscreen" added="1255710373">Toggle Fullscreen</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="full_screen_editor" added="1255710422">Full Screen Editor</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="january" added="1255712010">January</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="february" added="1255712019">February</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="march" added="1255712026">March</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="april" added="1255712033">April</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="may" added="1255712040">May</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="june" added="1255712047">June</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="july" added="1255712054">July</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="august" added="1255712061">August</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="september" added="1255712068">September</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="october" added="1255712075">October</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="november" added="1255712082">November</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="december" added="1255712089">December</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="not_a_valid_file_extension_we_only_accept_support" added="1255712204">Not a valid file extension. We only accept: {support}</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="not_a_valid_image_we_only_accept_the_following_file_extensions_support" added="1255712279">Not a valid image. We only accept the following file extensions: {support}</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="unable_to_move_the_image" added="1255712307">Unable to move the image.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="unable_to_move_the_file" added="1255712330">Unable to move the file.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="unable_to_upload_the_image" added="1255712340">Unable to upload the image.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="upload_failed_server_cannot_handle_files_larger_then_file_size" added="1255712554">Upload failed. Server cannot handle files larger then: {file_size}</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="upload_failed_server_cannot_handle_files_size_larger_then_file_size" added="1255712603">Upload failed. Server cannot handle files ({size}) larger then: {file_size}</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="upload_failed_your_file_size_is_larger_then_our_limit_file_size" added="1255712638">Upload failed. Your file ({size}) is larger then our limit: {file_size}</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="uploaded_file_is_not_valid" added="1255712670">Uploaded file is not valid.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="unable_to_connect_to_ftp_host" added="1255712693">Unable to connect to FTP host.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="ftp_password_hash_does_not_match_with_server_hash" added="1255712704">FTP password hash does not match with server hash.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="unable_to_login_to_ftp_server" added="1255712714">Unable to login to FTP server.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="unable_to_connect_to_ftp_base_directory_make_sure_the_setting_for_ftp_directory_path_has_the_correct_path" added="1255712739"><![CDATA[Unable to connect to FTP base directory. Make sure the setting for "FTP Directory Path" has the correct path.]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="paypal_email" added="1255712780">PayPal Email</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="paypal_is_an_electronic_money_service_which_allows_you_to_make_payment_to_anyone_online" added="1255712892">PayPal is an electronic money service which allows you to make payment to anyone online. You can choose to pay using your credit card, debit card, bank account, or PayPal balance and make secure purchases without revealing your credit card number or financial information. All major credit and debit cards are accepted including Visa, Mastercard, American Express, Switch and Solo (plus many more).</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="the_email_that_represents_your_paypal_account" added="1255712972">The email that represents your PayPal account.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="2checkout_vendor_id_number" added="1255712983">2Checkout Vendor ID Number</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="2checkout_secret_word" added="1255712992">2Checkout Secret Word</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="your_numerical_vendor_id" added="1255713000">Your numerical vendor ID.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="the_secret_word_as_set_within_the_look_and_feel_page_of_your_2checkout_account" added="1255713007"><![CDATA[The secret word as set within the "Look and Feel" page of your 2Checkout account.]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="unable_to_create_a_watermark_resource" added="1255713076">Unable to create a watermark resource.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="originally_posted_by" added="1255714201">Originally posted by</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="search_results_for" added="1255714921">Search results for</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="any" added="1255714973">Any</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="upgrade_taking_place" added="1255715353">Upgrade Taking Place</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="content_is_empty" added="1255715616">Content is empty.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="the_content_of_this_item_is_identical_to_something_you_have_added_before_please_try_again" added="1255715631">The content of this item is identical to something you have added before. Please try again.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="try_again_in_1_minute" added="1255715652">Try again in 1 minute.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="try_again_in_time_minutes" added="1255715666">Try again in {time} minutes.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="month" added="1255715765">Month</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="day" added="1255715866">Day</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="year" added="1255715882">Year</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="am" added="1255715940">am</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="pm" added="1255715976">pm</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="language_packages" added="1255716241">Language Packages</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="manage" added="1255716528">Manage</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="profile" added="1255716538">Profile</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="1_second_ago" added="1255787567">1 second ago</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="total_seconds_ago" added="1255787587">{total} seconds ago</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="1_minute_ago" added="1255787604">1 minute ago</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="total_minutes_ago" added="1255787618">{total} minutes ago</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="1_hour_ago" added="1255787633">1 hour ago</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="total_hours_ago" added="1255787645">{total} hours ago</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="today" added="1255787662">Today</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="yesterday" added="1255787672">Yesterday</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="move_this_block" added="1255935862">Move This Block</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="online" added="1256030174">Online</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="none" added="1256032072">(none)</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="cancel_lowercase" added="1256119676">cancel</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="setting_can_move_on_a_y_and_x_axis" added="1256500257"><![CDATA[<title>Drag/Drop Blocks</title><info>Set this setting to <b>True</b> if you want to allow users to move blocks on a Y or X axis within areas where they can move blocks (eg. Their own profile). By default we only allow users to move blocks on a Y axis and allowing users to move blocks anywhere will give them the freedom but can cause your site design to be destroyed.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="block" added="1256542768">Block</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="full_name_is_online" added="1256550931">{full_name} is online.</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="setting_resize_images" added="1256639414"><![CDATA[<title>Resize Images</title><info>If you allow HTML on the site and users attempt to add images you can enable this option to set a maximum width/height in certain areas (eg. General Comments & News Feed).

<b>Note:</b> If enabled this will add an extra overhead to the script.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="you_cannot_write_more_then_limit_characters" added="1256666443">You cannot write more then {limit} characters!</phrase>
		<phrase module_id="core" version_id="2.0.0rc4" var_name="you_have_limit_character_s_left" added="1256666594">You have {limit} character(s) left.</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="welcome_email_content" added="1256828212">Thanks for joining our community!</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="welcome_email_subject" added="1256828898">Welcome to {site}</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="monday" added="1256832175">Monday</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="tuesday" added="1256832914">Tuesday</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="wednesday" added="1256832954">Wednesday</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="thursday" added="1256832979">Thursday</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="friday" added="1256833008">Friday</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="saturday" added="1256833052">Saturday</phrase>
		<phrase module_id="core" version_id="2.0.0rc5" var_name="sunday" added="1256833073">Sunday</phrase>
		<phrase module_id="core" version_id="2.0.0rc6" var_name="view_less" added="1257261878">View Less</phrase>
		<phrase module_id="core" version_id="2.0.0rc7" var_name="select_a_file_to_upload" added="1257790027">Select a file to upload.</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="clear" added="1258501182">Clear</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="clear_your_current_status" added="1258501409">Clear your current status...</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="not_a_valid_file_extension_we_only_allow_ext" added="1258550380">Not a valid file extension. We only allow: {ext}</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="opps_something_went_wrong" added="1258552662">Oops! Something went wrong. We were not able to complete your request. We are looking into fixing the issue. Please refresh the page and try again.</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="fill_in_a_proper_url" added="1259006129">Fill in a proper URL.</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="url" added="1259006139">URL</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="message" added="1259006152">Message</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="image" added="1259006739">Image</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="provide_a_proper_image_path" added="1259006762">Provide a proper image path.</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="not_a_valid_password" added="1259092483">Not a valid password.</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="invalid_url" added="1259092495">Invalid URL.</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="provide_a_numerical_value" added="1259092504">Provide a numerical value.</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="provide_a_valid_price" added="1259092512">Provide a valid price.</phrase>
		<phrase module_id="core" version_id="2.0.0rc8" var_name="provide_a_valid_year_eg_1982" added="1259092519">Provide a valid year. (eg. 1982)</phrase>
		<phrase module_id="core" version_id="2.0.0rc9" var_name="setting_mail_smtp_port" added="1259174724"><![CDATA[<title>SMTP Port</title><info>What port to use for sending mail with SMTP? Default is 25</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc10" var_name="setting_conver_time_to_string" added="1259600267"><![CDATA[<title>Time to String</title><info>Time to String</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc10" var_name="setting_global_welcome_time_stamp" added="1259613089"><![CDATA[<title>Global Welcome Time Stamp</title><info>Global Welcome Time Stamp</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="his" added="1259966039">his</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="her" added="1259966050">her</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="setting_no_more_ie6" added="1260114410"><![CDATA[<title>Detect IE6</title><info>With this feature enabled it will guide those using IE6 to upgrade to a supported browser.

This feature is powered by <a href="http://www.ie6nomore.com/" target="_blank">IE6 No More</a>

<b>Note:</b> The themes we provide by default require IE7 or higher, however other themes could work fine with IE6 as this comes down to the theme you have installed.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="warning" added="1260115626">Warning!</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="you_are_using_an_outdated_browser" added="1260115640">You are using an outdated browser</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="for_a_better_experience_using_this_site_please_upgrade_to_a_modern_web_browser" added="1260115649">For a better experience using this site, please upgrade to a modern web browser.</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="get_firefox" added="1260115659">Get Firefox</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="get_internet_explorer" added="1260115674">Get Internet Explorer</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="get_safari" added="1260115686">Get Safari</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="get_google_chrome" added="1260115698">Get Google Chrome</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="menu_core_new_sample" added="1260125237">New Sample</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="menu_core_sub_menu" added="1260133497">Sub Menu</phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="setting_resize_embed_video" added="1260137802"><![CDATA[<title>Resize Embedded Videos</title><info>Enable this feature to resize embedded videos to fit your sites default theme in areas where it is designed to fix flash videos (eg. users profile).

Note that enabling this feature will be an extra overhead.

Use this feature with caution as it is  experimental.
</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc11" var_name="translate" added="1260209538">Translate</phrase>
		<phrase module_id="core" version_id="2.0.0rc12" var_name="setting_footer_watch_time_stamp" added="1260824135"><![CDATA[<title>Footer Bar Time Stamp</title><info>Footer Bar Time Stamp</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc12" var_name="setting_categories_to_show_at_first" added="1260886987"><![CDATA[<title>How many subcategories to show at first</title><info>This setting tells how many subcategories are to be shown at first. If the list of subcategories is longer than this value the extra ones will be hidden and a "View More" option will be shown instead, allowing the user to display the hidden subcategories.

a "View Less" option will be available to provide the full "accordion" effect.

If you set it to zero ("0" without quotes) it will hide every subcategory and a plus sign will show next to the category name, clicking the plus sign will show that category's subcategories.
</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0rc12" var_name="translating_name" added="1260974997">Translating: {name}</phrase>
		<phrase module_id="core" version_id="2.0.0" var_name="sample_phrase" added="1261078500">Sample Phrase</phrase>
		<phrase module_id="core" version_id="2.0.0" var_name="setting_global_site_title" added="1261332596"><![CDATA[<title>Site Title</title><info>This will displayed on each page as the title of your site.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.0" var_name="uploading" added="1261570167">Uploading</phrase>
		<phrase module_id="core" version_id="2.0.2" var_name="setting_css_edit_id" added="1262718486"><![CDATA[<title>CSS Edit ID#</title><info>CSS Edit ID#</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.2" var_name="setting_footer_bar_tool_tip_time_stamp" added="1263239803"><![CDATA[<title>Footerbar Tooltip Timestamp</title><info>This is the time stamp displayed when hovering over the mini time stamp on the footer bar.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.4" var_name="what_s_on_your_mind" added="1267544459"><![CDATA[What's on your mind?]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="currency" added="1271403468">Currency</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="currency_manager" added="1271403530">Currency Manager</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="add_currency" added="1271403551">Add Currency</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="u_s_dollars" added="1271404571">U.S. Dollars</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="euros" added="1271404620">Euros</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="pounds_sterling" added="1271404639">Pounds Sterling</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="currencies" added="1271410326">Currencies</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="custom_currency_sek" added="1271419828">Swedish Crown</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_group_currency" added="1272025108"><![CDATA[<title>Currency</title><info>Currency</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_exchange_rate_api_key" added="1272025266"><![CDATA[<title>Exchange Rate API</title><info>In order to get the latest exchange rates for the currencies being used we need to connect to a 3rd party website. To sign up for a free API key go <a href="http://www.exchangerate-api.com/api-key">here</a>.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_group_cdn_content_delivery_network" added="1272361339"><![CDATA[<title>CDN (Content Delivery Network)</title><info>CDN (Content Delivery Network)</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_amazon_access_key" added="1272361405"><![CDATA[<title>Amazon Access Key</title><info>Add your Amazon access key.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_amazon_secret_key" added="1272361721"><![CDATA[<title>Amazon Secret Key</title><info>Add your Amazon secret key.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_amazon_bucket" added="1272361799"><![CDATA[<title>Amazon Bucket Name</title><info>This will automatically be created by the script. Leave this setting unless you want to manually create a bucket on Amazon.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_amazon_bucket_created" added="1272361978"><![CDATA[<title>Amazon Bucket Created</title><info>This setting is automatically updated by the script. Only edit this setting for debugging purposes.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_allow_cdn" added="1272362370"><![CDATA[<title>Enable CDN (Beta)</title><info>Set this to "True" if you want to use CDN. Note that this feature is still in "Beta".</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="money_field_only_accepts_numbers_and_point" added="1271338945">The money fields can only have numbers and a point.
Valid examples:
12.43
15
0.65</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="only_one_point_is_allowed" added="1271339014">In money fields only one point is allowed, valid examples:
23.12
19.54
30</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="money_fields_are_required" added="1271339939">If a money field is set, the others are required. You can leave them all empty or none.</phrase>
		<phrase module_id="core" version_id="2.0.5" var_name="setting_cdn_cname" added="1273008398"><![CDATA[<title>CDN URL (Optional)</title><info>If your CDN provider allows you to create a CNAME record you can add the domain here. Example: (http://cdn.yoursite.com/)</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5dev1" var_name="setting_force_https_secure_pages" added="1274840652"><![CDATA[<title>Secure Pages with HTTPS</title><info>If your server has support for HTTPS you can enable this feature to secure certain pages like the login, registration and account setting pages.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5dev2" var_name="try_again_in_time_seconds" added="1275106296">Try again in {time} seconds.</phrase>
		<phrase module_id="core" version_id="2.0.5dev2" var_name="try_again_in_1_second" added="1275106549">Try again in 1 second.</phrase>
		<phrase module_id="core" version_id="2.0.5dev2" var_name="setting_global_genders" added="1275182678"><![CDATA[<title>Genders</title><info>This setting controls the genders used on this community. To add a new gender you need to populate it with 3 values separated by a pipe "|" (without quotes). Use the default Male and Female genders we provide as examples.
 The first value needs to be a unique numerical ID number. For Male and Female we use the numbers 1 and 2. We advice to go upwards from there. The 2nd field needs to be a phrase that you must first add using our language manager. Once you add a phrase it gives you several examples on how to use the phrase. We will be using the "Text" method, which is basically the variable name of the phrase and how we will connect to this specific word. So the 2nd value needs to be a phrase that identifies this gender. For Male and Female we used his and her. The 3rd value identifies the gender and must also be a phrase much like the 2nd value. For male and female we used Male and Female to populate this value.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.5dev2" var_name="all" added="1275184041">All</phrase>
		<phrase module_id="core" version_id="2.0.6" var_name="time_separator" added="1284989757"><![CDATA[&nbsp;&nbsp;at&nbsp;&nbsp;]]></phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="setting_phpfox_total_users_online_mark" added="1287501316"><![CDATA[<title>Info on Total Users Online</title><info>Info on Total Users Online</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="setting_phpfox_total_users_online_history" added="1287579364"><![CDATA[<title>Info on Total Users Online History</title><info>Info on Total Users Online History</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="your_website_has_surpassed_its_limit_on_how_many_active" added="1287591667">Your website has surpassed its limit on how many active users you can have online at once. Below you will find a log of how many users you had and a time stamp of when it happened. We advice for you to upgrade your account so you do not encounter these interruptions in the future.</phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="limit_warning" added="1287591678">Limit Warning</phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="online_usage_log" added="1287591694">Online Usage Log</phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="timestamp" added="1287591706">Timestamp</phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="users" added="1287591715">Users</phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="setting_phpfox_is_hosted" added="1287591800"><![CDATA[<title>Hosted</title><info>Hosted</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="setting_phpfox_max_users_online" added="1287591837"><![CDATA[<title>Max Users Online</title><info>Max Users Online</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="saving" added="1288182996">Saving...</phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="loading_text_editor" added="1288281231">Loading text editor</phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="setting_enabled_edit_area" added="1288349480"><![CDATA[<title>Use Edit Area</title><info>Enable this to use <a href="http://www.cdolivet.com/index.php?page=editArea">EditArea</a> when editing code (HTML, PHP etc...) within the AdminCP. This feature transforms a conventional form into a code editor.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="setting_group_ip_infodb" added="1289988638"><![CDATA[<title>IP InfoDB</title><info>Free IP address geolocation tools</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.7" var_name="setting_ip_infodb_api_key" added="1289988772"><![CDATA[<title>IP InfoDB API Key</title><info>IP InfoDB is a free IP address geolocation tools we use to find useful information about users based on their IP. Enter your free API key, which you can get <a href="http://ipinfodb.com/register.php">here</a>.</info>]]></phrase>
		<phrase module_id="core" version_id="2.1.0Beta1" var_name="setting_load_jquery_from_google_cdn" added="1292408370"><![CDATA[<title>Load jQuery from Google CDN</title><info>Enabling this option will load jQuery related JavaScript files from Google CDN servers. More information can be found <a href="http://code.google.com/apis/libraries/devguide.html">here</a>.</info>]]></phrase>
		<phrase module_id="core" version_id="2.1.0Beta1" var_name="setting_jquery_google_cdn_version" added="1292408517"><![CDATA[<title>jQuery Version on Google CDN</title><info>Define the version of jQuery that is available on <a href="http://code.google.com/apis/libraries/devguide.html#jquery">Google CDN</a> servers.</info>]]></phrase>
		<phrase module_id="core" version_id="2.1.0Beta1" var_name="setting_jquery_ui_google_cdn_version" added="1292408601"><![CDATA[<title>jQuery UI Version on Google CDN</title><info>Define the version of jQuery UI that is available on <a href="http://code.google.com/apis/libraries/devguide.html#jqueryUI">Google CDN</a> servers.</info>]]></phrase>
		<phrase module_id="core" version_id="2.1.0Beta1" var_name="setting_friends_only_community" added="1293613541"><![CDATA[<title>Friends Only Community</title><info>By enabling this option certain sections (eg. Blogs, Photos etc...), will by default only show items from the member and his or her friends list. <b>Note:</b> In order for this to work you must enable the option <b>Section Privacy Item Browsing
</b></info>]]></phrase>
		<phrase module_id="core" version_id="2.1.0Beta1" var_name="setting_site_wide_ajax_browsing" added="1294768580"><![CDATA[<title>Site Wide AJAX Browsing</title><info>By enabling this option users will be able to browse certain areas on the site using AJAX. By using AJAX we only load the required data for the specific page to be displayed. This saves bandwidth and can greatly improve your servers overall performance due to the reduced number of requests to your servers.</info>]]></phrase>
		<phrase module_id="core" version_id="3.0.0Beta1" var_name="setting_section_privacy_item_browsing" added="1295254530"><![CDATA[<title>Section Privacy Item Browsing</title><info>Enabling this option will allow users to browse certain sections that allow privacy settings. By default we only display public items in what we call sections (eg. Blogs, Polls, Albums etc...). With this option enabled we will display items to the user that is viewing it based on the items privacy setting. Note that this option requires a load balanced server and in many cases several SQL servers just to support this sort of query on an active community.</info>]]></phrase>
		<phrase module_id="core" version_id="3.0.0Beta1" var_name="setting_date_field_order" added="1302345875"><![CDATA[<title>Calendar Date Format</title><info>The format for parsed and displayed dates. 
MDY = Month/Day/Year
DMY = Day/Month/Year
YMD = Year/Month/Day</info>]]></phrase>
		<phrase module_id="core" version_id="3.0.0Beta1" var_name="setting_use_jquery_datepicker" added="1302348657"><![CDATA[<title>Use Datepicker</title><info>Set this to "TRUE" to use a Datepicker on all areas that require users to select a date.</info>]]></phrase>
		<phrase module_id="core" version_id="2.0.8" var_name="name" added="1294829089">Name</phrase>
		<phrase module_id="core" version_id="2.0.8" var_name="in_queue" added="1294829175">In queue</phrase>
		<phrase module_id="core" version_id="2.0.8" var_name="more_queued_than_allowed" added="1296557912">Please only select {iQueueLimit} files</phrase>
		<phrase module_id="core" version_id="2.0.8" var_name="stopped" added="1297081376">Stopped</phrase>
		<phrase module_id="core" version_id="2.0.8" var_name="manage_activity_points" added="1297418856">Manage Activity Points</phrase>
		<phrase module_id="core" version_id="2.0.8" var_name="multiple_selection" added="1297678709">Multiple Selection</phrase>
		<phrase module_id="core" version_id="2.0.8" var_name="radio" added="1297688811">Radio</phrase>
		<phrase module_id="core" version_id="2.0.8" var_name="checkbox" added="1297690696">Checkbox</phrase>
		<phrase module_id="core" version_id="2.1.0beta2" var_name="setting_cdn_amazon_https" added="1301318031"><![CDATA[<title>Enable HTTPS Support</title><info>Set this to TRUE if a user is on a secure page to use HTTPS with Amazon S3 items. Note you will need to create your own certificate to work with Amazon S3 as they do not provide support for this by default.</info>]]></phrase>
		<phrase module_id="core" version_id="2.1.0rc1" var_name="upload_problems" added="1301568603"><![CDATA[Upload problems? Try the <a href="{link}">basic uploader</a> (works on older computers and web browsers).]]></phrase>
		<phrase module_id="core" version_id="3.0.0beta1" var_name="user_setting_can_design_dnd" added="1308659242">Can members of this user group enable the site designer to drag and drop blocks all around the site? (These changes affect the entire site and this feature is targeted to site administrators)</phrase>
		<phrase module_id="core" version_id="3.0.0Beta1" var_name="menu_core_create_a_list_a441eadc1389cdf0ffe6c4f8babdd66e" added="1310027894">Create a List</phrase>
		<phrase module_id="core" version_id="3.0.0beta1" var_name="setting_twitter_consumer_key" added="1312530940"><![CDATA[<title>Consumer Key</title><info>Enter your Twitter consumer key.</info>]]></phrase>
		<phrase module_id="core" version_id="3.0.0beta1" var_name="setting_twitter_consumer_secret" added="1312530982"><![CDATA[<title>Consumer Secret</title><info>Enter your Twitter consumer secret.</info>]]></phrase>
		<phrase module_id="core" version_id="3.0.0beta3" var_name="setting_allow_html_in_activity_feed" added="1315510132"><![CDATA[<title>Allow HTML in Activity Feed</title><info>If you enable this option it will allow HTML in the activity feed and any comments connected to the feed.</info>]]></phrase>
		<phrase module_id="core" version_id="3.0.0beta3" var_name="setting_disable_hash_bang_support" added="1316512962"><![CDATA[<title>AJAX Browsing - Disable Hash-Bang URL</title><info>If you have "Site Wide AJAX Browsing" enabled we provide support for a function provided with HTML5 that allows the changing of the URL path without actually reloading the page. For browsers that do not have support for this function we use a fallback hash-bang URL. If you do not want to allow the usage of hash-bang URL's enable this option and for browsers that do not have HTML 5 support will not be able to use your sites AJAX browsing functionality. Currently all IE browsers do not have support for this HTML5 function so they by default use the fallback method.</info>]]></phrase>
		<phrase module_id="core" version_id="3.0.0beta3" var_name="search_dot" added="1316530308">Search...</phrase>
		<phrase module_id="core" version_id="3.0.0beta4" var_name="account_info" added="1316617438">Account Info</phrase>
		<phrase module_id="core" version_id="3.0.0beta4" var_name="edit_profile" added="1316617464">Edit Profile</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="add_new_block" added="1319115055">Add New Block</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="disable_dnd" added="1319115062">Disable DnD</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="dnd_mode" added="1319115071">DnD Mode</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="back" added="1319115084">Back</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="home" added="1319115090">Home</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="add" added="1319115104">Add</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="log_back_in_as_global_full_name" added="1319115155">Log back in as {global_full_name}</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="edit_page" added="1319115170">Edit Page</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="login_as_page" added="1319115182">Login as Page</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="enable_dnd_mode" added="1319115195">Enable DnD Mode</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="disable_dnd_mode" added="1319115201">Disable DnD Mode</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="view_more" added="1319187654">View More</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="displaying_of_total" added="1319187677">{displaying} of {total}</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="select_all" added="1319187767">Select All</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="un_select_all" added="1319187776">Un-Select All</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="with_selected" added="1319187786">With Selected</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="clear_all_selected" added="1319187794">Clear All Selected</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="all_time" added="1319188240">All Time</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="this_month" added="1319188247">This Month</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="this_week" added="1319188256">This Week</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="upcoming" added="1319188270">Upcoming</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="sort" added="1319456633">Sort</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="show" added="1319456639">Show</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="when" added="1319456645">When</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="align_left" added="1319463778">Align Left</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="align_center" added="1319463786">Align Center</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="align_right" added="1319463793">Align Right</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="bullets" added="1319463800">Bullets</phrase>
		<phrase module_id="core" version_id="3.0.0beta5" var_name="ordered_list" added="1319463807">Ordered List</phrase>
		<phrase module_id="core" version_id="3.0.0rc1" var_name="setting_display_older_ie_error" added="1320238795"><![CDATA[<title>IE8 or Higher Requirement Check</title><info>By default the script requires IE8 or higher. We will show users a notice if they are using an older version and a link to upgrade their browser. Disable this if you do not want to show a warning.</info>]]></phrase>
		<phrase module_id="core" version_id="3.0.0rc1" var_name="ie8_or_higher_warning" added="1320238851"><![CDATA[You seem to be using an older version of Internet Explorer. This site requires Internet Explorer 8 or higher. Update your browser <a href="http://www.microsoft.com/ie/" target="_blank">here</a> today to fully enjoy all the marvels of this site.]]></phrase>
		<phrase module_id="core" version_id="3.0.0rc2" var_name="himself" added="1321362953">himself</phrase>
		<phrase module_id="core" version_id="3.0.0rc2" var_name="herself" added="1321362973">herself</phrase>
		<phrase module_id="core" version_id="3.0.0" var_name="said" added="1322462984">said...</phrase>
		<phrase module_id="core" version_id="3.0.0" var_name="loading" added="1322465330">Loading</phrase>
		<phrase module_id="core" version_id="3.0.1" var_name="setting_disable_ie_warning" added="1327406336"><![CDATA[<title>Disable IE Warning</title><info>We display a warning for those that use Internet Explorer 7 or lower. Enable this setting if you do not want to display this warning.</info>]]></phrase>
		<phrase module_id="core" version_id="3.1.0beta1" var_name="setting_cdn_service" added="1330603751"><![CDATA[<title>CDN Service</title><info>Select what CDN service you would like to use.</info>]]></phrase>
		<phrase module_id="core" version_id="3.1.0rc1" var_name="setting_enable_amazon_expire_urls" added="1332254480"><![CDATA[<title>Enable Amazon Expiring URLs</title><info>If this setting is enabled and "Amazon Expire Timeout" is higher than zero, all paths to images taken from Amazon S3 will include a signature set to expire.<br />
If this setting is enabled images uploaded to S3 will be set to private. If this setting is later disabled those images will remain private and they will not show on your site until you manually revert their privacy.</info>]]></phrase>
		<phrase module_id="core" version_id="3.1.0rc1" var_name="setting_amazon_s3_expire_url_timeout" added="1332254771"><![CDATA[<title>Amazon Expire Timeout</title><info>How many seconds will the urls to the images be valid for.</info>]]></phrase>
		<phrase module_id="core" version_id="3.2.0beta1" var_name="site_statistics" added="1334318165">Site Statistics</phrase>
		<phrase module_id="core" version_id="3.2.0beta1" var_name="setting_official_launch_of_site" added="1334320691"><![CDATA[<title>Official Launch Date (Month/Day/Year)</title><info>This is the day your site was launched. It is used to create statistics for the site to build daily averages. The format is <b>Month/Day/Year</b>.</info>]]></phrase>
		<phrase module_id="core" version_id="3.2.0beta1" var_name="total" added="1334581180">Total</phrase>
		<phrase module_id="core" version_id="3.2.0beta1" var_name="daily_average" added="1334581190">Daily Average</phrase>
		<phrase module_id="core" version_id="3.2.0beta1" var_name="building_site_stats_please_hold" added="1334581202">Building site stats. Please hold...</phrase>
		<phrase module_id="core" version_id="3.2.0rc1" var_name="setting_use_md5_for_file_names" added="1334918381"><![CDATA[<title>Use MD5 for File Names</title><info>If enabled the script will use an md5 hash for the file names of every uploaded file.

If you disable it extra checks will be added to try to preserve the original name of the file. If an item with the same name already exists the new one will have a number added at the end.</info>]]></phrase>
		<phrase module_id="core" version_id="3.3.0beta1" var_name="setting_no_follow_on_external_links" added="1336977764"><![CDATA[<title>Add rel="nofollow" on External Links</title><info>If enabled this feature provides a way for webmasters to tell search engines to not follow any external links.</info>]]></phrase>
		<phrase module_id="core" version_id="3.3.0beta1" var_name="setting_rackspace_username" added="1339346243"><![CDATA[<title>Rackspace Username</title><info>Enter your Rackspace username.</info>]]></phrase>
		<phrase module_id="core" version_id="3.3.0beta1" var_name="setting_rackspace_key" added="1339346279"><![CDATA[<title>Rackspace API Key</title><info>Enter your Rackspace API key.</info>]]></phrase>
		<phrase module_id="core" version_id="3.3.0beta1" var_name="setting_rackspace_container" added="1339346351"><![CDATA[<title>Rackspace Container</title><info>Enter your Rackspace container.</info>]]></phrase>
		<phrase module_id="core" version_id="3.3.0beta1" var_name="setting_rackspace_url" added="1339349782"><![CDATA[<title>Rackspace Container URL</title><info>Enter your Rackspace Container URL.</info>]]></phrase>
		<phrase module_id="core" version_id="3.3.0beta2" var_name="mobile_search" added="1340276312">Search...</phrase>
		<phrase module_id="core" version_id="3.3.0rc1" var_name="error" added="1341560923">Error</phrase>
		<phrase module_id="core" version_id="3.4.0beta1" var_name="user_setting_can_gift_points" added="1345646843">Can members of this user group gift activity points?</phrase>
		<phrase module_id="core" version_id="3.4.0beta1" var_name="purchase" added="1347865347">Purchase</phrase>
		<phrase module_id="core" version_id="3.4.0beta1" var_name="fromrow_torow_of_totalrows_results" added="1347881796">{fromRow}-{toRow} of {totalRows} Results</phrase>
		<phrase module_id="core" version_id="3.4.0rc1" var_name="gift_sent_successfully" added="1349857067">Gift sent successfully</phrase>
		<phrase module_id="core" version_id="3.4.0rc1" var_name="you_are_about_to_gift_activity_points" added="1349857399"><![CDATA[You are about to gift activity points to the user <strong>{full_name}</strong>. These points will be taken from your activity points. <br />	At this moment you have <strong>{current}</strong> points available to gift.]]></phrase>
		<phrase module_id="core" version_id="3.4.0rc1" var_name="you_only_have_one_point_available" added="1349857434">You only have one point available, do you want to give it away to {full_name}?</phrase>
		<phrase module_id="core" version_id="3.4.0rc1" var_name="gift_points" added="1349857455">Gift Points</phrase>
		<phrase module_id="core" version_id="3.4.0rc1" var_name="how_many_points_do_you_want_to_gift_away" added="1349857462">How many points do you want to gift away?</phrase>
		<phrase module_id="core" version_id="3.4.0rc1" var_name="unfortunately_you_do_not_have_enough_points_to_gift_away" added="1349857479">Unfortunately you do not have enough points to gift away, but you can earn more points by being more active in the site.</phrase>
		<phrase module_id="core" version_id="3.5.0beta1" var_name="setting_keep_files_in_server" added="1353415860"><![CDATA[<title>Keep Files In Server</title><info>Set this to TRUE to keep original files on the server.</info>]]></phrase>
		<phrase module_id="core" version_id="3.5.0beta1" var_name="setting_google_api_key" added="1353588797"><![CDATA[<title>Google API Key</title><info>Google offers many services that require an API key (like the Places service), enter your Google API key here.

More information on how to get an API key can be found <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">here</a>.</info>]]></phrase>
		<phrase module_id="core" version_id="3.5.0" var_name="setting_activity_feed_line_breaks" added="1361864310"><![CDATA[<title>Activity Feed Line Breaks</title><info>This feature controls how many line breaks to show in activity feed posts and comments. To enable this feature simply add a number higher than 0.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_include_master_files" added="1371725536"><![CDATA[<title>JS/CSS Include Master Files</title><info>This setting is designed to create 1 JS and 1 CSS master file so it would only be loaded once by the browser. Then when a user visits a page it will load another file that is specific to that page only. The file will be a lot smaller since it does not have any of the master data.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_defer_loading_user_images" added="1371725698"><![CDATA[<title>Defer Profile Images</title><info>Load profile images after the site has loaded.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_defer_loading_images" added="1371725751"><![CDATA[<title>Defer Photos</title><info>Load photos from the Photo module after the site has loaded.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_keep_non_square_images" added="1371726679"><![CDATA[<title>Keep Non Square Images</title><info>By default we create 2 thumbnails for each image. One keeps the original aspect ratio and the other is a fixed square image. With our current themes we only use the fixed square images. The original aspect ratio images are not really needed and disabling this feature is advised.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_controllers_to_load_delayed" added="1371726829"><![CDATA[<title>Load sections via AJAX</title><info>You can define an array of controllers that will be loaded after the site has been loaded via AJAX.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_super_cache_system" added="1371727047"><![CDATA[<title>Global Caching</title><info>Global caching setting. Enable to turn on caching system on several areas. Drops database queries.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_store_only_users_in_session" added="1371732076"><![CDATA[<title>Only Users in Session Table</title><info>Only store users in the session table. Keeps bots and guests out from this table.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_push_jscss_to_cdn" added="1371732268"><![CDATA[<title>Upload CSS/JS to CDN</title><info>Upload minified CSS/JS to CDN if minified files is enabled. Note you will still need to manually upload your themes images. This only works for CSS and JavaScript files.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_include_site_title_all_pages" added="1371732664"><![CDATA[<title>Remove Site Title</title><info>Removes site title on all pages other then the index page and if a page has no title. This is to assist with duplicate content.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_force_404_check" added="1371732723"><![CDATA[<title>Force 404 Check</title><info>Enable to force 404 checks on sub-pages that do not exist. This works in selective sections.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_enable_html_purifier" added="1371733020"><![CDATA[<title>HTML PURIFIER</title><info>If enabled we will use a 3rd party library to assist in parsing content submitted by your users. Only enable this if you allow HTML on your site. To learn more about this product check out:
http://htmlpurifier.org/

You can find additional settings in the file:
include/setting/htmlpurifier.sett.php.new</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_group_security" added="1371733071"><![CDATA[<title>Security</title><info>Manage security settings for your site.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_force_secure_site" added="1371733146"><![CDATA[<title>Force HTTPS for Logged In Users</title><info>Enable to make all connections secure when a user is logged in. <b>Notice:</b> Your server must have HTTPS support.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_use_custom_cookie_names" added="1371733182"><![CDATA[<title>Custom Cookie Names</title><info>Enable to use custom cookie names</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_custom_cookie_names_hash" added="1371733247"><![CDATA[<title>Custom Cookie Name Unique Salt</title><info>Create your own unique cookie name salt.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_protect_admincp_with_ips" added="1371733289"><![CDATA[<title>AdminCP IP Access</title><info>Allow access to the AdminCP if an IP is added to this list. Comma separated.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_auth_user_via_session" added="1371733504"><![CDATA[<title>Authenticate Users via Database Session Log</title><info>If you enable this option we will authenticate users via a database session log.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_include_ip_sub_id_hash" added="1371733576"><![CDATA[<title>User IP Substring in ID Hash</title><info>Enable to include a users IP substring in the ID hash. This makes it much harder for users to hijack another users session.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_id_hash_salt" added="1371733619"><![CDATA[<title>Unique Salt for ID Hash</title><info>Create your own unique hash for the authenticating ID hash.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_check_body_for_text" added="1371733697"><![CDATA[<title>HTML Body Check</title><info>Enable to check HTML body for specific text.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_check_body_regex" added="1371733742"><![CDATA[<title>HTML Body Check REGEX</title><info>Add your custom REGEX to check the HTML body.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_check_body_offline_message" added="1371733838"><![CDATA[<title>HTML Body Check Failed Message</title><info>If the REGEX check fails, add a message we should display.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_check_body_header" added="1371733888"><![CDATA[<title>HTML Body Check Failed Response</title><info>Custom header to send the browser in case the HTML body check REGEX fails.</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_html_purifier_allowed_html" added="1371734080"><![CDATA[<title>HTML PURIFIER Allowed HTML</title><info>Comma separated list of HTML elements and attributes HTML Purifier should allow.

To learn more on how this setting works check out:
http://htmlpurifier.org/live/configdoc/plain.html#HTML.Allowed</info>]]></phrase>
		<phrase module_id="core" version_id="3.6.0rc1" var_name="setting_html_purifier_allowed_iframes" added="1371734180"><![CDATA[<title>HTML PURIFIER Allowed IFRAMES REGEX</title><info>REGEX of sites HTML Purifier should allow when users use HTML IFRAMES.</info>]]></phrase>
		<phrase module_id="core" version_id="3.7.0beta1" var_name="setting_city_in_registration" added="1373891053"><![CDATA[<title>City in Registration</title><info>Enable this setting to allow visitors to enter their city when they are creating their account.</info>]]></phrase>
		<phrase module_id="core" version_id="3.7.0beta1" var_name="original_url" added="1374048801">Original URL</phrase>
		<phrase module_id="core" version_id="3.7.0beta1" var_name="replacement_url" added="1374048834">Replacement URL</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="text" added="1392649453">Text</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="top_left" added="1392649827">top left</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="bottom_left" added="1392649851">bottom left</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="bottom_right" added="1392649867">bottom right</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="top_right" added="1392649881">top right</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="rackspace" added="1392650017">Rackspace</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="phpfox" added="1392650024">PHPFox</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="s3" added="1392650034">Amazon S3</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="tiny_mce" added="1392650096">TinyMCE</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="default" added="1392650104">Default</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="level_0" added="1392650441">Level 0</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="level_1" added="1392650455">Level 1</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="level_2" added="1392650461">Level 2</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="level_3" added="1392650469">Level 3</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="mail" added="1392650630">mail</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="smtp" added="1392650636">smtp</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="medium" added="1392735559">medium</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="high" added="1392735577">high</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="low" added="1392735581">low</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="mdy" added="1392813730">MDY</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="dmy" added="1392813736">DMY</phrase>
		<phrase module_id="core" version_id="3.7.5" var_name="ymd" added="1392813745">YMD</phrase>
	</phrases>
	<pages>
		<page module_id="core" is_phrase="1" has_bookmark="0" parse_php="1" add_view="0" full_size="1" title="core.about" title_url="about" added="1231338597">
			<keyword></keyword>
			<description></description>
			<text>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla justo consectetur velit. Morbi volutpat. Nam et nibh. Sed nec metus vitae libero luctus cursus. Nulla facilisi. Duis at orci ut mauris imperdiet mattis. Integer quam enim, feugiat at, sagittis at, venenatis in, lacus. Phasellus at tellus. Praesent orci justo, malesuada ac, pulvinar sed, iaculis non, leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam eget quam. Nunc sed velit. Phasellus quis nisi. In nisi nisi, suscipit ut, lobortis non, vestibulum quis, sapien. Cras nisl. Proin tristique. Duis ac diam nec ante convallis elementum. Quisque eget purus.

Quisque mauris orci, feugiat et, ornare vitae, adipiscing tempus, metus. Nam tincidunt. Donec arcu. Sed augue risus, faucibus eu, laoreet sit amet, interdum eget, odio. Aliquam faucibus libero sed lorem. Nulla erat. Donec sapien dui, rutrum ac, pharetra id, fermentum sed, arcu. Donec elementum vulputate lectus. Nam vitae risus. Suspendisse semper consectetur nulla. Morbi mattis justo a mauris. Nam vel felis ac velit pharetra rhoncus. Praesent faucibus odio tincidunt massa. Etiam adipiscing libero vel erat. Vestibulum arcu. Donec convallis quam non lectus.</text>
			<text_parsed><![CDATA[<?php /* Cached: December 15, 2009, 4:39 pm */ ?>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla justo consectetur velit. Morbi volutpat. Nam et nibh. Sed nec metus vitae libero luctus cursus. Nulla facilisi. Duis at orci ut mauris imperdiet mattis. Integer quam enim, feugiat at, sagittis at, venenatis in, lacus. Phasellus at tellus. Praesent orci justo, malesuada ac, pulvinar sed, iaculis non, leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam eget quam. Nunc sed velit. Phasellus quis nisi. In nisi nisi, suscipit ut, lobortis non, vestibulum quis, sapien. Cras nisl. Proin tristique. Duis ac diam nec ante convallis elementum. Quisque eget purus.
<br class="pf_break" />
<br class="pf_break" />Quisque mauris orci, feugiat et, ornare vitae, adipiscing tempus, metus. Nam tincidunt. Donec arcu. Sed augue risus, faucibus eu, laoreet sit amet, interdum eget, odio. Aliquam faucibus libero sed lorem. Nulla erat. Donec sapien dui, rutrum ac, pharetra id, fermentum sed, arcu. Donec elementum vulputate lectus. Nam vitae risus. Suspendisse semper consectetur nulla. Morbi mattis justo a mauris. Nam vel felis ac velit pharetra rhoncus. Praesent faucibus odio tincidunt massa. Etiam adipiscing libero vel erat. Vestibulum arcu. Donec convallis quam non lectus.]]></text_parsed>
		</page>
		<page module_id="core" is_phrase="1" has_bookmark="0" parse_php="1" add_view="0" full_size="1" title="core.privacy_policy" title_url="policy" added="1231339063">
			<keyword></keyword>
			<description></description>
			<text><![CDATA[<div class="item_view_content">
<ul>
<li>Coffee</li>
<li>Milk</li>
</ul>

<ol>
<li>Coffee</li>
<li>Milk</li>
</ol>
</div>

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla justo consectetur velit. Morbi volutpat. Nam et nibh. Sed nec metus vitae libero luctus cursus. Nulla facilisi. Duis at orci ut mauris imperdiet mattis. Integer quam enim, feugiat at, sagittis at, venenatis in, lacus. Phasellus at tellus. Praesent orci justo, malesuada ac, pulvinar sed, iaculis non, leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam eget quam. Nunc sed velit. Phasellus quis nisi. In nisi nisi, suscipit ut, lobortis non, vestibulum quis, sapien. Cras nisl. Proin tristique. Duis ac diam nec ante convallis elementum. Quisque eget purus.

Quisque mauris orci, feugiat et, ornare vitae, adipiscing tempus, metus. Nam tincidunt. Donec arcu. Sed augue risus, faucibus eu, laoreet sit amet, interdum eget, odio. Aliquam faucibus libero sed lorem. Nulla erat. Donec sapien dui, rutrum ac, pharetra id, fermentum sed, arcu. Donec elementum vulputate lectus. Nam vitae risus. Suspendisse semper consectetur nulla. Morbi mattis justo a mauris. Nam vel felis ac velit pharetra rhoncus. Praesent faucibus odio tincidunt massa. Etiam adipiscing libero vel erat. Vestibulum arcu. Donec convallis quam non lectus.]]></text>
			<text_parsed><![CDATA[<?php /* Cached: April 24, 2013, 9:45 am */ ?>
<div class="item_view_content">
<ul>
<li>Coffee</li>
<li>Milk</li>
</ul>

<ol>
<li>Coffee</li>
<li>Milk</li>
</ol>
</div>

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla justo consectetur velit. Morbi volutpat. Nam et nibh. Sed nec metus vitae libero luctus cursus. Nulla facilisi. Duis at orci ut mauris imperdiet mattis. Integer quam enim, feugiat at, sagittis at, venenatis in, lacus. Phasellus at tellus. Praesent orci justo, malesuada ac, pulvinar sed, iaculis non, leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam eget quam. Nunc sed velit. Phasellus quis nisi. In nisi nisi, suscipit ut, lobortis non, vestibulum quis, sapien. Cras nisl. Proin tristique. Duis ac diam nec ante convallis elementum. Quisque eget purus.

Quisque mauris orci, feugiat et, ornare vitae, adipiscing tempus, metus. Nam tincidunt. Donec arcu. Sed augue risus, faucibus eu, laoreet sit amet, interdum eget, odio. Aliquam faucibus libero sed lorem. Nulla erat. Donec sapien dui, rutrum ac, pharetra id, fermentum sed, arcu. Donec elementum vulputate lectus. Nam vitae risus. Suspendisse semper consectetur nulla. Morbi mattis justo a mauris. Nam vel felis ac velit pharetra rhoncus. Praesent faucibus odio tincidunt massa. Etiam adipiscing libero vel erat. Vestibulum arcu. Donec convallis quam non lectus.]]></text_parsed>
		</page>
		<page module_id="core" is_phrase="1" has_bookmark="0" parse_php="1" add_view="0" full_size="1" title="core.terms_use" title_url="terms" added="1232964954">
			<keyword></keyword>
			<description></description>
			<text>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque id ipsum nisl. Nam vitae ligula turpis, vel egestas turpis. Curabitur condimentum metus ac ligula pulvinar volutpat. Nullam mollis nulla eu ligula volutpat pellentesque. Pellentesque sit amet nisl metus, et placerat elit. Mauris ac justo est, at malesuada mauris. Etiam auctor pharetra mollis. Vivamus lobortis, sem sit amet porta suscipit, augue libero consectetur justo, a sollicitudin risus eros et est. Vivamus eget lectus tellus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean vel ullamcorper mauris.

Ut non consequat risus. Phasellus eget ligula vel enim pretium volutpat. Phasellus rutrum porttitor lorem. In accumsan pharetra sapien, in porta augue accumsan a. Fusce pellentesque egestas euismod. Donec porta dapibus urna eu varius. Pellentesque aliquet dapibus turpis, ut sollicitudin elit convallis eget. Curabitur ornare, sapien nec rhoncus bibendum, lacus libero tristique dui, in interdum massa purus ut quam. Morbi est turpis, feugiat non porttitor sed, adipiscing sed ligula.

Quisque ac tempus ipsum. Praesent tempus convallis enim in suscipit. Nulla eu ipsum nec nisl tempus vestibulum. Fusce rutrum placerat tortor, vel ultricies sem ultrices sit amet. Proin elementum convallis neque eu sodales. Vivamus turpis massa, sodales sed volutpat consequat, feugiat non ante. Phasellus vel blandit nunc. Quisque nec ligula orci. Proin luctus interdum diam eu mattis. Maecenas nec posuere nunc. Duis a purus lacus. Quisque sit amet enim lacus. Praesent molestie, arcu id pharetra sollicitudin, est diam mattis erat, vel volutpat mauris ante nec lorem. In eget posuere sapien.

Donec felis tellus, adipiscing viverra volutpat vel, luctus sed felis. Morbi ultricies ante in mauris ultrices ullamcorper. Vivamus justo est, suscipit eget convallis quis, dapibus nec lacus. Maecenas vel urna ac lacus adipiscing molestie nec id quam. Aliquam faucibus rutrum nisl, vitae faucibus felis tincidunt eget. Aliquam sit amet varius augue. In elementum sodales sapien id laoreet. Ut mattis laoreet neque, quis tincidunt leo mattis sed.

Cras lacinia elementum auctor. Proin ante lacus, lobortis viverra tincidunt vitae, ullamcorper in nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus condimentum gravida lorem, eget lacinia mauris sodales eu. Suspendisse odio orci, congue sit amet elementum sed, vulputate in massa. Ut eget nisl metus, et adipiscing augue. Proin egestas porta arcu vitae feugiat. Donec et lacus tortor. Aliquam ornare velit tempor urna consectetur laoreet. Quisque congue ante vel sem ultricies ullamcorper.

Duis posuere mauris quis turpis ornare lobortis sed quis leo. Morbi rhoncus lorem ac erat porttitor consectetur. Nullam condimentum libero sit amet sapien hendrerit placerat. Quisque at neque at turpis gravida hendrerit placerat quis neque. Sed dictum ipsum nisi, non placerat nisi. Cras elementum, eros at tempus tristique, lectus mi scelerisque tortor, sit amet pretium odio turpis sed risus. Vestibulum rutrum commodo porta. Phasellus sagittis mattis pretium. Curabitur in auctor libero. Curabitur rutrum dignissim ipsum et scelerisque. Nullam fermentum vehicula lectus eget tristique. Duis lacus nisl, ultricies vel fringilla at, iaculis a risus. Maecenas in eleifend massa.

Nunc sit amet lorem turpis, sed gravida ante. Duis semper, nunc in condimentum imperdiet, eros tellus scelerisque lectus, vitae viverra justo libero a justo. In magna justo, blandit sed commodo non, porta ac urna. Vivamus in lacus mi, at scelerisque tortor. Nullam velit felis, convallis sit amet ullamcorper ut, consequat ut lacus. Aenean id porta lectus. Maecenas rutrum ante justo. Mauris dapibus adipiscing elementum. Fusce imperdiet neque dignissim ipsum sagittis fermentum. Nulla facilisi.

Duis convallis tempus felis, eget sodales orci euismod sit amet. Ut at velit ipsum. Donec id nisl at turpis mollis rutrum. Vivamus faucibus, ipsum volutpat lacinia tincidunt, justo dui elementum felis, faucibus bibendum nibh nisi nec nulla. Mauris nisi arcu, dignissim non ultrices quis, ultricies rhoncus leo. Suspendisse varius volutpat odio euismod rhoncus. In ac sem vel nisl convallis varius. Nullam nisi erat, accumsan nec porta vel, blandit at leo. Mauris eu lorem laoreet sem faucibus auctor. Praesent viverra, enim id feugiat tincidunt, eros urna dapibus enim, vel adipiscing eros felis et neque. Nulla eu cursus velit. Ut at tellus nunc, eget feugiat erat. Ut nec magna blandit risus ornare vulputate a eget diam.

Aenean posuere, purus ac cursus pulvinar, turpis eros condimentum sem, sit amet pulvinar purus lacus ut velit. Nulla tristique vestibulum nisl, a posuere ante tincidunt a. Fusce porta vestibulum felis, in eleifend sem faucibus eu. Duis bibendum suscipit dolor et mollis. Integer eget nulla eu augue mollis sagittis. Nam vel tempus odio. Nulla facilisi. Duis fermentum tortor vitae risus porta cursus. Morbi ultrices luctus lorem vitae pharetra. Integer pulvinar dui sed erat ultricies vehicula. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum pharetra pharetra ante at pellentesque. Etiam at convallis orci. Duis semper lorem quis ipsum hendrerit et interdum ligula vestibulum.

Praesent accumsan nulla quis arcu ornare iaculis. Vestibulum in enim at arcu malesuada lacinia non sed neque. Maecenas vel velit sed lectus sagittis porttitor non a turpis. Cras eu tortor quis leo dapibus sagittis sed vehicula mauris. In luctus elementum urna sit amet sodales. Aliquam erat volutpat. Mauris sit amet tincidunt ipsum. Nam arcu lorem, vehicula rutrum dignissim non, pellentesque a arcu. Ut nec leo dui, vitae molestie lorem. Nam nisl tellus, tincidunt mollis facilisis ornare, suscipit vel mauris. Morbi pellentesque ullamcorper augue nec vestibulum. Mauris ac ipsum eget nibh tempus consequat id non ante. Etiam ligula magna, posuere a suscipit et, molestie at erat. Integer mi eros, dignissim non posuere eget, convallis ut magna. Proin vestibulum feugiat eros, id tempor dui rutrum non. Aenean auctor congue dignissim.

Cras suscipit felis sit amet urna bibendum vel aliquet nibh tincidunt. Fusce eget velit sed diam interdum fringilla. Fusce mauris massa, pharetra quis vehicula eu, condimentum non neque. Mauris non odio metus. Integer nec purus lacus. Donec elit felis, bibendum in ultrices sed, elementum non arcu. In quis libero at turpis semper egestas. Duis dapibus lectus a urna cursus volutpat. Praesent rutrum imperdiet egestas. Mauris pulvinar lacus sed mauris dictum pellentesque. Suspendisse dictum, risus et pellentesque congue, nisi turpis suscipit nisl, non porta velit magna non ipsum. Etiam eget tellus sit amet sem lobortis mattis in ac nisi.

Donec tristique rhoncus tellus ac pharetra. Nulla pellentesque lorem est, consequat pellentesque erat. Phasellus non nunc a sem egestas pellentesque vitae dapibus augue. Mauris vestibulum, augue ac blandit aliquam, sem justo varius dolor, et condimentum augue magna ac nulla. Ut sed nisl lorem, vel laoreet est. Donec lacus magna, dapibus ac auctor eget, imperdiet non dui. Suspendisse tristique luctus sagittis. Nulla sagittis odio eu felis facilisis suscipit non sed tortor. Nunc nulla sapien, cursus non faucibus et, luctus nec lectus. Integer euismod volutpat dolor suscipit semper. Proin blandit imperdiet tincidunt. Aenean placerat, purus vitae elementum venenatis, nunc libero fringilla mauris, et varius erat ligula eu dolor. Sed purus augue, convallis sit amet bibendum vitae, bibendum et metus. Suspendisse tempus quam ut odio dapibus ac tristique mauris varius. Mauris ut enim vulputate ante viverra interdum. Mauris sed mi ipsum.

Suspendisse quis risus ut eros luctus rhoncus nec et ligula. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper viverra pellentesque. Praesent eros velit, elementum eget feugiat fringilla, interdum eu mauris. Donec nisi ante, lacinia non pellentesque in, accumsan eget mauris. Phasellus suscipit mauris sit amet lectus dapibus dignissim. In sed ullamcorper lectus. Sed sit amet sapien ligula, non venenatis lorem. In turpis ligula, posuere vitae imperdiet eu, aliquet a quam. Nullam accumsan dignissim leo. Cras blandit ultricies pharetra. In eu tortor quis metus cursus placerat. Vestibulum varius euismod nulla, placerat sodales mi viverra id. Aliquam erat volutpat.

Duis eu quam nec metus consequat malesuada. Sed at lectus nisi. Nunc mauris lectus, commodo a condimentum in, commodo eget mi. Quisque vulputate rutrum purus ut lobortis. Curabitur sagittis ligula non magna iaculis id fermentum ante bibendum. Proin mollis ipsum in massa cursus convallis. Cras eleifend fermentum velit, eget vestibulum diam viverra vitae. Praesent purus diam, iaculis interdum tincidunt non, ultrices id mi.

Maecenas gravida, dui id varius egestas, nisi purus feugiat enim, quis semper nunc massa et est. Aliquam convallis ante eros, in posuere erat. Nunc ut sagittis lorem. Ut non cursus sapien. Donec nisl tortor, commodo ut commodo sit amet, volutpat et dui. Maecenas laoreet ligula at augue tincidunt pellentesque tincidunt nulla consectetur. Praesent vestibulum, est ut tincidunt dignissim, urna lectus commodo neque, id aliquam leo risus rhoncus leo. Sed ligula lacus, fringilla vitae mattis a, malesuada non purus. Duis id magna quis tortor consectetur vulputate sit amet id justo. Vestibulum fermentum ligula non quam porta a posuere neque rhoncus. In at purus nunc. Integer ornare vestibulum nisl, a elementum nibh tincidunt in. Duis porta nisl nisi. Sed volutpat pulvinar dui in tempus.

Mauris arcu nisl, sollicitudin ornare scelerisque sit amet, suscipit ut metus. In hac habitasse platea dictumst. Donec porttitor nibh a massa lacinia nec imperdiet lectus eleifend. Quisque ultricies nibh ac sem faucibus mattis. Mauris enim augue, rhoncus et mollis at, congue vitae sapien. Vivamus luctus feugiat euismod. Donec metus libero, tempus vitae posuere non, posuere vitae magna. Sed et nunc orci. Nullam in erat dui. In hac habitasse platea dictumst. Maecenas sollicitudin sapien id augue malesuada porta. Nullam id lorem ac leo feugiat laoreet nec ac orci. In eget nunc enim, quis pretium ante. Nam vestibulum purus ut dolor tristique aliquam.

Vestibulum in enim nisl. In pretium, diam sed lacinia facilisis, augue felis dictum diam, vitae ullamcorper orci odio a nunc. Morbi porttitor, est a aliquam faucibus, urna nulla consequat augue, pulvinar imperdiet purus justo eu augue. Maecenas porta libero quis nulla euismod et cursus lorem ullamcorper. In nulla neque, eleifend vel porttitor id, consequat a neque. Etiam pretium rhoncus sapien, sit amet bibendum nibh adipiscing in. Cras dapibus orci nec neque vehicula vulputate. Curabitur congue, felis lacinia convallis porta, neque turpis eleifend nunc, at scelerisque nibh est sed leo.

Ut id nibh vitae augue facilisis convallis. Sed quis augue lacus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In molestie justo non felis sodales convallis. Maecenas sit amet nisl blandit diam sollicitudin dignissim. Proin imperdiet mattis ante non malesuada. Proin pharetra pharetra justo. Fusce at elit vitae tortor fringilla tincidunt. Nulla ut fringilla mi. Nulla ultrices massa eget odio scelerisque lobortis. Pellentesque a lorem felis. Aenean eget porta urna.

Vestibulum lacinia bibendum lectus, ultrices tempus nibh aliquam et. Phasellus a convallis erat. Quisque mollis, augue nec tincidunt mollis, purus ipsum ullamcorper lorem, quis auctor tortor metus et lectus. In vitae metus nec diam lacinia euismod. Maecenas vitae vulputate risus. Nullam eget quam vel risus malesuada laoreet. Praesent malesuada justo ac augue porttitor sed accumsan elit congue. Nam eget tellus quis est convallis tempus. Vestibulum sit amet lorem a est hendrerit sodales. Sed nec dictum magna. Duis pretium viverra dolor, in rhoncus diam euismod sed. Etiam vitae felis ac justo tincidunt mattis ac nec risus. Vestibulum varius imperdiet turpis sed facilisis. Nullam arcu dolor, aliquam in consectetur sit amet, scelerisque in turpis.

Proin consectetur commodo justo, vitae convallis magna laoreet ut. Nulla eget risus eget velit consequat dignissim. Nunc vitae sem turpis. Morbi vestibulum malesuada ante at rhoncus. Ut faucibus lectus ut sapien tincidunt nec facilisis neque interdum. Quisque velit nulla, ornare et semper nec, scelerisque vitae ipsum. Nullam et pretium erat. Aliquam facilisis tincidunt nunc eu placerat. Mauris cursus dui in risus convallis lobortis. Mauris nec tortor lectus, a laoreet massa. Phasellus a erat metus. Etiam nisl nulla, sollicitudin a iaculis ut, tristique quis augue. Suspendisse dui est, ullamcorper id porta ac, aliquam quis erat.

Nullam venenatis varius laoreet. Donec pellentesque justo at quam facilisis mattis fringilla risus sagittis. Cras dui ante, sollicitudin faucibus lobortis a, interdum vitae augue. Donec dui felis, viverra a semper nec, gravida sed augue. Nulla justo sem, convallis et porta vitae, placerat ac magna. Nullam a turpis in ipsum hendrerit dictum id at erat. Nullam lacinia iaculis risus, a mattis diam hendrerit in. Suspendisse dictum lobortis iaculis. In vulputate lectus a massa gravida venenatis. Aenean porttitor condimentum posuere.

Nulla facilisi. Praesent vel risus id mauris malesuada vestibulum eget vel ligula. Etiam dapibus ultrices urna, nec auctor turpis aliquam non. Nam erat quam, sagittis nec faucibus in, fringilla vel sapien. Quisque commodo, eros sed elementum rutrum, tortor tortor viverra sem, non egestas augue mauris non libero. Cras tristique tortor et libero vehicula eu venenatis velit pharetra. Donec sagittis ornare libero, et interdum odio volutpat at. Donec non tellus et mauris lacinia pretium vitae in lorem. Nam tellus velit, mollis eget auctor non, luctus a tellus. Suspendisse potenti. Suspendisse posuere metus ipsum.

Proin faucibus, dolor iaculis volutpat viverra, arcu nisi accumsan turpis, nec ultrices nibh nibh a tellus. Nullam a neque id diam lobortis dictum quis lobortis velit. Nunc congue aliquam facilisis. Ut interdum, tortor ut volutpat rutrum, enim nisi tincidunt tortor, ac venenatis libero tortor in erat. Cras at justo ut felis molestie rutrum. Nam justo nunc, vulputate et sollicitudin sed, vestibulum in neque. Nunc laoreet varius nulla.

Nullam eu nisi non lorem fringilla luctus eu ac magna. Nulla rutrum ante eget magna fermentum consequat. Suspendisse hendrerit lacus vulputate turpis dictum lacinia. Nam placerat nisl in ante gravida rutrum. Sed sed eros libero, et tincidunt libero. Duis placerat sollicitudin bibendum. Nullam vitae nulla diam, ac luctus nisi. Ut dictum nunc ac purus semper posuere. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque non ipsum nec risus porttitor sodales. Quisque odio dolor, malesuada quis faucibus at, laoreet semper elit. Nullam ac ipsum eu mauris hendrerit pulvinar eu at magna. Mauris eget ante libero, non porttitor arcu.

Vestibulum accumsan tempus venenatis. Nam massa quam, fermentum vitae aliquam at, vehicula non neque. Phasellus tristique dui at felis euismod porta. Fusce nisl magna, tempor mollis adipiscing sed, convallis at lorem. Suspendisse velit nulla, adipiscing eget gravida ut, sodales ut erat. Nulla facilisi. Etiam et tempus diam. Nam vulputate molestie laoreet.

Sed nunc nulla, suscipit et fermentum ac, tempor sed magna. Donec libero lorem, tristique sit amet commodo vitae, dictum in felis. Proin sem orci, tempor sit amet adipiscing vitae, blandit blandit neque. Quisque eget massa dui, eget mattis turpis. Proin quis tellus vitae felis laoreet laoreet vitae vitae risus. Cras dictum semper vehicula. Integer vitae libero ante.

Fusce vitae metus nulla, sed euismod felis. Nulla pulvinar egestas tincidunt. Nam vehicula malesuada urna, ac fringilla purus euismod quis. Curabitur sed metus eu orci rutrum tincidunt. Nam elementum, nibh in suscipit egestas, ligula dolor fringilla diam, et mollis tortor leo eu urna. Aenean egestas mauris ut arcu gravida vel volutpat felis consectetur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut pretium vulputate felis, sit amet varius lectus pellentesque non.

Nulla facilisi. Nunc ornare tellus non dolor consectetur accumsan. Aenean tincidunt, nibh aliquam interdum bibendum, erat lacus ultrices libero, quis vehicula ligula dolor eget arcu. Sed rhoncus nulla eget justo viverra vitae rutrum nunc porttitor. Proin id neque risus. Maecenas vestibulum purus eget diam ullamcorper vel aliquam lacus imperdiet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla nec libero ac mauris malesuada rutrum sit amet vitae erat. Nam tellus est, tempor ut egestas sit amet, tempor ut lorem. Suspendisse fermentum ornare metus sed tincidunt. Nulla mattis bibendum sapien, ac vehicula lorem mattis in. Maecenas adipiscing elementum consectetur. In vel leo augue, nec tincidunt purus. Sed id gravida massa.

Curabitur eros enim, feugiat sed eleifend quis, fringilla et metus. Quisque lacinia lacus non lorem commodo sed varius tellus cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris egestas consectetur massa, vulputate tincidunt magna vehicula id. Pellentesque eget dolor vel purus semper volutpat eu at nisl. Ut sollicitudin nisi sit amet odio auctor fringilla. Sed eu nisi sed ipsum hendrerit varius. Sed tempus dignissim tincidunt. Curabitur laoreet tortor quis urna tempor fermentum. Ut quis libero vitae nunc cursus hendrerit. Integer et interdum lacus.

Donec ipsum velit, elementum quis porta ut, condimentum non dolor. Phasellus posuere dignissim leo, quis mollis lectus egestas vel. Phasellus adipiscing faucibus dictum. Vestibulum eu felis eros. Maecenas eu sapien turpis. Quisque volutpat aliquam sem laoreet porta. Nam varius feugiat dolor sit amet ornare. Sed vitae viverra velit. Curabitur non turpis nec augue placerat euismod mattis nec nulla. Morbi aliquet nibh nec leo vehicula vulputate. Maecenas vel lacinia est. Curabitur augue elit, fringilla placerat auctor id, luctus quis eros.

Vestibulum ultrices iaculis tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam vel enim dui, et consequat magna. In vitae mi eget magna pulvinar pretium. Etiam quis turpis nunc. Nam eget velit eros. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer nunc elit, semper vel pellentesque et, faucibus ut metus. Nunc mollis dolor quis sem tempor in dictum est scelerisque. Nunc vel risus nisl, vitae bibendum nulla. Suspendisse tellus erat, dignissim imperdiet ultricies ac, malesuada sit amet nunc.

Praesent nec turpis iaculis elit adipiscing semper. In feugiat, odio a tempus fermentum, nisl metus fringilla nulla, interdum fringilla felis odio et mauris. Cras consequat leo sed felis interdum eu mattis enim tristique. Suspendisse vel orci sapien, ut varius odio. Curabitur ut arcu elit. Cras purus ligula, sodales sit amet viverra et, iaculis at augue. Praesent vehicula vulputate porta. Pellentesque lectus mi, ornare ut ultricies eu, elementum sed purus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus laoreet, eros in volutpat fringilla, quam justo suscipit leo, vitae interdum magna nisi vel odio.

Ut fermentum lorem quis ipsum lobortis bibendum. Pellentesque viverra augue vitae libero euismod volutpat. Nullam ac ipsum eget velit fringilla porta hendrerit nec nisl. Nunc vitae sem enim, quis tempor ipsum. Quisque vel diam eu metus blandit sagittis vitae sed eros. Vestibulum placerat elit et magna pretium dignissim. Integer luctus ligula vel dui mollis id porta purus ornare. Suspendisse eget dui mi. Quisque magna felis, volutpat eu posuere non, blandit id leo. Donec vel nisi nisl, eget lacinia odio. Phasellus sit amet massa vitae nibh congue fringilla sed nec felis.

Mauris neque dolor, semper id porta vitae, rhoncus in felis. Proin porttitor, dui a auctor sagittis, nulla dolor interdum lacus, quis auctor nisi erat id nunc. Donec feugiat risus eget magna commodo id malesuada eros mollis. Suspendisse enim lacus, ultrices id malesuada nec, fringilla in augue. Ut ultrices dapibus tortor, sit amet dapibus quam condimentum ac. Aenean et nisi in velit luctus tempor. Integer sed risus justo, vel gravida arcu. Duis eleifend massa a nunc molestie tristique ornare nulla iaculis. Praesent vel nisi ante, id consequat diam.

Nulla facilisi. Duis eros risus, euismod non facilisis et, pharetra eget orci. Praesent ultricies malesuada lectus, semper faucibus nibh ornare eu. Donec condimentum porta mollis. Vivamus sodales aliquet erat sit amet tempor. Nulla non dictum nisl. Suspendisse eleifend metus quis tellus mattis eget vulputate sapien scelerisque. Quisque dui ligula, accumsan cursus imperdiet nec, porttitor sed est.

Donec purus erat, lobortis a convallis eu, euismod volutpat lacus. Pellentesque bibendum egestas ligula, in commodo est congue a. Cras sagittis viverra est, id tristique leo iaculis nec. Donec posuere sollicitudin scelerisque. Cras eros nulla, varius ut sollicitudin non, interdum at metus. Fusce nisi orci, vestibulum sed vehicula at, ullamcorper eget est. Praesent quis tortor orci, nec malesuada dui. Nullam in ipsum vel mauris gravida cursus ac nec erat.

Nulla ut mi vitae quam euismod iaculis. Ut dapibus auctor metus, at feugiat tortor tincidunt vitae. Donec ultricies nulla eget diam faucibus ultrices posuere odio malesuada. Aenean porta dolor sed nibh rhoncus placerat. Nam vestibulum mauris in leo dictum nec volutpat lectus facilisis. Integer tristique condimentum purus, id auctor justo tristique quis. Aenean vitae lorem ac mauris suscipit gravida et quis tellus. Morbi ultricies tempus mauris id commodo. Nullam justo ligula, dictum et suscipit vitae, mollis id nunc. Maecenas lacinia, purus eget tempus pharetra, elit eros mattis felis, vel lacinia sapien massa et ligula. Morbi volutpat bibendum quam sed pulvinar. Etiam a odio mi, sit amet volutpat neque.

Phasellus vel erat non lectus consequat vehicula at a ante. Praesent eu sagittis velit. Fusce eleifend dictum est, eu dapibus velit malesuada non. Nulla at sagittis nisl. Praesent justo tellus, semper eu vehicula vitae, fringilla adipiscing mauris. Praesent enim nulla, cursus eu tincidunt a, venenatis vel sapien. Suspendisse fringilla libero vitae libero eleifend gravida. Sed vitae nisi metus. Proin porttitor porta mattis. Aenean bibendum rhoncus enim rutrum gravida. Proin lobortis sagittis neque in euismod. Mauris ac arcu eu arcu sodales cursus. Sed posuere mauris id metus vulputate tincidunt. Sed sed elit ut est luctus eleifend. Curabitur euismod volutpat mauris, sit amet dapibus ipsum malesuada in.

Aenean at elit orci. Mauris vel orci a nisl rhoncus lobortis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eleifend cursus gravida. Morbi semper, felis vitae condimentum adipiscing, enim diam molestie augue, id rutrum nibh nisi nec dui. Quisque tempus feugiat elit vitae pulvinar. Fusce sit amet lorem sed metus tristique ultricies.

Donec eu mauris elit. Vivamus quis sapien nunc. Nunc ut velit quis magna malesuada gravida non non sapien. Morbi eu neque nibh, ac placerat nulla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin interdum nisi vitae ante ultricies consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.

Vestibulum dictum, nisi vel scelerisque commodo, purus ante accumsan nibh, eget ultrices mauris ipsum eu odio. Nulla facilisi. Etiam ac tincidunt nunc. Praesent sed urna felis. Ut eget tristique tortor. Donec ultrices diam at nisi ultricies placerat. Etiam libero orci, sodales vitae dictum posuere, tempor nec nunc. Praesent pharetra rutrum neque, sed congue tortor pellentesque id. Fusce bibendum turpis non arcu adipiscing ullamcorper non congue libero. In et volutpat felis. Aliquam iaculis dui auctor dolor placerat dapibus. Sed rhoncus erat sed purus tincidunt in mattis massa mattis. Nulla facilisi. Integer viverra rutrum condimentum. Vivamus vitae nibh ac purus dignissim tincidunt et non urna.

Vivamus pellentesque vehicula magna venenatis interdum. Quisque fringilla quam dui. Curabitur lacinia iaculis nisi, sit amet consectetur arcu porta tempus. Suspendisse vel fringilla eros. Mauris non lacus ac felis cursus vestibulum. Maecenas in orci eget risus bibendum viverra. Nunc ac libero at felis vestibulum pulvinar. Morbi non dui ante, in egestas justo. Cras quis ante venenatis nisi molestie tincidunt a euismod tellus. Suspendisse fermentum consectetur urna vel varius. Proin tempor hendrerit leo, a aliquam velit pellentesque tempus. Nunc nulla eros, ultricies sit amet tincidunt in, ornare sodales felis. Maecenas tincidunt, nisi id lacinia convallis, nibh felis bibendum lectus, at mollis orci lectus nec velit.

Duis ut quam vel quam consequat hendrerit tincidunt eget metus. Suspendisse vitae molestie elit. Nunc blandit venenatis leo ut vulputate. Pellentesque tempus fringilla porta. Etiam eget mattis felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi leo sem, commodo eget semper eget, porttitor id leo. Duis pulvinar pulvinar ultricies. Proin laoreet posuere sagittis. Curabitur lectus libero, fringilla et varius ut, sodales sit amet purus. Cras molestie pulvinar magna in malesuada. Nullam tincidunt enim at tellus tempor dignissim. Aliquam et lacus massa.

Mauris arcu neque, bibendum vel porttitor eget, hendrerit at metus. Curabitur porttitor, orci a volutpat tristique, turpis nulla pellentesque tortor, vel mattis libero dui nec velit. Proin aliquam enim sed ligula mollis tristique. Aenean eget urna turpis. Etiam volutpat, massa sed tincidunt eleifend, nulla augue lacinia mauris, quis rhoncus libero erat aliquet est. Fusce vel ipsum mattis quam sagittis interdum. Phasellus ac turpis at justo convallis mollis sit amet sed tortor. Donec ac nunc urna, vitae laoreet mauris. Aenean dolor neque, ultricies eget sodales at, bibendum at erat.

Proin sollicitudin scelerisque orci, at vestibulum magna consectetur et. Pellentesque sit amet ligula dolor. Duis dignissim blandit arcu, a vulputate nisi vehicula at. Sed sit amet velit vel justo pellentesque consequat quis vitae nulla. Nullam ornare tellus nisi. Nunc dignissim magna nisl, sit amet adipiscing turpis. Nulla vel purus vehicula enim dictum aliquam. Donec nisi diam, condimentum eu pharetra nec, ultrices vel lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget turpis sapien, at adipiscing erat. Curabitur sit amet turpis lacus, non pretium nibh. In hac habitasse platea dictumst. Proin sit amet tellus vel nibh pellentesque lobortis. Vivamus dignissim purus suscipit neque eleifend eget faucibus ipsum fringilla. Aenean nec quam lobortis purus aliquam viverra a eu dui.

Nulla adipiscing, dui ac varius accumsan, purus lorem aliquet dui, non porttitor libero leo imperdiet mauris. Mauris eleifend porta risus, sit amet pharetra diam luctus quis. Nunc pellentesque blandit massa, vulputate sagittis magna sagittis a. Nulla sagittis euismod odio ut feugiat. Suspendisse non magna ut nisl congue consequat. Maecenas nisi tortor, tincidunt vel fringilla id, dictum vitae augue. Donec cursus nibh in est volutpat posuere. Ut dolor tortor, elementum a sodales in, consectetur scelerisque sem. Mauris non purus neque. Ut dictum ligula id est venenatis a tincidunt enim vulputate. Nullam imperdiet lobortis lectus, ac viverra tellus facilisis et. In lobortis diam lectus.

Mauris fermentum dapibus urna quis adipiscing. Fusce at lorem lectus. Nullam eu orci justo. Sed orci dolor, congue et suscipit id, elementum sed ante. Phasellus vehicula eros vitae risus interdum pharetra. Nam lectus elit, suscipit in rutrum vel, rhoncus in elit. Nullam dignissim nunc nibh, et aliquet felis. Sed vulputate, ipsum eget facilisis scelerisque, lacus felis feugiat massa, eget interdum nisi sapien eget massa. Vestibulum leo metus, molestie non pulvinar nec, condimentum non diam.

Quisque sagittis commodo molestie. Donec venenatis ante a purus elementum vestibulum. Maecenas laoreet, tortor non dapibus luctus, odio risus mollis risus, sed luctus diam libero eu felis. Suspendisse potenti. Sed vel quam mi, non placerat neque. In hac habitasse platea dictumst. Integer sed neque a arcu elementum semper. Donec vel velit erat. Nunc posuere, nisl semper pellentesque dignissim, quam purus varius urna, at ultrices dui risus in dolor. Vivamus at dui enim, et imperdiet risus. Vestibulum nisi nisi, faucibus sit amet venenatis vitae, pharetra at dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu mauris nulla. Nunc diam erat, placerat at commodo porta, faucibus a turpis. Morbi sodales nisi id ante imperdiet adipiscing.

Fusce metus tellus, luctus placerat vehicula et, fermentum ut sem. Donec ac lorem risus, sit amet lobortis dui. Mauris vel metus ac urna mollis gravida id id justo. Proin id justo felis. Vivamus at vehicula massa. Proin interdum ornare congue. Mauris pellentesque faucibus mi sed vestibulum. Mauris enim sem, vestibulum ut placerat at, rhoncus sit amet metus. Nulla neque dolor, malesuada ac luctus sit amet, imperdiet quis libero. Nunc facilisis erat at turpis vulputate aliquet.

Sed dignissim convallis interdum. Curabitur ligula ligula, lacinia in accumsan at, pharetra tempor sapien. Quisque quis augue ac magna aliquet fermentum ultrices vitae mauris. Phasellus nec dolor hendrerit dolor vestibulum placerat nec ut lacus. Phasellus mattis suscipit varius. Ut egestas tortor sit amet augue cursus ut volutpat magna scelerisque. Aenean pulvinar, lacus a hendrerit gravida, tellus neque condimentum lorem, eget semper purus massa eget neque. Nam pretium lacus in quam feugiat fringilla aliquet lectus egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque elementum consequat feugiat. Quisque id diam justo, eget euismod augue. Integer tristique vestibulum sollicitudin. Quisque eu orci nec magna vestibulum placerat in volutpat odio. Integer in orci non dolor ornare viverra. Nulla facilisi. Fusce volutpat mollis urna, vel ultrices libero porttitor a.</text>
			<text_parsed><![CDATA[<?php /* Cached: August 9, 2012, 7:18 am */ ?>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque id ipsum nisl. Nam vitae ligula turpis, vel egestas turpis. Curabitur condimentum metus ac ligula pulvinar volutpat. Nullam mollis nulla eu ligula volutpat pellentesque. Pellentesque sit amet nisl metus, et placerat elit. Mauris ac justo est, at malesuada mauris. Etiam auctor pharetra mollis. Vivamus lobortis, sem sit amet porta suscipit, augue libero consectetur justo, a sollicitudin risus eros et est. Vivamus eget lectus tellus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean vel ullamcorper mauris.
<br class="pf_break" />
<br class="pf_break" />Ut non consequat risus. Phasellus eget ligula vel enim pretium volutpat. Phasellus rutrum porttitor lorem. In accumsan pharetra sapien, in porta augue accumsan a. Fusce pellentesque egestas euismod. Donec porta dapibus urna eu varius. Pellentesque aliquet dapibus turpis, ut sollicitudin elit convallis eget. Curabitur ornare, sapien nec rhoncus bibendum, lacus libero tristique dui, in interdum massa purus ut quam. Morbi est turpis, feugiat non porttitor sed, adipiscing sed ligula.
<br class="pf_break" />
<br class="pf_break" />Quisque ac tempus ipsum. Praesent tempus convallis enim in suscipit. Nulla eu ipsum nec nisl tempus vestibulum. Fusce rutrum placerat tortor, vel ultricies sem ultrices sit amet. Proin elementum convallis neque eu sodales. Vivamus turpis massa, sodales sed volutpat consequat, feugiat non ante. Phasellus vel blandit nunc. Quisque nec ligula orci. Proin luctus interdum diam eu mattis. Maecenas nec posuere nunc. Duis a purus lacus. Quisque sit amet enim lacus. Praesent molestie, arcu id pharetra sollicitudin, est diam mattis erat, vel volutpat mauris ante nec lorem. In eget posuere sapien.
<br class="pf_break" />
<br class="pf_break" />Donec felis tellus, adipiscing viverra volutpat vel, luctus sed felis. Morbi ultricies ante in mauris ultrices ullamcorper. Vivamus justo est, suscipit eget convallis quis, dapibus nec lacus. Maecenas vel urna ac lacus adipiscing molestie nec id quam. Aliquam faucibus rutrum nisl, vitae faucibus felis tincidunt eget. Aliquam sit amet varius augue. In elementum sodales sapien id laoreet. Ut mattis laoreet neque, quis tincidunt leo mattis sed.
<br class="pf_break" />
<br class="pf_break" />Cras lacinia elementum auctor. Proin ante lacus, lobortis viverra tincidunt vitae, ullamcorper in nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus condimentum gravida lorem, eget lacinia mauris sodales eu. Suspendisse odio orci, congue sit amet elementum sed, vulputate in massa. Ut eget nisl metus, et adipiscing augue. Proin egestas porta arcu vitae feugiat. Donec et lacus tortor. Aliquam ornare velit tempor urna consectetur laoreet. Quisque congue ante vel sem ultricies ullamcorper.
<br class="pf_break" />
<br class="pf_break" />Duis posuere mauris quis turpis ornare lobortis sed quis leo. Morbi rhoncus lorem ac erat porttitor consectetur. Nullam condimentum libero sit amet sapien hendrerit placerat. Quisque at neque at turpis gravida hendrerit placerat quis neque. Sed dictum ipsum nisi, non placerat nisi. Cras elementum, eros at tempus tristique, lectus mi scelerisque tortor, sit amet pretium odio turpis sed risus. Vestibulum rutrum commodo porta. Phasellus sagittis mattis pretium. Curabitur in auctor libero. Curabitur rutrum dignissim ipsum et scelerisque. Nullam fermentum vehicula lectus eget tristique. Duis lacus nisl, ultricies vel fringilla at, iaculis a risus. Maecenas in eleifend massa.
<br class="pf_break" />
<br class="pf_break" />Nunc sit amet lorem turpis, sed gravida ante. Duis semper, nunc in condimentum imperdiet, eros tellus scelerisque lectus, vitae viverra justo libero a justo. In magna justo, blandit sed commodo non, porta ac urna. Vivamus in lacus mi, at scelerisque tortor. Nullam velit felis, convallis sit amet ullamcorper ut, consequat ut lacus. Aenean id porta lectus. Maecenas rutrum ante justo. Mauris dapibus adipiscing elementum. Fusce imperdiet neque dignissim ipsum sagittis fermentum. Nulla facilisi.
<br class="pf_break" />
<br class="pf_break" />Duis convallis tempus felis, eget sodales orci euismod sit amet. Ut at velit ipsum. Donec id nisl at turpis mollis rutrum. Vivamus faucibus, ipsum volutpat lacinia tincidunt, justo dui elementum felis, faucibus bibendum nibh nisi nec nulla. Mauris nisi arcu, dignissim non ultrices quis, ultricies rhoncus leo. Suspendisse varius volutpat odio euismod rhoncus. In ac sem vel nisl convallis varius. Nullam nisi erat, accumsan nec porta vel, blandit at leo. Mauris eu lorem laoreet sem faucibus auctor. Praesent viverra, enim id feugiat tincidunt, eros urna dapibus enim, vel adipiscing eros felis et neque. Nulla eu cursus velit. Ut at tellus nunc, eget feugiat erat. Ut nec magna blandit risus ornare vulputate a eget diam.
<br class="pf_break" />
<br class="pf_break" />Aenean posuere, purus ac cursus pulvinar, turpis eros condimentum sem, sit amet pulvinar purus lacus ut velit. Nulla tristique vestibulum nisl, a posuere ante tincidunt a. Fusce porta vestibulum felis, in eleifend sem faucibus eu. Duis bibendum suscipit dolor et mollis. Integer eget nulla eu augue mollis sagittis. Nam vel tempus odio. Nulla facilisi. Duis fermentum tortor vitae risus porta cursus. Morbi ultrices luctus lorem vitae pharetra. Integer pulvinar dui sed erat ultricies vehicula. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum pharetra pharetra ante at pellentesque. Etiam at convallis orci. Duis semper lorem quis ipsum hendrerit et interdum ligula vestibulum.
<br class="pf_break" />
<br class="pf_break" />Praesent accumsan nulla quis arcu ornare iaculis. Vestibulum in enim at arcu malesuada lacinia non sed neque. Maecenas vel velit sed lectus sagittis porttitor non a turpis. Cras eu tortor quis leo dapibus sagittis sed vehicula mauris. In luctus elementum urna sit amet sodales. Aliquam erat volutpat. Mauris sit amet tincidunt ipsum. Nam arcu lorem, vehicula rutrum dignissim non, pellentesque a arcu. Ut nec leo dui, vitae molestie lorem. Nam nisl tellus, tincidunt mollis facilisis ornare, suscipit vel mauris. Morbi pellentesque ullamcorper augue nec vestibulum. Mauris ac ipsum eget nibh tempus consequat id non ante. Etiam ligula magna, posuere a suscipit et, molestie at erat. Integer mi eros, dignissim non posuere eget, convallis ut magna. Proin vestibulum feugiat eros, id tempor dui rutrum non. Aenean auctor congue dignissim.
<br class="pf_break" />
<br class="pf_break" />Cras suscipit felis sit amet urna bibendum vel aliquet nibh tincidunt. Fusce eget velit sed diam interdum fringilla. Fusce mauris massa, pharetra quis vehicula eu, condimentum non neque. Mauris non odio metus. Integer nec purus lacus. Donec elit felis, bibendum in ultrices sed, elementum non arcu. In quis libero at turpis semper egestas. Duis dapibus lectus a urna cursus volutpat. Praesent rutrum imperdiet egestas. Mauris pulvinar lacus sed mauris dictum pellentesque. Suspendisse dictum, risus et pellentesque congue, nisi turpis suscipit nisl, non porta velit magna non ipsum. Etiam eget tellus sit amet sem lobortis mattis in ac nisi.
<br class="pf_break" />
<br class="pf_break" />Donec tristique rhoncus tellus ac pharetra. Nulla pellentesque lorem est, consequat pellentesque erat. Phasellus non nunc a sem egestas pellentesque vitae dapibus augue. Mauris vestibulum, augue ac blandit aliquam, sem justo varius dolor, et condimentum augue magna ac nulla. Ut sed nisl lorem, vel laoreet est. Donec lacus magna, dapibus ac auctor eget, imperdiet non dui. Suspendisse tristique luctus sagittis. Nulla sagittis odio eu felis facilisis suscipit non sed tortor. Nunc nulla sapien, cursus non faucibus et, luctus nec lectus. Integer euismod volutpat dolor suscipit semper. Proin blandit imperdiet tincidunt. Aenean placerat, purus vitae elementum venenatis, nunc libero fringilla mauris, et varius erat ligula eu dolor. Sed purus augue, convallis sit amet bibendum vitae, bibendum et metus. Suspendisse tempus quam ut odio dapibus ac tristique mauris varius. Mauris ut enim vulputate ante viverra interdum. Mauris sed mi ipsum.
<br class="pf_break" />
<br class="pf_break" />Suspendisse quis risus ut eros luctus rhoncus nec et ligula. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper viverra pellentesque. Praesent eros velit, elementum eget feugiat fringilla, interdum eu mauris. Donec nisi ante, lacinia non pellentesque in, accumsan eget mauris. Phasellus suscipit mauris sit amet lectus dapibus dignissim. In sed ullamcorper lectus. Sed sit amet sapien ligula, non venenatis lorem. In turpis ligula, posuere vitae imperdiet eu, aliquet a quam. Nullam accumsan dignissim leo. Cras blandit ultricies pharetra. In eu tortor quis metus cursus placerat. Vestibulum varius euismod nulla, placerat sodales mi viverra id. Aliquam erat volutpat.
<br class="pf_break" />
<br class="pf_break" />Duis eu quam nec metus consequat malesuada. Sed at lectus nisi. Nunc mauris lectus, commodo a condimentum in, commodo eget mi. Quisque vulputate rutrum purus ut lobortis. Curabitur sagittis ligula non magna iaculis id fermentum ante bibendum. Proin mollis ipsum in massa cursus convallis. Cras eleifend fermentum velit, eget vestibulum diam viverra vitae. Praesent purus diam, iaculis interdum tincidunt non, ultrices id mi.
<br class="pf_break" />
<br class="pf_break" />Maecenas gravida, dui id varius egestas, nisi purus feugiat enim, quis semper nunc massa et est. Aliquam convallis ante eros, in posuere erat. Nunc ut sagittis lorem. Ut non cursus sapien. Donec nisl tortor, commodo ut commodo sit amet, volutpat et dui. Maecenas laoreet ligula at augue tincidunt pellentesque tincidunt nulla consectetur. Praesent vestibulum, est ut tincidunt dignissim, urna lectus commodo neque, id aliquam leo risus rhoncus leo. Sed ligula lacus, fringilla vitae mattis a, malesuada non purus. Duis id magna quis tortor consectetur vulputate sit amet id justo. Vestibulum fermentum ligula non quam porta a posuere neque rhoncus. In at purus nunc. Integer ornare vestibulum nisl, a elementum nibh tincidunt in. Duis porta nisl nisi. Sed volutpat pulvinar dui in tempus.
<br class="pf_break" />
<br class="pf_break" />Mauris arcu nisl, sollicitudin ornare scelerisque sit amet, suscipit ut metus. In hac habitasse platea dictumst. Donec porttitor nibh a massa lacinia nec imperdiet lectus eleifend. Quisque ultricies nibh ac sem faucibus mattis. Mauris enim augue, rhoncus et mollis at, congue vitae sapien. Vivamus luctus feugiat euismod. Donec metus libero, tempus vitae posuere non, posuere vitae magna. Sed et nunc orci. Nullam in erat dui. In hac habitasse platea dictumst. Maecenas sollicitudin sapien id augue malesuada porta. Nullam id lorem ac leo feugiat laoreet nec ac orci. In eget nunc enim, quis pretium ante. Nam vestibulum purus ut dolor tristique aliquam.
<br class="pf_break" />
<br class="pf_break" />Vestibulum in enim nisl. In pretium, diam sed lacinia facilisis, augue felis dictum diam, vitae ullamcorper orci odio a nunc. Morbi porttitor, est a aliquam faucibus, urna nulla consequat augue, pulvinar imperdiet purus justo eu augue. Maecenas porta libero quis nulla euismod et cursus lorem ullamcorper. In nulla neque, eleifend vel porttitor id, consequat a neque. Etiam pretium rhoncus sapien, sit amet bibendum nibh adipiscing in. Cras dapibus orci nec neque vehicula vulputate. Curabitur congue, felis lacinia convallis porta, neque turpis eleifend nunc, at scelerisque nibh est sed leo.
<br class="pf_break" />
<br class="pf_break" />Ut id nibh vitae augue facilisis convallis. Sed quis augue lacus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In molestie justo non felis sodales convallis. Maecenas sit amet nisl blandit diam sollicitudin dignissim. Proin imperdiet mattis ante non malesuada. Proin pharetra pharetra justo. Fusce at elit vitae tortor fringilla tincidunt. Nulla ut fringilla mi. Nulla ultrices massa eget odio scelerisque lobortis. Pellentesque a lorem felis. Aenean eget porta urna.
<br class="pf_break" />
<br class="pf_break" />Vestibulum lacinia bibendum lectus, ultrices tempus nibh aliquam et. Phasellus a convallis erat. Quisque mollis, augue nec tincidunt mollis, purus ipsum ullamcorper lorem, quis auctor tortor metus et lectus. In vitae metus nec diam lacinia euismod. Maecenas vitae vulputate risus. Nullam eget quam vel risus malesuada laoreet. Praesent malesuada justo ac augue porttitor sed accumsan elit congue. Nam eget tellus quis est convallis tempus. Vestibulum sit amet lorem a est hendrerit sodales. Sed nec dictum magna. Duis pretium viverra dolor, in rhoncus diam euismod sed. Etiam vitae felis ac justo tincidunt mattis ac nec risus. Vestibulum varius imperdiet turpis sed facilisis. Nullam arcu dolor, aliquam in consectetur sit amet, scelerisque in turpis.
<br class="pf_break" />
<br class="pf_break" />Proin consectetur commodo justo, vitae convallis magna laoreet ut. Nulla eget risus eget velit consequat dignissim. Nunc vitae sem turpis. Morbi vestibulum malesuada ante at rhoncus. Ut faucibus lectus ut sapien tincidunt nec facilisis neque interdum. Quisque velit nulla, ornare et semper nec, scelerisque vitae ipsum. Nullam et pretium erat. Aliquam facilisis tincidunt nunc eu placerat. Mauris cursus dui in risus convallis lobortis. Mauris nec tortor lectus, a laoreet massa. Phasellus a erat metus. Etiam nisl nulla, sollicitudin a iaculis ut, tristique quis augue. Suspendisse dui est, ullamcorper id porta ac, aliquam quis erat.
<br class="pf_break" />
<br class="pf_break" />Nullam venenatis varius laoreet. Donec pellentesque justo at quam facilisis mattis fringilla risus sagittis. Cras dui ante, sollicitudin faucibus lobortis a, interdum vitae augue. Donec dui felis, viverra a semper nec, gravida sed augue. Nulla justo sem, convallis et porta vitae, placerat ac magna. Nullam a turpis in ipsum hendrerit dictum id at erat. Nullam lacinia iaculis risus, a mattis diam hendrerit in. Suspendisse dictum lobortis iaculis. In vulputate lectus a massa gravida venenatis. Aenean porttitor condimentum posuere.
<br class="pf_break" />
<br class="pf_break" />Nulla facilisi. Praesent vel risus id mauris malesuada vestibulum eget vel ligula. Etiam dapibus ultrices urna, nec auctor turpis aliquam non. Nam erat quam, sagittis nec faucibus in, fringilla vel sapien. Quisque commodo, eros sed elementum rutrum, tortor tortor viverra sem, non egestas augue mauris non libero. Cras tristique tortor et libero vehicula eu venenatis velit pharetra. Donec sagittis ornare libero, et interdum odio volutpat at. Donec non tellus et mauris lacinia pretium vitae in lorem. Nam tellus velit, mollis eget auctor non, luctus a tellus. Suspendisse potenti. Suspendisse posuere metus ipsum.
<br class="pf_break" />
<br class="pf_break" />Proin faucibus, dolor iaculis volutpat viverra, arcu nisi accumsan turpis, nec ultrices nibh nibh a tellus. Nullam a neque id diam lobortis dictum quis lobortis velit. Nunc congue aliquam facilisis. Ut interdum, tortor ut volutpat rutrum, enim nisi tincidunt tortor, ac venenatis libero tortor in erat. Cras at justo ut felis molestie rutrum. Nam justo nunc, vulputate et sollicitudin sed, vestibulum in neque. Nunc laoreet varius nulla.
<br class="pf_break" />
<br class="pf_break" />Nullam eu nisi non lorem fringilla luctus eu ac magna. Nulla rutrum ante eget magna fermentum consequat. Suspendisse hendrerit lacus vulputate turpis dictum lacinia. Nam placerat nisl in ante gravida rutrum. Sed sed eros libero, et tincidunt libero. Duis placerat sollicitudin bibendum. Nullam vitae nulla diam, ac luctus nisi. Ut dictum nunc ac purus semper posuere. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque non ipsum nec risus porttitor sodales. Quisque odio dolor, malesuada quis faucibus at, laoreet semper elit. Nullam ac ipsum eu mauris hendrerit pulvinar eu at magna. Mauris eget ante libero, non porttitor arcu.
<br class="pf_break" />
<br class="pf_break" />Vestibulum accumsan tempus venenatis. Nam massa quam, fermentum vitae aliquam at, vehicula non neque. Phasellus tristique dui at felis euismod porta. Fusce nisl magna, tempor mollis adipiscing sed, convallis at lorem. Suspendisse velit nulla, adipiscing eget gravida ut, sodales ut erat. Nulla facilisi. Etiam et tempus diam. Nam vulputate molestie laoreet.
<br class="pf_break" />
<br class="pf_break" />Sed nunc nulla, suscipit et fermentum ac, tempor sed magna. Donec libero lorem, tristique sit amet commodo vitae, dictum in felis. Proin sem orci, tempor sit amet adipiscing vitae, blandit blandit neque. Quisque eget massa dui, eget mattis turpis. Proin quis tellus vitae felis laoreet laoreet vitae vitae risus. Cras dictum semper vehicula. Integer vitae libero ante.
<br class="pf_break" />
<br class="pf_break" />Fusce vitae metus nulla, sed euismod felis. Nulla pulvinar egestas tincidunt. Nam vehicula malesuada urna, ac fringilla purus euismod quis. Curabitur sed metus eu orci rutrum tincidunt. Nam elementum, nibh in suscipit egestas, ligula dolor fringilla diam, et mollis tortor leo eu urna. Aenean egestas mauris ut arcu gravida vel volutpat felis consectetur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut pretium vulputate felis, sit amet varius lectus pellentesque non.
<br class="pf_break" />
<br class="pf_break" />Nulla facilisi. Nunc ornare tellus non dolor consectetur accumsan. Aenean tincidunt, nibh aliquam interdum bibendum, erat lacus ultrices libero, quis vehicula ligula dolor eget arcu. Sed rhoncus nulla eget justo viverra vitae rutrum nunc porttitor. Proin id neque risus. Maecenas vestibulum purus eget diam ullamcorper vel aliquam lacus imperdiet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla nec libero ac mauris malesuada rutrum sit amet vitae erat. Nam tellus est, tempor ut egestas sit amet, tempor ut lorem. Suspendisse fermentum ornare metus sed tincidunt. Nulla mattis bibendum sapien, ac vehicula lorem mattis in. Maecenas adipiscing elementum consectetur. In vel leo augue, nec tincidunt purus. Sed id gravida massa.
<br class="pf_break" />
<br class="pf_break" />Curabitur eros enim, feugiat sed eleifend quis, fringilla et metus. Quisque lacinia lacus non lorem commodo sed varius tellus cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris egestas consectetur massa, vulputate tincidunt magna vehicula id. Pellentesque eget dolor vel purus semper volutpat eu at nisl. Ut sollicitudin nisi sit amet odio auctor fringilla. Sed eu nisi sed ipsum hendrerit varius. Sed tempus dignissim tincidunt. Curabitur laoreet tortor quis urna tempor fermentum. Ut quis libero vitae nunc cursus hendrerit. Integer et interdum lacus.
<br class="pf_break" />
<br class="pf_break" />Donec ipsum velit, elementum quis porta ut, condimentum non dolor. Phasellus posuere dignissim leo, quis mollis lectus egestas vel. Phasellus adipiscing faucibus dictum. Vestibulum eu felis eros. Maecenas eu sapien turpis. Quisque volutpat aliquam sem laoreet porta. Nam varius feugiat dolor sit amet ornare. Sed vitae viverra velit. Curabitur non turpis nec augue placerat euismod mattis nec nulla. Morbi aliquet nibh nec leo vehicula vulputate. Maecenas vel lacinia est. Curabitur augue elit, fringilla placerat auctor id, luctus quis eros.
<br class="pf_break" />
<br class="pf_break" />Vestibulum ultrices iaculis tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam vel enim dui, et consequat magna. In vitae mi eget magna pulvinar pretium. Etiam quis turpis nunc. Nam eget velit eros. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer nunc elit, semper vel pellentesque et, faucibus ut metus. Nunc mollis dolor quis sem tempor in dictum est scelerisque. Nunc vel risus nisl, vitae bibendum nulla. Suspendisse tellus erat, dignissim imperdiet ultricies ac, malesuada sit amet nunc.
<br class="pf_break" />
<br class="pf_break" />Praesent nec turpis iaculis elit adipiscing semper. In feugiat, odio a tempus fermentum, nisl metus fringilla nulla, interdum fringilla felis odio et mauris. Cras consequat leo sed felis interdum eu mattis enim tristique. Suspendisse vel orci sapien, ut varius odio. Curabitur ut arcu elit. Cras purus ligula, sodales sit amet viverra et, iaculis at augue. Praesent vehicula vulputate porta. Pellentesque lectus mi, ornare ut ultricies eu, elementum sed purus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus laoreet, eros in volutpat fringilla, quam justo suscipit leo, vitae interdum magna nisi vel odio.
<br class="pf_break" />
<br class="pf_break" />Ut fermentum lorem quis ipsum lobortis bibendum. Pellentesque viverra augue vitae libero euismod volutpat. Nullam ac ipsum eget velit fringilla porta hendrerit nec nisl. Nunc vitae sem enim, quis tempor ipsum. Quisque vel diam eu metus blandit sagittis vitae sed eros. Vestibulum placerat elit et magna pretium dignissim. Integer luctus ligula vel dui mollis id porta purus ornare. Suspendisse eget dui mi. Quisque magna felis, volutpat eu posuere non, blandit id leo. Donec vel nisi nisl, eget lacinia odio. Phasellus sit amet massa vitae nibh congue fringilla sed nec felis.
<br class="pf_break" />
<br class="pf_break" />Mauris neque dolor, semper id porta vitae, rhoncus in felis. Proin porttitor, dui a auctor sagittis, nulla dolor interdum lacus, quis auctor nisi erat id nunc. Donec feugiat risus eget magna commodo id malesuada eros mollis. Suspendisse enim lacus, ultrices id malesuada nec, fringilla in augue. Ut ultrices dapibus tortor, sit amet dapibus quam condimentum ac. Aenean et nisi in velit luctus tempor. Integer sed risus justo, vel gravida arcu. Duis eleifend massa a nunc molestie tristique ornare nulla iaculis. Praesent vel nisi ante, id consequat diam.
<br class="pf_break" />
<br class="pf_break" />Nulla facilisi. Duis eros risus, euismod non facilisis et, pharetra eget orci. Praesent ultricies malesuada lectus, semper faucibus nibh ornare eu. Donec condimentum porta mollis. Vivamus sodales aliquet erat sit amet tempor. Nulla non dictum nisl. Suspendisse eleifend metus quis tellus mattis eget vulputate sapien scelerisque. Quisque dui ligula, accumsan cursus imperdiet nec, porttitor sed est.
<br class="pf_break" />
<br class="pf_break" />Donec purus erat, lobortis a convallis eu, euismod volutpat lacus. Pellentesque bibendum egestas ligula, in commodo est congue a. Cras sagittis viverra est, id tristique leo iaculis nec. Donec posuere sollicitudin scelerisque. Cras eros nulla, varius ut sollicitudin non, interdum at metus. Fusce nisi orci, vestibulum sed vehicula at, ullamcorper eget est. Praesent quis tortor orci, nec malesuada dui. Nullam in ipsum vel mauris gravida cursus ac nec erat.
<br class="pf_break" />
<br class="pf_break" />Nulla ut mi vitae quam euismod iaculis. Ut dapibus auctor metus, at feugiat tortor tincidunt vitae. Donec ultricies nulla eget diam faucibus ultrices posuere odio malesuada. Aenean porta dolor sed nibh rhoncus placerat. Nam vestibulum mauris in leo dictum nec volutpat lectus facilisis. Integer tristique condimentum purus, id auctor justo tristique quis. Aenean vitae lorem ac mauris suscipit gravida et quis tellus. Morbi ultricies tempus mauris id commodo. Nullam justo ligula, dictum et suscipit vitae, mollis id nunc. Maecenas lacinia, purus eget tempus pharetra, elit eros mattis felis, vel lacinia sapien massa et ligula. Morbi volutpat bibendum quam sed pulvinar. Etiam a odio mi, sit amet volutpat neque.
<br class="pf_break" />
<br class="pf_break" />Phasellus vel erat non lectus consequat vehicula at a ante. Praesent eu sagittis velit. Fusce eleifend dictum est, eu dapibus velit malesuada non. Nulla at sagittis nisl. Praesent justo tellus, semper eu vehicula vitae, fringilla adipiscing mauris. Praesent enim nulla, cursus eu tincidunt a, venenatis vel sapien. Suspendisse fringilla libero vitae libero eleifend gravida. Sed vitae nisi metus. Proin porttitor porta mattis. Aenean bibendum rhoncus enim rutrum gravida. Proin lobortis sagittis neque in euismod. Mauris ac arcu eu arcu sodales cursus. Sed posuere mauris id metus vulputate tincidunt. Sed sed elit ut est luctus eleifend. Curabitur euismod volutpat mauris, sit amet dapibus ipsum malesuada in.
<br class="pf_break" />
<br class="pf_break" />Aenean at elit orci. Mauris vel orci a nisl rhoncus lobortis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eleifend cursus gravida. Morbi semper, felis vitae condimentum adipiscing, enim diam molestie augue, id rutrum nibh nisi nec dui. Quisque tempus feugiat elit vitae pulvinar. Fusce sit amet lorem sed metus tristique ultricies.
<br class="pf_break" />
<br class="pf_break" />Donec eu mauris elit. Vivamus quis sapien nunc. Nunc ut velit quis magna malesuada gravida non non sapien. Morbi eu neque nibh, ac placerat nulla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin interdum nisi vitae ante ultricies consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
<br class="pf_break" />
<br class="pf_break" />Vestibulum dictum, nisi vel scelerisque commodo, purus ante accumsan nibh, eget ultrices mauris ipsum eu odio. Nulla facilisi. Etiam ac tincidunt nunc. Praesent sed urna felis. Ut eget tristique tortor. Donec ultrices diam at nisi ultricies placerat. Etiam libero orci, sodales vitae dictum posuere, tempor nec nunc. Praesent pharetra rutrum neque, sed congue tortor pellentesque id. Fusce bibendum turpis non arcu adipiscing ullamcorper non congue libero. In et volutpat felis. Aliquam iaculis dui auctor dolor placerat dapibus. Sed rhoncus erat sed purus tincidunt in mattis massa mattis. Nulla facilisi. Integer viverra rutrum condimentum. Vivamus vitae nibh ac purus dignissim tincidunt et non urna.
<br class="pf_break" />
<br class="pf_break" />Vivamus pellentesque vehicula magna venenatis interdum. Quisque fringilla quam dui. Curabitur lacinia iaculis nisi, sit amet consectetur arcu porta tempus. Suspendisse vel fringilla eros. Mauris non lacus ac felis cursus vestibulum. Maecenas in orci eget risus bibendum viverra. Nunc ac libero at felis vestibulum pulvinar. Morbi non dui ante, in egestas justo. Cras quis ante venenatis nisi molestie tincidunt a euismod tellus. Suspendisse fermentum consectetur urna vel varius. Proin tempor hendrerit leo, a aliquam velit pellentesque tempus. Nunc nulla eros, ultricies sit amet tincidunt in, ornare sodales felis. Maecenas tincidunt, nisi id lacinia convallis, nibh felis bibendum lectus, at mollis orci lectus nec velit.
<br class="pf_break" />
<br class="pf_break" />Duis ut quam vel quam consequat hendrerit tincidunt eget metus. Suspendisse vitae molestie elit. Nunc blandit venenatis leo ut vulputate. Pellentesque tempus fringilla porta. Etiam eget mattis felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi leo sem, commodo eget semper eget, porttitor id leo. Duis pulvinar pulvinar ultricies. Proin laoreet posuere sagittis. Curabitur lectus libero, fringilla et varius ut, sodales sit amet purus. Cras molestie pulvinar magna in malesuada. Nullam tincidunt enim at tellus tempor dignissim. Aliquam et lacus massa.
<br class="pf_break" />
<br class="pf_break" />Mauris arcu neque, bibendum vel porttitor eget, hendrerit at metus. Curabitur porttitor, orci a volutpat tristique, turpis nulla pellentesque tortor, vel mattis libero dui nec velit. Proin aliquam enim sed ligula mollis tristique. Aenean eget urna turpis. Etiam volutpat, massa sed tincidunt eleifend, nulla augue lacinia mauris, quis rhoncus libero erat aliquet est. Fusce vel ipsum mattis quam sagittis interdum. Phasellus ac turpis at justo convallis mollis sit amet sed tortor. Donec ac nunc urna, vitae laoreet mauris. Aenean dolor neque, ultricies eget sodales at, bibendum at erat.
<br class="pf_break" />
<br class="pf_break" />Proin sollicitudin scelerisque orci, at vestibulum magna consectetur et. Pellentesque sit amet ligula dolor. Duis dignissim blandit arcu, a vulputate nisi vehicula at. Sed sit amet velit vel justo pellentesque consequat quis vitae nulla. Nullam ornare tellus nisi. Nunc dignissim magna nisl, sit amet adipiscing turpis. Nulla vel purus vehicula enim dictum aliquam. Donec nisi diam, condimentum eu pharetra nec, ultrices vel lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget turpis sapien, at adipiscing erat. Curabitur sit amet turpis lacus, non pretium nibh. In hac habitasse platea dictumst. Proin sit amet tellus vel nibh pellentesque lobortis. Vivamus dignissim purus suscipit neque eleifend eget faucibus ipsum fringilla. Aenean nec quam lobortis purus aliquam viverra a eu dui.
<br class="pf_break" />
<br class="pf_break" />Nulla adipiscing, dui ac varius accumsan, purus lorem aliquet dui, non porttitor libero leo imperdiet mauris. Mauris eleifend porta risus, sit amet pharetra diam luctus quis. Nunc pellentesque blandit massa, vulputate sagittis magna sagittis a. Nulla sagittis euismod odio ut feugiat. Suspendisse non magna ut nisl congue consequat. Maecenas nisi tortor, tincidunt vel fringilla id, dictum vitae augue. Donec cursus nibh in est volutpat posuere. Ut dolor tortor, elementum a sodales in, consectetur scelerisque sem. Mauris non purus neque. Ut dictum ligula id est venenatis a tincidunt enim vulputate. Nullam imperdiet lobortis lectus, ac viverra tellus facilisis et. In lobortis diam lectus.
<br class="pf_break" />
<br class="pf_break" />Mauris fermentum dapibus urna quis adipiscing. Fusce at lorem lectus. Nullam eu orci justo. Sed orci dolor, congue et suscipit id, elementum sed ante. Phasellus vehicula eros vitae risus interdum pharetra. Nam lectus elit, suscipit in rutrum vel, rhoncus in elit. Nullam dignissim nunc nibh, et aliquet felis. Sed vulputate, ipsum eget facilisis scelerisque, lacus felis feugiat massa, eget interdum nisi sapien eget massa. Vestibulum leo metus, molestie non pulvinar nec, condimentum non diam.
<br class="pf_break" />
<br class="pf_break" />Quisque sagittis commodo molestie. Donec venenatis ante a purus elementum vestibulum. Maecenas laoreet, tortor non dapibus luctus, odio risus mollis risus, sed luctus diam libero eu felis. Suspendisse potenti. Sed vel quam mi, non placerat neque. In hac habitasse platea dictumst. Integer sed neque a arcu elementum semper. Donec vel velit erat. Nunc posuere, nisl semper pellentesque dignissim, quam purus varius urna, at ultrices dui risus in dolor. Vivamus at dui enim, et imperdiet risus. Vestibulum nisi nisi, faucibus sit amet venenatis vitae, pharetra at dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu mauris nulla. Nunc diam erat, placerat at commodo porta, faucibus a turpis. Morbi sodales nisi id ante imperdiet adipiscing.
<br class="pf_break" />
<br class="pf_break" />Fusce metus tellus, luctus placerat vehicula et, fermentum ut sem. Donec ac lorem risus, sit amet lobortis dui. Mauris vel metus ac urna mollis gravida id id justo. Proin id justo felis. Vivamus at vehicula massa. Proin interdum ornare congue. Mauris pellentesque faucibus mi sed vestibulum. Mauris enim sem, vestibulum ut placerat at, rhoncus sit amet metus. Nulla neque dolor, malesuada ac luctus sit amet, imperdiet quis libero. Nunc facilisis erat at turpis vulputate aliquet.
<br class="pf_break" />
<br class="pf_break" />Sed dignissim convallis interdum. Curabitur ligula ligula, lacinia in accumsan at, pharetra tempor sapien. Quisque quis augue ac magna aliquet fermentum ultrices vitae mauris. Phasellus nec dolor hendrerit dolor vestibulum placerat nec ut lacus. Phasellus mattis suscipit varius. Ut egestas tortor sit amet augue cursus ut volutpat magna scelerisque. Aenean pulvinar, lacus a hendrerit gravida, tellus neque condimentum lorem, eget semper purus massa eget neque. Nam pretium lacus in quam feugiat fringilla aliquet lectus egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque elementum consequat feugiat. Quisque id diam justo, eget euismod augue. Integer tristique vestibulum sollicitudin. Quisque eu orci nec magna vestibulum placerat in volutpat odio. Integer in orci non dolor ornare viverra. Nulla facilisi. Fusce volutpat mollis urna, vel ultrices libero porttitor a.]]></text_parsed>
		</page>
	</pages>
	<reports>
		<report module_id="core">Test</report>
		<report module_id="core">test4</report>
	</reports>
	<user_delete>
		<option module_id="core" phrase_var="core.user_cancellation_9" />
		<option module_id="core" phrase_var="core.user_cancellation_10" />
		<option module_id="core" phrase_var="core.user_cancellation_11" />
		<option module_id="core" phrase_var="core.user_cancellation_12" />
		<option module_id="core" phrase_var="core.user_cancellation_13" />
		<option module_id="core" phrase_var="core.user_cancellation_14" />
	</user_delete>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="1" user="1" guest="1" staff="1" module="core" ordering="0">can_view_update_info</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="1" user="0" guest="0" staff="1" module="core" ordering="0">can_view_private_items</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="1" user="0" guest="0" staff="0" module="core" ordering="0">can_add_new_setting</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="1" user="0" guest="0" staff="1" module="core" ordering="0">can_view_site_offline</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="0" user="0" guest="0" staff="0" module="core" ordering="0">user_is_banned</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="1" user="0" guest="0" staff="0" module="core" ordering="0">is_spam_free</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="1" user="0" guest="0" staff="0" module="core" ordering="0">can_view_twitter_updates</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="1" user="0" guest="0" staff="0" module="core" ordering="0">can_view_news_updates</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="true" user="false" guest="false" staff="false" module="core" ordering="0">can_design_dnd</setting>
		<setting is_admin_setting="0" module_id="core" type="boolean" admin="true" user="false" guest="false" staff="false" module="core" ordering="0">can_gift_points</setting>
	</user_group_settings>
	<tables><![CDATA[a:30:{s:24:"phpfox_admincp_dashboard";a:2:{s:7:"COLUMNS";a:5:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"cache_id";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"block_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_hidden";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:9:"is_hidden";}}}}s:20:"phpfox_admincp_login";a:2:{s:7:"COLUMNS";a:6:{s:8:"login_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"is_failed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"cache_data";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:8:"login_id";}s:12:"phpfox_block";a:3:{s:7:"COLUMNS";a:13:{s:8:"block_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"type_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"m_connection";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:9:"component";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"location";a:4:{i:0;s:9:"VCHAR:255";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"disallow_access";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"can_move";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:8:"block_id";s:4:"KEYS";a:5:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"product_id";}s:12:"m_connection";a:2:{i:0;s:5:"INDEX";i:1;s:12:"m_connection";}s:14:"m_connection_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:12:"m_connection";i:1;s:9:"is_active";}}s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"module_id";}}}s:18:"phpfox_block_order";a:3:{s:7:"COLUMNS";a:4:{s:8:"order_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"style_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"block_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"order_id";s:4:"KEYS";a:1:{s:8:"style_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"style_id";}}}s:19:"phpfox_block_source";a:2:{s:7:"COLUMNS";a:3:{s:8:"block_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"source_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"source_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:8:"block_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"block_id";}}}s:12:"phpfox_cache";a:2:{s:7:"COLUMNS";a:6:{s:8:"cache_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"file_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"cache_data";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"data_size";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"cache_id";}s:16:"phpfox_component";a:3:{s:7:"COLUMNS";a:8:{s:12:"component_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"component";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"m_connection";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:75";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:13:"is_controller";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"is_block";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:12:"component_id";s:4:"KEYS";a:2:{s:9:"component";a:2:{i:0;s:5:"INDEX";i:1;s:9:"component";}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:24:"phpfox_component_setting";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"user_value";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:8:"var_name";}}}}s:14:"phpfox_country";a:2:{s:7:"COLUMNS";a:4:{s:11:"country_iso";a:4:{i:0;s:6:"CHAR:2";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:8:"VCHAR:80";i:1;s:0:"";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:11:"country_iso";}s:20:"phpfox_country_child";a:3:{s:7:"COLUMNS";a:5:{s:8:"child_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:11:"country_iso";a:4:{i:0;s:6:"CHAR:2";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:200";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:8:"child_id";s:4:"KEYS";a:1:{s:11:"country_iso";a:2:{i:0;s:5:"INDEX";i:1;s:11:"country_iso";}}}s:11:"phpfox_cron";a:3:{s:7:"COLUMNS";a:9:{s:7:"cron_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:8:"next_run";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"last_run";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"every";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"php_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"cron_id";s:4:"KEYS";a:1:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:15:"phpfox_cron_log";a:2:{s:7:"COLUMNS";a:3:{s:6:"log_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"cron_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"log_id";}s:15:"phpfox_currency";a:2:{s:7:"COLUMNS";a:6:{s:11:"currency_id";a:4:{i:0;s:7:"VCHAR:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"symbol";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"phrase_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_default";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:11:"currency_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:11:"currency_id";}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:18:"phpfox_install_log";a:2:{s:7:"COLUMNS";a:6:{s:6:"log_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"is_upgrade";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:18:"upgrade_version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"log_id";}s:11:"phpfox_menu";a:3:{s:7:"COLUMNS";a:13:{s:7:"menu_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"page_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"m_connection";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"url_value";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"disallow_access";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"mobile_icon";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:7:"menu_id";s:4:"KEYS";a:5:{s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"product_id";}s:9:"url_value";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"url_value";i:1;s:9:"module_id";}}s:7:"page_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"page_id";}s:12:"m_connection";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:12:"m_connection";i:1;s:9:"is_active";}}s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"parent_id";}}}s:13:"phpfox_module";a:2:{s:7:"COLUMNS";a:7:{s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_core";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_menu";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:4:"menu";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:4:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}s:7:"is_menu";a:2:{i:0;s:5:"INDEX";i:1;s:7:"is_menu";}s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"module_id";}s:16:"module_is_active";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"module_id";i:1;s:9:"is_active";}}}}s:23:"phpfox_password_request";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"request_id";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:10:"request_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"request_id";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:13:"phpfox_plugin";a:3:{s:7:"COLUMNS";a:8:{s:9:"plugin_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:9:"call_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"php_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"plugin_id";s:4:"KEYS";a:1:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:18:"phpfox_plugin_hook";a:3:{s:7:"COLUMNS";a:8:{s:7:"hook_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"hook_type";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:9:"call_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"hook_id";s:4:"KEYS";a:2:{s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"product_id";}s:9:"call_name";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"call_name";i:1;s:9:"is_active";}}}}s:14:"phpfox_product";a:2:{s:7:"COLUMNS";a:10:{s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_core";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"version";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:14:"latest_version";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"last_check";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:3:"url";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:17:"url_version_check";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:4:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}s:5:"title";a:2:{i:0;s:5:"INDEX";i:1;s:5:"title";}s:14:"product_active";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"product_id";i:1;s:9:"is_active";}}s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"product_id";}}}s:25:"phpfox_product_dependency";a:3:{s:7:"COLUMNS";a:6:{s:13:"dependency_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"check_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:16:"dependency_start";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"dependency_end";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:13:"dependency_id";s:4:"KEYS";a:1:{s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"product_id";}}}s:22:"phpfox_product_install";a:3:{s:7:"COLUMNS";a:5:{s:10:"install_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"version";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"install_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:14:"uninstall_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:10:"install_id";s:4:"KEYS";a:1:{s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"product_id";}}}s:14:"phpfox_rewrite";a:2:{s:7:"COLUMNS";a:3:{s:10:"rewrite_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:3:"url";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"replacement";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"rewrite_id";}s:13:"phpfox_search";a:3:{s:7:"COLUMNS";a:6:{s:9:"search_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"search_query";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:12:"search_array";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"search_ids";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"search_id";s:4:"KEYS";a:1:{s:9:"search_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"search_id";i:1;s:7:"user_id";}}}}s:15:"phpfox_seo_meta";a:2:{s:7:"COLUMNS";a:5:{s:7:"meta_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:3:"url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"content";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"meta_id";}s:19:"phpfox_seo_nofollow";a:2:{s:7:"COLUMNS";a:3:{s:11:"nofollow_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:3:"url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"nofollow_id";}s:14:"phpfox_setting";a:3:{s:7:"COLUMNS";a:12:{s:10:"setting_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"group_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_hidden";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"type_id";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"value_actual";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"value_default";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"ordering";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"setting_id";s:4:"KEYS";a:5:{s:8:"var_name";a:2:{i:0;s:5:"INDEX";i:1;s:8:"var_name";}s:8:"group_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"group_id";i:1;s:9:"is_hidden";}}s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"module_id";i:1;s:9:"is_hidden";}}s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"product_id";i:1;s:9:"is_hidden";}}s:9:"is_hidden";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_hidden";}}}s:20:"phpfox_setting_group";a:2:{s:7:"COLUMNS";a:5:{s:8:"group_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:10:"version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:8:"var_name";a:2:{i:0;s:5:"INDEX";i:1;s:8:"var_name";}s:8:"group_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"group_id";}}}s:16:"phpfox_site_stat";a:3:{s:7:"COLUMNS";a:9:{s:7:"stat_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"phrase_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"php_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"stat_link";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"stat_image";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"stat_id";s:4:"KEYS";a:1:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:14:"phpfox_version";a:2:{s:7:"COLUMNS";a:2:{s:10:"version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"ordering";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:10:"version_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"version_id";}}}}]]></tables>
	<install><![CDATA[		
		$aRows = array(
			array(
				'currency_id' => 'USD',
				'symbol' => '&#36;'	,
				'phrase_var' => 'core.u_s_dollars',
				'ordering' => '1',
				'is_default' => '1',
				'is_active' => '1'
			),	
			array(
				'currency_id' => 'EUR',
				'symbol' => '&#8364;'	,
				'phrase_var' => 'core.euros',
				'ordering' => '2',
				'is_default' => '0',
				'is_active' => '1'
			),
			array(
				'currency_id' => 'GBP',
				'symbol' => '&#163;',
				'phrase_var' => 'core.pounds_sterling',
				'ordering' => '3',
				'is_default' => '0',
				'is_active' => '1'
			)
		);	
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('currency'), $aInsert);
		}		
	
		$aRows = array(
			array(
				'url' => 'user/login',
				'replacement' => 'login'	
			),	
			array(
				'url' => 'user/logout',
				'replacement' => 'logout'
			)			
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('rewrite'), $aInsert);
		}
		$aRows = array(
			array(
				'product_id' => 'phpfox',
				'title' => 'Core',
				'description' => '',
				'version' => '',
				'is_active' => '1',
				'url' => '',
				'url_version_check' => ''		
			),
			array(
				'product_id' => 'phpfox_installer',
				'title' => 'Core Installer',
				'description' => '',
				'version' => '1',
				'is_active' => '1',
				'url' => '',
				'url_version_check' => ''		
			),
			array(
				'product_id' => 'flowplayer',
				'title' => 'Flowplayer',
				'description' => 'Video Player for the Web',
				'version' => '3.1',
				'is_active' => '1',
				'url' => null,
				'url_version_check' => null
			)	
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('product'), $aInsert);
		}		
		
		$aCountryChildren = array (
				  'US' => 
				  array (
				    0 => 'Alabama',
				    1 => 'Alaska',
				    2 => 'American Samoa',
				    3 => 'Arizona',
				    4 => 'Arkansas',
				    5 => 'California',
				    6 => 'Colorado',
				    7 => 'Connecticut',
				    8 => 'Delaware',
				    9 => 'District Of Columbia',
				    10 => 'Federated States Of Micronesia',
				    11 => 'Florida',
				    12 => 'Georgia',
				    13 => 'Guam',
				    14 => 'Hawaii',
				    15 => 'Idaho',
				    16 => 'Illinois',
				    17 => 'Indiana',
				    18 => 'Iowa',
				    19 => 'Kansas',
				    20 => 'Kentucky',
				    21 => 'Louisiana',
				    22 => 'Maine',
				    23 => 'Marshall Islands',
				    24 => 'Maryland',
				    25 => 'Massachusetts',
				    26 => 'Michigan',
				    27 => 'Minnesota',
				    28 => 'Mississippi',
				    29 => 'Missouri',
				    30 => 'Montana',
				    31 => 'Nebraska',
				    32 => 'Nevada',
				    33 => 'New Hampshire',
				    34 => 'New Jersey',
				    35 => 'New Mexico',
				    36 => 'New York',
				    37 => 'North Carolina',
				    38 => 'North Dakota',
				    39 => 'Northern Mariana Islands',
				    40 => 'Ohio',
				    41 => 'Oklahoma',
				    42 => 'Oregon',
				    43 => 'Palau',
				    44 => 'Pennsylvania',
				    45 => 'Puerto Rico',
				    46 => 'Rhode Island',
				    47 => 'South Carolina',
				    48 => 'South Dakota',
				    49 => 'Tennessee',
				    50 => 'Texas',
				    51 => 'Utah',
				    52 => 'Vermont',
				    53 => 'Virgin Islands',
				    54 => 'Virginia',
				    55 => 'Washington',
				    56 => 'West Virginia',
				    57 => 'Wisconsin',
				    58 => 'Wyoming',
				  ),
				  'SE' => 
				  array (
				    0 => 'Blekinge',
				    1 => 'Bohusl&#228;n',
				    2 => 'Dalarna',
				    3 => 'Dalsland',
				    4 => 'Gotland',
				    5 => 'G&#228;strikland',
				    6 => 'Halland',
				    7 => 'H&#228;lsingland',
				    8 => 'H&#228;rjedalen',
				    9 => 'J&#228;mtland',
				    10 => 'Lappland',
				    11 => 'Medelpad',
				    12 => 'Norrbotten',
				    13 => 'N&#228;rke',
				    14 => 'Sk&#229;ne',
				    15 => 'Sm&#229;land',
				    16 => 'S&#246;dermanland',
				    17 => 'Uppland',
				    18 => 'V&#228;rmland',
				    19 => 'V&#228;stmanland',
				    20 => 'V&#228;sterbotten',
				    21 => 'V&#228;sterg&#246;tland',
				    22 => '&#197;ngermanland',
				    23 => '&#214;land',
				    24 => '&#214;sterg&#246;tland',
				  )
		);	
		
		foreach ($aCountryChildren as $sIso => $aChilds)
		{
			foreach ($aChilds as $sChild)
			{
				$this->database()->insert(Phpfox::getT('country_child'), array('country_iso' => $sIso, 'name' => $sChild));
			}
		}

		/* Remove the attribute Unsigned from feed table*/
		$this->database()->query("ALTER TABLE  `" . Phpfox::getParam(array('db','prefix')) . "feed` CHANGE  `feed_reference`  `feed_reference` INT( 10 ) NOT NULL DEFAULT  '0'");
	]]></install>
</module>