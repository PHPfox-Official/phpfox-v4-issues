<upgrade>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>3.2.0</version_id>
			<var_name>your_photo_has_been_approved_message</var_name>
			<added>1335946950</added>
			<value><![CDATA[Your photo "<a href=&#039;{sLink}&#039;>{title}</a>" has been approved.
To view this photo follow the link below:
<a href="{sLink}">{sLink}</a>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>photo</module_id>
			<hook_type>component</hook_type>
			<module>photo</module>
			<call_name>photo.component_ajax_ajax_process__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_album__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_converting_clean</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_index_brunplugin1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_index_plugin1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_view__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>controller</hook_type>
			<module>photo</module>
			<call_name>photo.component_controller_view__2</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.service_album_process_delete__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.component_service_callback_getactivityfeed__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.service_process_delete__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.service_process_approve__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.service_tag_process_add__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>photo</module_id>
			<hook_type>service</hook_type>
			<module>photo</module>
			<call_name>photo.service_tag_process_delete__1</call_name>
			<added>1335951260</added>
			<version_id>3.2.0</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>