<upgrade>
	<phrases>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.0.0</version_id>
			<var_name>your_page_has_been_approved</var_name>
			<added>1322731734</added>
			<value><![CDATA[Your page "{title}" has been approved.]]></value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.0.0</version_id>
			<var_name>please_select_a_category</var_name>
			<added>1323164314</added>
			<value>Please select a category.</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.0.0</version_id>
			<var_name>account</var_name>
			<added>1323185644</added>
			<value>Account</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.0.0</version_id>
			<var_name>full_name_liked_a_comment_you_made_on_the_page_title</var_name>
			<added>1323186791</added>
			<value><![CDATA[{full_name} liked a comment you made on the page "{title}"]]></value> 
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.0.0</version_id>
			<var_name>full_name_liked_a_comment_you_made_on_the_page_title_to_view_the_comment_thread_follow_the_link_below_a_href_link_link_a</var_name>
			<added>1323186876</added>
			<value><![CDATA[{full_name} liked a comment you made on the page "{title}".
To view the comment thread follow the link below:
<a href="{link}">{link}</a>]]></value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.0.0</version_id>
			<var_name>full_name_is_requesting_to_join_your_page_title</var_name>
			<added>1323329529</added>
			<value><![CDATA[{full_name} is requesting to join your page "{title}".]]></value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.0.0</version_id>
			<var_name>users_pages_groups_count</var_name>
			<added>1323430955</added>
			<value>Users Pages/Groups Count</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.0.0beta3</version_id>
			<var_name>successfully_registered_for_this_page</var_name>
			<added>1316530667</added>
			<value>Successfully registered for this page. Your membership is pending an admins approval. As soon as your membership has been approved you will be notified.</value>
		</phrase>
	</phpfox_update_phrases>
	<hooks>
		<hook>
			<module_id>pages</module_id>
			<hook_type>service</hook_type>
			<module>pages</module>
			<call_name>pages.service_process_add_1</call_name>
			<added>1323345487</added>
			<version_id>3.0.0</version_id>
			<value />
		</hook>
	</hooks>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>error.display</m_connection>
			<module_id>pages</module_id>
			<component>photo</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Pages Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
</upgrade>