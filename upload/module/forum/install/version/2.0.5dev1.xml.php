<upgrade>
	<settings>
		<setting>
			<group>time_stamps</group>
			<module_id>forum</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>global_forum_timezone</var_name>
			<phrase_var_name>setting_global_forum_timezone</phrase_var_name>
			<ordering>3</ordering>
			<version_id>2.0.5</version_id>
			<value>g:i a</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_can_sponsor_thread</var_name>
			<added>1269951006</added>
			<value>Can members of this user group mark a thread as sponsored?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor</var_name>
			<added>1269951526</added>
			<value>Sponsor</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>you_are_not_allowed_to_mark_threads_as_sponsor</var_name>
			<added>1269952247</added>
			<value>You are not allowed to mark threads as sponsor.</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_can_purchase_sponsor</var_name>
			<added>1271152478</added>
			<value>Can members of this user group purchase a sponsored ad space?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>unsponsor</var_name>
			<added>1271159396</added>
			<value>Unsponsor</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>thread_successfully_sponsored</var_name>
			<added>1271161358</added>
			<value>Thread Successfully Sponsored</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>thread_successfully_unsponsored</var_name>
			<added>1271161410</added>
			<value>Thread Successfully Unsponsored</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_forum_thread_sponsor_price</var_name>
			<added>1271847763</added>
			<value>How much is the sponsor space worth for forum threads?
This works in a CPM basis.</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_error_not_found</var_name>
			<added>1272005806</added>
			<value>That thread is no longer available</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_title</var_name>
			<added>1272005846</added>
			<value>Forum thread: {sThreadTitle}</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_paypal_message</var_name>
			<added>1272005907</added>
			<value>Sponsor of forum thread: {sThreadTitle}</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_auto_publish_sponsored_item</var_name>
			<added>1272006656</added>
			<value>After the user has purchased a sponsored space, should the thread be published right away?
If set to false, the admin will have to approve each new purchased sponsored thread space before it is shown in the site.</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5</version_id>
			<var_name>setting_global_forum_timezone</var_name>
			<added>1273245857</added>
			<value><![CDATA[<title>Forum Global Time Stamp</title><info>This is the time stamp that is displayed at the bottom of the forum.</info>]]></value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>can_sponsor_thread</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>can_purchase_sponsor</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>string</type>
			<admin>null</admin>
			<user>null</user>
			<guest>null</guest>
			<staff>null</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>forum_thread_sponsor_price</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>true</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>auto_publish_sponsored_thread</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>forum</module_id>
			<hook_type>service</hook_type>
			<module>forum</module>
			<call_name>forum.service_thread_process_sponsor__end</call_name>
			<added>1274286148</added>
			<version_id>2.0.5dev1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>component</hook_type>
			<module>forum</module>
			<call_name>forum.component_ajax_get_text</call_name>
			<added>1274286148</added>
			<version_id>2.0.5dev1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>forum</module_id>
			<hook_type>template</hook_type>
			<module>forum</module>
			<call_name>forum.template_controller_thread_form_quick_reply</call_name>
			<added>1274286148</added>
			<version_id>2.0.5dev1</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">forum.html.php</file>
		<file type="controller">thread.html.php</file>
		<file type="controller">post.html.php</file>
		<file type="block">thread-entry.html.php</file>
	</update_templates>
</upgrade>