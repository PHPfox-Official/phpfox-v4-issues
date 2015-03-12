<module>
	<data>
		<module_id>help</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_help</phrase_var_name>
		<writable />
	</data>
	<hooks>
		<hook module_id="help" hook_type="component" module="help" call_name="help.component_block_close_tips_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="help" hook_type="component" module="help" call_name="help.component_block_popup_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="help" hook_type="component" module="help" call_name="help.component_block_popup_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="help" hook_type="component" module="help" call_name="help.component_block_info_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="help" hook_type="service" module="help" call_name="help.service_help__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="help" hook_type="service" module="help" call_name="help.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
	</hooks>
	<components>
		<component module_id="help" component="popup" m_connection="" module="help" is_controller="0" is_block="1" is_active="1" />
		<component module_id="help" component="info" m_connection="" module="help" is_controller="0" is_block="1" is_active="1" />
		<component module_id="help" component="ajax" m_connection="" module="help" is_controller="0" is_block="0" is_active="1" />
		<component module_id="help" component="close-tips" m_connection="" module="help" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="help" version_id="2.0.0alpha1" var_name="user_setting_show_tips" added="1219325863">Show tips?</phrase>
		<phrase module_id="help" version_id="2.0.0alpha1" var_name="module_help" added="1219157383">Help</phrase>
		<phrase module_id="help" version_id="2.0.0alpha1" var_name="add_new_phrase" added="1213990180">Add New Phrase</phrase>
		<phrase module_id="help" version_id="2.0.0alpha1" var_name="click_for_help" added="1213990238">Click for Help</phrase>
		<phrase module_id="help" version_id="2.0.0alpha1" var_name="hide_all_tips" added="1219325791">Hide All Tips</phrase>
		<phrase module_id="help" version_id="2.0.0alpha1" var_name="close" added="1219325807">Close</phrase>
		<phrase module_id="help" version_id="2.0.0alpha1" var_name="hide_this_tip" added="1219328167">Hide This Tip</phrase>
		<phrase module_id="help" version_id="2.0.0alpha1" var_name="add_back_tips_info" added="1219328306"><![CDATA[<b>Note:</b> If you close all tips found on this site you can edit your <b>Account Settings</b> to view tips again.]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="help" type="boolean" admin="1" user="1" guest="1" staff="1" module="help" ordering="0">show_tips</setting>
	</user_group_settings>
	<tables><![CDATA[a:1:{s:11:"phpfox_help";a:2:{s:7:"COLUMNS";a:6:{s:7:"help_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;s:6:"phpfox";i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"updated";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"help_id";}}]]></tables>
</module>