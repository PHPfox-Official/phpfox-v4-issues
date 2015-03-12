<upgrade>
	<phrases>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.4</version_id>
			<var_name>mobile_messages</var_name>
			<added>1267559963</added>
			<value>Messages</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.4</version_id>
			<var_name>compose</var_name>
			<added>1267559980</added>
			<value>Compose</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.4</version_id>
			<var_name>no_messages</var_name>
			<added>1267622617</added>
			<value>No messages</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.4</version_id>
			<var_name>unable_to_find_any_messages</var_name>
			<added>1267622629</added>
			<value>Unable to find any messages</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.4</version_id>
			<var_name>select_recipient</var_name>
			<added>1267622645</added>
			<value>Select Recipient</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>2.0.4</version_id>
			<var_name>select_a_recipient_below</var_name>
			<added>1267622665</added>
			<value>Select a recipient below</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>mail</module_id>
			<hook_type>controller</hook_type>
			<module>mail</module>
			<call_name>mail.component_controller_compose_mobile_clean</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>controller</hook_type>
			<module>mail</module>
			<call_name>mail.component_controller_index_mobile_clean</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>controller</hook_type>
			<module>mail</module>
			<call_name>mail.component_controller_view_mobile_clean</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_mail";a:1:{s:7:"mass_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>