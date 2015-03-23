<module>
	<data>
		<module_id>error</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_error</phrase_var_name>
		<writable />
	</data>
	<hooks>
		<hook module_id="error" hook_type="controller" module="error" call_name="error.component_controller_notfound_1" added="1361180401" version_id="3.5.0rc1" />
	</hooks>
	<components>
		<component module_id="error" component="display" m_connection="error.display" module="error" is_controller="1" is_block="0" is_active="1" />
		<component module_id="error" component="404" m_connection="error.404" module="error" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="error" version_id="2.0.0alpha1" var_name="module_error" added="1214851398">Error Handler</phrase>
		<phrase module_id="error" version_id="2.0.0alpha1" var_name="csrf_token_set" added="1214851419">No security token has been set within the posted form. All forms must contain a security token in order for our site to handle its requests.</phrase>
		<phrase module_id="error" version_id="2.0.0alpha1" var_name="csrf_session_token" added="1214851490">No security token was set to your session. Please make sure your web browser is allowing all COOKIES from our site.</phrase>
		<phrase module_id="error" version_id="2.0.0alpha1" var_name="csrf_detected" added="1214851524">Cross site forgery request (CSFR) detected.  Please note all such attempts are logged.</phrase>
		<phrase module_id="error" version_id="2.0.0alpha1" var_name="site_email_not_set" added="1233753322">The admin has not set any email address to contact them.</phrase>
		<phrase module_id="error" version_id="2.0.0rc3" var_name="the_page_you_are_looking_for_cannot_be_found" added="1254390056">The page you are looking for cannot be found.</phrase>
	</phrases>
</module>