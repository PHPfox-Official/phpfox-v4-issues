<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>user_dob_month_day_year</var_name>
			<phrase_var_name>setting_user_dob_month_day_year</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0</version_id>
			<value>F j, Y</value>
		</setting>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>user_dob_month_day</var_name>
			<phrase_var_name>setting_user_dob_month_day</phrase_var_name>
			<ordering>2</ordering>
			<version_id>3.0.0</version_id>
			<value>F j</value>
		</setting>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>cache_featured_users</var_name>
			<phrase_var_name>setting_cache_featured_users</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.6.0rc1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>cache_user_inner_joins</var_name>
			<phrase_var_name>setting_cache_user_inner_joins</phrase_var_name>
			<ordering>2</ordering>
			<version_id>3.6.0rc1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>cache_recent_logged_in</var_name>
			<phrase_var_name>setting_cache_recent_logged_in</phrase_var_name>
			<ordering>3</ordering>
			<version_id>3.6.0rc1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>disable_store_last_user</var_name>
			<phrase_var_name>setting_disable_store_last_user</phrase_var_name>
			<ordering>4</ordering>
			<version_id>3.6.0rc1</version_id>
			<value>0</value>
		</setting>
	</phpfox_update_settings>
	<phpfox_update_menus>
		<menu>
			<module_id>user</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_browse</var_name>
			<ordering>3</ordering>
			<url_value>user.browse</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>user</module>
			<mobile_icon>users</mobile_icon>
			<value />
		</menu>
	</phpfox_update_menus>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-visitor</m_connection>
			<module_id>user</module_id>
			<component>featured</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Featured Users for Guests</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-visitor</m_connection>
			<module_id>user</module_id>
			<component>register</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>User SignUp for Guests</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>