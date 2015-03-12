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
			<value />
		</menu>
	</phpfox_update_menus>
	<components>
		<component>
			<module_id>forum</module_id>
			<component>stat</component>
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
			<component>stat</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Forum Stats</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>forum</module_id>
			<component>parent</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:17:"phpfox_forum_post";a:1:{s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:19:"phpfox_forum_thread";a:3:{s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"thread_id";i:1;s:8:"group_id";}}s:8:"start_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"start_id";}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:5:"title";}}}}}]]></sql>
</upgrade>