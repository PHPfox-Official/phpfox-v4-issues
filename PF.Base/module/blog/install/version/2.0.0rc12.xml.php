<upgrade>
	<phrases>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_your_a_href_link_blog_a</var_name>
			<added>1260472335</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">blog</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_their_own_a_href_link_blog_a</var_name>
			<added>1260472354</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">blog</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_blog_a</var_name>
			<added>1260472367</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">blog</a>.]]></value>
		</phrase>
	</phrases>
	<update_templates>
		<file type="block">top.html.php</file>
	</update_templates>
</upgrade>