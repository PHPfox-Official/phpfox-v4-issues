<upgrade>
	<phrases>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_your_a_href_link_comment_a</var_name>
			<added>1260473572</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">comment</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_their_own_a_href_link_coment_a</var_name>
			<added>1260483353</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">coment</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_comment_a</var_name>
			<added>1260483372</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">comment</a>.]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>comment</module_id>
			<component>display</component>
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
			<m_connection>group.view</m_connection>
			<module_id>comment</module_id>
			<component>display</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>10</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="block">display.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">view-top.html.php</file>
		<file type="block">mini.html.php</file>
	</update_templates>
</upgrade>