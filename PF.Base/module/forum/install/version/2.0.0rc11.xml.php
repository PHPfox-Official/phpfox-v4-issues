<upgrade>
	<phrases>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>user_setting_can_view_forum</var_name>
			<added>1260276741</added>
			<value>Can browse and view the forum module?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>forum_thread_post_count</var_name>
			<added>1260291719</added>
			<value>Forum Thread/Post Count</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>1</guest>
			<staff>1</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>can_view_forum</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>forum</module_id>
			<hook_type>service</hook_type>
			<module>forum</module>
			<call_name>forum.service_process_add__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>service</hook_type>
			<module>forum</module>
			<call_name>forum.service_thread_process_add__start</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>service</hook_type>
			<module>forum</module>
			<call_name>forum.service_thread_process_add__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">thread.html.php</file>
		<file type="block">copy.html.php</file>
		<file type="block">move.html.php</file>
		<file type="block">post.html.php</file>
	</update_templates>
</upgrade>