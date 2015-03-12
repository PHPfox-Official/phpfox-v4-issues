<upgrade>
	<phrases>
		<phrase>
			<module_id>admincp</module_id>
			<version_id>3.7.0rc1</version_id>
			<var_name>uninstall_module_reminder</var_name>
			<added>1377070561</added>
			<value>Do not forget to remove the folder for this module from the /module/ folder</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>admincp</module_id>
			<hook_type>controller</hook_type>
			<module>admincp</module>
			<call_name>admincp.component_controller_maintain_1</call_name>
			<added>1378375116</added>
			<version_id>3.7.0rc1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>