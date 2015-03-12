<upgrade>
	<phrases>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>item_phrase</var_name>
			<added>1352730198</added>
			<value>page</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>place_your_page_in_the_map</var_name>
			<added>1354532662</added>
			<value><![CDATA[Place your Page in the map, when someone writes a status update they can say they were at your pages&#039; location:]]></value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>you_can_also_write_your_address</var_name>
			<added>1354532697</added>
			<value>You can also write your address here</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>pages</module_id>
			<hook_type>template</hook_type>
			<module>pages</module>
			<call_name>pages.template_controller_add_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>pages</module_id>
			<hook_type>service</hook_type>
			<module>pages</module>
			<call_name>pages.service_process_update_0</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>pages</module_id>
			<hook_type>service</hook_type>
			<module>pages</module>
			<call_name>pages.service_process_update_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>pages</module_id>
			<hook_type>service</hook_type>
			<module>pages</module>
			<call_name>pages.service_pages_getforedit_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>pages</module_id>
			<component>widget</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>pages</module_id>
			<component>admin</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Page Admins</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_pages";a:5:{s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:17:"location_latitude";a:4:{i:0;s:9:"MDECIMAL:";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:18:"location_longitude";a:4:{i:0;s:9:"MDECIMAL:";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"location_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:12:"use_timeline";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:12:"phpfox_pages";a:1:{s:8:"latitude";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:17:"location_latitude";i:1;s:13:"location_name";}}}}}]]></sql>
</upgrade>