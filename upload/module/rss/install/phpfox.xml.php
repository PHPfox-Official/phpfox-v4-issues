<module>
	<data>
		<module_id>rss</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:4:{s:27:"rss.admin_menu_manage_feeds";a:1:{s:3:"url";a:1:{i:0;s:3:"rss";}}s:27:"rss.admin_menu_add_new_feed";a:1:{s:3:"url";a:2:{i:0;s:3:"rss";i:1;s:3:"add";}}s:28:"rss.admin_menu_manage_groups";a:1:{s:3:"url";a:2:{i:0;s:3:"rss";i:1;s:5:"group";}}s:28:"rss.admin_menu_add_new_group";a:1:{s:3:"url";a:3:{i:0;s:3:"rss";i:1;s:5:"group";i:2;s:3:"add";}}}]]></menu>
		<phrase_var_name>module_rss</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="rss" is_hidden="0" type="integer" var_name="total_rss_display" phrase_var_name="setting_total_rss_display" ordering="1" version_id="2.0.0beta5">15</setting>
		<setting group="" module_id="rss" is_hidden="0" type="boolean" var_name="display_rss_count_on_profile" phrase_var_name="setting_display_rss_count_on_profile" ordering="1" version_id="2.0.0beta5">1</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="rss" module_id="rss" component="info" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="rss" hook_type="controller" module="rss" call_name="rss.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="rss" hook_type="service" module="rss" call_name="rss.service_rss__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="rss" hook_type="service" module="rss" call_name="rss.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="rss" hook_type="service" module="rss" call_name="rss.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="rss" hook_type="component" module="rss" call_name="rss.component_block_info_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="component" module="rss" call_name="rss.component_block_log_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="controller" module="rss" call_name="rss.component_controller_admincp_index_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="controller" module="rss" call_name="rss.component_controller_admincp_log_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="controller" module="rss" call_name="rss.component_controller_admincp_group_index_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="controller" module="rss" call_name="rss.component_controller_admincp_group_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="controller" module="rss" call_name="rss.component_controller_admincp_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="controller" module="rss" call_name="rss.component_controller_log_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="controller" module="rss" call_name="rss.component_controller_profile_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="service" module="rss" call_name="rss.service_log_log__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="service" module="rss" call_name="rss.service_group_group__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="rss" hook_type="service" module="rss" call_name="rss.service_group_process__call" added="1258389334" version_id="2.0.0rc8" />
	</hooks>
	<components>
		<component module_id="rss" component="index" m_connection="rss.index" module="rss" is_controller="1" is_block="0" is_active="1" />
		<component module_id="rss" component="info" m_connection="" module="rss" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="rss" version_id="2.0.0alpha1" var_name="module_rss" added="1233130688">Rss Feeds</phrase>
		<phrase module_id="rss" version_id="2.0.0beta5" var_name="admin_menu_manage_feeds" added="1245508823">Manage Feeds</phrase>
		<phrase module_id="rss" version_id="2.0.0beta5" var_name="admin_menu_add_new_feed" added="1245508823">Add New Feed</phrase>
		<phrase module_id="rss" version_id="2.0.0beta5" var_name="admin_menu_manage_groups" added="1245513778">Manage Groups</phrase>
		<phrase module_id="rss" version_id="2.0.0beta5" var_name="admin_menu_add_new_group" added="1245513778">Add New Group</phrase>
		<phrase module_id="rss" version_id="2.0.0beta5" var_name="setting_total_rss_display" added="1245534638"><![CDATA[<title>Total Items</title><info>Define how many items can be displayed within a RSS feed.</info>]]></phrase>
		<phrase module_id="rss" version_id="2.0.0beta5" var_name="setting_display_rss_count_on_profile" added="1245591302"><![CDATA[<title>RSS Subscriber Count on Profile</title><info>Set to <b>True</b> to display the RSS subscriber count on a users profile.

<b>Notice:</b> If enabled the user will have the ability to disable this via their privacy settings.</info>]]></phrase>
		<phrase module_id="rss" version_id="2.0.0rc2" var_name="rss_subscribers" added="1253083444">RSS Subscribers</phrase>
		<phrase module_id="rss" version_id="2.0.0rc2" var_name="rss_subscribers_log" added="1253083456">RSS Subscribers Log</phrase>
		<phrase module_id="rss" version_id="2.0.0rc3" var_name="subscribe_to_my_feed" added="1254466507">Subscribe to my feed.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="subscribers" added="1255330863">Subscribers</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="other" added="1255330878">Other</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="group_successfully_updated" added="1255330910">Group successfully updated.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="group_successfully_added" added="1255330918">Group successfully added.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="add_new_group" added="1255330926">Add New Group</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="manage_groups" added="1255330935">Manage Groups</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="group_successfully_deleted" added="1255330945">Group successfully deleted.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="feed_successfully_updated" added="1255330969">Feed successfully updated.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="feed_successfully_added" added="1255330977">Feed successfully added.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="editing_feed" added="1255331032">Editing Feed</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="add_new_feed" added="1255331093">Add New Feed</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="manage_feeds" added="1255331206">Manage Feeds</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="feed_successfully_deleted" added="1255331223">Feed successfully deleted.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="unable_to_find_rss_log" added="1255331249">Unable to find RSS log.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="viewing_rss_feed_log" added="1255331261">Viewing RSS Feed Log</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="rss_feed_log" added="1255331280">RSS Feed Log</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="rss_feeds" added="1255331339">RSS Feeds</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="rss_logs" added="1255331387">RSS Logs</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="log" added="1255331407">Log</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="user_has_disabled_rss_feeds" added="1255331450">User has disabled RSS feeds.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="unable_to_find_the_group_you_are_planning_to_edit" added="1255331854">Unable to find the group you are planning to edit.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="select_a_product" added="1255331873">Select a product.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="select_a_module" added="1255331895">Select a module.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="at_least_one_name_for_the_group_is_required" added="1255331910">At least one name for the group is required.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="select_if_the_group_is_active_or_not" added="1255331919">Select if the group is active or not.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="not_a_valid_request" added="1255331946">Not a valid request.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="the_group_you_are_looking_for_cannot_be_found" added="1255331961">The group you are looking for cannot be found.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="unable_to_find_the_feed_you_are_looking_for" added="1255331975">Unable to find the feed you are looking for.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="display_rss_count" added="1255331994">Display RSS Count</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="rss_subscribtion" added="1255332001">RSS Subscribtion</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="select_a_group_for_this_feed" added="1255333371">Select a group for this feed.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="at_least_one_title_for_the_feed_is_required" added="1255333379">At least one title for the feed is required.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="at_least_one_description_for_the_feed_is_required" added="1255333387">At least one description for the feed is required.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="provide_a_link_for_the_feed" added="1255333396">Provide a link for the feed.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="provide_proper_php_code" added="1255333407">Provide proper PHP code.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="php_code_for_the_feed_is_required" added="1255333421">PHP code for the feed is required.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="select_if_the_feed_can_be_seen_site_wide" added="1255333897">Select if the feed can be seen site wide.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="select_if_the_feed_is_active_or_not" added="1255333911">Select if the feed is active or not.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="the_feed_you_are_looking_for_cannot_be_found" added="1255333928">The feed you are looking for cannot be found.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="unable_to_find_the_feed_you_are_planning_to_edit" added="1255333957">Unable to find the feed you are planning to edit.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="latest_updates_from_full_name" added="1255333977">Latest updates from {full_name}</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="unable_to_find_rss_feed" added="1255333997">Unable to find RSS feed.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="not_a_valid_rss_feed_php_code_failed" added="1255334006">Not a valid RSS feed (PHP code failed).</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="rss_feed_url" added="1255334039">RSS Feed URL</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="feed_readers_aggregators_and_web_browsers" added="1255334052">Feed Readers, Aggregators and Web Browsers</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="reader" added="1255334059">Reader</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="ip_address" added="1255334092">IP Address</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="date" added="1255334104">Date</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="no_subscribers_found" added="1255334163">No subscribers found.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="group_details" added="1255334178">Group Details</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="name" added="1255334185">Name</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="is_active" added="1255334194">Is Active</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="yes" added="1255334200">Yes</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="no" added="1255334205">No</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="submit" added="1255334212">Submit</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="groups" added="1255334235">Groups</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="title" added="1255334241">Title</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="active" added="1255334247">Active</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="edit_group" added="1255334257">Edit Group</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="delete_group" added="1255334263">Delete Group</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="are_you_sure" added="1255334269">Are you sure?</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="deactivate" added="1255334278">Deactivate</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="activate" added="1255334284">Activate</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="feed_details" added="1255334332">Feed Details</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="group" added="1255334338">Group</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="select" added="1255334346">Select</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="description" added="1255334359">Description</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="link" added="1255334365">Link</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="php_group_code" added="1255334373">PHP Group Code</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="php_view_code" added="1255334383">PHP View Code</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="site_wide" added="1255334390">Site Wide</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="feeds" added="1255334425">Feeds</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="edit_feed" added="1255334461">Edit Feed</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="delete_feed" added="1255334468">Delete Feed</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="disable" added="1255334483">Disable</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="enable" added="1255334488">Enable</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="no_rss_feeds_are_available" added="1255334514">No RSS feeds are available.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="results_for" added="1255334544">Results for</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="search_results" added="1255334594">Search Results</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="search" added="1255334601">Search</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="showing_1_result" added="1255334626">Showing 1 result.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="showing_total_results" added="1255334634">Showing {total} results.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="showing_count_results_out_of_over_result" added="1255334656">Showing {count} results out of over {result}.</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="all_results_total" added="1255334685">All Results ({total})</phrase>
		<phrase module_id="rss" version_id="2.0.0rc4" var_name="no_search_results_found" added="1255334708">No search results found.</phrase>
		<phrase module_id="rss" version_id="3.0.0" var_name="subscribe_via_rss" added="1323692157">Subscribe via RSS</phrase>
	</phrases>
	<tables><![CDATA[a:4:{s:10:"phpfox_rss";a:3:{s:7:"COLUMNS";a:13:{s:7:"feed_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"group_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"title_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"description_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"feed_link";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"php_group_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"php_view_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"is_site_wide";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"total_subscribed";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"feed_id";s:4:"KEYS";a:3:{s:8:"group_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"group_id";i:1;s:9:"is_active";}}s:7:"feed_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"feed_id";i:1;s:9:"is_active";}}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_active";i:1;s:12:"is_site_wide";}}}}s:16:"phpfox_rss_group";a:3:{s:7:"COLUMNS";a:6:{s:8:"group_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"name_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"group_id";s:4:"KEYS";a:1:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:14:"phpfox_rss_log";a:3:{s:7:"COLUMNS";a:6:{s:6:"log_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"feed_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"id_hash";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"user_agent";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"log_id";s:4:"KEYS";a:1:{s:7:"feed_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"feed_id";i:1;s:7:"id_hash";}}}}s:19:"phpfox_rss_log_user";a:3:{s:7:"COLUMNS";a:6:{s:6:"log_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"id_hash";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"user_agent";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"log_id";s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"id_hash";}}}}}]]></tables>
</module>