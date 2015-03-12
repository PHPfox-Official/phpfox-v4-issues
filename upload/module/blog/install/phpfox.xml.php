<module>
	<data>
		<module_id>blog</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:36:"admincp.admin_menu_manage_categories";a:1:{s:3:"url";a:1:{i:0;s:4:"blog";}}s:31:"admincp.admin_menu_add_category";a:1:{s:3:"url";a:2:{i:0;s:4:"blog";i:1;s:3:"add";}}}]]></menu>
		<phrase_var_name>module_blog</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="blog" parent_var_name="" m_connection="main" var_name="menu_blogs" ordering="5" url_value="blog" version_id="2.0.0alpha1" disallow_access="" module="blog" />
		<menu module_id="blog" parent_var_name="" m_connection="blog.index" var_name="menu_add_new_blog" ordering="3" url_value="blog.add" version_id="2.0.0alpha1" disallow_access="" module="blog" />
		<menu module_id="blog" parent_var_name="" m_connection="profile" var_name="menu_blogs" ordering="2" url_value="profile.blog" version_id="2.0.0alpha1" disallow_access="" module="blog" />
		<menu module_id="blog" parent_var_name="" m_connection="mobile" var_name="menu_blog_blogs_532c28d5412dd75bf975fb951c740a30" ordering="114" url_value="blog" version_id="3.1.0rc1" disallow_access="" module="blog" mobile_icon="small_blogs.png" />
	</menus>
	<settings>
		<setting group="time_stamps" module_id="blog" is_hidden="0" type="string" var_name="blog_time_stamp" phrase_var_name="setting_blog_time_stamp" ordering="2" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="" module_id="blog" is_hidden="0" type="integer" var_name="top_bloggers_display_limit" phrase_var_name="setting_top_bloggers_display_limit" ordering="0" version_id="2.0.0alpha1">8</setting>
		<setting group="" module_id="blog" is_hidden="0" type="integer" var_name="top_bloggers_min_post" phrase_var_name="setting_top_bloggers_min_post" ordering="0" version_id="2.0.0alpha1">10</setting>
		<setting group="" module_id="blog" is_hidden="0" type="boolean" var_name="cache_top_bloggers" phrase_var_name="setting_cache_top_bloggers" ordering="0" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="blog" is_hidden="0" type="integer" var_name="cache_top_bloggers_limit" phrase_var_name="setting_cache_top_bloggers_limit" ordering="0" version_id="2.0.0alpha1">180</setting>
		<setting group="" module_id="blog" is_hidden="0" type="boolean" var_name="display_post_count_in_top_bloggers" phrase_var_name="setting_display_post_count_in_top_bloggers" ordering="0" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="blog" is_hidden="0" type="boolean" var_name="show_drafts_count" phrase_var_name="setting_show_drafts_count" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="blog" is_hidden="0" type="integer" var_name="length_in_index" phrase_var_name="setting_length_in_index" ordering="1" version_id="30">200</setting>
		<setting group="spam" module_id="blog" is_hidden="0" type="boolean" var_name="spam_check_blogs" phrase_var_name="setting_spam_check_blogs" ordering="5" version_id="2.0.0rc1">1</setting>
		<setting group="spam" module_id="blog" is_hidden="0" type="boolean" var_name="allow_links_in_blog_title" phrase_var_name="setting_allow_links_in_blog_title" ordering="2" version_id="2.0.0rc1">1</setting>
		<setting group="search_engine_optimization" module_id="blog" is_hidden="0" type="large_string" var_name="blog_meta_description" phrase_var_name="setting_blog_meta_description" ordering="6" version_id="2.0.0rc1">Read up on the latest blogs on Site Name.</setting>
		<setting group="search_engine_optimization" module_id="blog" is_hidden="0" type="large_string" var_name="blog_meta_keywords" phrase_var_name="setting_blog_meta_keywords" ordering="13" version_id="2.0.0rc1">blog, blogs, journals</setting>
		<setting group="" module_id="blog" is_hidden="1" type="boolean" var_name="blog_display_user_post_count" phrase_var_name="setting_blog_display_user_post_count" ordering="1" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="blog" is_hidden="1" type="integer" var_name="blog_cache_minutes" phrase_var_name="setting_blog_cache_minutes" ordering="1" version_id="3.0.0Beta1">0</setting>
		<setting group="" module_id="blog" is_hidden="1" type="integer" var_name="total_pages_to_cache_blog" phrase_var_name="setting_total_pages_to_cache_blog" ordering="1" version_id="3.0.0Beta1">4</setting>
		<setting group="" module_id="blog" is_hidden="1" type="boolean" var_name="digg_integration" phrase_var_name="setting_digg_integration" ordering="1" version_id="2.0.0rc8">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="core.index" module_id="blog" component="new-blogs" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="blog.index" module_id="blog" component="categories" location="1" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title>Categories</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="blog.index" module_id="blog" component="top" location="3" is_active="1" ordering="5" disallow_access="" can_move="0">
			<title>Top Bloggers</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="blog.profile" module_id="blog" component="categories" location="3" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title>User Profile Blog Categories</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_add_category_list_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_add_category_list_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_menu_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_preview_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_preview_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_top_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_top_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_categories_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_categories_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_admincp_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_admincp_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_profile_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_index_process_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_index_process_search" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_index_process_middle" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_index_process_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_add_process_edit" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_add_process_validation" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_add_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_view_process_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_view_process_middle" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_view_process_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_view_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_blog___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_blog_get" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_blog_getblog" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_blog_hasaccess_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_blog_hasaccess_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_blog__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_callback__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_category_get_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_category_get_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_category_getcategories_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_category_getcategories_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_category_getblogsbycategory_count" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_category_getblogsbycategory_query" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_category_getsearch" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_category__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_category_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_add_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_add_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_update" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_delete" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_block_displayoptions" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_block_entry_date_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_block_entry_text_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_block_entry_links_main" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_block_entry_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_controller_view_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_controller_add_hidden_form" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_controller_add_textarea_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_controller_add_submit_buttons" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_controller_add_additional_options" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_new_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="blog" hook_type="controller" module="blog" call_name="blog.component_controller_admincp_browse_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_update__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_update__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_updateblogtitle__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_updateblogtitle__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_updateblogtext__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_updateblogtext__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_deleteinline__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_deleteinline__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_delete__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettags__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettags__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettagsearch__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettagsearch__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettagcloud__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getnewsfeed__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getnewsfeed__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getcommentnewsfeed__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getcommentnewsfeed__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettopusers__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettopusers__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettaglinkprofile__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_gettaglink__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_addtrack__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getlatesttrackusers__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getlatesttrackusers__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getfeedredirect__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getfeedredirect__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_addcomment__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_addcomment__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_processcommentmoderation__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_processcommentmoderation__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_globalsearch__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_globalsearch__return" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_globalsearch__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getfavorite__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getfavorite__return" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getfavorite__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_ondeleteuser__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_ondeleteuser__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_updatecounter__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_get__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_get__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getsearch__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getsearch__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getdraftscount__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getnewblogs__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getnewblogs__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getblogsforedit__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getblog__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getblog__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_verifypassword__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_verifypassword__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_preparetitle__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getextra__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getextra__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getnew__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getnew__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getspamtotal__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_ajax_get_text" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="blog" hook_type="template" module="blog" call_name="blog.template_block_entry_left_item_menu" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_getpendingtotal" added="1276177474" version_id="2.0.5" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_ajax_addviastatusupdate" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="blog" hook_type="component" module="blog" call_name="blog.component_block_share_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_blog_gettotaldrafts" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_browse__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getactivityfeedcomment__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="blog" hook_type="service" module="blog" call_name="blog.service_process_approve__1" added="1335951260" version_id="3.2.0" />
	</hooks>
	<components>
		<component module_id="blog" component="add" m_connection="blog.add" module="blog" is_controller="1" is_block="0" is_active="1" />
		<component module_id="blog" component="add-category-list" m_connection="" module="blog" is_controller="0" is_block="1" is_active="1" />
		<component module_id="blog" component="ajax" m_connection="" module="blog" is_controller="0" is_block="0" is_active="1" />
		<component module_id="blog" component="index" m_connection="blog.index" module="blog" is_controller="1" is_block="0" is_active="1" />
		<component module_id="blog" component="view" m_connection="blog.view" module="blog" is_controller="1" is_block="0" is_active="1" />
		<component module_id="blog" component="display-options" m_connection="" module="blog" is_controller="0" is_block="1" is_active="1" />
		<component module_id="blog" component="categories" m_connection="" module="blog" is_controller="0" is_block="1" is_active="1" />
		<component module_id="blog" component="top" m_connection="" module="blog" is_controller="0" is_block="1" is_active="1" />
		<component module_id="blog" component="profile" m_connection="blog.profile" module="blog" is_controller="1" is_block="0" is_active="1" />
		<component module_id="blog" component="profile.index" m_connection="" module="blog" is_controller="0" is_block="1" is_active="1" />
		<component module_id="blog" component="preview" m_connection="" module="blog" is_controller="0" is_block="1" is_active="1" />
		<component module_id="blog" component="menu" m_connection="" module="blog" is_controller="0" is_block="1" is_active="1" />
		<component module_id="blog" component="admincp.index" m_connection="" module="blog" is_controller="0" is_block="0" is_active="1" />
		<component module_id="blog" component="admincp.add" m_connection="" module="blog" is_controller="0" is_block="0" is_active="1" />
		<component module_id="blog" component="delete" m_connection="blog.delete" module="blog" is_controller="1" is_block="0" is_active="1" />
	</components>
	<stats>
		<stat module_id="blog" phrase_var="blog.stat_title_2" stat_link="blog" stat_image="blog.png" is_active="1"><![CDATA[$this->database()
->select('COUNT(*)')
->from(Phpfox::getT('blog'))
->where('is_approved = 1 AND post_status = 1')
->execute('getSlaveField');]]></stat>
	</stats>
	<feed_share>
		<share module_id="blog" title="{phrase var='blog.blog'}" description="{phrase var='blog.write_your_blog_entry_here'}" block_name="share" no_input="0" is_frame="0" ajax_request="addViaStatusUpdate" no_profile="1" icon="blog.png" ordering="5" />
	</feed_share>
	<phrases>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_view_blogs" added="1214436163">Can view blogs.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_edit_own_blog" added="1214436244">Can edit their own blogs?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_edit_user_blog" added="1214436264">Can edit blogs added by other users?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_delete_own_blog" added="1214436270">Can delete their own blog?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_delete_user_blog" added="1214436277">Can delete blogs added by other users?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_search_blogs" added="1214436285">Can search for blogs?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_add_new_blog" added="1214436306">Can add a new blog?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_blog_add_categories" added="1214436490">Can create new blog categories when adding a blog?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_can_control_comments_on_blogs" added="1214436533">Can control if a user can add a comment on their blog or simply disable comments?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_can_password_protect_blogs" added="1214436544"><![CDATA[Can password protect blogs?

If set to <b>Yes</b> and if user would try to view a password protected blog they will not be able to view or comment on the blog unless they enter the correct password.

The user that added the blog will not have to enter the password.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_can_use_editor_on_blog" added="1214436572">Can use a WYSIWYG Editor when creating or editing a blog?

Note: The WYSIWYG Editor feature must be enabled.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_can_post_comment_on_blog" added="1214975412">Can post comments on blogs?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_can_view_password_protected_blog" added="1214975898"><![CDATA[Can view password protected blogs?

If a blog has been password protected a user will have to enter a password before they can view or comment on the blog. 

If this feature is set to <b>No</b> they will not have the opportunity to enter a password thus not allowing them to view such blogs.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_points_blog" added="1214982408">Specify how many points the user will receive when adding a new blog.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_blog_category_limit" added="1218791957">blog category limit</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="blog" added="1214844661">Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="module_blog" added="1219135843">nice test</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="already_a_category" added="1212114610">This category already exists.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="posted_x_by_x_in_x" added="1212114864"><![CDATA[Posted {date} by <a href="{link}">{full_name}</a> in {categories}]]></phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="posted_x_by_x" added="1212118012"><![CDATA[Posted {date} by <a href="{link}">{full_name}</a>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="x_comment" added="1212118157">{total} Comment</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="x_comments" added="1212118195">{total} Comments</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="view_entry" added="1212118224">View Entry</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="this_blog_password_protected" added="1212118249">This blog is password protected.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="enter_password" added="1212118284">Enter Password</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="click_to_edit_title" added="1212118317">Click to Edit Title</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="delete_blog" added="1212118384">Delete Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="search_blogs_" added="1212123440">Search Blogs...</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="blogs" added="1212123482">Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="unable_to_view_password_protected_blogs" added="1212123772">You are unable to view password protected blogs.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="password_is_invalid" added="1212123827">Password is invalid.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="blog_not_found" added="1212123902">The blog you are looking for cannot be found.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="comments_have_been_disabled" added="1212123947">Comments have been disabled.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="no_blogs_added" added="1213594226">No blogs have been added.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="be_first_to_add_a_blog" added="1213594273">Be the first to add a blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="title" added="1213594579">Title</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="fill_title_for_blog" added="1213606861">Fill in a title for your blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="add_content_to_blog" added="1213606896">Add some content to your blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="maximum_length_password" added="1213606965">Maximum length for your password is {length}</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="add_a_new_blog" added="1213607039">Add a New Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="adding_a_new_blog" added="1213607053">Add a New Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="menu_blogs" added="1213607098">Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="your_blog_has_been_added" added="1213607139">Your blog has been added</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="post" added="1213607157">Post</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="categories" added="1213607178">Categories</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="all" added="1213607202">All</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="public" added="1213607214">Public</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="personal" added="1213607227">Personal</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="most_used" added="1213607244">Most Used</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="manage_categories" added="1213607259">Manage Categories</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="add_a_new_category" added="1213607287">Add a new category...</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="multiple_categories_with_commas" added="1213607389">Separate multiple categories with commas.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="add" added="1213607405">Add</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="additional_options" added="1213612389">Additional Options</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="privacy" added="1213612412">Privacy</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="public_blog_added_public_blog_section" added="1213612445">Public (Blog will be added to our public blog section)</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="personal_blog_displayed_profile" added="1213612471">Personal (Blog will only be displayed on your profile)</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="friends_view_this_blog" added="1213612509">Friends (Only you and your friends can view this blog)</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="preferred_list" added="1213612543">Preferred List (Only you and the members you select can view this blog)</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="separate_friends_commas" added="1213612566">Separate friends with commas.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="password_protect_post" added="1213612585">Password-Protect</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="discussion" added="1213612600">Discussion</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="allow_comments" added="1213612615">Allow Comments</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="post_status" added="1213612635">Post Status</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="published" added="1213612660">Published</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="draft" added="1213612671">Draft</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="save_as_draft" added="1213612691">Save as Draft</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="preview" added="1213612716">Preview</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="publish" added="1213612750">Publish</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="update" added="1213612775">Update</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="blog_preview" added="1213855272">Blog Preview</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="editing_blog" added="1213855344">Editing Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="blog_updated" added="1213855813">Blog Updated</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="invalid_search" added="1214706746">Invalid search ID#</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="searching" added="1214706764">Searching</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="search_results_found" added="1214706814">No search results found!</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="menu_add_new_blog" added="1215259888">Add New Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="search_filter" added="1217558351">Search Filter</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="top_bloggers" added="1217797114">Top Bloggers</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="time" added="1217797266">Time</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="most_viewed" added="1217797279">Most Viewed</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="most_talked_about" added="1217797290">Most Talked About</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="search_for_text" added="1217797327">Search For Text</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="display" added="1217797335">Display</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="sort" added="1217797343">Sort By</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="added" added="1218529569">Added</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="blog_deleted" added="1218529633">Blog Deleted</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="password_invalid" added="1218529740">Password is invalid.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="unable_view_password_protected_blogs" added="1218529789">You are unable to view password protected blogs.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="click_edit_permalink" added="1218548055">Click to edit permalink.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="permalink" added="1218548064">Permalink</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="you_have_reached_your_limit" added="1218793409">You have reached your limit.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="tip_delete_category" added="1219325630"><![CDATA[Deleting a category will not delete the blogs that belong to that category, it will only remove the specific category and any blogs that belong to that category will be set under "Uncategorized".]]></phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="search_for_user" added="1219328631">Search for User</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="created" added="1219328642">Created By</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="name" added="1219328685">Name</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="total_blogs" added="1219328723">Total Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="system" added="1219328731">System</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="delete_selected" added="1219328746">Delete Selected</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="none" added="1219328767">None</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="users" added="1219328992">Users</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="categories_successfully_deleted" added="1219329875">Categories successfully deleted.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="add_category" added="1219391589">Add New Category</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="category_successfully_added" added="1219393407">Category successfully added.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="provide_blog_category" added="1219393431">Provide a blog category.</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="category_details" added="1219393445">Category Details</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="category" added="1219393453">Category</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="sort_single" added="1219840870">Sort</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="single" added="1219840881">By</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="created_user" added="1221831207">Created By</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="setting_show_drafts_count" added="1233222866"><![CDATA[<title>Show drafts count in blog module</title><info>Enables the module to show how many drafts does each user have from the profile.blog section</info>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0alpha1" var_name="user_setting_show_drafts_count" added="1233223235">Show how many drafts are stored</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha3" var_name="user_setting_can_delete_other_blog_category" added="1238248276">Can delete blog categories created by other users?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha3" var_name="user_setting_can_delete_own_blog_category" added="1238248327">Can delete own blog categories?</phrase>
		<phrase module_id="blog" version_id="2.0.0alpha3" var_name="setting_display_blog_category_count" added="1238349584"><![CDATA[<title>Display Blog Category Count</title><info>Set to <b>True</b> if you would like to display the blog count for each of the categories displayed publicly.</info>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0beta4" var_name="stat_title_2" added="1245142611">Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0beta5" var_name="rss_group_name_1" added="1245515168">Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0beta5" var_name="rss_title_1" added="1245516443">Latest Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0beta5" var_name="rss_description_1" added="1245516443">Latest Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0beta5" var_name="rss_title_2" added="1245531498">Categories</phrase>
		<phrase module_id="blog" version_id="2.0.0beta5" var_name="rss_description_2" added="1245531498">Blog categories...</phrase>
		<phrase module_id="blog" version_id="30" var_name="setting_length_in_index" added="1247587010"><![CDATA[<title>How Long is the Preview</title><info>How much of the blog to show on the main blog section?

Value is in characters, i.e.:
15 would show something like:
"Lorem ipsum dol..."

0 = No limit</info>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc1" var_name="user_setting_can_approve_blogs" added="1251202806">Can approve blogs?</phrase>
		<phrase module_id="blog" version_id="2.0.0rc1" var_name="setting_spam_check_blogs" added="1251269478"><![CDATA[<title>Spam Check Blogs</title><info>Spam Check Blogs</info>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc1" var_name="setting_allow_links_in_blog_title" added="1251270055"><![CDATA[<title>Allow Links in Blog Titles</title><info>Allow Links in Blog Titles</info>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc1" var_name="setting_blog_meta_description" added="1252057473"><![CDATA[<title>Blog Meta Description</title><info>Meta description added to pages related to the Blog module.</info>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc1" var_name="setting_blog_meta_keywords" added="1252058698"><![CDATA[<title>Blog Meta Keywords</title><info>Mete keywords that will be displayed on sections related to the Blog module.</info>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="add_a_title" added="1252927105">Add a title.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="add_some_text" added="1252927127">Add some text.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="unable_to_edit_this_blog" added="1252927237">Unable to edit this blog.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="blog_successfully_saved" added="1252927265">Blog successfully saved.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="blog_title" added="1252927310">Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="full_name_s_blogs" added="1252927338"><![CDATA[{full_name}'s Blogs]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="full_name_s_blogs_on_site_title" added="1252927452"><![CDATA[{full_name}'s blogs on {site_title}.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="blogs_title" added="1252928477">Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="owner_full_name_added_a_new_blog_a_href_title_link_title_a" added="1252928621"><![CDATA[<a href="{user_link}">{owner_full_name}</a> added a new blog "<a href="{title_link}">{title}</a>".]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="we_do_not_allow_links_in_titles" added="1252928947">We do not allow links in titles.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="your_blog_has_been_marked_as_spam" added="1252929018">Your blog has been marked as spam. It will have to be approved by an Admin before it is displayed publicly.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="the_blog_you_are_trying_to_approve_is_not_valid" added="1252929042">The blog you are trying to approve is not valid.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="your_blog_has_been_approved_on_site_title" added="1252929062">Your blog has been approved on {site_title}.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="your_blog_has_been_approved_on_site_title_message" added="1252929150"><![CDATA[Your blog has been approved on {site_title}.

To view this blog, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="no_categories_added" added="1252929208">No categories added.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="private_entry" added="1252929256">PRIVATE ENTRY</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="private_entry_friends_only" added="1252929264">PRIVATE ENTRY - FRIENDS ONLY</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="private_blog_entry" added="1252929282">Private blog entry...</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="private_blog_entry_friends_only" added="1252929290">Private blog entry. Friends only...</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="approve" added="1252929386">Approve</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="favorite" added="1252929401">Favorite</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="add_to_your_favorites" added="1252929410">Add to your Favorites</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="report" added="1252929417">Report</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="report_a_blog" added="1252929424">Report a Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="are_you_sure_you_want_to_delete_this_blog" added="1252929444">Are you sure you want to delete this blog?</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="add_new_blog" added="1252929466">Add New Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="view_drafts_count" added="1252929510">View Drafts ({count})</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="no_blogs_have_been_added_yet" added="1252929703">No blogs have been added yet.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="be_the_first_to_add_a_blog" added="1252929712">Be the First to Add a Blog.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="posted_on_post_time_by_user_link" added="1252929857">Posted on {post_time} by {user_link}.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="comments" added="1252934810">Comments</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="moderate_comments_first" added="1252934832">Moderate Comments First</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="no_comments" added="1252934841">No Comments</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="blog_has_been_deleted" added="1252934891">Blog has been deleted!</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="tags" added="1252934912">Tags</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="status" added="1252934921">Status</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="date" added="1252934928">Date</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="delete" added="1252934952">Delete</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="you_have_not_added_any_drafts" added="1252934973">You have not added any drafts.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="you_have_not_added_any_blogs" added="1252934983">You have not added any blogs.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="add_a_new_blog_entry" added="1252935002">Add a New Blog Entry</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="user_link_has_not_added_any_blogs" added="1252935029">{user_link} has not added any blogs.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="browse_other_blog_entries" added="1252935242">Browse Other Blog Entries</phrase>
		<phrase module_id="blog" version_id="2.0.0rc2" var_name="this_blog_is_pending_an_admins_approval" added="1252935262">This blog is pending an Admins approval.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="user_added_a_new_comment_on_their_own_blog" added="1254380430"><![CDATA[<a href="{user_link}">{user_name}</a> added a new comment on their own <a href="{title_link}">blog</a>.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="user_added_a_new_comment_on_your_blog" added="1254381407"><![CDATA[<a href="{user_link}">{user_name}</a> added a new comment on your <a href="{title_link}">blog</a>.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="user_name_added_a_new_comment_on_item_user_name_blog" added="1254381593"><![CDATA[<a href="{user_link}">{user_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">blog</a>.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="user_name_left_you_a_comment_on_site_title" added="1254381747">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="user_name_left_you_a_comment_on_site_title_to_view_this_comment" added="1254381827"><![CDATA[{user_name} left you a comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="user_name_left_you_a_comment_on_site_title_however_before_it_can_be_displayed_it" added="1254381922"><![CDATA[{user_name} left you a comment on {site_title}, however before it can be displayed it needs to be approved by you.

You can approve or deny this comment by following the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="search_blogs" added="1254382037">Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="view_more_blogs" added="1254382051">View More Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="blog_created_on_time_stamp_by_full_name" added="1254382119"><![CDATA[<a href="{link}">Blog</a> created on {time_stamp} by <a href="{user_link}">{full_name}</a>.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="write_a_blog" added="1254382481">Write a Blog</phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="manage_blogs" added="1254382492">Manage Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="your_blog_blog_title_has_been_approved" added="1254382530"><![CDATA[Your blog "{blog_title}" has been approved.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="full_name_wrote_a_comment_on_your_blog_blog_title" added="1254382644"><![CDATA[<a href="{user_link}">{full_name}</a> wrote a comment on your blog "<a href="{blog_link}">{blog_title}</a>".]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc3" var_name="blogs_text" added="1254382713">Blogs Text</phrase>
		<phrase module_id="blog" version_id="2.0.0rc8" var_name="setting_digg_integration" added="1258399183"><![CDATA[<title>Digg Intergration</title><info>Add Digg integration.</info>]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_blog_a" added="1260472335"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">blog</a>.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_a_href_link_blog_a" added="1260472354"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">blog</a>.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_blog_a" added="1260472367"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">blog</a>.]]></phrase>
		<phrase module_id="blog" version_id="2.0.0" var_name="update_tags_blogs" added="1261056796">Update Tags (Blogs)</phrase>
		<phrase module_id="blog" version_id="2.0.0" var_name="user_setting_can_view_private_blogs" added="1261072610">Can view private and password protected blogs?</phrase>
		<phrase module_id="blog" version_id="2.0.0" var_name="no_blog_categories_have_been_created" added="1261078923">No blog categories have been created.</phrase>
		<phrase module_id="blog" version_id="2.0.0" var_name="create_one_now" added="1261078933">Create one now</phrase>
		<phrase module_id="blog" version_id="2.0.0" var_name="draft_info" added="1261422066"><![CDATA[[DRAFT]]]></phrase>
		<phrase module_id="blog" version_id="2.0.2" var_name="update_users_activity_blog_points" added="1263379913">Update Users Activity Blog Points</phrase>
		<phrase module_id="blog" version_id="2.0.5dev1" var_name="user_setting_approve_blogs" added="1274842829">Approve blogs before they are publicly displayed?</phrase>
		<phrase module_id="blog" version_id="2.0.5dev1" var_name="recent_blogs" added="1274843713">Recent Blogs</phrase>
		<phrase module_id="blog" version_id="2.0.5dev1" var_name="most_disccused" added="1274843732">Most Disccused</phrase>
		<phrase module_id="blog" version_id="2.0.5dev1" var_name="most_discussed" added="1274843742">Most Discussed</phrase>
		<phrase module_id="blog" version_id="2.0.5dev1" var_name="pending" added="1274843749">Pending</phrase>
		<phrase module_id="blog" version_id="2.0.5dev1" var_name="there_are_blogs_pending_approval_total_total" added="1274843907">There are blogs pending approval. Total: {total}</phrase>
		<phrase module_id="blog" version_id="2.0.5dev1" var_name="approve_blogs_here" added="1274843988">Approve blogs here.</phrase>
		<phrase module_id="blog" version_id="2.0.5dev2" var_name="user_setting_flood_control_blog" added="1275105423"><![CDATA[How many minutes should a user wait before they can submit another blog?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></phrase>
		<phrase module_id="blog" version_id="2.0.5dev2" var_name="your_are_posting_a_little_too_soon" added="1275105712">You are posting a little too soon.</phrase>
		<phrase module_id="blog" version_id="2.0.7" var_name="there_are_no_pending_blogs" added="1288344199">There are no pending blogs.</phrase>
		<phrase module_id="blog" version_id="3.0.0Beta1" var_name="setting_blog_cache_minutes" added="1295019128"><![CDATA[<title>Blog Cache (Minutes)</title><info>Define how many minutes to wait until blogs are repopulated with new data.

Set this to "0" (without quotes) to always output the latest data.

Note for larger communities we strongly advice to enable this feature as this will improve your sites overall performance.</info>]]></phrase>
		<phrase module_id="blog" version_id="3.0.0Beta1" var_name="setting_total_pages_to_cache_blog" added="1295255472"><![CDATA[<title>Total Pages to Cache</title><info>By default we display 5 blogs per page on the blog section. If caching is enabled this setting controls how many blogs to cache thus allowing users to browse X number of pages in cache before running a query to retrieve live data. If we display 5 items per page and this setting is set to 4 it will cache 20 blogs as we multiply the total blogs we display by this setting.</info>]]></phrase>
		<phrase module_id="blog" version_id="3.0.0Beta1" var_name="write_your_blog_entry_here" added="1302203113">Write your blog entry here...</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="blog_has_been_approved" added="1319124127">Blog has been approved.</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="blog_approved" added="1319124141">Blog Approved</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="search_blogs_dot" added="1319188095">Search Blogs...</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="latest" added="1319188102">Latest</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="most_liked" added="1319188122">Most Liked</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="all_blogs" added="1319188132">All Blogs</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="my_blogs" added="1319188141">My Blogs</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="friends_blogs" added="1319188155"><![CDATA[Friends' Blogs]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="pending_blogs" added="1319188167">Pending Blogs</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="by_user" added="1319188864">by {full_name}</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="actions" added="1319188946">Actions</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="view_blog" added="1319188996">View Blog</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="comment_privacy" added="1319189007">Comment Privacy</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="control_who_can_see_this_blog" added="1319189021">Control who can see this blog.</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="control_who_can_comment_on_this_blog" added="1319189038">Control who can comment on this blog.</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="by_full_name" added="1319191124">by {full_name}</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="report_this_blog" added="1319195940">Report this blog</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="no_blogs_found" added="1319197044">No blogs found.</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="full_name_liked_your_blog_title" added="1319467184"><![CDATA[{full_name} liked your blog "{title}"]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="full_name_liked_your_blog_link_title" added="1319467373"><![CDATA[{full_name} liked your blog "<a href="{link}">{title}</a>"
To view this blog follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="users_liked_gender_own_blog_title" added="1319536679"><![CDATA[{users} liked {gender} own blog "{title}"]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="users_liked_your_blog_title" added="1319536724"><![CDATA[{users} liked your blog "{title}"]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_row_full_name_s_span_blog_title" added="1319536765"><![CDATA[{users} liked <span class="drop_data_user">{row_full_name}'s</span> blog "{title}"]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="full_name_commented_on_your_blog_title" added="1319540987"><![CDATA[{full_name} commented on your blog "{title}".]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="full_name_commented_on_your_blog_message" added="1319541173"><![CDATA[{full_name} commented on your blog "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="full_name_commented_on_gender_blog" added="1319541233">{full_name} commented on {gender} blog.</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="full_name_commented_on_blog_full_name_s_blog" added="1319541276"><![CDATA[{full_name} commented on {blog_full_name}'s blog.]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="full_name_commented_on_gender_blog_message" added="1319541377"><![CDATA[{full_name} commented on {gender} blog "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="full_name_commented_on_blog_full_name_s_blog_message" added="1319541478"><![CDATA[{full_name} commented on {blog_full_name}'s blog "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1319541528">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="users_commented_on_gender_blog_title" added="1319541665"><![CDATA[{users} commented on {gender} blog "{title}"]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="users_commented_on_your_blog_title" added="1319541703"><![CDATA[{users} commented on your blog "{title}"]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="users_commented_on_span_class_drop_data_user_row_full_name" added="1319541752"><![CDATA[{users} commented on <span class="drop_data_user">{row_full_name}'s</span> blog "{title}"]]></phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="users_blog_count" added="1319542630">Users Blog Count</phrase>
		<phrase module_id="blog" version_id="3.0.0beta5" var_name="your_blog_title_has_been_approved" added="1319542672"><![CDATA[Your blog "{title}" has been approved.]]></phrase>
		<phrase module_id="blog" version_id="3.0.0rc1" var_name="see_more" added="1320076456">See More</phrase>
		<phrase module_id="blog" version_id="3.0.0" var_name="posted_a_comment_on_gender_blog_a_href_link_title_a" added="1322559353"><![CDATA[posted a comment on {gender} blog <a href="{link}"> {title}</a>]]></phrase>
		<phrase module_id="blog" version_id="3.0.0" var_name="posted_a_comment_on_user_name_s_blog_a_href_link_title_a" added="1322559633"><![CDATA[posted a comment on {user_name}'s blog "<a href="{link}">{title}</a>"]]></phrase>
		<phrase module_id="blog" version_id="3.0.0" var_name="a_href_link_on_name_s_blog_a" added="1322559886"><![CDATA[<a href="{link}">On {name}'s blog</a>]]></phrase>
		<phrase module_id="blog" version_id="3.0.0" var_name="please_provide_some_text_for_your_blog" added="1322739183">Please provide some text for your blog.</phrase>
		<phrase module_id="blog" version_id="3.0.0" var_name="blog_s_successfully_approved" added="1322739208">Blog(s) successfully approved.</phrase>
		<phrase module_id="blog" version_id="3.0.0" var_name="blog_s_successfully_deleted" added="1322739225">Blog(s) successfully deleted.</phrase>
		<phrase module_id="blog" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_a_blog" added="1331221899">{user_name} tagged you in a comment in a blog</phrase>
		<phrase module_id="blog" version_id="3.1.0rc1" var_name="menu_blog_blogs_532c28d5412dd75bf975fb951c740a30" added="1332257664">Blogs</phrase>
		<phrase module_id="blog" version_id="3.4.0beta2" var_name="blog_successfully_deleted" added="1348142472">Blog successfully deleted.</phrase>
		<phrase module_id="blog" version_id="3.5.0beta1" var_name="item_phrase" added="1352730269">blog entry</phrase>
		<phrase module_id="blog" version_id="3.5.0beta1" var_name="cannot_display_due_to_privacy" added="1353501183">Cannot display this section due to privacy.</phrase>
	</phrases>
	<rss_group>
		<group module_id="blog" group_id="1" name_var="blog.rss_group_name_1" is_active="1" />
	</rss_group>
	<rss>
		<feed module_id="blog" group_id="1" title_var="blog.rss_title_1" description_var="blog.rss_description_1" feed_link="blog" is_active="1" is_site_wide="1">
			<php_group_code></php_group_code>
			<php_view_code><![CDATA[$aRows = $this->database()->select('bt.text_parsed AS text, b.blog_id, b.title, u.user_name, u.full_name, b.time_stamp')
	->from(Phpfox::getT('blog'), 'b')
        ->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id') 
	->join(Phpfox::getT('blog_text'), 'bt','bt.blog_id = b.blog_id')
	->where('b.is_approved = 1 AND b.privacy = 0 AND b.post_status = 1')
	->limit(Phpfox::getParam('rss.total_rss_display'))
	->order('b.blog_id DESC')
	->execute('getSlaveRows');
$iCnt = count($aRows);

foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['description'] = $aRow['text'];
	$aRows[$iKey]['link'] = Phpfox::permaLink('blog', $aRow['blog_id'], $aRow['title']);
	$aRows[$iKey]['creator'] = $aRow['full_name'];
}]]></php_view_code>
		</feed>
		<feed module_id="blog" group_id="1" title_var="blog.rss_title_2" description_var="blog.rss_description_2" feed_link="blog.category.{TITLE_URL}" is_active="1" is_site_wide="0">
			<php_group_code><![CDATA[$aCategories = $this->database()->select('category_id, name')
	->from(Phpfox::getT('blog_category'))
	->where('user_id = 0')
	->execute('getSlaveRows');
if (count($aCategories))
{
	foreach ($aCategories as $aCategory)
	{
		$aRow['child'][Phpfox::getLib('phpfox.url')->makeUrl('rss', array('id' => $aRow['feed_id'], 'category' => $aCategory['category_id']))] = $aCategory['name'];
	}
}]]></php_group_code>
			<php_view_code><![CDATA[list($iCnt, $aRows) = Phpfox::getService('blog.category')->getBlogsByCategory(Phpfox::getLib('phpfox.request')->get('category'), 0, array('AND blog.is_approved = 1 AND blog.privacy = 0 AND blog.post_status = 1'), 'blog.time_stamp DESC', 0, Phpfox::getParam('rss.total_rss_display'));

foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['description'] = $aRow['text'];
	$aRows[$iKey]['link'] = Phpfox::permalink('blog', $aRow['blog_id'], $aRow['title']);
	$aRows[$iKey]['creator'] = $aRow['full_name'];
}


$aCategory = $this->database()->select('*')
	->from(Phpfox::getT('blog_category'))
	->where('category_id = ' . (int) Phpfox::getLib('phpfox.request')->get('category'))
	->execute('getSlaveRow');

$aFeed['feed_link'] = Phpfox::permalink('blog.category', $aCategory['category_id'], $aCategory['name']);
$sDescription = $aCategory['name'];]]></php_view_code>
		</feed>
	</rss>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="1" staff="1" module="blog" ordering="1">view_blogs</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="2">edit_own_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="0" guest="0" staff="1" module="blog" ordering="3">edit_user_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="4">delete_own_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="0" guest="0" staff="1" module="blog" ordering="5">delete_user_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="1" staff="1" module="blog" ordering="6">search_blogs</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="7">add_new_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="integer" admin="1" user="1" guest="1" staff="1" module="blog" ordering="8">points_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="10">blog_add_categories</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="12">can_password_protect_blogs</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="13">can_control_comments_on_blogs</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="14">can_use_editor_on_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="0">can_post_comment_on_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="15">can_view_password_protected_blog</setting>
		<setting is_admin_setting="0" module_id="blog" type="string" admin="10" user="null" guest="0" staff="10" module="blog" ordering="0">blog_category_limit</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="0" guest="0" staff="1" module="blog" ordering="0">show_drafts_count</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="0" guest="0" staff="1" module="blog" ordering="0">can_delete_other_blog_category</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="1" guest="0" staff="1" module="blog" ordering="0">can_delete_own_blog_category</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="0" guest="0" staff="1" module="blog" ordering="0">can_approve_blogs</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="1" user="0" guest="0" staff="1" module="blog" ordering="0">can_view_private_blogs</setting>
		<setting is_admin_setting="0" module_id="blog" type="boolean" admin="0" user="0" guest="0" staff="0" module="blog" ordering="0">approve_blogs</setting>
		<setting is_admin_setting="0" module_id="blog" type="integer" admin="0" user="0" guest="0" staff="0" module="blog" ordering="0">flood_control_blog</setting>
	</user_group_settings>
	<tables><![CDATA[a:5:{s:11:"phpfox_blog";a:3:{s:7:"COLUMNS";a:16:{s:7:"blog_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"time_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_approved";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"post_status";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"total_attachment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;s:4:"blog";i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"blog_id";s:4:"KEYS";a:5:{s:11:"public_view";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:11:"is_approved";i:1;s:7:"privacy";i:2;s:11:"post_status";}}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"user_id";i:1;s:11:"is_approved";i:2;s:7:"privacy";i:3;s:11:"post_status";}}s:10:"time_stamp";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:10:"time_stamp";i:1;s:11:"is_approved";i:2;s:7:"privacy";i:3;s:11:"post_status";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:7:"user_id";i:1;s:10:"time_stamp";i:2;s:11:"is_approved";i:3;s:7:"privacy";i:4;s:11:"post_status";}}s:5:"title";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:5:"title";i:1;s:11:"is_approved";i:2;s:7:"privacy";i:3;s:11:"post_status";}}}}s:20:"phpfox_blog_category";a:3:{s:7:"COLUMNS";a:5:{s:11:"category_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"used";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"category_id";s:4:"KEYS";a:3:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:11:"category_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"category_id";i:1;s:7:"user_id";}}s:8:"name_url";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:25:"phpfox_blog_category_data";a:2:{s:7:"COLUMNS";a:2:{s:7:"blog_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"category_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:7:"blog_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"blog_id";}s:11:"category_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"category_id";}}}s:16:"phpfox_blog_text";a:2:{s:7:"COLUMNS";a:3:{s:7:"blog_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"text_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:7:"blog_id";}s:17:"phpfox_blog_track";a:2:{s:7:"COLUMNS";a:3:{s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}}}}]]></tables>
	<install><![CDATA[
		$aBlogCategories = array(
			'Business' => 'business',
			'Education' => 'education',
			'Entertainment' => 'entertainment',
			'Family & Home' => 'family-home',
			'Health' => 'health',
			'Recreation' => 'recreation',
			'Shopping' => 'shopping',
			'Society' => 'society',
			'Sports' => 'sports',
			'Technology' => 'technology'
		);
		foreach ($aBlogCategories as $sName => $sUrl)
		{
			$this->database()->insert(Phpfox::getT('blog_category'), array(
					'name' => $sName,
					'added' => PHPFOX_TIME
				)
			);
		}
	]]></install>
</module>