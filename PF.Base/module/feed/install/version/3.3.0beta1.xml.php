<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>force_timeline</var_name>
			<phrase_var_name>setting_force_timeline</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.3.0beta1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>can_add_past_dates</var_name>
			<phrase_var_name>setting_can_add_past_dates</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.3.0beta1</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>timeline_optional</var_name>
			<phrase_var_name>setting_timeline_optional</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.3.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>shared</var_name>
			<added>1336400814</added>
			<value>shared...</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>successfully_shared_this_item_on_your_friends_wall</var_name>
			<added>1336400863</added>
			<value>Successfully shared this item on your friends wall.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>successfully_shared_this_item</var_name>
			<added>1336400883</added>
			<value>Successfully shared this item.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>setting_force_timeline</var_name>
			<added>1337095087</added>
			<value><![CDATA[<title>Force Timeline</title><info>Enable this feature to force the activity feed on a users profile to use a Timeline.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>setting_can_add_past_dates</var_name>
			<added>1338364887</added>
			<value><![CDATA[<title>Feeds in the Past</title><info>If this option is enabled and the Timeline feature is also enabled users will be able to add feeds from their profile in the past.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>setting_timeline_optional</var_name>
			<added>1339423430</added>
			<value><![CDATA[<title>Timeline Optional</title><info>If the setting "Force Timeline" is disabled and this setting is enabled users can choose if they want to convert their profiles into a Timeline.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>feed</module_id>
			<hook_type>component</hook_type>
			<module>feed</module>
			<call_name>feed.component_block_mini_clean</call_name>
			<added>1339076699</added>
			<version_id>3.3.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<components>
		<component>
			<module_id>feed</module_id>
			<component>time</component>
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
			<m_connection>profile.index</m_connection>
			<module_id>feed</module_id>
			<component>time</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Feed Timeline</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>feed</module_id>
			<component>display</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_feed";a:1:{s:14:"parent_feed_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>