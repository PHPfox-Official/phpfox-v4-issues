<upgrade>
	<phrases>
		<phrase>
			<module_id>admincp</module_id>
			<version_id>2.0.5</version_id>
			<var_name>alter_title_fields</var_name>
			<added>1275386165</added>
			<value>Alter Title Fields</value>
		</phrase>
		<phrase>
			<module_id>admincp</module_id>
			<version_id>2.0.5</version_id>
			<var_name>database_tables_updated</var_name>
			<added>1275386206</added>
			<value>Database tables updated.</value>
		</phrase>
		<phrase>
			<module_id>admincp</module_id>
			<version_id>2.0.5</version_id>
			<var_name>b_notice_b_this_routine_is_highly_experimental</var_name>
			<added>1275386223</added>
			<value><![CDATA[<b>Notice:</b> This routine is highly experimental.]]></value>
		</phrase>
		<phrase>
			<module_id>admincp</module_id>
			<version_id>2.0.5</version_id>
			<var_name>all_items_on_the_site_store_certain_information_in_the_database</var_name>
			<added>1275386310</added>
			<value>All items on the site store certain information in the database. Some of this information are the titles of items. By default these fields that store the items title have a limit of 255 characters, which with alphanumeric characters is a lot. However, if using non-latin characters this might not be enough and titles are cut short. This reason for this is we convert non-latin characters before they are added into the database so when they are outputted everyone can view these characters irregardless of what character-set they have. Using the tool found on this page you can enlarge these fields to store a maximum of 65,535 characters.</value>
		</phrase>
		<phrase>
			<module_id>admincp</module_id>
			<version_id>2.0.5</version_id>
			<var_name>update_database_tables</var_name>
			<added>1275386334</added>
			<value>Update Database Tables</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>admincp</module_id>
			<hook_type>controller</hook_type>
			<module>admincp</module>
			<call_name>admincp.component_controller_sql_title_clean</call_name>
			<added>1276177474</added>
			<version_id>2.0.5</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>