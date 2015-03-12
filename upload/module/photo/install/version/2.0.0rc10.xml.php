<upgrade>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc10</version_id>
			<var_name>menu_photo_albums</var_name>
			<added>1259613604</added>
			<value>Photo Albums</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc10</version_id>
			<var_name>photo_count_for_photo_albums</var_name>
			<added>1259673154</added>
			<value>Photo Count for Photo Albums</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc10</version_id>
			<var_name>by_full_name</var_name>
			<added>1259673587</added>
			<value>By: {full_name}</value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>photo</module_id>
			<parent_id>0</parent_id>
			<m_connection>photo.index</m_connection>
			<var_name>menu_photo_albums</var_name>
			<ordering>92</ordering>
			<url_value>photo.public-album</url_value>
			<version_id>2.0.0rc10</version_id>
			<disallow_access />
			<module>photo</module>
			<value />
		</menu>
	</menus>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>photo</module_id>
			<component>profile</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.index</m_connection>
			<module_id>photo</module_id>
			<component>category</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.index</m_connection>
			<module_id>photo</module_id>
			<component>featured</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.index</m_connection>
			<module_id>photo</module_id>
			<component>filter</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.view</m_connection>
			<module_id>photo</module_id>
			<component>detail</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.view</m_connection>
			<module_id>photo</module_id>
			<component>menu</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.album</m_connection>
			<module_id>photo</module_id>
			<component>menu-album</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.rate</m_connection>
			<module_id>photo</module_id>
			<component>stat</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.rate</m_connection>
			<module_id>photo</module_id>
			<component>category</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.battle</m_connection>
			<module_id>photo</module_id>
			<component>category</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>photo</module_id>
			<component>parent</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:18:"phpfox_photo_album";a:1:{s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:8:"group_id";i:2;s:7:"privacy";}}}}}]]></sql>
	<update_templates>
		<file type="block">album-entry.html.php</file>
		<file type="block">menu.html.php</file>
	</update_templates>
</upgrade>