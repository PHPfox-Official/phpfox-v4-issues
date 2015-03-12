<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>profile</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>show_empty_tabs</var_name>
			<phrase_var_name>setting_show_empty_tabs</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_show_empty_tabs</var_name>
			<added>1296735608</added>
			<value><![CDATA[<title>Show Empty Tabs</title><info>When this setting is enabled the script will show tabs for empty items in profiles, for example if a user has not yet uploaded a blog and this setting is enabled, the tab "Blogs" will still show in profiles.

If this setting is disabled there will be an extra query for each tab in profiles every time site cache is cleared.</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>info</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>14</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>12</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>menu</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>13</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>