<module>
	<data>
		<module_id>profile</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_profile</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="profile" parent_var_name="" m_connection="main_right" var_name="menu_profile" ordering="4" url_value="profile.my" version_id="2.0.0alpha1" disallow_access="a:1:{i:0;s:1:&quot;3&quot;;}" module="profile" />
		<menu module_id="profile" parent_var_name="" m_connection="profile" var_name="menu_profile" ordering="1" url_value="profile" version_id="2.0.0alpha1" disallow_access="" module="profile" />
		<menu module_id="profile" parent_var_name="" m_connection="profile.my" var_name="menu_customize_profile" ordering="4" url_value="profile.designer" version_id="2.0.0alpha3" disallow_access="" module="profile" />
		<menu module_id="profile" parent_var_name="" m_connection="profile.my" var_name="menu_my_profile" ordering="1" url_value="profile" version_id="2.0.0alpha3" disallow_access="" module="profile" />
		<menu module_id="profile" parent_var_name="" m_connection="mobile" var_name="menu_profile_profile_532c28d5412dd75bf975fb951c740a30" ordering="124" url_value="profile" version_id="3.1.0rc1" disallow_access="" module="profile" mobile_icon="small_members-profiles.gif" />
		<menu module_id="profile" parent_var_name="menu_profile" m_connection="" var_name="menu_profile_my_profile_b392d011b7f15183caf21a8bc56fd1fe" ordering="109" url_value="profile" version_id="3.0.0beta4" disallow_access="" module="profile" />
		<menu module_id="profile" parent_var_name="menu_profile" m_connection="" var_name="menu_profile_edit_profile_b392d011b7f15183caf21a8bc56fd1fe" ordering="110" url_value="user.profile" version_id="3.0.0beta4" disallow_access="" module="profile" />
		<menu module_id="profile" parent_var_name="menu_profile" m_connection="" var_name="menu_profile_edit_profile_picture_b392d011b7f15183caf21a8bc56fd1fe" ordering="111" url_value="user.photo" version_id="3.0.0beta4" disallow_access="" module="profile" />
		<menu module_id="profile" parent_var_name="menu_profile" m_connection="" var_name="menu_profile_customize_profile_b392d011b7f15183caf21a8bc56fd1fe" ordering="112" url_value="profile.designer" version_id="3.0.0beta4" disallow_access="" module="profile" />
	</menus>
	<settings>
		<setting group="" module_id="profile" is_hidden="0" type="boolean" var_name="can_drag_drop_blocks_on_profile" phrase_var_name="setting_can_drag_drop_blocks_on_profile" ordering="1" version_id="2.0.0alpha3">1</setting>
		<setting group="search_engine_optimization" module_id="profile" is_hidden="0" type="string" var_name="profile_seo_for_meta_title" phrase_var_name="setting_profile_seo_for_meta_title" ordering="5" version_id="2.0.0rc4">{full_name} - {gender_name} - {location}</setting>
		<setting group="" module_id="profile" is_hidden="0" type="boolean" var_name="can_rate_on_users_profile" phrase_var_name="setting_can_rate_on_users_profile" ordering="1" version_id="2.0.0rc8">1</setting>
		<setting group="" module_id="profile" is_hidden="0" type="boolean" var_name="show_empty_tabs" phrase_var_name="setting_show_empty_tabs" ordering="1" version_id="2.0.8">0</setting>
		<setting group="" module_id="profile" is_hidden="0" type="drop" var_name="profile_default_landing_page" phrase_var_name="setting_profile_default_landing_page" ordering="1" version_id="3.4.0beta1"><![CDATA[a:2:{s:7:"default";s:4:"wall";s:6:"values";a:2:{i:0;s:4:"wall";i:1;s:4:"info";}}]]></setting>
		<setting group="" module_id="profile" is_hidden="0" type="boolean" var_name="allow_user_select_landing" phrase_var_name="setting_allow_user_select_landing" ordering="1" version_id="3.4.0beta1">0</setting>
		<setting group="cache" module_id="profile" is_hidden="0" type="boolean" var_name="cache_blocks_design" phrase_var_name="setting_cache_blocks_design" ordering="1" version_id="3.6.0rc1">0</setting>
		<setting group="cache" module_id="profile" is_hidden="0" type="boolean" var_name="profile_caches" phrase_var_name="setting_profile_caches" ordering="2" version_id="3.6.0rc1">0</setting>
		<setting group="" module_id="profile" is_hidden="1" type="boolean" var_name="display_submenu_for_photo" phrase_var_name="setting_display_submenu_for_photo" ordering="1" version_id="3.5.0beta1">0</setting>
		<setting group="" module_id="profile" is_hidden="1" type="boolean" var_name="ajax_profile_tab" phrase_var_name="setting_ajax_profile_tab" ordering="1" version_id="2.1.0Beta1">1</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="pages.view" module_id="profile" component="logo" location="13" is_active="1" ordering="8" disallow_access="" can_move="0">
			<title>Pages Cover Photo</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="quiz.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.index" module_id="profile" component="pic" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="profile" component="info" location="2" is_active="1" ordering="1" disallow_access="" can_move="1">
			<title>Profile Info</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="profile" component="pic" location="1" is_active="1" ordering="8" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="blog.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="video.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="poll.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="marketplace.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="event.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="friend.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="pages.profile" module_id="profile" component="pic" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_header_clean" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_info" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_info_clean" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_menu_clean" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_pic_clean" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_index_process_start" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_index_clean" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="service" module="profile" call_name="profile.service_callback___call" added="1231935380" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="template" module="profile" call_name="profile.template_block_info" added="1231935457" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="template" module="profile" call_name="profile.template_block_menu" added="1232376179" version_id="2.0.0alpha1" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_my_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_design_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_panel_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_order_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="profile" hook_type="service" module="profile" call_name="profile.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="profile" hook_type="service" module="profile" call_name="profile.service_profile__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_private_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_designer_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_index_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_info_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_index_process_section" added="1276177474" version_id="2.0.5" />
		<hook module_id="profile" hook_type="service" module="profile" call_name="profile.service_callback_getnewsfeedinfo_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_index_process_after_requests" added="1286546859" version_id="2.0.7" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_header_process" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_menu_process" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_mobile_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_pic_process" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_index_set_header" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_info_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="profile" hook_type="template" module="profile" call_name="profile.template_block_menu_more" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="profile" hook_type="controller" module="profile" call_name="profile.component_controller_index_process_is_sub_section" added="1323703660" version_id="3.0.0" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_cover_clean" added="1335951260" version_id="3.2.0" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_logo_clean" added="1335951260" version_id="3.2.0" />
		<hook module_id="profile" hook_type="component" module="profile" call_name="profile.component_block_pic_start" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="profile" hook_type="service" module="profile" call_name="profile.service_profile_get_profile_menu" added="1378374384" version_id="3.7.0rc1" />
	</hooks>
	<components>
		<component module_id="profile" component="index" m_connection="profile.index" module="profile" is_controller="1" is_block="0" is_active="1" />
		<component module_id="profile" component="pic" m_connection="" module="profile" is_controller="0" is_block="1" is_active="1" />
		<component module_id="profile" component="menu" m_connection="" module="profile" is_controller="0" is_block="1" is_active="1" />
		<component module_id="profile" component="info" m_connection="" module="profile" is_controller="0" is_block="1" is_active="1" />
		<component module_id="profile" component="header" m_connection="" module="profile" is_controller="0" is_block="1" is_active="1" />
		<component module_id="profile" component="my" m_connection="profile.my" module="profile" is_controller="1" is_block="0" is_active="1" />
		<component module_id="profile" component="panel" m_connection="" module="profile" is_controller="0" is_block="1" is_active="1" />
		<component module_id="profile" component="info" m_connection="profile.info" module="profile" is_controller="1" is_block="0" is_active="1" />
		<component module_id="profile" component="logo" m_connection="" module="profile" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="profile" version_id="2.0.0alpha1" var_name="user_setting_can_post_comment_on_profile" added="1219671363">Can post comments on a users profile?</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha1" var_name="module_profile" added="1219151453">Profile</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha1" var_name="male" added="1219666172">Male</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha1" var_name="female" added="1219666198">Female</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha1" var_name="years_years_old" added="1219666274">{years} years old</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha1" var_name="menu_profile" added="1219674380">Profile</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha3" var_name="menu_my_profile" added="1238669902">My Profile</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha3" var_name="menu_customize_profile" added="1238670014">Customize Profile</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha3" var_name="user_setting_can_custom_design_own_profile" added="1238741089">Can custom design own profile?</phrase>
		<phrase module_id="profile" version_id="2.0.0alpha3" var_name="setting_can_drag_drop_blocks_on_profile" added="1238741422"><![CDATA[<title>Drag & Drop Profile Blocks</title><info>Set to <b>True</b> to enable the feature that allows users the ability to drag-and-drop blocks on their profiles and position them based on where they drop them.</info>]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc1" var_name="user_setting_display_membership_info" added="1250103786">Display membership details on a users profile?</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="gender" added="1255178004">Gender</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="birthday" added="1255178014">Birthday</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="age" added="1255178025">Age</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="last_login" added="1255178036">Last Login</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="member_since" added="1255178043">Member Since</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="membership" added="1255178049">Membership</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="profile_views" added="1255178062">Profile Views</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="rss_subscribers" added="1255178085">RSS Subscribers</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="total_rating_ratings" added="1255178113">{total_rating} Ratings</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="basic_info" added="1255178134">Basic Info</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_profile_a" added="1255178189"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">profile</a>.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_profile_a" added="1255178246"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">profile</a>.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_a_href_title_link_item_user_name_s_a_profile" added="1255178274"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{title_link}">{item_user_name}'s</a> profile.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title" added="1255178368">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_your_profile_message" added="1255178426"><![CDATA[{user_name} left you a comment on your profile.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_wrote_a_comment_on_your_a_href_profile_link_profile_a" added="1255178500"><![CDATA[<a href="{user_link}">{full_name}</a> wrote a comment on your <a href="{profile_link}">profile</a>.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="profile" added="1255178648">Profile</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="profile_info" added="1255178672">Profile Info</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="comments_on" added="1255178689">Comments on</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="on_name_s_profile" added="1255178708"><![CDATA[On {name}'s profile.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="online" added="1255178771">Online</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="rating" added="1255178802">Rating</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="send_a_message" added="1255178817">Send a Message</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="add_to_friends" added="1255178834">Add to Friends</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="add_to_your_favorites" added="1255178845">Add to your Favorites</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="add_to_favorites" added="1255178851">Add to Favorites</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="unblock_this_user" added="1255178860">Unblock this User</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="block_this_user" added="1255178873">Block this User</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="invite_to_one_of_your_groups" added="1255178890">Invite to one of your groups.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="invite_to_a_group" added="1255178899">Invite to a Group</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="instant_chat" added="1255178909">Instant Chat</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="un_feature_this_member" added="1255178918">Un-Feature this member.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="unfeature" added="1255178928">Unfeature</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="feature_this_member" added="1255178935">Feature this member.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="feature" added="1255178946">Feature</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="change_profile_picture" added="1255178958">Change Profile Picture</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="profile_is_private" added="1255178976">Profile is private.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="full_name_is_on_site_title" added="1255432580">{full_name} from {location} is on {site_title}. {meta_description_profile} {full_name} has {total_friend} friends. Sign up on {site_title} and connect with {full_name}, message {full_name} or add {full_name} as your friend.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="you_have_already_rated_this_user" added="1255432719">You have already rated this user.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="you_cannot_rate_yourself" added="1255432729">You cannot rate yourself.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="location" added="1255866561">Location</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="setting_profile_seo_for_meta_title" added="1255866678"><![CDATA[<title>Profile Title</title><info>Profile Title</info>]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_updated_their_profile_design" added="1256479461"><![CDATA[<a href="{user_link}">{full_name}</a> updated {gender} profile design.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_updated_their_profile" added="1256479947"><![CDATA[<a href="{user_link}">{full_name}</a> updated {gender} profile.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="this_user_has_been_banned" added="1256497825">This user has been banned.</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="user_setting_can_view_users_profile" added="1256498007">Can view a users profile? (Including their own profile.)</phrase>
		<phrase module_id="profile" version_id="2.0.0rc4" var_name="updates_from" added="1256500572">Updates from</phrase>
		<phrase module_id="profile" version_id="2.0.0rc8" var_name="setting_can_rate_on_users_profile" added="1258556786"><![CDATA[<title>Allow Rating of Users via Profile</title><info>Enable this option to allow your members the ability to rate other members via their profile.</info>]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc8" var_name="profile_designer" added="1258848380">Profile Designer</phrase>
		<phrase module_id="profile" version_id="2.0.0rc11" var_name="full_name_s_profile_has_been_updated" added="1259966679"><![CDATA[<a href="{user_link}">{full_name}</a>'s profile has been updated.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc11" var_name="full_name_s_profile_design_has_been_updated" added="1259966946"><![CDATA[<a href="{user_link}">{full_name}</a>'s profile design has been updated.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_recent_profile_a_href_link_design_a" added="1260461900"><![CDATA[<a href="{user_link}">{full_name}</a> likes your recent profile design.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_their_own_profile_a_href_link_design_a" added="1260462181"><![CDATA[<a href="{user_link}">{full_name}</a> liked their own profile <a href="{link}">design</a>.]]></phrase>
		<phrase module_id="profile" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_profile_a_href_link_design_a" added="1260462206"><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s profile <a href="{link}">design</a>.]]></phrase>
		<phrase module_id="profile" version_id="2.0.4" var_name="wall" added="1267545418">Wall</phrase>
		<phrase module_id="profile" version_id="2.0.4" var_name="info" added="1267545427">Info</phrase>
		<phrase module_id="profile" version_id="2.1.0Beta1" var_name="setting_ajax_profile_tab" added="1292314822"><![CDATA[<title>Ajax Profile Sections</title><info>Enable this option to load sub-sections on a users profile using AJAX.</info>]]></phrase>
		<phrase module_id="profile" version_id="2.0.8" var_name="setting_show_empty_tabs" added="1296735608"><![CDATA[<title>Show Empty Tabs</title><info>When this setting is enabled the script will show tabs for empty items in profiles, for example if a user has not yet uploaded a blog and this setting is enabled, the tab "Blogs" will still show in profiles.

If this setting is disabled there will be an extra query for each tab in profiles every time site cache is cleared.</info>]]></phrase>
		<phrase module_id="profile" version_id="3.0.0beta4" var_name="menu_profile_my_profile_b392d011b7f15183caf21a8bc56fd1fe" added="1317129003">My Profile</phrase>
		<phrase module_id="profile" version_id="3.0.0beta4" var_name="menu_profile_edit_profile_b392d011b7f15183caf21a8bc56fd1fe" added="1317129065">Edit Profile</phrase>
		<phrase module_id="profile" version_id="3.0.0beta4" var_name="menu_profile_edit_profile_picture_b392d011b7f15183caf21a8bc56fd1fe" added="1317129262">Edit Profile Picture</phrase>
		<phrase module_id="profile" version_id="3.0.0beta4" var_name="menu_profile_customize_profile_b392d011b7f15183caf21a8bc56fd1fe" added="1317129352">Customize Profile</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="edit_profile" added="1319115269">Edit Profile</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="design_profile" added="1319115276">Design Profile</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="send_message" added="1319115286">Send Message</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="confirm_friend_request" added="1319115297">Confirm Friend Request</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="more" added="1319115311">More</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="edit_friends" added="1319115320">Edit Friends</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="pending_friend_confirmation" added="1319115341">Pending Friend Confirmation</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="pending_friend_request" added="1319115347">Pending Friend Request</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="lives_in" added="1319115363">Lives in</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="age_years_old" added="1319115376">{age} years old</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="born_on_birthday" added="1319115394">Born on {birthday}</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="relationship_status" added="1319115416">Relationship status</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="message" added="1319115456">Message</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="change_picture" added="1319115749">Change Picture</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="drafts" added="1319116115">Drafts</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="blogs" added="1319116123">Blogs</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="polls" added="1319116135">Polls</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="friends" added="1319116148">Friends</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="videos" added="1319116160">Videos</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="events" added="1319116169">Events</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="guestbook" added="1319116179">Guestbook</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="listings" added="1319116189">Listings</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="music" added="1319116201">Music</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="albums" added="1319116213">Albums</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="photos" added="1319116219">Photos</phrase>
		<phrase module_id="profile" version_id="3.0.0beta5" var_name="quizzes" added="1319116230">Quizzes</phrase>
		<phrase module_id="profile" version_id="3.1.0rc1" var_name="menu_profile_profile_532c28d5412dd75bf975fb951c740a30" added="1332257954">Profile</phrase>
		<phrase module_id="profile" version_id="3.2.0beta1" var_name="user_setting_can_change_cover_photo" added="1334061288">Can change profile cover photo?</phrase>
		<phrase module_id="profile" version_id="3.3.0beta1" var_name="cover_photo" added="1339153611">Cover Photo</phrase>
		<phrase module_id="profile" version_id="3.4.0beta1" var_name="setting_profile_default_landing_page" added="1344592982"><![CDATA[<title>Default Profile Landing Page</title><info>Select what should be the default landing page for user profiles.</info>]]></phrase>
		<phrase module_id="profile" version_id="3.4.0beta1" var_name="setting_allow_user_select_landing" added="1344593926"><![CDATA[<title>Allow Users Select for Landing Page</title><info>Enable this option if you would like to allow your users.</info>]]></phrase>
		<phrase module_id="profile" version_id="3.5.0beta1" var_name="setting_display_submenu_for_photo" added="1355998784"><![CDATA[<title>Display Sub-Menu for Photos</title><info>If this setting is enabled it will display a sub menu in the profiles where users can click to view "Albums" or "Photos". 
If this setting is disabled that sub-menu will not be shown, and instead a bigger menu will be displayed on the right side. 
Please note that this is only valid if Timeline is disabled.</info>]]></phrase>
		<phrase module_id="profile" version_id="3.6.0rc1" var_name="setting_cache_blocks_design" added="1371724344"><![CDATA[<title>Profile/Dashboard Design</title><info>Stops querying the table user_dashboard, which is used to store information about the block positioning on a users profiles or dashboard.</info>]]></phrase>
		<phrase module_id="profile" version_id="3.6.0rc1" var_name="setting_profile_caches" added="1371724865"><![CDATA[<title>Profile Tracking</title><info>This cache removes the track from profiles. It goes against privacy and is very difficult to circumvent efficiently.</info>]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="profile" type="boolean" admin="1" user="1" guest="0" staff="1" module="profile" ordering="0">can_post_comment_on_profile</setting>
		<setting is_admin_setting="0" module_id="profile" type="boolean" admin="1" user="1" guest="0" staff="1" module="profile" ordering="0">can_custom_design_own_profile</setting>
		<setting is_admin_setting="0" module_id="profile" type="boolean" admin="1" user="1" guest="0" staff="1" module="profile" ordering="0">display_membership_info</setting>
		<setting is_admin_setting="0" module_id="profile" type="boolean" admin="1" user="1" guest="1" staff="1" module="profile" ordering="0">can_view_users_profile</setting>
		<setting is_admin_setting="0" module_id="profile" type="boolean" admin="1" user="1" guest="0" staff="1" module="profile" ordering="0">can_change_cover_photo</setting>
	</user_group_settings>
</module>