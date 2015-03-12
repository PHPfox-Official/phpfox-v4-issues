<upgrade>
	<phrases>
		<phrase>
			<module_id>friend</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>user_setting_link_to_remove_friend_on_profile</var_name>
			<added>1352109355</added>
			<value><![CDATA[When enabled, members of this user group will see a link to "Remove Friend" from the profile page of their friends.]]></value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>friend</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>friend</module>
			<ordering>0</ordering>
			<value>link_to_remove_friend_on_profile</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>friend</module_id>
			<hook_type>service</hook_type>
			<module>friend</module>
			<call_name>friend.service_getfromcachequery</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>friend</module_id>
			<hook_type>component</hook_type>
			<module>friend</module>
			<call_name>friend.component_block_search_get</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>friend</module_id>
			<hook_type>component</hook_type>
			<module>friend</module>
			<call_name>friend.component_block_mini_process</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<components>
		<component>
			<module_id>friend</module_id>
			<component>remove</component>
			<m_connection />
			<module>friend</module>
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
			<module_id>friend</module_id>
			<component>remove</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>8</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Remove Friend</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
</upgrade>