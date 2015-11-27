<upgrade>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>provide_a_valid_email_address</var_name>
			<added>1258742333</added>
			<value>Provide a valid email address.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>new_members</var_name>
			<added>1258756750</added>
			<value>New Members</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>new_comments</var_name>
			<added>1258756762</added>
			<value>New Comments</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>updating</var_name>
			<added>1258899641</added>
			<value>Updating</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>total_full_name_change_out_of_allowed</var_name>
			<added>1258984271</added>
			<value>{total_full_name_change} out of {allowed}</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>provide_a_valid_user_name</var_name>
			<added>1255348982</added>
			<value>Not a valid user name. User name can only contain alphanumeric characters and _ or - and must be between {min} and {max} characters long.</value>
		</phrase>
	</phpfox_update_phrases>
	<hooks>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.controller_browse_filter</call_name>
			<added>1259160644</added>
			<version_id>2.0.0rc9</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_browse_genders</call_name>
			<added>1259173633</added>
			<version_id>2.0.0rc9</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_browse_filter</call_name>
			<added>1259173633</added>
			<version_id>2.0.0rc9</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">setting.html.php</file>
		<file type="block">setting.html.php</file>
	</update_templates>
</upgrade>