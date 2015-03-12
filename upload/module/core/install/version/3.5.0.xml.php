<upgrade>
	<settings>
		<setting>
			<group>formatting</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>activity_feed_line_breaks</var_name>
			<phrase_var_name>setting_activity_feed_line_breaks</phrase_var_name>
			<ordering>7</ordering>
			<version_id>3.5.0</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>3.5.0</version_id>
			<var_name>setting_activity_feed_line_breaks</var_name>
			<added>1361864310</added>
			<value><![CDATA[<title>Activity Feed Line Breaks</title><info>This feature controls how many line breaks to show in activity feed posts and comments. To enable this feature simply add a number higher than 0.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>core</module_id>
			<hook_type>service</hook_type>
			<module>core</module>
			<call_name>core.service_currency_contruct__1</call_name>
			<added>1361532353</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>service</hook_type>
			<module>core</module>
			<call_name>core.service_currency_getforedit__1</call_name>
			<added>1361532353</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>service</hook_type>
			<module>core</module>
			<call_name>core.service_currency_getforbrowse__1</call_name>
			<added>1361532353</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_phpfox_locale_phrase_not_found</call_name>
			<added>1361776392</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_module_getservice_1</call_name>
			<added>1363075699</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_module_getcomponent_1</call_name>
			<added>1363075699</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_module_getcomponent_2</call_name>
			<added>1363075699</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_template_cache_compile__1</call_name>
			<added>1363075699</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_template_cache_parse__1</call_name>
			<added>1363075699</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>library_phpfox_getlibclass_1</call_name>
			<added>1363075699</added>
			<version_id>3.5.0</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>