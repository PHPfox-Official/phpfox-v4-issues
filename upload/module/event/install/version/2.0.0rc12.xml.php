<upgrade>
	<phrases>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_event_a</var_name>
			<added>1260455427</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">event</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_their_own_a_href_link_event_a</var_name>
			<added>1260455449</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked their own <a href="{link}">event</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_your_a_href_link_event_a</var_name>
			<added>1260456261</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked your <a href="{link}">event</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>can_create_event</var_name>
			<added>1260904019</added>
			<value>Create Event</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>select_a_sub_category</var_name>
			<added>1260971268</added>
			<value>Select a Sub-Category</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>event</module_id>
			<component>profile</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:11:"ALTER_FIELD";a:1:{s:21:"phpfox_event_category";a:1:{s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="block">profile.html.php</file>
		<file type="block">category.html.php</file>
	</update_templates>
</upgrade>