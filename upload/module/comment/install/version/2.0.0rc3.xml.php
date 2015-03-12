<upgrade>
	<phrases>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc3</version_id>
			<var_name>user_setting_can_delete_comments_posted_on_own_profile</var_name>
			<added>1254142484</added>
			<value>Can this user group delete comments posted on their own profile?</value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc3</version_id>
			<var_name>no_comments_added</var_name>
			<added>1254575996</added>
			<value>No comments added.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>comment</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>comment</module>
			<ordering>0</ordering>
			<value>can_delete_comments_posted_on_own_profile</value>
		</setting>
	</user_group_settings>
	<update_templates>
		<file type="block">view.html.php</file>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>