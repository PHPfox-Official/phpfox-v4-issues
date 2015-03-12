<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>display_profile_photo_within_gallery</var_name>
			<phrase_var_name>setting_display_profile_photo_within_gallery</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.1.0beta1</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.1.0beta1</version_id>
			<var_name>setting_display_profile_photo_within_gallery</var_name>
			<added>1329766842</added>
			<value><![CDATA[<title>Display Profile Photo within Gallery</title><info>Disable this feature if you do not want to display profile photos within the photo gallery.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.1.0beta1</version_id>
			<var_name>update_profile_photos</var_name>
			<added>1329769181</added>
			<value>Update Profile Photos</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.1.0beta1</version_id>
			<var_name>user_name_tagged_you_in_a_comment_in_a_photo</var_name>
			<added>1331221050</added>
			<value>{user_name} tagged you in a comment in a photo</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.1.0beta1</version_id>
			<var_name>user_name_tagged_you_in_a_comment_in_a_photo_album</var_name>
			<added>1331221198</added>
			<value>{user_name} tagged you in a comment in a photo album</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.view</m_connection>
			<module_id>photo</module_id>
			<component>detail</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Photo Details</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_photo";a:1:{s:16:"is_profile_photo";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:12:"phpfox_photo";a:1:{s:16:"is_profile_photo";a:2:{i:0;s:5:"INDEX";i:1;s:16:"is_profile_photo";}}}}]]></sql>
</upgrade>