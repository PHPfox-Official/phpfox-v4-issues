<module>
	<data>
		<module_id>ban</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_ban</phrase_var_name>
		<writable />
	</data>
	<hooks>
		<hook module_id="ban" hook_type="service" module="ban" call_name="ban.service_word__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="ban" hook_type="service" module="ban" call_name="ban.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="ban" hook_type="service" module="ban" call_name="ban.service_ban__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="ban" hook_type="service" module="ban" call_name="ban.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_admincp_word_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_admincp_ip_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_admincp_display_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_admincp_default_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_admincp_email_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_admincp_username_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_spam_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="ban" hook_type="controller" module="ban" call_name="ban.component_controller_message_clean" added="1258389334" version_id="2.0.0rc8" />
	</hooks>
	<phrases>
		<phrase module_id="ban" version_id="2.0.0alpha1" var_name="module_ban" added="1219151836">Ban</phrase>
		<phrase module_id="ban" version_id="2.0.0rc1" var_name="ban_filters" added="1248093329">Ban Filters</phrase>
		<phrase module_id="ban" version_id="2.0.0rc1" var_name="ban_filter_username" added="1248093367">Usernames</phrase>
		<phrase module_id="ban" version_id="2.0.0rc1" var_name="ban_filter_email" added="1248110298">Emails</phrase>
		<phrase module_id="ban" version_id="2.0.0rc1" var_name="ban_filter_display_name" added="1248113718">Display Names</phrase>
		<phrase module_id="ban" version_id="2.0.0rc1" var_name="ban_filter_ip" added="1248114041">IP Address</phrase>
		<phrase module_id="ban" version_id="2.0.0rc1" var_name="global_ban_message" added="1248114867">You have been banned from the site.</phrase>
		<phrase module_id="ban" version_id="2.0.0rc1" var_name="ban_filter_word" added="1248115029">Words</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="filter_successfully_deleted" added="1252926663">Filter successfully deleted.</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="filter_successfully_added" added="1252926676">Filter successfully added.</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="ban" added="1252926684">Ban</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="display_names" added="1252926710">Display Names</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="display_name" added="1252926721">Display Name</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="emails" added="1252926731">Emails</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="email" added="1252926738">Email</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="ip_addresses" added="1252926751">IP Addresses</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="ip_address" added="1252926760">IP Address</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="usernames" added="1252926770">Usernames</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="username" added="1252926777">Username</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="words" added="1252926787">Words</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="word" added="1252926794">Word</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="filter_value_is_required" added="1252926832">Filter value is required.</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="filter_replacement_is_required" added="1252926846">Filter replacement is required.</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="add_filter" added="1252926887">Add Filter</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="use_the_asterisk_for_wildcard_entries" added="1252926938"><![CDATA[Use the asterisk (&#42;) for wildcard entries.]]></phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="replacement" added="1252926946">Replacement</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="add" added="1252926955">Add</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="added_by" added="1252926974">Added By</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="added_on" added="1252926982">Added On</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="delete" added="1252926996">Delete</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="are_you_sure" added="1252927003">Are you sure?</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="n_a" added="1252927037">N/A</phrase>
		<phrase module_id="ban" version_id="2.0.0rc2" var_name="you_have_been_banned_for_spamming" added="1252927064">You have been banned for spamming.</phrase>
		<phrase module_id="ban" version_id="2.0.5dev1" var_name="recent_blogs" added="1274843692">Recent Blogs</phrase>
		<phrase module_id="ban" version_id="2.0.5dev1" var_name="most_viewed" added="1274843702">Most Viewed</phrase>
		<phrase module_id="ban" version_id="2.0.6" var_name="not_allowed_ip_address" added="1282234070">Your IP address is not allowed</phrase>
		<phrase module_id="ban" version_id="2.0.8" var_name="this_user_has_been_unbanned" added="1297945314">This user has been unbanned</phrase>
		<phrase module_id="ban" version_id="2.0.8" var_name="the_user_a_href_link_user_a_has_been_banned" added="1297945492"><![CDATA[The user <a href="{link}">"{user_name}"</a> has been banned.]]></phrase>
		<phrase module_id="ban" version_id="2.0.8" var_name="you_need_to_choose_a_user_to_ban" added="1297946808">You need to choose a user to ban</phrase>
		<phrase module_id="ban" version_id="2.0.8" var_name="you_are_about_to_ban_the_user" added="1297947001">You are about to ban the user:</phrase>
		<phrase module_id="ban" version_id="2.0.8" var_name="phrase_variable_when_banning_explanation" added="1297947304"><![CDATA[You can enter a language phrase variable, for example: {phrase var='report.attacks_individual_or_group'}, or text directly]]></phrase>
		<phrase module_id="ban" version_id="2.0.8" var_name="ban_for_how_many_days" added="1297947320">Ban for how many days:</phrase>
		<phrase module_id="ban" version_id="2.0.8" var_name="0_means_indefinite" added="1297947350">0 means indefinite</phrase>
		<phrase module_id="ban" version_id="2.0.8" var_name="user_group_to_move_the_user_when_the_ban_expires" added="1297947370">User group to move the user when the ban expires:</phrase>
	</phrases>
	<tables><![CDATA[a:2:{s:10:"phpfox_ban";a:3:{s:7:"COLUMNS";a:10:{s:6:"ban_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"find_value";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"replacement";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"days_banned";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:17:"return_user_group";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"reason";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:20:"user_groups_affected";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"ban_id";s:4:"KEYS";a:1:{s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"type_id";}}}s:15:"phpfox_ban_data";a:3:{s:7:"COLUMNS";a:8:{s:11:"ban_data_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:6:"ban_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:16:"start_time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"end_time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:17:"return_user_group";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"reason";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"is_expired";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"ban_data_id";s:4:"KEYS";a:1:{s:6:"ban_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:6:"ban_id";i:1;s:7:"user_id";i:2;s:14:"end_time_stamp";}}}}}]]></tables>
</module>