<module>
	<data>
		<module_id>theme</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_theme</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:9:"file/css/";}]]></writable>
	</data>
	<hooks>
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_sample_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="theme" hook_type="service" module="theme" call_name="theme.service_theme__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="theme" hook_type="service" module="theme" call_name="theme.service_template_template__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="theme" hook_type="service" module="theme" call_name="theme.service_template_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_style_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_logo_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_select_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="theme" hook_type="service" module="theme" call_name="theme.service_style_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="theme" hook_type="service" module="theme" call_name="theme.service_style_style__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="theme" hook_type="component" module="theme" call_name="theme.component_block_design_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_import_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_file_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_style_import_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_style_export_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_style_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_style_css_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_style_css_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_template_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_admincp_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="controller" module="theme" call_name="theme.component_controller_index_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="service" module="theme" call_name="theme.service_process__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="service" module="theme" call_name="theme.service_callback__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="theme" hook_type="service" module="theme" call_name="theme.service_style_getstyles__1" added="1363075699" version_id="3.5.0" />
	</hooks>
	<components>
		<component module_id="theme" component="ajax" m_connection="" module="theme" is_controller="0" is_block="0" is_active="1" />
		<component module_id="theme" component="sample" m_connection="theme.sample" module="theme" is_controller="1" is_block="0" is_active="1" />
		<component module_id="theme" component="admincp.index" m_connection="" module="theme" is_controller="0" is_block="0" is_active="1" />
		<component module_id="theme" component="admincp.template" m_connection="" module="theme" is_controller="0" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="theme" version_id="2.0.0alpha1" var_name="user_setting_can_view_theme_sample" added="1216065545">Can view block layout for themes within the Admin Control Panel?</phrase>
		<phrase module_id="theme" version_id="2.0.0alpha1" var_name="module_theme" added="1216065167">Theme Management</phrase>
		<phrase module_id="theme" version_id="2.0.0rc1" var_name="admincp_menu_create_theme" added="1248279775">Create Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc1" var_name="admincp_menu_create_style" added="1248283393">Create Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc1" var_name="create_a_new_template" added="1248370729">Create a New Template</phrase>
		<phrase module_id="theme" version_id="2.0.0rc1" var_name="admincp_create_css_file" added="1248427439">Create CSS File</phrase>
		<phrase module_id="theme" version_id="2.0.0rc1" var_name="admincp_menu_import_themes" added="1249416443">Import Themes</phrase>
		<phrase module_id="theme" version_id="2.0.0rc1" var_name="admincp_menu_import_styles" added="1249416519">Import Styles</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="last_modified_time_stamp_by_full_name" added="1255341569">Last modified {time_stamp} by {full_name}</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="css_file_successfully_added" added="1255341673">CSS file successfully added.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="not_a_valid_style" added="1255341684">Not a valid style.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="edit_css" added="1255341692">Edit CSS</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="themes" added="1255341702">Themes</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="styles" added="1255341707">Styles</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="editing_style" added="1255341724">Editing Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="create_new_style" added="1255341735">Create New Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="style_successfully_updated" added="1255342251">Style successfully updated.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="style_successfully_added" added="1255342260">Style successfully added.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="create_style" added="1255342279">Create Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="import_styles" added="1255342298">Import Styles</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="style_successfully_imported" added="1255342393">Style successfully imported.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="not_a_valid_theme" added="1255342410">Not a valid theme.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="style_successfully_deleted" added="1255342418">Style successfully deleted.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="managing_styles_for" added="1255342425">Managing styles for</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="logo_successfully_reverted" added="1255342457">Logo successfully reverted.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="logo_successfully_uploaded" added="1255342467">Logo successfully uploaded.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="change_site_logo" added="1255342474">Change Site Logo</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="change_logo" added="1255342493">Change Logo</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="template_successfully_added" added="1255342506">Template successfully added.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="create_new_template" added="1255342536">Create New Template</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="templates" added="1255342553">Templates</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme_successfully_updated" added="1255342573">Theme successfully updated.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme_successfully_added" added="1255342583">Theme successfully added.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="editing_theme" added="1255342590">Editing Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="create_new_theme" added="1255342598">Create New Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="create_theme" added="1255342624">Create Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme_is_not_valid" added="1255342635">Theme is not valid.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="export_theme" added="1255342643">Export Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme_successfully_imported" added="1255342668">Theme successfully imported.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="not_a_valid_theme_to_import" added="1255342677">Not a valid theme to import.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="import_themes" added="1255342684">Import Themes</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme_successfully_deleted" added="1255342706">Theme successfully deleted.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="not_a_valid_file_extension" added="1255342775">Not a valid file extension.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="unable_to_upload_image" added="1255342800">Unable to upload image.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="unable_to_find_style" added="1255342813">Unable to find style.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="style_requires_a_name" added="1255342829">Style requires a name.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="style_requires_a_folder_name" added="1255342836">Style requires a folder name.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="select_a_parent_theme_for_this_style" added="1255342843">Select a parent theme for this style.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="provide_if_the_style_is_active_or_not" added="1255342850">Provide if the style is active or not.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="provide_a_default_logo_name" added="1255342858">Provide a default logo name.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="folder_is_not_valid" added="1255342866">Folder is not valid.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="this_folder_is_already_in_use" added="1255342874"><![CDATA[This "Folder" is already in use.]]></phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="select_a_style" added="1255342895">Select a style.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="provide_a_file_name" added="1255342901">Provide a file name.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="provide_css_code" added="1255342915">Provide CSS code.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="file_name_is_not_valid" added="1255342923">File name is not valid.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="the_file_name_is_already_in_use" added="1255342931"><![CDATA[The "File Name" is already in use.]]></phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="not_a_valid_style_to_set_to_default" added="1255342990">Not a valid style to set to default.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="unable_to_find_style_sheet" added="1255343035">Unable to find style sheet.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="unable_to_find_the_style_sheet_file" added="1255343045">Unable to find the style sheet file.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="select_a_theme_for_this_template" added="1255343095">Select a theme for this template.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="select_what_type_of_a_template_this_is" added="1255343103">Select what type of a template this is.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="not_a_valid_template_to_delete" added="1255343159">Not a valid template to delete.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme_requires_a_name" added="1255343189">Theme requires a name.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme_requires_a_folder_name" added="1255343196">Theme requires a folder name.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="provide_if_the_theme_is_active_or_not" added="1255343205">Provide if the theme is active or not.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="there_is_already_a_theme_with_the_same_folder_name" added="1255343286">There is already a theme with the same folder name.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="not_a_valid_theme_to_delete" added="1255343324">Not a valid theme to delete.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="full_screen" added="1255343483">Full Screen</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="toggle" added="1255343492">Toggle</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="blocks" added="1255343499">Blocks</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="toggle_all_blocks" added="1255343507">Toggle all blocks.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="close" added="1255343514">Close</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="advanced" added="1255343533">Advanced</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="css" added="1255343540">CSS</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="use_theme" added="1255343554">Use Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="save" added="1255343567">Save</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="preview" added="1255343573">Preview</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="revert_to_default" added="1255343591">Revert To Default</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="are_you_sure_note_that_this_will_revert_all_your_changes_and_not_just_those_within_this_group" added="1255343603">Are you sure? Note that this will revert all your changes and not just those within this group.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="width" added="1255343620">Width</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="default" added="1255343632"><![CDATA[[Default]]]></phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="background" added="1255343644">Background</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="url" added="1255343670">URL</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="attach_files" added="1255343681">Attach Files</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="scroll" added="1255343687">Scroll</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="yes" added="1255343701">Yes</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="no" added="1255343707">No</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="position" added="1255343718">Position</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="repeat" added="1255343727">Repeat</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="do_not_repeat" added="1255343737">Do Not Repeat</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="across" added="1255343743">Across</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="down" added="1255343749">Down</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="tile" added="1255343755">Tile</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="font" added="1255343762">Font</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="color" added="1255343769">Color</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="family" added="1255343779">Family</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="size" added="1255343801">Size</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="style" added="1255343816">Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="weight" added="1255343826">Weight</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="text" added="1255343834">Text</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="align" added="1255343840">Align</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="transform" added="1255343851">Transform</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="decoration" added="1255343860">Decoration</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="border" added="1255343872">Border</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="padding" added="1255343939">Padding</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="reset" added="1255343959">Reset</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="css_details" added="1255344281">CSS Details</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="select" added="1255344295">Select</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="file_name" added="1255344302">File Name</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="creator" added="1255344309">Creator</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="submit" added="1255344322">Submit</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="css_files" added="1255344333">CSS Files</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="global_css" added="1255344341">Global CSS</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="revert" added="1255344362">Revert</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="delete" added="1255344368">Delete</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="style_details" added="1255344380">Style Details</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="parent_theme" added="1255344387">Parent Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="parent_style" added="1255344399">Parent Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="name" added="1255344406">Name</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="folder_name" added="1255344413">Folder Name</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="logo_image" added="1255344420">Logo Image</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="default_logo_file_name_eg_logo_png" added="1255344427">Default logo file name (eg. logo.png)</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="website" added="1255344440">Website</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="version" added="1255344447">Version</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="is_default" added="1255344455">Is Default</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="is_active" added="1255344489">Is Active</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="update" added="1255344510">Update</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="manual_install" added="1255344530">Manual Install</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme" added="1255344536">Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="created_by" added="1255344548">Created By</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="action" added="1255344559">Action</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="n_a" added="1255344568">N/A</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="install" added="1255344589">Install</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="click_to_install_this_theme" added="1255344596">Click to install this theme.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="nothing_new_to_install" added="1255344602">Nothing new to install.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="active" added="1255344625">Active</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="edit_style" added="1255344633">Edit Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="export_style" added="1255344649">Export Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="are_you_sure" added="1255344660">Are you sure?</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="remove_as_default" added="1255344669">Remove as Default</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="set_as_default" added="1255344677">Set as Default</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="deactivate" added="1255344683">Deactivate</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="activate" added="1255344688">Activate</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="no_styles_found" added="1255344698">No styles found.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="create_a_new_style" added="1255344704">Create a New Style</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="logo" added="1255344710">Logo</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="select_a_logo" added="1255344716">Select a Logo</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1255344722">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="recommended_width_height_width_x_height_pixels" added="1255344735">Recommended width/height: {width}x{height} pixels.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="automatically_resize" added="1255344755">Automatically Resize</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="current_logo" added="1255344772">Current logo</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="revert_logo" added="1255344804">Revert Logo</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="upload_logo" added="1255344818">Upload Logo</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="template_info" added="1255344826">Template Info</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="group" added="1255344831">Group</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="global_template" added="1255344837">Global Template</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="type" added="1255344901">Type</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="block" added="1255344914">Block</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="controller" added="1255344919">Controller</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="required_only_for_modular_templates" added="1255344928">Required only for modular templates.</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="html" added="1255344940">HTML</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="html_templates" added="1255344956">HTML Templates</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="global_templates" added="1255344973">Global Templates</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="controllers" added="1255344986">Controllers</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="theme_details" added="1255345026">Theme Details</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="folder" added="1255345049">Folder</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="export" added="1255345141">Export</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="export_styles" added="1255345208">Export Styles</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="download" added="1255345215">Download</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="manage" added="1255345751">Manage</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="edit_theme" added="1255345761">Edit Theme</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="edit_templates" added="1255345771">Edit Templates</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="manage_styles" added="1255345779">Manage Styles</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="recent_visitors" added="1255345946">Recent Visitors</phrase>
		<phrase module_id="theme" version_id="2.0.0rc4" var_name="default_manage" added="1255766695">Default</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="page_width" added="1260207598">Page Width</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="link" added="1260207621">Link</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="link_hover" added="1260207630">Link:Hover</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="search_bar" added="1260207639">Search Bar</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="header" added="1260207647">Header</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="menu" added="1260207656">Menu</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="menu_link" added="1260207665">Menu Link</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="menu_link_hover" added="1260207690">Menu Link:Hover</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="profile_header" added="1260207703">Profile Header</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="profile_header_link" added="1260207713">Profile Header Link</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="profile_header_link_hover" added="1260207725">Profile Header Link:Hover</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="profile_link" added="1260207735">Profile Link</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="profile_link_hover" added="1260207746">Profile Link:Hover</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="content" added="1260207757">Content</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="block_body" added="1260207770">Block Body</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="block_header" added="1260207781">Block Header</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="bottom" added="1260207790">Bottom</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="bottom_link" added="1260207800">Bottom Link</phrase>
		<phrase module_id="theme" version_id="2.0.0rc11" var_name="bottom_link_hover" added="1260207809">Bottom Link:Hover</phrase>
		<phrase module_id="theme" version_id="2.0.0" var_name="click_on_the_blocks_below_to_hide_unhide_them" added="1261162437"><![CDATA[Click on the "Blocks" below to hide/unhide them.]]></phrase>
		<phrase module_id="theme" version_id="2.0.7" var_name="creating_css_file" added="1288349553">Creating CSS File</phrase>
		<phrase module_id="theme" version_id="3.0.0beta5" var_name="add_new_block" added="1319121954">Add New Block</phrase>
		<phrase module_id="theme" version_id="3.0.0beta5" var_name="please_enable_designdnd_first" added="1319127067">Please enable DesignDND first.</phrase>
		<phrase module_id="theme" version_id="3.0.0beta5" var_name="you_are_not_allowed_to_make_use_of_this_feature" added="1319127081">You are not allowed to make use of this feature.</phrase>
		<phrase module_id="theme" version_id="3.0.0beta5" var_name="something_bad_happened" added="1319127092">Something bad happened.</phrase>
		<phrase module_id="theme" version_id="3.0.0" var_name="order_updated" added="1323096693">Order Updated</phrase>
		<phrase module_id="theme" version_id="3.0.0" var_name="select_a_block_below_and_then_drag_it_to_any_of_the_available_positions" added="1323096740">Select a block below and then drag it to any of the available positions.</phrase>
		<phrase module_id="theme" version_id="3.5.0" var_name="favorites" added="1361783592">Favorites</phrase>
		<phrase module_id="theme" version_id="3.5.0" var_name="edit" added="1361783599">Edit</phrase>
		<phrase module_id="theme" version_id="3.5.0" var_name="edit_profile" added="1361783606">Edit Profile</phrase>
		<phrase module_id="theme" version_id="3.5.0" var_name="view_more" added="1361783682">View More</phrase>
		<phrase module_id="theme" version_id="3.5.0" var_name="view_less" added="1361783688">View Less</phrase>
		<phrase module_id="theme" version_id="3.5.0" var_name="add_more" added="1361783694">Add More</phrase>
		<phrase module_id="theme" version_id="3.5.0" var_name="done" added="1361783708">Done</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="theme" type="boolean" admin="1" user="1" guest="1" staff="1" module="theme" ordering="0">can_view_theme_sample</setting>
	</user_group_settings>
	<tables><![CDATA[a:6:{s:12:"phpfox_theme";a:3:{s:7:"COLUMNS";a:11:{s:8:"theme_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"folder";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"created";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"creator";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"website";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"version";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_default";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_column";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"2";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"theme_id";s:4:"KEYS";a:3:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}s:8:"theme_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"theme_id";i:1;s:9:"is_active";}}s:6:"folder";a:2:{i:0;s:5:"INDEX";i:1;s:6:"folder";}}}s:16:"phpfox_theme_css";a:3:{s:7:"COLUMNS";a:11:{s:6:"css_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_custom";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"style_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"file_name";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"css_data";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:17:"css_data_original";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"full_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:17:"time_stamp_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"css_id";s:4:"KEYS";a:3:{s:8:"style_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"style_id";i:1;s:9:"file_name";}}s:10:"style_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:8:"style_id";}s:9:"is_custom";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_custom";i:1;s:8:"style_id";}}}}s:18:"phpfox_theme_style";a:2:{s:7:"COLUMNS";a:15:{s:8:"style_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"theme_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_default";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"folder";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"created";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"creator";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"website";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"version";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"logo_image";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"l_width";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"c_width";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"r_width";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:6:{s:10:"style_id_2";a:2:{i:0;s:6:"UNIQUE";i:1;s:8:"style_id";}s:8:"style_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"style_id";i:1;s:9:"is_active";}}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"parent_id";i:1;s:9:"is_active";}}s:10:"is_default";a:2:{i:0;s:5:"INDEX";i:1;s:10:"is_default";}s:6:"folder";a:2:{i:0;s:5:"INDEX";i:1;s:6:"folder";}}}s:23:"phpfox_theme_style_logo";a:2:{s:7:"COLUMNS";a:4:{s:7:"logo_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"style_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"logo";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"file_ext";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"logo_id";}s:21:"phpfox_theme_template";a:3:{s:7:"COLUMNS";a:12:{s:11:"template_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"is_custom";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"folder";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:4:"name";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"html_data";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:18:"html_data_original";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"full_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:17:"time_stamp_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"template_id";s:4:"KEYS";a:4:{s:8:"theme_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:6:"folder";i:1;s:7:"type_id";i:2;s:4:"name";}}s:10:"theme_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:6:"folder";i:1;s:7:"type_id";i:2;s:9:"module_id";i:3;s:4:"name";}}s:6:"folder";a:2:{i:0;s:5:"INDEX";i:1;s:6:"folder";}s:9:"is_custom";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_custom";i:1;s:6:"folder";}}}}s:18:"phpfox_theme_umenu";a:3:{s:7:"COLUMNS";a:3:{s:8:"umenu_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"menu_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"umenu_id";s:4:"KEYS";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"menu_id";}}}}}]]></tables>
	<install><![CDATA[
		$aRows = array(
			array(
				'name' => 'Default',
				'folder' => 'default',
				'created' => '1212226813',
				'is_active' => '1',
				'is_default' => '1',
				'total_column' => '3'
			),
			array(
				'name' => 'Cosmic',
				'folder' => 'cosmic',
				'created' => '1212226813',
				'is_active' => '1',
				'is_default' => '0',
				'total_column' => '3'
			),
			array(
				'name' => 'Nebula',
				'folder' => 'nebula',
				'created' => '1212226813',
				'is_active' => '1',
				'is_default' => '0',
				'total_column' => '3'
			)
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('theme'), $aInsert);
		}
		
		$aRows = array(
			array(
				'theme_id' => '1',
				'name' => 'Default',
				'folder' => 'default',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '1',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '1',
				'name' => 'Facebookish',
				'folder' => 'facebookish',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '1',
				'name' => 'Altitude',
				'folder' => 'altitude',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '2',
				'name' => 'Cosmic',
				'folder' => 'cosmic',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '1',
				'name' => 'Density',
				'folder' => 'density',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '3',
				'name' => 'Nebula',
				'folder' => 'nebula',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			)					
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('theme_style'), $aInsert);
		}
	]]></install>
</module>