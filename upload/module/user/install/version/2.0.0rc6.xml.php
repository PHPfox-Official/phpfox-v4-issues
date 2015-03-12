<upgrade>
	<settings>
		<setting>
			<group>spam</group>
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>check_status_updates</var_name>
			<phrase_var_name>setting_check_status_updates</phrase_var_name>
			<ordering>13</ordering>
			<version_id>2.0.0rc5</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>drop</type>
			<var_name>user_browse_display_results_default</var_name>
			<phrase_var_name>setting_user_browse_display_results_default</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha3</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:17:"name_photo_detail";s:6:"values";a:2:{i:0;s:17:"name_photo_detail";i:1;s:10:"name_photo";}}]]></value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc5</version_id>
			<var_name>you_have_already_added_this_recently_try_adding_something_else</var_name>
			<added>1256831625</added>
			<value>You have already added this recently. Try adding something else.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc5</version_id>
			<var_name>setting_check_status_updates</var_name>
			<added>1256831739</added>
			<value><![CDATA[<title>Spam Check Status Updates</title><info>Define how many status updates should we check to see if the new status update the user is adding is similar and if one is we will guide them to add another status update.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>rating</var_name>
			<added>1257148296</added>
			<value>Rating</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>confirm_password</var_name>
			<added>1257149713</added>
			<value>Confirm Password</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>password_successfully_updated</var_name>
			<added>1257149818</added>
			<value>Password successfully updated.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>confirm_your_new_password</var_name>
			<added>1257149930</added>
			<value>Confirm your new password.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>your_confirmed_password_does_not_match_your_new_password</var_name>
			<added>1257149968</added>
			<value>Your confirmed password does not match your new password.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>search_for_members</var_name>
			<added>1257171948</added>
			<value>Search For Members</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>icon</var_name>
			<added>1257255484</added>
			<value>Icon</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>complete_this_step_to_setup_your_personal_profile</var_name>
			<added>1257262042</added>
			<value>Complete this step to setup your personal profile.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>you_are_required_to_upload_a_profile_image</var_name>
			<added>1257262086</added>
			<value>You are required to upload a profile image.</value>
		</phrase>
	</phrases>
	<update_templates>
		<file type="controller">setting.html.php</file>
		<file type="block">password.html.php</file>
		<file type="block">browse.html.php</file>
		<file type="block">filter.html.php</file>
	</update_templates>
</upgrade>