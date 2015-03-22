<upgrade>
	<phrases>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>user_setting_approve_groups</var_name>
			<added>1274941412</added>
			<value>Approve groups before they are publicly displayed?</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>this_group_is_pending_an_admins_approval</var_name>
			<added>1274941602</added>
			<value>This group is pending an Admins approval.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>user_setting_can_approve_groups</var_name>
			<added>1274943313</added>
			<value>Can approve pending groups?</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>this_group_is_still_pending_an_admins_approval_and_this_feature_cannot_be_used_yet</var_name>
			<added>1274943488</added>
			<value>This group is still pending an Admins approval and this feature cannot be used yet.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>approve</var_name>
			<added>1274944601</added>
			<value>Approve</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>group_approved_on_site_title</var_name>
			<added>1274945364</added>
			<value>Group Approved on {site_title}</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>your_group_group_title_on_site_title</var_name>
			<added>1274945423</added>
			<value><![CDATA[Your group "{group_title}" on {site_title} has been approved. To view your group visit the link below:
<a href="{link}">{link}</a>]]></value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>this_group_is_still_pending_an_admins_approval</var_name>
			<added>1274945709</added>
			<value>This group is still pending an Admins approval. Once it has been approved you will be able to invite people to join your group.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>approve_group</var_name>
			<added>1274946040</added>
			<value>Approve Group</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>group_successfully_approved</var_name>
			<added>1274946152</added>
			<value>Group successfully approved.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>user_setting_flood_control_groups</var_name>
			<added>1275106749</added>
			<value><![CDATA[How many minutes should a user wait before they can create another group?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>you_are_creating_another_group_a_little_too_soon</var_name>
			<added>1275106853</added>
			<value>You are creating another group a little too soon.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>group</module_id>
			<type>boolean</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>group</module>
			<ordering>0</ordering>
			<value>approve_groups</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>group</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>group</module>
			<ordering>0</ordering>
			<value>can_approve_groups</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>group</module_id>
			<type>integer</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>group</module>
			<ordering>0</ordering>
			<value>flood_control_groups</value>
		</setting>
	</user_group_settings>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_group";a:1:{s:9:"is_public";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:12:"phpfox_group";a:3:{s:11:"is_public_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_public";i:1;s:7:"view_id";}}s:9:"is_public";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_public";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}}]]></sql>
	<update_templates>
		<file type="controller">add.html.php</file>
		<file type="controller">view.html.php</file>
		<file type="controller">index.html.php</file>
	</update_templates>
</upgrade>