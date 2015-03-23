<upgrade>
	<hooks>
		<hook>
			<module_id>feed</module_id>
			<hook_type>service</hook_type>
			<module>feed</module>
			<call_name>feed.service_process_like_notify</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>component</hook_type>
			<module>feed</module>
			<call_name>feed.component_block_display_process_flike</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>component</hook_type>
			<module>feed</module>
			<call_name>feed.component_block_like_list_clean</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_feed";a:1:{s:7:"is_like";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:11:"phpfox_feed";a:1:{s:7:"is_like";a:2:{i:0;s:5:"INDEX";i:1;s:7:"is_like";}}}}]]></sql>
	<update_templates>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>