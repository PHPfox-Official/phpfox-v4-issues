<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>friend</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>friend_cache_limit</var_name>
			<phrase_var_name>setting_friend_cache_limit</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0Beta1</version_id>
			<value>100</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>friend</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>show_empty_birthdays</var_name>
			<phrase_var_name>setting_show_empty_birthdays</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0beta4</version_id>
			<value>0</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>friend</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>setting_friend_cache_limit</var_name>
			<added>1295603213</added>
			<value><![CDATA[<title>Friends Cache Limit</title><info>Certain features on the site pick up on the users friends list especially when running a search for a friend. In order to provide a "live" feel to search results we cache in advance X (where X is this settings value) number of friends in memory. Making it easier for users to find their friends instantly.</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_menus>
		<menu>
			<module_id>friend</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_core_friends</var_name>
			<ordering>3</ordering>
			<url_value>friend</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>friend</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<components>
		<component>
			<module_id>friend</module_id>
			<component>birthday-profile</component>
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
			<m_connection>profile.info</m_connection>
			<module_id>friend</module_id>
			<component>mutual-friend</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Mutual Friends</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.index</m_connection>
			<module_id>friend</module_id>
			<component>birthday</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Birthdays</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>mini</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>friend</module_id>
			<component>profile.small</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>friend.profile</m_connection>
			<module_id>friend</module_id>
			<component>top</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>friend.profile</m_connection>
			<module_id>friend</module_id>
			<component>menu</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>birthday</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>8</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>friend</module_id>
			<component>mutual-friend</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>suggestion</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>9</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:4:{s:9:"ADD_FIELD";a:3:{s:13:"phpfox_friend";a:1:{s:7:"is_page";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:18:"phpfox_friend_list";a:1:{s:10:"is_profile";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:21:"phpfox_friend_request";a:2:{s:7:"is_seen";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"relation_data_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}s:9:"ALTER_KEY";a:1:{s:13:"phpfox_friend";a:1:{s:10:"user_check";a:2:{i:0;s:6:"UNIQUE";i:1;a:2:{i:0;s:7:"user_id";i:1;s:14:"friend_user_id";}}}}s:7:"ADD_KEY";a:3:{s:13:"phpfox_friend";a:2:{s:7:"is_page";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"is_page";i:1;s:7:"user_id";}}s:9:"is_page_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"is_page";i:1;s:7:"user_id";i:2;s:14:"friend_user_id";}}}s:18:"phpfox_friend_list";a:1:{s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:10:"is_profile";}}}s:21:"phpfox_friend_request";a:2:{s:16:"relation_data_id";a:2:{i:0;s:5:"INDEX";i:1;s:16:"relation_data_id";}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:7:"is_seen";i:2;s:9:"is_ignore";}}}}s:10:"REMOVE_KEY";a:1:{s:18:"phpfox_friend_list";a:1:{i:0;a:2:{i:0;s:5:"INDEX";i:1;s:4:"used";}}}}]]></sql>
</upgrade>