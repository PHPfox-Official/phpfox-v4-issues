<upgrade>
	<hooks>
		<hook>
			<module_id>report</module_id>
			<hook_type>component</hook_type>
			<module>report</module>
			<call_name>report.component_block_browse_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>report</module_id>
			<hook_type>service</hook_type>
			<module>report</module>
			<call_name>report.service_data_data__call</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="block">add.html.php</file>
	</update_templates>
</upgrade>