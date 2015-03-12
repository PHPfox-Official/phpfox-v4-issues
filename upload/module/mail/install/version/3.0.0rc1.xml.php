<upgrade>
	<phrases>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>delete_this_list</var_name>
			<added>1319792161</added>
			<value>Delete This List</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>moderate</var_name>
			<added>1319792181</added>
			<value>Moderate</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>mark_as_read</var_name>
			<added>1319792194</added>
			<value>Mark as Read</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>mark_as_unread</var_name>
			<added>1319792203</added>
			<value>Mark as Unread</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>you</var_name>
			<added>1319792216</added>
			<value>You</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>no_messages_found_here</var_name>
			<added>1319792229</added>
			<value>No messages found here.</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>create_a_new_folder</var_name>
			<added>1319792250</added>
			<value>Create a New Folder</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>search_messages</var_name>
			<added>1319792276</added>
			<value>Search Messages...</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>latest</var_name>
			<added>1319792284</added>
			<value>Latest</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>unread_first</var_name>
			<added>1319792292</added>
			<value>Unread First</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>move</var_name>
			<added>1319792308</added>
			<value>Move</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>this_message_was_sent_from_full_name</var_name>
			<added>1319792349</added>
			<value>This message was sent from {full_name}</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>actions</var_name>
			<added>1319792388</added>
			<value>Actions</value>
		</phrase>
		<phrase>
			<module_id>mail</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>search_friends_by_their_name</var_name>
			<added>1319792505</added>
			<value>Search friends by their name...</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>mail</module_id>
			<hook_type>component</hook_type>
			<module>mail</module>
			<call_name>mail.component_ajax_compose</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>component</hook_type>
			<module>mail</module>
			<call_name>mail.component_block_box_add_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>component</hook_type>
			<module>mail</module>
			<call_name>mail.component_block_box_select_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>component</hook_type>
			<module>mail</module>
			<call_name>mail.component_block_latest_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>component</hook_type>
			<module>mail</module>
			<call_name>mail.component_block_notify_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>service</hook_type>
			<module>mail</module>
			<call_name>mail.service_api__call</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>service</hook_type>
			<module>mail</module>
			<call_name>mail.service_mail_canmessageuser_1</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>service</hook_type>
			<module>mail</module>
			<call_name>mail.service_process_add_1</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>mail</module_id>
			<hook_type>template</hook_type>
			<module>mail</module>
			<call_name>mail.template_controller_compose_ajax_onsubmit</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>