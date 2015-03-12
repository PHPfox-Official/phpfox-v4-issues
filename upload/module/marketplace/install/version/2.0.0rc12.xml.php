<upgrade>
	<phrases>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_your_a_href_link_listing_a</var_name>
			<added>1260470252</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">listing</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_their_own_a_href_link_listing_a</var_name>
			<added>1260470283</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">listing</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_listing_a</var_name>
			<added>1260470300</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">listing</a>.]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>marketplace</module_id>
			<component>profile</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:11:"ALTER_FIELD";a:1:{s:27:"phpfox_marketplace_category";a:1:{s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="block">category.html.php</file>
	</update_templates>
</upgrade>