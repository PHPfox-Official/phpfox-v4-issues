<upgrade>
	<phrases>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>full_name_replied_to_the_thread_title_with_link</var_name>
			<added>1256558977</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> replied to the thread "<a href="{thread_link}">{title}</a>".]]></value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.0rc3</version_id>
			<var_name>full_name_replied_to_the_thread_title</var_name>
			<added>1254471921</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> replied to the thread "<a href="{link}">{title}</a>".]]></value>
		</phrase>
	</phpfox_update_phrases>
	<phpfox_update_user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>can_edit_own_post</value>
		</setting>
	</phpfox_update_user_group_settings>
	<update_templates>
		<file type="controller">post.html.php</file>
		<file type="controller">thread.html.php</file>
	</update_templates>
</upgrade>