<upgrade>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>user_setting_flood_control_photos</var_name>
			<added>1275105927</added>
			<value><![CDATA[How many minutes should a user wait before they can upload another batch of photos?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>uploading_photos_a_little_too_soon</var_name>
			<added>1275105953</added>
			<value>Uploading photos a little too soon.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>photo</module_id>
			<type>integer</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>photo</module>
			<ordering>0</ordering>
			<value>flood_control_photos</value>
		</setting>
	</user_group_settings>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:12:"phpfox_photo";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}}]]></sql>
</upgrade>