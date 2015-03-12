<upgrade>
	<phpfox_update_settings>
		<setting>
			<group>time_stamps</group>
			<module_id>event</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>event_browse_time_stamp</var_name>
			<phrase_var_name>setting_event_browse_time_stamp</phrase_var_name>
			<ordering>2</ordering>
			<version_id>2.0.0alpha4</version_id>
			<value>l, F j</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.1.0</version_id>
			<var_name>find_on_map</var_name>
			<added>1303890231</added>
			<value>Find On Map</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>user_setting_points_event</var_name>
			<added>1304600668</added>
			<value>How many points does the user get when they add a new event?</value>
		</phrase>
	</phrases>
	<phpfox_update_menus>
		<menu>
			<module_id>event</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_event</var_name>
			<ordering>29</ordering>
			<url_value>event</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>event</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>event</module_id>
			<type>integer</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>event</module>
			<ordering>0</ordering>
			<value>points_event</value>
		</setting>
	</user_group_settings>
	<components>
		<component>
			<module_id>event</module_id>
			<component>list</component>
			<m_connection />
			<module>event</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>event</module_id>
			<component>attending</component>
			<m_connection />
			<module>event</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>event</module_id>
			<component>invite</component>
			<m_connection />
			<module>event</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>event</module_id>
			<component>profile</component>
			<m_connection>event.profile</m_connection>
			<module>event</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>attending</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Attending</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.index</m_connection>
			<module_id>event</module_id>
			<component>invite</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Event Invites</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>info</component>
			<location>4</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Event Information</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>rsvp</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>event</module_id>
			<component>parent</component>
			<location>0</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>image</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Event Photo</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:4:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_event";a:2:{s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ALTER_KEY";a:1:{s:12:"phpfox_event";a:3:{s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"item_id";i:3;s:10:"start_time";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"item_id";i:3;s:7:"user_id";i:4;s:10:"start_time";}}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"user_id";}}}}s:7:"ADD_KEY";a:2:{s:12:"phpfox_event";a:2:{s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"item_id";i:3;s:5:"title";}}s:9:"view_id_5";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:9:"module_id";i:3;s:7:"item_id";i:4;s:10:"start_time";}}}s:19:"phpfox_event_invite";a:1:{s:7:"rsvp_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"rsvp_id";i:1;s:15:"invited_user_id";}}}}s:11:"ALTER_FIELD";a:1:{s:21:"phpfox_event_category";a:1:{s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>