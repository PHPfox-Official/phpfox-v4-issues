<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>cache_timeout</var_name>
			<phrase_var_name>setting_feedcache_timeout</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.6</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>drop</type>
			<var_name>feed_time_layout</var_name>
			<phrase_var_name>setting_feed_time_layout</phrase_var_name>
			<ordering>0</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:4:"days";s:6:"values";a:4:{i:0;s:4:"days";i:1;s:7:"minutes";i:2;s:5:"hours";i:3;s:6:"months";}}]]></value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>display_feeds_from</var_name>
			<phrase_var_name>setting_display_feeds_from</phrase_var_name>
			<ordering>0</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value>30</value>
		</setting>
	</phpfox_update_settings>
	<hooks>
		<hook>
			<module_id>feed</module_id>
			<hook_type>template</hook_type>
			<module>feed</module>
			<call_name>feed.template_block_entry_1</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>template</hook_type>
			<module>feed</module>
			<call_name>feed.template_block_entry_2</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>template</hook_type>
			<module>feed</module>
			<call_name>feed.template_block_entry_3</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>controller</hook_type>
			<module>feed</module>
			<call_name>feed.component_controller_user_mobile_clean</call_name>
			<added>1288281378</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>