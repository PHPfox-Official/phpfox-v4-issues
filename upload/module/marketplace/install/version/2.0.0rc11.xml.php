<upgrade>
	<phrases>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>this_category_name_cannot_be_used_due_to_that_there_is_already_another_category_with_the_same_name_being_used</var_name>
			<added>1260237609</added>
			<value>This category name cannot be used due to that there is already another category with the same name being used.</value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>user_setting_can_access_marketplace</var_name>
			<added>1260286697</added>
			<value>Can browse and view listings?</value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>user_setting_can_create_listing</var_name>
			<added>1260329360</added>
			<value>Can create a listing?</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>marketplace</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>1</guest>
			<staff>1</staff>
			<module>marketplace</module>
			<ordering>0</ordering>
			<value>can_access_marketplace</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>marketplace</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>marketplace</module>
			<ordering>0</ordering>
			<value>can_create_listing</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>marketplace</module_id>
			<hook_type>service</hook_type>
			<module>marketplace</module>
			<call_name>marketplace.service_process_add__start</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>marketplace</module_id>
			<hook_type>service</hook_type>
			<module>marketplace</module>
			<call_name>marketplace.service_process_add__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="block">photo.html.php</file>
	</update_templates>
</upgrade>