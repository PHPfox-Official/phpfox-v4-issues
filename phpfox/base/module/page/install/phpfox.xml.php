<module>
	<data>
		<module_id>page</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_page</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="page" parent_var_name="" m_connection="footer" var_name="menu_terms" ordering="32" url_value="terms" version_id="2.0.0alpha1" disallow_access="" module="page" />
	</menus>
	<hooks>
		<hook module_id="page" hook_type="controller" module="page" call_name="page.component_controller_admincp_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="controller" module="page" call_name="page.component_controller_admincp_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="controller" module="page" call_name="page.component_controller_view_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="controller" module="page" call_name="page.component_controller_view_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="service" module="page" call_name="page.service_log_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="service" module="page" call_name="page.service_page_getforedit" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="service" module="page" call_name="page.service_page_get" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="service" module="page" call_name="page.service_page_getcache" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="service" module="page" call_name="page.service_page_getpage" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="service" module="page" call_name="page.service_page__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="service" module="page" call_name="page.service_callback___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="service" module="page" call_name="page.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="template" module="page" call_name="page.template_controller_view_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="template" module="page" call_name="page.template_controller_view_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="page" hook_type="controller" module="page" call_name="page.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="page" hook_type="component" module="page" call_name="page.component_block_view_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="page" hook_type="template" module="page" call_name="page.template_controller_admincp_add_editor" added="1274286148" version_id="2.0.5dev1" />
	</hooks>
	<components>
		<component module_id="page" component="admincp.index" m_connection="" module="page" is_controller="0" is_block="0" is_active="1" />
		<component module_id="page" component="admincp.add" m_connection="" module="page" is_controller="0" is_block="0" is_active="1" />
		<component module_id="page" component="admincp.ajax" m_connection="" module="page" is_controller="0" is_block="0" is_active="1" />
		<component module_id="page" component="view" m_connection="page.view" module="page" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="user_setting_can_manage_custom_pages" added="1217465936">Can manage custom pages from within the AdminCP?

This includes adding/editing/deleting pages.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="module_page" added="1217293198">Handles custom pages created from within the AdminCP.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="missing_title" added="1217293231">Missing a title.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="select_product" added="1217293258">Select a product.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="specify_page_active" added="1217293292">Specify if the page is active.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_missing_data" added="1217293309">Page is missing data.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="add_new_page" added="1217293351">Add New Page</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="successfully_added" added="1217293416">Successfully added.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_added_continue" added="1217293441">Page successfully added. Please continue below to add a menu to your page.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="details" added="1217293598">Details</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="product" added="1217293614">Product</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_title" added="1217293636">Page Title</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="url_title" added="1217293651">URL Title</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="meta_keywords" added="1217293663">Meta Keywords</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="meta_description" added="1217293676">Meta Description</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="active" added="1217293693">Active</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="use_entire_page" added="1217293707">Use Entire Page</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="add_menu" added="1217293717">Add To Menu</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="allow_access" added="1217293731">Allow Access</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_data" added="1217293747">Page Data</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="bbcode" added="1217293759">BBCode</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="emoticons" added="1217293778">Emoticons</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="add_smart_breaks" added="1217293787">Add Smart Breaks</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="options" added="1217293818">Options</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="phrase_from_language_package" added="1217293855">Is a phrase from a language package?</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_successfully_deleted" added="1217556059">Page successfully deleted.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_activity_successfully_updated" added="1217556073">Page activity successfully updated.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="manage_pages" added="1217556086">Manage Pages</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page" added="1217556107">Page</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="created" added="1217556116">Created</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="actions" added="1217556140">Actions</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="select_action" added="1217556164">Select Action</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="edit_page" added="1217556177">Edit Page</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="edit_page_menu" added="1217556186">Edit Page Menu</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="delete" added="1217556197">Delete</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_successfully_updated" added="1217556323">Page successfully updated.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="add_bookmark_links" added="1217556416">Add Bookmark Links</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="add_page_views" added="1217556429">Add Page Views</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="can_modify" added="1217556448">Can Modify</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="php" added="1217556471">PHP</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="wiki" added="1217556479">Wiki</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="bookmark" added="1217556549">Bookmark</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_has_been_viewed_once" added="1217556574">Page has been viewed once.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="page_has_been_viewed" added="1217556593">Page has been viewed {total} times.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="edit" added="1217556688">Edit</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="invalid_title" added="1218451159">Page title is invalid.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="missing_url_title" added="1218451222">Missing URL title.</phrase>
		<phrase module_id="page" version_id="2.0.0alpha1" var_name="menu_terms" added="1232964965">Terms</phrase>
		<phrase module_id="page" version_id="2.0.0rc4" var_name="unable_to_find_the_page_you_are_looking_for" added="1255093305">Unable to find the page you are looking for.</phrase>
		<phrase module_id="page" version_id="2.0.0rc4" var_name="module" added="1255093434">Module</phrase>
		<phrase module_id="page" version_id="2.0.0rc4" var_name="select" added="1255093444">Select</phrase>
		<phrase module_id="page" version_id="2.0.0rc4" var_name="no_pages_have_been_added" added="1255093469">No pages have been added.</phrase>
		<phrase module_id="page" version_id="2.0.0rc4" var_name="create_a_new_page" added="1255093476">Create a New Page</phrase>
		<phrase module_id="page" version_id="2.0.0" var_name="update_tags_pages" added="1261056616">Update Tags (Pages)</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="page" type="boolean" admin="1" user="0" guest="0" staff="0" module="page" ordering="0">can_manage_custom_pages</setting>
	</user_group_settings>
	<tables><![CDATA[a:4:{s:11:"phpfox_page";a:3:{s:7:"COLUMNS";a:17:{s:7:"page_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_phrase";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"parse_php";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"has_bookmark";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"add_view";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"full_size";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"title_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"disallow_access";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"total_attachment";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"total_tag";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"page_id";s:4:"KEYS";a:4:{s:9:"url_value";a:2:{i:0;s:5:"INDEX";i:1;s:9:"title_url";}s:7:"page_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"page_id";i:1;s:9:"is_active";}}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_active";i:1;s:9:"title_url";}}s:10:"product_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"product_id";}}}s:15:"phpfox_page_log";a:2:{s:7:"COLUMNS";a:3:{s:7:"page_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"updated";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"page_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"page_id";}}}s:16:"phpfox_page_text";a:2:{s:7:"COLUMNS";a:5:{s:7:"page_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"text_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"keyword";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"description";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"page_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"page_id";}}}s:17:"phpfox_page_track";a:2:{s:7:"COLUMNS";a:3:{s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}}}}]]></tables>
</module>