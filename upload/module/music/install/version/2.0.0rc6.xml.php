<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>music</module_id>
			<is_hidden>0</is_hidden>
			<type>drop</type>
			<var_name>music_index_controller</var_name>
			<phrase_var_name>setting_music_index_controller</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc6</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:4:"song";s:6:"values";a:3:{i:0;s:4:"song";i:1;s:5:"album";i:2;s:6:"artist";}}]]></value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>setting_music_index_controller</var_name>
			<added>1256893249</added>
			<value><![CDATA[<title>Music Index Controller</title><info>Select which controller should be used when viewing the music sections index page.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>full_name_uploaded_a_new_song</var_name>
			<added>1257252374</added>
			<value><![CDATA[<a href="{profile_link}">{full_name}</a> uploaded a new song "<a href="{link}">{title}</a>".]]></value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>full_name_uploaded_a_new_song_to_the_album</var_name>
			<added>1257253578</added>
			<value><![CDATA[<a href="{profile_link}">{full_name}</a> uploaded a song "<a href="{link}">{title}</a>" to the album "<a href="{album_link}">{album_title}</a>".]]></value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc6</version_id>
			<var_name>add_to_favorites</var_name>
			<added>1257317596</added>
			<value>Add to Favorites</value>
		</phrase>
	</phrases>
	<phpfox_update_menus>
		<menu>
			<module_id>music</module_id>
			<parent_id>0</parent_id>
			<m_connection>music</m_connection>
			<var_name>menu_artists</var_name>
			<ordering>85</ordering>
			<url_value>music.browse.artist</url_value>
			<version_id>2.0.0rc1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
		<menu>
			<module_id>music</module_id>
			<parent_id>0</parent_id>
			<m_connection>music</m_connection>
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
			<parent_id>0</parent_id>
			<m_connection>music</m_connection>
			<var_name>menu_create_an_album</var_name>
			<ordering>75</ordering>
			<url_value>music.album</url_value>
			<version_id>2.0.0beta1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
		<menu>
			<module_id>music</module_id>
			<parent_id>0</parent_id>
			<m_connection>music</m_connection>
			<var_name>menu_songs</var_name>
			<ordering>86</ordering>
			<url_value>music.browse.song</url_value>
			<version_id>2.0.0rc1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
		<menu>
			<module_id>music</module_id>
			<parent_id>0</parent_id>
			<m_connection>music</m_connection>
			<var_name>menu_albums</var_name>
			<ordering>87</ordering>
			<url_value>music.browse.album</url_value>
			<version_id>2.0.0rc1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
		<menu>
			<module_id>music</module_id>
			<parent_id>0</parent_id>
			<m_connection>music</m_connection>
			<var_name>menu_view_my_songs</var_name>
			<ordering>88</ordering>
			<url_value>music.browse.song.view_my</url_value>
			<version_id>2.0.0rc1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
		<menu>
			<module_id>music</module_id>
			<parent_id>0</parent_id>
			<m_connection>music</m_connection>
			<var_name>menu_view_my_albums</var_name>
			<ordering>89</ordering>
			<url_value>music.browse.album.view_my</url_value>
			<version_id>2.0.0rc1</version_id>
			<disallow_access />
			<module>music</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<blocks>
		<block>
			<m_connection>music</m_connection>
			<module_id>music</module_id>
			<component>top</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<can_move>0</can_move>
			<value />
		</block>
		<block>
			<m_connection>music</m_connection>
			<module_id>music</module_id>
			<component>latest</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<can_move>0</can_move>
			<value />
		</block>
		<block>
			<m_connection>music</m_connection>
			<module_id>music</module_id>
			<component>featured</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<can_move>0</can_move>
			<value />
		</block>
	</blocks>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="block">menu.html.php</file>
		<file type="block">menu-album.html.php</file>
		<file type="block">latest.html.php</file>
	</update_templates>
</upgrade>