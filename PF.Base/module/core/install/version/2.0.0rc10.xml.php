<upgrade>
	<settings>
		<setting>
			<group>mail</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>mail_smtp_port</var_name>
			<phrase_var_name>setting_mail_smtp_port</phrase_var_name>
			<ordering>9</ordering>
			<version_id>2.0.0rc9</version_id>
			<value>25</value>
		</setting>
		<setting>
			<group>time_stamps</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>conver_time_to_string</var_name>
			<phrase_var_name>setting_conver_time_to_string</phrase_var_name>
			<ordering>11</ordering>
			<version_id>2.0.0rc10</version_id>
			<value>g:i a</value>
		</setting>
		<setting>
			<group>time_stamps</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>global_welcome_time_stamp</var_name>
			<phrase_var_name>setting_global_welcome_time_stamp</phrase_var_name>
			<ordering>12</ordering>
			<version_id>2.0.0rc10</version_id>
			<value>l, F j, Y g:i A</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>menu_core_friends</var_name>
			<added>1220960932</added>
			<value>Friends</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc9</version_id>
			<var_name>setting_mail_smtp_port</var_name>
			<added>1259174724</added>
			<value><![CDATA[<title>SMTP Port</title><info>What port to use for sending mail with SMTP? Default is 25</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc10</version_id>
			<var_name>setting_conver_time_to_string</var_name>
			<added>1259600267</added>
			<value><![CDATA[<title>Time to String</title><info>Time to String</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc10</version_id>
			<var_name>setting_global_welcome_time_stamp</var_name>
			<added>1259613089</added>
			<value><![CDATA[<title>Global Welcome Time Stamp</title><info>Global Welcome Time Stamp</info>]]></value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>core</module_id>
			<parent_id>0</parent_id>
			<m_connection>main</m_connection>
			<var_name>menu_core_friends</var_name>
			<ordering>5</ordering>
			<url_value>friend</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>core</module>
			<value />
		</menu>
	</menus>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>welcome</component>
			<location>7</location>
			<is_active>1</is_active>
			<ordering>13</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-visitor</m_connection>
			<module_id>core</module_id>
			<component>new</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>dashboard</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>10</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>new</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>12</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>stat</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>9</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>admincp.index</m_connection>
			<module_id>core</module_id>
			<component>note</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>admincp.index</m_connection>
			<module_id>core</module_id>
			<component>active-admin</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>admincp.index</m_connection>
			<module_id>core</module_id>
			<component>news</component>
			<location>3</location>
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
			<m_connection>admincp.index</m_connection>
			<module_id>core</module_id>
			<component>twitter</component>
			<location>3</location>
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
			<m_connection>admincp.index</m_connection>
			<module_id>core</module_id>
			<component>site-stat</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>admincp.index</m_connection>
			<module_id>core</module_id>
			<component>latest-admin-login</component>
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
			<m_connection>admincp.index</m_connection>
			<module_id>core</module_id>
			<component>quick-find</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:4:{s:12:"phpfox_block";a:1:{s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:14:"phpfox_country";a:1:{s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:20:"phpfox_country_child";a:1:{s:15:"phrase_var_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:14:"phpfox_product";a:2:{s:14:"latest_version";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"last_check";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
	<update_templates>
		<file type="layout">email.html.php</file>
	</update_templates>
	<update_styles>
		<file type="layout">layout.css</file>
	</update_styles>
</upgrade>