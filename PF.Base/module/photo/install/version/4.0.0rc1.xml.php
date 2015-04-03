<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>photo_image_details_time_stamp</var_name>
			<phrase_var_name>setting_photo_image_details_time_stamp</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value>F j, Y</value>
		</setting>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enabled_watermark_on_photos</var_name>
			<phrase_var_name>setting_enabled_watermark_on_photos</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>1</is_hidden>
			<type>boolean</type>
			<var_name>pre_load_header_view</var_name>
			<phrase_var_name>setting_pre_load_header_view</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.6.0rc1</version_id>
			<value>1</value>
		</setting>
	</phpfox_update_settings>
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
			<mobile_icon>photo</mobile_icon>
			<value />
		</menu>
	</phpfox_update_menus>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.view</m_connection>
			<module_id>photo</module_id>
			<component>stream</component>
			<location>7</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Viewing Photo</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
</upgrade>