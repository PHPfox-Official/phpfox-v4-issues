<module>
	<data>
		<module_id>report</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:3:{s:30:"report.admin_menu_view_reports";a:1:{s:3:"url";a:1:{i:0;s:6:"report";}}s:30:"report.admin_menu_add_category";a:1:{s:3:"url";a:2:{i:0;s:6:"report";i:1;s:3:"add";}}s:35:"report.admin_menu_manage_categories";a:1:{s:3:"url";a:2:{i:0;s:6:"report";i:1;s:8:"category";}}}]]></menu>
		<phrase_var_name>module_report</phrase_var_name>
		<writable />
	</data>
	<blocks>
		<block type_id="0" m_connection="profile.index" module_id="report" component="profile" location="1" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="report" hook_type="service" module="report" call_name="report.service_data_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="report" hook_type="service" module="report" call_name="report.service_report___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="report" hook_type="service" module="report" call_name="report.service_report__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="report" hook_type="controller" module="report" call_name="report.component_controller_admincp_index_clean" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="report" hook_type="controller" module="report" call_name="report.component_controller_admincp_category_clean" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="report" hook_type="controller" module="report" call_name="report.component_controller_admincp_add_clean" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="report" hook_type="controller" module="report" call_name="report.component_controller_index_clean" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="report" hook_type="service" module="report" call_name="report.service_process__call" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="report" hook_type="service" module="report" call_name="report.service_callback__call" added="1242637439" version_id="2.0.0beta2" />
		<hook module_id="report" hook_type="component" module="report" call_name="report.component_block_profile_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="report" hook_type="component" module="report" call_name="report.component_block_browse_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="report" hook_type="service" module="report" call_name="report.service_data_data__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="report" hook_type="component" module="report" call_name="report.component_block_profile_process" added="1358258443" version_id="3.5.0beta1" />
	</hooks>
	<components>
		<component module_id="report" component="ajax" m_connection="" module="report" is_controller="0" is_block="0" is_active="1" />
		<component module_id="report" component="add" m_connection="" module="report" is_controller="0" is_block="1" is_active="1" />
		<component module_id="report" component="profile" m_connection="" module="report" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="report" version_id="2.0.0alpha1" var_name="user_setting_can_report_comments" added="1218790099">Can report on comments?</phrase>
		<phrase module_id="report" version_id="2.0.0alpha1" var_name="report" added="1212758605">Report</phrase>
		<phrase module_id="report" version_id="2.0.0alpha1" var_name="report_a_comment" added="1212758732">Report a Comment</phrase>
		<phrase module_id="report" version_id="2.0.0alpha1" var_name="you_have_already_reported_this_item" added="1219411144">You have already reported this item.</phrase>
		<phrase module_id="report" version_id="2.0.0alpha1" var_name="you_are_about_report_violation_our_terms_use" added="1219411155">You are about to report a violation of our Terms of Use.</phrase>
		<phrase module_id="report" version_id="2.0.0alpha1" var_name="all_reports_are_strictly_confidential" added="1219411169"><![CDATA[<strong>All reports are strictly confidential</strong>.]]></phrase>
		<phrase module_id="report" version_id="2.0.0alpha1" var_name="choose_one" added="1219411180">Choose one...</phrase>
		<phrase module_id="report" version_id="2.0.0beta2" var_name="admin_menu_view_reports" added="1242580237">View Reports</phrase>
		<phrase module_id="report" version_id="2.0.0beta2" var_name="admin_menu_add_category" added="1242635091">Add Category</phrase>
		<phrase module_id="report" version_id="2.0.0beta2" var_name="admin_menu_manage_categories" added="1242635091">Manage Categories</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="category_successfully_updated" added="1255329781">Category successfully updated.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="category_successfully_added" added="1255329789">Category successfully added.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="edit_a_category" added="1255329797">Edit a Category</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="add_a_category" added="1255329806">Add a Category</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="successfully_deleted_categories" added="1255329834">Successfully deleted categories.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="manage_categories" added="1255329842">Manage Categories</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="report_s_successfully_ignored" added="1255329858">Report(s) successfully ignored.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="reports" added="1255329868">Reports</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="provide_a_category_name" added="1255329905">Provide a category name.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="not_a_valid_category_to_edit" added="1255329928">Not a valid category to edit.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="not_a_valid_report" added="1255329942">Not a valid report.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="you_are_about_to_report_a_violation_of_our_a_href_link_target_blank_terms_of_use_a" added="1255330036"><![CDATA[You are about to report a violation of our <a href="{link}" target="_blank">Terms of Use</a>.]]></phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="reason" added="1255330068">Reason</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="user" added="1255330120">User</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="category" added="1255330126">Category</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="date" added="1255330132">Date</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="report_this_user" added="1255330248">Report this User</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="category_details" added="1255330269">Category Details</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="category_name" added="1255330290">Category Name</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="update" added="1255330297">Update</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="add" added="1255330303">Add</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="module" added="1255330314">Module</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="delete_selected" added="1255330327">Delete Selected</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="no_categories" added="1255330333">No Categories.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="total" added="1255330356">Total</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="last_report" added="1255330368">Last Report</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="ignore_selected" added="1255330389">Ignore Selected</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="no_reports" added="1255330395">No reports.</phrase>
		<phrase module_id="report" version_id="2.0.0rc4" var_name="report_this_feed" added="1256657121">Report this feed.</phrase>
		<phrase module_id="report" version_id="2.0.7" var_name="attacks_individual_or_group" added="1288202139">Attacks Individual or Group</phrase>
		<phrase module_id="report" version_id="2.0.8" var_name="feedback" added="1297091784">Feedback</phrase>
		<phrase module_id="report" version_id="3.0.0rc2" var_name="a_comment_optional" added="1321349662">A comment? (optional)</phrase>
		<phrase module_id="report" version_id="3.0.0" var_name="copyright_infringement" added="1322467207">Copyright Infringement</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="report" type="boolean" admin="1" user="1" guest="0" staff="1" module="report" ordering="0">can_report_comments</setting>
	</user_group_settings>
	<tables><![CDATA[a:2:{s:13:"phpfox_report";a:3:{s:7:"COLUMNS";a:4:{s:9:"report_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:7:"message";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"report_id";s:4:"KEYS";a:1:{s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"module_id";}}}s:18:"phpfox_report_data";a:3:{s:7:"COLUMNS";a:7:{s:7:"data_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"report_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"feedback";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:7:"data_id";s:4:"KEYS";a:3:{s:9:"report_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:9:"report_id";i:1;s:7:"item_id";i:2;s:7:"user_id";}}s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}s:11:"report_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:9:"report_id";}}}}]]></tables>
</module>