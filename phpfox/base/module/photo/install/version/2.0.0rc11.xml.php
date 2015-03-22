<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>photo</module_id>
			<is_hidden>1</is_hidden>
			<type>boolean</type>
			<var_name>rating_randomize_photos</var_name>
			<phrase_var_name>setting_rating_randomize_photos</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value>0</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>no_photos_have_been_featured</var_name>
			<added>1260189682</added>
			<value>No photos have been featured.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>no_photos_pending_approval</var_name>
			<added>1260189708</added>
			<value>No photos pending approval.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>recent_photos</var_name>
			<added>1260189785</added>
			<value>Recent Photos</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>featured</var_name>
			<added>1260189792</added>
			<value>Featured</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>pending</var_name>
			<added>1260189799</added>
			<value>Pending</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>unfeature</var_name>
			<added>1260190575</added>
			<value>Unfeature</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>photo_successfully_unfeatured</var_name>
			<added>1260190782</added>
			<value>Photo successfully unfeatured.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>albums</var_name>
			<added>1260195690</added>
			<value>Albums</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>no_public_photo_albums_found</var_name>
			<added>1260195737</added>
			<value>No public photo albums found.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>advanced_critique_is_encouraged_when_commenting_on_this_photo</var_name>
			<added>1260204958</added>
			<value>Advanced critique is encouraged when commenting on this photo.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>criticism_is_discouraged_when_commenting_on_this_photo</var_name>
			<added>1260204967</added>
			<value>Criticism is discouraged when commenting on this photo.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>create_a_new_album</var_name>
			<added>1260206706</added>
			<value>Create a New Album</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>user_setting_can_view_photos</var_name>
			<added>1260276540</added>
			<value>Can browse and view the photo module?</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>you_have_rated_all_the_available_images</var_name>
			<added>1255094396</added>
			<value>No more available images to rate.</value>
		</phrase>
	</phpfox_update_phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>photo</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>1</guest>
			<staff>1</staff>
			<module>photo</module>
			<ordering>0</ordering>
			<value>can_view_photos</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.service_process_add__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_public_album_clean</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">profile.html.php</file>
		<file type="controller">view.html.php</file>
		<file type="controller">upload.html.php</file>
		<file type="controller">index.html.php</file>
		<file type="controller">public-album.html.php</file>
		<file type="block">profile.html.php</file>
		<file type="block">photo-entry.html.php</file>
		<file type="block">form.html.php</file>
	</update_templates>
</upgrade>