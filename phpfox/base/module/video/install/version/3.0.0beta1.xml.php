<upgrade>
	<phpfox_update_settings>
		<setting>
			<group>search_engine_optimization</group>
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>large_string</type>
			<var_name>video_meta_description</var_name>
			<phrase_var_name>setting_video_meta_description</phrase_var_name>
			<ordering>17</ordering>
			<version_id>2.0.0rc1</version_id>
			<value>Share your videos with friends, family, and the world on Site Name.</value>
		</setting>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>video_enable_mass_uploader</var_name>
			<phrase_var_name>setting_video_enable_mass_uploader</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>1</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>video</var_name>
			<added>1302203053</added>
			<value>Video</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>say_something_about_this_video</var_name>
			<added>1302203060</added>
			<value>Say something about this video...</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0beta2</version_id>
			<var_name>menu_upload_a_new_video</var_name>
			<added>1242118593</added>
			<value>Upload/Share a Video</value>
		</phrase>
	</phpfox_update_phrases>
	<phpfox_update_menus>
		<menu>
			<module_id>video</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_video</var_name>
			<ordering>26</ordering>
			<url_value>video</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>video</module>
			<value />
		</menu>
		<menu>
			<module_id>video</module_id>
			<parent_var_name />
			<m_connection>video.index</m_connection>
			<var_name>menu_upload_a_new_video</var_name>
			<ordering>76</ordering>
			<url_value>video.add</url_value>
			<version_id>2.0.0beta2</version_id>
			<disallow_access />
			<module>video</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<components>
		<component>
			<module_id>video</module_id>
			<component>profile</component>
			<m_connection>video.profile</m_connection>
			<module>video</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>video</module_id>
			<component>category</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>video</module_id>
			<component>profile</component>
			<location>2</location>
			<is_active>0</is_active>
			<ordering>13</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>video</module_id>
			<component>parent</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>video</module_id>
			<component>spotlight</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>video.view</m_connection>
			<module_id>video</module_id>
			<component>related</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<feed_share>
		<share>
			<module_id>video</module_id>
			<title><![CDATA[{phrase var='video.video'}]]></title>
			<description><![CDATA[{phrase var='video.say_something_about_this_video'}]]></description>
			<block_name>share</block_name>
			<no_input>0</no_input>
			<is_frame>1</is_frame>
			<ajax_request />
			<no_profile>0</no_profile>
			<icon>video.png</icon>
			<ordering>2</ordering>
			<value />
		</share>
	</feed_share>
	<sql><![CDATA[a:4:{s:9:"ADD_FIELD";a:2:{s:12:"phpfox_video";a:3:{s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:18:"phpfox_video_track";a:1:{s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}s:9:"ALTER_KEY";a:3:{s:12:"phpfox_video";a:5:{s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}s:12:"in_process_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"item_id";i:3;s:7:"privacy";}}s:12:"in_process_3";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"item_id";i:3;s:7:"user_id";}}s:12:"in_process_4";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"item_id";i:3;s:7:"privacy";i:4;s:5:"title";}}s:12:"in_process_5";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"item_id";i:3;s:7:"privacy";i:4;s:7:"user_id";}}}s:21:"phpfox_video_category";a:1:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}s:18:"phpfox_video_track";a:1:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:10:"ip_address";}}}}s:7:"ADD_KEY";a:1:{s:12:"phpfox_video";a:1:{s:12:"in_process_6";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:10:"in_process";i:1;s:7:"view_id";i:2;s:7:"privacy";i:3;s:5:"title";}}}}s:10:"REMOVE_KEY";a:1:{s:12:"phpfox_video";a:6:{i:0;a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"video_id";i:1;s:10:"in_process";i:2;s:7:"user_id";}}i:1;a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:9:"module_id";i:2;s:7:"item_id";}}i:2;a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:8:"video_id";i:1;s:10:"in_process";i:2;s:7:"view_id";i:3;s:5:"title";}}i:3;a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:8:"video_id";i:1;s:10:"in_process";i:2;s:7:"view_id";i:3;s:7:"user_id";}}i:4;a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}i:5;a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"user_id";}}}}}]]></sql>
</upgrade>