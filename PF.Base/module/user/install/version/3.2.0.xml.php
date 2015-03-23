<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>drop</type>
			<var_name>user_browse_display_results_default</var_name>
			<phrase_var_name>setting_user_browse_display_results_default</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha3</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:10:"name_photo";s:6:"values";a:2:{i:0;s:10:"name_photo";i:1;s:17:"name_photo_detail";}}]]></value>
		</setting>
	</phpfox_update_settings>
	<hooks>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_setting_settitle</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_add_1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>