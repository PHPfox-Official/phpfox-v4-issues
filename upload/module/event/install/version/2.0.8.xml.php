<upgrade>
	<phrases>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.8</version_id>
			<var_name>user_setting_can_view_gmap</var_name>
			<added>1298476820</added>
			<value>Can members of this user group view a Google Map in the Events section?</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.8</version_id>
			<var_name>user_setting_can_add_gmap</var_name>
			<added>1298476869</added>
			<value>Can members of this user group add a Google Map to their events?</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.8</version_id>
			<var_name>address</var_name>
			<added>1298896463</added>
			<value>Address</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>event</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>event</module>
			<ordering>0</ordering>
			<value>can_view_gmap</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>event</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>event</module>
			<ordering>0</ordering>
			<value>can_add_gmap</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_delete__start</call_name>
			<added>1298455495</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_delete__pre_unlink</call_name>
			<added>1298455495</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_delete__pre_space_update</call_name>
			<added>1298455495</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_delete__pre_deletes</call_name>
			<added>1298455495</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_delete__end</call_name>
			<added>1298455495</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_add__start</call_name>
			<added>1298455786</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_update__start</call_name>
			<added>1298455786</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_massemail__start</call_name>
			<added>1298455786</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_massemail__end</call_name>
			<added>1298455786</added>
			<version_id>2.0.8</version_id>
			<value />
		</hook>
	</hooks>
	<components>
		<component>
			<module_id>event</module_id>
			<component>map</component>
			<m_connection />
			<module>event</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>map</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_event";a:2:{s:4:"gmap";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"address";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>