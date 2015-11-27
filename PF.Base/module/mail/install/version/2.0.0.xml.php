<upgrade>
	<phrases>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.0</version_id>
			<var_name>viewing_private_message</var_name>
			<added>1261069259</added>
			<value>Viewing Private Message</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.0</version_id>
			<var_name>private_message_from_timestamp</var_name>
			<added>1261069539</added>
			<value>Private message from {time_stamp} between {owner} and {viewer}.</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.0</version_id>
			<var_name>message_not_found</var_name>
			<added>1261069623</added>
			<value>Message not found.</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.0</version_id>
			<var_name>report</var_name>
			<added>1261069915</added>
			<value>Report</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.0</version_id>
			<var_name>report_this_message</var_name>
			<added>1261069925</added>
			<value>Report this message.</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>mail</module_id>
			<hook_type>controller</hook_type>
			<module>mail</module>
			<call_name>mail.component_controller_admincp_view_clean</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">view.html.php</file>
	</update_templates>
</upgrade>