<upgrade>
	<phrases>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0beta2</version_id>
			<var_name>menu_friend_friends</var_name>
			<added>1242569898</added>
			<value>Friends</value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>friend</module_id>
			<parent_id>0</parent_id>
			<m_connection>profile</m_connection>
			<var_name>menu_friend_friends</var_name>
			<ordering>16</ordering>
			<url_value>profile.friend</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>friend</module>
			<value />
		</menu>
	</menus>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>mini</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>friend</module_id>
			<component>profile.small</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>friend.index</m_connection>
			<module_id>friend</module_id>
			<component>top</component>
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
			<m_connection>friend.index</m_connection>
			<module_id>friend</module_id>
			<component>list</component>
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
			<m_connection>friend.profile</m_connection>
			<module_id>friend</module_id>
			<component>top</component>
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
			<m_connection>friend.profile</m_connection>
			<module_id>friend</module_id>
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
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>birthday</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>friend</module_id>
			<component>mutual-friend</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>105</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>suggestion</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="block">birthday.html.php</file>
	</update_templates>
</upgrade>