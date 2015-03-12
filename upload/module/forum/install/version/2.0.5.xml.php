<upgrade>
	<phrases>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_auto_publish_sponsored_thread</var_name>
			<added>1276177393</added>
			<value>After the user has purchased a sponsored space, should the thread be published right away?
If set to false, the admin will have to approve each new purchased sponsored thread before it is shown in the site.</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>forum</module_id>
			<hook_type>service</hook_type>
			<module>forum</module>
			<call_name>forum.service_moderate_moderate_getperms</call_name>
			<added>1276177474</added>
			<version_id>2.0.5</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>