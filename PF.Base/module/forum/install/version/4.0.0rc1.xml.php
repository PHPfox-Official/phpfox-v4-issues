<upgrade>
	<phpfox_update_menus>
		<menu>
			<module_id>forum</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_forum</var_name>
			<ordering>23</ordering>
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
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>forum</m_connection>
			<module_id>forum</module_id>
			<component>forums</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Forums</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
</upgrade>