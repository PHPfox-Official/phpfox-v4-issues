<upgrade>
	<phrases>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>or_login_with</var_name>
			<added>1287493443</added>
			<value>Or login with:</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>facebook_connect_account_issues</var_name>
			<added>1289310719</added>
			<value>Facebook Connect Account Issues</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>we_already_have_an_account_created_with_us</var_name>
			<added>1289310877</added>
			<value>We already have an account created with us with the same email you have on Facebook. Would you like to sync both accounts?</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>note_that_if_you_sync_both_accounts</var_name>
			<added>1289314457</added>
			<value>Note that if you sync both accounts you will not be able to use the original account here other then logging in with Facebook Connect.</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>yes_sync_both_accounts</var_name>
			<added>1289314465</added>
			<value>Yes, sync both accounts.</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>no_do_not_sync_both_accounts</var_name>
			<added>1289314474</added>
			<value>No, do not sync both accounts.</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>you_have_chosen_to_not_sync_both_accounts</var_name>
			<added>1289314492</added>
			<value>You have chosen to not sync both accounts. To complete this process please remove this Facebook Connection here:</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>unable_to_login</var_name>
			<added>1289314532</added>
			<value>Unable to login.</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>unable_to_fetch_your_facebook_account</var_name>
			<added>1289314557</added>
			<value>Unable to fetch your Facebook account.</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.7</version_id>
			<var_name>unable_to_fetch_your_full_name_from_facebook</var_name>
			<added>1289314585</added>
			<value>Unable to fetch your full name from Facebook.</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>facebook</module_id>
			<hook_type>controller</hook_type>
			<module>facebook</module>
			<call_name>facebook.component_controller_sync_clean</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>facebook</module_id>
			<hook_type>controller</hook_type>
			<module>facebook</module>
			<call_name>facebook.component_controller_account_clean</call_name>
			<added>1290072896</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>facebook</module_id>
			<hook_type>controller</hook_type>
			<module>facebook</module>
			<call_name>facebook.component_controller_frame_clean</call_name>
			<added>1290072896</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>