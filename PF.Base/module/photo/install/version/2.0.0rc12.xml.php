<upgrade>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_their_own_a_href_link_photo_album_a</var_name>
			<added>1260451144</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked their own <a href="{link}">photo album</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_photo_album_a</var_name>
			<added>1260451210</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">photo album</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_photo_a</var_name>
			<added>1260452199</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">photo</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_their_own_a_href_link_photo_a</var_name>
			<added>1260452218</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked their own <a href="{link}">photo</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_your_a_href_link_photo_album_a</var_name>
			<added>1260458422</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked your <a href="{link}">photo album</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_liked_your_a_href_link_photo_a</var_name>
			<added>1260459387</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> liked your <a href="{link}">photo</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>part_of_the_photo_album</var_name>
			<added>1260896980</added>
			<value>Part of the photo album</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>full_name_s_albums</var_name>
			<added>1260897047</added>
			<value><![CDATA[{full_name}'s Albums]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>photo</module_id>
			<component>profile</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>11</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>photo</module_id>
			<component>parent</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>9</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:11:"ALTER_FIELD";a:1:{s:21:"phpfox_photo_category";a:1:{s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="block">album-entry.html.php</file>
		<file type="block">category.html.php</file>
	</update_templates>
</upgrade>