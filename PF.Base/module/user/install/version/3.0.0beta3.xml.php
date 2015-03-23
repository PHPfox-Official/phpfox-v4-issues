<upgrade>
	<settings>
		<setting>
			<group>registration</group>
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>new_user_terms_confirmation</var_name>
			<phrase_var_name>setting_new_user_terms_confirmation</phrase_var_name>
			<ordering>18</ordering>
			<version_id>3.0.0beta3</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.0.0beta3</version_id>
			<var_name>setting_new_user_terms_confirmation</var_name>
			<added>1315851732</added>
			<value><![CDATA[<title>Terms & Privacy Confirmation</title><info>Enable this option if users must confirm that they understand and have ready over your sites terms and privacy policies.</info>]]></value>
		</phrase>
	</phrases>
	<components>
		<component>
			<module_id>user</module_id>
			<component>cf_about_me</component>
			<m_connection />
			<module>user</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>user</module_id>
			<component>cf_who_i_d_like_to_meet</component>
			<m_connection />
			<module>user</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>user</module_id>
			<component>cf_interests</component>
			<m_connection />
			<module>user</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>user</module_id>
			<component>cf_music</component>
			<m_connection />
			<module>user</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>user</module_id>
			<component>cf_movies</component>
			<m_connection />
			<module>user</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>user</module_id>
			<component>cf_smoker</component>
			<m_connection />
			<module>user</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>user</module_id>
			<component>cf_drinker</component>
			<m_connection />
			<module>user</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:17:"phpfox_user_field";a:2:{s:16:"relation_data_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"relation_with";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>