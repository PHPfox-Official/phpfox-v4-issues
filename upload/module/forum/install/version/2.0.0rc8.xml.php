<upgrade>
	<phrases>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>display_options</var_name>
			<added>1258414774</added>
			<value>Display Options</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>additional_options</var_name>
			<added>1258414801</added>
			<value>Additional Options</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>forum</module_id>
			<hook_type>component</hook_type>
			<module>forum</module>
			<call_name>forum.component_block_parent_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>controller</hook_type>
			<module>forum</module>
			<call_name>forum.component_controller_read_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>controller</hook_type>
			<module>forum</module>
			<call_name>forum.component_controller_action_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>controller</hook_type>
			<module>forum</module>
			<call_name>forum.component_controller_group_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>controller</hook_type>
			<module>forum</module>
			<call_name>forum.component_controller_rss_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>service</hook_type>
			<module>forum</module>
			<call_name>forum.service_subscribe_process__call</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>service</hook_type>
			<module>forum</module>
			<call_name>forum.service_subscribe_subscribe__call</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">forum.html.php</file>
		<file type="controller">post.html.php</file>
		<file type="block">forum.html.php</file>
	</update_templates>
</upgrade>