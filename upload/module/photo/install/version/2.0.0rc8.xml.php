<upgrade>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>remove_tag</var_name>
			<added>1258385449</added>
			<value>remove tag</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>photo</module_id>
			<hook_type>component</hook_type>
			<module>photo</module>
			<call_name>photo.component_block_profile_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>component</hook_type>
			<module>photo</module>
			<call_name>photo.component_block_parent_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_group_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.service_album_album_getforedit</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>