<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>close_sql_connection_while_converting</var_name>
			<phrase_var_name>setting_close_sql_connection_while_converting</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.7</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.7</version_id>
			<var_name>setting_close_sql_connection_while_converting</var_name>
			<added>1288619093</added>
			<value><![CDATA[<title>Close SQL Connection During Conversion</title><info>Enable this option to close the SQL connection while converting videos.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>video</module_id>
			<hook_type>service</hook_type>
			<module>video</module>
			<call_name>video.service_process_addsharevideo__start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>service</hook_type>
			<module>video</module>
			<call_name>video.service_callback_getnewsfeed_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>template</hook_type>
			<module>video</module>
			<call_name>video.template_block_entry_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>template</hook_type>
			<module>video</module>
			<call_name>video.template_block_entry_2</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>template</hook_type>
			<module>video</module>
			<call_name>video.template_block_entry_3</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>template</hook_type>
			<module>video</module>
			<call_name>video.template_block_entry_4</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>template</hook_type>
			<module>video</module>
			<call_name>video.template_block_entry_5</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>template</hook_type>
			<module>video</module>
			<call_name>video.template_block_entry_6</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>template</hook_type>
			<module>video</module>
			<call_name>video.template_block_menu</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_view_end</call_name>
			<added>1290072896</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>