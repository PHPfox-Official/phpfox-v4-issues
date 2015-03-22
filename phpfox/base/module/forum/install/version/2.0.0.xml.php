<upgrade>
	<phrases>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.0</version_id>
			<var_name>viewing_single_post</var_name>
			<added>1261175625</added>
			<value>Viewing Single Post</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.0</version_id>
			<var_name>forum_user_post_count</var_name>
			<added>1261399133</added>
			<value>Forum User Post Count</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>forum</module_id>
			<component>parent</component>
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
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:17:"phpfox_forum_post";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}}]]></sql>
	<update_templates>
		<file type="controller">thread.html.php</file>
		<file type="block">post.html.php</file>
	</update_templates>
</upgrade>