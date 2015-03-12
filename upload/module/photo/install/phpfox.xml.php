<module>
	<data>
		<module_id>photo</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:1:{s:27:"photo.admin_menu_categories";a:1:{s:3:"url";a:1:{i:0;s:5:"photo";}}}]]></menu>
		<phrase_var_name>module_photo</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:15:"file/pic/photo/";}]]></writable>
	</data>
	<menus>
		<menu module_id="photo" parent_var_name="" m_connection="main" var_name="menu_photo" ordering="22" url_value="photo" version_id="2.0.0alpha1" disallow_access="" module="photo" />
		<menu module_id="photo" parent_var_name="" m_connection="profile" var_name="menu_photos" ordering="38" url_value="profile.photo" version_id="2.0.0alpha1" disallow_access="" module="photo" />
		<menu module_id="photo" parent_var_name="" m_connection="photo.index" var_name="menu_photo_upload_a_new_image_714586c73197300f65ba08f7dee8cb4a" ordering="128" url_value="photo.add" version_id="3.3.0beta2" disallow_access="" module="photo" />
		<menu module_id="photo" parent_var_name="" m_connection="mobile" var_name="menu_photo_photos_532c28d5412dd75bf975fb951c740a30" ordering="122" url_value="photo" version_id="3.1.0rc1" disallow_access="" module="photo" mobile_icon="small_photos.png" />
		<menu module_id="photo" parent_var_name="" m_connection="photo.albums" var_name="menu_photo_upload_a_new_image_0df7df42d810e7978c535292f273fc91" ordering="129" url_value="photo.add" version_id="3.5.0beta1" disallow_access="" module="photo" />
	</menus>
	<settings>
		<setting group="" module_id="photo" is_hidden="0" type="array" var_name="photo_pic_sizes" phrase_var_name="setting_photo_pic_sizes" ordering="1" version_id="2.0.0alpha1"><![CDATA[s:93:"array(
  0 => '75',
  1 => '100',
  2 => '150',
  3 => '240',
  4 => '500',
  5 => '1024'
);";]]></setting>
		<setting group="" module_id="photo" is_hidden="0" type="integer" var_name="total_photo_input_bars" phrase_var_name="setting_total_photo_input_bars" ordering="1" version_id="2.0.0alpha1">5</setting>
		<setting group="time_stamps" module_id="photo" is_hidden="0" type="string" var_name="photo_image_details_time_stamp" phrase_var_name="setting_photo_image_details_time_stamp" ordering="1" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="protect_photos_from_public" phrase_var_name="setting_protect_photos_from_public" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="can_rate_on_photos" phrase_var_name="setting_can_rate_on_photos" ordering="1" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="photo" is_hidden="0" type="integer" var_name="rating_total_photos_cache" phrase_var_name="setting_rating_total_photos_cache" ordering="1" version_id="2.0.0alpha1">10</setting>
		<setting group="" module_id="photo" is_hidden="0" type="integer" var_name="photo_battle_image_cache" phrase_var_name="setting_photo_battle_image_cache" ordering="1" version_id="2.0.0alpha1">10</setting>
		<setting group="" module_id="photo" is_hidden="0" type="integer" var_name="total_tags_on_photos" phrase_var_name="setting_total_tags_on_photos" ordering="1" version_id="2.0.0beta4">40</setting>
		<setting group="search_engine_optimization" module_id="photo" is_hidden="0" type="large_string" var_name="photo_meta_description" phrase_var_name="setting_photo_meta_description" ordering="8" version_id="2.0.0rc1">Check out our photo gallery.</setting>
		<setting group="search_engine_optimization" module_id="photo" is_hidden="0" type="large_string" var_name="photo_meta_keywords" phrase_var_name="setting_photo_meta_keywords" ordering="14" version_id="2.0.0rc1">photo, photos, albums, gallery</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="ajax_refresh_on_featured_photos" phrase_var_name="setting_ajax_refresh_on_featured_photos" ordering="1" version_id="2.0.0">1</setting>
		<setting group="search_engine_optimization" module_id="photo" is_hidden="0" type="integer" var_name="how_many_categories_to_show_in_title" phrase_var_name="setting_how_many_categories_to_show_in_title" ordering="15" version_id="2.0.4">0</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="auto_crop_photo" phrase_var_name="setting_auto_crop_photo" ordering="1" version_id="3.0.0beta1">0</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="view_photos_in_theater_mode" phrase_var_name="setting_view_photos_in_theater_mode" ordering="1" version_id="3.0.0beta3">1</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="enable_photo_battle" phrase_var_name="setting_enable_photo_battle" ordering="1" version_id="3.0.0">1</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="display_profile_photo_within_gallery" phrase_var_name="setting_display_profile_photo_within_gallery" ordering="1" version_id="3.1.0beta1">1</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="allow_photo_category_selection" phrase_var_name="setting_allow_photo_category_selection" ordering="1" version_id="3.1.0rc1">0</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="rename_uploaded_photo_names" phrase_var_name="setting_rename_uploaded_photo_names" ordering="1" version_id="2.0.0alpha3">0</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="photo_upload_process" phrase_var_name="setting_photo_upload_process" ordering="1" version_id="3.3.0beta1">0</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="delete_original_after_resize" phrase_var_name="setting_delete_original_after_resize" ordering="1" version_id="3.5.0beta1">0</setting>
		<setting group="" module_id="photo" is_hidden="0" type="drop" var_name="in_main_photo_section_show" phrase_var_name="setting_in_main_photo_section_show" ordering="1" version_id="3.5.0beta1"><![CDATA[a:2:{s:7:"default";s:6:"photos";s:6:"values";a:2:{i:0;s:6:"photos";i:1;s:6:"albums";}}]]></setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="show_info_on_mouseover" phrase_var_name="setting_show_info_on_mouseover" ordering="1" version_id="3.5.0beta1">0</setting>
		<setting group="" module_id="photo" is_hidden="0" type="boolean" var_name="html5_upload_photo" phrase_var_name="setting_html5_upload_photo" ordering="1" version_id="3.7.0rc1">0</setting>
		<setting group="image_processing" module_id="photo" is_hidden="0" type="boolean" var_name="enabled_watermark_on_photos" phrase_var_name="setting_enabled_watermark_on_photos" ordering="1" version_id="2.0.0rc1">0</setting>
		<setting group="" module_id="photo" is_hidden="1" type="boolean" var_name="enable_mass_uploader" phrase_var_name="setting_enable_mass_uploader" ordering="1" version_id="2.0.8">0</setting>
		<setting group="cache" module_id="photo" is_hidden="1" type="boolean" var_name="pre_load_header_view" phrase_var_name="setting_pre_load_header_view" ordering="1" version_id="3.6.0rc1">1</setting>
		<setting group="" module_id="photo" is_hidden="1" type="boolean" var_name="rating_randomize_photos" phrase_var_name="setting_rating_randomize_photos" ordering="1" version_id="2.0.0alpha1">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="photo.index" module_id="photo" component="category" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.index" module_id="photo" component="featured" location="3" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.view" module_id="photo" component="detail" location="0" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.rate" module_id="photo" component="stat" location="3" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.rate" module_id="photo" component="category" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.battle" module_id="photo" component="category" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="group.view" module_id="photo" component="parent" location="2" is_active="1" ordering="5" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.index" module_id="photo" component="sponsored" location="3" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.album" module_id="photo" component="album-tag" location="3" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title>In This Album</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.view" module_id="photo" component="detail" location="3" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title>Photo Details</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_admincp_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_tag_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_rate_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_rate_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_rate_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_frame_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_frame_process_photo" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_frame_process_photos_done" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_frame_process_photos_done_javascript" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_frame_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_album_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_album_process_album" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_album_process_conditions" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_album_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_album_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_view_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_view_process_photo" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_view_process_controller" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_view_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_view_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_edit_image_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_edit_album_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_size_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_download_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_upload_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_upload_process_global" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_upload_process_photos" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_upload_process_display_batch" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_upload_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_upload_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_battle_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_profile_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_profile_process_album_conditions" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_profile_process_album_viewer" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_profile_process_photo_album_viewer" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_profile_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_profile_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_ajax_getphotosforrating_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_ajax_getphotosforrating_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_menu_album_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_category_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_detail_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_drop_down_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_stat_process" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_stat_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_album_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_menu_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_new_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_filter_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_featured_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_stream_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_warning_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_edit_photo_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_photo__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_category__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_category_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_rate__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_rate_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_album_get_count" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_album_get_query" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_album_getall" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_album_getalbumcount" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_album_getalbum" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_album_getnextphoto" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_album_getpreviousphoto" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_battle_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_battle_battle__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_controller_upload_form_process_hidden" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_controller_upload_form_actions" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_controller_upload_form" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_controller_upload_form_extra" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_controller_rate" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_default_controller_view_title" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_default_controller_view_extra_info" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_block_album_entry_extra_info" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_block_stat" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_default_block_photo_entry_tool" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_default_block_photo_entry_info" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_block_menu_album" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_tag_tag__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_tag_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_profile_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_parent_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_group_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_album_getforedit" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_process_add__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_public_album_clean" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_process_sponsor__end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_callback_getnewsfeedalbum_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_default_block_photo_entry_hover_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_block_menu" added="1286546859" version_id="2.0.7" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_ajax_process_done" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_album_tag_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_attachment_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_block_share_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_add_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_albums_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_browse__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_api__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_browse__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="photo" hook_type="component" module="photo" call_name="photo.component_ajax_ajax_process__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_album__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_converting_clean" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_index_brunplugin1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_index_plugin1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_view__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_view__2" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_album_process_delete__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_process_delete__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_process_approve__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_tag_process_add__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_tag_process_delete__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_block_share_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_block_share_2" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_block_share_3" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_controller_view_view_box_comment_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_controller_view_view_box_comment_2" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="photo" hook_type="template" module="photo" call_name="photo.template_controller_view_view_box_comment_3" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="photo" hook_type="service" module="photo" call_name="photo.service_callback_getprofilemenu_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="photo" hook_type="controller" module="photo" call_name="photo.component_controller_profile_1" added="1358258443" version_id="3.5.0beta1" />
	</hooks>
	<components>
		<component module_id="photo" component="category" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="index" m_connection="photo.index" module="photo" is_controller="1" is_block="0" is_active="1" />
		<component module_id="photo" component="featured" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="filter" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="detail" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="menu" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="view" m_connection="photo.view" module="photo" is_controller="1" is_block="0" is_active="1" />
		<component module_id="photo" component="profile" m_connection="photo.profile" module="photo" is_controller="1" is_block="0" is_active="1" />
		<component module_id="photo" component="stream" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="menu-album" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="album" m_connection="photo.album" module="photo" is_controller="1" is_block="0" is_active="1" />
		<component module_id="photo" component="rate" m_connection="photo.rate" module="photo" is_controller="1" is_block="0" is_active="1" />
		<component module_id="photo" component="stat" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="battle" m_connection="photo.battle" module="photo" is_controller="1" is_block="1" is_active="1" />
		<component module_id="photo" component="parent" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="profile" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="upload" m_connection="photo.upload" module="photo" is_controller="1" is_block="0" is_active="1" />
		<component module_id="photo" component="sponsored" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="album-tag" m_connection="" module="photo" is_controller="0" is_block="1" is_active="1" />
		<component module_id="photo" component="add" m_connection="photo.add" module="photo" is_controller="1" is_block="0" is_active="1" />
		<component module_id="photo" component="albums" m_connection="photo.albums" module="photo" is_controller="1" is_block="0" is_active="1" />
	</components>
	<stats>
		<stat module_id="photo" phrase_var="photo.stat_title_3" stat_link="photo" stat_image="photo.png" is_active="1"><![CDATA[$this->database()
->select('COUNT(*)')
->from(Phpfox::getT('photo'))
->where('view_id = 0')
->execute('getSlaveField');]]></stat>
	</stats>
	<feed_share>
		<share module_id="photo" title="{phrase var='photo.photo'}" description="{phrase var='photo.say_something_about_this_photo'}" block_name="share" no_input="0" is_frame="1" ajax_request="" no_profile="0" icon="photo.png" ordering="1" />
	</feed_share>
	<phrases>
		<phrase module_id="photo" version_id="2.0.4" var_name="setting_how_many_categories_to_show_in_title" added="1268150470"><![CDATA[<title>How many categories to show in title</title><info>When viewing a photo with categories assigned you can show these categories in the title of the page.
This setting tells how many categories to show. Set to 0 if you dont want to show categories in the title of the page when viewing a photo.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="module_photo" added="1232963935">Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="menu_photo" added="1232964074">Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="menu_photos" added="1233146048">Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_create_photo_album" added="1234005559">Can create a new photo album?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_max_number_of_albums" added="1234008456"><![CDATA[Define the total number of photo albums a user within this user group can create.

<b>Notice:</b> If you set this value to <b>null</b> it will allow them to create an unlimited amount of photo albums. Setting this value to <b>0</b> will not allow them the ability to create photo albums.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="setting_photo_pic_sizes" added="1234108211"><![CDATA[<title>Photo Image Sizes</title><info>Photo Image Sizes</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_points_photo" added="1234168710">Points received when uploading a new image.</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_upload_photos" added="1234355661">Can upload photos?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_password_protect_albums" added="1234356018">Can password protect photo albums?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_use_privacy_settings" added="1234356693">Can use privacy settings when creating an album?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="setting_total_photo_input_bars" added="1234356994"><![CDATA[<title>Upload Inputs</title><info>Define how many upload inputs should be displayed when a user is uploading photos.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_max_images_per_upload" added="1234357193"><![CDATA[Define the maximum number of images a user can upload each time they use the upload form.

<b>Notice:</b> This setting does not control how many images a user can upload in total, just how many they can upload each time they use the upload form to upload new images.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_add_to_rating_module" added="1234359086">Can add photos to the public rating sections?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_add_tags_on_photos" added="1234359767">Can add tags on photos?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_control_comments_on_photos" added="1234359856">Can control how comments behave on their photos?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_add_mature_images" added="1234360050">Can add mature images with warnings?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_search_for_photos" added="1234461616">Can search for photos?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_total_photos_displays" added="1234463967">Define how many images a user can view at once when browsing the public photo section?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_default_photo_display_limit" added="1234464570"><![CDATA[Define how many photos should be displayed by default.

<b>Notice:</b> This value must be part of the setting <setting>photo.total_photos_displays</setting> array in order to be valid.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_max_photo_display_limit" added="1234464816"><![CDATA[Define the max number of photos a user can view on each page. 

<b>Notice:</b> This value should work together with the setting <setting>photo.total_photos_displays</setting> and in most cases should either be the same value as the highest number in the array or lower. The reason to set this value lower is to show users that the gallery can at max view 100 per page but maybe you only want this specific user group to display 24 images out of that max total (100).]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_refresh_featured_photo" added="1234468064"><![CDATA[Define how many minutes or seconds the script should wait until it refreshes the feature photo.

<b>Notice:</b> To add X minutes here are some examples:
[code]
1 min
2 min
30 min
[/code]
If you would like to define it in seconds here are some examples:
[code]
20 sec
30 sec
90 sec
[/code]]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="admin_menu_categories" added="1234775140">Categories</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="setting_photo_image_details_time_stamp" added="1234855825"><![CDATA[<title>Image Details</title><info>Image Details</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_download_user_photos" added="1234869122">Can download a users photo?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_view_all_photo_sizes" added="1234872811">Can view all available photo sizes?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_edit_own_photo_album" added="1235028102">Can edit own photo album?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_edit_other_photo_albums" added="1235028151">Can edit photo albums that belong to other users?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_photo_album" added="1235065612">Can add a new photo album?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_view_hidden_photos" added="1235068622"><![CDATA[Can view hidden photos?

<b>Notice:</b> This is intended for a user group with Admin rights as this will allow them full access to all photos uploaded on the site, which in return can give them control to moderate images.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="setting_protect_photos_from_public" added="1235132674"><![CDATA[<title>Protect Photos</title><info>If you would like to protect the privacy of your members photos set this option to <b>True</b>. By enabling this feature users will not be allowed to view images via their direct path if they do not have permission to view that specific image. This will however add extra queries to the database and can add an extra strain to the server.

<b>Notice:</b> Apache "mod_rewrite" will have to be enabled to use this feature. Once you have enabled this feature you must edit the file ".htaccess" find in your sites root directory.

Look for the following in that file:
[code]
# RewriteRule ^file/pic/photo/(.*).(.*)$ static/image.php?file=$1&ext=$2
[/code]

Replace it with:
[code]
RewriteRule ^file/pic/photo/(.*).(.*)$ static/image.php?file=$1&ext=$2
[/code]
</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_delete_own_photo" added="1235400287">Can delete own photo?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_delete_other_photos" added="1235400340">Can delete photos uploaded by other users?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_edit_own_photo" added="1235499296">Can edit own photo?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_edit_other_photo" added="1235499334">Can edit photos added by other users?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_photo_mature_age_limit" added="1235502907"><![CDATA[For a photo that is marked as "Mature (Strict)" define the age limit?

<b>Note:</b>The age you define will allow users with that age or older the ability to view mature photos.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="feed_user_add_photos" added="1235639996"><![CDATA[<a href="{owner_link}">{owner_full_name}</a> added photos to their album "<a href="{link}">{album_name}</a>".]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="setting_can_rate_on_photos" added="1235920519"><![CDATA[<title>Photo Rating</title><info>Set to <b>True</b> if you would like to enable the ability for users to rate on photos uploaded by other users.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_rate_on_photos" added="1235920668">Can rate photos?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="setting_rating_total_photos_cache" added="1235920999"><![CDATA[<title>Total Photos to Cache for Rating Section</title><info>Define how many images to cache when rating images. This will load X photos when visiting the rating section and will allow users the ability to rate images at a very fast rate. Once X images have been rated the script will use AJAX to load the next round of X images.

<b>Notice:</b> "X" is the value of this specific setting.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="setting_rating_randomize_photos" added="1235921158"><![CDATA[<title>Randomize Photos in the Rating Section</title><info>Set to <b>True</b> if photos within the rating section should be randomized. If set to <b>False</b> we will display images based on the date they were uploaded in descending order.

<b>Notice:</b> Either setting will allow the users the ability to only rate an image once. Images are not recycled.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_edit_photo_categories" added="1235999973">Can edit public photo categories?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_add_public_categories" added="1236000044">Can add public photo categories?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="setting_photo_battle_image_cache" added="1236024195"><![CDATA[<title>Photo Cache for Photo Battle</title><info>Define how many images to cache when display the photo battle.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_photo_must_be_approved" added="1236065652"><![CDATA[Set this to <b>True</b> if photos uploaded must be approved before they are visible to the public.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha1" var_name="user_setting_can_approve_photos" added="1236066726">Can approve photos that require moderation?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha2" var_name="user_setting_can_feature_photo" added="1237643657">Can feature a photo?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha3" var_name="setting_rename_uploaded_photo_names" added="1239041807"><![CDATA[<title>Rename Photo Names</title><info>Set to <b>True</b> if you would like to rename a photo based on what the title of the photo or the title provided by the user when processing their recently uploaded photos. By default we use a 32 character unique hash to protect images, however enabling this feature will still create a unique ID for each image and help with image SEO.

<b>Notice:</b> Apache "mod_rewrite" will have to be enabled to use this feature. Once you have enabled this feature you must edit the file ".htaccess" find in your sites root directory.

Look for the following in that file:
[code]
# Rename Photo Names
[/code]
Under that line you will find 2 lines that have been commented out. Simply uncomment those 2 lines by removing the hash "#" symbol.
</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0alpha3" var_name="user_setting_can_delete_own_photo_album" added="1239099768">Can delete own photo album?</phrase>
		<phrase module_id="photo" version_id="2.0.0alpha3" var_name="user_setting_can_delete_other_photo_albums" added="1239099813">Can delete photo albums created by other users?</phrase>
		<phrase module_id="photo" version_id="2.0.0beta4" var_name="user_setting_can_tag_own_photo" added="1244485890">Can tag own photo?</phrase>
		<phrase module_id="photo" version_id="2.0.0beta4" var_name="user_setting_can_tag_other_photos" added="1244485972">Can tag photos added by other users?</phrase>
		<phrase module_id="photo" version_id="2.0.0beta4" var_name="user_setting_how_many_tags_on_own_photo" added="1244486244">How many times can a user tag their own photo?</phrase>
		<phrase module_id="photo" version_id="2.0.0beta4" var_name="user_setting_how_many_tags_on_other_photo" added="1244486633">How many times can this user tag photos added by other users?</phrase>
		<phrase module_id="photo" version_id="2.0.0beta4" var_name="setting_total_tags_on_photos" added="1244486871"><![CDATA[<title>Total Tags on Photos</title><info>Define how many tags a photo can have.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0beta4" var_name="stat_title_3" added="1245143473">Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc1" var_name="user_setting_photo_max_upload_size" added="1248950092"><![CDATA[Max file size for photos upload in kilobits (kb).
(1000 kb = 1 mb)
For unlimited add "0" without quotes.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc1" var_name="setting_enabled_watermark_on_photos" added="1249708251"><![CDATA[<title>Watermark Photos</title><info>Enable this option to watermark photos.

<b>Notice:</b> The setting <setting>core.watermark_option</setting> must be enabled.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc1" var_name="setting_photo_meta_description" added="1252062286"><![CDATA[<title>Photo Meta Description</title><info>Meta description for the photo sections.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc1" var_name="setting_photo_meta_keywords" added="1252062356"><![CDATA[<title>Photo Meta Keywords</title><info>Keywords for the photo sections.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="you_have_reached_your_limit_you_are_currently_unable_to_create_new_photo_albums" added="1255093572">You have reached your limit. You are currently unable to create new photo albums.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="you_have_rated_all_the_available_images" added="1255094396">No more available images to rate.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="editing_category" added="1255094413">Editing category</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="cancel" added="1255094438">Cancel</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="are_you_sure" added="1255098330">Are you sure?</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="un_feature_this_photo" added="1255098352">Un-Feature this photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="feature_this_photo" added="1255098360">Feature this photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_successfully_featured" added="1255098370">Photo successfully featured.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_successfully_un_featured" added="1255098382">Photo successfully un-featured.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_successfully_uploaded" added="1255098410">Photo successfully uploaded.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photos_successfully_uploaded" added="1255098421">Photos successfully uploaded.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="processing_image_current_total" added="1255098472">Processing image {current}/{total}</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="provide_a_name_for_your_album" added="1255098524">Provide a name for your album.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="select_a_privacy_setting_for_your_album" added="1255098533">Select a privacy setting for your album.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="categories" added="1255098543">Categories</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="image_details" added="1255098555">Image Details</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="featured_photo" added="1255098622">Featured Photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="browse_filter" added="1255098633">Browse Filter</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photos" added="1255098653">Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="view_more_photos" added="1255098663">View More Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="average_rating" added="1255098694">Average Rating</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="provide_a_name_for_your_photo_category" added="1255098718">Provide a name for your photo category.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_category_order_successfully_updated" added="1255098727">Photo category order successfully updated.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="invalid_section" added="1255098738">Invalid section.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_category_successfully_deleted" added="1255098747">Photo category successfully deleted.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_category_successfully_updated" added="1255098756">Photo category successfully updated.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_category_successfully_added" added="1255098771">Photo category successfully added.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="manage_photo_categories" added="1255098780">Manage Photo Categories</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_album_successfully_deleted" added="1255099435">Photo album successfully deleted.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="invalid_photo_album" added="1255099446">Invalid photo album.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="password_is_not_correct_please_try_again" added="1255099457">Password is not correct. Please try again.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="full_name_s_photos" added="1255099478"><![CDATA[{full_name}'s Photos]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="full_name_s_photo_album_from_time_stamp" added="1255099519"><![CDATA[{full_name}'s Photo Album from {time_stamp}]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_battle" added="1255099553">Photo Battle</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="battle" added="1255099567">Battle</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="not_allowed_to_download_this_image" added="1255099580">Not allowed to download this image.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_section_is_closed" added="1255099610">Photo section is closed.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="site_title_has_a_total_of_total_photo_s" added="1255099671">{site_title} has a total of {total} photo(s).</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="section_is_private" added="1255099728">Section is private.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="full_name_s_photos_on_site_title_full_name_has_total_photo_photo_s_and_total_album_photo" added="1255100161"><![CDATA[{full_name}'s photos on {site_title}. {full_name} has {total_photo} photo(s) and {total_album} photo album(s).]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_rating_is_disabled" added="1255100253">Photo rating is disabled.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="rate_photos" added="1255100268">Rate Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="rate" added="1255100290">Rate</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_tags" added="1255100311">Photo Tags</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo" added="1255100318">Photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="tags" added="1255100325">Tags</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload_photos" added="1255100342">Upload Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photos_successfully_updated" added="1255100368">Photos successfully updated.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_s_successfully_updated" added="1255100380">Photo(s) successfully updated.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="process_photos" added="1255100393">Process Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload" added="1255100452">Upload</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="invalid_photo" added="1255101664">Invalid photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="sorry_this_photo_can_only_be_viewed_by_those_older_then_the_age_of_limit" added="1255101703">Sorry, this photo can only be viewed by those older then the age of {limit}.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="not_a_valid_photo_album_to_delete" added="1255101768">Not a valid photo album to delete.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="you_do_not_have_sufficient_permission_to_delete_this_photo_album" added="1255101778">You do not have sufficient permission to delete this photo album.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="unable_to_find_the_photo" added="1255101869">Unable to find the photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="this_photo_is_already_tagged_in_the_same_position" added="1255101890">This photo is already tagged in the same position.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="no_more_tags_for_this_photo_can_be_added" added="1255101900">No more tags for this photo can be added.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="full_name_has_already_been_tagged_in_this_photo" added="1255101918">{full_name} has already been tagged in this photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="provide_a_photo_tag" added="1255101946">Provide a photo tag.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="not_allowed_to_tag_this_photo" added="1255101956">Not allowed to tag this photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="unable_to_find_photo" added="1255101967">Unable to find photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="unable_to_delete_this_tag" added="1255101979">Unable to delete this tag.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="a_href_profile_link_owner_full_name_a_uploaded_a_new_photo" added="1255156765"><![CDATA[<a href="{profile_link}">{owner_full_name}</a> uploaded a new photo.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="a_href_profile_link_owner_full_name_a_uploaded_new_photos" added="1255156843"><![CDATA[<a href="{profile_link}">{owner_full_name}</a> uploaded new photos.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_photo" added="1255156971"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">photo</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_photo_a" added="1255157021"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">photo</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on" added="1255157088"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">photo</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title" added="1255157199">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title_message" added="1255157259"><![CDATA[{user_name} left you a comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title_however_before_it_can_be_displayed_it_needs_to_be" added="1255157349"><![CDATA[{user_name} left you a comment on {site_title}, however before it can be displayed it needs to be approved by you.

You can approve or deny this comment by following the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_wrote_a_comment_on_your_photo_a_href_photo_link_title" added="1255158733"><![CDATA[<a href="{user_link}">{full_name}</a> wrote a comment on your photo "<a href="{photo_link}">{title}</a>".]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="on_name_s_photo" added="1255158838"><![CDATA[On {name}'s photo.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="full_name_approved_your_comment_on_site_title" added="1255158932">{full_name} approved your comment on {site_title}.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="full_name_approved_your_comment_on_site_title_message" added="1255158993"><![CDATA[{full_name} approved your comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="a_href_photo_section_link_photo_a_uploaded_on_time_stamp_by_a_href_user_link" added="1255159132"><![CDATA[<a href="{photo_section_link}">Photo</a> uploaded on {time_stamp} by <a href="{user_link}">{full_name}</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_albums" added="1255159204">Photo Albums</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload_a_photo" added="1255159230">Upload a Photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="manage_photos" added="1255159237">Manage Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="view_photos" added="1255159267">View Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="unable_to_find_the_photo_you_plan_to_edit" added="1255159921">Unable to find the photo you plan to edit.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="updating_album" added="1255160073">Updating Album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="loading" added="1255160127">Loading</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="none_of_your_files_were_uploaded_please_make_sure_you_upload_either_a_jpg_gif_or_png_file" added="1255160204">None of your files were uploaded. Please make sure you upload either a JPG, GIF or PNG file.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="updating_photo" added="1255160312">Updating photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="password_protected_album" added="1255160379">PASSWORD PROTECTED ALBUM</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="private_album" added="1255160387">PRIVATE ALBUM</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="name_by_full_name" added="1255160410">{name} by {full_name}</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="view_more_albums_total" added="1255160470">View More Albums ({total})</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="submit" added="1255160494">Submit</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="all_categories" added="1255160526">All Categories</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="url" added="1255160539">URL</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="search_for_keyword" added="1255160559">Search for Keyword</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="display" added="1255160572">Display</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="sort" added="1255160583">Sort</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="time" added="1255160590">Time</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="most_viewed" added="1255160598">Most Viewed</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="most_talked_about" added="1255160606">Most Talked About</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="top_rated" added="1255160782">Top Rated</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="top_battle" added="1255160797">Top Battle</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="by" added="1255160804">By</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="descending" added="1255160810">Descending</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="ascending" added="1255160817">Ascending</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="name" added="1255160998">Name</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="description" added="1255161008">Description</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="privacy" added="1255161017">Privacy</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="public_photos_will_be_added_to_our_public_photo_section" added="1255162284">Public (Photos will be added to our public photo section.)</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="personal_photos_will_only_be_displayed_on_your_profile" added="1255162294">Personal (Photos will only be displayed on your profile.)</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="friends_only_you_and_your_friends_can_view_this_album" added="1255162303">Friends (Only you and your friends can view this album.)</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="preferred_list_only_you_and_the_members_you_select_can_view_this_album" added="1255162321">Preferred List (Only you and the members you select can view this album.)</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="password_protect" added="1255162339">Password-Protect</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="image_is_pending_approval" added="1255162439">Image is pending approval.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="title" added="1255162468">Title</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="category" added="1255162481">Category</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="mature_content" added="1255162491">Mature Content</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="yes_strict" added="1255162500"><![CDATA[Yes [strict]]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="yes_warning" added="1255162507"><![CDATA[Yes [warning]]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="no" added="1255162513">No</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="discussion" added="1255162520">Discussion</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="allow_comments_default" added="1255162529">Allow comments (default)</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="encourage_advanced_critique" added="1255162539">Encourage advanced critique</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="discourage_criticism" added="1255162547">Discourage criticism</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="moderate_comments_first" added="1255162554">Moderate comments first</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="disable_comments" added="1255162562">Disable comments</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="public_rating" added="1255162574">Public Rating</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="yes" added="1255162585">Yes</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="download_enabled" added="1255162599">Download Enabled</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="enabling_this_option_will_allow_others_the_rights_to_download_this_photo" added="1255162616">Enabling this option will allow others the rights to download this photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="enabling_this_option_will_allow_others_the_rights_to_download_these_photos" added="1255162622">Enabling this option will allow others the rights to download these photos.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="report_a_photo_album" added="1255162727">Report a Photo Album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="report" added="1255162734">Report</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="add_to_your_favorites" added="1255162744">Add to your Favorites</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="add_to_favorites" added="1255162752">Add to Favorites</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="edit_this_album" added="1255162760">Edit This Album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload_photos_to_album" added="1255162767">Upload Photos to Album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="delete" added="1255162773">Delete</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="view_all_sizes" added="1255162789">View All Sizes</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="report_a_photo" added="1255162798">Report a Photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="download" added="1255162827">Download</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="edit_this_photo" added="1255162835">Edit this Photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload_a_new_image" added="1255162844">Upload a New Image</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="delete_this_photo" added="1255162853">Delete this Photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="rotate_right" added="1255162862">Rotate Right</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="rotate_left" added="1255162869">Rotate Left</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="tag_this_photo" added="1255162876">Tag this Photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="no_photos_have_been_added_yet" added="1255162892">No photos have been added yet.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="be_the_first_to_upload_a_photo" added="1255162898">Be the First to Upload a Photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="title_by_full_name" added="1255162922">{title} by {full_name}</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="by_user_info" added="1255162955">by {user_info}</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="no_photos_added_yet" added="1255163019">No photos added yet.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="click_here_to_upload_a_photo" added="1255163025">Click here to upload a photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="approve_this_photo" added="1255163046">Approve this photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="set_as_album_cover" added="1255163072">Set as album cover.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="no_photos_uploaded_yet" added="1255165857">No photos uploaded yet.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="click_here_to_upload_photos" added="1255165864">Click here to upload photos.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="warning" added="1255168472">Warning!</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="the_photo_you_are_about_to_view_may_contain_nudity_sexual_themes_violence_gore_strong_language_or_ideologically_sensitive_subject_matter" added="1255168917">The photo you are about to view may contain nudity, sexual themes, violence/gore, strong language or ideologically sensitive subject matter.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="would_you_like_to_view_this_image" added="1255168925">Would you like to view this image?</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="no_thanks" added="1255168937">No, Thanks.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="add_a_photo_category" added="1255168955">Add a Photo Category</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="parent" added="1255168960">Parent</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="update" added="1255168981">Update</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="are_you_sure_you_want_to_delete_this_album_and_all_the_pictures_that_belong_to_it" added="1255168994">Are you sure you want to delete this album and all the pictures that belong to it?</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="note_that_this_cannot_be_undone" added="1255169000">Note that this cannot be undone.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="update_photo" added="1255169021">Update Photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="update_album" added="1255169041">Update Album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="this_photo_album_is_password_protected" added="1255169058">This photo album is password protected.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="enter_password" added="1255169066">Enter Password</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="no_images_found" added="1255169114">No images found.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="v_br_e_br_r_br_s_br_u_br_s" added="1255169125"><![CDATA[V<br />e<br />r<br />s<br />u<br />s]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="there_is_one_image_that_requires_your_approval" added="1255169140">There is one image that requires your approval.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="there_are_total_images_that_require_your_approval" added="1255169150">There are {total} images that require your approval.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="no_public_photos_have_been_uploaded_yet" added="1255169181">No public photos have been uploaded yet.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="click_here_to_approve_photos" added="1255169212">Click here to approve photos.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photos_total" added="1255169369">Photos ({total})</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="albums_total" added="1255169418">Albums ({total})</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="you_have_not_uploaded_any_photos_yet" added="1255169448">You have not uploaded any photos yet.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="user_info_has_not_uploaded_any_photos_yet" added="1255169497">{user_info} has not uploaded any photos yet.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload_your_photos" added="1255169521">Upload Your Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="browse_other_photos" added="1255169528">Browse Other Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="skip" added="1255169618">Skip</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="b_back_b_to_full_name_s_photo_section" added="1255169648"><![CDATA[<b>Back</b> to {full_name}'s photo section.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="b_back_b_to_title_s_photo_section" added="1255169673"><![CDATA[<b>Back</b> to {title}'s photo section.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload_by_user_info_on_time_stamp" added="1255169715">Upload by {user_info} on {time_stamp}.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="available_sizes" added="1255169742">Available sizes</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="download_this_image" added="1255169758">Download This Image.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_links" added="1255169768">Photo Links</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="html_embed" added="1255169774">HTML Embed</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="photo_path" added="1255169846">Photo Path</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="skip_this_step" added="1255169861">Skip This Step</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="global_photo_settings" added="1255169872">Global Photo Settings</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="note_that_global_photo_settings_will_override_any_settings_saved_individually_below" added="1255169879"><![CDATA[Note that "Global Photo Settings" will override any settings saved individually below.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="save_global_settings" added="1255169887">Save Global Settings</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="uploaded_photos" added="1255169895">Uploaded Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="save" added="1255169909">Save</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="and_then" added="1255169918">and then</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="process_next_batch_total_left" added="1255169930">process next batch ({total} left).</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="view_this_album" added="1255169945">view this album.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="view_your_photos" added="1255169951">view your photos.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload_new_images" added="1255169957">upload new images.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="album" added="1255169993">Album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="select_an_album" added="1255170002">Select an album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="or" added="1255170019">or</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="create_a_new_one" added="1255170026">Create a New One</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="select_photo_s" added="1255170034">Select Photo(s)</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="process_your_photos" added="1255170053">process your photos.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="upload_more_photos" added="1255170060">upload more photos.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1255170081">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="the_file_size_limit_is_file_size_if_your_upload_does_not_work_try_uploading_a_smaller_picture" added="1255170105">The file size limit is {file_size}. If your upload does not work, try uploading a smaller picture.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="recently_uploaded" added="1255170121">Recently Uploaded</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="process_your_photo_s" added="1255170132">Process Your Photo(s)</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="in" added="1255170264">in</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="by_lower" added="1255170279">by</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="in_this_photo" added="1255170329">In this photo</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="full_name_s_photo_from_time_stamp" added="1256488497"><![CDATA[{full_name}'s Photo from {time_stamp}]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="click_here_to_tag_as_yourself" added="1256488630">Click here to tag as yourself.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="groups" added="1256489661">Groups</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="select_an_area_on_your_photo_to_crop" added="1256490113">Select an area on your photo to crop.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc4" var_name="all_photos" added="1256712979">All Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="submitted" added="1257169324">Submitted</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="file_size" added="1257169340">File Size</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="resolution" added="1257169346">Resolution</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="comments" added="1257169352">Comments</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="views" added="1257169359">Views</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="rating" added="1257169365">Rating</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="battle_wins" added="1257169373">Battle Wins</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="downloads" added="1257169380">Downloads</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="not_enough_photos_to_have_a_battle" added="1257251559">Not enough photos to have a battle.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="get_the_battle_started_and_upload_some_photos" added="1257251607">Get the battle started and upload some photos.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc6" var_name="photo_successfully_deleted" added="1257256844">Photo successfully deleted.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc8" var_name="remove_tag" added="1258385449">remove tag</phrase>
		<phrase module_id="photo" version_id="2.0.0rc9" var_name="added_on_time_stamp_by_full_name" added="1259162534">Added on {time_stamp} by {full_name}.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc9" var_name="with_a_total_of_total_vote_votes" added="1259162619">with a total of {total_vote} votes.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc10" var_name="photo_count_for_photo_albums" added="1259673154">Photo Count for Photo Albums</phrase>
		<phrase module_id="photo" version_id="2.0.0rc10" var_name="by_full_name" added="1259673587">By: {full_name}</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="no_photos_have_been_featured" added="1260189682">No photos have been featured.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="no_photos_pending_approval" added="1260189708">No photos pending approval.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="recent_photos" added="1260189785">Recent Photos</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="featured" added="1260189792">Featured</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="pending" added="1260189799">Pending</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="unfeature" added="1260190575">Unfeature</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="photo_successfully_unfeatured" added="1260190782">Photo successfully unfeatured.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="albums" added="1260195690">Albums</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="no_public_photo_albums_found" added="1260195737">No public photo albums found.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="advanced_critique_is_encouraged_when_commenting_on_this_photo" added="1260204958">Advanced critique is encouraged when commenting on this photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="criticism_is_discouraged_when_commenting_on_this_photo" added="1260204967">Criticism is discouraged when commenting on this photo.</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="create_a_new_album" added="1260206706">Create a New Album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc11" var_name="user_setting_can_view_photos" added="1260276540">Can browse and view the photo module?</phrase>
		<phrase module_id="photo" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_their_own_a_href_link_photo_album_a" added="1260451144"><![CDATA[<a href="{user_link}">{full_name}</a> liked their own <a href="{link}">photo album</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_photo_album_a" added="1260451210"><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">photo album</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_photo_a" added="1260452199"><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">photo</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_their_own_a_href_link_photo_a" added="1260452218"><![CDATA[<a href="{user_link}">{full_name}</a> liked their own <a href="{link}">photo</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_your_a_href_link_photo_album_a" added="1260458422"><![CDATA[<a href="{user_link}">{full_name}</a> liked your <a href="{link}">photo album</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_your_a_href_link_photo_a" added="1260459387"><![CDATA[<a href="{user_link}">{full_name}</a> liked your <a href="{link}">photo</a>.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0rc12" var_name="part_of_the_photo_album" added="1260896980">Part of the photo album</phrase>
		<phrase module_id="photo" version_id="2.0.0rc12" var_name="full_name_s_albums" added="1260897047"><![CDATA[{full_name}'s Albums]]></phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="update_tags_photo" added="1261056664">Update Tags (Photo)</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="user_setting_can_view_private_photos" added="1261073026">Can view private and password protected photos?</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="rate_this_image" added="1261161424">Rate This Image</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="total_rating_out_of_5" added="1261179113">{total_rating} out of 10</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="no_photos_found" added="1261179316">No photos found.</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="no_photos_have_been_rated" added="1261179331">No photos have been rated.</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="no_photo_battles_have_taken_place" added="1261179377">No photo battles have taken place.</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="total_battle_win_s" added="1261179478">{total_battle} win(s)</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="setting_ajax_refresh_on_featured_photos" added="1261335633"><![CDATA[<title>AJAX Refresh Featured Photos</title><info>With this option enabled photos within the "Featured Photo" block will refresh.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="no_popular_photos_found" added="1261412466">No popular photos found.</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="no_featured_photos_found" added="1261412669">No featured photos found.</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="comments_total_comment" added="1261413297">Comments ({total_comment})</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="total_score_out_of_10" added="1261413456">{total_score} out of 10</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="sorry_the_photo_you_are_looking_for_no_longer_exists" added="1261415869"><![CDATA[Sorry, the photo you are looking for no longer exists. Please <a href="{link}">click here</a> to browse more photos.]]></phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="cancel_lowercase" added="1261511944">cancel</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="personal_this_album_will_only_be_displayed_on_your_profile" added="1261514661">Personal (This album will only be displayed on your profile.)</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="public_this_album_will_be_added_to_our_public_photo_album_section" added="1261514696">Public (This album will be added to our public photo album section.)</phrase>
		<phrase module_id="photo" version_id="2.0.0" var_name="delete_this_image" added="1261570267">Delete this image.</phrase>
		<phrase module_id="photo" version_id="2.0.2" var_name="update_photo_thumbnails" added="1262710651">Update Photo Thumbnails</phrase>
		<phrase module_id="photo" version_id="2.0.3" var_name="user_setting_can_post_on_photos" added="1264423442">Can post comments on photos?</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="user_setting_can_sponsor_photo" added="1269941437">Can members of this user group explicitly set a photo as Sponsor?</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="unsponsor_this_photo" added="1269941692">Unsponsor this photo</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="sponsor_this_photo" added="1269941832">Sponsor this Photo</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="photo_successfully_sponsored" added="1269943956">Photo successfully sponsored.</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="photo_successfully_un_sponsored" added="1269944039">Photo successfully unsponsored.</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="sponsored_photo" added="1270022791">Sponsored Photo</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="user_setting_can_purchase_sponsor" added="1271074731">Can members of this user group purchase a sponsored ad space?</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="sponsor_help" added="1271080634"><![CDATA[In order to sponsor a photo click on the photo you wish to sponsor below and then look for the link "Sponsor this Photo".]]></phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="encourage_sponsor" added="1271150118">Sponsor your Photos</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="user_setting_photo_sponsor_price" added="1271244034">How much is the sponsor space worth?
This works in a CPM basis.</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="user_setting_auto_publish_sponsored_item" added="1271418913">After the user has purchased a sponsored space, should the item be published right away?
If set to false, the admin will have to approve each new purchased sponsored photo space before it is shown in the site.</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="sponsor_paypal_message" added="1271944103">Payment for the sponsor space of photo: {sPhotoTitle}</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="sponsor_title" added="1271944272">Photo: {sPhotoTitle}</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="update_friend_count" added="1273153962">Update Friend Count</phrase>
		<phrase module_id="photo" version_id="2.0.5" var_name="user_setting_can_view_photo_albums" added="1273168609">Can view photo albums?</phrase>
		<phrase module_id="photo" version_id="2.0.5dev2" var_name="user_setting_flood_control_photos" added="1275105927"><![CDATA[How many minutes should a user wait before they can upload another batch of photos?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></phrase>
		<phrase module_id="photo" version_id="2.0.5dev2" var_name="uploading_photos_a_little_too_soon" added="1275105953">Uploading photos a little too soon.</phrase>
		<phrase module_id="photo" version_id="3.0.0Beta1" var_name="say_something_about_this_photo" added="1302202989">Say something about this photo...</phrase>
		<phrase module_id="photo" version_id="2.0.8" var_name="the_following_files_were_not_uploaded_because_their_size_exceeds_the_limit_of_ilimit_sfiles" added="1294924698">The following files were not uploaded because their size exceeds the limit of {iLimit}: {sFiles}</phrase>
		<phrase module_id="photo" version_id="2.0.8" var_name="setting_enable_mass_uploader" added="1294927024"><![CDATA[<title>Enable Mass Uploader</title><info>When enabled users will be allowed to use a mass photo uploader to select multiple files from a single file select dialog.

This uses an integration of SWFUpload (http://code.google.com/p/swfupload/) and thus it uses a Flash object.</info>]]></phrase>
		<phrase module_id="photo" version_id="2.0.8" var_name="use_simple_uploader" added="1296651153">Use simple uploader</phrase>
		<phrase module_id="photo" version_id="2.0.8" var_name="use_mass_uploader" added="1296651172">Use mass uploader</phrase>
		<phrase module_id="photo" version_id="2.1.0beta2" var_name="user_setting_total_photo_display_profile" added="1300968617">Define how many photos to display within an album on a users profile.</phrase>
		<phrase module_id="photo" version_id="2.1.0beta2" var_name="album_successfully_created" added="1300969620">Album successfully created.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta1" var_name="setting_auto_crop_photo" added="1306738298"><![CDATA[<title>Auto Crop Photos</title><info>If this option is enabled images within the photo section will crop images so each image has the same width/height giving the photo section a cleaner look. This works similar to how the photo section on Facebook works.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0beta3" var_name="setting_view_photos_in_theater_mode" added="1316011101"><![CDATA[<title>View Photos in Theater Mode</title><info>In several areas where we display photos, when a user clicks on the photo they will be able to view the photo on the spot in what we call "Theater Mode" if this option is enabled.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="create_a_new_photo_album" added="1319122273">Create a New Photo Album</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="editing_photo" added="1319122283">Editing Photo</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="select_a_photo_to_attach" added="1319122541">Select a photo to attach.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="add_a_title" added="1319184119">Add a title.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="photo_has_been_approved" added="1319184129">Photo has been approved.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="photo_approved" added="1319184137">Photo Approved</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="successfully_updated_photo_s" added="1319184147">Successfully updated photo(s)</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="notice" added="1319184153">Notice</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="unable_to_find_the_photo_you_are_looking_for" added="1319184162">Unable to find the photo you are looking for.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="unable_to_import_this_photo" added="1319184170">Unable to import this photo.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="note_when_selecting_a_photo_to_import" added="1319188547">Note when selecting a photo to import below it will not import its privacy settings as you can control the privacy settings with the item you are attaching this photo to.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="no_photos_to_select_from" added="1319188559">No photos to select from.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="search_photos" added="1319190264">Search Photos...</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="latest" added="1319190271">Latest</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="most_discussed" added="1319190286">Most Discussed</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="approve" added="1319190316">Approve</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="my_photos" added="1319190348">My Photos</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="friends_photos" added="1319190373"><![CDATA[Friends' Photos]]></phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="featured_photos" added="1319190381">Featured Photos</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="pending_photos" added="1319190393">Pending Photos</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="all_albums" added="1319190402">All Albums</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="my_albums" added="1319190409">My Albums</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="photo_battles" added="1319190425">Photo Battles</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="link" added="1319190492">Link</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="delete_photo" added="1319190502">Delete Photo</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="edit_photo" added="1319190510">Edit Photo</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="make_profile_picture" added="1319190517">Make Profile Picture</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="setting_this_photo_as_your_profile_picture_please_hold" added="1319190528">Setting this photo as your profile picture. Please hold...</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="un_feature" added="1319190539">Un-Feature</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="feature" added="1319190544">Feature</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="sponsored" added="1319190555">Sponsored</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="moderate" added="1319190566">Moderate</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="actions" added="1319190701">Actions</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="photo_current_of_total" added="1319190720">Photo {current} of {total}</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="previous" added="1319190735">Previous</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="next" added="1319190741">Next</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="by_full_name_lowercase" added="1319190805">by {full_name}</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="report_this_photo" added="1319190960">Report this photo</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="time_stamp_by_full_name" added="1319191037">{time_stamp} by {full_name}</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="please_hold_while_your_images_are_being_processed_processing_image" added="1319191210">Please hold while your images are being processed. Processing image</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="out_of" added="1319191219">out of</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="unable_to_view_this_item_due_to_privacy_settings" added="1319195316">Unable to view this item due to privacy settings.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="photo_s_privacy" added="1319195363">Photo(s) Privacy</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="comment_privacy" added="1319195370">Comment Privacy</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="control_who_can_see_these_photo_s" added="1319195378">Control who can see these photo(s).</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="control_who_can_comment_on_these_photo_s" added="1319195387">Control who can comment on these photo(s).</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="upload_problems_try_the_basic_uploader" added="1319195704"><![CDATA[Upload problems? Try the <a href="{link}">basic uploader</a> (works on older computers and web browsers).]]></phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="profile_pictures" added="1319195784">Profile Pictures</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="album_s_privacy" added="1319195799">Album(s) Privacy</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="control_who_can_see_this_photo_album_and_any_photos_associated_with_it" added="1319195808">Control who can see this photo album and any photos associated with it.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="control_who_can_comment_on_this_photo_album_and_any_photos_associated_with_it" added="1319195833">Control who can comment on this photo album and any photos associated with it.</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="mass_edit_photos" added="1319197005">Mass Edit Photos</phrase>
		<phrase module_id="photo" version_id="3.0.0beta5" var_name="update_photo_s" added="1319197015">Update Photo(s)</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="photo_album_not_found" added="1320074867">Photo album not found.</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="album_successfully_updated" added="1320074886">Album successfully updated.</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="album_info" added="1320074894">Album Info</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="view_this_album_uppercase" added="1320074913">View This Album</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="editing_album" added="1320074922">Editing Album</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="report_this_photo_album" added="1320075087">Report this photo album</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="upload_photo_s" added="1320075582">Upload Photo(s)</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="edit" added="1320075589">Edit</phrase>
		<phrase module_id="photo" version_id="3.0.0rc1" var_name="by_lowercase" added="1320075610">by</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="close_full_mode" added="1321347942">Close Full Mode</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="open_full_mode" added="1321347948">Open Full Mode</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="added_by_full_name_br_on_time_stamp" added="1321347978"><![CDATA[Added by {full_name}<br /> on {time_stamp}]]></phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="vs" added="1321348013">VS</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="no_available_images_to_rate" added="1321348065">No available images to rate.</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="no_albums_found_here" added="1321348119">No albums found here.</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="search_photo_albums" added="1321348151">Search Photo Albums...</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="delete_this_photo_lowercase" added="1321348986">Delete this photo.</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="who_can_share_a_photo" added="1321360826">Who can share a photo?</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="who_can_view_browse_photos" added="1321360833">Who can view/browse photos?</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="in_the_album" added="1321365448">In the album</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="set_as_the_album_cover" added="1321366546">Set as the album cover.</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="move_to" added="1321366577">Move to</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="select" added="1321366584">Select</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="control_who_can_see_this_photo" added="1321366614">Control who can see this photo.</phrase>
		<phrase module_id="photo" version_id="3.0.0rc2" var_name="control_who_can_comment_on_this_photo" added="1321366625">Control who can comment on this photo.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="update_user_photo_count" added="1322462330">Update User Photo Count</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_your_photo_album_name" added="1322465669"><![CDATA[{full_name} commented on your photo album "{name}".]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_your_photo_title" added="1322465959"><![CDATA[{full_name} commented on your photo "{title}".]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="added" added="1322466623">Added</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="plays_lowercase" added="1322466667">plays</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="get_all_the_photos_for_a_user_if_you_do_not_pass_the_user_id_we_will_return_information_about_the_user_that_is_currently_logged_in" added="1322645842">Get all the photos for a user. If you do not pass the #{USER_ID} we will return information about the user that is currently logged in.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1322645871">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="posted_a_comment_on_gender_photo" added="1322645988">posted a comment on {gender} photo</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="posted_a_comment_on_user_name_s_photo" added="1322646033"><![CDATA[posted a comment on {user_name}'s photo]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_your_photo_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322646178"><![CDATA[{full_name} commented on your photo "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_gender_photo" added="1322646407">{full_name} commented on {gender} photo.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_photo" added="1322647040"><![CDATA[{full_name} commented on {other_full_name}'s photo.]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_gender_photo_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322647390"><![CDATA[{full_name} commented on {gender} photo "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_photo_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322647522"><![CDATA[{full_name} commented on {other_full_name}'s photo "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_liked_gender_own_photo_title" added="1322647856"><![CDATA[{user_name} liked {gender} own photo "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_liked_your_photo_title" added="1322647948"><![CDATA[{user_name} liked your photo "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_liked_span_class_drop_data_user_full_name_s_span_photo_title" added="1322648103"><![CDATA[{user_name} liked <span class="drop_data_user">{full_name}'s</span> photo "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_commented_on_gender_photo_title" added="1322648213"><![CDATA[{user_name} commented on {gender} photo "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_commented_on_your_photo_title" added="1322648290"><![CDATA[{user_name} commented on your photo "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_commented_on_span_class_drop_data_user_full_name_s_span_photo_title" added="1322648462"><![CDATA[{user_name} commented on <span class="drop_data_user">{full_name}'s</span> photo "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_posted_a_href_link_photo_a_photo_a_on_a_href_link_user_parent_full_name_a_s_a_href_link_wall_wall_a" added="1322649115"><![CDATA[{full_name} posted <a href="{link_photo}"> a photo</a> on <a href="{link_user}">{parent_full_name}</a>'s <a href="{link_wall}">wall</a>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_liked_gender_own_photo_album_title" added="1322649280"><![CDATA[{user_name} liked {gender} own photo album "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_liked_your_photo_album_title" added="1322649469"><![CDATA[{user_name} liked your photo album "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_liked_span_class_drop_data_user_full_name_s_span_photo_album_title" added="1322649592"><![CDATA[{user_name} liked <span class="drop_data_user">{full_name}'s</span> photo album "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_your_photo_album_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322649784"><![CDATA[{full_name} commented on your photo album "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_gender_photo_album" added="1322650140">{full_name} commented on {gender} photo album.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_photo_album" added="1322650217"><![CDATA[{full_name} commented on {other_full_name}'s photo album.]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_gender_photo_album_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322650597"><![CDATA[{full_name} commented on {gender} photo album "<a href="{link}">{title}</a>.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_photo_album_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322650759"><![CDATA[{full_name} commented on {other_full_name}'s photo album "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_commented_on_gender_photo_album_title" added="1322650881"><![CDATA[{user_name} commented on {gender} photo album "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_commented_on_your_photo_album_title" added="1322650947"><![CDATA[{user_name} commented on your photo album "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_commented_on_span_class_drop_data_user_full_name_s_span_photo_album_title" added="1322651104"><![CDATA[{user_name} commented on <span class="drop_data_user">{full_name}'s</span> photo album "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="you_tagged_yourself_in_your_photo_title" added="1322651213"><![CDATA[You tagged yourself in your photo "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="user_name_tagged_you_in_span_class_drop_data_user_full_name_s_span_photo_title" added="1322651318"><![CDATA[{user_name} tagged you in <span class="drop_data_user">{full_name}'s</span> photo "{title}"]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="setting_enable_photo_battle" added="1322718976"><![CDATA[<title>Photo Battle</title><info>Set to <b>True</b> if you would like to enable the ability for users to battle on photos uploaded by other users.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="photos_unfortunately_cannot_be_uploaded_via_mobile_devices_at_this_moment" added="1322737379">Photos unfortunately cannot be uploaded via mobile devices at this moment.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="photo_album" added="1322737409">Photo Album:</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="profile_photo_successfully_updated" added="1322737467">Profile photo successfully updated.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="photo_s_successfully_approved" added="1322740660">Photo(s) successfully approved.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="photo_s_successfully_deleted" added="1322740672">Photo(s) successfully deleted.</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="save_changes" added="1323086740">Save Changes</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="subcategories" added="1323170112">Subcategories</phrase>
		<phrase module_id="photo" version_id="3.0.0" var_name="your_photo_title_has_been_approved" added="1323327516"><![CDATA[Your photo "{title}" has been approved.]]></phrase>
		<phrase module_id="photo" version_id="3.1.0beta1" var_name="setting_display_profile_photo_within_gallery" added="1329766842"><![CDATA[<title>Display Profile Photo within Gallery</title><info>Disable this feature if you do not want to display profile photos within the photo gallery.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.1.0beta1" var_name="update_profile_photos" added="1329769181">Update Profile Photos</phrase>
		<phrase module_id="photo" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_a_photo" added="1331221050">{user_name} tagged you in a comment in a photo</phrase>
		<phrase module_id="photo" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_a_photo_album" added="1331221198">{user_name} tagged you in a comment in a photo album</phrase>
		<phrase module_id="photo" version_id="3.1.0rc1" var_name="tagged_gender_on_a_href_link_photo_full_name_s_photo" added="1332162548"><![CDATA[tagged {gender} on <a href="{link}">{photo_full_name}</a>&#039;s photo.]]></phrase>
		<phrase module_id="photo" version_id="3.1.0rc1" var_name="setting_allow_photo_category_selection" added="1332237468"><![CDATA[<title>Allow Selection of Categories</title><info>Enable this feature to give users the option to select a category when they upload photos.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.1.0rc1" var_name="menu_photo_photos_532c28d5412dd75bf975fb951c740a30" added="1332257899">Photos</phrase>
		<phrase module_id="photo" version_id="3.1.0" var_name="read_more" added="1332840601">Read More</phrase>
		<phrase module_id="photo" version_id="3.2.0" var_name="your_photo_has_been_approved_message" added="1335946950"><![CDATA[Your photo "<a href=&#039;{sLink}&#039;>{title}</a>" has been approved.
To view this photo follow the link below:
<a href="{sLink}">{sLink}</a>]]></phrase>
		<phrase module_id="photo" version_id="3.3.0beta1" var_name="setting_photo_upload_process" added="1337064029"><![CDATA[<title>Edit Photos After Upload</title><info>Enable this option if you want users to edit the batch of photos they had just recently updated.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.3.0beta1" var_name="in_this_album" added="1339154953">In This Album</phrase>
		<phrase module_id="photo" version_id="3.3.0beta1" var_name="please_upload_an_image_for_your_profile" added="1340029029">Please upload an image for your profile.</phrase>
		<phrase module_id="photo" version_id="3.3.0beta2" var_name="full_name_tagged_you_on_gender_photo" added="1340286898"><![CDATA[{full_name} tagged you on {gender} photo "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="photo" version_id="3.3.0beta2" var_name="full_name_tagged_you_on_user_photo" added="1340287021"><![CDATA[{full_name} tagged you on {other_full_name}&#039;s photo "<a href="{link}">{title}</a>
To view this photo follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="photo" version_id="3.3.0beta2" var_name="full_name_tagged_you_in_a_photo" added="1340287175">{full_name} tagged you in a photo.</phrase>
		<phrase module_id="photo" version_id="3.3.0beta2" var_name="menu_photo_upload_a_new_image_714586c73197300f65ba08f7dee8cb4a" added="1340638576">Upload a New Image</phrase>
		<phrase module_id="photo" version_id="3.3.0beta2" var_name="photo_details" added="1340815615">Photo Details</phrase>
		<phrase module_id="photo" version_id="3.5.0beta1" var_name="setting_delete_original_after_resize" added="1352107332"><![CDATA[<title>Delete Original Photo After Resize</title><info>When a user uploads an image the site will create thumbnails of this image, and uses the thumbnails around the site. 
If you enable this setting the original file (that the user uploaded) will be deleted after the thumbnails have been created.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.5.0beta1" var_name="item_phrase" added="1352730334">photo</phrase>
		<phrase module_id="photo" version_id="3.5.0beta1" var_name="item_phrase_album" added="1352730426">photo album</phrase>
		<phrase module_id="photo" version_id="3.5.0beta1" var_name="setting_in_main_photo_section_show" added="1355986348"><![CDATA[<title>In Main Photo Section Show</title><info>This setting lets you choose what should be displayed when going to the main photo section. The default is to display photos</info>]]></phrase>
		<phrase module_id="photo" version_id="3.5.0beta1" var_name="setting_show_info_on_mouseover" added="1356078187"><![CDATA[<title>Dynamic View</title><info>
This setting changes a few aspects related to the photo section:<br/>
- It hides the user and album name of a photo until you place the cursor over that photo
- The thumbnails for the photos are bigger
- When placing the mouse over a thumbnail you can like the photo with one click.
- The Pager in the photo section is a bigger button allowing the visitor to simply load more photos.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.5.0beta1" var_name="menu_photo_upload_a_new_image_0df7df42d810e7978c535292f273fc91" added="1357813885">Upload a New Image</phrase>
		<phrase module_id="photo" version_id="3.5.0beta2" var_name="set_as_page_s_cover_photo" added="1359377560"><![CDATA[Set as Page&#039;s Cover Photo]]></phrase>
		<phrase module_id="photo" version_id="3.5.0beta2" var_name="set_as_your_page_s_cover_photo" added="1359466469"><![CDATA[Set as your page&#039;s cover photo]]></phrase>
		<phrase module_id="photo" version_id="3.5.0beta2" var_name="set_this_as_your_page_s_cover_photo" added="1359466479"><![CDATA[Set this as your Page&#039;s cover photo]]></phrase>
		<phrase module_id="photo" version_id="3.5.0beta2" var_name="set_this_photo_as_your_profile_image" added="1359466506">Set this photo as your profile image.</phrase>
		<phrase module_id="photo" version_id="3.6.0rc1" var_name="setting_pre_load_header_view" added="1371732031"><![CDATA[<title>Pre-load JavaScript for Photo Theater Mode</title><info>Enable to pre-load all the needed JS/CSS files for viewing a photo. Makes it faster to get the popup.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.7.0rc1" var_name="setting_html5_upload_photo" added="1377092218"><![CDATA[<title>HTML5 Mass Upload</title><info>Enable this option to allow browsers that have support for HTML5 mass uploads.</info>]]></phrase>
		<phrase module_id="photo" version_id="3.7.3" var_name="photo_uploads" added="1383756273">Photo Uploads</phrase>
		<phrase module_id="photo" version_id="3.7.3" var_name="upload_complete_we_are_currently_processing_the_photos" added="1383756365">Upload complete. We are currently processing the photos.</phrase>
		<phrase module_id="photo" version_id="3.7.4" var_name="number_photos" added="1385479831">{iCnt} photos</phrase>
		<phrase module_id="photo" version_id="3.7.4" var_name="number_photo" added="1385479869">{iCnt} photo</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_create_photo_album</setting>
		<setting is_admin_setting="0" module_id="photo" type="string" admin="null" user="20" guest="0" staff="30" module="photo" ordering="0">max_number_of_albums</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">points_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_upload_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_password_protect_albums</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_use_privacy_settings</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="10" user="10" guest="0" staff="10" module="photo" ordering="0">max_images_per_upload</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_add_to_rating_module</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_add_tags_on_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_control_comments_on_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_add_mature_images</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_search_for_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="array" admin="s:22:&quot;array('20','40','60');&quot;;" user="s:22:&quot;array('20','40','60');&quot;;" guest="s:22:&quot;array('20','40','60');&quot;;" staff="s:22:&quot;array('20','40','60');&quot;;" module="photo" ordering="0">total_photos_displays</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="15" user="15" guest="15" staff="15" module="photo" ordering="0">default_photo_display_limit</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="100" user="100" guest="100" staff="100" module="photo" ordering="0">max_photo_display_limit</setting>
		<setting is_admin_setting="0" module_id="photo" type="string" admin="1 min" user="1 min" guest="1 min" staff="1 min" module="photo" ordering="0">refresh_featured_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_download_user_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_view_all_photo_sizes</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_edit_own_photo_album</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_edit_other_photo_albums</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_view_hidden_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_delete_own_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_delete_other_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_edit_own_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_edit_other_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="18" user="18" guest="18" staff="18" module="photo" ordering="0">photo_mature_age_limit</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_rate_on_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_edit_photo_categories</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_add_public_categories</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="0" user="0" guest="1" staff="0" module="photo" ordering="0">photo_must_be_approved</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_approve_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_feature_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_delete_own_photo_album</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_delete_other_photo_albums</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_tag_own_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_tag_other_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="40" user="40" guest="0" staff="40" module="photo" ordering="0">how_many_tags_on_own_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="4" user="4" guest="0" staff="4" module="photo" ordering="0">how_many_tags_on_other_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="500" user="500" guest="500" staff="500" module="photo" ordering="0">photo_max_upload_size</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="1" staff="1" module="photo" ordering="0">can_view_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="0" guest="0" staff="1" module="photo" ordering="0">can_view_private_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="0" staff="1" module="photo" ordering="0">can_post_on_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="false" user="false" guest="false" staff="false" module="photo" ordering="0">can_sponsor_photo</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="false" user="false" guest="false" staff="false" module="photo" ordering="0">can_purchase_sponsor</setting>
		<setting is_admin_setting="0" module_id="photo" type="string" admin="null" user="null" guest="null" staff="null" module="photo" ordering="0">photo_sponsor_price</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="true" user="false" guest="false" staff="false" module="photo" ordering="0">auto_publish_sponsored_item</setting>
		<setting is_admin_setting="0" module_id="photo" type="boolean" admin="1" user="1" guest="1" staff="1" module="photo" ordering="0">can_view_photo_albums</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="0" user="0" guest="0" staff="0" module="photo" ordering="0">flood_control_photos</setting>
		<setting is_admin_setting="0" module_id="photo" type="integer" admin="9" user="9" guest="9" staff="9" module="photo" ordering="0">total_photo_display_profile</setting>
	</user_group_settings>
	<tables><![CDATA[a:11:{s:12:"phpfox_photo";a:3:{s:7:"COLUMNS";a:31:{s:8:"photo_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"album_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"group_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"destination";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"server_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"mature";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"allow_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"allow_rate";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"total_download";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_rating";a:4:{i:0;s:9:"DECIMAL:3";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_vote";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_battle";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_featured";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"is_cover";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"allow_download";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"is_profile_photo";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"photo_id";s:4:"KEYS";a:12:{s:8:"album_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"album_id";i:1;s:7:"view_id";}}s:8:"photo_id";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:8:"photo_id";i:1;s:8:"album_id";i:2;s:7:"view_id";i:3;s:8:"group_id";i:4;s:7:"privacy";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:8:"group_id";i:2;s:7:"type_id";i:3;s:7:"privacy";}}s:10:"photo_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:6:{i:0;s:8:"photo_id";i:1;s:8:"album_id";i:2;s:7:"view_id";i:3;s:8:"group_id";i:4;s:7:"type_id";i:5;s:7:"privacy";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}s:7:"privacy";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"privacy";i:1;s:10:"allow_rate";}}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:8:"group_id";i:2;s:7:"type_id";i:3;s:7:"user_id";}}s:10:"album_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"album_id";i:1;s:7:"view_id";i:2;s:8:"is_cover";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:5:"title";}}s:9:"view_id_5";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:9:"module_id";i:2;s:8:"group_id";i:3;s:7:"privacy";}}s:16:"is_profile_photo";a:2:{i:0;s:5:"INDEX";i:1;s:16:"is_profile_photo";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:18:"phpfox_photo_album";a:3:{s:7:"COLUMNS";a:15:{s:8:"album_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"group_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:17:"time_stamp_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_photo";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"profile_id";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"album_id";s:4:"KEYS";a:6:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:8:"group_id";i:2;s:7:"user_id";}}s:8:"album_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"album_id";i:1;s:7:"view_id";i:2;s:7:"privacy";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:8:"group_id";i:2;s:7:"privacy";}}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"user_id";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"total_photo";}}}}s:23:"phpfox_photo_album_info";a:2:{s:7:"COLUMNS";a:2:{s:8:"album_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:8:"album_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:8:"album_id";}}}s:19:"phpfox_photo_battle";a:3:{s:7:"COLUMNS";a:5:{s:9:"battle_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"photo_1";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"photo_2";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"battle_id";s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:7:"photo_1";i:2;s:7:"photo_2";}}}}s:21:"phpfox_photo_category";a:3:{s:7:"COLUMNS";a:7:{s:11:"category_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"used";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"category_id";s:4:"KEYS";a:2:{s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"parent_id";}s:8:"name_url";a:2:{i:0;s:5:"INDEX";i:1;s:8:"name_url";}}}s:26:"phpfox_photo_category_data";a:2:{s:7:"COLUMNS";a:2:{s:8:"photo_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"category_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:8:"photo_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"photo_id";}s:11:"category_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"category_id";}}}s:17:"phpfox_photo_feed";a:2:{s:7:"COLUMNS";a:2:{s:7:"feed_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"photo_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:7:"feed_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"feed_id";}s:8:"photo_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"photo_id";}}}s:17:"phpfox_photo_info";a:2:{s:7:"COLUMNS";a:8:{s:8:"photo_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"file_name";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"file_size";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"mime_type";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"extension";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:5:"width";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"height";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:8:"photo_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:8:"photo_id";}}}s:19:"phpfox_photo_rating";a:3:{s:7:"COLUMNS";a:5:{s:9:"rating_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"photo_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"rating";a:4:{i:0;s:9:"DECIMAL:3";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"rating_id";s:4:"KEYS";a:1:{s:8:"photo_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"photo_id";i:1;s:7:"user_id";}}}}s:16:"phpfox_photo_tag";a:3:{s:7:"COLUMNS";a:10:{s:6:"tag_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"photo_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"tag_user_id";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"content";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"position_x";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"position_y";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"width";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"height";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"tag_id";s:4:"KEYS";a:4:{s:8:"photo_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"photo_id";}s:10:"photo_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:8:"photo_id";i:1;s:10:"position_x";i:2;s:10:"position_y";i:3;s:5:"width";i:4;s:6:"height";}}s:10:"photo_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"photo_id";i:1;s:11:"tag_user_id";}}s:10:"photo_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"photo_id";i:1;s:7:"user_id";}}}}s:18:"phpfox_photo_track";a:2:{s:7:"COLUMNS";a:3:{s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}}}}]]></tables>
	<install><![CDATA[
		$aPhotoCategories = array(
			'Comedy',
			'Digital Art',
			'Photography',
			'Traditional Art',
			'Film & Animation',
			'Designs & Interfaces',
			'Game Development Art',
			'Artisan Crafts',
			'Customization',
			'Fractal Art',
			'Cartoons & Comics',
			'Contests',
			'Resources & Stock Images',
			'Literature',
			'Fan Art',
			'Anthro',
			'Community Projects',
			'People',
			'Pets & Animals',
			'Science & Technology',
			'Sports'
		);		
		sort($aPhotoCategories);
		$iCategoryOrder = 0;
		foreach ($aPhotoCategories as $sCategory)
		{
			$iCategoryOrder++;
			$this->database()->insert(Phpfox::getT('photo_category'), array(					
					'name' => $sCategory,
					'ordering' => $iCategoryOrder			
				)
			);
		}
	]]></install>
</module>