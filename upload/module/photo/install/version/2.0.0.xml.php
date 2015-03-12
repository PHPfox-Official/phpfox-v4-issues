<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>ajax_refresh_on_featured_photos</var_name>
			<phrase_var_name>setting_ajax_refresh_on_featured_photos</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>update_tags_photo</var_name>
			<added>1261056664</added>
			<value>Update Tags (Photo)</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>user_setting_can_view_private_photos</var_name>
			<added>1261073026</added>
			<value>Can view private and password protected photos?</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>rate_this_image</var_name>
			<added>1261161424</added>
			<value>Rate This Image</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>total_rating_out_of_5</var_name>
			<added>1261179113</added>
			<value>{total_rating} out of 10</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>no_photos_found</var_name>
			<added>1261179316</added>
			<value>No photos found.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>no_photos_have_been_rated</var_name>
			<added>1261179331</added>
			<value>No photos have been rated.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>no_photo_battles_have_taken_place</var_name>
			<added>1261179377</added>
			<value>No photo battles have taken place.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>total_battle_win_s</var_name>
			<added>1261179478</added>
			<value>{total_battle} win(s)</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>setting_ajax_refresh_on_featured_photos</var_name>
			<added>1261335633</added>
			<value><![CDATA[<title>AJAX Refresh Featured Photos</title><info>With this option enabled photos within the "Featured Photo" block will refresh.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>no_popular_photos_found</var_name>
			<added>1261412466</added>
			<value>No popular photos found.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>no_featured_photos_found</var_name>
			<added>1261412669</added>
			<value>No featured photos found.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>comments_total_comment</var_name>
			<added>1261413297</added>
			<value>Comments ({total_comment})</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>total_score_out_of_10</var_name>
			<added>1261413456</added>
			<value>{total_score} out of 10</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>sorry_the_photo_you_are_looking_for_no_longer_exists</var_name>
			<added>1261415869</added>
			<value><![CDATA[Sorry, the photo you are looking for no longer exists. Please <a href="{link}">click here</a> to browse more photos.]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>cancel_lowercase</var_name>
			<added>1261511944</added>
			<value>cancel</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>personal_this_album_will_only_be_displayed_on_your_profile</var_name>
			<added>1261514661</added>
			<value>Personal (This album will only be displayed on your profile.)</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>public_this_album_will_be_added_to_our_public_photo_album_section</var_name>
			<added>1261514696</added>
			<value>Public (This album will be added to our public photo album section.)</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0</version_id>
			<var_name>delete_this_image</var_name>
			<added>1261570267</added>
			<value>Delete this image.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>photo</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>photo</module>
			<ordering>0</ordering>
			<value>can_view_private_photos</value>
		</setting>
	</user_group_settings>
	<components>
		<component>
			<module_id>photo</module_id>
			<component>upload</component>
			<m_connection>photo.upload</m_connection>
			<module>photo</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>photo</module_id>
			<component>parent</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="controller">upload.html.php</file>
		<file type="controller">album.html.php</file>
		<file type="controller">index.html.php</file>
		<file type="block">photo-entry.html.php</file>
		<file type="block">featured.html.php</file>
		<file type="block">new-image.html.php</file>
		<file type="block">menu.html.php</file>
		<file type="block">album-entry.html.php</file>
		<file type="block">form-album.html.php</file>
	</update_templates>
</upgrade>