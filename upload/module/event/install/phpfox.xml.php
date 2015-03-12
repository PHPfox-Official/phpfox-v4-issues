<module>
	<data>
		<module_id>event</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:29:"event.admin_menu_add_category";a:1:{s:3:"url";a:2:{i:0;s:5:"event";i:1;s:3:"add";}}s:34:"event.admin_menu_manage_categories";a:1:{s:3:"url";a:1:{i:0;s:5:"event";}}}]]></menu>
		<phrase_var_name>module_event</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:15:"file/pic/event/";}]]></writable>
	</data>
	<menus>
		<menu module_id="event" parent_var_name="" m_connection="main" var_name="menu_event" ordering="29" url_value="event" version_id="2.0.0alpha1" disallow_access="" module="event" />
		<menu module_id="event" parent_var_name="" m_connection="event.index" var_name="menu_create_new_event" ordering="62" url_value="event.add" version_id="2.0.0alpha4" disallow_access="" module="event" />
		<menu module_id="event" parent_var_name="" m_connection="mobile" var_name="menu_event_events_532c28d5412dd75bf975fb951c740a30" ordering="115" url_value="event" version_id="3.1.0rc1" disallow_access="" module="event" mobile_icon="small_events.png" />
	</menus>
	<settings>
		<setting group="time_stamps" module_id="event" is_hidden="0" type="string" var_name="event_view_time_stamp_profile" phrase_var_name="setting_event_view_time_stamp_profile" ordering="1" version_id="2.0.0alpha4">F j, Y</setting>
		<setting group="time_stamps" module_id="event" is_hidden="0" type="string" var_name="event_browse_time_stamp" phrase_var_name="setting_event_browse_time_stamp" ordering="2" version_id="2.0.0alpha4">l, F j</setting>
		<setting group="time_stamps" module_id="event" is_hidden="0" type="string" var_name="event_basic_information_time" phrase_var_name="setting_event_basic_information_time" ordering="3" version_id="2.0.5">l, F j, Y g:i a</setting>
		<setting group="time_stamps" module_id="event" is_hidden="0" type="string" var_name="event_basic_information_time_short" phrase_var_name="setting_event_basic_information_time_short" ordering="4" version_id="2.0.5">g:i a</setting>
		<setting group="cache" module_id="event" is_hidden="0" type="boolean" var_name="cache_events_per_user" phrase_var_name="setting_cache_events_per_user" ordering="1" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="event" is_hidden="0" type="integer" var_name="cache_upcoming_events_info" phrase_var_name="setting_cache_upcoming_events_info" ordering="2" version_id="3.6.0rc1">8</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="event.view" module_id="event" component="info" location="4" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title>Event Information</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.view" module_id="event" component="rsvp" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.index" module_id="event" component="category" location="1" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="group.view" module_id="event" component="parent" location="0" is_active="1" ordering="1" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.view" module_id="event" component="map" location="1" is_active="1" ordering="5" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.view" module_id="event" component="image" location="1" is_active="1" ordering="5" disallow_access="" can_move="0">
			<title>Event Photo</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.index" module_id="event" component="sponsored" location="3" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.view" module_id="event" component="attending" location="1" is_active="1" ordering="6" disallow_access="" can_move="0">
			<title>Attending</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.index" module_id="event" component="invite" location="3" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title>Event Invites</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.index" module_id="event" component="featured" location="3" is_active="1" ordering="5" disallow_access="" can_move="0">
			<title>Featured Events</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_admincp_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_admincp_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_view_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_group_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_image_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_category_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_parent_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_menu_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_info_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_profile_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_rsvp_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_list_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_category_category__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_category_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_event__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_browse__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_filter_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_add__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_sponsor__end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_sponsored_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="event" hook_type="template" module="event" call_name="event.template_default_controller_view_extra_info" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_delete__start" added="1298455495" version_id="2.0.8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_delete__pre_unlink" added="1298455495" version_id="2.0.8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_delete__pre_space_update" added="1298455495" version_id="2.0.8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_delete__pre_deletes" added="1298455495" version_id="2.0.8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_delete__end" added="1298455495" version_id="2.0.8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_add__start" added="1298455786" version_id="2.0.8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_update__start" added="1298455786" version_id="2.0.8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_massemail__start" added="1298455786" version_id="2.0.8" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_massemail__end" added="1298455786" version_id="2.0.8" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_attending_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_browse_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_featured_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_invite_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_rsvp_entry_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_profile_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_index_set_filter_menu_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_update__end" added="1335951260" version_id="3.2.0" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_deleteimage__end" added="1335951260" version_id="3.2.0" />
		<hook module_id="event" hook_type="service" module="event" call_name="event.service_process_approve__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="event" hook_type="component" module="event" call_name="event.component_block_mini_clean" added="1372931660" version_id="3.6.0" />
		<hook module_id="event" hook_type="controller" module="event" call_name="event.component_controller_view_process_end" added="1395674818" version_id="3.7.6rc1" />
	</hooks>
	<components>
		<component module_id="event" component="menu" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="image" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="view" m_connection="event.view" module="event" is_controller="1" is_block="0" is_active="1" />
		<component module_id="event" component="index" m_connection="event.index" module="event" is_controller="1" is_block="0" is_active="1" />
		<component module_id="event" component="rsvp" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="category" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="profile" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="info" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="parent" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="filter" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="sponsored" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="list" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="attending" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="map" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="invite" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
		<component module_id="event" component="profile" m_connection="event.profile" module="event" is_controller="1" is_block="0" is_active="1" />
		<component module_id="event" component="featured" m_connection="" module="event" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="event" version_id="2.0.0alpha1" var_name="module_event" added="1232964578">Events</phrase>
		<phrase module_id="event" version_id="2.0.0alpha1" var_name="menu_event" added="1232964592">Events</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="user_setting_can_edit_own_event" added="1239708707">Can edit own event?</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="user_setting_can_edit_other_event" added="1239708756">Can edit events added by other users?</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="user_setting_can_post_comment_on_event" added="1239715876">Can post comments on events?</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="user_setting_can_delete_own_event" added="1239716463">Can delete own event?</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="user_setting_can_delete_other_event" added="1239716486">Can delete events created by other users?</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="menu_create_new_event" added="1239786795">Create New Event</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="admin_menu_add_category" added="1239792607">Add Category</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="admin_menu_manage_categories" added="1239792607">Manage Categories</phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="setting_event_view_time_stamp_profile" added="1239794674"><![CDATA[<title>Event Profile Time Stamp</title><info>Time stamp used when displaying events on a users profile.</info>]]></phrase>
		<phrase module_id="event" version_id="2.0.0alpha4" var_name="setting_event_browse_time_stamp" added="1239801858"><![CDATA[<title>Event Browsing Time Stamp</title><info>Time stamp displayed when browsing events.</info>]]></phrase>
		<phrase module_id="event" version_id="2.0.0beta5" var_name="rss_group_name_2" added="1245607788">Events</phrase>
		<phrase module_id="event" version_id="2.0.0beta5" var_name="rss_title_3" added="1245608409">Latest Events</phrase>
		<phrase module_id="event" version_id="2.0.0beta5" var_name="rss_description_3" added="1245608409">List of all the upcoming events.</phrase>
		<phrase module_id="event" version_id="2.0.0rc1" var_name="user_setting_max_upload_size_event" added="1250361175"><![CDATA[Max file size for event photos in kilobits (kb).
(1000 kb = 1 mb)
For unlimited add "0" without quotes.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc1" var_name="user_setting_can_view_pirvate_events" added="1250490001">Can view private events?</phrase>
		<phrase module_id="event" version_id="2.0.0rc1" var_name="user_setting_can_approve_events" added="1250491324">Can approve events?</phrase>
		<phrase module_id="event" version_id="2.0.0rc1" var_name="user_setting_can_feature_events" added="1250491341">Can feature events?</phrase>
		<phrase module_id="event" version_id="2.0.0rc1" var_name="user_setting_event_must_be_approved" added="1250491615">Events must be approved first before they are displayed publicly?</phrase>
		<phrase module_id="event" version_id="2.0.0rc1" var_name="user_setting_total_mass_emails_per_hour" added="1250502555">Define how long this user group must wait until they are allowed to send out another mass email.</phrase>
		<phrase module_id="event" version_id="2.0.0rc1" var_name="user_setting_can_mass_mail_own_members" added="1250505060">Can mass email own event guests?</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="done" added="1254390083">Done!</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="not_attending" added="1254390105">Not Attending</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="maybe" added="1254390112">Maybe</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="attending" added="1254390119">Attending</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="successfully_deleted_event" added="1254390136">Successfully deleted event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="you_are_unable_to_send_out_any_mass_emails_at_the_moment" added="1254390156">You are unable to send out any mass emails at the moment.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="fill_in_both_a_subject_and_text_for_your_mass_email" added="1254390166">Fill in both a subject and text for your mass email.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="you_are_unable_to_send_a_mass_email_for_this_event" added="1254390175">You are unable to send a mass email for this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="email_progress_page_total" added="1254390201">Email Progress: {page}/{total}</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="categories" added="1254390245">Categories</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="sub_categories" added="1254390255">Sub-Categories</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="browse_filter" added="1254390267">Browse Filter</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="basic_information" added="1254390281">Basic Information</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_guests" added="1254390296">Event Guests</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="can_t_make_it" added="1254390323"><![CDATA[Can't Make It]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="not_responded" added="1254390333">Not Responded</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="upcoming_events" added="1254390347">Upcoming Events</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="events_i_m_attending" added="1254390361"><![CDATA[Events I'm Attending]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="your_rsvp" added="1254390374">Your RSVP</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="category_successfully_updated" added="1254390394">Category successfully updated.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="category_successfully_added" added="1254390403">Category successfully added.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="edit_a_category" added="1254390411">Edit a Category</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="create_a_new_category" added="1254390420">Create a New Category</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="category_order_successfully_updated" added="1254390441">Category order successfully updated.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="category_successfully_deleted" added="1254390450">Category successfully deleted.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="manage_categories" added="1254390459">Manage Categories</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="provide_a_name_for_this_event" added="1254390488">Provide a name for this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="provide_a_location_for_this_event" added="1254390496">Provide a location for this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="provide_a_country_location_for_this_event" added="1254390544">Provide a country location for this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="provide_a_host_for_this_event" added="1254390553">Provide a host for this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="successfully_invited_guests_to_this_event" added="1254390564">Successfully invited guests to this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="successfully_customized_this_event" added="1254390573">Successfully customized this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_successfully_updated" added="1254390590">Event successfully updated.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_successfully_added" added="1254390606">Event successfully added.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="note_that_events_must_first_be_approved_by_a_site_admin_before_it_is_displayed_publicly" added="1254390617">Note that events must first be approved by a site admin before it is displayed publicly.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="edit_event" added="1254390634">Edit Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="create_new_event" added="1254390661">Create New Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="events" added="1254390673">Events</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="the_events_section_is_closed" added="1254390690">The events section is closed.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_successfully_deleted" added="1254390708">Event successfully deleted.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="date_added" added="1254390726">Date Added</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="name" added="1254390733">Name</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="recent_events" added="1254390754">Recent Events</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="today" added="1254390762">Today</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="tomorrow" added="1254390768">Tomorrow</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="this_week" added="1254390776">This Week</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="this_weekend" added="1254390785">This Weekend</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="pending" added="1254390792">Pending</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="the_event_you_are_looking_for_does_not_exist_or_has_been_removed" added="1254390835">The event you are looking for does not exist or has been removed.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="this_event_is_private" added="1254390844">This event is private.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="provide_a_category_name" added="1254390903">Provide a category name.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="user_name_left_you_a_comment_on_site_title" added="1254390985">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="user_name_left_you_a_comment_on_your_event_title" added="1254393241"><![CDATA[{user_name} left you a comment on your event "{title}".

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="user_name_added_a_new_comment_on_their_own_event" added="1254393467"><![CDATA[<a href="{user_link}">{user_name}</a> added a new comment on their own <a href="{title_link}">event</a>.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="user_name_added_a_new_comment_on_your_event" added="1254393537"><![CDATA[<a href="{user_link}">{user_name}</a> added a new comment on your <a href="{title_link}">event</a>.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="user_name_added_a_new_comment_on_item_user_name" added="1254393593"><![CDATA[<a href="{user_link}">{user_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">event</a>.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="owner_full_name_added_a_new_event_title" added="1254393693"><![CDATA[<a href="{user_link}">{owner_full_name}</a> added a new event "<a href="{title_link}">{title}</a>"]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="create_an_event" added="1254393872">Create an Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="manage_events" added="1254393882">Manage Events</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="view_events" added="1254393907">View Events</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="your_event_title_has_been_approved" added="1254393926"><![CDATA[Your event "{title}" has been approved.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="full_name_invited_you_to_an_event" added="1254393988"><![CDATA[<a href="{user_link}">{full_name}</a> invited you to an event.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="no_event_invites" added="1254394032">No event invites.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_invites_total" added="1254394068"><![CDATA[Event Invites (<span id="js_request_event_count_total">{total}</span>)]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_text" added="1254394108">Event Text</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="are_you_sure_this_will_delete_all_events_that_belong_to_this_category_and_cannot_be_undone" added="1254394191">Are you sure? This will delete all events that belong to this category and cannot be undone.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="keywords" added="1254394232">Keywords</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="location" added="1254394242">Location</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="city" added="1254394251">City</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="zip_postal_code" added="1254394258">Zip/Postal Code</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="sort" added="1254394264">Sort</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="submit" added="1254394272">Submit</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="reset" added="1254394278">Reset</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="host" added="1254394553">Host</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="date" added="1254394561">Date</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="remove_this_person_from_the_guest_list" added="1254394593">Remove this person from the guest list.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="report_an_event" added="1254394628">Report an Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="report" added="1254394635">Report</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="invite_people_to_come" added="1254394643">Invite People to Come</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="mass_email_guests" added="1254394654">Mass Email Guests</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="manage_guest_list" added="1254394679">Manage Guest List</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="contact_full_name_creator" added="1254394697">Contact {full_name} (Creator)</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="delete_event" added="1254394721">Delete Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="no_upcoming_events" added="1254397022">No upcoming events.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="add_an_event" added="1254397054">Add an Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="time_stamp_at_location" added="1254397907">{time_stamp} at {location}</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="maybe_attending" added="1254398353">Maybe Attending</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="update_your_rsvp" added="1254398413">Update Your RSVP</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="submit_your_rsvp" added="1254398422">Submit Your RSVP</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_category_details" added="1254398464">Event Category Details</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="parent_category" added="1254398482">Parent Category</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="select" added="1254398490">Select</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="edit" added="1254398508">Edit</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="delete" added="1254398515">Delete</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="update_order" added="1254398529">Update Order</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="view_this_event" added="1254398541">View This Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="skip_amp_view_this_event" added="1254398553"><![CDATA[Skip &amp; View This Event]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="step_1" added="1254398566">Step 1</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_details" added="1254398576">Event Details</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="step_2" added="1254398589">Step 2</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="customize" added="1254398598">Customize</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="step_3" added="1254398609">Step 3</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="invite_guests" added="1254398621">Invite Guests</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="mass_email" added="1254398639">Mass Email</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="category" added="1254398655">Category</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="tagline" added="1254398671">Tagline</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="description" added="1254398686">Description</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="public_everyone_can_join" added="1254398696">Public (Everyone can join)</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="privacy" added="1254398703">Privacy</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="private_does_not_show_up_anywhere_and_only_invited_users_can_rsvp" added="1254398711">Private (Does not show up anywhere and only invited users can RSVP)</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="start_time" added="1254398721">Start Time</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="end_time" added="1254398728">End Time</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="country" added="1254398736">Country</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="location_venue" added="1254398759">Location/Venue</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="save" added="1254398769">Save</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="create_event" added="1254398776">Create Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_photo" added="1254398789">Event Photo</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="are_you_sure" added="1254398809">Are you sure?</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="click_here_to_delete_this_image_and_upload_a_new_one_in_its" added="1254399660"><![CDATA[Click <a href="#" onclick="{java_script}">here</a> to delete this image and upload a new one in its place.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1254399765">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="the_file_size_limit_is_filesize_if_your_upload_does_not_work_try_uploading_a_smaller_picture" added="1254399852">The file size limit is {filesize}. If your upload does not work, try uploading a smaller picture.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="invite_friends" added="1254399982">Invite Friends</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="invite_people_via_email" added="1254399998">Invite People via Email</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="separate_multiple_emails_with_a_comma" added="1254400018">Separate multiple emails with a comma.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="add_a_personal_message" added="1254400038">Add a Personal Message</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="send_invitations" added="1254402189">Send Invitations</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="new_guest_list" added="1254402198">New Guest List</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="send_out_an_email_to_all_the_guests_that_are_joining_this_event" added="1254402208">Send out an email to all the guests that are joining this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="last_mass_email" added="1254403662">Last Mass Email</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="subject" added="1254403672">Subject</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="text" added="1254403680">Text</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="sending_emails" added="1254403694">Sending Emails</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="send" added="1254403702">Send</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="please_wait_till" added="1254403726">Please wait till</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="you_have_not_been_invited_to_any_events_yet" added="1254403749">You have not been invited to any events yet.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="browse_events" added="1254403767">Browse events.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="you_are_not_attending_any_events" added="1254403845">You are not attending any events.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="no_events_found_where_you_might_attend" added="1254403853">No events found where you might attend.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="no_events_found_where_you_are_not_attending" added="1254403860">No events found where you are not attending.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="no_past_events_were_found" added="1254403867">No past events were found.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="no_events_have_been_created" added="1254403874">No events have been created.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="be_the_first_to_create_an_event" added="1254403881">Be the first to create an event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="there_is_one_event_that_is_pending_approval" added="1254403897">There is one event that is pending approval.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="there_are_total_events_that_are_pending_approval" added="1254403911">There are {total} events that are pending approval.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="click_here_to_approve_events" added="1254403986"><![CDATA[Click <a href="{link}">here</a> to approve events.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="private" added="1254404038">Private</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="featured" added="1254404047">Featured</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="start_time_at_location" added="1254404250">{start_time} at {location}</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="posted_by_user_name_on_time_stamp" added="1254405622">Posted by {user_name} on {time_stamp}</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="rsvp" added="1254463761">RSVP</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="no_response" added="1254463769">No Response</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="edit_lowercase" added="1254463862">edit</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="approve_this_event" added="1254463909">Approve this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="approve" added="1254463929">Approve</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="approved" added="1254463938">Approved</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="feature_this_event" added="1254463951">Feature this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="feature" added="1254463975">Feature</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="un_feature_this_event" added="1254463988">Un-Feature this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="unfeature" added="1254464001">Unfeature</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="event_is_pending_approval" added="1254464118">Event is pending approval.</phrase>
		<phrase module_id="event" version_id="2.0.0rc3" var_name="full_name_has_closed_their_favorites_section" added="1254464572"><![CDATA[<a href="{user_link}">{full_name}</a> has closed their favorites section.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc4" var_name="a_href_user_link_user_name_a_added_a_comment_on_the_event_a_href_title_link_title_a" added="1255941112"><![CDATA[<a href="{user_link}">{user_name}</a> added a comment on the event "<a href="{title_link}">{title}</a>".]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc6" var_name="your_event_is_ending_before_it_starts" added="1256907682">Your event is ending before it starts.</phrase>
		<phrase module_id="event" version_id="2.0.0rc6" var_name="your_event_is_starting_in_the_past" added="1256907696">Your event is starting in the past.</phrase>
		<phrase module_id="event" version_id="2.0.0rc7" var_name="full_name_invited_you_to_the_title" added="1257929870"><![CDATA[{full_name} invited you to "{title}".

To check out this event, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc7" var_name="full_name_added_the_following_personal_message" added="1257930058">

{full_name} added the following personal message
</phrase>
		<phrase module_id="event" version_id="2.0.0rc7" var_name="full_name_invited_you_to_the_event_title" added="1257930189"><![CDATA[{full_name} invited you to the event "{title}".]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc7" var_name="provide_a_category_this_event_will_belong_to" added="1257930365">Provide a category this event will belong to.</phrase>
		<phrase module_id="event" version_id="2.0.0rc8" var_name="unable_to_find_the_event_you_want_to_approve" added="1258472809">Unable to find the event you want to approve.</phrase>
		<phrase module_id="event" version_id="2.0.0rc8" var_name="you_do_not_have_sufficient_permission_to_modify_this_event" added="1258472832">You do not have sufficient permission to modify this event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc8" var_name="unable_to_find_the_event" added="1258472853">Unable to find the event.</phrase>
		<phrase module_id="event" version_id="2.0.0rc8" var_name="unable_to_find_the_event_you_want_to_delete" added="1258472870">Unable to find the event you want to delete.</phrase>
		<phrase module_id="event" version_id="2.0.0rc8" var_name="you_do_not_have_sufficient_permission_to_delete_this_listing" added="1258472878">You do not have sufficient permission to delete this listing.</phrase>
		<phrase module_id="event" version_id="2.0.0rc8" var_name="your_event_has_been_approved_on_site_title" added="1258472903">Your event has been approved on {site_title}.</phrase>
		<phrase module_id="event" version_id="2.0.0rc8" var_name="your_event_has_been_approved_on_site_title_link" added="1258472958"><![CDATA[Your event has been approved on {site_title}.

To view this event, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc8" var_name="notice_this_is_a_newsletter_sent_from_the_event" added="1258472989">Notice: This is a newsletter sent from the event</phrase>
		<phrase module_id="event" version_id="2.0.0rc11" var_name="user_setting_can_access_event" added="1260286460">Can browse and view the event module?</phrase>
		<phrase module_id="event" version_id="2.0.0rc11" var_name="user_setting_can_create_event" added="1260329621">Can create an event?</phrase>
		<phrase module_id="event" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_event_a" added="1260455427"><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">event</a>.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_their_own_a_href_link_event_a" added="1260455449"><![CDATA[<a href="{user_link}">{full_name}</a> liked their own <a href="{link}">event</a>.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_your_a_href_link_event_a" added="1260456261"><![CDATA[<a href="{user_link}">{full_name}</a> liked your <a href="{link}">event</a>.]]></phrase>
		<phrase module_id="event" version_id="2.0.0rc12" var_name="can_create_event" added="1260904019">Create Event</phrase>
		<phrase module_id="event" version_id="2.0.0rc12" var_name="select_a_sub_category" added="1260971268">Select a Sub-Category</phrase>
		<phrase module_id="event" version_id="2.0.2" var_name="remove_invite" added="1262117196">Remove Invite</phrase>
		<phrase module_id="event" version_id="2.0.4" var_name="no_attendees" added="1266424685">No attendees.</phrase>
		<phrase module_id="event" version_id="2.0.4" var_name="no_results" added="1266424785">No results.</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="user_setting_can_sponsor_event" added="1270109256">Can members of this user group sponsor their events?</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="unsponsor_this_event" added="1270109414">Unsponsor this event</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="sponsor_this_event" added="1270109438">Sponsor this Event</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="sponsored_event" added="1270109451">Sponsored Event</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="user_setting_can_purchase_sponsor" added="1271077140">Can members of this user group purchase a sponsored ad space?</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="event_successfully_un_sponsored" added="1271077259">Event successfully unsponsored</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="event_successfully_sponsored" added="1271077306">Event successfully sponsored</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="sponsor_help" added="1271149455">To purchase sponsor space for your events click on your event and then click on Sponsor in the right hand side menu.</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="encourage_sponsor" added="1271149817">Sponsor your Events</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="user_setting_event_event_sponsor_price" added="1271932350">How much is the sponsor space worth for events?
This works in a CPM basis.</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="user_setting_auto_publish_sponsored_item" added="1272007260">After the user has purchased a sponsored space, should the event be published right away?
If set to false, the admin will have to approve each new purchased sponsored event space before it is shown in the site.</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="sponsor_error_not_found" added="1272356770">That event is no longer available.</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="sponsor_error_privacy" added="1272356851">This event is set to private, sponsoring it conflicts with this setting.</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="sponsor_title" added="1272356926">Event: {sEventTitle}</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="sponsor_paypal_message" added="1272357027">Sponsor of event {sEventTitle}</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="setting_event_basic_information_time" added="1273245992"><![CDATA[<title>Event Basic Information Time Stamp</title><info>This is the time stamp that is used when viewing an event. It can be found in the "Basic Information" block.</info>]]></phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="setting_event_basic_information_time_short" added="1273246130"><![CDATA[<title>Event Basic Information Time Stamp (Short)</title><info>This is the short version of the time stamp that is used when viewing an event. It can be found in the "Basic Information" block.</info>]]></phrase>
		<phrase module_id="event" version_id="2.0.5dev2" var_name="user_setting_flood_control_events" added="1275108355"><![CDATA[How many minutes should a user wait before they can create another event?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></phrase>
		<phrase module_id="event" version_id="2.0.5dev2" var_name="you_are_creating_an_event_a_little_too_soon" added="1275108393">You are creating an event a little too soon.</phrase>
		<phrase module_id="event" version_id="2.0.5" var_name="user_setting_event_sponsor_price" added="1276177435">How much is the sponsor space worth for events?
This works in a CPM basis.</phrase>
		<phrase module_id="event" version_id="2.0.6" var_name="time_separator" added="1284988672">at</phrase>
		<phrase module_id="event" version_id="2.0.7" var_name="updating" added="1288183829">Updating</phrase>
		<phrase module_id="event" version_id="2.0.7" var_name="event_invite_count" added="1288714155">Event Invite Count</phrase>
		<phrase module_id="event" version_id="2.0.8" var_name="user_setting_can_view_gmap" added="1298476820">Can members of this user group view a Google Map in the Events section?</phrase>
		<phrase module_id="event" version_id="2.0.8" var_name="user_setting_can_add_gmap" added="1298476869">Can members of this user group add a Google Map to their events?</phrase>
		<phrase module_id="event" version_id="2.0.8" var_name="address" added="1298896463">Address</phrase>
		<phrase module_id="event" version_id="2.1.0" var_name="find_on_map" added="1303890231">Find On Map</phrase>
		<phrase module_id="event" version_id="3.0.0beta1" var_name="user_setting_points_event" added="1304600668">How many points does the user get when they add a new event?</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="what_s_the_event" added="1319112161"><![CDATA[What's the event?]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="where" added="1319112186">Where?</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="and" added="1319112259">and</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="guest_list" added="1319121993">Guest List</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="event_has_been_approved" added="1319183730">Event has been approved.</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="event_approved" added="1319183741">Event Approved</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="unable_to_find_the_event_you_are_trying_to_comment_on" added="1319183818">Unable to find the event you are trying to comment on.</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="no_events_found" added="1319200038">No events found.</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="sponsored" added="1319200053">Sponsored</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="actions" added="1319200068">Actions</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="moderate" added="1319200074">Moderate</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="at" added="1319200086">at</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="search_events" added="1319200435">Search Events...</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="latest" added="1319200442">Latest</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="most_viewed" added="1319200453">Most Viewed</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="most_liked" added="1319200462">Most Liked</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="most_discussed" added="1319200470">Most Discussed</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="all_events" added="1319200489">All Events</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="my_events" added="1319200498">My Events</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="friends_events" added="1319200523"><![CDATA[Friends' Events]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="featured_events" added="1319200531">Featured Events</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="pending_events" added="1319200542">Pending Events</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="events_i_may_attend" added="1319200564">Events I May Attend</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="events_i_m_not_attending" added="1319200574"><![CDATA[Events I'm Not Attending]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="event_invites" added="1319200582">Event Invites</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_s_events" added="1319200598"><![CDATA[{full_name}'s Events]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="what_are_you_planning" added="1319200639">What are you planning?</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="add_end_time" added="1319200648">Add end time</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="add_address_city_zip_country" added="1319200659">Add address/city/zip/country</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="event_privacy" added="1319200672">Event Privacy</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="control_who_can_see_this_event" added="1319200679">Control who can see this event.</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="share_privacy" added="1319200688">Share Privacy</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="control_who_can_share_on_this_event" added="1319200695">Control who can share on this event.</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="update" added="1319200706">Update</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="upload_photo" added="1319200722">Upload Photo</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="unable_to_view_this_item_due_to_privacy_settings" added="1319200748">Unable to view this item due to privacy settings.</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="photo" added="1319200760">Photo</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="managing_event" added="1319200777">Managing Event</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="time" added="1319200892">Time</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="view_on_google_maps" added="1319200908">View on Google Maps</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="view_this_on_google_maps" added="1319200920">View this on Google maps</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="created_by" added="1319200928">Created By</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="respond" added="1319200965">Respond</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="awaiting_reply" added="1319200985">Awaiting Reply</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="view_guest_list" added="1319201019">View Guest List</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_liked_a_comment_you_posted_on_the_event_title" added="1319530391"><![CDATA[{full_name} liked a comment you posted on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_liked_your_comment_message_event" added="1319530495"><![CDATA[{full_name} liked your comment "<a href="{link}">{content}</a>" that you posted on the event "<a href="{item_link}">{title}</a>".
To view this event follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_liked_your_event_title" added="1319530561"><![CDATA[{full_name} liked your event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_liked_your_event_message" added="1319530627"><![CDATA[{full_name} liked your event "<a href="{link}">{title}</a>"
To view this event follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1319547123">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_commented_on_a_comment_posted_on_the_event_title" added="1319547152"><![CDATA[{full_name} commented on a comment posted on the event "{title}".]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_your_comments_you_posted_on_the_event" added="1319547220"><![CDATA[{full_name} commented on one of your comments you posted on the event "<a href="{item_link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_gender_event_comments" added="1319547295">{full_name} commented on one of {gender} event comments.</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_row_full_name_s_event_comments" added="1319547348"><![CDATA[{full_name} commented on one of {row_full_name}'s event comments.]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_gender_own_comments_on_the_event" added="1319547425"><![CDATA[{full_name} commented on one of {gender} own comments on the event "<a href="{item_link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_row_full_name_s" added="1319547518"><![CDATA[{full_name} commented on one of {row_full_name}'s comments on the event "<a href="{item_link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_commented_on_span_class_drop_data_user_row_full_name_s_span_comment_on_the_event_title" added="1319547635"><![CDATA[{users} commented on <span class="drop_data_user">{row_full_name}'s</span> comment on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_commented_on_gender_own_comment_on_the_event_title" added="1319547703"><![CDATA[{users} commented on {gender} own comment on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_commented_on_one_of_your_comments_on_the_event_title" added="1319547746"><![CDATA[{users} commented on one of your comments on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_commented_on_one_of_span_class_drop_data_user_row_full_name_s_span_comments_on_the_event_title" added="1319547790"><![CDATA[{users} commented on one of <span class="drop_data_user">{row_full_name}'s</span> comments on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_commented_on_span_class_drop_data_user_row_full_name_s_span_event_title" added="1319547938"><![CDATA[{users} commented on <span class="drop_data_user">{row_full_name}'s</span> event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_commented_on_gender_own_event_title" added="1319547985"><![CDATA[{users} commented on {gender} own event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_commented_on_your_event_title" added="1319548025"><![CDATA[{users} commented on your event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_row_full_name_s_span_comment_on_the_event_title" added="1319548826"><![CDATA[{users} liked <span class="drop_data_user">{row_full_name}'s</span> comment on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_liked_gender_own_comment_on_the_event_title" added="1319548878"><![CDATA[{users} liked {gender} own comment on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_liked_one_of_your_comments_on_the_event_title" added="1319548913"><![CDATA[{users} liked one of your comments on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_liked_one_on_span_class_drop_data_user_row_full_name_s_span_comments_on_the_event_title" added="1319548952"><![CDATA[{users} liked one on <span class="drop_data_user">{row_full_name}'s</span> comments on the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_liked_gender_own_event_title" added="1319551547"><![CDATA[{users} liked {gender} own event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_liked_your_event_title" added="1319551587"><![CDATA[{users} liked your event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_row_full_name_s_span_event_title" added="1319551627"><![CDATA[{users} liked <span class="drop_data_user">{row_full_name}'s</span> event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="users_invited_you_to_the_event_title" added="1319551700"><![CDATA[{users} invited you to the event "{title}"]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="in_the_event_a_href_link_title_a" added="1319551749"><![CDATA[In the event <a href="{link}">{title}</a>]]></phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="who_can_share_events" added="1319551800">Who can share events?</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="who_can_view_browse_events" added="1319551808">Who can view/browse events?</phrase>
		<phrase module_id="event" version_id="3.0.0beta5" var_name="event" added="1319551818">Event</phrase>
		<phrase module_id="event" version_id="3.0.0rc1" var_name="responded" added="1320238329">Responded</phrase>
		<phrase module_id="event" version_id="3.0.0rc1" var_name="invited" added="1320238336">Invited</phrase>
		<phrase module_id="event" version_id="3.0.0rc1" var_name="invites" added="1321288957">Invites</phrase>
		<phrase module_id="event" version_id="3.0.0rc1" var_name="yes" added="1321288970">Yes</phrase>
		<phrase module_id="event" version_id="3.0.0rc1" var_name="no" added="1321288983">No</phrase>
		<phrase module_id="event" version_id="3.0.0rc2" var_name="by" added="1321364518">by</phrase>
		<phrase module_id="event" version_id="3.0.0" var_name="full_name_wrote_a_comment_on_your_event_title" added="1322466493"><![CDATA[{full_name} wrote a comment on your event "{title}".]]></phrase>
		<phrase module_id="event" version_id="3.0.0" var_name="full_name_wrote_a_comment_on_your_event_message" added="1322466576"><![CDATA[{full_name} wrote a comment on your event "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="event" version_id="3.0.0" var_name="a_href_link_on_name_s_event_a" added="1322561554"><![CDATA[<a href="{link}">On {name}'s event</a>]]></phrase>
		<phrase module_id="event" version_id="3.0.0" var_name="event_s_successfully_approved" added="1322739304">Event(s) successfully approved.</phrase>
		<phrase module_id="event" version_id="3.0.0" var_name="event_s_successfully_deleted" added="1322739317">Event(s) successfully deleted.</phrase>
		<phrase module_id="event" version_id="3.0.0" var_name="successfully_added_a_photo_to_your_event" added="1323087700">Successfully added a photo to your event.</phrase>
		<phrase module_id="event" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_an_event" added="1331221377">{user_name} tagged you in a comment in an event</phrase>
		<phrase module_id="event" version_id="3.1.0rc1" var_name="menu_event_events_532c28d5412dd75bf975fb951c740a30" added="1332257694">Events</phrase>
		<phrase module_id="event" version_id="3.5.0beta1" var_name="item_phrase" added="1352730940">event</phrase>
		<phrase module_id="event" version_id="3.6.0rc1" var_name="setting_cache_events_per_user" added="1371724255"><![CDATA[<title>Profile Event Count</title><info>Avoids querying for count in event.callback getTotalItemCount (called when going to a profile).</info>]]></phrase>
		<phrase module_id="event" version_id="3.6.0rc1" var_name="setting_cache_upcoming_events_info" added="1371731919"><![CDATA[<title>Cache Upcoming Events (Hours)</title><info>Cache the upcoming event in hours.</info>]]></phrase>
	</phrases>
	<rss_group>
		<group module_id="event" group_id="2" name_var="event.rss_group_name_2" is_active="1" />
	</rss_group>
	<rss>
		<feed module_id="event" group_id="2" title_var="event.rss_title_3" description_var="event.rss_description_3" feed_link="event" is_active="1" is_site_wide="1">
			<php_group_code></php_group_code>
			<php_view_code><![CDATA[$aRows = Phpfox::getService('event')->getForRssFeed();]]></php_view_code>
		</feed>
	</rss>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="1" guest="0" staff="1" module="event" ordering="0">can_edit_own_event</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="0" guest="0" staff="1" module="event" ordering="0">can_edit_other_event</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="1" guest="0" staff="1" module="event" ordering="0">can_post_comment_on_event</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="1" guest="0" staff="1" module="event" ordering="0">can_delete_own_event</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="0" guest="0" staff="1" module="event" ordering="0">can_delete_other_event</setting>
		<setting is_admin_setting="0" module_id="event" type="integer" admin="500" user="500" guest="500" staff="500" module="event" ordering="0">max_upload_size_event</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="0" guest="0" staff="1" module="event" ordering="0">can_view_pirvate_events</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="0" guest="0" staff="1" module="event" ordering="0">can_approve_events</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="0" guest="0" staff="1" module="event" ordering="0">can_feature_events</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="0" user="0" guest="0" staff="0" module="event" ordering="0">event_must_be_approved</setting>
		<setting is_admin_setting="0" module_id="event" type="integer" admin="0" user="60" guest="60" staff="0" module="event" ordering="0">total_mass_emails_per_hour</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="1" guest="0" staff="1" module="event" ordering="0">can_mass_mail_own_members</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="1" guest="1" staff="1" module="event" ordering="0">can_access_event</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="1" user="1" guest="0" staff="1" module="event" ordering="0">can_create_event</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="false" user="false" guest="false" staff="false" module="event" ordering="0">can_sponsor_event</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="false" user="false" guest="false" staff="false" module="event" ordering="0">can_purchase_sponsor</setting>
		<setting is_admin_setting="0" module_id="event" type="string" admin="null" user="null" guest="null" staff="null" module="event" ordering="0">event_sponsor_price</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="true" user="false" guest="false" staff="false" module="event" ordering="0">auto_publish_sponsored_item</setting>
		<setting is_admin_setting="0" module_id="event" type="integer" admin="0" user="0" guest="0" staff="0" module="event" ordering="0">flood_control_events</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="true" user="true" guest="false" staff="true" module="event" ordering="0">can_view_gmap</setting>
		<setting is_admin_setting="0" module_id="event" type="boolean" admin="true" user="true" guest="false" staff="true" module="event" ordering="0">can_add_gmap</setting>
		<setting is_admin_setting="0" module_id="event" type="integer" admin="1" user="1" guest="0" staff="1" module="event" ordering="0">points_event</setting>
	</user_group_settings>
	<tables><![CDATA[a:7:{s:12:"phpfox_event";a:3:{s:7:"COLUMNS";a:28:{s:8:"event_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_featured";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;s:5:"event";i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"location";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"country_iso";a:4:{i:0;s:6:"CHAR:2";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:16:"country_child_id";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"postal_code";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:4:"city";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"start_time";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"end_time";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"mass_email";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"start_gmt_offset";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:14:"end_gmt_offset";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:4:"gmap";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"address";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:8:"event_id";s:4:"KEYS";a:7:{s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"module_id";i:1;s:7:"item_id";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"item_id";i:3;s:10:"start_time";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"item_id";i:3;s:7:"user_id";i:4;s:10:"start_time";}}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"user_id";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"item_id";i:3;s:5:"title";}}s:9:"view_id_5";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:9:"module_id";i:3;s:7:"item_id";i:4;s:10:"start_time";}}}}s:21:"phpfox_event_category";a:3:{s:7:"COLUMNS";a:8:{s:11:"category_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"used";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"category_id";s:4:"KEYS";a:2:{s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"parent_id";i:1;s:9:"is_active";}}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_active";i:1;s:8:"name_url";}}}}s:26:"phpfox_event_category_data";a:2:{s:7:"COLUMNS";a:2:{s:8:"event_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"category_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:11:"category_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"category_id";}s:8:"event_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"event_id";}}}s:17:"phpfox_event_feed";a:3:{s:7:"COLUMNS";a:11:{s:7:"feed_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_feed_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"parent_module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"time_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"feed_id";s:4:"KEYS";a:2:{s:14:"parent_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:14:"parent_user_id";}s:11:"time_update";a:2:{i:0;s:5:"INDEX";i:1;s:11:"time_update";}}}s:25:"phpfox_event_feed_comment";a:3:{s:7:"COLUMNS";a:9:{s:15:"feed_comment_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"content";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:15:"feed_comment_id";s:4:"KEYS";a:1:{s:14:"parent_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:14:"parent_user_id";}}}s:19:"phpfox_event_invite";a:3:{s:7:"COLUMNS";a:8:{s:9:"invite_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"event_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"rsvp_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"invited_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"invited_email";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"invite_id";s:4:"KEYS";a:5:{s:8:"event_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"event_id";}s:10:"event_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"event_id";i:1;s:15:"invited_user_id";}}s:15:"invited_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:15:"invited_user_id";}s:10:"event_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"event_id";i:1;s:7:"rsvp_id";i:2;s:15:"invited_user_id";}}s:7:"rsvp_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"rsvp_id";i:1;s:15:"invited_user_id";}}}}s:17:"phpfox_event_text";a:2:{s:7:"COLUMNS";a:3:{s:8:"event_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:18:"description_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:8:"event_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"event_id";}}}}]]></tables>
	<install><![CDATA[
		$aCategories = array(
			'Arts',
			'Party',
			'Comedy',			
			'Sports',			
			'Music',
			'TV',
			'Movies',
			'Other'
		);		
		
		$iCategoryOrder = 0;
		foreach ($aCategories as $sCategory)
		{
			$iCategoryOrder++;
			$iCategoryId = $this->database()->insert(Phpfox::getT('event_category'), array(					
					'name' => $sCategory,					
					'is_active' => 1,
					'ordering' => $iCategoryOrder			
				)
			);			
		}
	]]></install>
</module>