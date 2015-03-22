<upgrade>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>profile_comments</var_name>
			<added>1275017584</added>
			<value>Profile Comments</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>profile_comment_s_successfully_approved</var_name>
			<added>1275019497</added>
			<value>Profile comment(s) successfully approved.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>nothing_to_approve_at_this_time</var_name>
			<added>1275019538</added>
			<value>Nothing to approve at this time.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>profile_comment_s_successfully_deleted</var_name>
			<added>1275019685</added>
			<value>Profile comment(s) successfully deleted.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>profile_feed_comments</var_name>
			<added>1275020064</added>
			<value>Profile Feed Comments</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>id</var_name>
			<added>1275020070</added>
			<value>ID#</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>owner</var_name>
			<added>1275020076</added>
			<value>Owner</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>profile</var_name>
			<added>1275020082</added>
			<value>Profile</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>posted_on</var_name>
			<added>1275020089</added>
			<value>Posted On</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>content</var_name>
			<added>1275020095</added>
			<value>Content</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>approve_selected</var_name>
			<added>1275020108</added>
			<value>Approve Selected</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>deny_selected</var_name>
			<added>1275020115</added>
			<value>Deny Selected</value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_feed";a:1:{s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:11:"phpfox_feed";a:2:{s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"type_id";i:2;s:12:"item_user_id";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"user_id";}}}}}]]></sql>
	<update_templates>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>