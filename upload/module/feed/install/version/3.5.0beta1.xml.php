<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enable_check_in</var_name>
			<phrase_var_name>setting_enable_check_in</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_enable_check_in</var_name>
			<added>1355219746</added>
			<value><![CDATA[<title>Enable Check-In</title><info>If enabled users will be able to choose their location when posting a status update.

This setting also allows pages to define their location. Pages with a location defined will show up in the list of establishments when the user is posting a status update.

For this to work you need to have entered the Google API Key (<setting>google_api_key</setting></info>) or the IP Info DB Key (<setting>ip_infodb_api_key</setting>)]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>feed</module_id>
			<hook_type>template</hook_type>
			<module>feed</module>
			<call_name>feed.component_block_display_process_header</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>service</hook_type>
			<module>feed</module>
			<call_name>feed.service_feed_get_userprofile</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>service</hook_type>
			<module>feed</module>
			<call_name>feed.service_feed_get_buildquery</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>feed</module_id>
			<component>time</component>
			<location>2</location>
			<is_active>0</is_active>
			<ordering>9</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Display Timeline</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>feed</module_id>
			<component>display</component>
			<location>4</location>
			<is_active>1</is_active>
			<ordering>10</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Feed display</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:19:"phpfox_feed_comment";a:1:{s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>