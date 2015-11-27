<upgrade>
	<phrases>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.7</version_id>
			<var_name>music_genres</var_name>
			<added>1290008427</added>
			<value>Music Genres</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.7</version_id>
			<var_name>please_select_a_genre_for_your_music</var_name>
			<added>1290010470</added>
			<value>Please select a genre for your music.</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.7</version_id>
			<var_name>update</var_name>
			<added>1290010481</added>
			<value>Update</value>
		</phrase>
		<phrase>
			<module_id>music</module_id>
			<version_id>2.0.7</version_id>
			<var_name>note_that_you_can_edit_your_genre</var_name>
			<added>1290010521</added>
			<value><![CDATA[Note that you can edit your genre at a later time by editing your profile <a href="{link}">here</a>.]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>music</module_id>
			<hook_type>service</hook_type>
			<module>music</module>
			<call_name>music.service_callback_getnewsfeedsong_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>service</hook_type>
			<module>music</module>
			<call_name>music.song_album_service_callback_getnewsfeed_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>template</hook_type>
			<module>music</module>
			<call_name>music.template_block_menu</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_genre_form_clean</call_name>
			<added>1290072896</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>