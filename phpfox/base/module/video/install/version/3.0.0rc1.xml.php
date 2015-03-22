<upgrade>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>by_lowercase</var_name>
			<added>1320414457</added>
			<value>by</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>views</var_name>
			<added>1320414463</added>
			<value>views</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_ajax_convert_feed</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_featured_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_file_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_share_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_supported_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_url_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>component</hook_type>
			<module>video</module>
			<call_name>video.component_block_user_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_add_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_view_video_path</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
	</hooks>
	<phpfox_update_rss>
		<feed>
			<module_id>video</module_id>
			<group_id>4</group_id>
			<title_var>video.rss_title_5</title_var>
			<description_var>video.rss_description_5</description_var>
			<feed_link>video</feed_link>
			<is_active>1</is_active>
			<is_site_wide>1</is_site_wide>
			<php_group_code />
			<php_view_code><![CDATA[$aRows = Phpfox::getService('video')->getForRssFeed();]]></php_view_code>
		</feed>
	</phpfox_update_rss>
</upgrade>