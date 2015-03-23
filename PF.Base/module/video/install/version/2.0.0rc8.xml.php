<upgrade>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>user_setting_points_video</var_name>
			<added>1258461532</added>
			<value>Points received when adding a video.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>video</module_id>
			<type>integer</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>video</module>
			<ordering>0</ordering>
			<value>points_video</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_related_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_filter_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_my_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_spotlight_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_video";a:1:{s:9:"is_viewed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
	<update_templates>
		<file type="controller">view.html.php</file>
	</update_templates>
</upgrade>