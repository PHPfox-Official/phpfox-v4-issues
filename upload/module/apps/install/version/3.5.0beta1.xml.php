<upgrade>
	<hooks>
		<hook>
			<module_id>apps</module_id>
			<hook_type>controller</hook_type>
			<module>apps</module>
			<call_name>apps.component_controller_admincp_import_clean</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>apps</module_id>
			<hook_type>controller</hook_type>
			<module>apps</module>
			<call_name>apps.component_controller_admincp_export_clean</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:10:"phpfox_app";a:2:{s:10:"return_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"is_ext";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:10:"phpfox_app";a:2:{s:10:"public_key";a:2:{i:0;s:5:"INDEX";i:1;s:10:"public_key";}s:6:"app_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:6:"app_id";i:1;s:6:"is_ext";}}}}}]]></sql>
</upgrade>