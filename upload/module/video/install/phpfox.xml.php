<module>
	<data>
		<module_id>video</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:29:"video.admin_menu_add_category";a:1:{s:3:"url";a:2:{i:0;s:5:"video";i:1;s:3:"add";}}s:34:"video.admin_menu_manage_categories";a:1:{s:3:"url";a:1:{i:0;s:5:"video";}}}]]></menu>
		<phrase_var_name>module_video</phrase_var_name>
		<writable><![CDATA[a:2:{i:0;s:11:"file/video/";i:1;s:15:"file/pic/video/";}]]></writable>
	</data>
	<menus>
		<menu module_id="video" parent_var_name="" m_connection="main" var_name="menu_video" ordering="26" url_value="video" version_id="2.0.0alpha1" disallow_access="" module="video" />
		<menu module_id="video" parent_var_name="" m_connection="video.index" var_name="menu_upload_a_new_video" ordering="76" url_value="video.add" version_id="2.0.0beta2" disallow_access="" module="video" />
		<menu module_id="video" parent_var_name="" m_connection="profile" var_name="menu_videos" ordering="78" url_value="profile.video" version_id="2.0.0beta2" disallow_access="" module="video" />
		<menu module_id="video" parent_var_name="" m_connection="mobile" var_name="menu_video_videos_532c28d5412dd75bf975fb951c740a30" ordering="127" url_value="video" version_id="3.1.0rc1" disallow_access="" module="video" mobile_icon="small_videos.png" />
	</menus>
	<setting_groups>
		<name module_id="video" version_id="3.0.1" var_name="setting_group_embedly">embedly</name>
	</setting_groups>
	<settings>
		<setting group="time_stamps" module_id="video" is_hidden="0" type="string" var_name="video_time_stamp" phrase_var_name="setting_video_time_stamp" ordering="4" version_id="2.0.0beta2">F j, Y</setting>
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="ffmpeg_path" phrase_var_name="setting_ffmpeg_path" ordering="3" version_id="2.0.0beta2">ffmpeg</setting>
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="mencoder_path" phrase_var_name="setting_mencoder_path" ordering="2" version_id="2.0.0beta2">mencoder</setting>
		<setting group="" module_id="video" is_hidden="0" type="boolean" var_name="allow_video_uploading" phrase_var_name="setting_allow_video_uploading" ordering="1" version_id="2.0.0beta2">0</setting>
		<setting group="" module_id="video" is_hidden="0" type="boolean" var_name="embed_auto_play" phrase_var_name="setting_embed_auto_play" ordering="5" version_id="2.0.0beta3">0</setting>
		<setting group="" module_id="video" is_hidden="0" type="integer" var_name="total_related_videos" phrase_var_name="setting_total_related_videos" ordering="9" version_id="2.0.0rc1">10</setting>
		<setting group="search_engine_optimization" module_id="video" is_hidden="0" type="large_string" var_name="video_meta_keywords" phrase_var_name="setting_video_meta_keywords" ordering="11" version_id="2.0.0rc1">video, sharing, free, upload</setting>
		<setting group="search_engine_optimization" module_id="video" is_hidden="0" type="large_string" var_name="video_meta_description" phrase_var_name="setting_video_meta_description" ordering="17" version_id="2.0.0rc1">Share your videos with friends, family, and the world on Site Name.</setting>
		<setting group="" module_id="video" is_hidden="0" type="boolean" var_name="full_screen_with_youtube" phrase_var_name="setting_full_screen_with_youtube" ordering="6" version_id="2.0.0rc2">1</setting>
		<setting group="" module_id="video" is_hidden="0" type="boolean" var_name="disable_youtube_related_videos" phrase_var_name="setting_disable_youtube_related_videos" ordering="7" version_id="2.0.0rc2">0</setting>
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="params_for_ffmpeg" phrase_var_name="setting_params_for_ffmpeg" ordering="1" version_id="2.0.5">-i {source}  -s {width}x{height} {destination}</setting>
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="params_for_mencoder" phrase_var_name="setting_params_for_mencoder" ordering="1" version_id="2.0.5">{source} -o {destination} -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=800:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -vf scale={width}:{height}</setting>
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="params_for_mencoder_fallback" phrase_var_name="setting_params_for_mencoder_fallback" ordering="1" version_id="2.0.5">{source} -o {destination} -of lavf -oac pcm -ovc lavc -lavcopts vcodec=flv:vbitrate=800:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -srate 22050 -ofps 24 -vf scale={width}:{height}</setting>
		<setting group="" module_id="video" is_hidden="0" type="boolean" var_name="enable_flvtool2" phrase_var_name="setting_enable_flvtool2" ordering="1" version_id="2.0.5">0</setting>
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="params_for_flvtool2" phrase_var_name="setting_params_for_flvtool2" ordering="1" version_id="2.0.5">-U {destination}</setting>
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="flvtool2_path" phrase_var_name="setting_flvtool2_path" ordering="1" version_id="2.0.5">flvtool2</setting>
		<setting group="" module_id="video" is_hidden="0" type="boolean" var_name="close_sql_connection_while_converting" phrase_var_name="setting_close_sql_connection_while_converting" ordering="1" version_id="2.0.7">0</setting>
		<setting group="formatting" module_id="video" is_hidden="0" type="boolean" var_name="allow_youtube_iframe" phrase_var_name="setting_allow_youtube_iframe" ordering="1" version_id="2.1.0beta1">1</setting>
		<setting group="embedly" module_id="video" is_hidden="0" type="boolean" var_name="enabled_embedly_import" phrase_var_name="setting_enabled_embedly_import" ordering="1" version_id="3.0.1">1</setting>
		<setting group="embedly" module_id="video" is_hidden="0" type="string" var_name="embedly_api_key" phrase_var_name="setting_embedly_api_key" ordering="2" version_id="3.0.1" />
		<setting group="" module_id="video" is_hidden="0" type="boolean" var_name="use_youtube_iframe" phrase_var_name="setting_use_youtube_iframe" ordering="1" version_id="3.5.0beta1">1</setting>
		<setting group="" module_id="video" is_hidden="0" type="boolean" var_name="vidly_support" phrase_var_name="setting_vidly_support" ordering="1" version_id="3.3.0beta2">0</setting>
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="vidly_user_key" phrase_var_name="setting_vidly_user_key" ordering="1" version_id="3.3.0beta2" />
		<setting group="" module_id="video" is_hidden="0" type="string" var_name="vidly_api_key" phrase_var_name="setting_vidly_api_key" ordering="1" version_id="3.3.0beta2" />
		<setting group="" module_id="video" is_hidden="1" type="boolean" var_name="video_enable_mass_uploader" phrase_var_name="setting_video_enable_mass_uploader" ordering="1" version_id="2.0.8">0</setting>
		<setting group="" module_id="video" is_hidden="1" type="drop" var_name="show_share_and_upload_video_on_dashboard" phrase_var_name="setting_show_share_and_upload_video_on_dashboard" ordering="10" version_id="2.0.0rc3"><![CDATA[a:2:{s:7:"default";s:5:"share";s:6:"values";a:3:{i:0;s:5:"share";i:1;s:6:"upload";i:2;s:4:"both";}}]]></setting>
		<setting group="" module_id="video" is_hidden="1" type="integer" var_name="total_my_videos" phrase_var_name="setting_total_my_videos" ordering="8" version_id="2.0.0rc1">10</setting>
		<setting group="" module_id="video" is_hidden="1" type="string" var_name="video_upload_private_key" phrase_var_name="setting_video_upload_private_key" ordering="1" version_id="3.3.0beta2" />
		<setting group="" module_id="video" is_hidden="1" type="string" var_name="video_upload_public_key" phrase_var_name="setting_video_upload_public_key" ordering="1" version_id="3.3.0beta2" />
		<setting group="" module_id="video" is_hidden="1" type="boolean" var_name="video_upload_service" phrase_var_name="setting_video_upload_service" ordering="1" version_id="3.3.0beta2">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="video.index" module_id="video" component="category" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="group.view" module_id="video" component="parent" location="2" is_active="1" ordering="4" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="video.view" module_id="video" component="related" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="video.index" module_id="video" component="sponsored" location="3" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="video.index" module_id="video" component="featured" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title>featured</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_video__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_menu_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_category_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_detail_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_profile_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_admincp_index_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_admincp_add_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_convert_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_view_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_upload_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_share_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_frame_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_category_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_edit_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_profile_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_video_getvideo" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_convert__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_category_process__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_category_category__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_browse__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_new_clean" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_parent_clean" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_group_clean" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_video_verify" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_related_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_filter_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_my_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_spotlight_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_tag_clean" added="1259160644" version_id="2.0.0rc9" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_addShareVideo__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_add__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_parse__start" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_parse__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_sponsor__end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="video" hook_type="template" module="video" call_name="video.template_default_controller_view_extra_info" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_addsharevideo__start" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="template" module="video" call_name="video.template_block_entry_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="template" module="video" call_name="video.template_block_entry_2" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="template" module="video" call_name="video.template_block_entry_3" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="template" module="video" call_name="video.template_block_entry_4" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="template" module="video" call_name="video.template_block_entry_5" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="template" module="video" call_name="video.template_block_entry_6" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="template" module="video" call_name="video.template_block_menu" added="1286546859" version_id="2.0.7" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_view_end" added="1290072896" version_id="2.0.7" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_ajax_convert_feed" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_featured_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_file_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_share_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_supported_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_url_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_user_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_add_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_view_video_path" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_add_sphrase" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_add_sphrase_2" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_index_set_action" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_index_switch_sview" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_index_switch" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_index_set_filter_menu_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_index_set_filter_menu_2" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_convert_process_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_update_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_delete_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_deleteimage_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_approve__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_process_approve_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="video" hook_type="component" module="video" call_name="video.component_block_supported_1" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_get_1" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_get_2" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_title_1" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_title_3" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_title_4" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_title_2" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_image_1" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_image_3" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_image_2" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_embed_1" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="service" module="video" call_name="video.service_grab_embed_2" added="1339506615" version_id="3.3.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_add_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_add_2" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_add_3" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_add_4" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_profile_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_view_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_view_2" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_view_3" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_play_clean" added="1372931660" version_id="3.6.0" />
		<hook module_id="video" hook_type="controller" module="video" call_name="video.component_controller_ping_clean" added="1372931660" version_id="3.6.0" />
	</hooks>
	<components>
		<component module_id="video" component="view" m_connection="video.view" module="video" is_controller="1" is_block="0" is_active="1" />
		<component module_id="video" component="menu" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="detail" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="index" m_connection="video.index" module="video" is_controller="1" is_block="0" is_active="1" />
		<component module_id="video" component="category" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="profile" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="parent" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="filter" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="spotlight" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="related" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="my" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="sponsored" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
		<component module_id="video" component="profile" m_connection="video.profile" module="video" is_controller="1" is_block="0" is_active="1" />
		<component module_id="video" component="share" m_connection="video.share" module="video" is_controller="1" is_block="0" is_active="1" />
		<component module_id="video" component="featured" m_connection="" module="video" is_controller="0" is_block="1" is_active="1" />
	</components>
	<feed_share>
		<share module_id="video" title="{phrase var='video.video'}" description="{phrase var='video.say_something_about_this_video'}" block_name="share" no_input="0" is_frame="1" ajax_request="" no_profile="0" icon="video.png" ordering="2" />
	</feed_share>
	<phrases>
		<phrase module_id="video" version_id="2.0.0alpha1" var_name="module_video" added="1232964371">Videos</phrase>
		<phrase module_id="video" version_id="2.0.0alpha1" var_name="menu_video" added="1232964384">Videos</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="user_setting_can_add_comment_on_video" added="1241971648">Can add comments on videos?</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="setting_video_time_stamp" added="1242026906"><![CDATA[<title>Video Time Stamp</title><info>Video Time Stamp</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="user_setting_can_edit_own_video" added="1242112583">Can edit own video?</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="user_setting_can_edit_other_video" added="1242112616">Can edit videos added by other users?</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="user_setting_can_delete_own_video" added="1242113706">Can delete own video?</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="user_setting_can_delete_other_video" added="1242113732">Can delete videos added by other users?</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="menu_upload_a_new_video" added="1242118593">Upload/Share a Video</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="menu_videos" added="1242291396">Videos</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="admin_menu_add_category" added="1242293663">Add Category</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="admin_menu_manage_categories" added="1242293693">Manage Categories</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="setting_ffmpeg_path" added="1242374616"><![CDATA[<title>Path to FFMPEG</title><info>Path to FFMPEG</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="setting_mencoder_path" added="1242374658"><![CDATA[<title>Path to MENCODER</title><info>Path to MENCODER</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="setting_video_file_size_limit" added="1242561688"><![CDATA[<title>Video File Size Limit</title><info>File size limit in megabytes.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="user_setting_video_file_size_limit" added="1242736067">File size limit in megabytes.</phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="setting_allow_video_uploading" added="1242803593"><![CDATA[<title>Enable Uploading of Videos</title><info>Enable this option if you would like to give users the ability to upload videos from their computer.

<b>Notice:</b> This feature requires that FFMPEG and MENCODER be installed. Once you attempt to enable this feature the script will attempt to verify if the server has all the required scripts installed.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0beta2" var_name="user_setting_can_upload_videos" added="1242805129">Can upload videos?</phrase>
		<phrase module_id="video" version_id="2.0.0beta3" var_name="setting_embed_auto_play" added="1243855646"><![CDATA[<title>Auto Play (Shared Videos)</title><info>If enabled this setting will attempt to auto play shared videos (eg. Youtube). 

Note: This will only work on new videos being added.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="user_setting_can_feature_videos" added="1250115994">Can feature videos?</phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="user_setting_can_spotlight_videos" added="1250146300">Can spotlight videos?</phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="setting_total_my_videos" added="1250235604"><![CDATA[<title>Total "More From" Videos to Display</title><info>When viewing a video we list more videos that belong to the owner of the video. Define how many videos should be displayed within this block.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="setting_total_related_videos" added="1250236359"><![CDATA[<title>Total Related Videos to Display</title><info>Define how many related videos should be displayed when viewing a video.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="user_setting_approve_video_before_display" added="1250238662">Should videos added by this user group be approved before they are displayed publicly?</phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="user_setting_can_approve_videos" added="1250242183">Can approve videos?</phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="user_setting_max_size_for_video_photos" added="1250251876"><![CDATA[Max file size for photos upload in kilobits (kb).
(1000 kb = 1 mb)
For unlimited add "0" without quotes. 

<b>Notice:</b> Photos are only uploaded if we were unable to convert/import photos.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="setting_video_meta_keywords" added="1252131246"><![CDATA[<title>Video Meta Keywords</title><info>Meta keywords used within the video section.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc1" var_name="setting_video_meta_description" added="1252131304"><![CDATA[<title>Video Meta Description</title><info>Meta description used within the video section.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc2" var_name="setting_full_screen_with_youtube" added="1253532536"><![CDATA[<title>Enable Full Screen for YouTube</title><info>Enable this option to enable the "Full Screen" feature for YouTube videos.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc2" var_name="setting_disable_youtube_related_videos" added="1253532687"><![CDATA[<title>Disable YouTube Related Videos</title><info>Enable this feature to disable YouTube related videos feature.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="setting_show_share_and_upload_video_on_dashboard" added="1254218034"><![CDATA[<title>Show upload and share on Dashboard</title><info>Here you can choose whether to show just the "upload video" link, just the "share video" link or both on the dashboard.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_edit_this_video_as_there_is_no_video_id" added="1254401648">Unable to edit this video as there is no video ID#</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="done" added="1254401673">Done!</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="categories" added="1254402091">Categories</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="sub_categories" added="1254402112">Sub-Categories</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_details" added="1254402131">Video Details</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="browse_filter" added="1254402149">Browse Filter</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="more_from" added="1254402174">More From:</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="videos" added="1254402214">Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="view_more" added="1254402255">View More</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="related_videos" added="1254402325">Related Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="afooter" added="1254402338">aFooter</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="spotlight" added="1254402421">Spotlight</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="category_successfully_updated" added="1254402459">Category successfully updated.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="category_successfully_added" added="1254402474">Category successfully added.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="edit_a_category" added="1254402486">Edit a Category</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="create_a_new_category" added="1254402498">Create a New Category</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="category_order_successfully_updated" added="1254402543">Category order successfully updated.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="category_successfully_deleted" added="1254402580">Category successfully deleted.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="manage_categories" added="1254402591">Manage Categories</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="id_must_be_defined" added="1254402634">ID must be defined.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_edit_this_video" added="1254402663">Unable to edit this video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_successfully_updated" added="1254402685">Video successfully updated.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="edit_a_video" added="1254402735">Edit a Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="upload_failed_file_is_too_large" added="1254402946">Upload failed. File is too large.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_section_is_closed" added="1254403051">Video section is closed.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_successfully_deleted" added="1254403096">Video successfully deleted.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="full_name_s_videos_full_name_has_total_video_s" added="1254403381"><![CDATA[{full_name}'s videos. {full_name} has {total} video(s).]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="full_name_s_videos" added="1254403482"><![CDATA[{full_name}'s Videos]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="videos_for_this_profile_is_set_to_private" added="1254403646">Videos for this profile is set to private.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_successfully_added" added="1254403678">Video successfully added.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_successfull_added_however_you_will_have_to_manually_upload_a_photo_for_it" added="1254403699">Video successfull added, however you will have to manually upload a photo for it.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="share_a_video" added="1254403721">Share a Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_successfully_uploaded" added="1254403776">Video successfully uploaded.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="upload_a_video" added="1254403788">Upload a Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="the_video_you_are_looking_for_does_not_exist_or_has_been_removed" added="1254403835">The video you are looking for does not exist or has been removed.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="total_rating_ratings" added="1254403888">{total_rating} Ratings</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="poor" added="1254403954">Poor</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="nothing_special" added="1254403965">Nothing Special</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="worth_watching" added="1254403976">Worth Watching</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="pretty_cool" added="1254403987">Pretty Cool</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="awesome" added="1254403996">Awesome</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="you_have_already_voted" added="1254404170">You have already voted.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="you_cannot_rate_your_own_video" added="1254404183">You cannot rate your own video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="select" added="1254404840">Select</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="select_a_sub_category" added="1254404852">Select a Sub-Category</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="nothing_to_convert" added="1254404948">Nothing to convert.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="started_converting_process" added="1254404962">Started converting process.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="converting_store_in_cache_video_id" added="1254405048">Converting (store in cache): {video_id}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="updated_process_id" added="1254405081">Updated process ID#</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="start_converting_process_video_id" added="1254405113">Start converting process: {video_id}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="file_exists_sdestination" added="1254405171">File exists: {sDestination}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="cant_convert_ssource" added="1254405251">Cant convert: {sSource}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="converting_ssource" added="1254405295">Converting: {sSource}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="converting_completed_sdestination" added="1254405335">Converting completed: {sDestination}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="updated_database_video_table" added="1254405376">Updated database video table.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="updated_user_points" added="1254405390">Updated user points.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="removed_source_file" added="1254405401">Removed source file.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="completed_image_simagelocation" added="1254405456">Completed Image: {sImageLocation}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="completed_sdestination" added="1254405513">Completed: {sDestination}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_convert_video" added="1254405571">Unable to convert video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="not_a_valid_site_valid_sites_asites" added="1254405633">Not a valid site. Valid sites: {aSites}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="provide_a_category_this_video_will_belong_to" added="1254487824">Provide a category this video will belong to.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_embed_this_video_due_to_privacy_settings" added="1254487845">Unable to embed this video due to privacy settings.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="select_a_video_to_upload" added="1254487878">Select a video to upload.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="not_a_valid_file_we_only_allow_sallow" added="1254487914">Not a valid file. We only allow: {sAllow}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="select_a_video" added="1254487977">Select a video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_process_this_video" added="1254488029">Unable to process this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_find_the_video_you_plan_to_edit" added="1254488075">Unable to find the video you plan to edit.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="provide_a_title_for_this_video" added="1254488086">Provide a title for this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="invalid_permissions" added="1254488133">Invalid Permissions.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_find_the_video_you_plan_to_delete" added="1254488148">Unable to find the video you plan to delete.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_find_the_video_image_you_plan_to_delete" added="1254488214">Unable to find the video image you plan to delete.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unable_to_find_the_video_you_want_to_approve" added="1254488246">Unable to find the video you want to approve.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="your_video_has_been_approved_on_site_title" added="1254488300">Your video has been approved on {site_title}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="your_video_has_been_approved_on_site_title_n_nto_view_this_video_follow_the_link_below_n_a_href" added="1254488463"><![CDATA[Your video has been approved on {site_title}.nnTo view this video, follow the link below:n<a href="{sLink}"> {sLink} </a>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="not_a_valid_video_to_display" added="1254488610">Not a valid video to display.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="are_you_sure_this_will_delete_all_videos_that_belong_to_this_category_and_cannot_be_undone" added="1254488826">Are you sure? This will delete all videos that belong to this category and cannot be undone.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="added_by" added="1254488943">Added By</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="rating" added="1254488976">Rating</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="category" added="1254488990">Category</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="url" added="1254489013">URL</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="embed" added="1254489021">Embed</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="featured" added="1254489041">Featured</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="pending" added="1254489059">Pending</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="approve_this_video" added="1254489109">Approve this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="approved" added="1254489134">Approved</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="edit_this_video" added="1254489227">Edit this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="edit" added="1254489247">Edit</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="delete_this_video" added="1254489283">Delete this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="are_you_sure" added="1254489302">Are you sure?</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="delete" added="1254489334">Delete</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="feature_this_video" added="1254489427">Feature this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="unfeature" added="1254489453">Unfeature</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="spotlight_this_video" added="1254489500">Spotlight this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="remove_the_spotlight_from_this_video" added="1254489533">Remove the spotlight from this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="remove_spotlight" added="1254489549">Remove Spotlight</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="keywords" added="1254489744">Keywords</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="submit" added="1254489754">Submit</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="reset" added="1254489762">Reset</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_title" added="1254489785">Video Title</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="description" added="1254489808">Description</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="by" added="1254490481">By</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="report_a_video" added="1254490573">Report a Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="report" added="1254490584">Report</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="add_to_your_favorites" added="1254490592">Add to your Favorites</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="add_to_favorites" added="1254490600">Add to Favorites</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="edit_this_video_menu" added="1254490709">Edit this Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="delete_this_video_menu" added="1254490763">Delete this Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="total_views_views" added="1254490886">{total_views} views</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="no_videos_have_been_added_yet" added="1254490981">No videos have been added yet.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="be_the_first_to_add_a_video" added="1254490991">Be the First to Add a Video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="go_advanced" added="1254491246">go advanced</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="cancel" added="1254491255">cancel</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="no_videos_added_yet_link_to_add" added="1254491516"><![CDATA[No videos added yet. Click <a href="{sAddNewVideoLink}"> here</a> to add a new video.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="update" added="1254491664">Update</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="no_videos_added_yet" added="1254491928">No videos added yet.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="add_a_new_video" added="1254491938">Add a New Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_category_details" added="1254492010">Video Category Details</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="name" added="1254492016">Name</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="parent_category" added="1254492030">Parent Category</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="select_form_select" added="1254492052">Select</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="update_order" added="1254492100">Update Order</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="view_this_video" added="1254492141">View This Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="step_2" added="1254492172">Step 2</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="photo" added="1254492181">Photo</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="step_1" added="1254492220">Step 1</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="save" added="1254492263">Save</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_photo" added="1254492274">Video Photo</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="here" added="1254492361">here</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="click_to_delete_this_image" added="1254492819"><![CDATA[Click <a href="#" onclick="{on_delete_image}">here</a> to delete this image and upload a new one in its place.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1254567468">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="the_file_size_limit_is" added="1254568982">The file size limit is {iMaxFileSize_filesize}. If your upload does not work, try uploading a smaller picture.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="you_have_not_added_any_videos" added="1254569091">You have not added any videos.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="browse_other_videos" added="1254569752">Browse Other Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="no_videos_have_been_added" added="1254569764">No videos have been added.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="there_is_one_video_that_is_pending_approval" added="1254569791">There is one video that is pending approval.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="there_are_ivideoapprovecnt_videos_that_are_pending_approval" added="1254569811">There are {iVideoApproveCnt} videos that are pending approval.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="click_here_to_approve_videos" added="1254569985"><![CDATA[Click <a href="{sLinkPendingVideos}">here</a> to approve videos.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_url" added="1254570126">Video URL</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="supported_sites" added="1254570139">Supported sites</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="add" added="1254570150">Add</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="add_a_video" added="1254570165">Add a Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="view_your_videos" added="1254570239">View Your Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="upload_more_videos" added="1254570254">Upload More Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="uploading" added="1254570297">Uploading</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="upload_copyrights_notice" added="1254570328">You retain all rights in your video that you upload. You must only upload videos in which you own all the rights. If you upload any videos in which you do not own all the rights, you may be violating copyright law.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="copyright_consequences_notice" added="1254570461">Uploading copyrighted videos without the explicit consent of the copyright owner will result in your profile being cancelled.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="select_video" added="1254570475">Select Video</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="you_can_upload_a_sfileext_file" added="1254570500">You can upload a {sFileExt} file.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="max_file_size_iuploadlimit" added="1254570537">Max file size: {iUploadLimit}</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_is_being_processed" added="1254570641">Video is being processed.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="video_is_pending_approval" added="1254570697">Video is pending approval.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="user_link_has_not_added_any_videos" added="1254570788">{user_link} has not added any videos.</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="date_added" added="1254570903">Date Added</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="popular" added="1254570916">Popular</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="most_discussed" added="1254570931">Most Discussed</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="most_viewed" added="1254570958">Most Viewed</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="recent_videos" added="1254570986">Recent Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="sort" added="1254571208">Sort</phrase>
		<phrase module_id="video" version_id="2.0.0rc3" var_name="in_sorting_order" added="1254571227">in</phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="manage_videos" added="1255354432">Manage Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="your_video_title_has_been_approved" added="1255354861"><![CDATA[Your video "{title}" has been approved.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="view_videos" added="1255354886">View Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="a_href_user_link_owner_full_name_a_added_a_new_video_a_href_title_link_title_a" added="1255354930"><![CDATA[<a href="{user_link}">{owner_full_name}</a> added a new video "<a href="{title_link}">{title}</a>".]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_video_a" added="1255355112"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">video</a>.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_video_a" added="1255355165"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">video</a>.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link_item_user_name_s_a_a_href_title_link_video_a" added="1255355190"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">video</a>.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="on_name_s_video" added="1255355310"><![CDATA[On {name}'s video.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title" added="1255355342">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_your_video_title" added="1255355395"><![CDATA[{user_name} left you a comment on your video "{title}".

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc4" var_name="video_text" added="1255860208">Video Text</phrase>
		<phrase module_id="video" version_id="2.0.0rc6" var_name="added" added="1256899507">Added</phrase>
		<phrase module_id="video" version_id="2.0.0rc6" var_name="comments" added="1256899516">Comments</phrase>
		<phrase module_id="video" version_id="2.0.0rc6" var_name="view" added="1256899530">View</phrase>
		<phrase module_id="video" version_id="2.0.0rc6" var_name="embedding_this_video_is_not_allowed_try_another_video" added="1256905055">Embedding this video is not allowed. Try another video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc6" var_name="full_name_wrote_a_comment_on_your_video" added="1257316881"><![CDATA[<a href="{user_link}">{full_name}</a> wrote a comment on your video "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc7" var_name="un_feature_this_video" added="1257799894">Un-Feature this video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc8" var_name="user_setting_points_video" added="1258461532">Points received when adding a video.</phrase>
		<phrase module_id="video" version_id="2.0.0rc8" var_name="tags" added="1258733037">Tags</phrase>
		<phrase module_id="video" version_id="2.0.0rc8" var_name="view_more_videos" added="1258739743">View More Videos</phrase>
		<phrase module_id="video" version_id="2.0.0rc8" var_name="video_added_on_time_stamp_by_full_name" added="1258739906"><![CDATA[<a href="{link}">Video</a> added on {time_stamp} by <a href="{user_link}">{full_name}</a>.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc8" var_name="update_video_view_count" added="1258986172"><![CDATA[Update video "view" count (Only for those that upgraded from v1.6.21).]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc8" var_name="total_views" added="1259000889">{total} views</phrase>
		<phrase module_id="video" version_id="2.0.0rc10" var_name="favorite" added="1259352726">Favorite</phrase>
		<phrase module_id="video" version_id="2.0.0rc11" var_name="user_setting_can_access_videos" added="1260286300">Can browse and view the video module?</phrase>
		<phrase module_id="video" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_video_a" added="1260472724"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">video</a>.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_a_href_link_video_a" added="1260472742"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">video</a>.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_video_a" added="1260472757"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">video</a>.]]></phrase>
		<phrase module_id="video" version_id="2.0.0rc12" var_name="upload_videos" added="1260904165">Upload Videos</phrase>
		<phrase module_id="video" version_id="2.0.0" var_name="update_tags_videos" added="1261056044">Update Tags (Videos)</phrase>
		<phrase module_id="video" version_id="2.0.0" var_name="1_view" added="1261163385">1 view</phrase>
		<phrase module_id="video" version_id="2.0.0" var_name="no_videos_found" added="1261413540">No videos found.</phrase>
		<phrase module_id="video" version_id="2.0.0" var_name="total_rating_out_of_10" added="1261569933">{total_rating} out of 10</phrase>
		<phrase module_id="video" version_id="2.0.2" var_name="rss_group_name_4" added="1263216651">Videos</phrase>
		<phrase module_id="video" version_id="2.0.2" var_name="rss_title_5" added="1263216811">Latest Videos</phrase>
		<phrase module_id="video" version_id="2.0.2" var_name="rss_description_5" added="1263216811">List of all the latest videos.</phrase>
		<phrase module_id="video" version_id="2.0.4" var_name="please_provide_a_valid_url_for_your_video" added="1266501161">Please provide a valid URL for your video.</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="user_setting_can_sponsor_video" added="1270026188">Can members of this user group mark videos as sponsor?</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="unsponsor_this_video" added="1270026492">Unsponsor this video</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="sponsor_this_video" added="1270026503">Sponsor this video</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="video_successfully_sponsored" added="1270029791">Video successfully sponsored.</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="video_successfully_un_sponsored" added="1270029804">Video successfully unsponsored.</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="sponsored_video" added="1270031934">Sponsored Video</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="user_setting_can_purchase_sponsor" added="1271076186">Can members of this user group purchase a sponsored ad space?</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="sponsor_help" added="1271148643"><![CDATA[To purchase sponsor space for your video, view your video by clicking on it and then click on "Sponsor" on the right hand side menu]]></phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="encourage_sponsor" added="1271150347">Sponsor your Videos</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="user_setting_video_sponsor_price" added="1271756668">How much is the sponsor space worth?
This works in a CPM basis.</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="sponsor_paypal_message" added="1271941483">Payment for the sponsor space of video: {sVideoTitle}</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="sponsor_title" added="1271941956">Video: {sVideoTitle}</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="sponsor_error_not_found" added="1271942415">The video you are trying to sponsor cannot be found.</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="user_setting_auto_publish_sponsored_item" added="1272007206">After the user has purchased a sponsored space, should the video be published right away?
If set to false, the admin will have to approve each new purchased sponsored video space before it is shown in the site.</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="comments_total_comment" added="1273233241">Comments ({total_comment})</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="total_score_out_of_10" added="1273233268">{total_score} out of 10</phrase>
		<phrase module_id="video" version_id="2.0.5dev2" var_name="user_setting_flood_control_videos" added="1275107164"><![CDATA[How many minutes should a user wait before they can share/upload another video?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></phrase>
		<phrase module_id="video" version_id="2.0.5dev2" var_name="you_are_sharing_a_video_a_little_too_soon" added="1275107266">You are sharing a video a little too soon.</phrase>
		<phrase module_id="video" version_id="2.0.5dev2" var_name="you_are_uploading_a_video_a_little_too_soon" added="1275107571">You are uploading a video a little too soon.</phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="setting_params_for_ffmpeg" added="1275917842"><![CDATA[<title>Params for FFMPEG</title><info>This is the string to be used when converting videos using ffmpeg. 
The following replacements apply:
{source} path and file of the video to convert
{destination} path and file of the converted video
{width} frame width
{height} frame height</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="setting_params_for_mencoder" added="1275918473"><![CDATA[<title>Params for Mencoder</title><info>This is the string to be used when converting videos using mencoder.
The following replacements apply:
{source} path and file of the video to convert
{destination} path and file of the converted video
{width} frame width
{height} frame height</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="setting_params_for_mencoder_fallback" added="1275919046"><![CDATA[<title>Fallback Params for Mencoder</title><info>In case the first mencoder call fails this other param will be used in a subsequent call. The following replacements apply:
{source} path and file of the video to convert
{destination} path and file of the converted video
{width} frame width
{height} frame height</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="setting_flvtool2_path" added="1275991521"><![CDATA[<title>Path to FLVTool2</title><info>Path to FLVTool2</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="setting_params_for_flvtool2" added="1275991617"><![CDATA[<title>Params for FLVTool2</title><info>This is the string to be used when calling FLVTool2. The following replacements apply:
{source} path and file of the video to convert
{destination} path and file of the converted video
{width} frame width
{height} frame height</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.5" var_name="setting_enable_flvtool2" added="1275992422"><![CDATA[<title>Enable FLVTool2</title><info>Should the script call FLVTool2 after converting videos?</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.7" var_name="setting_close_sql_connection_while_converting" added="1288619093"><![CDATA[<title>Close SQL Connection During Conversion</title><info>Enable this option to close the SQL connection while converting videos.</info>]]></phrase>
		<phrase module_id="video" version_id="3.0.0Beta1" var_name="video" added="1302203053">Video</phrase>
		<phrase module_id="video" version_id="3.0.0Beta1" var_name="say_something_about_this_video" added="1302203060">Say something about this video...</phrase>
		<phrase module_id="video" version_id="2.0.8" var_name="setting_video_enable_mass_uploader" added="1295446768"><![CDATA[<title>Enable Mass Uploader</title><info>When enabled users will be allowed to use SWFUpload to upload videos, this shows a progress bar for the percentage of the video that has been uploaded. 

This uses an integration of SWFUpload (http://code.google.com/p/swfupload/) and thus it uses a Flash object.</info>]]></phrase>
		<phrase module_id="video" version_id="2.0.8" var_name="use_simple_uploader" added="1296655127">Use simple uploader</phrase>
		<phrase module_id="video" version_id="2.0.8" var_name="use_mass_uploader" added="1296655149">Use mass uploader</phrase>
		<phrase module_id="video" version_id="2.1.0beta1" var_name="setting_allow_youtube_iframe" added="1299846652"><![CDATA[<title>Allow iFrame From Youtube</title><info>iFrames pose a security risk and are disabled by default in the script. 
If you want to allow users to embed videos from youtube you can enable iframes only for youtube here.</info>]]></phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="viewing_video" added="1319121862">Viewing Video</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="title" added="1319122758">Title</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="select_a_video_to_attach" added="1319122771">Select a video to attach.</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="video_has_been_approved" added="1319183708">Video has been approved.</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="video_approved" added="1319183716">Video Approved</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="go_advanced_uppercase" added="1319198040">Go Advanced</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="cancel_uppercase" added="1319198053">Cancel</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="search_videos" added="1319198077">Search Videos...</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="latest" added="1319198083">Latest</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="most_liked" added="1319198098">Most Liked</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="all_videos" added="1319198120">All Videos</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="my_videos" added="1319198127">My Videos</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="friends_videos" added="1319198136"><![CDATA[Friends' Videos]]></phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="featured_videos" added="1319198144">Featured Videos</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="topic" added="1319198185">Topic</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="approve" added="1319198200">Approve</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="your_video_has_successfully_been_uploaded_please_standby_while_we_convert_your_video" added="1319198239">Your video has successfully been uploaded. Please standby while we convert your video.</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="upload_problems_try_the_basic_uploader" added="1319198271"><![CDATA[Upload problems? Try the <a href="{link}">basic uploader</a> (works on older computers and web browsers).]]></phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="upload" added="1319198287">Upload</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="click_here_to_view_a_list_of_supported_sites" added="1319198319"><![CDATA[Click <a href="#" onclick="$Core.box('video.supportedSites', 600); return false;">here</a> to view a list of supported sites you can import videos from.]]></phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="privacy" added="1319198327">Privacy</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="control_who_can_see_this_video" added="1319198336">Control who can see this video.</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="comment_privacy" added="1319198343">Comment Privacy</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="control_who_can_comment_on_this_video" added="1319198352">Control who can comment on this video.</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="link" added="1319198605">Link</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="un_sponsor" added="1319198617">Un-Sponsor</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="sponsor" added="1319198623">Sponsor</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="feature" added="1319198632">Feature</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="un_feature" added="1319198641">Un-Feature</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="sponsored" added="1319198652">Sponsored</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="moderate" added="1319198660">Moderate</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="by_full_name" added="1319198682">by {full_name}</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="actions" added="1319198997">Actions</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="show_more" added="1319199102">Show More</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="show_less" added="1319199109">Show Less</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="report_this_video" added="1319199203">Report this video</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="unable_to_view_this_item_due_to_privacy_settings" added="1319199213">Unable to view this item due to privacy settings.</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="editing_video" added="1319199289">Editing Video</phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="full_name_liked_your_video_title" added="1319530124"><![CDATA[{full_name} liked your video "{title}"]]></phrase>
		<phrase module_id="video" version_id="3.0.0beta5" var_name="full_name_liked_your_video_message" added="1319530311"><![CDATA[{full_name} liked your video "<a href="{link}">{title}</a>"
To view this video follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="video" version_id="3.0.0rc1" var_name="by_lowercase" added="1320414457">by</phrase>
		<phrase module_id="video" version_id="3.0.0rc1" var_name="views" added="1320414463">views</phrase>
		<phrase module_id="video" version_id="3.0.0rc2" var_name="upload_share_a_video" added="1321349685">Upload/Share a Video</phrase>
		<phrase module_id="video" version_id="3.0.0rc2" var_name="paste_url" added="1321349709">Paste URL</phrase>
		<phrase module_id="video" version_id="3.0.0rc2" var_name="file_upload" added="1321349717">File Upload</phrase>
		<phrase module_id="video" version_id="3.0.0rc2" var_name="who_can_share_videos" added="1321360764">Who can share videos?</phrase>
		<phrase module_id="video" version_id="3.0.0rc2" var_name="who_can_view_browse_videos" added="1321360777">Who can view/browse videos?</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="update_user_video_count" added="1322462306">Update User Video Count</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="full_name_commented_on_your_video_title" added="1322465905"><![CDATA[{full_name} commented on your video "{title}".]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1322733641">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="posted_a_comment_on_gender_video" added="1322733804">posted a comment on {gender} video</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="posted_a_comment_on_user_name_s_video" added="1322733958"><![CDATA[posted a comment on {user_name}'s video]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="full_name_commented_on_your_video_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322734285"><![CDATA[{full_name} commented on your video "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="full_name_commented_on_gender_video" added="1322734362">{full_name} commented on {gender} video.</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_video" added="1322734464"><![CDATA[{full_name} commented on {other_full_name}'s video.]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="full_name_commented_on_gender_video_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322734665"><![CDATA[{full_name} commented on {gender} video "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_video_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322734859"><![CDATA[{full_name} commented on {other_full_name}'s video "<a href="{link}">{title}</a>.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="user_name_liked_gender_own_video_title" added="1322735128"><![CDATA[{user_name} liked {gender} own video "{title}"]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="user_name_liked_your_video_title" added="1322735324"><![CDATA[{user_name} liked your video "{title}"]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="user_name_liked_span_class_drop_data_user_full_name_s_span_video_title" added="1322735723"><![CDATA[{user_name} liked <span class="drop_data_user">{full_name}'s</span> video "{title}"]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="user_name_commented_on_gender_video_title" added="1322735795"><![CDATA[{user_name} commented on {gender} video "{title}"]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="user_name_commented_on_your_video_title" added="1322735885"><![CDATA[{user_name} commented on your video "{title}"]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="user_name_commented_on_span_class_drop_data_user_full_name_s_span_video_title" added="1322736016"><![CDATA[{user_name} commented on <span class="drop_data_user">{full_name}'s</span> video "{title}"]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="span_no_more_suggestions_found_span" added="1322739044"><![CDATA[<span>No more suggestions found</span>]]></phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="video_s_successfully_approved" added="1322739062">Video(s) successfully approved.</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="video_s_successfully_deleted" added="1322739077">Video(s) successfully deleted.</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="suggestions" added="1323096802">Suggestions</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="load_more_suggestions" added="1323096814">Load More Suggestions</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="user_setting_can_feature_videos_" added="1323336926">Can feature videos?</phrase>
		<phrase module_id="video" version_id="3.0.0" var_name="can_feature_videos" added="1323337001">Can feature videos?</phrase>
		<phrase module_id="video" version_id="3.0.1" var_name="setting_group_embedly" added="1327498650"><![CDATA[<title>Embed.ly</title><info>Embedly provides a powerful API to convert standard URLs into embedded videos and images.</info>]]></phrase>
		<phrase module_id="video" version_id="3.0.1" var_name="setting_enabled_embedly_import" added="1327499697"><![CDATA[<title>Enable Embed.ly Support</title><info><a href="http://embed.ly/" target="_blank">Embedly</a> provides a powerful API to convert standard URLs into embedded videos, images, and rich article previews from 218 leading providers.</info>]]></phrase>
		<phrase module_id="video" version_id="3.0.1" var_name="setting_embedly_api_key" added="1327500393"><![CDATA[<title>Embed.ly API Key</title><info>Enter your API key here.</info>]]></phrase>
		<phrase module_id="video" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_a_video" added="1331220935">{user_name} tagged you in a comment in a video</phrase>
		<phrase module_id="video" version_id="3.1.0rc1" var_name="menu_video_videos_532c28d5412dd75bf975fb951c740a30" added="1332258041">Videos</phrase>
		<phrase module_id="video" version_id="3.3.0beta2" var_name="converting_video" added="1340288404">Converting Video</phrase>
		<phrase module_id="video" version_id="3.3.0beta2" var_name="setting_vidly_support" added="1340653094"><![CDATA[<title>Enable Vid.ly Support</title><info>Set to <b>True</b> to enable <a href="http://vid.ly" target="_blank">Vid.ly</a> support.</info>]]></phrase>
		<phrase module_id="video" version_id="3.3.0beta2" var_name="setting_video_upload_private_key" added="1341145410"><![CDATA[<title>Video Upload Private Key</title><info>Enter your video upload private key here.</info>]]></phrase>
		<phrase module_id="video" version_id="3.3.0beta2" var_name="setting_video_upload_public_key" added="1341145872"><![CDATA[<title>Video Upload Public Key</title><info>Enter your video upload public key here.</info>]]></phrase>
		<phrase module_id="video" version_id="3.3.0beta2" var_name="setting_video_upload_service" added="1341145938"><![CDATA[<title>Video Upload Service</title><info>Enable this option if you have our video upload service.</info>]]></phrase>
		<phrase module_id="video" version_id="3.3.0beta2" var_name="setting_vidly_user_key" added="1341168583"><![CDATA[<title>Vid.ly User Key</title><info>Enter your Vid.ly User Key here.</info>]]></phrase>
		<phrase module_id="video" version_id="3.3.0beta2" var_name="setting_vidly_api_key" added="1341249013"><![CDATA[<title>Vid.ly API key</title><info>Enter your Vid.ly API key here.</info>]]></phrase>
		<phrase module_id="video" version_id="3.3.0rc1" var_name="not_a_valid_video_site_url" added="1341562252">Not a valid video site URL.</phrase>
		<phrase module_id="video" version_id="3.4.0beta1" var_name="setting_group_vidly" added="1345048886"><![CDATA[<title>Vid.ly</title><info>Settings for vid.ly.</info>]]></phrase>
		<phrase module_id="video" version_id="3.4.0" var_name="the_php_function_exec_is_disabled_and_needed_to_run_this_check_and_convert_uploaded_videos" added="1350977803"><![CDATA[The PHP function "exec" is disabled and needed to run this check and convert uploaded videos]]></phrase>
		<phrase module_id="video" version_id="3.4.0" var_name="must_set_the_path_to_ffmpeg_before_enabling_uploading_of_videos" added="1350977825">Must set the path to FFMPEG before enabling uploading of videos.</phrase>
		<phrase module_id="video" version_id="3.5.0beta1" var_name="item_phrase" added="1352730777">video</phrase>
		<phrase module_id="video" version_id="3.5.0beta1" var_name="setting_use_youtube_iframe" added="1353335900"><![CDATA[<title>Use Youtube iFrame</title><info>If enabled the script will use an iFrame instead of an object when displaying a video from Youtube.</info>]]></phrase>
	</phrases>
	<rss_group>
		<group module_id="video" group_id="4" name_var="video.rss_group_name_4" is_active="1" />
	</rss_group>
	<rss>
		<feed module_id="video" group_id="4" title_var="video.rss_title_5" description_var="video.rss_description_5" feed_link="video" is_active="1" is_site_wide="1">
			<php_group_code></php_group_code>
			<php_view_code><![CDATA[$aRows = Phpfox::getService('video')->getForRssFeed();]]></php_view_code>
		</feed>
	</rss>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="1" guest="0" staff="1" module="video" ordering="0">can_add_comment_on_video</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="1" guest="0" staff="1" module="video" ordering="0">can_edit_own_video</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="0" guest="0" staff="1" module="video" ordering="0">can_edit_other_video</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="1" guest="0" staff="1" module="video" ordering="0">can_delete_own_video</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="0" guest="0" staff="1" module="video" ordering="0">can_delete_other_video</setting>
		<setting is_admin_setting="0" module_id="video" type="integer" admin="75" user="75" guest="0" staff="75" module="video" ordering="0">video_file_size_limit</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="1" guest="0" staff="1" module="video" ordering="0">can_upload_videos</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="0" guest="0" staff="1" module="video" ordering="0">can_feature_videos_</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="0" user="0" guest="0" staff="0" module="video" ordering="0">approve_video_before_display</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="0" guest="0" staff="1" module="video" ordering="0">can_approve_videos</setting>
		<setting is_admin_setting="0" module_id="video" type="integer" admin="500" user="500" guest="500" staff="500" module="video" ordering="0">max_size_for_video_photos</setting>
		<setting is_admin_setting="0" module_id="video" type="integer" admin="1" user="1" guest="0" staff="1" module="video" ordering="0">points_video</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="1" user="1" guest="1" staff="1" module="video" ordering="0">can_access_videos</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="false" user="false" guest="false" staff="false" module="video" ordering="0">can_sponsor_video</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="false" user="false" guest="false" staff="false" module="video" ordering="0">can_purchase_sponsor</setting>
		<setting is_admin_setting="0" module_id="video" type="string" admin="null" user="null" guest="null" staff="null" module="video" ordering="0">video_sponsor_price</setting>
		<setting is_admin_setting="0" module_id="video" type="boolean" admin="true" user="false" guest="false" staff="false" module="video" ordering="0">auto_publish_sponsored_item</setting>
		<setting is_admin_setting="0" module_id="video" type="integer" admin="0" user="0" guest="0" staff="0" module="video" ordering="0">flood_control_videos</setting>
	</user_group_settings>
	<tables><![CDATA[a:10:{s:12:"phpfox_video";a:3:{s:7:"COLUMNS";a:31:{s:8:"video_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"in_process";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_stream";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_featured";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"is_spotlight";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"destination";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"file_ext";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"duration";a:4:{i:0;s:7:"VCHAR:8";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:12:"resolution_x";a:4:{i:0;s:7:"VCHAR:4";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:12:"resolution_y";a:4:{i:0;s:7:"VCHAR:4";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"image_server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_score";a:4:{i:0;s:9:"DECIMAL:4";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_rating";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_viewed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"custom_v_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"video_id";s:4:"KEYS";a:9:{s:10:"in_process";a:2:{i:0;s:5:"INDEX";i:1;s:10:"in_process";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}s:12:"in_process_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"item_id";i:3;s:7:"privacy";}}s:12:"in_process_3";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"item_id";i:3;s:7:"user_id";}}s:12:"in_process_4";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"item_id";i:3;s:7:"privacy";i:4;s:5:"title";}}s:12:"in_process_5";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"item_id";i:3;s:7:"privacy";i:4;s:7:"user_id";}}s:12:"in_process_6";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"privacy";i:3;s:5:"title";}}s:11:"custom_v_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"custom_v_id";}}}s:21:"phpfox_video_category";a:3:{s:7:"COLUMNS";a:7:{s:11:"category_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"used";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"category_id";s:4:"KEYS";a:2:{s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"parent_id";i:1;s:9:"is_active";}}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:26:"phpfox_video_category_data";a:2:{s:7:"COLUMNS";a:2:{s:8:"video_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"category_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:11:"category_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"category_id";}s:8:"video_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"video_id";}}}s:19:"phpfox_video_custom";a:3:{s:7:"COLUMNS";a:3:{s:8:"track_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"hash_id";a:4:{i:0;s:8:"VCHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"track_id";s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:18:"phpfox_video_embed";a:2:{s:7:"COLUMNS";a:3:{s:8:"video_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"video_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"embed_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:8:"video_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:8:"video_id";}}}s:19:"phpfox_video_rating";a:3:{s:7:"COLUMNS";a:5:{s:7:"rate_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"rating";a:4:{i:0;s:9:"DECIMAL:4";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"rate_id";s:4:"KEYS";a:2:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}s:9:"item_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"item_id";}}}s:17:"phpfox_video_text";a:2:{s:7:"COLUMNS";a:3:{s:8:"video_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"text_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:8:"video_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:8:"video_id";}}}s:18:"phpfox_video_track";a:2:{s:7:"COLUMNS";a:4:{s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:10:"ip_address";}}}}s:12:"phpfox_vidly";a:3:{s:7:"COLUMNS";a:6:{s:8:"vidly_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:4:"hash";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_complete";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"video_data";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:8:"vidly_id";s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:11:"is_complete";}}}}s:16:"phpfox_vidly_url";a:2:{s:7:"COLUMNS";a:4:{s:8:"video_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"video_url";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"vidly_url_id";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"upload_video_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:8:"video_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:8:"video_id";}}}}]]></tables>
	<install><![CDATA[
		$aCategories = array(
			'Autos & Vehicles',
			'Comedy',
			'Education',
			'Entertainment',
			'Film & Animation',
			'Gaming',
			'Howto & Style',
			'News & Politics',
			'Nonprofits & Activism',
			'People & Blogs',
			'Pets & Animals',
			'Science & Technology',
			'Sports',
			'Travel & Events'
		);		
		
		$iCategoryOrder = 0;
		foreach ($aCategories as $sCategory)
		{
			$iCategoryOrder++;
			$iCategoryId = $this->database()->insert(Phpfox::getT('video_category'), array(					
					'name' => $sCategory,
					'is_active' => 1,
					'ordering' => $iCategoryOrder			
				)
			);			
		}		
	]]></install>
</module>