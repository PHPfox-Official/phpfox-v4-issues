<module>
	<data>
		<module_id>friend</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name />
		<writable />
	</data>
	<menus>
		<menu module_id="friend" parent_var_name="" m_connection="main" var_name="menu_core_friends" ordering="3" url_value="friend" version_id="2.0.0alpha1" disallow_access="" module="friend" />
		<menu module_id="friend" parent_var_name="" m_connection="profile" var_name="menu_friend_friends" ordering="16" url_value="profile.friend" version_id="2.0.0alpha1" disallow_access="" module="friend" />
		<menu module_id="friend" parent_var_name="" m_connection="mobile" var_name="menu_friend_friends_532c28d5412dd75bf975fb951c740a30" ordering="118" url_value="friend" version_id="3.1.0rc1" disallow_access="" module="friend" mobile_icon="small_friends.png" />
	</menus>
	<settings>
		<setting group="" module_id="friend" is_hidden="0" type="integer" var_name="total_requests_display" phrase_var_name="setting_total_requests_display" ordering="1" version_id="2.0.0alpha1">10</setting>
		<setting group="" module_id="friend" is_hidden="0" type="integer" var_name="friend_display_limit" phrase_var_name="setting_friend_display_limit" ordering="1" version_id="2.0.0beta3">6</setting>
		<setting group="" module_id="friend" is_hidden="0" type="array" var_name="friend_user_feed_display_limit" phrase_var_name="setting_friend_user_feed_display_limit" ordering="1" version_id="2.0.0beta3"><![CDATA[s:25:"array(6, 12, 18, 24, 30);";]]></setting>
		<setting group="" module_id="friend" is_hidden="0" type="boolean" var_name="enable_birthday_notices" phrase_var_name="setting_enable_birthday_notices" ordering="1" version_id="2.0.0beta4">1</setting>
		<setting group="" module_id="friend" is_hidden="0" type="integer" var_name="days_to_check_for_birthday" phrase_var_name="setting_days_to_check_for_birthday" ordering="1" version_id="2.0.0beta4">7</setting>
		<setting group="cache" module_id="friend" is_hidden="0" type="integer" var_name="birthdays_cache_time_out" phrase_var_name="setting_birthdays_cache_time_out" ordering="1" version_id="2.0.0beta4">5</setting>
		<setting group="" module_id="friend" is_hidden="0" type="boolean" var_name="show_empty_birthdays" phrase_var_name="setting_show_empty_birthdays" ordering="1" version_id="2.0.0beta4">0</setting>
		<setting group="search_engine_optimization" module_id="friend" is_hidden="0" type="large_string" var_name="friend_meta_keywords" phrase_var_name="setting_friend_meta_keywords" ordering="7" version_id="2.0.0rc1">friends, buddies</setting>
		<setting group="" module_id="friend" is_hidden="0" type="integer" var_name="friend_suggestion_search_total" phrase_var_name="setting_friend_suggestion_search_total" ordering="1" version_id="2.0.0rc12">50</setting>
		<setting group="" module_id="friend" is_hidden="0" type="boolean" var_name="enable_friend_suggestion" phrase_var_name="setting_enable_friend_suggestion" ordering="1" version_id="2.0.0rc12">0</setting>
		<setting group="" module_id="friend" is_hidden="0" type="integer" var_name="friend_suggestion_timeout" phrase_var_name="setting_friend_suggestion_timeout" ordering="1" version_id="2.0.0rc12">1440</setting>
		<setting group="" module_id="friend" is_hidden="0" type="boolean" var_name="friend_suggestion_user_based" phrase_var_name="setting_friend_suggestion_user_based" ordering="1" version_id="2.0.0rc12">0</setting>
		<setting group="" module_id="friend" is_hidden="0" type="boolean" var_name="hide_denied_requests_from_pending_list" phrase_var_name="setting_hide_denied_requests_from_pending_list" ordering="1" version_id="2.0.7">0</setting>
		<setting group="" module_id="friend" is_hidden="0" type="integer" var_name="friend_cache_limit" phrase_var_name="setting_friend_cache_limit" ordering="1" version_id="3.0.0Beta1">100</setting>
		<setting group="" module_id="friend" is_hidden="0" type="boolean" var_name="allow_blocked_user_to_friend_request" phrase_var_name="setting_allow_blocked_user_to_friend_request" ordering="1" version_id="2.1.0beta1">1</setting>
		<setting group="" module_id="friend" is_hidden="0" type="boolean" var_name="friends_only_profile" phrase_var_name="setting_friends_only_profile" ordering="1" version_id="3.0.1">0</setting>
		<setting group="cache" module_id="friend" is_hidden="0" type="integer" var_name="cache_mutual_friends" phrase_var_name="setting_cache_mutual_friends" ordering="2" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="friend" is_hidden="0" type="integer" var_name="cache_rand_list_of_friends" phrase_var_name="setting_cache_rand_list_of_friends" ordering="3" version_id="3.6.0rc1">60</setting>
		<setting group="cache" module_id="friend" is_hidden="0" type="boolean" var_name="cache_is_friend" phrase_var_name="setting_cache_is_friend" ordering="4" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="friend" is_hidden="0" type="boolean" var_name="cache_friend_list" phrase_var_name="setting_cache_friend_list" ordering="5" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="friend" is_hidden="0" type="boolean" var_name="load_friends_online_ajax" phrase_var_name="setting_load_friends_online_ajax" ordering="6" version_id="3.6.0rc1">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="core.index-member" module_id="friend" component="mini" location="1" is_active="1" ordering="2" disallow_access="" can_move="1">
			<title><![CDATA[{phrase var=&#039;friend.friends_online&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.index" module_id="friend" component="profile.small" location="1" is_active="1" ordering="2" disallow_access="" can_move="1">
			<title><![CDATA[{phrase var=&#039;friend.friends&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="core.index-member" module_id="friend" component="birthday" location="3" is_active="1" ordering="5" disallow_access="" can_move="1">
			<title><![CDATA[{phrase var=&#039;event.upcoming_events&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.index" module_id="friend" component="mutual-friend" location="3" is_active="1" ordering="5" disallow_access="" can_move="1">
			<title><![CDATA[{phrase var=&#039;friend.mutual_friends&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="core.index-member" module_id="friend" component="suggestion" location="3" is_active="1" ordering="6" disallow_access="" can_move="1">
			<title><![CDATA[{phrase var=&#039;friend.suggestions&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="friend" component="mutual-friend" location="3" is_active="1" ordering="9" disallow_access="" can_move="1">
			<title>Mutual Friends</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.index" module_id="friend" component="birthday" location="3" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title>Birthdays</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.index" module_id="friend" component="remove" location="1" is_active="1" ordering="8" disallow_access="" can_move="0">
			<title>Remove Friend</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_menu_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_accept_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_request_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_top_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_list_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_list_edit_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="controller" module="friend" call_name="friend.component_controller_profile_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="controller" module="friend" call_name="friend.component_controller_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_callback___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_request_request_get" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_request_request__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_request_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_friend___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_list_list__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_list_process_update" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_list_process_delete" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_list_process_move" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_list_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_profile_small_clean" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="friend" hook_type="controller" module="friend" call_name="friend.component_controller_pending_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="friend" hook_type="controller" module="friend" call_name="friend.component_controller_request_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_search_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_suggestion_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_search_process" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_setting_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_mutual_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_mutual_friend_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="friend" hook_type="controller" module="friend" call_name="friend.component_controller_accept_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_suggestion__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_block__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_suggestion__build_search" added="1261572640" version_id="2.0.0" />
		<hook module_id="friend" hook_type="controller" module="friend" call_name="friend.component_controller_suggestion_clean" added="1261572640" version_id="2.0.0" />
		<hook module_id="friend" hook_type="controller" module="friend" call_name="friend.component_controller_index_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_process__updatefriendcount" added="1276177474" version_id="2.0.5" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_callback__updatecounter" added="1276177474" version_id="2.0.5" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_friend_get" added="1276177474" version_id="2.0.5" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_friend_getmutualfriends" added="1276177474" version_id="2.0.5" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="friend" hook_type="template" module="friend" call_name="friend.template_block_congratulate_form" added="1299062480" version_id="2.0.8" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_birthday_profile_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_list_add_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_mutual_browse_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_notify_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_api__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_process_add__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_process_delete__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_getfromcachequery" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_search_get" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="friend" hook_type="component" module="friend" call_name="friend.component_block_mini_process" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_request_get__2" added="1361180401" version_id="3.5.0rc1" />
		<hook module_id="friend" hook_type="service" module="friend" call_name="friend.service_request_get__3" added="1361180401" version_id="3.5.0rc1" />
		<hook module_id="friend" hook_type="template" module="friend" call_name="friend.template_block_accept__1" added="1361180401" version_id="3.5.0rc1" />
	</hooks>
	<components>
		<component module_id="friend" component="mini" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="index" m_connection="friend.index" module="friend" is_controller="1" is_block="0" is_active="1" />
		<component module_id="friend" component="list" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="top" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="ajax" m_connection="" module="friend" is_controller="0" is_block="0" is_active="1" />
		<component module_id="friend" component="profile.small" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="accept" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="request" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="list.edit" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="profile" m_connection="friend.profile" module="friend" is_controller="1" is_block="0" is_active="1" />
		<component module_id="friend" component="menu" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="pending" m_connection="friend.pending" module="friend" is_controller="1" is_block="0" is_active="1" />
		<component module_id="friend" component="birthday" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="mutual-friend" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="suggestion" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="birthday-profile" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
		<component module_id="friend" component="remove" m_connection="" module="friend" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="menu_core_friends" added="1220960932">Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="menu_top_friends" added="1221135325">Top Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="menu_online_friends" added="1221135362">Online Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="create_new_list" added="1221136804">Create New List...</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="edit_lists" added="1221139189">Edit Lists</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="view_list" added="1221139400">View List</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="user_setting_can_add_friends" added="1230339115">Can add friends?</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="user_setting_can_add_folders" added="1230340611">Can add custom folders?</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="setting_total_requests_display" added="1230390855"><![CDATA[<title>Friend Requests Display Total</title><info>How many friend requests should be displayed when a user accepts requests?</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="menu_all_friends" added="1231408249">All Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0alpha1" var_name="menu_pending_requests" added="1233128504">Pending Requests</phrase>
		<phrase module_id="friend" version_id="2.0.0beta2" var_name="menu_friend_friends" added="1242569898">Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0beta3" var_name="setting_friend_display_limit" added="1243631119"><![CDATA[<title>Friends Display Limit</title><info>Define how many friends should be displayed on a users profile and dashboard.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0beta3" var_name="setting_friend_user_feed_display_limit" added="1243631308"><![CDATA[<title>Total Friends Display (User Selection)</title><info>Define how many friends a user can select to be displayed on their dashboard or profile.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0beta3" var_name="user_setting_can_remove_friends_from_profile" added="1243631421">Can remove friends block from their profile?</phrase>
		<phrase module_id="friend" version_id="2.0.0beta3" var_name="user_setting_can_remove_friends_from_dashboard" added="1243631461">Can remove their friends block from their dashboard?</phrase>
		<phrase module_id="friend" version_id="2.0.0beta4" var_name="setting_enable_birthday_notices" added="1244723490"><![CDATA[<title>Enable Birthday Notices</title><info>When enabled users will see a list of their friends upcoming birthdays.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0beta4" var_name="setting_days_to_check_for_birthday" added="1244723907"><![CDATA[<title>How many days in advance to check for birthdays</title><info>This setting tells how many days in advance should the script check for.

Setting it to a number too high may beat the purpose of the feature.

The results from this feature cannot be cached, so it is prone to becoming a slow down for your site.

Keep in mind that you can disable this feature altogether in the setting friend.enable_birthday_notices</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0beta4" var_name="setting_birthdays_cache_time_out" added="1245154442"><![CDATA[<title>Birthdays Cache Time Out</title><info>Showing your friend's birthdays in the dashboard has a cost in database calls, therefore we cache it to save time and avoid extra calls.

This setting tells how often should the cache be refreshed, its set in hours so if you set it to 5 it means that every 5 hours the list of friends whose birthday is coming soon will be refreshed. This is helpful for new sign ups whose birthday is within 1 day.

This setting complements days_to_check_for_birthday and is useless if enable_birthday_notices is disabled.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0beta4" var_name="setting_show_empty_birthdays" added="1245159765"><![CDATA[<title>Show Empty Birthdays</title><info>When enabled the site will show the block in the dashboard regardless if the user has friends whose birthday is coming or not. 

Disabling it does not mean a performance optimization since the contents are already cached.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0beta4" var_name="menu_birthday_e_cards" added="1245162577">Birthday E-Cards</phrase>
		<phrase module_id="friend" version_id="2.0.0rc1" var_name="setting_friend_meta_keywords" added="1252061571"><![CDATA[<title>Friends Meta Keywords</title><info>Meta keywords used when in relation to the Friend module.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="your_message_has_been_sent" added="1254550634">Your message has been sent.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friend_request_successfully_sent" added="1254550663">Friend request successfully sent.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="you_have_reached_your_limit" added="1254550681">You have reached your limit.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="done" added="1254550703">Done!</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="top_friends" added="1254550718">Top Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="remove_from_your_top_friends_list" added="1254550733">Remove from your Top Friends List</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="add_to_your_top_friends_list" added="1254550749">Add to your Top Friends List</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friends_successfully_moved" added="1254550769">Friends successfully moved.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friend_successfully_removed" added="1254550786">Friend successfully removed.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friend_lists" added="1254550824">Friend Lists</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="view_all" added="1254550842">View All</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friends" added="1254550849">Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="birthdays" added="1254550868">Birthdays</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="my_friends" added="1254550887">My Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="change_my_top_friends" added="1254550899"><![CDATA[Change my "Top Friends"]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="search_friends" added="1254550982">Search Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="invalid_friend_list" added="1254550997">Invalid friend list.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="successfully_deleted" added="1254551010">Successfully deleted.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="birthday_e_cards" added="1254551129">Birthday E-Cards</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friends_request_successfully_deleted" added="1254551143">Friends request successfully deleted.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="pending_friend_requests" added="1254551152">Pending Friend Requests</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="user_link_has_closed_their_friends_section" added="1254551184">{user_link} has closed their friends section.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_s_friends" added="1254551220"><![CDATA[{full_name}'s friends]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_is_on_site_title_and_has_total_friends" added="1254551268">{full_name} is on {site_title} and has {total} friends.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_is_connected_with_friends" added="1254551367">{full_name} is connected with {friends}.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="sign_up_on_site_title_and_connect_with_full_name_message_full_name_or_add_full_name_as_you" added="1254551424">Sign up on {site_title} and connect with {full_name}, message {full_name}, or add {full_name} as your friend.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="not_a_valid_user_to_be_friends_with" added="1254551557">Not a valid user to be friends with.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="you_are_already_friends_with_this_user" added="1254551569">You are already friends with this user.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friends_request" added="1254551577">Friends Request</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_added_you_as_a_friend_on_site_title" added="1254551799">{full_name} added you as a friend on {site_title}.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_added_you_as_a_friend_on_site_title_to_confirm_this_friend_request" added="1254551886"><![CDATA[{full_name} added you as a friend on {site_title}.

To confirm this friend request, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="no_friends_requests" added="1254552073">No friends requests.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friend_requests_total" added="1254552168"><![CDATA[Friend Requests (<span id="js_request_friend_count_total">{total}</span>)]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="viewer_image_you_and_owner_image_a_href_user_link_full_name_a_are_now_friends" added="1254552868"><![CDATA[{viewer_image}You and {owner_image}<a href="{user_link}">{full_name}</a> are now friends.]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="owner_image_you_and_viewer_image_a_href_friend_link_friend_a_are_now_friends" added="1254553038"><![CDATA[{owner_image}You and {viewer_image}<a href="{friend_link}">{friend}</a> are now friends.]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="owner_image_a_href_user_link_full_name_a_and_viewer_image" added="1254553166"><![CDATA[{owner_image}<a href="{user_link}">{full_name}</a> and {viewer_image}<a href="{friend_link}">{friend}</a> are now friends.]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="owner_image_a_href_user_link_full_name_a_and_viewer_image_friends" added="1254553354"><![CDATA[{owner_image}<a href="{user_link}">{full_name}</a> and {viewer_image}<a href="{friend_link}">{friend}</a> are now friends.]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="new_friend" added="1254553816">New Friend</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friend_request" added="1254553828">Friend Request</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="user_link_wished_you_a_happy_birthday" added="1254553960">{user_link} wished you a happy birthday.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="view_friends" added="1254554017">View Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="user_link_asked_to_be_your_friend" added="1254554055">{user_link} asked to be your friend.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_confirmed_you_as_a_friend_on_site_title" added="1254554280">{full_name} confirmed you as a friend on {site_title}.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_confirmed_you_as_a_friend_on_site_title_to_view_their_profile" added="1254554372"><![CDATA[{full_name} confirmed you as a friend on {site_title}.

To view their profile, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_wishes_you_a_happy_birthday_on_site_title" added="1254554565">{full_name} wishes you a happy birthday on {site_title}.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_wrote_to_congratulate_you_on_your_birthday_on_site_title" added="1254554691"><![CDATA[{full_name} wrote to congratulate you on your birthday on {site_title}.

To view this message, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="adding_new_list" added="1254555159">Adding New List</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="updating" added="1254555393">Updating</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="delete" added="1254555443">Delete</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="update" added="1254555489">Update</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="cancel" added="1254555500">Cancel</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="add" added="1254555571">Add</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="total_friend" added="1254555603">{total} friend</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="total_friends" added="1254555625">{total} friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friend_requests" added="1254555646">Friend Requests</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="you_are_now_friends_with_user_link" added="1254555668">You are now friends with {user_link}.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="add_to_a_friend_list" added="1254555697">Add to a friend list...</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="lists" added="1254555705">Lists...</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="create_a_new_list" added="1254555714">Create a New List...</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="create" added="1254555726">Create</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="show_all_lists" added="1254555738">Show all lists...</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="user_link_wrote" added="1254555754">{user_link} wrote</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="accept" added="1254555772">Accept</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="deny" added="1254555781">Deny</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="no_birthdays_coming_up" added="1254555795">No birthdays coming up.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="birthday_e_card" added="1254555804">Birthday E-Card</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="send_a_birthday_e_card_to_full_name" added="1254555861">Send a Birthday E-Card to {full_name}.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="send_full_name_a_message" added="1254555898">Send {full_name} a message.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="1_day" added="1254555928">1 Day</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="today" added="1254555938">Today!</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="days_left_days" added="1254555973">{days_left} days</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="message_optional" added="1254556056">Message (Optional)</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="send_e_card" added="1254556071">Send E-Card</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="view_friends_online" added="1254556091">View Friends Online</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="edit_top_friends" added="1254556100">Edit Top Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="find_friends_by_name_or_email" added="1254556120">Find friends by name or email.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="you_have_not_added_any_friends_yet" added="1254556181">You have not added any friends yet.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="search_for_friends" added="1254556193">Search For Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="browse_members" added="1254556202">Browse Members</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="you_have_already_asked_full_name_to_be_your_friend" added="1254556237">You have already asked {full_name} to be your friend.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="full_name_has_already_asked_to_be_your_friend" added="1254556259">{full_name} has already asked to be your friend.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="would_you_like_to_accept_their_request_to_be_friends" added="1254556278">Would you like to accept their request to be friends?</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="yes" added="1254556286">Yes</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="no" added="1254556293">No</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="cannot_add_yourself_as_a_friend" added="1254556307">Cannot add yourself as a friend.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="you_are_already_friends_with_full_name" added="1254556331">You are already friends with {full_name}.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="user_link_will_have_to_confirm_that_you_are_friends" added="1254556356">{user_link} will have to confirm that you are friends.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="add_a_personal_message" added="1254556374">Add a personal message...</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="add_a_personal_message_form" added="1254556394">Add a personal message</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="write_your_message_within_250_characters" added="1254556417">Write your message within 250 characters.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="add_friend" added="1254556495">Add Friend</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="search_by_email_full_name_or_user_name" added="1254556510">Search by email, full name or user name.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="view" added="1254556536">View</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="all_friends" added="1254556543">All Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="online_friends" added="1254556558">Online Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="friends_list" added="1254556572">Friends List</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="find" added="1254557017">Find</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="sorry_no_friends_were_found" added="1254557169">Sorry, no friends were found.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="use_selected" added="1254557181">Use Selected</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="save" added="1254557202">Save</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="use_this_image_to_add_friends_to_your_top_friends_list" added="1254557295"><![CDATA[Use this image to add friends to your "Top Friends" list]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="select" added="1254557351">Select</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="none" added="1254557390">None</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="all" added="1254557396">All</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="move_to_list" added="1254557409">Move to List...</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="message" added="1254557436">Message</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="age" added="1254557449">Age</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="gender" added="1254557455">Gender</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="location" added="1254557461">Location</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="remove_from_top" added="1254557493">Remove from Top</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="add_to_top" added="1254557503">Add to Top</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="toggle" added="1254557513">Toggle</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="no_friends" added="1254557568">No friends.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="no_birthday_messages_found" added="1254557746">No birthday messages found.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="remove_this_friends_request" added="1254557759">Remove this friends request.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="user_link_has_not_added_any_friends" added="1254557823">{user_link} has not added any friends.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="browse_other_members" added="1254557841">Browse Other Members</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="in_order_to_view_this_item_posted_by_user_link_you_need_to_be_on_their_friends_list" added="1254557859">In order to view this item posted by {user_link} you need to be on their friends list.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="send_a_friends_request_to_full_name" added="1254557950">Send a Friends Request to {full_name}</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="thank_you_for_your_request_to_join_our_group_your_membership_will_first_have_to_be_approved" added="1254558818">Thank you for your request to join our group. Your membership will first have to be approved.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="successfully_deleted_the_group" added="1254558846">Successfully deleted the group.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc3" var_name="group_invitation_successfully_sent" added="1254558860">Group invitation successfully sent!</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="top" added="1255716748">Top</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="online" added="1255716757">Online</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="there_are_no_pending_friends_requests" added="1255716866">There are no pending friends requests.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="mutual_friends" added="1256236952">Mutual Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="1_friend_in_common" added="1256237194">1 friend in common</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="total_friends_in_common" added="1256237212">{total} friends in common</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="friends_online" added="1256239756">Friends Online</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="suggestions" added="1256241942">Suggestions</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="add_to_friends" added="1256252043">Add to Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="friend_suggestions" added="1256304055">Friend Suggestions</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="mutual_friends_will_be_listed_here" added="1256308926">Mutual friends will be listed here.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="videos" added="1256373148">Videos</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="that_s_you" added="1256630526"><![CDATA[That's You!]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="the_following_users_are_already_a_member_of_our_community" added="1256630550">The following users are already a member of our community</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="requests" added="1256648176">Requests</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="you_do_not_have_any_friends_requests_at_the_moment" added="1256650329">You do not have any friends requests at the moment.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="menu_friends_requests" added="1256650846">Friends Requests</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="view_friend_request_id" added="1256664976">View Friend Request: #{id}</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="viewing_friends_request_id" added="1256664985">Viewing Friends Request: #{id}</phrase>
		<phrase module_id="friend" version_id="2.0.0rc4" var_name="you_have_denied_user_link_s_friends_request" added="1256665043"><![CDATA[You have denied {user_link}'s friends request.]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc6" var_name="search_for_members" added="1257171904">Search for Members</phrase>
		<phrase module_id="friend" version_id="2.0.0rc6" var_name="search_for_your_friends" added="1257171912">Search for Your Friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc8" var_name="total_friends_block" added="1258846987">Total friends</phrase>
		<phrase module_id="friend" version_id="2.0.0rc8" var_name="we_can_t_create_an_empty_list" added="1258848740"><![CDATA[We can't create an empty list.]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc8" var_name="provide_a_name_for_your_list" added="1258848794">Provide a name for your list.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc11" var_name="accepting_friends_request" added="1260307069">Accepting friends request</phrase>
		<phrase module_id="friend" version_id="2.0.0rc11" var_name="no_friends_online" added="1260309498">No friends online.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc11" var_name="select_all" added="1260323970">Select All</phrase>
		<phrase module_id="friend" version_id="2.0.0rc11" var_name="unselect_all" added="1260323981">Unselect All</phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="setting_friend_suggestion_search_total" added="1260554251"><![CDATA[<title>Friends Suggestion Friends Check Count</title><info>When performing the search to find friend suggestions for your members it will pull out X amount of users, where X is the numerical value of how many friends to search.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="setting_enable_friend_suggestion" added="1260554523"><![CDATA[<title>Friend Suggestions</title><info>Enable this if you want to suggest friends to your members when they visit their dashboard.

You can control the search criteria on what defines a friend to suggest.

This feature requires a lot of extra server resources in order to perform such a search. 

Each search result is cached for X minutes (where you can control X).

<b>Notice:</b> This feature is experimental and is not stable.
</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="setting_friend_suggestion_timeout" added="1260554689"><![CDATA[<title>Refresh Friend Suggestions</title><info>Define how long to wait till we run the search to find friends to suggest to a member in minutes.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="setting_friend_suggestion_user_based" added="1260729076"><![CDATA[<title>Check Location for Friend Suggestions</title><info>Enable this option in order for us to pick up friend suggestions for your members based on the Country, State/Province and City they live in.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="we_are_unable_to_find_any_friends_to_suggest_at_this_time_once_we_do_you_will_be_notified_within_our_dashboard" added="1260879935">We are unable to find any friends to suggest at this time. Once we do you will be notified within our Dashboard.</phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="finding_another_suggestion" added="1260879983">Finding another suggestion...</phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="hide_this_suggestion" added="1260880006">Hide this suggestion</phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="friend" added="1260880732">Friend</phrase>
		<phrase module_id="friend" version_id="2.0.0rc12" var_name="hide" added="1260893725">Hide</phrase>
		<phrase module_id="friend" version_id="2.0.0" var_name="unselect" added="1261233215">Unselect</phrase>
		<phrase module_id="friend" version_id="2.0.4" var_name="optional" added="1266425024">(optional)</phrase>
		<phrase module_id="friend" version_id="2.0.4" var_name="user_setting_total_folders" added="1267026937"><![CDATA[Allowed Total Friend Folders (Enter without quotes "0" for no limit.)]]></phrase>
		<phrase module_id="friend" version_id="2.0.4" var_name="no_search_results_found" added="1267547707">No search results found.</phrase>
		<phrase module_id="friend" version_id="2.0.4" var_name="no_friends_found" added="1267547714">No friends found.</phrase>
		<phrase module_id="friend" version_id="2.0.4" var_name="search" added="1267547722">Search</phrase>
		<phrase module_id="friend" version_id="2.0.7" var_name="loading" added="1288350596">Loading...</phrase>
		<phrase module_id="friend" version_id="2.0.7" var_name="setting_hide_denied_requests_from_pending_list" added="1288624002"><![CDATA[<title>Hide denied requests from pending list</title><info>If enabled, friend requests that were denied will be hidden from the Pending Friend Requests list.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.7" var_name="cannot_select_this_user" added="1289315360">(Based on privacy settings this user cannot be selected)</phrase>
		<phrase module_id="friend" version_id="3.0.0Beta1" var_name="setting_friend_cache_limit" added="1295603213"><![CDATA[<title>Friends Cache Limit</title><info>Certain features on the site pick up on the users friends list especially when running a search for a friend. In order to provide a "live" feel to search results we cache in advance X (where X is this settings value) number of friends in memory. Making it easier for users to find their friends instantly.</info>]]></phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="menu_friend_sent_ecards_a441eadc1389cdf0ffe6c4f8babdd66e" added="1299597849">Sent ECards</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="invoices" added="1299598610">Invoices</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="id" added="1299598669">Id</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="status" added="1299598699">Status</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="price" added="1299598718">Price</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="date" added="1299598743">Date</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="sent_to" added="1299598759">Sent To</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="you_do_not_have_any_invoices" added="1299598815">You do not have any invoices</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="sent_from" added="1299667618">From</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="created" added="1299667836">Created</phrase>
		<phrase module_id="friend" version_id="2.0.8" var_name="paid" added="1299667848">Paid</phrase>
		<phrase module_id="friend" version_id="2.1.0beta1" var_name="setting_allow_blocked_user_to_friend_request" added="1300893373"><![CDATA[<title>Allow Friend Requests from Blocked users</title><info>If userA blocks userB, should userB be able to send a friend request to userA?</info>]]></phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="no_new_requests" added="1319116328">No new requests.</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="moderate" added="1319116336">Moderate</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="relationship_request" added="1319116348">Relationship request</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="1_mutual_friend" added="1319116360">1 mutual friend</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="total_mutual_friends" added="1319116372">{total} mutual friends</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="view_more" added="1319116390">View More</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="send_a_message" added="1319116398">Send a Message</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="view_profile" added="1319116406">View Profile</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="see_all_friend_requests" added="1319116416">See All Friend Requests</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="search_friends_dot_dot_dot" added="1319123079">Search Friends...</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="newest_friends" added="1319123092">Newest Friends</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="by_first_name" added="1319123099">By First Name</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="custom_order" added="1319123110">Custom Order</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="list_successfully_deleted" added="1319123118">List successfully deleted.</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="incoming_requests" added="1319123162">Incoming Requests</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="pending_requests" added="1319123171">Pending Requests</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="you_have_1_new_friend_request" added="1319123305">You have 1 new friend request</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="you_have_total_new_friend_requests" added="1319123319">You have {total} new friend requests</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="delete_list" added="1319123833">Delete List</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="edit_name" added="1319123840">Edit Name</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="display_on_profile" added="1319123848">Display on Profile</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="remove_from_profile" added="1319123855">Remove from Profile</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="change_order" added="1319123863">Change Order</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="remove_this_friend" added="1319123907">Remove This Friend</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="enter_the_name_of_your_custom_friends_list" added="1319123939"><![CDATA[Enter the name of your custom friends' list.]]></phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="submit" added="1319123945">Submit</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="remove_friend" added="1319124021">Remove Friend</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="list_successfully_created" added="1319124239">List successfully created.</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="successfully_added_this_list_to_your_profile" added="1319124316">Successfully added this list to your profile.</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="profile_friend_lists" added="1319124325">Profile Friend Lists</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="order_successfully_saved" added="1319124721">Order successfully saved</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="list_order" added="1319124741">List Order</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="you_must_enable_dnd_mode" added="1319124771">You must enable DND mode.</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="block_was_deleted" added="1319124780">Block was deleted</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="cant_delete_it" added="1319124790">Cant delete it</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="tomorrow" added="1319448584">Tomorrow</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="after_tomorrow" added="1319448593">After Tomorrow</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="today_normal" added="1319448609">Today</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="and" added="1319448619">and</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="full_name_added_you_as_a_friend" added="1319553387">{full_name} added you as a friend</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="gets_a_full_list_of_friends_for_a_specific_user" added="1319553442">Gets a full list of friends for a specific user. If you do not pass the #{USER_ID} we will return information about the user that is currently logged in.</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="checks_if_2_users_are_friends_or_not" added="1319553457">Checks if 2 users are friends or not. If you do not pass the #{USER_ID} we will return information about the user that is currently logged in.</phrase>
		<phrase module_id="friend" version_id="3.0.0beta5" var_name="full_name_posted_a_href_link_a_link_a_on_a_href_parent_user_name" added="1319553576"><![CDATA[{full_name} posted <a href="{link}">a link</a> on <a href="{parent_user_name}">{parent_full_name}</a>'s <a href="{link}">wall</a>.]]></phrase>
		<phrase module_id="friend" version_id="3.0.0rc2" var_name="birthday_notification" added="1321360031">Birthday Notification</phrase>
		<phrase module_id="friend" version_id="3.0.0rc2" var_name="happy_birthday" added="1321360051">Happy Birthday!</phrase>
		<phrase module_id="friend" version_id="3.0.0" var_name="confirm" added="1322481491">Confirm</phrase>
		<phrase module_id="friend" version_id="3.0.0" var_name="remove_this_request" added="1322737531">Remove This Request</phrase>
		<phrase module_id="friend" version_id="3.0.0" var_name="show_more_results_for_search_term" added="1322738277"><![CDATA[Show more results for "{search_term}"]]></phrase>
		<phrase module_id="friend" version_id="3.0.0" var_name="save_changes" added="1323086613">Save Changes</phrase>
		<phrase module_id="friend" version_id="3.0.1" var_name="setting_friends_only_profile" added="1327427677"><![CDATA[<title>Friends Only Profile</title><info>With this setting enabled only friends can view each others profiles.<br />Note this will override your users privacy settings and force anything related to viewing their profile and have it set to "Friends Only".</info>]]></phrase>
		<phrase module_id="friend" version_id="3.1.0rc1" var_name="menu_friend_friends_532c28d5412dd75bf975fb951c740a30" added="1332257784">Friends</phrase>
		<phrase module_id="friend" version_id="3.3.0beta2" var_name="see_all" added="1340275664">See All</phrase>
		<phrase module_id="friend" version_id="3.3.0" var_name="confirmed" added="1343030392">Confirmed</phrase>
		<phrase module_id="friend" version_id="3.3.0" var_name="denied" added="1343030402">Denied</phrase>
		<phrase module_id="friend" version_id="3.5.0beta1" var_name="user_setting_link_to_remove_friend_on_profile" added="1352109355"><![CDATA[When enabled, members of this user group will see a link to "Remove Friend" from the profile page of their friends.]]></phrase>
		<phrase module_id="friend" version_id="3.5.0beta2" var_name="unable_to_send_a_friend_request_to_this_user_at_this_moment" added="1359361600">Unable to send a friend request to this user at this moment.</phrase>
		<phrase module_id="friend" version_id="3.5.1" var_name="unfriend" added="1366634350">Unfriend</phrase>
		<phrase module_id="friend" version_id="3.6.0rc1" var_name="setting_cache_mutual_friends" added="1371724056"><![CDATA[<title>Mutual Friends List</title><info>Minutes, 0 = no cache. Caches the list of mutual friends with specific users.</info>]]></phrase>
		<phrase module_id="friend" version_id="3.6.0rc1" var_name="setting_cache_rand_list_of_friends" added="1371724112"><![CDATA[<title>Friends List</title><info>Minutes. 0 = no cache. Block is friend.small in the profiles, defaults to the left column. It is also called from the timeline block in the friend module.</info>]]></phrase>
		<phrase module_id="friend" version_id="3.6.0rc1" var_name="setting_cache_is_friend" added="1371724166"><![CDATA[<title>Friends Check</title><info>Cache if a user is friends with another user. Cleared only when adding or removing a friend.</info>]]></phrase>
		<phrase module_id="friend" version_id="3.6.0rc1" var_name="setting_cache_friend_list" added="1371724202"><![CDATA[<title>Friends List (FULL)</title><info>Cache the users friends list so we don&#039;t query the database all the time.</info>]]></phrase>
		<phrase module_id="friend" version_id="3.6.0rc1" var_name="setting_load_friends_online_ajax" added="1371731879"><![CDATA[<title>Online Friends via AJAX</title><info>Load the Online Friends only after the site has loaded via AJAX.</info>]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="friend" type="boolean" admin="1" user="1" guest="0" staff="1" module="friend" ordering="0">can_add_friends</setting>
		<setting is_admin_setting="0" module_id="friend" type="boolean" admin="1" user="1" guest="0" staff="1" module="friend" ordering="0">can_add_folders</setting>
		<setting is_admin_setting="0" module_id="friend" type="integer" admin="10" user="10" guest="0" staff="10" module="friend" ordering="0">total_folders</setting>
		<setting is_admin_setting="0" module_id="friend" type="boolean" admin="1" user="1" guest="0" staff="1" module="friend" ordering="0">can_remove_friends_from_profile</setting>
		<setting is_admin_setting="0" module_id="friend" type="boolean" admin="1" user="1" guest="0" staff="1" module="friend" ordering="0">can_remove_friends_from_dashboard</setting>
		<setting is_admin_setting="0" module_id="friend" type="boolean" admin="false" user="false" guest="false" staff="false" module="friend" ordering="0">link_to_remove_friend_on_profile</setting>
	</user_group_settings>
	<tables><![CDATA[a:6:{s:13:"phpfox_friend";a:3:{s:7:"COLUMNS";a:8:{s:9:"friend_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"is_page";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"list_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"friend_user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"is_top_friend";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"friend_id";s:4:"KEYS";a:8:{s:10:"user_check";a:2:{i:0;s:6:"UNIQUE";i:1;a:2:{i:0;s:7:"user_id";i:1;s:14:"friend_user_id";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:10:"top_friend";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:13:"is_top_friend";}}s:9:"friend_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"friend_id";i:1;s:7:"user_id";}}s:7:"list_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"list_id";i:1;s:7:"user_id";}}s:14:"friend_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:14:"friend_user_id";}s:7:"is_page";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"is_page";i:1;s:7:"user_id";}}s:9:"is_page_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"is_page";i:1;s:7:"user_id";i:2;s:14:"friend_user_id";}}}}s:18:"phpfox_friend_list";a:3:{s:7:"COLUMNS";a:5:{s:7:"list_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_profile";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"list_id";s:4:"KEYS";a:3:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:7:"list_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"list_id";i:1;s:7:"user_id";}}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:10:"is_profile";}}}}s:23:"phpfox_friend_list_data";a:2:{s:7:"COLUMNS";a:3:{s:7:"list_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"friend_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:7:"list_id";a:2:{i:0;s:6:"UNIQUE";i:1;a:2:{i:0;s:7:"list_id";i:1;s:14:"friend_user_id";}}s:9:"list_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"list_id";}}}s:21:"phpfox_friend_request";a:3:{s:7:"COLUMNS";a:9:{s:10:"request_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_seen";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"friend_user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_ignore";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"list_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"message";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:16:"relation_data_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:10:"request_id";s:4:"KEYS";a:5:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:14:"friend_user_id";}}s:7:"ignored";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:9:"is_ignore";}}s:14:"friend_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:14:"friend_user_id";}s:16:"relation_data_id";a:2:{i:0;s:5:"INDEX";i:1;s:16:"relation_data_id";}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:7:"is_seen";i:2;s:9:"is_ignore";}}}}s:22:"phpfox_friend_birthday";a:3:{s:7:"COLUMNS";a:7:{s:11:"birthday_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:20:"birthday_user_sender";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:22:"birthday_user_receiver";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:16:"birthday_message";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"egift_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"status_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:11:"birthday_id";s:4:"KEYS";a:2:{s:20:"birthday_user_sender";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:20:"birthday_user_sender";i:1;s:22:"birthday_user_receiver";}}s:11:"birthday_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"birthday_id";i:1;s:22:"birthday_user_receiver";}}}}s:18:"phpfox_friend_hide";a:3:{s:7:"COLUMNS";a:4:{s:7:"hide_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"friend_user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"hide_id";s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}}]]></tables>
</module>