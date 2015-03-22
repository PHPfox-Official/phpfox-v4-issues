<upgrade>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0</version_id>
			<var_name>update_tags_videos</var_name>
			<added>1261056044</added>
			<value>Update Tags (Videos)</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0</version_id>
			<var_name>1_view</var_name>
			<added>1261163385</added>
			<value>1 view</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0</version_id>
			<var_name>no_videos_found</var_name>
			<added>1261413540</added>
			<value>No videos found.</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0</version_id>
			<var_name>total_rating_out_of_10</var_name>
			<added>1261569933</added>
			<value>{total_rating} out of 10</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>video</module_id>
			<component>parent</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="controller">view.html.php</file>
		<file type="controller">index.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">spotlight.html.php</file>
	</update_templates>
</upgrade>