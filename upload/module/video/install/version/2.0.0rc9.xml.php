<upgrade>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>tags</var_name>
			<added>1258733037</added>
			<value>Tags</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>view_more_videos</var_name>
			<added>1258739743</added>
			<value>View More Videos</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>video_added_on_time_stamp_by_full_name</var_name>
			<added>1258739906</added>
			<value><![CDATA[<a href="{link}">Video</a> added on {time_stamp} by <a href="{user_link}">{full_name}</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>update_video_view_count</var_name>
			<added>1258986172</added>
			<value><![CDATA[Update video "view" count (Only for those that upgraded from v1.6.21).]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>total_views</var_name>
			<added>1259000889</added>
			<value>{total} views</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_tag_clean</call_name>
			<added>1259160644</added>
			<version_id>2.0.0rc9</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="block">detail.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">form.html.php</file>
	</update_templates>
</upgrade>