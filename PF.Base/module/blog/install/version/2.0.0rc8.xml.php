<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>blog</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>digg_integration</var_name>
			<phrase_var_name>setting_digg_integration</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc8</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>blog</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>setting_digg_integration</var_name>
			<added>1258399183</added>
			<value><![CDATA[<title>Digg Intergration</title><info>Add Digg integration.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>blog</module_id>
			<hook_type>controller</hook_type>
			<module>blog</module>
			<call_name>blog.component_controller_admincp_browse_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>