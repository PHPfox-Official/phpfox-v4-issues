<upgrade>
	<settings>
		<setting>
			<group>registration</group>
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>allow_user_registration</var_name>
			<phrase_var_name>setting_allow_user_registration</phrase_var_name>
			<ordering>0</ordering>
			<version_id>2.0.7</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.7</version_id>
			<var_name>setting_allow_user_registration</var_name>
			<added>1288616671</added>
			<value><![CDATA[<title>Allow User Registration</title><info>Enable this setting to allow public registration.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.7</version_id>
			<var_name>user_setting_can_manage_user_group_settings</var_name>
			<added>1289825772</added>
			<value>Can manage user group settings?</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.7</version_id>
			<var_name>user_setting_can_edit_user_group</var_name>
			<added>1289825844</added>
			<value>Can edit user groups?</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.7</version_id>
			<var_name>user_setting_can_delete_user_group</var_name>
			<added>1289826018</added>
			<value>Can delete user group?</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.7</version_id>
			<var_name>you_are_unable_to_delete_a_site_administrator</var_name>
			<added>1289827215</added>
			<value>You are unable to delete a site administrator.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.7</version_id>
			<var_name>you_are_unable_to_ban_a_site_administrator</var_name>
			<added>1289827731</added>
			<value>You are unable to ban a site administrator.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.7</version_id>
			<var_name>you_are_unable_to_edit_a_site_administrators_account</var_name>
			<added>1289828060</added>
			<value>You are unable to edit a site administrators account.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>user</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>user</module>
			<ordering>0</ordering>
			<value>can_manage_user_group_settings</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>user</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>user</module>
			<ordering>0</ordering>
			<value>can_edit_user_group</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>user</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>user</module>
			<ordering>0</ordering>
			<value>can_delete_user_group</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_add_check_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_update_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_update_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_update_end</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_updatesimple</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_updateusergroup</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_uploadimage</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_updateadvanced_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_updateadvanced_end</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_updatepassword</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_banuser</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_password_verifyrequest_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_password_verifyrequest_check_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_password_verifyrequest_end</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_cancellations_process_cancelaccount_invalid_password</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_callback_getnewsfeedstatus_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_callback_getnewsfeedphoto_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_callback_getnewsfeedjoined_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_user_getuserfields</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_photo_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_photo_2</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_photo_3</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_index_process</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_2</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_3</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_4</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_5</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_6</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_7</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_8</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_9</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_photo_10</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step2_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step2_2</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step2_3</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step2_4</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step2_5</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step2_6</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step2_7</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step2_8</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step1_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step1_2</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step1_3</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_default_block_register_step1_4</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_admincp_add</call_name>
			<added>1288281378</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_add_feed</call_name>
			<added>1290072896</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_user_getforedit</call_name>
			<added>1290072896</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>