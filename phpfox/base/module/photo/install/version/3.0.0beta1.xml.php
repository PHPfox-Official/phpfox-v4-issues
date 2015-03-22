<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>auto_crop_photo</var_name>
			<phrase_var_name>setting_auto_crop_photo</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>rename_uploaded_photo_names</var_name>
			<phrase_var_name>setting_rename_uploaded_photo_names</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha3</version_id>
			<value>0</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>say_something_about_this_photo</var_name>
			<added>1302202989</added>
			<value>Say something about this photo...</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>setting_auto_crop_photo</var_name>
			<added>1306738298</added>
			<value><![CDATA[<title>Auto Crop Photos</title><info>If this option is enabled images within the photo section will crop images so each image has the same width/height giving the photo section a cleaner look. This works similar to how the photo section on Facebook works.</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0alpha3</version_id>
			<var_name>setting_rename_uploaded_photo_names</var_name>
			<added>1239041807</added>
			<value><![CDATA[<title>Rename Photo Names</title><info>Set to <b>True</b> if you would like to rename a photo based on what the title of the photo or the title provided by the user when processing their recently uploaded photos. By default we use a 32 character unique hash to protect images, however enabling this feature will still create a unique ID for each image and help with image SEO.

<b>Notice:</b> Apache "mod_rewrite" will have to be enabled to use this feature. Once you have enabled this feature you must edit the file ".htaccess" find in your sites root directory.

Look for the following in that file:
[code]
# RewriteRule ^file/pic/photo/([0-9]+)/([0-9]+)/([A-Za-z0-9]{32}+)-(.*?)([_0-9]*?).(.*)$ file/pic/photo/$1/$2/$3$5.$6
[/code]

Replace it with:
[code]
RewriteRule ^file/pic/photo/([0-9]+)/([0-9]+)/([A-Za-z0-9]{32}+)-(.*?)([_0-9]*?).(.*)$ file/pic/photo/$1/$2/$3$5.$6
[/code]
</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<phpfox_update_menus>
		<menu>
			<module_id>photo</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_photo</var_name>
			<ordering>22</ordering>
			<url_value>photo</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>photo</module>
			<value />
		</menu>
		<menu>
			<module_id>photo</module_id>
			<parent_var_name />
			<m_connection>photo</m_connection>
			<var_name>menu_upload_new_image</var_name>
			<ordering>42</ordering>
			<url_value>photo.add</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>photo</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<components>
		<component>
			<module_id>photo</module_id>
			<component>album-tag</component>
			<m_connection />
			<module>photo</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.album</m_connection>
			<module_id>photo</module_id>
			<component>album-tag</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>In This Album</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>photo</module_id>
			<component>profile</component>
			<location>2</location>
			<is_active>0</is_active>
			<ordering>15</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.view</m_connection>
			<module_id>photo</module_id>
			<component>detail</component>
			<location>0</location>
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
			<m_connection>photo.view</m_connection>
			<module_id>photo</module_id>
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
			<m_connection>photo.album</m_connection>
			<module_id>photo</module_id>
			<component>menu-album</component>
			<location>3</location>
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
			<m_connection>photo.rate</m_connection>
			<module_id>photo</module_id>
			<component>stat</component>
			<location>3</location>
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
			<m_connection>group.view</m_connection>
			<module_id>photo</module_id>
			<component>parent</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<feed_share>
		<share>
			<module_id>photo</module_id>
			<title><![CDATA[{phrase var='photo.photo'}]]></title>
			<description><![CDATA[{phrase var='photo.say_something_about_this_photo'}]]></description>
			<block_name>share</block_name>
			<no_input>0</no_input>
			<is_frame>1</is_frame>
			<ajax_request />
			<no_profile>0</no_profile>
			<icon>photo.png</icon>
			<ordering>1</ordering>
			<value />
		</share>
	</feed_share>
	<sql><![CDATA[a:5:{s:9:"ADD_FIELD";a:2:{s:12:"phpfox_photo";a:6:{s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"type_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:18:"phpfox_photo_album";a:6:{s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:17:"time_stamp_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"profile_id";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ALTER_KEY";a:1:{s:12:"phpfox_photo";a:9:{s:8:"album_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"album_id";i:1;s:7:"view_id";}}s:8:"photo_id";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:8:"photo_id";i:1;s:8:"album_id";i:2;s:7:"view_id";i:3;s:8:"group_id";i:4;s:7:"privacy";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:8:"group_id";i:2;s:7:"type_id";i:3;s:7:"privacy";}}s:10:"photo_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:6:{i:0;s:8:"photo_id";i:1;s:8:"album_id";i:2;s:7:"view_id";i:3;s:8:"group_id";i:4;s:7:"type_id";i:5;s:7:"privacy";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:8:"group_id";i:2;s:7:"type_id";i:3;s:7:"user_id";}}s:10:"album_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"album_id";i:1;s:7:"view_id";i:2;s:8:"is_cover";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:5:"title";}}s:9:"view_id_5";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:9:"module_id";i:2;s:8:"group_id";i:3;s:7:"privacy";}}}}s:7:"ADD_KEY";a:2:{s:12:"phpfox_photo";a:1:{s:7:"privacy";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"privacy";i:1;s:10:"allow_rate";}}}s:18:"phpfox_photo_album";a:1:{s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"user_id";}}}}s:10:"REMOVE_KEY";a:2:{s:12:"phpfox_photo";a:6:{i:0;a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"photo_id";i:1;s:8:"album_id";}}i:1;a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:8:"album_id";i:1;s:7:"view_id";i:2;s:8:"group_id";i:3;s:7:"privacy";i:4;s:7:"user_id";}}i:2;a:2:{i:0;s:5:"INDEX";i:1;s:10:"allow_rate";}i:3;a:2:{i:0;s:5:"INDEX";i:1;s:11:"destination";}i:4;a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"photo_id";i:1;s:8:"album_id";i:2;s:8:"group_id";}}i:5;a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}s:18:"phpfox_photo_album";a:1:{i:0;a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:8:"name_url";}}}}s:11:"ALTER_FIELD";a:1:{s:21:"phpfox_photo_category";a:1:{s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>