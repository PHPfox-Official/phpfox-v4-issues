<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>feed_only_friends</var_name>
			<phrase_var_name>setting_feed_only_friends</phrase_var_name>
			<ordering>0</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>feed_display_time_stamp</var_name>
			<phrase_var_name>setting_feed_display_time_stamp</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha3</version_id>
			<value>F j, Y g:i a</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>force_ajax_on_load</var_name>
			<phrase_var_name>setting_force_ajax_on_load</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.6.0rc1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>cache_each_feed_entry</var_name>
			<phrase_var_name>setting_cache_each_feed_entry</phrase_var_name>
			<ordering>2</ordering>
			<version_id>3.6.0rc1</version_id>
			<value>0</value>
		</setting>
	</phpfox_update_settings>
	<components>
		<component>
			<module_id>feed</module_id>
			<component>form2</component>
			<m_connection />
			<module>feed</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-visitor</m_connection>
			<module_id>feed</module_id>
			<component>display</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Guest Feed</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>feed</module_id>
			<component>display</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>10</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Feed display</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>