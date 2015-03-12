<upgrade>
	<phrases>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>user_setting_approve_all_comments</var_name>
			<added>1275006612</added>
			<value>Approve comments before they are displayed publicly?</value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>your_comment_has_successfully_been_added_however_it_is_pending_an_admins_approval</var_name>
			<added>1275010416</added>
			<value>Your comment has successfully been added, however it is pending an Admins approval.</value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>comments_approve</var_name>
			<added>1275010577</added>
			<value>Comments</value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>comment_approved_on_site_title</var_name>
			<added>1275012409</added>
			<value>Comment Approved on {site_title}</value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>one_of_your_comments_on_site_title</var_name>
			<added>1275012488</added>
			<value><![CDATA[One of your comments on {site_title} has been approved. To view this comment click the link below:
<a href="{link}">{link}</a>]]></value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>comment</module_id>
			<type>boolean</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>comment</module>
			<ordering>0</ordering>
			<value>approve_all_comments</value>
		</setting>
	</user_group_settings>
	<update_templates>
		<file type="block">entry.html.php</file>
		<file type="block">mini.html.php</file>
	</update_templates>
</upgrade>