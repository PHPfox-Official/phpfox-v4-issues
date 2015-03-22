<upgrade>
	<phrases>
		<phrase>
			<module_id>share</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>before_using_this_feature_you_will_have_to_setup_up_a_connection_with_this_3rd_party_service</var_name>
			<added>1320229448</added>
			<value>Before using this feature you will have to setup up a connection with this 3rd party service.</value>
		</phrase>
		<phrase>
			<module_id>share</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>connect_now</var_name>
			<added>1320229456</added>
			<value>Connect Now</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>share</module_id>
			<hook_type>component</hook_type>
			<module>share</module>
			<call_name>share.component_block_connect_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>share</module_id>
			<hook_type>controller</hook_type>
			<module>share</module>
			<call_name>share.component_controller_connect_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>