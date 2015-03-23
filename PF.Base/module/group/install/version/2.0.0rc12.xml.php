<upgrade>
	<phrases>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_your_a_href_link_group_a</var_name>
			<added>1260471969</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">group</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_their_own_a_href_link_group_a</var_name>
			<added>1260471991</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">group</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_group_a</var_name>
			<added>1260472004</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">group</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>user_setting_can_manage_all_groups</var_name>
			<added>1260896108</added>
			<value>Can manage all groups?</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>group_access</var_name>
			<added>1260914592</added>
			<value>Group Access</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>group_posting_privileges</var_name>
			<added>1260914603</added>
			<value>Group Posting Privileges</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>group</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>group</module>
			<ordering>0</ordering>
			<value>can_manage_all_groups</value>
		</setting>
	</user_group_settings>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>group</module_id>
			<component>profile</component>
			<location>1</location>
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
			<m_connection>group.view</m_connection>
			<module_id>group</module_id>
			<component>list</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>group</module_id>
			<component>image</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>11</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>group</module_id>
			<component>menu</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>12</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:11:"ALTER_FIELD";a:1:{s:21:"phpfox_group_category";a:1:{s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
	<update_templates>
		<file type="controller">add.html.php</file>
		<file type="block">profile.html.php</file>
		<file type="block">category.html.php</file>
	</update_templates>
</upgrade>