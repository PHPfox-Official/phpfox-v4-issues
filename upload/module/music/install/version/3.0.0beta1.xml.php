<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>music</module_id>
			<is_hidden>1</is_hidden>
			<type>drop</type>
			<var_name>music_index_controller</var_name>
			<phrase_var_name>setting_music_index_controller</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc6</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:4:"song";s:6:"values";a:3:{i:0;s:4:"song";i:1;s:5:"album";i:2;s:6:"artist";}}]]></value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>music</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>user_setting_can_edit_own_song</var_name>
			<added>1303845553</added>
			<value>Can edit own songs?</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>user_setting_can_edit_other_song</var_name>
			<added>1303845597</added>
			<value>Can edit songs uploaded by other users?</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>user_setting_activity_music_song</var_name>
			<added>1303978055</added>
			<value>How many activity points does a user get when uploading a song?</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>say_something_about_this_song</var_name>
			<added>1304063712</added>
			<value>Say something about this song.</value>
		</phrase>
	</phrases>
	<phpfox_update_menus>
		<menu>
			<module_id>music</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_music</var_name>
			<ordering>31</ordering>
			<url_value>music</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
		<menu>
			<module_id>music</module_id>
			<parent_var_name />
			<m_connection>music.index</m_connection>
			<var_name>menu_upload_a_song</var_name>
			<ordering>74</ordering>
			<url_value>music.upload</url_value>
			<version_id>2.0.0beta1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
		<menu>
			<module_id>music</module_id>
			<parent_var_name />
			<m_connection>music.index</m_connection>
			<var_name>menu_create_an_album</var_name>
			<ordering>75</ordering>
			<url_value>music.album</url_value>
			<version_id>2.0.0beta1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>music</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>music</module>
			<ordering>0</ordering>
			<value>can_edit_own_song</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>music</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>music</module>
			<ordering>0</ordering>
			<value>can_edit_other_song</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>music</module_id>
			<type>integer</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>music</module>
			<ordering>0</ordering>
			<value>points_music_song</value>
		</setting>
	</user_group_settings>
	<phpfox_update_user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>music</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>1</guest>
			<staff>1</staff>
			<module>music</module>
			<ordering>0</ordering>
			<value>can_upload_music_public</value>
		</setting>
	</phpfox_update_user_group_settings>
	<components>
		<component>
			<module_id>music</module_id>
			<component>new-album</component>
			<m_connection />
			<module>music</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>music</module_id>
			<component>track</component>
			<m_connection />
			<module>music</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>music</module_id>
			<component>album</component>
			<m_connection>music.album</m_connection>
			<module>music</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>music</module_id>
			<component>tracklist</component>
			<m_connection />
			<module>music</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>music</module_id>
			<component>featured-album</component>
			<m_connection />
			<module>music</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>music</module_id>
			<component>profile</component>
			<m_connection>music.profile</m_connection>
			<module>music</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>music.index</m_connection>
			<module_id>music</module_id>
			<component>new-album</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>New Albums</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.album</m_connection>
			<module_id>music</module_id>
			<component>track</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Manage Tracks for Albums</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.view-album</m_connection>
			<module_id>music</module_id>
			<component>track</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Album Tracklist</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.index</m_connection>
			<module_id>music</module_id>
			<component>featured</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Featured Songs</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.browse.album</m_connection>
			<module_id>music</module_id>
			<component>featured-album</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Featured Albums</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>music</module_id>
			<component>album</component>
			<location>2</location>
			<is_active>0</is_active>
			<ordering>14</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>music</module_id>
			<component>song</component>
			<location>3</location>
			<is_active>0</is_active>
			<ordering>9</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.view</m_connection>
			<module_id>music</module_id>
			<component>info</component>
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
			<m_connection>music</m_connection>
			<module_id>music</module_id>
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
			<m_connection>music</m_connection>
			<module_id>music</module_id>
			<component>latest</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.index</m_connection>
			<module_id>music</module_id>
			<component>filter</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.browse.song</m_connection>
			<module_id>music</module_id>
			<component>filter</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.browse.album</m_connection>
			<module_id>music</module_id>
			<component>list</component>
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
			<m_connection>music.browse.album</m_connection>
			<module_id>music</module_id>
			<component>filter</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.view-album</m_connection>
			<module_id>music</module_id>
			<component>menu-album</component>
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
			<m_connection>music.view</m_connection>
			<module_id>music</module_id>
			<component>photo</component>
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
			<m_connection>music.view</m_connection>
			<module_id>music</module_id>
			<component>menu</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music</m_connection>
			<module_id>music</module_id>
			<component>featured</component>
			<location>2</location>
			<is_active>0</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>music</module_id>
			<component>profile</component>
			<location>3</location>
			<is_active>0</is_active>
			<ordering>10</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Favorite Songs</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.browse.album</m_connection>
			<module_id>music</module_id>
			<component>sponsored-album</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<feed_share>
		<share>
			<module_id>music</module_id>
			<title><![CDATA[{phrase var='music.music'}]]></title>
			<description><![CDATA[{phrase var='music.say_something_about_this_song'}]]></description>
			<block_name>share</block_name>
			<no_input>0</no_input>
			<is_frame>1</is_frame>
			<ajax_request />
			<no_profile>1</no_profile>
			<icon>music.png</icon>
			<ordering>6</ordering>
			<value />
		</share>
	</feed_share>
	<sql><![CDATA[a:5:{s:9:"ADD_FIELD";a:2:{s:18:"phpfox_music_album";a:5:{s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:17:"phpfox_music_song";a:6:{s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"genre_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ALTER_KEY";a:2:{s:18:"phpfox_music_album";a:3:{s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"is_featured";}}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"total_track";i:3;s:9:"module_id";i:4;s:7:"item_id";}}}s:17:"phpfox_music_song";a:6:{s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:8:"genre_id";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"is_featured";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"user_id";}}s:9:"view_id_5";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:5:"title";}}s:9:"view_id_6";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:9:"module_id";i:3;s:7:"item_id";}}}}s:7:"ADD_KEY";a:1:{s:18:"phpfox_music_album";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:10:"REMOVE_KEY";a:2:{s:18:"phpfox_music_album";a:2:{i:0;a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}i:1;a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:11:"is_featured";}}}s:18:"phpfox_music_genre";a:1:{i:0;a:2:{i:0;s:5:"INDEX";i:1;s:8:"name_url";}}}s:11:"ALTER_FIELD";a:1:{s:18:"phpfox_music_genre";a:1:{s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>