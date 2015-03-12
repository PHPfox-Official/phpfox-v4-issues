<upgrade>
	<phrases>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>approved</var_name>
			<added>1258377477</added>
			<value>Approved</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>no_music_albums_have_been_created</var_name>
			<added>1258397590</added>
			<value>No music albums have been created.</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>there_are_new_featured_albums</var_name>
			<added>1258397705</added>
			<value>There are new featured albums.</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>there_are_no_featured_albums</var_name>
			<added>1258397713</added>
			<value>There are no featured albums.</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_top_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_photo_album_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_menu_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_photo_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_latest_album_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_featured_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_filter_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_latest_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_featured_album_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_menu_album_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>controller</hook_type>
			<module>music</module>
			<call_name>music.component_controller_browse_artist_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>controller</hook_type>
			<module>music</module>
			<call_name>music.component_controller_browse_album_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>controller</hook_type>
			<module>music</module>
			<call_name>music.component_controller_browse_song_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
	<phpfox_update_custom_group>
		<group>
			<module_id>music</module_id>
			<type_id>user_profile</type_id>
			<phrase_var_name>music.custom_group_basics</phrase_var_name>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<value />
		</group>
		<group>
			<module_id>music</module_id>
			<type_id>user_profile</type_id>
			<phrase_var_name>music.custom_group_musician_details</phrase_var_name>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<value />
		</group>
	</phpfox_update_custom_group>
	<phpfox_update_custom_field>
		<field>
			<group_name>music.custom_group_basics</group_name>
			<field_name>record_label_name</field_name>
			<module_id>music</module_id>
			<type_id>user_panel</type_id>
			<phrase_var_name>music.custom_record_label_name</phrase_var_name>
			<type_name>VARCHAR(255)</type_name>
			<var_type>text</var_type>
			<is_active>1</is_active>
			<is_required>0</is_required>
			<ordering>9</ordering>
			<value />
		</field>
		<field>
			<group_name>music.custom_group_basics</group_name>
			<field_name>record_label_type</field_name>
			<module_id>music</module_id>
			<type_id>user_panel</type_id>
			<phrase_var_name>music.custom_record_label_type</phrase_var_name>
			<type_name>VARCHAR(150)</type_name>
			<var_type>select</var_type>
			<is_active>1</is_active>
			<is_required>1</is_required>
			<ordering>10</ordering>
			<value><![CDATA[a:3:{i:0;a:1:{s:15:"phrase_var_name";s:21:"music.cf_option_indie";}i:1;a:1:{s:15:"phrase_var_name";s:21:"music.cf_option_major";}i:2;a:1:{s:15:"phrase_var_name";s:24:"music.cf_option_unsigned";}}]]></value>
		</field>
	</phpfox_update_custom_field>
	<update_templates>
		<file type="block">latest-album.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">featured-album.html.php</file>
	</update_templates>
</upgrade>