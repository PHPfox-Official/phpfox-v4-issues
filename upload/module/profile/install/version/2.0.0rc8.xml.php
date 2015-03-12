<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>profile</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>can_rate_on_users_profile</var_name>
			<phrase_var_name>setting_can_rate_on_users_profile</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc8</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>setting_can_rate_on_users_profile</var_name>
			<added>1258556786</added>
			<value><![CDATA[<title>Allow Rating of Users via Profile</title><info>Enable this option to allow your members the ability to rate other members via their profile.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>profile</module_id>
			<hook_type>controller</hook_type>
			<module>profile</module>
			<call_name>profile.component_controller_designer_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="block">header.html.php</file>
		<file type="block">info.html.php</file>
	</update_templates>
</upgrade>