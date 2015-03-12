<module>
	<data>
		<module_id>language</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_language</phrase_var_name>
		<writable />
	</data>
	<setting_groups>
		<name module_id="language" version_id="2.0.0alpha1" var_name="setting_group_language">language</name>
	</setting_groups>
	<settings>
		<setting group="development" module_id="language" is_hidden="0" type="boolean" var_name="lang_pack_helper" phrase_var_name="setting_lang_pack_helper" ordering="0" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="language" is_hidden="0" type="boolean" var_name="cache_phrases" phrase_var_name="setting_cache_phrases" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="language" module_id="language" is_hidden="0" type="boolean" var_name="display_language_flag" phrase_var_name="setting_display_language_flag" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="language" module_id="language" is_hidden="0" type="boolean" var_name="auto_detect_language_on_ip" phrase_var_name="setting_auto_detect_language_on_ip" ordering="2" version_id="3.1.0beta1">0</setting>
		<setting group="language" module_id="language" is_hidden="0" type="boolean" var_name="no_string_restriction" phrase_var_name="setting_no_string_restriction" ordering="3" version_id="3.7.0beta2">0</setting>
	</settings>
	<hooks>
		<hook module_id="language" hook_type="controller" module="language" call_name="language.component_controller_admincp_file_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="controller" module="language" call_name="language.component_controller_admincp_file_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="controller" module="language" call_name="language.component_controller_admincp_phrase_add_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="controller" module="language" call_name="language.component_controller_admincp_phrase_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="service" module="language" call_name="language.service_phrase_phrase__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="service" module="language" call_name="language.service_phrase_process___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="service" module="language" call_name="language.service_phrase_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="service" module="language" call_name="language.service_language__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="service" module="language" call_name="language.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="language" hook_type="controller" module="language" call_name="language.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="language" hook_type="component" module="language" call_name="language.component_block_admincp_form_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="language" hook_type="component" module="language" call_name="language.component_block_select_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="language" hook_type="controller" module="language" call_name="language.component_controller_admincp_import_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="language" hook_type="controller" module="language" call_name="language.component_controller_admincp_missing_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="language" hook_type="controller" module="language" call_name="language.component_controller_admincp_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="language" hook_type="component" module="language" call_name="language.component_block_sample_clean" added="1260366442" version_id="2.0.0rc11" />
	</hooks>
	<components>
		<component module_id="language" component="ajax" m_connection="" module="language" is_controller="0" is_block="0" is_active="1" />
		<component module_id="language" component="admincp.phrase.add" m_connection="" module="language" is_controller="0" is_block="0" is_active="1" />
		<component module_id="language" component="admincp.file" m_connection="" module="language" is_controller="0" is_block="0" is_active="1" />
		<component module_id="language" component="admincp.index" m_connection="" module="language" is_controller="0" is_block="0" is_active="1" />
		<component module_id="language" component="admincp.phrase.phrase" m_connection="" module="language" is_controller="0" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="user_setting_can_manage_lang_packs" added="1215135052">Can manage language packages?</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="module_language" added="1219147665">Language</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_manager" added="1212092906">Phrase Manager</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="add_phrase" added="1212098704">Add Phrase</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_already_created" added="1212099832">This phrase has already been created: {phrase}</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_form" added="1212101835">Phrase Form</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="module" added="1212101872">Module</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="varname" added="1212101892">Varname</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="text" added="1212101908">Text</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="variable" added="1212102235">Variable</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="language" added="1212102262">Language</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="original" added="1212102283">Original</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_added" added="1212104699">Phrase has been added: {phrase}</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="product" added="1213989355">Product</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="select_varname" added="1213989408"><![CDATA[Select a "Varname" for your phrase]]></phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="product_not_defined_xml_file" added="1214414060">Product not defined in XML file.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="language_package_successfully_deleted" added="1214414106">Language package successfully deleted.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="manage_language_packages" added="1214414122">Manage Language Packages</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="delete" added="1214414137">Delete</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="are_you_sure" added="1214414183"><![CDATA[Are you sure you want to delete this language package (<i>{language}</i>)?]]></phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="yes" added="1214414236">Yes</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="no" added="1214414248">No</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="added" added="1214414369">Added On</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="created" added="1214414701">Created By</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="actions" added="1214414716">Actions</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="select_action" added="1214414731">Select Action</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="edit_settings" added="1214414742">Edit Settings</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="set_default" added="1214414753">Set As Default</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="default_language_package_reset" added="1214414838">Default language package reset.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="invalid_language_package" added="1214414865">Invalid language package.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="invalid_language" added="1214414882">Invalid language ID#.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="product_does_not_have_any_phrases_export" added="1214414922">Product does not have any phrases to export.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="language_package_successfully_imported" added="1214414951">Language package successfully imported.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="language_package" added="1214414972">Language Package</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="import_export" added="1214415020">Import/Export Language Packages</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="import_language_package" added="1214417937">Import Language Package</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="either_select_language_package" added="1214417954"><![CDATA[<b>EITHER</b> select a language package]]></phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="upload_one_from_your_computer" added="1214417972"><![CDATA[<b>OR</b> upload one from your computer]]></phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="overwrite" added="1214418012">Overwrite</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="import_missing_phrases_only" added="1214786160">Import Missing Phrases Only</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="cannot_import" added="1214800555">Invalid language package. Cannot import since it does not exist.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="revert_selected_default" added="1214992247">Revert Selected to Default</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="delete_selected" added="1214992306">Delete Selected</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="save_selected" added="1214992355">Save Selected</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="save_all" added="1214992377">Save All</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="save" added="1214992971">Save</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrases_found" added="1215127864">No phrases found.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="search_for_text" added="1215127988">Search For Text</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="search_filter" added="1215128001">Search Filter</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="search" added="1215128012">Search in</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="language_packages" added="1215128022">Language Packages</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="display" added="1215128032">Display</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="sort" added="1215128041">Sort By</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_id" added="1215128085">Phrase ID#</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_text_only" added="1215128104">Phrase Text Only</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_variable_name_only" added="1215128115">Phrase Variable Name Only</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_text_and_phrase_variable_name" added="1215128126">Phrase Text and Phrase Variable Name</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="phrase_s_updated" added="1215128152">Phrase(s) updated.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="selected_phrase_s_successfully_reverted" added="1215128178">Selected phrase(s) successfully reverted.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="selected_phrase_s_successfully_deleted" added="1215128192">Selected phrase(s) successfully deleted.</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="master" added="1217026920">MASTER</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="manage_phrases" added="1217026932">Manage Phrases</phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="setting_group_language" added="1236851585"><![CDATA[<title>Language</title><info>Language</info>]]></phrase>
		<phrase module_id="language" version_id="2.0.0alpha1" var_name="setting_display_language_flag" added="1236851646"><![CDATA[<title>Display Flag</title><info>Set to <b>True</b> if you would like to display the flag beside each of the language packages available.</info>]]></phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="online" added="1254982718">Online</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="php" added="1255009899">PHP</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="php_single_quoted" added="1255009910">PHP Single Quoted</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="php_double_quoted" added="1255009921">PHP Double Quoted</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="html" added="1255009931">HTML</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="js" added="1255009938">JS</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="create_language_pack" added="1255433188">Create Language Pack</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="create_a_new_language_package" added="1255433343">Create a New Language Package</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="create_language_package" added="1255433365">Create Language Package</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="editing_language_package" added="1255433381">Editing Language Package</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="package_details" added="1255433615">Package Details</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="name" added="1255433620">Name</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="language_abbreviation_code" added="1255433626">Language Abbreviation Code</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="submit" added="1255433631">Submit</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="html_character_set" added="1255433650">HTML Character Set</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="text_direction" added="1255433680">Text Direction</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="left_to_right" added="1255433795">Left to Right</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="right_to_left" added="1255433802">Right to Left</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="is_active" added="1255433997">Is Active</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="allow_user_selection" added="1255434067">Allow User Selection</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="created_by" added="1255434116">Created By</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="website" added="1255434124">Website</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="select" added="1255434344">Select</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="create_from" added="1255434351">Create From</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="language_package_successfully_added" added="1255435619">Language package successfully added.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="select_a_language_package_to_clone" added="1255435630">Select a language package to clone.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="provide_a_name_for_your_language_package" added="1255435641">Provide a name for your language package.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="provide_an_abbreviation_code" added="1255435651">Provide an abbreviation code.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="provide_an_html_character_set" added="1255435658">Provide an HTML character set.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="provide_the_text_direction" added="1255435665">Provide the text direction.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="language_package_not_found" added="1255440089">Language package not found.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="all_phrases" added="1255501983">All Phrases</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="not_translated" added="1255502005">Not Translated</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="translated_only" added="1255502014">Translated Only</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="phrases" added="1255502028">Phrases</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="importing_phrases_page_current_total" added="1255504472">Importing phrases. Page {current} / {total}</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="manage" added="1255505184">Manage</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="successfully_updated_your_language_preferences" added="1255506798">Successfully updated your language preferences.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="loading" added="1255508672">Loading</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="not_a_valid_url" added="1255510012">Not a valid URL.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="language_package_successfully_updated" added="1255510061">Language package successfully updated.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="icon" added="1255510283">Icon</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="find_missing_phrases" added="1255514039">Find Missing Phrases</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="default_icon_to_represent_this_language_package_br_advised_size_is_max_16_pixels_width_height" added="1255514182"><![CDATA[Default icon to represent this language package.
<br />
Advised size is max 16 pixels (Width & Height).]]></phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="not_a_valid_language_package" added="1255514329">Not a valid language package.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="successfully_imported_missing_phrases" added="1255518862">Successfully imported missing phrases.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="checking_the_following_modules_for_missing_phrases" added="1255518879">Checking the following modules for missing phrases</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="export" added="1255522097">Export</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="change_icon" added="1255524669">Change Icon</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="cancel" added="1255524684">cancel</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="import_language_pack" added="1255697717">Import Language Pack</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="not_a_valid_language_package_to_install" added="1255707073">Not a valid language package to install.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="not_a_valid_language_package_to_install_missing_the_xml_file" added="1255707087">Not a valid language package to install. Missing the XML file.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="successfully_installed_the_language_package" added="1255707101">Successfully installed the language package.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="importing_phrases_please_hold" added="1255707117">Importing phrases. Please hold...</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="manual_install" added="1255707126">Manual Install</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="title" added="1255707135">Title</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="action" added="1255707156">Action</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="nothing_new_to_install" added="1255707167">Nothing new to install.</phrase>
		<phrase module_id="language" version_id="2.0.0rc4" var_name="default" added="1255766645">Default</phrase>
		<phrase module_id="language" version_id="2.0.0rc11" var_name="phrase_variables" added="1259959433">Phrase Variables</phrase>
		<phrase module_id="language" version_id="2.0.0" var_name="translate_css_position_top" added="1261335237">Top</phrase>
		<phrase module_id="language" version_id="2.0.0" var_name="translate_css_position_right" added="1261335323">Right</phrase>
		<phrase module_id="language" version_id="2.0.0" var_name="translate_css_position_bottom" added="1261335334">Bottom</phrase>
		<phrase module_id="language" version_id="2.0.0" var_name="translate_css_position_left" added="1261335349">Left</phrase>
		<phrase module_id="language" version_id="2.0.4" var_name="attachments" added="1266500096">Attachments</phrase>
		<phrase module_id="language" version_id="2.0.7" var_name="export_with_3rd_party_phrases" added="1288624480">Export with 3rd Party Phrases</phrase>
		<phrase module_id="language" version_id="2.0.8" var_name="email_phrases" added="1298294636">Email Phrases</phrase>
		<phrase module_id="language" version_id="2.0.8" var_name="phrases_used_in_emails" added="1298383203">Phrases Used In Emails</phrase>
		<phrase module_id="language" version_id="2.0.8" var_name="phrases_updated_successfully" added="1298383306">Phrases updated successfully</phrase>
		<phrase module_id="language" version_id="3.1.0beta1" var_name="setting_auto_detect_language_on_ip" added="1330012352"><![CDATA[<title>Auto Detect Language Package</title><info>Enable this feature to auto detect a language package based on the users IP when they first visit the site. In order to use this option you must have an API key for the setting <b>"<a href="{url link='admincp/setting/edit/group-id_ip_infodb'}">IP InfoDB API Key</a>"</b>.</info>]]></phrase>
		<phrase module_id="language" version_id="3.1.0beta1" var_name="view_more_search_options" added="1331655642">View More Search Options</phrase>
		<phrase module_id="language" version_id="3.7.0beta2" var_name="setting_no_string_restriction" added="1376910146"><![CDATA[<title>No String Restriction</title><info>Enable this option if your site is using characters other then alphanumeric.</info>]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="language" type="boolean" admin="1" user="0" guest="0" staff="0" module="language" ordering="0">can_manage_lang_packs</setting>
	</user_group_settings>
	<tables><![CDATA[a:3:{s:15:"phpfox_language";a:3:{s:7:"COLUMNS";a:13:{s:11:"language_id";a:4:{i:0;s:8:"VCHAR:12";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:8:"VCHAR:12";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"user_select";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"language_code";a:4:{i:0;s:8:"VCHAR:12";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"charset";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"direction";a:4:{i:0;s:7:"VCHAR:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"flag_id";a:4:{i:0;s:8:"VCHAR:12";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"created";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:4:"site";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"is_default";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_master";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"language_id";s:4:"KEYS";a:3:{s:5:"title";a:2:{i:0;s:5:"INDEX";i:1;s:5:"title";}s:10:"is_default";a:2:{i:0;s:5:"INDEX";i:1;s:10:"is_default";}s:11:"user_select";a:2:{i:0;s:5:"INDEX";i:1;s:11:"user_select";}}}s:22:"phpfox_language_phrase";a:3:{s:7:"COLUMNS";a:9:{s:9:"phrase_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:11:"language_id";a:4:{i:0;s:8:"VCHAR:12";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:10:"version_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"text_default";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"phrase_id";s:4:"KEYS";a:3:{s:11:"language_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"language_id";}s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"module_id";i:1;s:8:"var_name";}}s:12:"setting_list";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"language_id";i:1;s:8:"var_name";}}}}s:20:"phpfox_language_rule";a:3:{s:7:"COLUMNS";a:6:{s:7:"rule_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:11:"language_id";a:4:{i:0;s:8:"VCHAR:12";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"rule";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"rule_value";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"rule_id";s:4:"KEYS";a:1:{s:11:"language_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"language_id";}}}}]]></tables>
</module>