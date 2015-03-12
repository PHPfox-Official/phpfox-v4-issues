<upgrade>
	<settings>
		<setting>
			<group>cdn_content_delivery_network</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>keep_files_in_server</var_name>
			<phrase_var_name>setting_keep_files_in_server</phrase_var_name>
			<ordering>15</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>google_api_key</var_name>
			<phrase_var_name>setting_google_api_key</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value />
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_keep_files_in_server</var_name>
			<added>1353415860</added>
			<value><![CDATA[<title>Keep Files In Server</title><info>After a file has been uploaded to the CDN, should we delete the original file in this server?</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_google_api_key</var_name>
			<added>1353588797</added>
			<value><![CDATA[<title>Google API Key</title><info>Google offers many services that require an API key (like the Places service), enter your Google API key here.

More information on how to get an API key can be found <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">here</a>.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_template_getstyle_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_template_getlayoutfile_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>template_template_getmenu_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_module_getmoduleblocks_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_phpfox_file_file_upload_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_phpfox_file_file_upload_2</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_phpfox_file_file_upload_3</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_phpfox_ismobile</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.template_block_template_menu_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>controller</hook_type>
			<module>core</module>
			<call_name>core.component_controller_full_clean</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>