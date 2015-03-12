<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>on_signup_new_friend</var_name>
			<phrase_var_name>setting_on_signup_new_friend</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc4</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>setting_on_signup_new_friend</var_name>
			<added>1256302937</added>
			<value><![CDATA[<title>On Signup New Friend</title><info>If you select a user from the drop down this user will automatically become friends with any new member that registers.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>provide_a_name_that_is_not_representing_an_empty_name</var_name>
			<added>1256498562</added>
			<value>Provide a name that is not representing an empty name.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>email_is_not_valid</var_name>
			<added>1256498658</added>
			<value>Email is not valid.</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc1</version_id>
			<var_name>setting_display_user_online_status</var_name>
			<added>1248697618</added>
			<value><![CDATA[<title>Display User Online Status</title><info>Select <b>True</b> to display a users online status, which will alter the users profile image to distinguish from other members that are offline.</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<update_templates>
		<file type="controller">browse.html.php</file>
	</update_templates>
</upgrade>