<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>delete_original_after_resize</var_name>
			<phrase_var_name>setting_delete_original_after_resize</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>drop</type>
			<var_name>in_main_photo_section_show</var_name>
			<phrase_var_name>setting_in_main_photo_section_show</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:6:"photos";s:6:"values";a:2:{i:0;s:6:"photos";i:1;s:7:" albums";}}]]></value>
		</setting>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>show_info_on_mouseover</var_name>
			<phrase_var_name>setting_show_info_on_mouseover</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_delete_original_after_resize</var_name>
			<added>1352107332</added>
			<value><![CDATA[<title>Delete Original Photo After Resize</title><info>When a user uploads an image the site will create thumbnails of this image, and uses the thumbnails around the site. 
If you enable this setting the original file (that the user uploaded) will be deleted after the thumbnails have been created.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>item_phrase</var_name>
			<added>1352730334</added>
			<value>photo</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>item_phrase_album</var_name>
			<added>1352730426</added>
			<value>photo album</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_in_main_photo_section_show</var_name>
			<added>1355986348</added>
			<value><![CDATA[<title>In Main Photo Section Show</title><info>This setting lets you choose what should be displayed when going to the main photo section. The default is to display photos</info>]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_show_info_on_mouseover</var_name>
			<added>1356078187</added>
			<value><![CDATA[<title>Dynamic View</title><info>
This setting changes a few aspects related to the photo section:<br/>
- It hides the user and album name of a photo until you place the cursor over that photo
- The thumbnails for the photos are bigger
- When placing the mouse over a thumbnail you can like the photo with one click.
- The Pager in the photo section is a bigger button allowing the visitor to simply load more photos.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>menu_photo_upload_a_new_image_0df7df42d810e7978c535292f273fc91</var_name>
			<added>1357813885</added>
			<value>Upload a New Image</value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>photo</module_id>
			<parent_var_name />
			<m_connection>photo.albums</m_connection>
			<var_name>menu_photo_upload_a_new_image_0df7df42d810e7978c535292f273fc91</var_name>
			<ordering>129</ordering>
			<url_value>photo.add</url_value>
			<version_id>3.5.0beta1</version_id>
			<disallow_access />
			<module>photo</module>
			<value />
		</menu>
	</menus>
	<hooks>
		<hook>
			<module_id>photo</module_id>
			<hook_type>template</hook_type>
			<module>photo</module>
			<call_name>photo.template_block_share_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>template</hook_type>
			<module>photo</module>
			<call_name>photo.template_block_share_2</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>template</hook_type>
			<module>photo</module>
			<call_name>photo.template_block_share_3</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>template</hook_type>
			<module>photo</module>
			<call_name>photo.template_controller_view_view_box_comment_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>template</hook_type>
			<module>photo</module>
			<call_name>photo.template_controller_view_view_box_comment_2</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>template</hook_type>
			<module>photo</module>
			<call_name>photo.template_controller_view_view_box_comment_3</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.service_callback_getprofilemenu_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_profile_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<components>
		<component>
			<module_id>photo</module_id>
			<component>albums</component>
			<m_connection>photo.albums</m_connection>
			<module>photo</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:2:{s:12:"phpfox_photo";a:1:{s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:18:"phpfox_photo_album";a:1:{s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>