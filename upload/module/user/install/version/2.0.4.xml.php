<upgrade>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.4</version_id>
			<var_name>total_activity_points</var_name>
			<added>1266500173</added>
			<value>Total Activity Points</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.4</version_id>
			<var_name>activity_points</var_name>
			<added>1266500821</added>
			<value>Activity Points</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>an_error_occured_and_this_operation_was_not_completed</var_name>
			<added>1255346213</added>
			<value>An error occurred and this operation was not completed.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>an_error_occured_and_this_user_could_not_be_verified</var_name>
			<added>1255346223</added>
			<value>An error occurred and this user could not be verified.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>an_error_occured_and_the_email_could_not_be_sent</var_name>
			<added>1255346241</added>
			<value>An error occurred and the email could not be sent.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.2</version_id>
			<var_name>user_setting_can_view_if_a_user_is_invisible</var_name>
			<added>1263216036</added>
			<value><![CDATA[Can view a users "Last Login" time stamp on their profile even if the user is logged as invisible?]]></value>
		</phrase>
	</phpfox_update_phrases>
	<hooks>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_add_updatestatus</call_name>
			<added>1266260139</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_setting_process_check</call_name>
			<added>1266260139</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.controller_login_login_failed</call_name>
			<added>1266260139</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_logout-mobile_clean</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
	</hooks>
	<phpfox_update_stats>
		<stat>
			<module_id>user</module_id>
			<phrase_var>user.stat_title_1</phrase_var>
			<stat_link>user.browse</stat_link>
			<stat_image>user.png</stat_image>
			<is_active>1</is_active>
			<value><![CDATA[$this->database()
->select('COUNT(*)')
->from(Phpfox::getT('user'))
->execute('getSlaveField');]]></value>
		</stat>
	</phpfox_update_stats>
	<sql><![CDATA[a:1:{s:11:"ALTER_FIELD";a:1:{s:11:"phpfox_user";a:1:{s:5:"email";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
	<update_templates>
		<file type="controller">privacy.html.php</file>
		<file type="controller">remove.html.php</file>
		<file type="controller">setting.html.php</file>
		<file type="controller">login.html.php</file>
		<file type="block">login-ajax.html.php</file>
		<file type="block">privacy-profile.html.php</file>
	</update_templates>
</upgrade>