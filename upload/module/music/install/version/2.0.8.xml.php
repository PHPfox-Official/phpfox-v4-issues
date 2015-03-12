<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>music</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>music_enable_mass_uploader</var_name>
			<phrase_var_name>setting_music_enable_mass_uploader</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_music_enable_mass_uploader</var_name>
			<added>1294995190</added>
			<value><![CDATA[<title>Enable Mass Uploader</title><info>When enabled users will be allowed to use a mass song uploader to select multiple files from a single file select dialog.

This uses an integration of SWFUpload (http://code.google.com/p/swfupload/) and thus it uses a Flash object.</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>music</module_id>
			<component>song</component>
			<location>3</location>
			<is_active>0</is_active>
			<ordering>15</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>music</module_id>
			<component>profile</component>
			<location>3</location>
			<is_active>0</is_active>
			<ordering>16</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Favorite Songs</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>