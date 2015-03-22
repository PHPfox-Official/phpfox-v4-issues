<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>profile</module_id>
			<is_hidden>0</is_hidden>
			<type>drop</type>
			<var_name>profile_default_landing_page</var_name>
			<phrase_var_name>setting_profile_default_landing_page</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.4.0beta1</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:4:"wall";s:6:"values";a:2:{i:0;s:4:"wall";i:1;s:4:"info";}}]]></value>
		</setting>
		<setting>
			<group />
			<module_id>profile</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>allow_user_select_landing</var_name>
			<phrase_var_name>setting_allow_user_select_landing</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.4.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>profile</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>setting_profile_default_landing_page</var_name>
			<added>1344592982</added>
			<value><![CDATA[<title>Default Profile Landing Page</title><info>Select what should be the default landing page for user profiles.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>profile</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>setting_allow_user_select_landing</var_name>
			<added>1344593926</added>
			<value><![CDATA[<title>Allow Users Select for Landing Page</title><info>Enable this option if you would like to allow your users.</info>]]></value>
		</phrase>
	</phrases>
	<components>
		<component>
			<module_id>profile</module_id>
			<component>logo</component>
			<m_connection />
			<module>profile</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>profile</module_id>
			<component>logo</component>
			<location>13</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Pages Cover Photo</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
</upgrade>