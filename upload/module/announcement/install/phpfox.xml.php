<module>
	<data>
		<module_id>announcement</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:30:"announcement.admin_menu_manage";a:1:{s:3:"url";a:1:{i:0;s:12:"announcement";}}s:31:"announcement.admin_menu_add_new";a:1:{s:3:"url";a:2:{i:0;s:12:"announcement";i:1;s:3:"add";}}}]]></menu>
		<phrase_var_name>module_announcement</phrase_var_name>
		<writable />
	</data>
	<blocks>
		<block type_id="0" m_connection="core.index-member" module_id="announcement" component="index" location="7" is_active="1" ordering="11" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="announcement" hook_type="controller" module="announcement" call_name="announcement.component_controller_index_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="announcement" hook_type="controller" module="announcement" call_name="announcement.component_controller_admincp_add_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_block_manage_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_block_manage_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_block_manage_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="announcement" hook_type="service" module="announcement" call_name="announcement.service_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="announcement" hook_type="service" module="announcement" call_name="announcement.service_announcement__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="announcement" hook_type="service" module="announcement" call_name="announcement.service_callback__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_ajax_changelanguage__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_ajax_changelanguage__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_ajax_setactive__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_ajax_setactive__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_ajax_hide__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_ajax_hide__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_block_index__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="announcement" hook_type="component" module="announcement" call_name="announcement.component_block_index__end" added="1263387694" version_id="2.0.2" />
	</hooks>
	<components>
		<component module_id="announcement" component="index" m_connection="" module="announcement" is_controller="0" is_block="1" is_active="1" />
		<component module_id="announcement" component="index" m_connection="announcement.index" module="announcement" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="announcement" version_id="2.0.0beta4" var_name="admin_menu_manage" added="1244631261">Manage</phrase>
		<phrase module_id="announcement" version_id="2.0.0beta4" var_name="admin_menu_add_new" added="1244631261">Add New</phrase>
		<phrase module_id="announcement" version_id="2.0.0beta4" var_name="module_announcement" added="1244631261">Announcement</phrase>
		<phrase module_id="announcement" version_id="2.0.0beta5" var_name="user_setting_can_close_announcement" added="1245317655">Are members of this user group allowed to close the announcements block in the dashboard?</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="im_afraid_you_are_not_allowed_to_close_this_announcement" added="1252909877"><![CDATA[I'm afraid you are not allowed to close this announcement.]]></phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="edit_an_announcement" added="1252909905">Edit An Announcement</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="add_an_announcement" added="1252909915">Add An Announcement</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="announcement_successfully_added" added="1252909925">Announcement successfully added.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="announcement_successfully_updated" added="1252909936">Announcement successfully updated.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="announcements" added="1252909961">Announcements</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="announcement_successfully_deleted" added="1252909976">Announcement successfully deleted.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="that_announcement_does_not_exist" added="1252910007">That announcement does not exist.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="subject_cannot_be_empty" added="1252910060">Subject cannot be empty.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="content_cannot_be_empty" added="1252910071">Content cannot be empty.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="announcement_not_found" added="1252910107">Announcement not found.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="announcement_is_already_hidden" added="1252910118">Announcement is already hidden.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="min_age_cannot_be_higher_than_max_age" added="1252910302">Min age cannot be higher than max age.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="max_age_cannot_be_lower_than_the_min_age" added="1252910317">Max age cannot be lower than the Min age.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="read_more" added="1252910412">Read More</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="subject" added="1252910440">Subject</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="active" added="1252910455">Active</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="edit" added="1252910466">Edit</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="delete" added="1252910475">Delete</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="announcement_details" added="1252910524">Announcement Details</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="intro" added="1252910547">Intro</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="the_intro_will_be_displayed_on_the_sites_dashboard_and_link_to_the_full_announcement" added="1252910565"><![CDATA[The intro will be displayed on the sites dashboard and link to the full announcement.
<br />
HTML is enabled.]]></phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="announcement" added="1252910575">Announcement</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="the_announcement_can_be_left_open_if_everything_can_be_added_into_the_intro" added="1252910593"><![CDATA[The announcement can be left open if everything can be added into the intro.
<br />
HTML is enabled.]]></phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="display_options" added="1252910604">Display Options</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="can_be_closed" added="1252910642">Can Be Closed</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="show_in_the_dashboard" added="1252910664">Show in the dashboard</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="show_author" added="1252910678">Show author</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="start_date" added="1252910698">Start Date</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="target_viewers" added="1252910709">Target Viewers</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="user_groups" added="1252910717">User Groups</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="all_user_groups" added="1252910727">All User Groups</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="selected_user_groups" added="1252910735">Selected User Groups</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="location" added="1252910745">Location</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="gender" added="1252910753">Gender</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="age_group_between" added="1252910761">Age Group Between</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="any" added="1252910771">Any</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="no_announcements_have_been_created" added="1252910844">No announcements have been created.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="create_a_new_announcement" added="1252910852">Create a New Announcement</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="that_announcement_cannot_be_found" added="1252910862">That announcement cannot be found.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="no_announcements_have_been_added" added="1252910870">No announcements have been added.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="posted_on_time_stamp_by_user" added="1252911113">Posted on {item_time_stamp} by {user_link}.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="posted_on_time_stamp" added="1252911135">Posted on {item_time_stamp}.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="attachments_title" added="1252926488">Attachments</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="extension" added="1252926511">Extension</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="manage_users" added="1253086432">Manage Users</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc2" var_name="attachment_successfully_deleted" added="1253442081">Attachment successfully deleted.</phrase>
		<phrase module_id="announcement" version_id="2.0.0rc11" var_name="user_setting_can_view_announcements" added="1260286754">Can browse and view announcements?</phrase>
		<phrase module_id="announcement" version_id="2.0.6" var_name="are_you_sure" added="1284995471">Are you sure?</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="announcement" type="boolean" admin="true" user="true" guest="false" staff="true" module="announcement" ordering="0">can_close_announcement</setting>
		<setting is_admin_setting="0" module_id="announcement" type="boolean" admin="1" user="1" guest="1" staff="1" module="announcement" ordering="0">can_view_announcements</setting>
	</user_group_settings>
	<tables><![CDATA[a:2:{s:19:"phpfox_announcement";a:3:{s:7:"COLUMNS";a:17:{s:15:"announcement_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:11:"subject_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"intro_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"content_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"can_be_closed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:17:"show_in_dashboard";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:10:"start_date";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"location";a:4:{i:0;s:6:"TINT:2";i:1;s:1:"6";i:2;s:0:"";i:3;s:2:"NO";}s:11:"country_iso";a:4:{i:0;s:6:"CHAR:2";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"gender";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"age_from";a:4:{i:0;s:6:"TINT:2";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"age_to";a:4:{i:0;s:6:"TINT:2";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"user_group";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"gmt_offset";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:15:"announcement_id";s:4:"KEYS";a:2:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_active";i:1;s:17:"show_in_dashboard";}}s:11:"is_active_2";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:24:"phpfox_announcement_hide";a:2:{s:7:"COLUMNS";a:2:{s:15:"announcement_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:15:"announcement_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:15:"announcement_id";i:1;s:7:"user_id";}}}}}]]></tables>
</module>