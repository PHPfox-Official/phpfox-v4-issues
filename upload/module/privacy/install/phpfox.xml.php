<module>
	<data>
		<module_id>privacy</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_privacy</phrase_var_name>
		<writable />
	</data>
	<hooks>
		<hook module_id="privacy" hook_type="controller" module="privacy" call_name="privacy.component_controller_invalid_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="privacy" hook_type="service" module="privacy" call_name="privacy.service_privacy_get_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="privacy" hook_type="service" module="privacy" call_name="privacy.service_privacy_get_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="privacy" hook_type="service" module="privacy" call_name="privacy.service_privacy__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="privacy" hook_type="service" module="privacy" call_name="privacy.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="privacy" hook_type="controller" module="privacy" call_name="privacy.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="privacy" hook_type="component" module="privacy" call_name="privacy.component_block_list_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="privacy" hook_type="service" module="privacy" call_name="privacy.service_privacy_get" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="privacy" hook_type="service" module="privacy" call_name="privacy.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="privacy" hook_type="component" module="privacy" call_name="privacy.component_block_build_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="privacy" hook_type="component" module="privacy" call_name="privacy.component_block_form_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="privacy" hook_type="component" module="privacy" call_name="privacy.component_block_friend_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="privacy" hook_type="service" module="privacy" call_name="privacy.service_privacy_getphrase" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="privacy" hook_type="component" module="privacy" call_name="privacy.component_block_form_process" added="1358258443" version_id="3.5.0beta1" />
	</hooks>
	<components>
		<component module_id="privacy" component="invalid" m_connection="privacy.invalid" module="privacy" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="privacy" version_id="2.0.0alpha1" var_name="user_setting_can_set_allow_list_on_blogs" added="1214436510"><![CDATA[Can set an "Allow List" when adding a new blog?

Note: This setting will give the user the feature to add a list of users that can view their blog.]]></phrase>
		<phrase module_id="privacy" version_id="2.0.0alpha1" var_name="module_privacy" added="1222250493">Privacy</phrase>
		<phrase module_id="privacy" version_id="2.0.0rc4" var_name="update_preferred_list" added="1255177946">Update Preferred List</phrase>
		<phrase module_id="privacy" version_id="2.0.0rc4" var_name="insufficient_permissions" added="1255177963">Insufficient Permissions</phrase>
		<phrase module_id="privacy" version_id="2.1.0Beta1" var_name="user_setting_can_view_all_items" added="1293441281">Can view all items regardless of privacy settings?</phrase>
		<phrase module_id="privacy" version_id="2.1.0Beta1" var_name="user_setting_can_comment_on_all_items" added="1293441385">Can comment on all items regardless of privacy settings?</phrase>
		<phrase module_id="privacy" version_id="3.0.0beta5" var_name="everyone" added="1319114129">Everyone</phrase>
		<phrase module_id="privacy" version_id="3.0.0beta5" var_name="friends" added="1319114135">Friends</phrase>
		<phrase module_id="privacy" version_id="3.0.0beta5" var_name="friends_of_friends" added="1319114142">Friends of Friends</phrase>
		<phrase module_id="privacy" version_id="3.0.0beta5" var_name="only_me" added="1319114152">Only Me</phrase>
		<phrase module_id="privacy" version_id="3.0.0beta5" var_name="custom_span_click_to_edit_span" added="1319114162"><![CDATA[Custom<span>(Click to Edit)</span>]]></phrase>
		<phrase module_id="privacy" version_id="3.0.0beta5" var_name="custom_privacy" added="1319122188">Custom Privacy</phrase>
		<phrase module_id="privacy" version_id="3.0.0rc2" var_name="you_have_not_created_a_custom_friends_list_yet" added="1321349481"><![CDATA[You have not created a custom friends' list yet. Create one below to control your custom privacy settings.]]></phrase>
		<phrase module_id="privacy" version_id="3.0.0rc2" var_name="create_a_new_friends_list_to_fully_control_your_contents_privacy" added="1321349489">Create a new friends list to fully control your contents privacy.</phrase>
		<phrase module_id="privacy" version_id="3.0.0rc2" var_name="add_friends_to_your_custom_list_below" added="1321349504"><![CDATA[Add friends' to your custom list below.]]></phrase>
		<phrase module_id="privacy" version_id="3.0.0rc2" var_name="save" added="1321349515">Save</phrase>
		<phrase module_id="privacy" version_id="3.0.0rc2" var_name="search_friends_by_their_name" added="1321365293">Search friends by their name...</phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="custom" added="1322467095">Custom</phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="select_a_custom_friends_list_if_you_want_to_add_privacy_to_your_item" added="1322737764"><![CDATA[Select a custom friends' list if you want to add privacy to your item.]]></phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="custom_friends_list_successfully_created" added="1322737780">Custom friends list successfully created.</phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="select_from_your_custom_friends_list" added="1322737789">Select from your custom friends list.</phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="or_create_a_new_list" added="1322737805">or create a new list</phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="item_section_privacy" added="1323088013">Item/Section Privacy</phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="the_item_or_section_you_are_trying_to_view_has_specific_privacy_settings_enabled_and_cannot_be_viewed_at_this_time" added="1323088056">The item or section you are trying to view has specific privacy settings enabled and cannot be viewed at this time.</phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="go_back" added="1323088065">Go back</phrase>
		<phrase module_id="privacy" version_id="3.0.0" var_name="go_to_our_homepage" added="1323088074">Go to our homepage</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="privacy" type="boolean" admin="1" user="1" guest="0" staff="1" module="privacy" ordering="11">can_set_allow_list_on_blogs</setting>
		<setting is_admin_setting="0" module_id="privacy" type="boolean" admin="1" user="0" guest="0" staff="1" module="privacy" ordering="0">can_view_all_items</setting>
		<setting is_admin_setting="0" module_id="privacy" type="boolean" admin="1" user="0" guest="0" staff="1" module="privacy" ordering="0">can_comment_on_all_items</setting>
	</user_group_settings>
	<tables><![CDATA[a:1:{s:14:"phpfox_privacy";a:3:{s:7:"COLUMNS";a:6:{s:10:"privacy_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"friend_list_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"privacy_id";s:4:"KEYS";a:2:{s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"module_id";i:1;s:7:"item_id";}}s:14:"friend_list_id";a:2:{i:0;s:5:"INDEX";i:1;s:14:"friend_list_id";}}}}]]></tables>
</module>