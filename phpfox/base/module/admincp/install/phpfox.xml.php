<module>
	<data>
		<module_id>admincp</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_admincp</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="admincp" is_hidden="0" type="string" var_name="admin_cp" phrase_var_name="setting_admin_cp" ordering="0" version_id="2.0.0alpha1">admincp</setting>
		<setting group="" module_id="admincp" is_hidden="0" type="string" var_name="cache_time_stamp" phrase_var_name="setting_cache_time_stamp" ordering="1" version_id="2.0.0rc1">F j, Y, g:i a</setting>
	</settings>
	<hooks>
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_block_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_module_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_module_add_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_module_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_index_process_menu" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_file_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_file_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_edit_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_edit_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_index_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_add_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_group_add_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_group_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_component_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_product_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_module_product_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_block_block_get" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_block_block_getforedit" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_block_block___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_block_process_add" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_block_process_delete" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_block_process___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_module_block_block___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_module_block_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_module_module___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_module_process___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_plugin_plugin___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_plugin_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_menu_menu___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_menu_menu_get_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_menu_menu_get_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_menu_menu_getforedit" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_menu_menu__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_menu_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_admincp__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_cron_process_call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_cron_cron__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_setting_group_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_group_group__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_setting_setting_get" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_setting_setting_search" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_setting_setting___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_setting_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_component_component_get" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_component_component__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_component_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_product_product___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_product_process___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="template" module="admincp" call_name="admincp.template_controller_setting_add_js_form_value" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="template" module="admincp" call_name="admincp.template_controller_setting_add_type_drop_down" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="admincp" hook_type="component" module="admincp" call_name="admincp.component_block_product_form_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="admincp" hook_type="component" module="admincp" call_name="admincp.component_block_module_form_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="admincp" hook_type="component" module="admincp" call_name="admincp.component_block_block_setting_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_login_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_stat_index_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_stat_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_maintain_reparser_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_maintain_duplicate_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_logout_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_maintain_maintain__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_maintain_counter_clean" added="1259160644" version_id="2.0.0rc9" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_sql_index_clean" added="1259160644" version_id="2.0.0rc9" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_sql_backup_clean" added="1259160644" version_id="2.0.0rc9" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_component_index_clean" added="1261572640" version_id="2.0.0" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_setting_missing_clean" added="1263387694" version_id="2.0.2" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_foxporter_index_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_sql_title_clean" added="1276177474" version_id="2.0.5" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_product_product_export" added="1286546859" version_id="2.0.7" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_module_process_updateactivity" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_module_process_delete" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_product_process_update" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="service" module="admincp" call_name="admincp.service_product_process_delete" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_seo_nofollow_clean" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_seo_meta_clean" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_product_file_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_product_file_2" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_product_file_3" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_product_index_3" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_product_index_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_product_index_2" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_limit_clean" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="admincp" hook_type="component" module="admincp" call_name="admincp.component_block_oncloud_clean" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="admincp" hook_type="controller" module="admincp" call_name="admincp.component_controller_maintain_1" added="1378375116" version_id="3.7.0rc1" />
	</hooks>
	<components>
		<component module_id="admincp" component="index" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="maintain.cache" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="setting.index" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="setting.edit" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="menu.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="block.index" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="menu.index" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="block.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="module.index" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="setting.group.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="setting.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="component.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="setting.file" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="module.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="maintain.ajax" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="product.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="product.file" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="product.index" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="module.ajax" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="plugin.index" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="plugin.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="plugin.hook.add" m_connection="" module="admincp" is_controller="0" is_block="0" is_active="1" />
		<component module_id="admincp" component="index" m_connection="admincp.index" module="admincp" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module_admincp" added="1219147675">Admincp</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="logged_in_as" added="1212102851">Logged in as {full_name}</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="view_site" added="1212102898">View Site</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="logout" added="1212102912">Logout</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="admin_cp" added="1212102946">Admin CP</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="dashboard" added="1212104757">Dashboard</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_add_group" added="1213992518"><![CDATA[Select the group your new setting will belong to. 

Regardless of the group it belongs to it can be accessed globally. 

Settings are split up into 3 groups, which are <b>Global Setting</b>, <b>Module Setting</b> or <b>Product Setting</b>.

<b>Global Setting</b> are settings that are not part of any specific module or 3rd party product so it falls into a global variable. 

<b>Module Setting</b> are settings that belong to the specific module it is used in. The setting can still be accessed across other modules, however these settings are intended to be used only in the specific module it was created for.

<b>Product Setting</b> are settings that belong to 3rd party products.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_details" added="1213992880">Setting Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="group" added="1213992894">Groups</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="global_settings" added="1213992913">Global Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module_settings" added="1213992929">Module Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="product_settings" added="1213992943">Product Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="variable" added="1213992960">Variable</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="type" added="1213992972">Type</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="string" added="1213992984">String</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="boolean" added="1213992994">Boolean</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="integer" added="1213993005">Integer</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="array" added="1213993015">Array</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="defined_drop_down" added="1213993026">Defined Drop-Down</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="value" added="1213993039">Value</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="language_package_details" added="1213993059">Language Package Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="title" added="1213993072">Title</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="info" added="1213993093">Info</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="submit" added="1213993106">Submit</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="true" added="1213993147">True</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="false" added="1213993164">False</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_array_example" added="1213993190"><![CDATA[Example: array("val1", "val2", "val3");]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_drop_down_example" added="1213993229">Separate drop downs with commas. The first drop down will be the default drop down. (Example: drop1, drop2, drop3)</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_add_var" added="1213994889"><![CDATA[The <b>Variable</b> of your new setting is how you will identify and call this specific setting and return the given value.

If you create a <b>Variable</b> with <b>foo</b> it can be used later within the PHP script as:
[php]
echo App::getParam('foo');
[/php]
The above code will print out the value of foo.

Note that if you add spacing or unsupported characters (alphanumeric support only) to your <b>Variable</b> it will automatically be renamed to fit the standards, which we will replace all unsupported characters or spaces with an underscore.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="admincp_help" added="1213995090">AdminCP Help</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_add_type" added="1213996094"><![CDATA[Settings can be stored as a String, Boolean, Integer, Array or a Defined Drop-Down value.

<b><u>String</u></b>
Store string values that could contain alphanumeric characters or long text.

<b><u>Boolean</u></b>
Store a TRUE or FALSE value.

<b><u>Integer</u></b>
Store a numeric value.

<b><u>Array</u></b>
Store values within an Array.

<b><u>Defined Drop-Down</u></b>
Store values within an Array, however unlike the Array storage method you can only return one value which will be used when calling the parameter.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_add_value" added="1213996483"><![CDATA[Settings can be stored as a String, Boolean, Integer, Array or a Defined Drop-Down value.

<b><u>String</u></b>
Store string values that could contain alphanumeric characters or long text.

<b><u>Boolean</u></b>
Store a TRUE or FALSE value. Simply select TRUE if the value for the setting you are adding should be TRUE by default.

<b><u>Integer</u></b>
Store a numeric value.

<b><u>Array</u></b>
Store values within an Array. Adding an Array is similar to how Arrays are adding in PHP. 

Example:
[php]
array("val1", "val2", "val3");
[/php]

<b><u>Defined Drop-Down</u></b>
Store values within an Array, however unlike the Array storage method you can only return one value which will be used when calling the parameter.

When adding a drop-down separate drop downs with commas. The first drop down will be the default drop down. 

Example: 
[quote]
drop1, drop2, drop3
[/quote]]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_add_title" added="1213996632">Each setting must have a phrase added to the default language package to identify what we are editing when it comes time to edit this setting in the future. 

Keep the setting title short and to the point as you will also be adding a more informative phrase right after which is used to explain how a setting reacts on the site.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_add_info" added="1213996745">Add as much information as you can regarding the new setting you are adding as others may need to edit this setting in the future. 

Instructions on how the setting effects the site when it for example is enabled or disabled is very useful.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_variable_name" added="1213997343">Add a Variable name that identifies your new setting</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_must_have_value" added="1213997421">Your setting must have a Value</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_title_for_setting" added="1213997453">Add a Title for your setting</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_information_regarding_setting" added="1213997500">Add some information regarding the setting</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="already_in_use" added="1213997527">Already in use</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="added" added="1213997544">Added</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_setting" added="1213997573">Add Setting</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="updated" added="1213998211">Updated!</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_settings" added="1213998227">Manage Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="quick_jump" added="1213998537">Quick Jump</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="remove" added="1213998602">Remove</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_a_new_value" added="1213998867">Add a New Value...</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add" added="1213998909">Add</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_group_avaliable_settings" added="1213998954">This setting group has no available settings.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_a_title_for_the_group" added="1214047004">Add a title for the group</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_information_regarding_group" added="1214047044">Add information regarding the group</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="group_information" added="1214047080">Group Information</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="product" added="1214047136">Product</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="name" added="1214047154">Name</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_setting_group" added="1214047478">Add Setting Group</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="export" added="1214048708">Export</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="not_valid_array" added="1214050827">Not a valid array</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="value_must_be_numeric" added="1214050852">Value must be numeric</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="import" added="1214060258">Import</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="download" added="1214060328">Download</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="upload" added="1214060337">Upload</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select_file" added="1214060347">Select File</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="valid_file_extensions" added="1214060404">Valid File Extensions</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="import_export_settings" added="1214060450">Import/Export Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="product_does_not_have_any_settings" added="1214060583">Product does not have any settings.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="unable_load_cached_config_file" added="1214060887">Unable to load cached config file. Please be sure you are uploading the correct file.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="setting_imported" added="1214060918">{total} setting(s) imported. Database is now up-to-date.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="nothing_new_import" added="1214060951">Nothing new to import. Your database is up-to-date.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="invalid_file_extension" added="1214060974">Invalid file extension.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module_folder_already_exists" added="1214230661">Unable to use this module name. Module folder already exists.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select_name_for_your_module" added="1214230680">Select a name for your module.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="provide_information_regarding_module" added="1214230700">Provide some information regarding the module</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module_name_already_used" added="1214230730">Module name is already being used. Select another name.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="create_module" added="1214230746">Create Module</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module_successfully_created" added="1214230798">Module successfully created. Create the following file structure for your module</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module_details" added="1214230813">Module Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_menu" added="1214230844">Add to Menu</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="yes" added="1214230853">Yes</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="no" added="1214230945">No</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menu" added="1214230956">Menu</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="phrase" added="1214230977">Phrase</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="link" added="1214231004">Link</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_more" added="1214231280">Add More</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="unable_import_settings" added="1214232088">Unable to import settings. No product has been specified within the XML file.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="untouchables" added="1214317575">Untouchables</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="phpfox_hidden_settings" added="1214317835">Hidden settings.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="or" added="1214324454">or</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="file_unsupported" added="1214326996">Server does not support the file extension you are uploading.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="download_file_format" added="1214327614">Download File Format</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="cached_cleared" added="1214785672">Cached cleared.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="clear_cache" added="1214785703">Clear Cache</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_setting_can_clear_site_cache" added="1214788895">Can clear the sites cache.

By allowing a user to clear the sites cache they will be able to remove either SQL data or HTML templates. 

Note that once the page is refreshed these items will be re-cached, however it might be best to only allow Admins or developers to have access to this feature.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="data_size" added="1214790713">Data Size</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="cached" added="1214790722">Cached On</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="clear_selected" added="1214790764">Clear Selected</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="clear_all" added="1214790772">Clear All</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="cache_source" added="1214790801">Cache Source</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_new_menu" added="1214845204">Add New Menu</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menu_successfully_added" added="1214845273">Menu successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menu_details" added="1214851754">Menu Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module" added="1214851821">Module</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="connection" added="1214851848">Connection</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menus" added="1214851856">Menus</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="modules" added="1214851863">Modules</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="url" added="1214851874">URL</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_group_access" added="1214851921">User Group Access</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="allow_access" added="1214851932">Allow Access</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menu_add_product" added="1214853997">Product this menu will belong to.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="core_module" added="1214957846">Is a Core Module</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="sub_menu" added="1214960766">Sub Menu</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="cms" added="1214963139">CMS</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_group_manager" added="1214963173">User Group Manager</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_user_group_setting" added="1214963493">Add User Group Setting</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_user_settings" added="1214963811">Manage User Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="users" added="1214963853">Users</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="extensions" added="1214963862">Extensions</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="create_new_module" added="1214963912">Create New Module</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="language" added="1214963926">Language</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_language_packs" added="1214963938">Manage Language Packs</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="phrase_manager" added="1214963958">Phrase Manager</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_phrase" added="1214963974">Add Phrase</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="language_import_export" added="1214963992">Import/Export</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="settings" added="1214964004">Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_setting_groups" added="1214964025">Manage Setting Groups</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_new_setting" added="1214964037">Add New Setting</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_new_setting_group" added="1214964045">Add New Setting Group</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="maintenance" added="1214964072">Maintenance</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="tools" added="1214964140">Tools</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="update" added="1214964195">Update</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_user_groups" added="1214966536">Manage User Groups</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_setting_has_admin_access" added="1214976110">Has general access to the Admin Control Panel.

Best to allow on Admins and Staff for security.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="install_dir_exists" added="1215780338"><![CDATA[Install directory "install/" exists. Please delete this directory for security purposes.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_setting_can_add_new_block" added="1216066116">Can add/modify blocks being added from the AdminCP?</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="blocks" added="1216069451">Blocks</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_new_block" added="1216069481">Add New Block</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="developer" added="1216070830">Developer</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="log_query" added="1216070861">Log Query</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="block_successfully_added" added="1216070957">Block successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select_product" added="1216071011">Select a product.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select_controller" added="1216071026">Select a controller.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select_component" added="1216071042">Select a component.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select_block_placement" added="1216071063">Select block placement.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="specify_block_active" added="1216071082">Specify if the block is active or not.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_setting_can_view_product_options" added="1216071352">Can view product drop downs in the AdminCP?

Within certain sections of the AdminCP there are areas where an entry into the database requires a product ID#. If you disable this feature users will not be able to view the products name and will automatically enter the default product ID#. 

Only enable this feature when creating a plug-in or 3rd party module.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="block_details" added="1216072142">Block Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="controller" added="1216089356">Controller</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="component" added="1216090253">Component</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="placement" added="1216091622">Placement</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="active" added="1216091671">Active</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="view_sample_layout" added="1216091824">View Sample Layout</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="sample_layout" added="1216091833">Sample Layout</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="block" added="1216091850">Block {x}</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select" added="1216091882">Select</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_menus" added="1217026597">Manage Menus</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menu_successfully_deleted" added="1217189351">Menu successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="order" added="1217189374">Order</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="location" added="1217189417">Location</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="actions" added="1217189540">Actions</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="edit" added="1217189636">Edit</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="delete" added="1217189646">Delete</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menu_successfully_updated" added="1217189724">Menu successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menu_manager" added="1217189774">Menu Manager</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_blocks" added="1217190522">Manage Blocks</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="successfully_deleted" added="1217193508">Successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="successfully_updated" added="1217197677">Successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="block_manager" added="1217198066">Block Manager</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="pages" added="1217201690">Pages</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_new_page" added="1217201717">Add New Page</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="page_menu_successfully_added" added="1217278396">Page and Menu successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_pages" added="1217293918">Manage Pages</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="add_component" added="1217802855">Add Component</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="component_successfully_added" added="1217808626">Component successfully added!</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="component_details" added="1217808713">Component Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="url_connection" added="1217808781">URL Connection</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="block_actual" added="1217808814">Block</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="specify_component" added="1217808943">Specify a component.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select_component_active" added="1217808955">Select if component is active.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="select_component_type" added="1217808964">Select a component type.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="menu_order_successfully_updated" added="1217939317">Menu order successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_modules" added="1219067475">Manage Modules</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="core_modules" added="1219225433">Core Modules</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module_s_updated" added="1219225575">Module(s) updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="overwrite_default_data" added="1219225665">Overwrite default data</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_setting_can_manage_modules" added="1219225982">Can manage product modules?

Note: This includes updating the status, editing or deleting modules.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_setting_can_add_new_modules" added="1219226029">Can add new product modules?</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="module_successfully_deleted" added="1219228565">Module successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="admin_menu_manage_categories" added="1219330154">Manage Categories</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="admin_menu_add_category" added="1219330307">Add New Category</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="not_allowed_for_guests" added="1219654948"><![CDATA[Not all options will work with this specific user group since it is marked as a "Guest" group and many features found within the site requires a user to be a member.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="admin_menu_add_article" added="1223227838">Add Article</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="user_setting_bcaneditarticles" added="1223385298">Can edit articles?</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="admin_menu_import_export" added="1223390093">Import Export</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="products" added="1230854108">Product</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_products" added="1230854160">Manage Products</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="create_new_product" added="1230854171">Create New Product</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="import_export" added="1230855085">Import Products</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="theme" added="1231033391">Theme</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_themes" added="1231033425">Manage Themes</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="plugin" added="1231748137">Plugin</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="manage_plugins" added="1231748173">Manage Plugins</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="create_new_plugin" added="1231750982">Create New Plugin</phrase>
		<phrase module_id="admincp" version_id="2.0.0alpha1" var_name="new_sample_test_phrase" added="1235553235">You have {total} comments.</phrase>
		<phrase module_id="admincp" version_id="2.0.0beta1" var_name="create_user_group" added="1240572399">Create User Group</phrase>
		<phrase module_id="admincp" version_id="2.0.0beta4" var_name="browse_members" added="1244542842">Browse Users</phrase>
		<phrase module_id="admincp" version_id="2.0.0beta4" var_name="country_management" added="1244642320">Country Management</phrase>
		<phrase module_id="admincp" version_id="2.0.0beta4" var_name="payment_gateways_menu" added="1244909510">Payment Gateways</phrase>
		<phrase module_id="admincp" version_id="2.0.0beta4" var_name="system_settings_menu" added="1244909711">System Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0beta4" var_name="menu_site_stats" added="1245138476">Site Stats</phrase>
		<phrase module_id="admincp" version_id="2.0.0beta4" var_name="menu_manage_stats" added="1245138629">Manage Stats</phrase>
		<phrase module_id="admincp" version_id="2.0.0beta4" var_name="menu_create_new_stat" added="1245138672">Add New Stat</phrase>
		<phrase module_id="admincp" version_id="1.0" var_name="user_cancellation_options" added="1215331034">User Cancellation</phrase>
		<phrase module_id="admincp" version_id="1.0" var_name="user_cancellation_options_add" added="1215331034">Add Options</phrase>
		<phrase module_id="admincp" version_id="1.0" var_name="user_cancellation_options_manage" added="1215331034">Manage Options</phrase>
		<phrase module_id="admincp" version_id="1.0" var_name="user_cancellations_feedback" added="1215331034">View Feedback</phrase>
		<phrase module_id="admincp" version_id="30" var_name="mail_messages" added="1247588853">Messages</phrase>
		<phrase module_id="admincp" version_id="30" var_name="view_messages" added="1247588922">View Private Messages</phrase>
		<phrase module_id="admincp" version_id="30" var_name="menu_tools_emoticon_add" added="1247743917">Add Emoticon</phrase>
		<phrase module_id="admincp" version_id="30" var_name="menu_tools_emoticon_package_add" added="1247831553">Add Package</phrase>
		<phrase module_id="admincp" version_id="30" var_name="menu_tools_emoticon_package" added="1248091043">Manage Packages</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc1" var_name="setting_cache_time_stamp" added="1248617319"><![CDATA[<title>Cache Time Stamp</title><info>Cache Time Stamp</info>]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc1" var_name="menu_cache_manager" added="1248617362">Cache Manager</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="cache_system_unlocked" added="1252757444">Cache system unlocked.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="timestamp" added="1252757507">Timestamp</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="cache_name" added="1252757518">Cache Name</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="module_successfully_updated" added="1252757604">Module successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="module_successfully_created_redirect" added="1252757646">Module successfully created.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="select_what_type_of_a_hook_this_is" added="1252757683">Select what type of a hook this is.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="hook_successfully_added" added="1252757694">Hook successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="add_hook" added="1252757705">Add Hook</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="provide_a_title_for_your_plugin" added="1252757723">Provide a title for your plugin.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="select_a_hook" added="1252757733">Select a hook.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="provide_php_code_for_your_plugin" added="1252757744">Provide PHP code for your plugin.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="plugin_successfully_updated" added="1252757756">Plugin successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="plugin_successfully_added" added="1252757766">Plugin successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="create_plugin" added="1252757776">Create Plugin</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="plugin_s_updated" added="1252757793">Plugin(s) updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="plugin_successfully_deleted" added="1252757806">Plugin successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="add_a_product_id" added="1252757839">Add a product ID.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="add_a_product_title" added="1252757861">Add a product title.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_dependency_updated" added="1252757875">Product dependency updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_install_uninstall_updated" added="1252757892">Product install/uninstall updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_successfully_updated" added="1252757902">Product successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_successfully_created" added="1252757912">Product successfully created.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="editing_product" added="1252757935">Editing Product</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_successfully_installed" added="1252757983">Product successfully installed.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="import_products" added="1252767035">Import Products</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_s_updated" added="1252767068">Product(s) updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_successfully_deleted" added="1252767078">Product successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="your_search_did_not_return_any_results" added="1252767458">Your search did not return any results.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="stat_successfully_updated" added="1252767479">Stat successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="stat_successfully_added" added="1252767488">Stat successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="add_new_stat" added="1252767499">Add New Stat</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="manage_stats" added="1252767512">Manage Stats</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="stat_successfully_deleted" added="1252767526">Stat successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="successfully_logged_out" added="1252767587">Successfully logged out.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="module_id_can_only_contain_the_following_characters" added="1252767742">Module ID can only contain the following characters: a-z, A-Z, 0-9.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="hook_already_exists" added="1252767835">Hook already exists.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_name_is_not_valid" added="1252767852">Product name is not valid.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="not_a_valid_product_to_import" added="1252767877">Not a valid product to import.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="not_a_valid_xml_file" added="1252767894">Not a valid XML file.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_already_exists" added="1252767905">Product already exists.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_requires_php_version" added="1252768039">Product requires PHP version {dependency_start}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_requires_php_version_up_until" added="1252768178">Product requires PHP version {dependency_start} up until {dependency_end}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_requires_phpfox_version" added="1252768235">Product requires version {dependency_start}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_requires_phpfox_version_up_until" added="1252768322">Product requires version {dependency_start} up until {dependency_end}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_requires_check_id_version_dependency_start" added="1252768418">Product requires {check_id} version {dependency_start}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_requires_check_id_version_dependency_start_up_until_dependency_end" added="1252768480">Product requires {check_id} version {dependency_start} up until {dependency_end}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="main_configuration_file_file_path_is_writable" added="1252768745"><![CDATA[Main configuration file ({file_path}) is writable. This is a security risk and this file should not have any "write" permission.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="main_file_folder_is_writable_file_path" added="1252768815"><![CDATA[Main file folder is writable ({file_path}). This is a security risk and this folder should not have any "write" permission.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="none_site_wide" added="1252768924">None (Site Wide)</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="can_drag_drop" added="1252768952">Can Drag/Drop</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="site_wide" added="1252769097">Site Wide</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="block_block_number" added="1252769121">Block {block_number}</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="cache_system_is_locked" added="1252908150">Cache system is locked.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="the_cache_system_is_locked_during_an_operation_that_requires_all_cache_files_to_be_kept_in_place" added="1252908171"><![CDATA[The cache system is locked during an operation that requires all cache files to be kept in place. If you would like to unlock the system click <a href="{link}" onclick="return confirm('Are you sure?');">here</a>.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="cache_stats" added="1252908186">Cache Stats</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="total_files" added="1252908194">Total Files</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="cache_size" added="1252908203">Cache Size</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="last_cached_file" added="1252908212">Last Cached File</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="search_filter" added="1252908222">Search Filter</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="search" added="1252908230">Search</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="display" added="1252908239">Display</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="sort" added="1252908248">Sort</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="files" added="1252908257">Files</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="no_cache_date_found" added="1252908269">No cache date found.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="or_select_a_page" added="1252908368">or select a page</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="module_id" added="1252908459">Module ID</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="hook_details" added="1252908498">Hook Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="call" added="1252908530">Call</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="save" added="1252908547">Save</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="plugin_details" added="1252908572">Plugin Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="hook" added="1252908589">Hook</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_code" added="1252908620">PHP Code</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="create_a_new_plugin" added="1252908670">Create a New Plugin</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_details" added="1252908687">Product Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_id" added="1252908695">Product ID</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="description" added="1252908714">Description</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="version" added="1252908721">Version</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="product_url" added="1252908730">Product URL</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="version_check_url" added="1252908739">Version Check URL</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="existing_product_dependencies" added="1252908781">Existing Product Dependencies</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="dependencies" added="1252908788">Dependencies</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="dependency_type" added="1252908797">Dependency Type</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="compatibility_starts" added="1252908805">Compatibility Starts</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="incompatible_with" added="1252908813">Incompatible With</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="add_new_product_dependency" added="1252908833">Add New Product Dependency</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php" added="1252908848">PHP</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="phpfox_version" added="1252908856">Core Version</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="compatibility_starts_with_version" added="1252908880">Compatibility Starts with Version</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="compatibility_end_with_version" added="1252908889">Compatibility End with Version</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="install_uninstall" added="1252908916">Install/Uninstall</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="existing_install_uninstall_code" added="1252908924">Existing Install/Uninstall Code</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="install_code" added="1252908939">Install Code</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="uninstall_code" added="1252908949">Uninstall Code</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="add_new_install_uninstall_code" added="1252908966">Add New Install/Uninstall Code</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="install" added="1252908980">Install</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="uninstall" added="1252908988">Uninstall</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="overwrite" added="1252909024">Overwrite</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="ftp_support_must_be_enabled_in_order_to_import_products" added="1252909057">FTP support must be enabled in order to import products.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="click_a_href_url_link_admincp_setting_edit_group_id_ftp_here_a_to_enable_ftp_support" added="1252909066"><![CDATA[Click <a href="{link}">here</a> to enable FTP support.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="create_a_new_product" added="1252909083">Create a New Product</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="import_a_product" added="1252909091">Import a Product</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="no_products_have_been_added" added="1252909101">No products have been added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="image" added="1252909340">Image</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="your_current_watermark_image" added="1252909349">Your current watermark image</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="b_notice_b_advised_image_is_a_transparent_png_with_a_max_width_height_of_52_pixels" added="1252909363"><![CDATA[<b>Notice:</b> Advised image is a transparent PNG with a max width/height of 52 pixels.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1252909373">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="stat_details" added="1252909438">Stat Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="stats" added="1252909528">Stats</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="are_you_sure" added="1252909580">Are you sure?</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="activate" added="1252909600">Activate</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="deactivate" added="1252909608">Deactivate</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="admincp_login" added="1252909626">AdminCP Login</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="email" added="1252909632">Email</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="password" added="1252909640">Password</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="back_to_site" added="1252909648">Back to site</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="login" added="1252909655">Login</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="active_admins" added="1253083283">Active Admins</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="latest_admin_logins" added="1253083475">Latest Admin Logins</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="view_more" added="1253083486">View More</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="phpfox_news_and_updates" added="1253083534"><![CDATA[Corporate News &amp; Updates]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="admincp_notes" added="1253083547">AdminCP Notes</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="quick_links" added="1253083563">Quick Links</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="members" added="1253083582">Members</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="guests" added="1253083590">Guests</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="online" added="1253083603">Online</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="pending_approval" added="1253083614">Pending Approval</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="reported_items_users" added="1253083633">Reported Items/Users</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="spam" added="1253083646">Spam</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="site_statistics" added="1253083662">Site Statistics</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="phpfox_tweets" added="1253083701">Corporate Tweets</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="not_a_valid_country" added="1253083732">Not a valid country.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="state_province_successfully_updated" added="1253083745">State/Province successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="state_province_successfully_added" added="1253083757">State/Province successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="country_manager" added="1253083768">Country Manager</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="adding_state_province" added="1253083780">Adding State/Province</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="editing_state_province" added="1253083798">Editing State/Province</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="state_province_successfully_deleted" added="1253083824">State/Province successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="states_provinces" added="1253083849">States/Provinces</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="country_successfully_updated" added="1253083871">Country successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="country_successfully_added" added="1253083883">Country successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="add_a_country" added="1253083894">Add a Country</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="editing_country" added="1253083903">Editing Country</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="text_import_successfully_completed" added="1253083984">Text import successfully completed. Success: {completed} - Failed: {failed}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="import_successfully_completed" added="1253084014">Import successfully completed.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="import_countries_states_provinces" added="1253084025"><![CDATA[Import Countries, States & Provinces]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="country_successfully_deleted" added="1253084063">Country successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="phpfox_branding_removal_successfully_installed" added="1253084098">Branding removal successfully installed.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="phpfox_branding_removal" added="1253084108">Branding Removal</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="login_time_stamp" added="1253084135">Login Time Stamp</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="ip_address" added="1253084146">IP Address</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="online_guests" added="1253084165">Online Guests</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="admincp_logins" added="1253084211">AdminCP Logins</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="last_activity" added="1253084264">Last Activity</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="guests_bots" added="1253084308">Guests/Bots</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_info" added="1253084322">PHP Info</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="system" added="1253084334">System</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="system_overview" added="1253084347">System Overview</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="customize_dashboard" added="1253084382">Customize Dashboard</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="not_a_valid_login_log" added="1253084504">Not a valid login log.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="not_a_valid_account" added="1253084517">Not a valid account.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="email_failure" added="1253084527">Email failure.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="password_failure" added="1253084538">Password failure.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="success" added="1253084548">Success</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="provide_a_category_name" added="1253084625">Provide a category name.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="provide_a_name" added="1253084710">Provide a name.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="select_a_country" added="1253084725">Select a country.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="the_state_province_name_already_exists" added="1253084747"><![CDATA[The state/province "{name}" already exists.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="all_fields_are_required" added="1253084816">All fields are required.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="iso_can_only_contain_2_characters" added="1253084826">ISO can only contain 2 characters.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="the_iso_is_already_in_use" added="1253084836">The ISO is already in use.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="not_a_valid_country_package" added="1253084876">Not a valid country package.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="select_a_product" added="1253084897">Select a product.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="select_a_module" added="1253084914">Select a module.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="at_least_one_title_for_the_stat_is_required" added="1253084926">At least one title for the stat is required.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="link_for_the_stat_is_required" added="1253084936">Link for the stat is required.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="image_for_the_stat_is_required" added="1253084946">Image for the stat is required.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_code_for_the_stat_is_required" added="1253084958">PHP code for the stat is required.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="select_if_the_stat_is_active_or_not" added="1253084971">Select if the stat is active or not.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="not_a_valid_request" added="1253084994">Not a valid request.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="the_stat_you_are_looking_for_cannot_be_found" added="1253085007">The stat you are looking for cannot be found.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="unable_to_find_the_stat_you_want_to_edit" added="1253085033">Unable to find the stat you want to edit.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_version" added="1253085208">PHP Version</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_sapi" added="1253085217">PHP Sapi</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_safe_mode" added="1253085231">PHP safe_mode</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_open_basedir" added="1253085243">PHP open_basedir</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_disabled_functions" added="1253085253">PHP Disabled Functions</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_loaded_extensions" added="1253085262">PHP Loaded Extensions</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="operating_system" added="1253085278">Operating System</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="server_time_stamp" added="1253085310">Server Time Stamp</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="gzip" added="1253085352">GZIP</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="sql_driver_version" added="1253085368">SQL Driver Version</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="sql_slave_enabled" added="1253085377">SQL Slave Enabled</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="sql_total_slaves" added="1253085387">SQL Total Slaves</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="sql_slave_server" added="1253085399">SQL Slave Server</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="memory_limit" added="1253085408">Memory Limit</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="load_balancing_enabled" added="1253085422">Load Balancing Enabled</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="none" added="1253085465">None</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="enabled" added="1253085477">Enabled</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="disabled" added="1253085488">Disabled</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="n_a" added="1253085499">N/A</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="total_server_memory" added="1253085571">Total Server Memory</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="available_server_memory" added="1253085584">Available Server Memory</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="current_server_load" added="1253085598">Current Server Load</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="your_ftp_path_is_empty_and_does_not_need_to_have_any_value" added="1253086015"><![CDATA[Your FTP path is "empty" and does not need to have any value.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="ftp_details" added="1253086025">FTP Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="ftp_host" added="1253086033">FTP Host</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="ftp_username" added="1253086042">FTP Username</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="ftp_password" added="1253086052">FTP Password</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="admincp_login_log" added="1253086100">AdminCP Login Log</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="view_attempt" added="1253086110">View Attempt</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="cancel" added="1253086155">Cancel</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="posted_on_time_stamp_by_creator" added="1253086263">Posted on {time_stamp} by {creator}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="find_users" added="1253086389">Find Users</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="go" added="1253086398">Go</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="manage_user_group_settings" added="1253086409">Manage User Group Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="edit_user_groups" added="1253086443">Edit User Groups</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="edit_system_settings" added="1253086453">Edit System Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="send_newsletter" added="1253086462">Send Newsletter</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="write_an_announcement" added="1253086471">Write an Announcement</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="posted_on_time_stamp" added="1253086501">Posted on {time_stamp}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="log_details" added="1253086570">Log Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="attempt" added="1253086578">Attempt</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="user" added="1253086587">User</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="time_stamp" added="1253086595">Time Stamp</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="referrer" added="1253086623">Referrer</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="user_agent" added="1253086633">User Agent</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="security_token" added="1253086642">Security Token</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="close" added="1253086659">Close</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="state_province_details" added="1253087117">State/Province Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="country" added="1253087125">Country</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="manage" added="1253087292">Manage</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="country_details" added="1253087344">Country Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="iso" added="1253087352">ISO</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="import_country_package" added="1253087386">Import Country Package</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="file" added="1253087395">File</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="import_text_file" added="1253087438">Import Text File</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="you_can_upload_a_text_file_with_a_list" added="1253087470">You can upload a text file with a list of states/provinces that you would like to import and each state/province should be on a new line.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="countries" added="1253087487">Countries</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="add_state_province" added="1253087540">Add State/Province</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="manage_states_provinces" added="1253087549">Manage States/Provinces</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="login_with_your_phpfox_client_details" added="1253087588"><![CDATA[Login with your phpFox client details in order to install the <i>branding removal</i>.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="phpfox_client_login_details" added="1253087596">phpFox Client Login Details</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="client_email" added="1253087604">Client Email</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="client_password" added="1253087612">Client Password</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="admins" added="1253087631">Admins</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="banned" added="1253087720">Banned</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="unban" added="1253087737">Unban</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="ban" added="1253087744">Ban</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="no_guests_online" added="1253087754">No guests online.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="server_overview" added="1253087766">Server Overview</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="you_are_about_to_leave_our_site_to_visit" added="1253087796"><![CDATA[You are about to leave our site to visit: <a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="click_here_to_continue" added="1253087813">Click here to continue.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="note_we_are_in_no_way_affiliated" added="1253087832"><![CDATA[<strong>Note:</strong> We are in no way affiliated to "{link}".]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="controllers" added="1253104993">Controllers</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="php_block_file" added="1253105020">PHP Block File</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="html_code" added="1253105036">HTML Code</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="not_a_valid_ip_address" added="1253522964">Not a valid IP address.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="ip_information" added="1253522974">IP Information</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="host_address" added="1253522984">Host Address</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="view_all_the_activity_from_this_ip" added="1253523295">View all the activity from this IP.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc2" var_name="search_ip_address" added="1253523525">Search IP Address</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc3" var_name="admincp_menu_reparser" added="1253959468">Reparser</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="edit_this_block" added="1255709840">Edit this Block</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="remove_this_block" added="1255709849">Remove this Block</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="remove_duplicates" added="1255856692">Remove Duplicates</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="parsing_completed" added="1255860451">Parsing completed.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="text_reparser" added="1255861071">Text Reparser</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="reparser" added="1255861077">Reparser</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="parsing_page_current_total_please_hold" added="1255861123">Parsing page {current}/{total}. Please hold...</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="text_data" added="1255861153">Text Data</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="records" added="1255861159">Records</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="there_is_no_data_to_parse" added="1255861167">There is no data to parse.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="successfully_removed_duplicate_entries" added="1255863746">Successfully removed duplicate entries.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="user_group_settings" added="1255863782">User Group Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="check" added="1255863866">Check</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc4" var_name="custom_field" added="1256490984">Custom Field</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc6" var_name="admincp_name_not_allowed" added="1256889425">AdminCP name not allowed</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc6" var_name="large_string" added="1256891252">Large String</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc7" var_name="enable_utf_encoding" added="1257799322">Enable UTF Encoding</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="sql" added="1258744172">SQL</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="sql_maintenance" added="1258744239">Maintenance</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="table_s_successfully_optimized" added="1258745778">Table(s) successfully optimized.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="table_s_successfully_repaired" added="1258745790">Table(s) successfully repaired.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="sql_maintenance_title" added="1258745827">SQL Maintenance</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="database_size" added="1258746004">Database Size</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="overhead" added="1258746010">Overhead</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="total_tables" added="1258746230">Total Tables</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="sql_tables" added="1258746241">SQL Tables</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="table" added="1258746253">Table</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="size" added="1258746266">Size</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="optimize_table_s" added="1258746303">Optimize Table(s)</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="repair_table_s" added="1258746310">Repair Table(s)</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="sql_backup" added="1258746653">Backup</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="sql_backup_successfully_created_and_can_be_downloaded_here_path" added="1258754213">SQL backup successfully created and can be downloaded here: {path}</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="the_path_you_provided_is_not_a_valid_directory" added="1258754263">The path you provided is not a valid directory.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="backup" added="1258754347">Backup</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="sql_backup_header" added="1258754406">SQL Backup</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="path" added="1258754414">Path</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="provide_the_full_path_to_where_we_should_save_the_sql_backup" added="1258754422">Provide the full path to where we should save the SQL backup.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="your_operating_system_does_not_support_the_method_of_backup_we_provide" added="1258754523">Your operating system does not support the method of backup we provide. We advice you contact your host and ask the best method to backup your database as most hosting companies provide these options from a hosting control panel (eg. cPanel, Plesk etc...).</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="today_s_site_stats" added="1258756073"><![CDATA[Today's Site Stats]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="counters" added="1258900597">Counters</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="update_of_counter_successfully_completed" added="1258979452">Update of counter successfully completed.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="update_counters" added="1258979493">Update Counters</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc8" var_name="updating_counters_processing_page_current_out_of_page" added="1258979529">Updating counters. Processing page {current} out of {page}.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc10" var_name="unable_to_find_xml_file_to_import_for_this_product" added="1259331413">Unable to find XML file to import for this product.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc10" var_name="the_module_name_is_required" added="1259331430"><![CDATA[The module "{name}" is required.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.0rc10" var_name="product_successfully_upgraded" added="1259334325">Product successfully upgraded.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc10" var_name="upgrade" added="1259334365">Upgrade</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc10" var_name="upgrade_upgrade_version" added="1259334389">Upgrade ({upgrade_version})</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc10" var_name="not_a_valid_product_to_upgrade" added="1259334492">Not a valid product to upgrade. It does not exist in our database.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc10" var_name="latest" added="1259347180">Latest</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc11" var_name="module_successfully_installed" added="1260124073">Module successfully installed.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc11" var_name="install_this_module" added="1260124108">Install this Module</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc11" var_name="menu_block" added="1260127011">Menu Block</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc11" var_name="parent_menu" added="1260127285">Parent Menu</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc11" var_name="manage_children_total_children" added="1260133275">Manage Children ({total_children})</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc11" var_name="editing" added="1260205884">Editing</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc11" var_name="country_child_entries_successfully_deleted" added="1260232705">Country child entries successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0rc11" var_name="show_price" added="1260234779">Show Price</phrase>
		<phrase module_id="admincp" version_id="2.0.0" var_name="manage_components" added="1261233363">Manage Components</phrase>
		<phrase module_id="admincp" version_id="2.0.0" var_name="component_successfully_updated" added="1261237677">Component successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.0" var_name="editing_component" added="1261237699">Editing Component</phrase>
		<phrase module_id="admincp" version_id="2.0.0" var_name="component_successfully_deleted" added="1261238215">Component successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.0" var_name="components" added="1261238355">Components</phrase>
		<phrase module_id="admincp" version_id="2.0.2" var_name="checking_the_following_modules_for_missing_settings" added="1263387520">Checking the following modules for missing settings</phrase>
		<phrase module_id="admincp" version_id="2.0.2" var_name="missing_settings_successfully_imported" added="1263387546">Missing settings successfully imported.</phrase>
		<phrase module_id="admincp" version_id="2.0.2" var_name="missing_settings" added="1263387556">Missing Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.2" var_name="find_missing_settings" added="1263387601">Find Missing Settings</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="provide_a_3_character_currency_id" added="1271666124">Provide a 3 character currency ID.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="provide_a_symbol" added="1271666133">Provide a symbol.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="provide_a_phrase_for_your_currency" added="1271666142">Provide a phrase for your currency.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="select_if_this_currency_is_active_or_not" added="1271666153">Select if this currency is active or not.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="this_currency_is_already_in_use" added="1271666169">This currency is already in use.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="currency_successfully_deleted" added="1271666187">Currency successfully deleted.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="id" added="1271666197">ID</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="symbol" added="1271666204">Symbol</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="currency" added="1271666211">Currency</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="default" added="1271666217">Default</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="set_as_default" added="1271666247">Set as Default</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="currency_successfully_updated" added="1271666288">Currency successfully updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="currency_successfully_added" added="1271666297">Currency successfully added.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="add_currency" added="1271666307">Add Currency</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="currency_details" added="1271666317">Currency Details</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="currency_id" added="1271666324">Currency ID</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="is_active" added="1271666344">Is Active</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="foxporter" added="1273067717">Foxporter</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="action" added="1273067760">Action</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="importing_data" added="1273067770">Importing Data</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="refresh" added="1273067778">Refresh</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="continue_to_the_next_step" added="1273067788">Continue to the next step...</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="start_importing" added="1273067800">Start Importing</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="not_a_valid_country_package_must_be_an_xml_file" added="1273136397">Not a valid country package. Must be an XML file.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="alter_title_fields" added="1275386165">Alter Title Fields</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="database_tables_updated" added="1275386206">Database tables updated.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="b_notice_b_this_routine_is_highly_experimental" added="1275386223"><![CDATA[<b>Notice:</b> This routine is highly experimental.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="all_items_on_the_site_store_certain_information_in_the_database" added="1275386310">All items on the site store certain information in the database. Some of this information are the titles of items. By default these fields that store the items title have a limit of 255 characters, which with alphanumeric characters is a lot. However, if using non-latin characters this might not be enough and titles are cut short. This reason for this is we convert non-latin characters before they are added into the database so when they are outputted everyone can view these characters irregardless of what character-set they have. Using the tool found on this page you can enlarge these fields to store a maximum of 65,535 characters.</phrase>
		<phrase module_id="admincp" version_id="2.0.5" var_name="update_database_tables" added="1275386334">Update Database Tables</phrase>
		<phrase module_id="admincp" version_id="2.0.7" var_name="you_have_logged_out_of_the_site" added="1288205070">You have logged out of the site. Redirecting you to the login page...</phrase>
		<phrase module_id="admincp" version_id="2.0.7" var_name="missing_api_key" added="1289989043">Missing API Key</phrase>
		<phrase module_id="admincp" version_id="2.0.7" var_name="enter_your_api_key" added="1289989168"><![CDATA[Enter your API key <a href="{link}">here</a> for additional IP information.]]></phrase>
		<phrase module_id="admincp" version_id="2.0.7" var_name="city" added="1289989619">City</phrase>
		<phrase module_id="admincp" version_id="2.0.7" var_name="zip_postal_code" added="1289989718">ZIP / Postal Code</phrase>
		<phrase module_id="admincp" version_id="2.0.7" var_name="latitude" added="1289989746">Latitude</phrase>
		<phrase module_id="admincp" version_id="2.0.7" var_name="longitude" added="1289989773">Longitude</phrase>
		<phrase module_id="admincp" version_id="2.0.8" var_name="inactive_member_reminder" added="1296740123">Inactive Member Reminder</phrase>
		<phrase module_id="admincp" version_id="2.1.0rc1" var_name="inactive_members" added="1301568738">Inactive Members</phrase>
		<phrase module_id="admincp" version_id="3.0.0beta5" var_name="update_privacy_for_v3_upgrade" added="1319536489"><![CDATA[Update Privacy for v3 Upgrade<b> (Only run this if you have just upgraded to v3 and make sure to only run this once.)</b>]]></phrase>
		<phrase module_id="admincp" version_id="3.0.0beta5" var_name="import_groups_from_v2_to_v3_pages" added="1319536506"><![CDATA[Import Groups from v2 to v3 Pages<b> (Only run this if you have just upgraded to v3 and make sure to only run this once.)</b>]]></phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="nofollow_urls" added="1336984686">NoFollow URLs</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="add_new_url" added="1336984704">Add New URL</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="provide_the_full_url_to_the_page" added="1336984727"><![CDATA[Provide the full URL to the page you wish to add a <a href="http://support.google.com/webmasters/bin/answer.py?hl=en&amp;answer=96569" target="_blank">rel="nofollow"</a>.]]></phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="urls" added="1336984743">URLs</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="successfully_added_a_new_url" added="1336984781">Successfully added a new URL.</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="provide_a_url" added="1336984796">Provide a URL.</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="successfully_added_a_new_meta_tag" added="1336990850">Successfully added a new meta tag.</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="keyword" added="1336991005">Keyword</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="custom_meta_tags" added="1336991043">Custom Meta Tags</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="add_new_meta" added="1336991058">Add New Meta</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="separate_keywords_with_commas" added="1336991101">Separate keywords with commas.</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="meta_keyword_descriptions" added="1336991188">Meta Keyword/Descriptions</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="provide_the_full_url_to_add_your_custom_meta_keywords_or_descriptions" added="1336991540">Provide the full URL to add your custom meta keywords or descriptions.</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta1" var_name="seo" added="1336993044">SEO</phrase>
		<phrase module_id="admincp" version_id="3.3.0beta2" var_name="to_your_left_you_will_find_all_the_available" added="1340288196"><![CDATA[To your left you will find all the available controllers that have blocks associated with them. Once you click on a controller it will list all the blocks and from there you can drag/drop	to order the positioning of each block. You can also "Enable DnD Mode", which will allow you to visually browse the site and drag/drop blocks as well as add new blocks on the spot.]]></phrase>
		<phrase module_id="admincp" version_id="3.3.0rc1" var_name="enable_dnd_mode" added="1341561848">Enable DnD Mode</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="admincp_priacy_control" added="1347438116">AdminCP Privacy Control</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="add_new_privacy_rule" added="1347438128">Add New Privacy Rule</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="provide_full_path" added="1347438216">Provide the full path to the URL you wish to add this rule to. We will then convert it to work with our internal URL system.</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="user_groups" added="1347438225">User Groups</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="select_a_user_group_this_rule_should_apply_to" added="1347438264">Select a user group this rule should apply to.</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="wildcard" added="1347438272">Wildcard</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="option_sub_section" added="1347438334">Enable this option if you wish to apply this rule to all sub-sections.</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="rules" added="1347438350">Rules</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="there_are_no_privacy_rules_at_the_moment" added="1347438380">There are no privacy rules at the moment.</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="provide_atleast_one_user_group_for_this_rule" added="1347438411">Provide atleast one user group for this rule.</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="general" added="1347866416">General</phrase>
		<phrase module_id="admincp" version_id="3.4.0beta1" var_name="admincp_privacy" added="1347866519">AdminCP Privacy</phrase>
		<phrase module_id="admincp" version_id="3.4.0rc1" var_name="save_your_notes_here" added="1349851420">Save your notes here...</phrase>
		<phrase module_id="admincp" version_id="3.4.0rc1" var_name="fix_birthdays" added="1349869890">Fix Birthdays</phrase>
		<phrase module_id="admincp" version_id="3.6.0beta2" var_name="custom_elements" added="1369660476">Custom Elements</phrase>
		<phrase module_id="admincp" version_id="3.6.0" var_name="add_new_element" added="1372494868">Add New Element</phrase>
		<phrase module_id="admincp" version_id="3.6.0" var_name="provide_the_full_url_to_add_your_custom_element" added="1372494888">Provide the full URL to add your custom element.</phrase>
		<phrase module_id="admincp" version_id="3.6.0" var_name="if_adding_keywords_make_sure_to_separate_them_with_commas" added="1372494902">If adding keywords make sure to separate them with commas.</phrase>
		<phrase module_id="admincp" version_id="3.7.0beta1" var_name="rewrite_url" added="1373976912">Rewrite URLs</phrase>
		<phrase module_id="admincp" version_id="3.7.0beta2" var_name="this_url" added="1376308242">This url</phrase>
		<phrase module_id="admincp" version_id="3.7.0beta2" var_name="will_show_this_page" added="1376308252">Will show this page</phrase>
		<phrase module_id="admincp" version_id="3.7.0beta2" var_name="add_new_rewrite" added="1376308259">Add New Rewrite</phrase>
		<phrase module_id="admincp" version_id="3.7.0rc1" var_name="uninstall_module_reminder" added="1377070561">Do not forget to remove the folder for this module from the /module/ folder</phrase>
		<phrase module_id="admincp" version_id="3.7.6beta1" var_name="check_modified_files" added="1395146962">Check Modified Files</phrase>
		<phrase module_id="admincp" version_id="3.7.6beta1" var_name="check_unknown_files" added="1395148783">Check Unknown Files</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="admincp" type="boolean" admin="1" user="0" guest="0" staff="0" module="admincp" ordering="2">can_clear_site_cache</setting>
		<setting is_admin_setting="0" module_id="admincp" type="boolean" admin="1" user="0" guest="0" staff="0" module="admincp" ordering="0">can_add_new_block</setting>
		<setting is_admin_setting="0" module_id="admincp" type="boolean" admin="1" user="0" guest="0" staff="0" module="admincp" ordering="0">can_view_product_options</setting>
		<setting is_admin_setting="0" module_id="admincp" type="boolean" admin="1" user="0" guest="0" staff="0" module="admincp" ordering="0">can_manage_modules</setting>
		<setting is_admin_setting="0" module_id="admincp" type="boolean" admin="1" user="0" guest="0" staff="0" module="admincp" ordering="0">can_add_new_modules</setting>
		<setting is_admin_setting="1" module_id="admincp" type="boolean" admin="1" user="0" guest="0" staff="1" module="admincp" ordering="0">has_admin_access</setting>
	</user_group_settings>
	<tables><![CDATA[a:1:{s:22:"phpfox_admincp_privacy";a:2:{s:7:"COLUMNS";a:6:{s:7:"rule_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:3:"url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"user_group";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"wildcard";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"rule_id";}}]]></tables>
</module>