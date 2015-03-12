<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enable_mass_uploader</var_name>
			<phrase_var_name>setting_enable_mass_uploader</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.8</version_id>
			<var_name>the_following_files_were_not_uploaded_because_their_size_exceeds_the_limit_of_ilimit_sfiles</var_name>
			<added>1294924698</added>
			<value>The following files were not uploaded because their size exceeds the limit of {iLimit}: {sFiles}</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_enable_mass_uploader</var_name>
			<added>1294927024</added>
			<value><![CDATA[<title>Enable Mass Uploader</title><info>When enabled users will be allowed to use a mass photo uploader to select multiple files from a single file select dialog.

This uses an integration of SWFUpload (http://code.google.com/p/swfupload/) and thus it uses a Flash object.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.8</version_id>
			<var_name>use_simple_uploader</var_name>
			<added>1296651153</added>
			<value>Use simple uploader</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.8</version_id>
			<var_name>use_mass_uploader</var_name>
			<added>1296651172</added>
			<value>Use mass uploader</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>photo</module_id>
			<component>profile</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>10</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>