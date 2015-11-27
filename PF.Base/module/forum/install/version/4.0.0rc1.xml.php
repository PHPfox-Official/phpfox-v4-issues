<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>forum</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>forum_time_stamp</var_name>
			<phrase_var_name>setting_forum_time_stamp</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value>M j, g:i a</value>
		</setting>
		<setting>
			<group />
			<module_id>forum</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>forum_user_time_stamp</var_name>
			<phrase_var_name>setting_forum_user_time_stamp</phrase_var_name>
			<ordering>2</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value>F j, Y</value>
		</setting>
		<setting>
			<group />
			<module_id>forum</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>global_forum_timezone</var_name>
			<phrase_var_name>setting_global_forum_timezone</phrase_var_name>
			<ordering>3</ordering>
			<version_id>2.0.5</version_id>
			<value>g:i a</value>
		</setting>
	</phpfox_update_settings>
	<phpfox_update_menus>
		<menu>
			<module_id>forum</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_forum</var_name>
			<ordering>5</ordering>
			<url_value>forum</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>forum</module>
			<mobile_icon>comments</mobile_icon>
			<value />
		</menu>
	</phpfox_update_menus>
	<components>
		<component>
			<module_id>forum</module_id>
			<component>forums</component>
			<m_connection />
			<module>forum</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>forum</module_id>
			<component>forum</component>
			<m_connection>forum.forum</m_connection>
			<module>forum</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>forum</module_id>
			<component>recent</component>
			<m_connection />
			<module>forum</module>
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
			<module_id>forum</module_id>
			<component>recent</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Recent Threads</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>forum.forum</m_connection>
			<module_id>forum</module_id>
			<component>recent</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Recent Posts</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
</upgrade>