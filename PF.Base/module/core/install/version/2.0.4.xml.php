<upgrade>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.4</version_id>
			<var_name>what_s_on_your_mind</var_name>
			<added>1267544459</added>
			<value><![CDATA[What's on your mind?]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>mail_send_query</call_name>
			<added>1266260139</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>mail_send_call</call_name>
			<added>1266260139</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>file_upload_start</call_name>
			<added>1266260157</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>check_url_is_array_return</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>controller</hook_type>
			<module>core</module>
			<call_name>core.component_controller_index_visitor_mobile_clean</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>controller</hook_type>
			<module>core</module>
			<call_name>core.component_controller_index_member_mobile_clean</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>hash_sethash__end</call_name>
			<added>1268138234</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:1:{s:11:"ALTER_FIELD";a:1:{s:11:"phpfox_menu";a:1:{s:8:"var_name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
	<update_templates>
		<file type="block">dashboard.html.php</file>
		<file type="block">footer.html.php</file>
		<file type="layout">template.html.php</file>
	</update_templates>
	<update_styles>
		<file type="layout">common.css</file>
	</update_styles>
</upgrade>