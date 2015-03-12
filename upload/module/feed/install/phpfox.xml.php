<module>
	<data>
		<module_id>feed</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_feed</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="feed" parent_var_name="" m_connection="mobile" var_name="menu_feed_news_feed_532c28d5412dd75bf975fb951c740a30" ordering="116" url_value="feed" version_id="3.1.0rc1" disallow_access="" module="feed" mobile_icon="small_activity-feed.png" />
	</menus>
	<settings>
		<setting group="" module_id="feed" is_hidden="0" type="boolean" var_name="feed_only_friends" phrase_var_name="setting_feed_only_friends" ordering="0" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="feed" is_hidden="0" type="integer" var_name="feed_display_limit" phrase_var_name="setting_feed_display_limit" ordering="0" version_id="2.0.0alpha1">10</setting>
		<setting group="time_stamps" module_id="feed" is_hidden="0" type="string" var_name="feed_display_time_stamp" phrase_var_name="setting_feed_display_time_stamp" ordering="1" version_id="2.0.0alpha3">F j, Y g:i a</setting>
		<setting group="" module_id="feed" is_hidden="0" type="integer" var_name="comment_feed_cutoff" phrase_var_name="setting_comment_feed_cutoff" ordering="1" version_id="2.0.0alpha3">4</setting>
		<setting group="" module_id="feed" is_hidden="0" type="integer" var_name="cache_timeout" phrase_var_name="setting_feedcache_timeout" ordering="1" version_id="2.0.6">0</setting>
		<setting group="" module_id="feed" is_hidden="0" type="integer" var_name="total_likes_to_display" phrase_var_name="setting_total_likes_to_display" ordering="1" version_id="3.0.0Beta1">3</setting>
		<setting group="" module_id="feed" is_hidden="0" type="integer" var_name="group_duplicate_feeds" phrase_var_name="setting_group_duplicate_feeds" ordering="1" version_id="3.0.0Beta1">2</setting>
		<setting group="" module_id="feed" is_hidden="0" type="integer" var_name="refresh_activity_feed" phrase_var_name="setting_refresh_activity_feed" ordering="1" version_id="3.0.0beta1">0</setting>
		<setting group="" module_id="feed" is_hidden="0" type="integer" var_name="feed_limit_days" phrase_var_name="setting_feed_limit_days" ordering="1" version_id="3.0.0beta3">0</setting>
		<setting group="" module_id="feed" is_hidden="0" type="string" var_name="twitter_share_via" phrase_var_name="setting_twitter_share_via" ordering="1" version_id="3.0.0rc1">YourSite</setting>
		<setting group="" module_id="feed" is_hidden="0" type="boolean" var_name="force_timeline" phrase_var_name="setting_force_timeline" ordering="1" version_id="3.3.0beta1">0</setting>
		<setting group="" module_id="feed" is_hidden="0" type="boolean" var_name="can_add_past_dates" phrase_var_name="setting_can_add_past_dates" ordering="1" version_id="3.3.0beta1">1</setting>
		<setting group="" module_id="feed" is_hidden="0" type="boolean" var_name="timeline_optional" phrase_var_name="setting_timeline_optional" ordering="1" version_id="3.3.0beta1">0</setting>
		<setting group="" module_id="feed" is_hidden="0" type="boolean" var_name="add_feed_for_comments" phrase_var_name="setting_add_feed_for_comments" ordering="1" version_id="3.4.0beta1">0</setting>
		<setting group="" module_id="feed" is_hidden="0" type="boolean" var_name="enable_check_in" phrase_var_name="setting_enable_check_in" ordering="1" version_id="3.5.0beta1">0</setting>
		<setting group="cache" module_id="feed" is_hidden="0" type="boolean" var_name="force_ajax_on_load" phrase_var_name="setting_force_ajax_on_load" ordering="1" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="feed" is_hidden="0" type="boolean" var_name="cache_each_feed_entry" phrase_var_name="setting_cache_each_feed_entry" ordering="2" version_id="3.6.0rc1">0</setting>
		<setting group="" module_id="feed" is_hidden="1" type="drop" var_name="feed_time_layout" phrase_var_name="setting_feed_time_layout" ordering="0" version_id="2.0.0alpha1"><![CDATA[a:2:{s:7:"default";s:4:"days";s:6:"values";a:4:{i:0;s:4:"days";i:1;s:7:"minutes";i:2;s:5:"hours";i:3;s:6:"months";}}]]></setting>
		<setting group="" module_id="feed" is_hidden="1" type="boolean" var_name="integrate_comments_into_feeds" phrase_var_name="setting_integrate_comments_into_feeds" ordering="1" version_id="2.0.0rc2">0</setting>
		<setting group="" module_id="feed" is_hidden="1" type="boolean" var_name="allow_comments_on_feeds" phrase_var_name="setting_allow_comments_on_feeds" ordering="1" version_id="2.0.0alpha3">1</setting>
		<setting group="" module_id="feed" is_hidden="1" type="array" var_name="user_feed_display_limit" phrase_var_name="setting_user_feed_display_limit" ordering="1" version_id="2.0.0beta3"><![CDATA[s:29:"array(5, 10, 15, 20, 25, 30);";]]></setting>
		<setting group="" module_id="feed" is_hidden="1" type="boolean" var_name="allow_rating_of_feeds" phrase_var_name="setting_allow_rating_of_feeds" ordering="1" version_id="2.0.0rc4">0</setting>
		<setting group="" module_id="feed" is_hidden="1" type="boolean" var_name="enable_like_system" phrase_var_name="setting_enable_like_system" ordering="1" version_id="2.0.0rc12">1</setting>
		<setting group="" module_id="feed" is_hidden="1" type="integer" var_name="display_feeds_from" phrase_var_name="setting_display_feeds_from" ordering="0" version_id="2.0.0alpha1">30</setting>
		<setting group="" module_id="feed" is_hidden="1" type="integer" var_name="height_for_resized_videos" phrase_var_name="setting_height_for_resized_videos" ordering="1" version_id="2.1.0beta2">260</setting>
		<setting group="" module_id="feed" is_hidden="1" type="integer" var_name="width_for_resized_videos" phrase_var_name="setting_width_for_resized_videos" ordering="1" version_id="2.1.0beta2">300</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="group.view" module_id="feed" component="display" location="2" is_active="1" ordering="12" disallow_access="" can_move="0">
			<title>Group Feeds</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="core.index-member" module_id="feed" component="display" location="2" is_active="1" ordering="9" disallow_access="" can_move="0">
			<title>Activity Feed</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.index" module_id="feed" component="display" location="2" is_active="1" ordering="7" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.view" module_id="feed" component="display" location="4" is_active="1" ordering="7" disallow_access="" can_move="0">
			<title>Activity Feed</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.index" module_id="feed" component="time" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title>Feed Timeline</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="pages.view" module_id="feed" component="time" location="3" is_active="0" ordering="4" disallow_access="" can_move="0">
			<title>Feed Timeline</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="pages.view" module_id="feed" component="display" location="4" is_active="1" ordering="10" disallow_access="" can_move="0">
			<title>Feed display</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="pages.view" module_id="feed" component="time" location="2" is_active="0" ordering="9" disallow_access="" can_move="0">
			<title>Display Timeline</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="feed" hook_type="controller" module="feed" call_name="feed.component_controller_user_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="feed" hook_type="controller" module="feed" call_name="feed.component_controller_view_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_feed___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_feed__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="feed" hook_type="controller" module="feed" call_name="feed.component_controller_index_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="feed" hook_type="component" module="feed" call_name="feed.component_block_setting_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_block__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_process_add__start" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_process_add__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_process_like_notify" added="1261572640" version_id="2.0.0" />
		<hook module_id="feed" hook_type="component" module="feed" call_name="feed.component_block_display_process_flike" added="1261572640" version_id="2.0.0" />
		<hook module_id="feed" hook_type="component" module="feed" call_name="feed.component_block_like_list_clean" added="1261572640" version_id="2.0.0" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_feed_get_mobile_types" added="1267629983" version_id="2.0.4" />
		<hook module_id="feed" hook_type="controller" module="feed" call_name="feed.component_controller_view_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="feed" hook_type="component" module="feed" call_name="feed.component_ajax_getcommenttext" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="feed" hook_type="controller" module="feed" call_name="feed.component_controller_admincp_index_clean" added="1276177474" version_id="2.0.5" />
		<hook module_id="feed" hook_type="component" module="feed" call_name="feed.component_block_display_process" added="1276177474" version_id="2.0.5" />
		<hook module_id="feed" hook_type="template" module="feed" call_name="feed.template_block_entry_1" added="1286546859" version_id="2.0.7" />
		<hook module_id="feed" hook_type="template" module="feed" call_name="feed.template_block_entry_2" added="1286546859" version_id="2.0.7" />
		<hook module_id="feed" hook_type="template" module="feed" call_name="feed.template_block_entry_3" added="1286546859" version_id="2.0.7" />
		<hook module_id="feed" hook_type="controller" module="feed" call_name="feed.component_controller_user_mobile_clean" added="1288281378" version_id="2.0.7" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_feed_get_start" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_process_deletefeed" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="feed" hook_type="template" module="feed" call_name="feed.template_block_comment_border" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_feed_getsharelinks__start" added="1334069444" version_id="3.2.0beta1" />
		<hook module_id="feed" hook_type="controller" module="feed" call_name="feed.component_controller_index_feeddisplay" added="1335951260" version_id="3.2.0" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_process_add__end2" added="1335951260" version_id="3.2.0" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_process_delete__end" added="1335951260" version_id="3.2.0" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_process_addcomment__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="feed" hook_type="component" module="feed" call_name="feed.component_block_mini_clean" added="1339076699" version_id="3.3.0beta1" />
		<hook module_id="feed" hook_type="template" module="feed" call_name="feed.component_block_display_process_header" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_feed_get_userprofile" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_feed_get_buildquery" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="feed" hook_type="service" module="feed" call_name="feed.service_feed_getsharelinks__end" added="1363075699" version_id="3.5.0" />
		<hook module_id="feed" hook_type="component" module="feed" call_name="feed.component_block_loaddates_clean" added="1372931660" version_id="3.6.0" />
	</hooks>
	<components>
		<component module_id="feed" component="display" m_connection="" module="feed" is_controller="0" is_block="1" is_active="1" />
		<component module_id="feed" component="view" m_connection="feed.view" module="feed" is_controller="1" is_block="0" is_active="1" />
		<component module_id="feed" component="user" m_connection="feed.user" module="feed" is_controller="1" is_block="0" is_active="1" />
		<component module_id="feed" component="time" m_connection="" module="feed" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="feed" version_id="2.0.0alpha1" var_name="module_feed" added="1219147598">Feed</phrase>
		<phrase module_id="feed" version_id="2.0.0alpha3" var_name="setting_feed_display_time_stamp" added="1238753352"><![CDATA[<title>Feed Time Stamps</title><info>Time stamps displayed on feeds.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.0.0alpha3" var_name="user_setting_can_post_comment_on_feed" added="1238755242">Can post a comment on a feed?</phrase>
		<phrase module_id="feed" version_id="2.0.0alpha3" var_name="setting_allow_comments_on_feeds" added="1238758105"><![CDATA[<title>Allow Comments On Feeds</title><info>Set to <b>True</b> if you would like to allow comments on news feeds.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.0.0alpha3" var_name="setting_comment_feed_cutoff" added="1238758497"><![CDATA[<title>Comment Cutoff on Feeds</title><info>Define the cutoff for comments in each feed.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.0.0beta3" var_name="setting_user_feed_display_limit" added="1243628690"><![CDATA[<title>Array of Display Limits (User Selection)</title><info>This array defines what users can select to modify the global display limit of feeds on their dashboard and profile.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.0.0beta3" var_name="user_setting_can_remove_feeds_from_dashboard" added="1243629838">Can remove feeds from their dashboard?</phrase>
		<phrase module_id="feed" version_id="2.0.0beta3" var_name="user_setting_can_remove_feeds_from_profile" added="1243630626">Can remove feeds from their own profile?</phrase>
		<phrase module_id="feed" version_id="2.0.0rc2" var_name="setting_integrate_comments_into_feeds" added="1252753029"><![CDATA[<title>Allow Comments in Feeds</title><info>By enabling this option you will allow members to add comments in feeds.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="you_do_not_have_permission_to_add_a_comment_on_this_persons_profile" added="1254466421">You do not have permission to add a comment on this persons profile.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="posting_a_comment_a_little_too_soon" added="1254466440">Posting a comment a little too soon.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="add_some_text_to_your_comment" added="1254466451">Add some text to your comment.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="updates" added="1254466478">Updates</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="invalid_user" added="1254466543">Invalid user.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="missing_feed_id" added="1254466556">Missing feed ID#</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="invalid_feed_id" added="1254466565">Invalid feed ID#</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="full_name_left_you_a_comment_on_site_title" added="1254466611">{full_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="full_name_left_you_a_comment_on_site_title_to_view_this_comment" added="1254466675"><![CDATA[{full_name} left you a comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="on_name_s_feed" added="1254466723"><![CDATA[On {name}'s feed.]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="adding_your_comment" added="1254466821">Adding your comment</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="comment" added="1254466836">Comment</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="cancel" added="1254466844">cancel</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="post" added="1254466883">Post</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="view_more" added="1254466897">View More</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="user_link_wrote" added="1254467370">{user_link} wrote...</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="viewer_full_name_wrote_on_owner_full_name_s_profile" added="1254467724"><![CDATA[<a href="{viewer_user_link}">{viewer_full_name}</a> wrote on <a href="{owner_user_link}">{owner_full_name}'s</a> profile...]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="show_total_left_more_comments" added="1254468247">Show {total_left} more comments...</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="total_feeds_to_display" added="1254468363">Total feeds to display</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="save" added="1254468372">Save</phrase>
		<phrase module_id="feed" version_id="2.0.0rc3" var_name="cancel_uppercase" added="1254468388">Cancel</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="setting_allow_rating_of_feeds" added="1255781516"><![CDATA[<title>Allow Rating of Feeds</title><info>Enable this option to allow users to rate feeds.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="are_you_sure" added="1255781764">Are you sure?</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="user_setting_can_delete_own_feed" added="1255781932">Can delete own feed?</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="user_setting_can_delete_other_feeds" added="1255781966">Can delete other feeds?</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="delete" added="1255782554">Delete</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="feed_successfully_deleted" added="1255782937">Feed successfully deleted.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="owner_full_name_commented_on_full_names_feed" added="1256492983"><![CDATA[<a href="{owner_link}">{owner_full_name}</a> commented on <a href="{viewer_link}">{viewer_full_name}'s <a href="{link}">feed</a>.]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="a_href_owner_link_owner_full_name_a_commented_on_their_own_a_href_link_feed_a" added="1256493985"><![CDATA[<a href="{owner_link}">{owner_full_name}</a> commented on their own <a href="{link}">feed</a>.]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="write_a_comment" added="1256502047">Write a comment...</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="loading" added="1256542012">Loading...</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="hide" added="1256542058">Hide</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="viewing_feed_with_a_comment_id" added="1256660407">Viewing Feed with a Comment: #{id}</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="viewing_feed_id" added="1256660424">Viewing Feed: #{id}</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="view_all" added="1256660461">View All</phrase>
		<phrase module_id="feed" version_id="2.0.0rc4" var_name="full_name_commented_on_their_own_profile" added="1256661031"><![CDATA[<a href="{user_link}">{full_name}</a> wrote on their own <a href="{user_link}">profile</a>.]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc7" var_name="edit" added="1257841247">Edit</phrase>
		<phrase module_id="feed" version_id="2.0.0rc8" var_name="the_activity_feed_you_are_looking_for_does_not_exist" added="1258848578">The activity feed you are looking for does not exist.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="nobody_likes_this" added="1260439366">Nobody likes this.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="you_like_this" added="1260439664">You like this.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="people_who_like_this" added="1260439672">People who like this</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="user_link_likes_this" added="1260439694">{user_link} likes this.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="you_and_user_link_like_this" added="1260439746">You and {user_link} like this.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="and" added="1260439790">and</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="you" added="1260439797">You</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="other_person" added="1260439817">other person</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="others" added="1260439830">others</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="like_this" added="1260439841">like this</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="like" added="1260439890">Like</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="unlike" added="1260439897">Unlike</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="you_have_already_liked_this_feed" added="1260440751"><![CDATA[You have already "liked" this feed.]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="user_link_and_user_link_like_this" added="1260445733">{user_link_owner} and {user_link} like this.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="the_feed_you_are_trying_to_like_unlike_does_not_exist_any_longer" added="1260459851">The feed you are trying to like/unlike does not exist any longer.</phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_status_a" added="1260475302"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">status</a>.]]></phrase>
		<phrase module_id="feed" version_id="2.0.0rc12" var_name="setting_enable_like_system" added="1260830264"><![CDATA[<title>Enable "Like" System</title><info>With this feature enabled it will allow users to "like/unlike" certain feeds.

Not all feeds support the "like/unlike" feature.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.0.4" var_name="successfully_added_your_comment" added="1267542907">Successfully added your comment</phrase>
		<phrase module_id="feed" version_id="2.0.4" var_name="successfully_liked_this_feed" added="1267542946">Successfully liked this feed</phrase>
		<phrase module_id="feed" version_id="2.0.4" var_name="successfully_unliked_this_feed" added="1267542968">Successfully unliked this feed</phrase>
		<phrase module_id="feed" version_id="2.0.4" var_name="not_a_valid_feed" added="1267542980">Not a valid feed.</phrase>
		<phrase module_id="feed" version_id="2.0.4" var_name="total_comments" added="1267544302">{total} Comments</phrase>
		<phrase module_id="feed" version_id="2.0.4" var_name="1_comment" added="1267544350">1 Comment</phrase>
		<phrase module_id="feed" version_id="2.0.4" var_name="comments" added="1267544379">Comments</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="profile_comments" added="1275017584">Profile Comments</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="profile_comment_s_successfully_approved" added="1275019497">Profile comment(s) successfully approved.</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="nothing_to_approve_at_this_time" added="1275019538">Nothing to approve at this time.</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="profile_comment_s_successfully_deleted" added="1275019685">Profile comment(s) successfully deleted.</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="profile_feed_comments" added="1275020064">Profile Feed Comments</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="id" added="1275020070">ID#</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="owner" added="1275020076">Owner</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="profile" added="1275020082">Profile</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="posted_on" added="1275020089">Posted On</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="content" added="1275020095">Content</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="approve_selected" added="1275020108">Approve Selected</phrase>
		<phrase module_id="feed" version_id="2.0.5dev1" var_name="deny_selected" added="1275020115">Deny Selected</phrase>
		<phrase module_id="feed" version_id="2.0.6" var_name="setting_feedcache_timeout" added="1282124296"><![CDATA[<title>Cache Feeds</title><info>Value is in minutes.
This greatly improves performance on sites with a medium to large user base</info>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0Beta1" var_name="setting_total_likes_to_display" added="1295002683"><![CDATA[<title>Total Likes to Display</title><info>Define how many users should be displayed when an item/feed is Liked.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0Beta1" var_name="setting_group_duplicate_feeds" added="1296125315"><![CDATA[<title>Group Duplicate Feeds</title><info>Define how many feeds to group when a user posts a feed that is part of the same item group (eg. Photo, Blogs, Status Update etc...). If you set this to "0" (without quotes) this will not group any feeds. 

Note this feature only works on the global activity feed and not on the users profile and is designed to prevent content SPAM.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.1.0beta2" var_name="setting_height_for_resized_videos" added="1300963794"><![CDATA[<title>Height for Resized Videos</title><info>If the setting "Resize Embedded Videos" (in Content Formatting) is enabled, how tall should the embedded video be?

Please remember that this setting depends on "Resize Embedded Videos" to be enabled.</info>]]></phrase>
		<phrase module_id="feed" version_id="2.1.0beta2" var_name="setting_width_for_resized_videos" added="1300963796"><![CDATA[<title>Width for Resized Videos</title><info>If the setting "Resize Embedded Videos" (in Content Formatting) is enabled, how wide should the embedded video be?

Please remember that this setting depends on "Resize Embedded Videos" to be enabled.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta1" var_name="setting_refresh_activity_feed" added="1309267841"><![CDATA[<title>Refresh Activity Feed (Seconds)</title><info>This setting controls if you want to find new updates in the activity feed without having the user to refresh the page. This will use AJAX and the value of this setting has to be a number in seconds. If you want this feature to be disabled set it to the number zero (0).</info>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta3" var_name="setting_feed_limit_days" added="1316518935"><![CDATA[<title>Feed Limit (Days)</title><info>This setting controls how many days we should look back when displaying feeds. If you set this to 0 it will look for all the feeds. We advice to add a limit to keep your site fresh. Note that this setting does not apply when viewing a users profile as it will list all of their feeds.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="share" added="1319111584">Share</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="status" added="1319111596">Status</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="write_something" added="1319111621">Write something...</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="what_s_on_your_mind" added="1319111629"><![CDATA[What's on your mind?]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="post_as" added="1319111689">Post as</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="share_this_on" added="1319111697">Share This On</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="facebook" added="1319111703">Facebook</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="twitter" added="1319111711">Twitter</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="1_new_update" added="1319111732">1 new update</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="span_id_js_new_update_view_span_new_updates" added="1319111742"><![CDATA[<span id="js_new_update_view"></span> new updates]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="recent_activity" added="1319111752">Recent Activity</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="there_are_no_new_feeds_to_view_at_this_time" added="1319111769">There are no new feeds to view at this time.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="delete_this_feed" added="1319111801">Delete this feed</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="play" added="1319111882">Play</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="see_total_more_posts_from_full_name" added="1319111952">See {total} more posts from {full_name}</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="tweet" added="1319112008">Tweet</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="report" added="1319112027">Report</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="posted_a_blog" added="1319117943">posted a blog.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="created_a_poll" added="1319117964">created a poll.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="is_now_friends_with" added="1319118016">is now friends with</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="updated_gender_profile_photo" added="1319118045">updated {gender} profile photo.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="content_on_a_href_link_parent_full_name_a_s_a_href_wall_link_wall_a" added="1319118139"><![CDATA["{content}" on <a href="{link}">{parent_full_name}</a>'s <a href="{wall_link}">wall</a>.]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="shared_a_video" added="1319118245">shared a video</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="full_name_posted_a_href_link_a_video_a_on_a_href_profile_parent_full_name_a_s_a_href_profile_link_wall_a" added="1319118316"><![CDATA[{full_name} posted <a href="{link}">a video</a> on <a href="{profile}">{parent_full_name}</a>'s <a href="{profile_link}">wall</a>.]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="created_an_event" added="1319118398">created an event.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="created_a_listing" added="1319118416">created a listing.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="shared_a_song" added="1319118456">shared a song.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="shared_a_song_from_gender_album_a_href_album_link_album_name_a" added="1319118507"><![CDATA[shared a song from {gender} album "<a href="{album_link}">{album_name}</a>".]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="updated_gender_profile_information" added="1319118569">updated {gender} profile information.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="shared_a_photo" added="1319118611">shared a photo</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="shared_a_few_photos" added="1319118619">shared a few photos</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="added_new_photos_to_gender_album_a_href_link_name_a" added="1319118656"><![CDATA[added new photos to {gender} album "<a href="{link}">{name}</a>"]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="tagged_a_href_row_link_full_name_a_on_gender_a_href_link_photo_a" added="1319119466"><![CDATA[tagged <a href="{row_link}">{full_name}</a> on {gender} <a href="{link}">photo</a>.]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="tagged_a_href_row_link_full_name_a_on_a_href_photo_user_name_photo_full_name_a_a_href_link_photo_a" added="1319119548"><![CDATA[tagged <a href="{row_link}">{full_name}</a> on <a href="{photo_user_name}">{photo_full_name}</a> <a href="{link}">photo</a>.]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="created_a_quiz" added="1319119623">created a quiz.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="replied_on_gender_thread_a_href_link_title_a" added="1319119665"><![CDATA[replied on {gender} thread "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="replied_on_a_href_user_name_full_name_a_s_thread_a_href_link_title_a" added="1319119731"><![CDATA[replied on <a href="{user_name}">{full_name}</a>'s thread "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="posted_a_thread" added="1319119773">posted a thread.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="feed_deletion" added="1319124821">Feed Deletion</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="unable_to_delete_this_entry" added="1319124834">Unable to delete this entry.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="news_feed" added="1319551853">News Feed</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_your_wall_comments" added="1319551890">{full_name} commented on one of your wall comments.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_your_wall_comments_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1319551940"><![CDATA[{full_name} commented on one of your wall comments.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_gender_wall_comments" added="1319551977">{full_name} commented on one of {gender} wall comments.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_row_full_name_s_wall_comments" added="1319552013"><![CDATA[{full_name} commented on one of {row_full_name}'s wall comments.]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_gender_wall_comments_message" added="1319552085"><![CDATA[{full_name} commented on one of {gender} wall comments.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="full_name_commented_on_one_of_row_full_name_s_wall_comments_message" added="1319552153"><![CDATA[{full_name} commented on one of {row_full_name}'s wall comments.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1319552190">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_commented_on_one_of_gender_wall_comments" added="1319552231">{users} commented on one of {gender} wall comments</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_commented_on_one_of_your_wall_comments" added="1319552257">{users} commented on one of your wall comments</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_commented_on_one_of_span_class_drop_data_user_row_full_name_s_span_wall_comments" added="1319552284"><![CDATA[{users} commented on one of <span class="drop_data_user">{row_full_name}'s</span> wall comments]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_commented_on_gender_wall" added="1319552335">{users} commented on {gender} wall</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_commented_on_your_wall" added="1319552359">{users} commented on your wall</phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_commented_on_one_span_class_drop_data_user_row_full_name_span_wall" added="1319552385"><![CDATA[{users} commented on one <span class="drop_data_user">{row_full_name}</span> wall]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_liked_your_comment_text_that_you_posted" added="1319552432"><![CDATA[{users} liked your comment "{text}" that you posted.]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_liked_gender_own_comment_content" added="1319552518"><![CDATA[{users} liked {gender} own comment "{content}"]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_liked_your_comment_content_that_you_posted_on_span_class_drop_data_user_parent_full_name_s_span_wall" added="1319552563"><![CDATA[{users} liked your comment "{content}" that you posted on  <span class="drop_data_user">{parent_full_name}'s</span> wall]]></phrase>
		<phrase module_id="feed" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_full_name_s_span_comment_content" added="1319552639"><![CDATA[{users} liked <span class="drop_data_user">{full_name}'s</span> comment "{content}"]]></phrase>
		<phrase module_id="feed" version_id="3.0.0rc1" var_name="activity_feed" added="1320067556">Activity Feed</phrase>
		<phrase module_id="feed" version_id="3.0.0rc1" var_name="setting_twitter_share_via" added="1320229326"><![CDATA[<title>Twitter Share VIA</title><info>Provide your sites Twitter profile user name.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.0.0rc3" var_name="find_missing_share_buttons" added="1321891270"><![CDATA[Find Missing "Share" Buttons]]></phrase>
		<phrase module_id="feed" version_id="3.0.0" var_name="status_update_iid" added="1323088288">Status Update: #{iId}</phrase>
		<phrase module_id="feed" version_id="3.0.0" var_name="link_iid" added="1323088326">Link: #{iId}</phrase>
		<phrase module_id="feed" version_id="3.0.0" var_name="poke_iid" added="1323088374">Poke: #{iId}</phrase>
		<phrase module_id="feed" version_id="3.0.0" var_name="wall_comment_iid" added="1323096556">Wall Comment: #{iId}</phrase>
		<phrase module_id="feed" version_id="3.0.0" var_name="feed" added="1323096581">Feed</phrase>
		<phrase module_id="feed" version_id="3.1.0beta1" var_name="full_name_wrote_a_comment_on_your_wall" added="1331645835">{full_name} wrote a comment on your wall.</phrase>
		<phrase module_id="feed" version_id="3.1.0beta1" var_name="full_name_wrote_a_comment_on_your_wall_message" added="1331646391"><![CDATA[{full_name} wrote a comment on your <a href="{link}">wall</a>.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="feed" version_id="3.1.0rc1" var_name="menu_feed_news_feed_532c28d5412dd75bf975fb951c740a30" added="1332257737">News Feed</phrase>
		<phrase module_id="feed" version_id="3.2.0beta1" var_name="comments_on_profiles" added="1334579341">Comments on Profiles</phrase>
		<phrase module_id="feed" version_id="3.3.0beta1" var_name="shared" added="1336400814">shared...</phrase>
		<phrase module_id="feed" version_id="3.3.0beta1" var_name="successfully_shared_this_item_on_your_friends_wall" added="1336400863">Successfully shared this item on your friends wall.</phrase>
		<phrase module_id="feed" version_id="3.3.0beta1" var_name="successfully_shared_this_item" added="1336400883">Successfully shared this item.</phrase>
		<phrase module_id="feed" version_id="3.3.0beta1" var_name="setting_force_timeline" added="1337095087"><![CDATA[<title>Force Timeline</title><info>Enable this feature to force the activity feed on a users profile to use a Timeline.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.3.0beta1" var_name="setting_can_add_past_dates" added="1338364887"><![CDATA[<title>Feeds in the Past</title><info>If this option is enabled and the Timeline feature is also enabled users will be able to add feeds from their profile in the past.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.3.0beta1" var_name="setting_timeline_optional" added="1339423430"><![CDATA[<title>Timeline Optional</title><info>If the setting "Force Timeline" is disabled and this setting is enabled users can choose if they want to convert their profiles into a Timeline.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.3.0beta2" var_name="now" added="1340275631">Now</phrase>
		<phrase module_id="feed" version_id="3.3.0beta2" var_name="set_a_date" added="1340275767">Set a Date</phrase>
		<phrase module_id="feed" version_id="3.4.0beta1" var_name="setting_add_feed_for_comments" added="1347341347"><![CDATA[<title>Add Comments as Feeds</title><info>If this setting is enabled it will add comments that are added to items such as videos, blogs, photos etc... as its own feed entry.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.4.0beta1" var_name="sort" added="1347362981">Sort</phrase>
		<phrase module_id="feed" version_id="3.4.0beta1" var_name="top_stories" added="1347362989">Top Stories</phrase>
		<phrase module_id="feed" version_id="3.4.0beta1" var_name="most_recent" added="1347362995">Most Recent</phrase>
		<phrase module_id="feed" version_id="3.4.0beta1" var_name="update_feed_time_stamps" added="1347363856">Update Feed Time Stamps</phrase>
		<phrase module_id="feed" version_id="3.4.0beta1" var_name="update_feed_time_stamps_for_pages" added="1347363870">Update Feed Time Stamps for Pages</phrase>
		<phrase module_id="feed" version_id="3.4.0beta1" var_name="update_feed_time_stamps_for_events" added="1347363879">Update Feed Time Stamps for Events</phrase>
		<phrase module_id="feed" version_id="3.4.0beta2" var_name="report_this_entry" added="1348125376">Report this entry</phrase>
		<phrase module_id="feed" version_id="3.4.0beta2" var_name="posted_on_parent_full_names_wall" added="1348224324"><![CDATA[posted on <a href="{parent_user_name}">{parent_full_name}</a>&#039;s wall.]]></phrase>
		<phrase module_id="feed" version_id="3.5.0beta1" var_name="setting_enable_check_in" added="1355219746"><![CDATA[<title>Enable Check-In</title><info>If enabled users will be able to choose their location when posting a status update.

This setting also allows pages to define their location. Pages with a location defined will show up in the list of establishments when the user is posting a status update.

For this to work you need to have entered the Google API Key (<setting>google_api_key</setting></info>) or the IP Info DB Key (<setting>ip_infodb_api_key</setting>)]]></phrase>
		<phrase module_id="feed" version_id="3.5.0beta2" var_name="this_item_has_successfully_been_submitted" added="1359358153">This item has successfully been submitted. Before it can be displayed it will have to first be approved by a site Admin.</phrase>
		<phrase module_id="feed" version_id="3.5.0rc1" var_name="at_location" added="1360587003">at {location}</phrase>
		<phrase module_id="feed" version_id="3.5.0" var_name="not_here" added="1361784216">Not here?</phrase>
		<phrase module_id="feed" version_id="3.5.1" var_name="parent_user_name_commented_on_one_of_your_status_updates" added="1366634446">{parent_user_name} commented on one of your status updates</phrase>
		<phrase module_id="feed" version_id="3.6.0rc1" var_name="setting_force_ajax_on_load" added="1371726736"><![CDATA[<title>Activity Feed AJAX</title><info>Activity feed loads after the site loads via AJAX.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.6.0rc1" var_name="setting_cache_each_feed_entry" added="1371726896"><![CDATA[<title>Activity Feed Entries Cache</title><info>Cache each specific feed entry. Saves on queries to the database.</info>]]></phrase>
		<phrase module_id="feed" version_id="3.7.0beta1" var_name="user_setting_feed_sponsor_price" added="1374735438">How much does it cost to sponsor a feed post? This works in a CPM basis</phrase>
		<phrase module_id="feed" version_id="3.7.0beta1" var_name="user_setting_can_sponsor_feed" added="1374837851">Can members of this user group define a feed as sponsored without paying?</phrase>
		<phrase module_id="feed" version_id="3.7.0beta1" var_name="user_setting_auto_publish_sponsored_item" added="1374837880">Should sponsored items be published right away?</phrase>
		<phrase module_id="feed" version_id="3.7.0beta1" var_name="user_setting_can_purchase_sponsor" added="1375264862">Can members of this user group sponsor feeds?</phrase>
		<phrase module_id="feed" version_id="3.7.0beta1" var_name="sponsor_in_feed" added="1375265039">Sponsor In Feed</phrase>
		<phrase module_id="feed" version_id="3.7.0rc1" var_name="user_setting_can_view_feed" added="1377073464">Can members of this user group view feeds anywhere in the site?</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="1" user="1" guest="0" staff="1" module="feed" ordering="0">can_post_comment_on_feed</setting>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="1" user="1" guest="0" staff="1" module="feed" ordering="0">can_remove_feeds_from_dashboard</setting>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="1" user="1" guest="0" staff="1" module="feed" ordering="0">can_remove_feeds_from_profile</setting>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="1" user="1" guest="0" staff="1" module="feed" ordering="0">can_delete_own_feed</setting>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="1" user="0" guest="0" staff="1" module="feed" ordering="0">can_delete_other_feeds</setting>
		<setting is_admin_setting="0" module_id="feed" type="string" admin="0" user="0" guest="999999" staff="0" module="feed" ordering="0">feed_sponsor_price</setting>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="true" user="false" guest="false" staff="false" module="feed" ordering="0">can_sponsor_feed</setting>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="true" user="true" guest="true" staff="true" module="feed" ordering="0">auto_publish_sponsored_item</setting>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="false" user="false" guest="false" staff="false" module="feed" ordering="0">can_purchase_sponsor</setting>
		<setting is_admin_setting="0" module_id="feed" type="boolean" admin="true" user="true" guest="true" staff="true" module="feed" ordering="0">can_view_feed</setting>
	</user_group_settings>
	<tables><![CDATA[a:4:{s:11:"phpfox_feed";a:3:{s:7:"COLUMNS";a:13:{s:7:"feed_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:6:"app_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"feed_reference";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_feed_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"parent_module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"time_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"feed_id";s:4:"KEYS";a:9:{s:9:"privacy_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"privacy";i:1;s:10:"time_stamp";i:2;s:14:"feed_reference";}}s:9:"privacy_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"privacy";i:1;s:7:"user_id";i:2;s:14:"feed_reference";}}s:9:"privacy_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"privacy";i:1;s:14:"parent_user_id";i:2;s:14:"feed_reference";}}s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"type_id";i:1;s:7:"item_id";i:2;s:14:"feed_reference";}}s:7:"privacy";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"privacy";i:1;s:7:"user_id";i:2;s:10:"time_stamp";i:3;s:14:"feed_reference";}}s:10:"time_stamp";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"time_stamp";i:1;s:14:"feed_reference";}}s:11:"time_update";a:2:{i:0;s:5:"INDEX";i:1;s:11:"time_update";}s:9:"privacy_5";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"privacy";i:1;s:14:"parent_user_id";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:14:"feed_reference";i:2;s:10:"time_stamp";}}}}s:19:"phpfox_feed_comment";a:3:{s:7:"COLUMNS";a:10:{s:15:"feed_comment_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"content";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:15:"feed_comment_id";s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:14:"parent_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:14:"parent_user_id";}}}s:17:"phpfox_feed_share";a:2:{s:7:"COLUMNS";a:12:{s:8:"share_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:75";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:3:"YES";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"block_name";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"no_input";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"is_frame";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"ajax_request";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"no_profile";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"icon";a:4:{i:0;s:8:"VCHAR:30";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"ordering";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"share_id";}s:19:"phpfox_feed_sponsor";a:3:{s:7:"COLUMNS";a:4:{s:10:"sponsor_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"feed_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_views";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"time_stamp_added";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"sponsor_id";s:4:"KEYS";a:1:{s:7:"feed_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"feed_id";}}}}]]></tables>
</module>