<upgrade>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>user_setting_can_access_videos</var_name>
			<added>1260286300</added>
			<value>Can browse and view the video module?</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>video</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>1</guest>
			<staff>1</staff>
			<module>video</module>
			<ordering>0</ordering>
			<value>can_access_videos</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>video</module_id>
			<hook_type>service</hook_type>
			<module>video</module>
			<call_name>video.service_process_addShareVideo__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>service</hook_type>
			<module>video</module>
			<call_name>video.service_process_add__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>service</hook_type>
			<module>video</module>
			<call_name>video.service_grab_parse__start</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>service</hook_type>
			<module>video</module>
			<call_name>video.service_grab_parse__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>