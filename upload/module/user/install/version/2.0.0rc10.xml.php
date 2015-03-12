<upgrade>
	<settings>
		<setting>
			<group>registration</group>
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>redirect_after_signup</var_name>
			<phrase_var_name>setting_redirect_after_signup</phrase_var_name>
			<ordering>3</ordering>
			<version_id>2.0.0rc10</version_id>
			<value />
		</setting>
		<setting>
			<group>registration</group>
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>suggest_usernames_on_registration</var_name>
			<phrase_var_name>setting_suggest_usernames_on_registration</phrase_var_name>
			<ordering>3</ordering>
			<version_id>2.0.0rc10</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc10</version_id>
			<var_name>setting_redirect_after_signup</var_name>
			<added>1259688625</added>
			<value><![CDATA[<title>Redirect After SignUp</title><info>Redirect After SignUp</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc10</version_id>
			<var_name>setting_suggest_usernames_on_registration</var_name>
			<added>1259610406</added>
			<value><![CDATA[<title>Suggest Usernames At Registration</title><info>When enabled the guest will be shown a list of valid usernames if the one they attempted is not available.

This setting enables or disables "Usernames to suggest"</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-visitor</m_connection>
			<module_id>user</module_id>
			<component>register</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>user.browse</m_connection>
			<module_id>user</module_id>
			<component>filter</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-visitor</m_connection>
			<module_id>user</module_id>
			<component>featured</component>
			<location>4</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>user.browse</m_connection>
			<module_id>user</module_id>
			<component>featured</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection />
			<module_id>user</module_id>
			<component>login-block</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>