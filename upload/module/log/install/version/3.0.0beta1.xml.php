<upgrade>
	<phpfox_update_settings>
		<setting>
			<group>server_settings</group>
			<module_id>log</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>active_session</var_name>
			<phrase_var_name>setting_active_session</phrase_var_name>
			<ordering>2</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value>15</value>
		</setting>
	</phpfox_update_settings>
	<components>
		<component>
			<module_id>log</module_id>
			<component>users</component>
			<m_connection />
			<module>log</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>forum.index</m_connection>
			<module_id>log</module_id>
			<component>active-users</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Users Online</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>log</module_id>
			<component>login</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-visitor</m_connection>
			<module_id>log</module_id>
			<component>login</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Recent Logins</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>