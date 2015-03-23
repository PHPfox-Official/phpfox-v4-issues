<upgrade>
	<phpfox_update_settings>
		<setting>
			<group>search_engine_optimization</group>
			<module_id>quiz</module_id>
			<is_hidden>0</is_hidden>
			<type>large_string</type>
			<var_name>quiz_meta_description</var_name>
			<phrase_var_name>setting_quiz_meta_description</phrase_var_name>
			<ordering>16</ordering>
			<version_id>2.0.0rc1</version_id>
			<value><![CDATA[Take Free Fun Quizzes & Tests. Cool Online Fun Quiz & Test. Fun Quizzes and Fun Tests by Site Name.]]></value>
		</setting>
	</phpfox_update_settings>
	<phpfox_update_menus>
		<menu>
			<module_id>quiz</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_quiz</var_name>
			<ordering>28</ordering>
			<url_value>quiz</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>quiz</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<phpfox_update_user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>quiz</module_id>
			<type>boolean</type>
			<admin>true</admin>
			<user>true</user>
			<guest>false</guest>
			<staff>true</staff>
			<module>quiz</module>
			<ordering>0</ordering>
			<value>can_edit_own_title</value>
		</setting>
	</phpfox_update_user_group_settings>
	<sql><![CDATA[a:5:{s:11:"ALTER_FIELD";a:1:{s:11:"phpfox_quiz";a:1:{s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ADD_FIELD";a:1:{s:11:"phpfox_quiz";a:2:{s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:11:"phpfox_quiz";a:3:{s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"user_id";i:2;s:7:"privacy";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:5:"title";i:2;s:7:"privacy";}}}}s:9:"ALTER_KEY";a:1:{s:11:"phpfox_quiz";a:1:{s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"user_id";}}}}s:10:"REMOVE_KEY";a:1:{s:11:"phpfox_quiz";a:1:{i:0;a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}}}}]]></sql>
</upgrade>