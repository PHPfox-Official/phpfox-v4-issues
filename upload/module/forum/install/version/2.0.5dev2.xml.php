<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>forum</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>forum_database_tracking</var_name>
			<phrase_var_name>setting_forum_database_tracking</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.5dev2</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>user_setting_approve_forum_thread</var_name>
			<added>1274844636</added>
			<value>Approve threads before they are displayed publicly?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>user_setting_can_approve_forum_thread</var_name>
			<added>1274845237</added>
			<value>Can approve forum threads?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>thread_is_pending_approval</var_name>
			<added>1274845561</added>
			<value>Thread is pending approval.</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>approve_thread</var_name>
			<added>1274845632</added>
			<value>Approve Thread</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>thread_approved_on_site_title</var_name>
			<added>1274927037</added>
			<value>Thread Approved on {site_title}</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>your_thread_title_on_site_title_has_been_approved</var_name>
			<added>1274927265</added>
			<value><![CDATA[Your thread "{thread_title}" on {site_title} has been approved. To view your thread follow the link below:
<a href="{link}">{link}</a>]]></value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>forum_threads</var_name>
			<added>1274927850</added>
			<value>Forum Threads</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>can_approve_threads</var_name>
			<added>1274931426</added>
			<value>Can approve threads?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>can_approve_posts</var_name>
			<added>1274931944</added>
			<value>Can approve posts?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>user_setting_approve_forum_post</var_name>
			<added>1274932013</added>
			<value>Approve forum posts before they are displayed publicly?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>your_post_has_successfully_been_added_however_it_is_pending_an_admins_approval_before_it_can_be_displayed_publicly</var_name>
			<added>1274932351</added>
			<value>Your post has successfully been added, however it is pending an Admins approval before it can be displayed publicly.</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>approve_this_forum_post</var_name>
			<added>1274932988</added>
			<value>Approve this forum post.</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>user_setting_can_approve_forum_post</var_name>
			<added>1274933104</added>
			<value>Can approve forum posts?</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>forum_post_approved_on_site_title</var_name>
			<added>1274933764</added>
			<value>Forum Post Approved on {site_title}</value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>your_post_that_is_part_of_the_forum_thread_title_on_site_title</var_name>
			<added>1274933802</added>
			<value><![CDATA[Your post that is part of the forum thread "{thread_title}" on {site_title} has been approved. To view your post follow the link below: 
<a href="{link}">{link}</a>]]></value>
		</phrase>
		<phrase>
			<module_id>forum</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>setting_forum_database_tracking</var_name>
			<added>1275199323</added>
			<value><![CDATA[<title>Database Tracking</title><info>If this option is enabled it will track users by storing the threads they have viewed in the database. As opposed to storing recent threads in cookies and basing if a user has viewed a thread or not on several time stamps. With this feature enabled it is much more accurate, however it requires extra server resources and on large forums it is best to disable this feature.</info>]]></value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>approve_forum_thread</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>can_approve_forum_thread</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>0</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>0</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>approve_forum_post</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>forum</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>forum</module>
			<ordering>0</ordering>
			<value>can_approve_forum_post</value>
		</setting>
	</user_group_settings>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:2:{s:17:"phpfox_forum_post";a:2:{s:11:"thread_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"thread_id";i:1;s:7:"view_id";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}}s:19:"phpfox_forum_thread";a:2:{s:10:"group_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"group_id";i:1;s:9:"title_url";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}}}}]]></sql>
	<update_templates>
		<file type="controller">thread.html.php</file>
		<file type="controller">post.html.php</file>
		<file type="block">thread-entry.html.php</file>
		<file type="block">post.html.php</file>
	</update_templates>
</upgrade>