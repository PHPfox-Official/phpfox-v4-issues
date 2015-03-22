<module>
	<data>
		<module_id>input</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:33:"input.admin_menu_add_input_fields";a:1:{s:3:"url";a:2:{i:0;s:5:"input";i:1;s:3:"add";}}s:36:"input.admin_menu_manage_input_fields";a:1:{s:3:"url";a:2:{i:0;s:5:"input";i:1;s:6:"manage";}}}]]></menu>
		<phrase_var_name>module_input</phrase_var_name>
		<writable />
	</data>
	<phrases>
		<phrase module_id="input" version_id="3.4.0beta1" var_name="admin_menu_add_input_fields" added="1343992150">Add Input Fields</phrase>
		<phrase module_id="input" version_id="3.4.0beta1" var_name="module_input" added="1343992150">Input</phrase>
		<phrase module_id="input" version_id="3.4.0beta1" var_name="admin_menu_manage_input_fields" added="1344336413">Manage Input Fields</phrase>
		<phrase module_id="input" version_id="3.4.0rc1" var_name="input_name_1_656" added="1349858442">Custom Input</phrase>
		<phrase module_id="input" version_id="3.4.0rc1" var_name="input_option_1_1" added="1349858442">Value 1</phrase>
		<phrase module_id="input" version_id="3.4.0rc1" var_name="input_option_1_2" added="1349858442">Value 2</phrase>
		<phrase module_id="input" version_id="3.4.0rc1" var_name="input_option_1_3" added="1349858442">Value 3</phrase>
		<phrase module_id="input" version_id="3.4.0rc1" var_name="input_option_1_4" added="1349858442">Value 4</phrase>
		<phrase module_id="input" version_id="3.4.0rc1" var_name="advanced_filters" added="1349864681">Advanced Filters</phrase>
		<phrase module_id="input" version_id="3.4.0rc1" var_name="close" added="1349864754">Close</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="no_fields_have_been_added" added="1350910383">No fields have been added.</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="adding_a_saction" added="1350910522">Adding a {sAction}</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="you_want_to_see_this_input_when_adding_a_new" added="1350911053">You want to see this input when adding a new</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="what_type_of_input_do_you_want" added="1350911064">What type of input do you want?</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="short_text" added="1350911077">Short Text</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="long_text" added="1350911100">Long Text</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="drop_down_list" added="1350911111">Drop Down List</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="drop_down_list_with_multiple_selection" added="1350911121">Drop Down List with Multiple Selection</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="radio_list" added="1350911135">Radio List</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="marks_list" added="1350911144">Marks List</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="please_add_options_to_this_new_input" added="1350911155">Please add options to this new input</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="what_name_do_you_want_for_this_input" added="1350911167">What name do you want for this input?</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="who_should_be_able_to_add_info_to_this_input" added="1350911180">Who should be able to add info to this input</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="should_we_force_users_to_enter_a_value_here" added="1350911191">Should we force users to enter a value here?</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="update" added="1350911208">Update</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="add" added="1350911221">Add</phrase>
		<phrase module_id="input" version_id="3.4.0" var_name="new_option" added="1350911246">New Option</phrase>
		<phrase module_id="input" version_id="3.5.0beta2" var_name="add_input_field" added="1359469512">Add Input Field</phrase>
		<phrase module_id="input" version_id="3.5.0beta2" var_name="yes" added="1359469607">Yes</phrase>
		<phrase module_id="input" version_id="3.5.0beta2" var_name="no" added="1359469614">No</phrase>
	</phrases>
	<tables><![CDATA[a:6:{s:18:"phpfox_input_field";a:3:{s:7:"COLUMNS";a:7:{s:8:"field_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"phrase_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"action";a:4:{i:0;s:9:"VCHAR:100";i:1;s:14:"default-action";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_required";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"1";i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:8:"field_id";s:4:"KEYS";a:1:{s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"module_id";}}}s:28:"phpfox_input_field_condition";a:2:{s:7:"COLUMNS";a:6:{s:9:"access_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"field_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"table_name";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"column_name";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"operand";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"full_value";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"access_id";}s:19:"phpfox_input_option";a:3:{s:7:"COLUMNS";a:4:{s:9:"option_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"field_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"phrase_var";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"ordering";a:4:{i:0;s:6:"TINT:2";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"option_id";s:4:"KEYS";a:1:{s:8:"field_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"field_id";}}}s:27:"phpfox_input_value_longtext";a:3:{s:7:"COLUMNS";a:4:{s:8:"value_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"field_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"long_value";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"value_id";s:4:"KEYS";a:1:{s:8:"field_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"field_id";i:1;s:7:"item_id";}}}}s:25:"phpfox_input_value_option";a:2:{s:7:"COLUMNS";a:4:{s:8:"value_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"field_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"option_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"value_id";}s:28:"phpfox_input_value_shorttext";a:3:{s:7:"COLUMNS";a:4:{s:8:"value_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"field_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"full_value";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"value_id";s:4:"KEYS";a:1:{s:8:"field_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"field_id";i:1;s:7:"item_id";}}}}}]]></tables>
</module>