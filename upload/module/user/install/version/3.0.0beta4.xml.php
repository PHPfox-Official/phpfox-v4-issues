<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enable_relationship_status</var_name>
			<phrase_var_name>setting_enable_relationship_status</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0beta4</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.0.0beta4</version_id>
			<var_name>menu_user_account_settings_73c8da87d666df89aabd61620c81c24c</var_name>
			<added>1317128919</added>
			<value>Account Settings</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.0.0beta4</version_id>
			<var_name>menu_user_privacy_settings_73c8da87d666df89aabd61620c81c24c</var_name>
			<added>1317128967</added>
			<value>Privacy Settings</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.0.0beta4</version_id>
			<var_name>setting_enable_relationship_status</var_name>
			<added>1317129649</added>
			<value><![CDATA[<title>Enable Relationships</title><info>If you would like your users to have the ability to set their relationship statues on your community enable this feature.</info>]]></value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>user</module_id>
			<parent_var_name>menu_settings</parent_var_name>
			<m_connection />
			<var_name>menu_user_account_settings_73c8da87d666df89aabd61620c81c24c</var_name>
			<ordering>107</ordering>
			<url_value>user.setting</url_value>
			<version_id>3.0.0beta4</version_id>
			<disallow_access />
			<module>user</module>
			<value />
		</menu>
		<menu>
			<module_id>user</module_id>
			<parent_var_name>menu_settings</parent_var_name>
			<m_connection />
			<var_name>menu_user_privacy_settings_73c8da87d666df89aabd61620c81c24c</var_name>
			<ordering>108</ordering>
			<url_value>user.privacy</url_value>
			<version_id>3.0.0beta4</version_id>
			<disallow_access />
			<module>user</module>
			<value />
		</menu>
	</menus>
	<phpfox_update_menus>
		<menu>
			<module_id>user</module_id>
			<parent_var_name>menu_settings</parent_var_name>
			<m_connection />
			<var_name>menu_user_logout_4ee1a589029a67e7f1a00990a1786f46</var_name>
			<ordering>109</ordering>
			<url_value>user.logout</url_value>
			<version_id>3.0.0Beta1</version_id>
			<disallow_access><![CDATA[a:1:{i:0;s:1:"3";}]]></disallow_access>
			<module>user</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:2:{s:17:"phpfox_user_field";a:1:{s:15:"signature_clean";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:25:"phpfox_user_group_setting";a:1:{s:9:"is_hidden";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>