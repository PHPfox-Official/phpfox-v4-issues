<upgrade>
	<phrases>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0</version_id>
			<var_name>unselect</var_name>
			<added>1261233215</added>
			<value>Unselect</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0beta4</version_id>
			<var_name>setting_enable_birthday_notices</var_name>
			<added>1244723490</added>
			<value><![CDATA[<title>Enable Birthday Notices</title><info>When enabled users will see a list of their friends upcoming birthdays.</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<hooks>
		<hook>
			<module_id>friend</module_id>
			<hook_type>service</hook_type>
			<module>friend</module>
			<call_name>friend.service_suggestion__build_search</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>friend</module_id>
			<hook_type>controller</hook_type>
			<module>friend</module>
			<call_name>friend.component_controller_suggestion_clean</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="block">birthday.html.php</file>
		<file type="block">suggestion.html.php</file>
		<file type="block">mini.html.php</file>
	</update_templates>
</upgrade>