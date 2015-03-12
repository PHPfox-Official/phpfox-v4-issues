<module>
	<data>
		<module_id>custom</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_custom</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="custom" is_hidden="0" type="boolean" var_name="hide_custom_fields_when_empty" phrase_var_name="setting_hide_custom_fields_when_empty" ordering="1" version_id="2.0.0alpha3">1</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="profile.info" module_id="custom" component="cf_about_me" location="2" is_active="1" ordering="2" disallow_access="" can_move="1">
			<title>About Me (Custom)</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="custom" component="cf_who_i_d_like_to_meet" location="2" is_active="1" ordering="3" disallow_access="" can_move="1">
			<title><![CDATA[Who I&#039;d Like to Meet (Custom)]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="custom" component="panel" location="4" is_active="0" ordering="10" disallow_access="" can_move="1">
			<title>Custom Fields for Profile Panel</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="custom" component="cf_movies" location="2" is_active="1" ordering="5" disallow_access="" can_move="1">
			<title>Custom Movies</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="custom" component="cf_drinker" location="4" is_active="1" ordering="11" disallow_access="" can_move="1">
			<title>Drinker</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="custom" component="cf_smoker" location="4" is_active="1" ordering="12" disallow_access="" can_move="1">
			<title>Smoker</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="custom" component="cf_interests" location="2" is_active="1" ordering="6" disallow_access="" can_move="1">
			<title>Interests</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="profile.info" module_id="custom" component="cf_music" location="2" is_active="1" ordering="7" disallow_access="" can_move="1">
			<title>Music</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="custom" hook_type="controller" module="custom" call_name="custom.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="controller" module="custom" call_name="custom.component_controller_admincp_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="controller" module="custom" call_name="custom.component_controller_admincp_group_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="controller" module="custom" call_name="custom.component_controller_admincp_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="component" module="custom" call_name="custom.component_block_panel_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="component" module="custom" call_name="custom.component_block_form_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="component" module="custom" call_name="custom.component_block_display_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="component" module="custom" call_name="custom.component_block_group_form_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="component" module="custom" call_name="custom.component_block_entry_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_custom__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_group_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_group_group__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_process_updatefields" added="1240688954" version_id="2.0.0beta1" />
		<hook module_id="custom" hook_type="component" module="custom" call_name="custom.component_ajax_edit" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="custom" hook_type="component" module="custom" call_name="custom.component_block_block_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_relation_process_updaterelationship__1" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_relation_process__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="custom" hook_type="service" module="custom" call_name="custom.service_custom_getforedit_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="custom" hook_type="component" module="custom" call_name="custom.component_ajax_updatefields__1" added="1363075699" version_id="3.5.0" />
	</hooks>
	<components>
		<component module_id="custom" component="panel" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="display" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="cf_about_me" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="cf_who_i_d_like_to_meet" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="cf_movies" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="cf_drinker" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="cf_smoker" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="cf_interests" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="cf_music" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
		<component module_id="custom" component="cf_college" m_connection="" module="custom" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="module_custom" added="1238394705">Custom Fields</phrase>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="user_setting_can_edit_own_custom_field" added="1238403255">Can edit own custom fields?</phrase>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="user_setting_can_edit_other_custom_fields" added="1238403455">Can edit other custom fields?</phrase>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="admin_menu_add_custom_field" added="1238430261">Add Custom Field</phrase>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="admin_menu_manage_custom_fields" added="1238611269">Manage Custom Fields</phrase>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="user_setting_can_add_custom_fields" added="1238611534">Can add new custom fields?</phrase>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="setting_hide_custom_fields_when_empty" added="1238613571"><![CDATA[<title>Hide Empty Custom Fields (Users Profile)</title><info>Define if we should hide custom fields that are empty when a user is viewing their profile without visiting the design page.</info>]]></phrase>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="admin_menu_add_custom_group" added="1238665028">Add Custom Group</phrase>
		<phrase module_id="custom" version_id="2.0.0alpha3" var_name="user_setting_can_add_custom_fields_group" added="1238665815">Can add a group for custom fields?</phrase>
		<phrase module_id="custom" version_id="2.0.0beta1" var_name="user_setting_has_special_custom_fields" added="1240596597">Can have special custom fields?</phrase>
		<phrase module_id="custom" version_id="2.0.0beta1" var_name="user_setting_custom_table_name" added="1240597480">Custom field database table name?</phrase>
		<phrase module_id="custom" version_id="2.0.0beta1" var_name="admincp_custom_fields" added="1241342492">Custom Fields</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="nothing_added_yet_click_to_edit" added="1254382815"><![CDATA[Nothing added yet. Click <a href="#" onclick="{link}">here</a> to edit.]]></phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="select_a_product_this_custom_field_will_belong_to" added="1254383181">Select a product this custom field will belong to.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="select_a_module_this_custom_field_will_belong_to" added="1254383838">Select a module this custom field will belong to.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="select_where_this_custom_field_should_be_located" added="1254383854">Select where this custom field should be located.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="group_successfully_updated" added="1254383870">Group successfully updated.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="group_successfully_added" added="1254383896">Group successfully added.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="add_a_new_custom_group" added="1254383958">Add a New Custom Group</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="select_what_type_of_custom_field_this_is" added="1254384409">Select what type of custom field this is.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="field_successfully_updated" added="1254384441">Field successfully updated.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="field_successfully_added" added="1254384461">Field successfully added.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="add_a_new_custom_field" added="1254384520">Add a New Custom Field</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="custom_group_successfully_deleted" added="1254384555">Custom group successfully deleted.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="custom_fields_successfully_updated" added="1254384566">Custom fields successfully updated.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="manage_custom_fields" added="1254384579">Manage Custom Fields</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="provide_a_module_for_this_group_to_belong_to" added="1254384647">Provide a module for this group to belong to.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="provide_a_name_for_this_group" added="1254384681">Provide a name for this group.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="there_is_already_a_group_with_the_same_name" added="1254384698">There is already a group with the same name.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="unable_to_find_the_custom_group" added="1254384946">Unable to find the custom group.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="unable_to_find_the_group_you_plan_on_deleting" added="1254384964">Unable to find the group you plan on deleting.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="not_a_valid_custom_field_to_edit" added="1254385041">Not a valid custom field to edit.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="you_do_not_have_permission_to_edit_this_field" added="1254385054">You do not have permission to edit this field.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="updating" added="1254385075">Updating</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="cancel" added="1254385096">cancel</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="provide_a_name_for_the_custom_field" added="1254385184">Provide a name for the custom field.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="name_of_this_custom_field_is_already_in_use" added="1254385200">Name of this custom field is already in use.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="not_a_valid_type_of_custom_field" added="1254385228">Not a valid type of custom field.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="you_have_selected_that_this_field_is_a_select_custom_field_which_requires_at_least_one_option" added="1254385243"><![CDATA[You have selected that this field is a "select" custom field, which requires at least one option.]]></phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="unable_to_find_the_custom_field" added="1254385584">Unable to find the custom field.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="unable_to_find_the_custom_field_you_want_to_delete" added="1254385593">Unable to find the custom field you want to delete.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="unable_to_find_the_custom_option_you_plan_on_deleting" added="1254385607">Unable to find the custom option you plan on deleting.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="are_you_sure_you_want_to_delete_this_custom_option" added="1254385722">Are you sure you want to delete this custom option?

Note that anyone using this option will revert to using the default option set for this custom field.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="select" added="1254387580">Select</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="no_answer" added="1254387590">No Answer</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="group_details" added="1254387601">Group Details</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="location" added="1254387608">Location</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="user_group" added="1254387623">User Group</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="select_only_if_you_want_a_specific_user_group_to_have_special_custom_fields" added="1254387639">Select only if you want a specific user group to have special custom fields.</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="group" added="1254387647">Group</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="add_group" added="1254387667">Add Group</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="cancel_uppercase" added="1254387686">Cancel</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="field_details" added="1254387694">Field Details</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="create_a_new_group" added="1254388379">Create a New Group</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="required" added="1254388430">Required</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="yes" added="1254388436">Yes</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="no" added="1254388445">No</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="type" added="1254388454">Type</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="large_text_area" added="1254388469">Large Text Area</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="small_text_area_255_characters_max" added="1254388477">Small Text Area (255 Characters Max)</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="selection" added="1254388483">Selection</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="field_name_amp_values" added="1254388493"><![CDATA[Field Name &amp; Values]]></phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="name" added="1254388502">Name</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="current_values" added="1254388513">Current Values</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="option_count" added="1254388554">Option {count}</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="values" added="1254388568">Values</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="option_html_count" added="1254388585"><![CDATA[Option <span class="js_option_count"></span>]]></phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="add_new_option" added="1254388596">Add New Option</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="update" added="1254388602">Update</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="add" added="1254388609">Add</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="edit" added="1254388627">Edit</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="set_to_inactive" added="1254388637">Set to Inactive</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="delete" added="1254388643">Delete</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="custom_fields" added="1254388653">Custom Fields</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="general" added="1254388664">General</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="update_order" added="1254388687">Update Order</phrase>
		<phrase module_id="custom" version_id="2.0.0rc3" var_name="no_custom_fields_have_been_added" added="1254388696">No custom fields have been added.</phrase>
		<phrase module_id="custom" version_id="2.0.0" var_name="include_on_registration" added="1261424334">Include on Registration</phrase>
		<phrase module_id="custom" version_id="2.0.4" var_name="user_setting_can_manage_custom_fields" added="1267027044">Can manage custom fields?</phrase>
		<phrase module_id="custom" version_id="2.0.5" var_name="submit" added="1273137049">Submit</phrase>
		<phrase module_id="custom" version_id="2.0.7" var_name="table_does_not_exist" added="1288716106">The table you are attempting to use ({sTableName}) does not exist. Please go to your database manager and create the table.</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="user_setting_can_have_relationship" added="1305879106">Can members of this user group define their relationship status?</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="admin_menu_manage_relationships" added="1305879144">Manage Relationship Statuses</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_blank" added="1305882451" />
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_single" added="1305882680">Single</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_engaged" added="1305882691">Engaged</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_married" added="1305882698">Married</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_it_s_complicated" added="1305882857"><![CDATA[It's complicated]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_in_an_open_relationship" added="1305882905">In an open relationship</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_widowed" added="1305882984">Widowed</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_separated" added="1305882992">Separated</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_divorced" added="1305883008">Divorced</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="relationship_status" added="1305884797">Relationship Status:</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_single_new" added="1306403775">is single</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="user_is_no_longer_listed_as" added="1306412736"><![CDATA[is no longer listed as "{previous}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_engaged_new" added="1306413530">is engaged</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_engaged_with" added="1306413743">is engaged to {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_married_with" added="1306415046">is married to {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_married_new" added="1306415429">is married</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_it_s_complicated_new" added="1306417354"><![CDATA[is in a relationship and it's complicated]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_it_s_complicated_with" added="1306418181">is in a complicated relationship with {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_in_an_open_relationship_new" added="1306418345">is in an open relationship</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_in_an_open_relationship_with" added="1306477750">is in an open relationship with {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_widowed_new" added="1306482879">has lost {their} loved one</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_custom_relation_separated_with" added="1306744450">is no longer with {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_custom_relation_separated_new" added="1306744460">is no longer with {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_separated_with" added="1306744557">is no longer with {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_separated_new" added="1306744557">is no longer with {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_divorced_with" added="1306744851">is now divorced</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_divorced_new" added="1306744851" />
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_cheating_with" added="1306744882">is cheating on his relationship with {with_full_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_cheating_new" added="1306744882">is being unfaithful</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_blank_with" added="1306744911">is no longer listed as {previous_status}</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_blank_new" added="1306744911" />
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_in_a_relationship" added="1309168519">In a relationship</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_in_a_relationship_with" added="1309168519">{full_name} is in a relationship</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="custom_relation_in_a_relationship_new" added="1309168519">{full_name} is in a relationship</phrase>
		<phrase module_id="custom" version_id="3.0.0beta1" var_name="relation_went_from_old_status_to_new_status" added="1309169257"><![CDATA[went from being "{sOldStatus}" to "{sNewStatus}"]]></phrase>
		<phrase module_id="custom" version_id="" var_name="custom_relation_single_with" added="1309169257">is Single</phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="could_not_delete" added="1319184040">Could not delete</phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_liked_your_change_on_phrase_var_name" added="1319533243"><![CDATA[{full_name} liked your change on "{phrase_var_name}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_liked_your_change_on_message" added="1319533321"><![CDATA[{full_name} liked your change on "<a href="{link}">{phrase_var_name}</a>"
To view this update follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_liked_your_change_in_relationship_title" added="1319533383"><![CDATA[{full_name} liked your change in relationship "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_liked_your_change_in_relationship_message" added="1319534017"><![CDATA[{full_name} liked your change in relationship "<a href="{link}">{title}</a>"
To view this follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_liked_your_photo_title" added="1319535072"><![CDATA[{full_name} liked your photo "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_liked_your_photo_message" added="1319535150"><![CDATA[{full_name} liked your photo "<a href="{link}">{title}</a>"
To view this photo follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_liked_your_photo_album_name" added="1319535205"><![CDATA[{full_name} liked your photo album "{name}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_liked_your_photo_album_message" added="1319535835"><![CDATA[{full_name} liked your photo album "<a href="{link}">{name}</a>"
To view this photo album follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_liked_gender_own_profile_update_title" added="1319542994"><![CDATA[{users} liked {gender} own profile update "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_liked_your_profile_update_title" added="1319543032"><![CDATA[{users} liked your profile update "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_row_full_name" added="1319543079"><![CDATA[{users} liked <span class="drop_data_user">{row_full_name}'s</span> profile update "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="name_commented_on_your_profile_update_title" added="1319543288"><![CDATA[{name} commented on your profile update "{title}".]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="name_commented_on_your_profile_update_a_href_link_content_a" added="1319543350"><![CDATA[{name} commented on your profile_update "<a href="{link}">{content}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="name_commented_on_gender_profile_update" added="1319543391">{name} commented on {gender} profile update.</phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="name_commented_on_full_name_s_profile_update" added="1319543433"><![CDATA[{name} commented on {full_name}'s profile update.]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="user_commented_on_gender_profile_update_message" added="1319543511"><![CDATA[{user} commented on {gender} profile update "<a href="{link}">{content}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="name_commented_on_full_name_s_profile_update_message" added="1319543604"><![CDATA[{name} commented on {full_name}'s profile update "<a href="{link}">{content}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1319543675">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_commented_on_gender_album_title" added="1319543768"><![CDATA[{users} commented on {gender} album "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_commented_on_your_relationship_status_title" added="1319543805"><![CDATA[{users} commented on your relationship status "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_commented_on_span_class_drop_data_user_full_name_s_span_relationship_status_title" added="1319543843"><![CDATA[{users} commented on <span class="drop_data_user">{full_name}'s</span> relationship status "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_liked_gender_own_relationship_status_title" added="1319543942"><![CDATA[{users} liked {gender} own relationship status "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_liked_your_relationship_status_title" added="1319543985"><![CDATA[{users} liked your relationship status "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_full_name_s_span_relationship_status_title" added="1319544025"><![CDATA[{users} liked <span class="drop_data_user">{full_name}'s</span> relationship status "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="import_custom_fields" added="1319544058">Import Custom Fields</phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="invalid_callback_on_comment" added="1319544079">Invalid callback on comment.</phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_commented_on_your_profile_update_title" added="1319544106"><![CDATA[{full_name} commented on your profile update "{title}".]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_commented_on_your_profile_update_message" added="1319544208"><![CDATA[{full_name} commented on your profile update "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_commented_on_gender_profile_update" added="1319544257">{full_name} commented on {gender} profile update.</phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_commented_on_row_full_name_s_video" added="1319544297"><![CDATA[{full_name} commented on {row_full_name}'s video.]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_commented_on_gender_profile_update_message" added="1319544379"><![CDATA[{full_name} commented on {gender} profile update "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="full_name_commented_on_row_full_name_s_profile_update" added="1319544494"><![CDATA[{full_name} commented on {row_full_name}'s profile update "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_commented_on_gender_profile_update_title" added="1319545221"><![CDATA[{users} commented on {gender} profile update "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_commented_on_your_profile_update_title" added="1319545268"><![CDATA[{users} commented on your profile update "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0beta5" var_name="users_commented_on_span_class_drop_data_user_row_full_name_s_span_profile_update_title" added="1319545739"><![CDATA[{users} commented on <span class="drop_data_user">{row_full_name}'s</span> profile update "{title}"]]></phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="relationship_status_confirmed" added="1321349812">Relationship status confirmed</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="full_name_and_full_name_with_are_now_phrase_var_name" added="1321349847">{full_name} and {full_name_with} are now {phrase_var_name}</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="add_status" added="1321349975">Add Status</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="you_can_add_a_language_phrase_if_you_enter_it_like_this" added="1321349987">You can add a language phrase if you enter it like this</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="otherwise_the_script_will_create_the_language_phrase_for_you" added="1321349995">Otherwise the script will create the language phrase for you</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="feed_when_confirmed" added="1321350003">Feed when confirmed</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="this_is_the_message_for_the_feed_when_the_relationship_has_been_confirmed" added="1321350014"><![CDATA[This is the message for the feed when the relationship has been confirmed.
				In some cases this feed is not needed and leaving this field blank will stop the feed from showing.
				For example "user1 is married to user2".]]></phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="feed_before_confirming" added="1321350023">Feed before confirming</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="this_message_will_be_shown_in_the_feed_when_a_user_has_set_a_relationship" added="1321350037"><![CDATA[This message will be shown in the feed when a user has set a relationship status with another user but 
				the other user has not confirmed it. It also applies when a user sets the status without defining another user.
				For example "user1 is married".]]></phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="requires_confirmation" added="1321350054">Requires Confirmation</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="if_this_field_is_enabled_this_relationship_status_requires_that_both_users_agree_on_displaying_their_relationship" added="1321350066">If this field is enabled this relationship status requires that both users agree
			       on displaying their relationship.</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="for_all_these_phrases_the_following_transformations_apply" added="1321350079">For all these phrases the following transformations apply</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="user_name_of_the_receiving_party" added="1321350086">user name of the receiving party</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="full_name_of_the_receiving_party" added="1321350093">full name of the receiving party</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="sender_s_user_name" added="1321350101"><![CDATA[sender's user name]]></phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="sender_s_full_name" added="1321350108"><![CDATA[sender's full name]]></phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="sender_s_possessive_adjective_his_her" added="1321350117"><![CDATA[sender's possessive adjective (his, her)]]></phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="edit_status" added="1321350126">Edit Status</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="manage_relationship_statuses" added="1321350143">Manage Relationship Statuses</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="status_name" added="1321350152">Status name</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="feed_when_new" added="1321350165">Feed when new</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="confirmation" added="1321350172">Confirmation</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="no_relationship_statuses_have_been_added" added="1321350187">No relationship statuses have been added.</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="status_added" added="1321350233">Status added</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="status_deleted" added="1321350243">Status deleted</phrase>
		<phrase module_id="custom" version_id="3.0.0rc2" var_name="not_found" added="1321350256">Not found</phrase>
		<phrase module_id="custom" version_id="3.1.0beta1" var_name="relationship_status_confirmation" added="1331647154">Relationship Status Confirmation</phrase>
		<phrase module_id="custom" version_id="3.1.0beta1" var_name="full_name_wants_to_list_you_both_as_phrase_var_name" added="1331647215"><![CDATA[{full_name} wants to list you both as "{phrase_var_name}"
This view all your relationship requests follow the link below:
<a href="{link}">{link}</a>]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="custom" type="boolean" admin="1" user="1" guest="0" staff="1" module="custom" ordering="0">can_edit_own_custom_field</setting>
		<setting is_admin_setting="0" module_id="custom" type="boolean" admin="1" user="0" guest="0" staff="1" module="custom" ordering="0">can_edit_other_custom_fields</setting>
		<setting is_admin_setting="0" module_id="custom" type="boolean" admin="1" user="0" guest="0" staff="1" module="custom" ordering="0">can_manage_custom_fields</setting>
		<setting is_admin_setting="0" module_id="custom" type="boolean" admin="1" user="0" guest="0" staff="1" module="custom" ordering="0">can_add_custom_fields</setting>
		<setting is_admin_setting="0" module_id="custom" type="boolean" admin="1" user="0" guest="0" staff="1" module="custom" ordering="0">can_add_custom_fields_group</setting>
		<setting is_admin_setting="0" module_id="custom" type="boolean" admin="0" user="0" guest="0" staff="0" module="custom" ordering="0">has_special_custom_fields</setting>
		<setting is_admin_setting="0" module_id="custom" type="string" admin="" user="" guest="" staff="" module="custom" ordering="0">custom_table_name</setting>
		<setting is_admin_setting="0" module_id="custom" type="boolean" admin="true" user="true" guest="false" staff="true" module="custom" ordering="0">can_have_relationship</setting>
	</user_group_settings>
	<tables><![CDATA[a:5:{s:19:"phpfox_custom_field";a:3:{s:7:"COLUMNS";a:15:{s:8:"field_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"field_name";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:13:"user_group_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"group_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"type_name";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_type";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_required";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"has_feed";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"on_signup";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"field_id";s:4:"KEYS";a:1:{s:8:"field_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"field_id";i:1;s:13:"user_group_id";}}}}s:19:"phpfox_custom_group";a:3:{s:7:"COLUMNS";a:8:{s:8:"group_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:13:"user_group_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"group_id";s:4:"KEYS";a:2:{s:13:"user_group_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:13:"user_group_id";i:1;s:7:"type_id";i:2;s:9:"is_active";}}s:15:"phrase_var_name";a:2:{i:0;s:5:"INDEX";i:1;s:15:"phrase_var_name";}}}s:20:"phpfox_custom_option";a:3:{s:7:"COLUMNS";a:3:{s:9:"option_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"field_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"option_id";s:4:"KEYS";a:1:{s:8:"field_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"field_id";}}}s:22:"phpfox_custom_relation";a:2:{s:7:"COLUMNS";a:3:{s:11:"relation_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"confirmation";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"relation_id";}s:27:"phpfox_custom_relation_data";a:3:{s:7:"COLUMNS";a:8:{s:16:"relation_data_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:11:"relation_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"with_user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"status_id";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:16:"relation_data_id";s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:12:"with_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:12:"with_user_id";}}}}]]></tables>
	<install><![CDATA[
		$aRelations = array(
			1 => array('phrase_var_name' => 'custom.custom_relation_blank', 'confirmation' => 0),
			2 => array('phrase_var_name' => 'custom.custom_relation_single', 'confirmation' => 0),
			3 => array('phrase_var_name' => 'custom.custom_relation_engaged', 'confirmation' => 1),
			4 => array('phrase_var_name' => 'custom.custom_relation_married', 'confirmation' => 1),
			5 => array('phrase_var_name' => 'custom.custom_relation_it_s_complicated', 'confirmation' => 0),
			6 => array('phrase_var_name' => 'custom.custom_relation_in_an_open_relationship', 'confirmation' => 1),
			7 => array('phrase_var_name' => 'custom.custom_relation_widowed', 'confirmation' => 0),
			8 => array('phrase_var_name' => 'custom.custom_relation_separated', 'confirmation' => 0),
			9 => array('phrase_var_name' => 'custom.custom_relation_divorced', 'confirmation' => 0),
			10 => array('phrase_var_name' => 'custom.custom_relation_in_a_relationship', 'confirmation' => 1),
		);
		foreach ($aRelations as $iId => $aRelation)
		{
			$this->database()->insert(Phpfox::getT('custom_relation'), array(
					'relation_id' => $iId,
					'phrase_var_name' => $aRelation['phrase_var_name'],
					'confirmation' => $aRelation['confirmation']
				)
			);
		}
	]]></install>
</module>