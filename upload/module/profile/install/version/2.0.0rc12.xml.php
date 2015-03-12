<upgrade>
	<phrases>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_your_recent_profile_a_href_link_design_a</var_name>
			<added>1260461900</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes your recent profile design.]]></value>
		</phrase>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_their_own_profile_a_href_link_design_a</var_name>
			<added>1260462181</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked their own profile <a href="{link}">design</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_profile_a_href_link_design_a</var_name>
			<added>1260462206</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s profile <a href="{link}">design</a>.]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>info</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>15</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>3</location>
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
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>menu</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>14</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="controller">private.html.php</file>
	</update_templates>
</upgrade>