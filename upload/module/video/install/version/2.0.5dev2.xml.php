<upgrade>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>user_setting_flood_control_videos</var_name>
			<added>1275107164</added>
			<value><![CDATA[How many minutes should a user wait before they can share/upload another video?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>you_are_sharing_a_video_a_little_too_soon</var_name>
			<added>1275107266</added>
			<value>You are sharing a video a little too soon.</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>you_are_uploading_a_video_a_little_too_soon</var_name>
			<added>1275107571</added>
			<value>You are uploading a video a little too soon.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>video</module_id>
			<type>integer</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>video</module>
			<ordering>0</ordering>
			<value>flood_control_videos</value>
		</setting>
	</user_group_settings>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:12:"phpfox_video";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"user_id";}}}}}]]></sql>
</upgrade>