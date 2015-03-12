<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>use_md5_for_file_names</var_name>
			<phrase_var_name>setting_use_md5_for_file_names</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.2.0rc1</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>3.2.0rc1</version_id>
			<var_name>setting_use_md5_for_file_names</var_name>
			<added>1334918381</added>
			<value><![CDATA[<title>Use MD5 for File Names</title><info>If enabled the script will use an md5 hash for the file names of every uploaded file.

If you disable it extra checks will be added to try to preserve the original name of the file. If an item with the same name already exists the new one will have a number added at the end.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>core</module_id>
			<hook_type>controller</hook_type>
			<module>core</module>
			<call_name>core.component_controller_admincp_stat_clean</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>