<upgrade>
	<settings>
		<setting>
			<group>registration</group>
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>require_all_spam_questions_on_signup</var_name>
			<phrase_var_name>setting_require_all_spam_questions_on_signup</phrase_var_name>
			<ordering>20</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>user_setting_hide_from_browse</var_name>
			<added>1352114001</added>
			<value><![CDATA[If enabled, members of this user group will be able hide themselves from the Browse section when they enable "Invisible Mode" from Profile -> Privacy Settings]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>anti_spam_security_questions</var_name>
			<added>1352733835</added>
			<value>Anti-Spam Security Questions</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>admin_menu_phrase_var_user_anti_spam_security_questions</var_name>
			<added>1352734459</added>
			<value>Anti Spam Question</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_require_all_spam_questions_on_signup</var_name>
			<added>1352881154</added>
			<value><![CDATA[<title>Spam Check Requires All Questions</title><info>If set to true visitors will have to answer all of the spam questions available before creating their account. 
If this setting is set to false visitors will have to answer only one question, chosen randomly by the site.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>user_setting_can_search_by_zip</var_name>
			<added>1352991266</added>
			<value>Should members of this user group search other users in the site by Zip code?.
(This setting does not affect the AdminCP)</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>question_deleted_succesfully</var_name>
			<added>1355317204</added>
			<value>Question deleted successfully</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>user</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>user</module>
			<ordering>0</ordering>
			<value>hide_from_browse</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>user</module_id>
			<type>boolean</type>
			<admin>true</admin>
			<user>true</user>
			<guest>true</guest>
			<staff>true</staff>
			<module>user</module>
			<ordering>0</ordering>
			<value>can_search_by_zip</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_register_pre_captcha</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_process_add_updatestatus_end</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>component</hook_type>
			<module>user</module>
			<call_name>user.component_block_processpoints_clean</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>component</hook_type>
			<module>user</module>
			<call_name>user.component_block_purchasepoints_clean</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_completepoints_clean</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:3:{s:17:"phpfox_user_field";a:1:{s:15:"location_latlng";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:18:"phpfox_user_status";a:2:{s:15:"location_latlng";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"location_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:19:"phpfox_upload_track";a:1:{s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}s:11:"ALTER_FIELD";a:1:{s:19:"phpfox_upload_track";a:1:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>