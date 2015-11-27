<upgrade>
	<phrases>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>menu_core_friends</var_name>
			<added>1220960932</added>
			<value>Friends</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.4</version_id>
			<var_name>optional</var_name>
			<added>1266425024</added>
			<value>(optional)</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.4</version_id>
			<var_name>user_setting_total_folders</var_name>
			<added>1267026937</added>
			<value><![CDATA[Allowed Total Friend Folders (Enter without quotes "0" for no limit.)]]></value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.4</version_id>
			<var_name>no_search_results_found</var_name>
			<added>1267547707</added>
			<value>No search results found.</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.4</version_id>
			<var_name>no_friends_found</var_name>
			<added>1267547714</added>
			<value>No friends found.</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.4</version_id>
			<var_name>search</var_name>
			<added>1267547722</added>
			<value>Search</value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>friend</module_id>
			<parent_id>0</parent_id>
			<m_connection>main</m_connection>
			<var_name>menu_core_friends</var_name>
			<ordering>5</ordering>
			<url_value>friend</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>friend</module>
			<value />
		</menu>
	</menus>
	<hooks>
		<hook>
			<module_id>friend</module_id>
			<hook_type>controller</hook_type>
			<module>friend</module>
			<call_name>friend.component_controller_index_mobile_clean</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="block">accept.html.php</file>
		<file type="block">request.html.php</file>
	</update_templates>
</upgrade>