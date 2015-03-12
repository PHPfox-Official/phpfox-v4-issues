<upgrade>
	<phrases>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_their_own_a_href_link_song_a</var_name>
			<added>1260453013</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked their own <a href="{link}">song</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_song_a</var_name>
			<added>1260453036</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">song</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_your_a_href_link_song_a</var_name>
			<added>1260457612</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked your <a href="{link}">song</a>.]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>music</module_id>
			<component>album</component>
			<location>2</location>
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
			<m_connection>profile.index</m_connection>
			<module_id>music</module_id>
			<component>song</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>16</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>