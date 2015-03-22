<upgrade>
	<phrases>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>user_setting_approve_blogs</var_name>
			<added>1274842829</added>
			<value>Approve blogs before they are publicly displayed?</value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>recent_blogs</var_name>
			<added>1274843713</added>
			<value>Recent Blogs</value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>most_disccused</var_name>
			<added>1274843732</added>
			<value>Most Disccused</value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>most_discussed</var_name>
			<added>1274843742</added>
			<value>Most Discussed</value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>pending</var_name>
			<added>1274843749</added>
			<value>Pending</value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>there_are_blogs_pending_approval_total_total</var_name>
			<added>1274843907</added>
			<value>There are blogs pending approval. Total: {total}</value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>approve_blogs_here</var_name>
			<added>1274843988</added>
			<value>Approve blogs here.</value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>user_setting_flood_control_blog</var_name>
			<added>1275105423</added>
			<value><![CDATA[How many minutes should a user wait before they can submit another blog?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>your_are_posting_a_little_too_soon</var_name>
			<added>1275105712</added>
			<value>You are posting a little too soon.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>blog</module_id>
			<type>boolean</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>blog</module>
			<ordering>0</ordering>
			<value>approve_blogs</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>blog</module_id>
			<type>integer</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>blog</module>
			<ordering>0</ordering>
			<value>flood_control_blog</value>
		</setting>
	</user_group_settings>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:11:"phpfox_blog";a:1:{s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}}]]></sql>
	<update_templates>
		<file type="controller">index.html.php</file>
	</update_templates>
</upgrade>