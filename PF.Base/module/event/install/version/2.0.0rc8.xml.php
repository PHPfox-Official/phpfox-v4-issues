<upgrade>
	<phrases>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>unable_to_find_the_event_you_want_to_approve</var_name>
			<added>1258472809</added>
			<value>Unable to find the event you want to approve.</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>you_do_not_have_sufficient_permission_to_modify_this_event</var_name>
			<added>1258472832</added>
			<value>You do not have sufficient permission to modify this event.</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>unable_to_find_the_event</var_name>
			<added>1258472853</added>
			<value>Unable to find the event.</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>unable_to_find_the_event_you_want_to_delete</var_name>
			<added>1258472870</added>
			<value>Unable to find the event you want to delete.</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>you_do_not_have_sufficient_permission_to_delete_this_listing</var_name>
			<added>1258472878</added>
			<value>You do not have sufficient permission to delete this listing.</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>your_event_has_been_approved_on_site_title</var_name>
			<added>1258472903</added>
			<value>Your event has been approved on {site_title}.</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>your_event_has_been_approved_on_site_title_link</var_name>
			<added>1258472958</added>
			<value><![CDATA[Your event has been approved on {site_title}.

To view this event, follow the link below:
<a href="{link}">{link}</a>]]></value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>notice_this_is_a_newsletter_sent_from_the_event</var_name>
			<added>1258472989</added>
			<value>Notice: This is a newsletter sent from the event</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>event</module_id>
			<hook_type>component</hook_type>
			<module>event</module>
			<call_name>event.component_block_filter_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">view.html.php</file>
	</update_templates>
</upgrade>