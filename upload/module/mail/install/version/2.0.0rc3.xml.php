<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>mail</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>show_preview_message</var_name>
			<phrase_var_name>setting_show_preview_message</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc3</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.0rc3</version_id>
			<var_name>setting_show_preview_message</var_name>
			<added>1254749315</added>
			<value><![CDATA[<title>Show Preview Message</title><info>If enabled, users will see a short version of their messages.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.0rc3</version_id>
			<var_name>user_setting_send_message_to_max_users_each_time</var_name>
			<added>1254829395</added>
			<value>This value restricts sending private messages.
It sets the maximum number of recipients when sending private messages, avoiding users to select way too many users and potentially spamming.

Set to 0 for unlimited.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>mail</module_id>
			<type>integer</type>
			<admin>0</admin>
			<user>50</user>
			<guest>1</guest>
			<staff>100</staff>
			<module>mail</module>
			<ordering>0</ordering>
			<value>send_message_to_max_users_each_time</value>
		</setting>
	</user_group_settings>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="controller">view.html.php</file>
		<file type="controller">compose.html.php</file>
	</update_templates>
</upgrade>