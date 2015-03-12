<module>
	<data>
		<module_id>forum</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:23:"forum.admin_menu_manage";a:1:{s:3:"url";a:1:{i:0;s:5:"forum";}}s:20:"forum.admin_menu_add";a:1:{s:3:"url";a:2:{i:0;s:5:"forum";i:1;s:3:"add";}}}]]></menu>
		<phrase_var_name>module_forum</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="forum" parent_var_name="" m_connection="main" var_name="menu_forum" ordering="23" url_value="forum" version_id="2.0.0alpha1" disallow_access="" module="forum" />
		<menu module_id="forum" parent_var_name="" m_connection="mobile" var_name="menu_forum_forum_532c28d5412dd75bf975fb951c740a30" ordering="117" url_value="forum" version_id="3.1.0rc1" disallow_access="" module="forum" mobile_icon="small_forum.png" />
	</menus>
	<settings>
		<setting group="" module_id="forum" is_hidden="0" type="integer" var_name="keep_active_posts" phrase_var_name="setting_keep_active_posts" ordering="1" version_id="2.0.0alpha1">60</setting>
		<setting group="time_stamps" module_id="forum" is_hidden="0" type="string" var_name="forum_time_stamp" phrase_var_name="setting_forum_time_stamp" ordering="1" version_id="2.0.0alpha1">M j, g:i a</setting>
		<setting group="time_stamps" module_id="forum" is_hidden="0" type="string" var_name="forum_user_time_stamp" phrase_var_name="setting_forum_user_time_stamp" ordering="2" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="" module_id="forum" is_hidden="0" type="integer" var_name="total_posts_per_thread" phrase_var_name="setting_total_posts_per_thread" ordering="1" version_id="2.0.0alpha1">15</setting>
		<setting group="" module_id="forum" is_hidden="0" type="integer" var_name="total_forum_tags_display" phrase_var_name="setting_total_forum_tags_display" ordering="1" version_id="2.0.0alpha1">100</setting>
		<setting group="" module_id="forum" is_hidden="0" type="integer" var_name="total_forum_post_preview" phrase_var_name="setting_total_forum_post_preview" ordering="1" version_id="2.0.0alpha1">10</setting>
		<setting group="" module_id="forum" is_hidden="0" type="boolean" var_name="rss_feed_on_each_forum" phrase_var_name="setting_rss_feed_on_each_forum" ordering="1" version_id="2.0.0beta5">1</setting>
		<setting group="" module_id="forum" is_hidden="0" type="boolean" var_name="enable_rss_on_threads" phrase_var_name="setting_enable_rss_on_threads" ordering="1" version_id="2.0.0beta5">1</setting>
		<setting group="time_stamps" module_id="forum" is_hidden="0" type="string" var_name="global_forum_timezone" phrase_var_name="setting_global_forum_timezone" ordering="3" version_id="2.0.5">g:i a</setting>
		<setting group="" module_id="forum" is_hidden="0" type="boolean" var_name="forum_database_tracking" phrase_var_name="setting_forum_database_tracking" ordering="1" version_id="2.0.5dev2">1</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="forum" module_id="forum" component="timezone" location="4" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="group.view" module_id="forum" component="parent" location="1" is_active="1" ordering="2" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="forum.index" module_id="forum" component="stat" location="1" is_active="1" ordering="7" disallow_access="" can_move="0">
			<title>Forum Stats</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_search_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_admincp_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_admincp_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_tag_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_forum_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_post_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_thread_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_block_admincp_moderator_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_block_move_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_block_timezone_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_block_merge_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_block_copy_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_block_jump_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_moderate_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_moderate_moderate__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_post_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_post_post__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_thread_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_thread_thread__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_forum__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_block_parent_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_read_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_action_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_group_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_rss_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_subscribe_process__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_subscribe_subscribe__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_process_add__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_thread_process_add__start" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_thread_process_add__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_thread_process_sponsor__end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_ajax_get_text" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="forum" hook_type="template" module="forum" call_name="forum.template_controller_thread_form_quick_reply" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_moderate_moderate_getperms" added="1276177474" version_id="2.0.5" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_forum_getaccess" added="1286546859" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_forum_hasaccess" added="1286546859" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_thread_get_query" added="1286546859" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_thread_getthread_query" added="1286546859" version_id="2.0.7" />
		<hook module_id="forum" hook_type="controller" module="forum" call_name="forum.component_controller_admincp_permission_clean" added="1286546859" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_callback_updatecounterlist" added="1288281378" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_post_getpost" added="1288281378" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_post_process_thank" added="1288281378" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_post_process_deletethanks" added="1288281378" version_id="2.0.7" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_forum_hasaccess_check" added="1290072896" version_id="2.0.7" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_ajax_reply" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="forum" hook_type="component" module="forum" call_name="forum.component_block_stat_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="forum" hook_type="template" module="forum" call_name="forum.template_controller_post_ajax_onsubmit" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="forum" hook_type="template" module="forum" call_name="forum.template_block_post_1" added="1323345637" version_id="3.0.0" />
		<hook module_id="forum" hook_type="template" module="forum" call_name="forum.template_block_post_2" added="1323345637" version_id="3.0.0" />
		<hook module_id="forum" hook_type="template" module="forum" call_name="forum.template_controller_post_1" added="1323345637" version_id="3.0.0" />
		<hook module_id="forum" hook_type="template" module="forum" call_name="forum.template_controller_post_2" added="1323345637" version_id="3.0.0" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_post_process_add_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_post_process_approve__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_process_approve__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_process_delete__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_process_close__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="forum" hook_type="service" module="forum" call_name="forum.service_thread_process_approve__1" added="1335951260" version_id="3.2.0" />
	</hooks>
	<components>
		<component module_id="forum" component="timezone" m_connection="" module="forum" is_controller="0" is_block="1" is_active="1" />
		<component module_id="forum" component="forum.index" m_connection="forum.index" module="forum" is_controller="1" is_block="0" is_active="1" />
		<component module_id="forum" component="parent" m_connection="" module="forum" is_controller="0" is_block="1" is_active="1" />
		<component module_id="forum" component="stat" m_connection="" module="forum" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="module_forum" added="1232964154">Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="menu_forum" added="1232964179">Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="setting_forum_time_stamp" added="1236199398"><![CDATA[<title>Forum Time Stamp</title><info>Form Time Stamp</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="setting_forum_user_time_stamp" added="1236243410"><![CDATA[<title>Forum User Time Stamp</title><info>Forum User Time Stamp</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="admin_menu_manage" added="1236250722">Manage</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="admin_menu_add" added="1236252198">Add</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_stick_thread" added="1236253463">Can stick a forum thread?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_close_a_thread" added="1236253526">Can close a thread?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_post_announcement" added="1236337152">Can post an announcement?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="setting_total_posts_per_thread" added="1236343387"><![CDATA[<title>Total Posts Per Thread</title><info>Total Posts Per Thread</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_delete_own_post" added="1236444561">Can delete their own post?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_delete_other_posts" added="1236445319">Can delete other posts?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_add_new_forum" added="1236620090">Can add a new public forum?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_edit_forum" added="1236620328">Can edit a public forum?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_manage_forum_moderators" added="1236620711"><![CDATA[Can manage forum moderators?

<b>Notice:</b> Includes adding, editing and deleting forum moderators.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_delete_forum" added="1236625977">Can delete a public forum?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_edit_own_post" added="1236672321">Can edit own forum post?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_edit_other_posts" added="1236673212">Can edit other forum posts?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_move_forum_thread" added="1236685973">Can move forum threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_copy_forum_thread" added="1236690483">Can copy forum threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_merge_forum_threads" added="1236712843">Can merge forum threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_multi_quote_forum" added="1236761340">Can use multi-quote feature?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_reply_to_own_thread" added="1236761601">Can reply to own thread?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_reply_on_other_threads" added="1236761963">Can reply on threads posted by other users?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_add_new_thread" added="1236762641">Can post a new thread?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_add_forum_attachments" added="1236793576">Can add attachments to posts?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_can_add_tags_on_threads" added="1236793957">Can add tags to threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="user_setting_enable_captcha_on_posting" added="1236798433">Enable Captcha protection when posting within the forums?</phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="setting_total_forum_tags_display" added="1237050147"><![CDATA[<title>Total Tag Display</title><info>Define how many tags should be displayed within the tag cloud for the forum.</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0alpha1" var_name="setting_total_forum_post_preview" added="1237052576"><![CDATA[<title>Total Forum Post Preview</title><info>Define how many posts can be previewed when adding a new reply to a thread.</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0alpha2" var_name="user_setting_forum_thread_flood_control" added="1237813942"><![CDATA[Define how many minutes this user group should wait before they can post a new thread.

<b>Note:</b> Set to <b>0</b> if there should be no limit.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0alpha2" var_name="user_setting_forum_post_flood_control" added="1237815116">Define how many minutes this user group should wait before they can post a new reply to a thread. 

Note: Set to 0 if there should be no limit.</phrase>
		<phrase module_id="forum" version_id="2.0.0beta5" var_name="rss_group_name_3" added="1245660594">Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0beta5" var_name="rss_title_4" added="1245660649">Latest Forum Topics</phrase>
		<phrase module_id="forum" version_id="2.0.0beta5" var_name="rss_description_4" added="1245660649">List of the latest topics from our public forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0beta5" var_name="setting_rss_feed_on_each_forum" added="1245668622"><![CDATA[<title>RSS Feed within Forums</title><info>Set to <b>True</b> to enable RSS feeds for each forum.</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0beta5" var_name="setting_enable_rss_on_threads" added="1245668866"><![CDATA[<title>RSS Feed on Threads</title><info>Set to <b>True</b> to enable RSS feeds on threads.</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc1" var_name="user_setting_points_forum" added="1250669265">Points received when adding a thread/post within the forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="only_members_can_add_a_reply_to_threads" added="1254468427">Only members can add a reply to threads.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_is_closed_for_posting" added="1254468445">Thread is closed for posting.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="insufficient_permission_to_reply_to_this_thread" added="1254468471">Insufficient permission to reply to this thread.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="posting_a_reply_a_little_too_soon" added="1254468482">Posting a reply a little too soon.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="select_moderators" added="1254468504">Select moderators.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="done" added="1254468514">Done!</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_permitted_to_move_threads" added="1254468558">Not permitted to move threads.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_successfully_moved" added="1254468573">Thread successfully moved.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="you_are_not_permitted_to_move_this_thread_to_this_specific_forum" added="1254468585">You are not permitted to move this thread to this specific forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="successfully_copied_the_thread" added="1254468606">Successfully copied the thread.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="you_are_not_permitted_to_copy_this_thread_to_this_specific_forum" added="1254468616">You are not permitted to copy this thread to this specific forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="unstick_thread" added="1254468635">Unstick Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="stick_thread" added="1254468651">Stick Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_successfully_unstuck" added="1254468662">Thread successfully unstuck.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_successfully_stuck" added="1254468672">Thread successfully stuck.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="open_thread" added="1254468683">Open Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_successfully_closed" added="1254468698">Thread successfully closed.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="close_thread" added="1254468707">Close Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_successfully_opened" added="1254468718">Thread successfully opened.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_allowed_to_merge_threads_from_this_specific_forum" added="1254468729">Not allowed to merge threads from this specific forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="threads_successfully_merged" added="1254468739">Threads successfully merged.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_thread_to_copy" added="1254468759">Not a valid thread to copy.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_thread_to_move" added="1254468774">Not a valid thread to move.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="recent_topics" added="1254468799">Recent Topics</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="provide_a_name_for_your_forum" added="1254469627">Provide a name for your forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_successfully_updated" added="1254469640">Forum successfully updated.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_successfully_added" added="1254469940">Forum successfully added.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="editing_forum" added="1254469951">Editing Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="create_new_form" added="1254469966">Create New Form</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_order_successfully_updated" added="1254469979">Forum order successfully updated.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_successfully_deleted" added="1254470108">Forum successfully deleted.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="manage_forums" added="1254470118">Manage Forums</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="successfully_unsubscribed_to_thread_s" added="1254470147">Successfully unsubscribed to thread(s).</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="successfully_subscribed_to_thread_s" added="1254470156">Successfully subscribed to thread(s).</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="no_results_found" added="1254470181">No results found.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_forum" added="1254470229">Not a valid forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum" added="1254470274">Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="tags" added="1254470336">Tags</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="threads_tagged_with" added="1254470344">Threads tagged with</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="search" added="1254470353">Search</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="new_posts" added="1254470365">New Posts</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="my_threads" added="1254470374">My Threads</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="subscriptions" added="1254470380">Subscriptions</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="group_forum" added="1254470431">Group Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_section_is_closed" added="1254470496">Forum section is closed.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_thread" added="1254470549">Not a valid thread.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="insufficient_permission_to_edit_this_thread" added="1254470574">Insufficient permission to edit this thread.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_is_closed" added="1254470594">Forum is closed.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="provide_a_title_for_your_thread" added="1254470614">Provide a title for your thread.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="provide_some_text" added="1254470621">Provide some text.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_successfully_updated" added="1254470634">Thread successfully updated.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="posting_a_new_thread_a_little_too_soon" added="1254470652">Posting a new thread a little too soon.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="editing_thread" added="1254470668">Editing Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="post_new_thread" added="1254470698">Post New Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_post" added="1254470728">Not a valid post.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_is_closed" added="1254470757">Thread is closed.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_is_an_announcement_not_allowed_to_leave_a_reply" added="1254470778">Thread is an announcement. Not allowed to leave a reply.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="editing_post" added="1254470824">Editing Post</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="post_new_reply" added="1254470834">Post New Reply</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_successfully_marked_as_read" added="1254470867">Forum successfully marked as read.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="rss_feeds_are_disabled_for_threads" added="1254470892">RSS feeds are disabled for threads.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_group" added="1254470972">Not a valid group.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="latest_threads_in_group_forum" added="1254470981">Latest threads in group forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="latest_threads_on" added="1254470990">Latest threads on</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread" added="1254471062">Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_edit_posts" added="1254471109">Can edit posts?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_delete_posts" added="1254471127">Can delete posts?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_post_announcements" added="1254471135">Can post announcements?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_stick_threads" added="1254471142">Can stick threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_move_threads" added="1254471150">Can move threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_copy_threads" added="1254471158">Can copy threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_close_threads" added="1254471166">Can close threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_merge_threads" added="1254471174">Can merge threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_reply_to_threads" added="1254471182">Can reply to threads?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="can_post_a_new_thread" added="1254471190">Can post a new thread?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="latest_posts_in" added="1254471232">Latest posts in</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="latest_forum_posts_on" added="1254471242">Latest forum posts on</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="reply_to_thread_title" added="1254471299"><![CDATA[Reply to thread "{title}".]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="full_name_has_just_replied_to_the_thread_title" added="1254471362"><![CDATA[{full_name} has just replied to the thread "{title}".

To view this thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_forum_url_missing_forum_path" added="1254471499">Not a valid forum URL. Missing forum path.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_forum_url_missing_thread_id" added="1254471633">Not a valid forum URL. Missing thread ID.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_forum_url_thread_is_not_valid" added="1254471643">Not a valid forum URL. Thread is not valid.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="not_a_valid_forum_url_merging_thread_is_not_valid" added="1254471652">Not a valid forum URL. Merging thread is not valid.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="you_cannot_merge_the_same_thread" added="1254471660">You cannot merge the same thread.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="you_cannot_merge_this_thread_as_it_belongs_to_another_group_forum" added="1254471672">You cannot merge this thread as it belongs to another group/forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="select_a_forum_this_announcement_will_belong_to" added="1254471695">Select a forum this announcement will belong to.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="owner_full_name_added_a_new_thread" added="1254471772"><![CDATA[<a href="{user_link}">{owner_full_name}</a> added a new thread "<a href="{title_link}">{title}</a>"]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="view_forum" added="1254471886">View Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_posts" added="1254471899">Forum Posts</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="full_name_replied_to_the_thread_title" added="1254471921"><![CDATA[<a href="{user_link}">{full_name}</a> replied to the thread "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_subscriptions" added="1254471948">Forum Subscriptions</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_post_text" added="1254471964">Forum Post Text</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="post_time" added="1254471989">Post Time</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="author" added="1254471996">Author</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="replies" added="1254472003">Replies</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="subject" added="1254472009">Subject</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="views" added="1254472015">Views</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_day" added="1254472027">Last Day</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_2_days" added="1254472034">Last 2 Days</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_week" added="1254472042">Last Week</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_10_days" added="1254472051">Last 10 Days</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_2_weeks" added="1254472064">Last 2 Weeks</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_month" added="1254472074">Last Month</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_45_days" added="1254472082">Last 45 Days</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_2_months" added="1254472090">Last 2 Months</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_75_days" added="1254472098">Last 75 Days</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_100_days" added="1254472106">Last 100 Days</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_year" added="1254472114">Last Year</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="beginning" added="1254472120">Beginning</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="latest_threads_in" added="1254473423">Latest threads in</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="are_you_sure_notice_this_will_delete_all_child_forums_and_any_threads_posts_announcements" added="1254473652">Are you sure?

Notice! This will delete all child forums and any threads, posts, announcements that belong to those forums.

This cannot be undone.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="global_moderator_permissions" added="1254473995">Global Moderator Permissions</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="moderator_permissions" added="1254474019">Moderator Permissions</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="cancel" added="1254474037">cancel</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="provide_a_reply" added="1254474073">Provide a reply.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="adding_your_reply" added="1254474097">Adding your reply</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="are_you_sure" added="1254474168">Are you sure?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="post_successfully_deleted" added="1254474188">Post successfully deleted.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="post_and_thread_successfully_deleted" added="1254474198">Post and thread successfully deleted.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_successfully_deleted" added="1254474227">Thread successfully deleted.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="manage_moderators" added="1254475005">Manage Moderators</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="moderators" added="1254475017">Moderators</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forums" added="1254475069">Forums</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="yes" added="1254475096">Yes</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="no" added="1254475104">No</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="save" added="1254475111">Save</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="new_title" added="1254475136">New Title</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="copying" added="1254475143">Copying</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="destination_forum" added="1254475152">Destination Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="copy_thread" added="1254475161">Copy Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="sub_forum" added="1254475173">Sub-Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="threads" added="1254475188">Threads</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="posts" added="1254475194">Posts</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_post" added="1254475201">Last Post</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_is_closed_for_posting" added="1254475291">Forum is Closed for Posting</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_contains_no_new_posts" added="1254475300">Forum Contains No New Posts</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_contains_new_posts" added="1254475308">Forum Contains New Posts</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="moderated_by" added="1254475319">Moderated by</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="by_user_link_on_time_stamp_phrase" added="1254475903"><![CDATA[by {user_link}<br />
on <a href="{link}">{time_stamp_phrase}</a>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="sub_forums" added="1254476793">Sub-Forums</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="url" added="1254476819">URL</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="merge_threads" added="1254476837">Merge Threads</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="move_thread" added="1254476856">Move Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="moving" added="1254476863">Moving</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="no_forum_threads" added="1254476877">No forum threads.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="posted_by_user_link_on_time_stamp_phrase" added="1254477002">Posted by {user_link} on {time_stamp_phrase}</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="location" added="1254477436">Location</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="registered" added="1254477443">Registered</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="topic" added="1254483138">Topic</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="title_posted_in_forum_name" added="1254483515"><![CDATA[<a href="{link}">{title}</a> posted in <a href="{forum_link}">{forum_name}</a>.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="last_update_on_time_stamp_by_update_user" added="1254484623">Last update on {time_stamp} by {update_user}.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="edit_this_post" added="1254488093">Edit this post.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="delete_this_post" added="1254488104">Delete this post.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="report_a_post" added="1254488115">Report a Post</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="quote_full_name_s_reply" added="1254488162"><![CDATA[Quote {full_name}'s reply.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="multi_quote_this_message" added="1254488187">Multi-Quote this message.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="no_new_posts" added="1254488245">No new posts</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="sticky" added="1254488281">Sticky</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="by_user_link_on_time_stamp_phrase_no_break" added="1254488777">by {user_link} on {time_stamp_phrase}</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="by_user_link_on_time_stamp_phrase_in_forum_name" added="1254488906"><![CDATA[by {user_link} on {time_stamp_phrase} in <a href="{forum_link}">{forum_name}</a>]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="by_user_link" added="1254489110">by {user_link}</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="all_times_are_gmt_time_zone_the_time_now_is_current_time" added="1254489167">All times are GMT{time_zone}. The time now is {current_time}.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_details" added="1254489232">Forum Details</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="name" added="1254489239">Name</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="parent_forum" added="1254489248">Parent Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="select" added="1254489255">Select</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="is_a_category" added="1254489263">Is a Category</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="closed" added="1254489288">Closed</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="description" added="1254489295">Description</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="cancel_uppercase" added="1254489314">Cancel</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="no_forums_created_yet" added="1254489326">No forums created yet.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="create_a_new_forum" added="1254489332">Create a New Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="edit_forum" added="1254489340">Edit Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="add_child_forum" added="1254489354">Add Child Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="delete_forum" added="1254489366">Delete Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="update_order" added="1254489384">Update Order</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="subscribe_to_this_forum" added="1254489400">Subscribe to this forum.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="new_thread" added="1254489412">New Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="forum_tools" added="1254489424">Forum Tools</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="mark_this_forum_read" added="1254489432">Mark This Forum Read</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="search_this_forum" added="1254490421">Search This Forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="show_threads" added="1254490433">Show Threads</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="show_posts" added="1254490440">Show Posts</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="advanced_search" added="1254490449">Advanced Search</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="announcements" added="1254490459">Announcements</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="with_selected" added="1254490511"><![CDATA[With Selected (<span id="js_selector_count"></span>)]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="subscribe" added="1254490550">Subscribe</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="unsubscribe" added="1254490555">Unsubscribe</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="submit" added="1254490563">Submit</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="display" added="1254490598">Display</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="from" added="1254490603">From</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="sort" added="1254490610">Sort</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="by" added="1254490617">By</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="nothing_found" added="1254490654">Nothing found.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="no_threads_were_posted_yet" added="1254490661">No threads were posted yet.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="be_the_first_to_post_a_thread" added="1254490669">Be the First to Post a Thread.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="quick_links" added="1254490698">Quick Links</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="mark_forums_read" added="1254490706">Mark Forums Read</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="subscribed_threads" added="1254490727">Subscribed Threads</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="go" added="1254490745">Go</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="no_forums_have_been_created" added="1254490780">No forums have been created.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="statistics" added="1254490793">Statistics</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="message" added="1254490873">Message</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="type" added="1254490977">Type</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="announcement" added="1254491325">Announcement</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="select_a_parent_forum" added="1254491338">Select a parent forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="announcement_will_be_included_in_child_forums" added="1254491346">Announcement will be included in child forums.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="topic_preview_newest_first" added="1254491410">Topic Preview (Newest First)</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="this_thread_has_more_than_total_setting_replies" added="1254491468"><![CDATA[This thread has more than {total_setting} replies. Click <a href="{link}">here</a> to review the whole thread.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="search_for_keyword_s" added="1254491593">Search for keyword(s)</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="search_for_author" added="1254491602">Search for author</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="find_in_forum" added="1254491611">Find in forum</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="display_results_as" added="1254491702">Display results as</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="subscribe_to_this_thread" added="1254491724">Subscribe to this thread.</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="new_reply" added="1254491761">New Reply</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="thread_tools" added="1254491770">Thread Tools</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="edit_thread" added="1254491960">Edit Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="delete_thread" added="1254491992">Delete Thread</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="quick_reply" added="1254492097">Quick Reply</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="reply" added="1254492142">Reply</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="post_quick_reply" added="1254492172">Post Quick Reply</phrase>
		<phrase module_id="forum" version_id="2.0.0rc3" var_name="go_advanced" added="1254492181">Go Advanced</phrase>
		<phrase module_id="forum" version_id="2.0.0rc4" var_name="full_name_replied_to_the_thread_title_with_link" added="1256558977"><![CDATA[<a href="{user_link}">{full_name}</a> replied to the thread "<a href="{thread_link}">{title}</a>".]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc8" var_name="display_options" added="1258414774">Display Options</phrase>
		<phrase module_id="forum" version_id="2.0.0rc8" var_name="additional_options" added="1258414801">Additional Options</phrase>
		<phrase module_id="forum" version_id="2.0.0rc8" var_name="title" added="1258986945">Title</phrase>
		<phrase module_id="forum" version_id="2.0.0rc11" var_name="user_setting_can_view_forum" added="1260276741">Can browse and view the forum module?</phrase>
		<phrase module_id="forum" version_id="2.0.0rc11" var_name="forum_thread_post_count" added="1260291719">Forum Thread/Post Count</phrase>
		<phrase module_id="forum" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_forum_a_href_link_thread_a" added="1260463116"><![CDATA[<a href="{user_link}">{full_name}</a> likes your forum <a href="{link}">thread</a>.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_forum_a_href_link_thread_a" added="1260463354"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own forum <a href="{link}">thread</a>.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_forum_a_href_link_thread_a" added="1260463404"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s forum <a href="{link}">thread</a>.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_forum_a_href_link_post_a" added="1260463695"><![CDATA[<a href="{user_link}">{full_name}</a> likes your forum <a href="{link}">post</a>.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_forum_a_href_link_reply_a" added="1260464244"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own forum <a href="{link}">reply</a>.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_forum_a_href_link_reply_a" added="1260464262"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s forum <a href="{link}">reply</a>.]]></phrase>
		<phrase module_id="forum" version_id="2.0.0" var_name="viewing_single_post" added="1261175625">Viewing Single Post</phrase>
		<phrase module_id="forum" version_id="2.0.0" var_name="forum_user_post_count" added="1261399133">Forum User Post Count</phrase>
		<phrase module_id="forum" version_id="2.0.2" var_name="update_forum_last_post" added="1263378519">Update Forum Last Post</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="user_setting_can_sponsor_thread" added="1269951006">Can members of this user group mark a thread as sponsored?</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="sponsor" added="1269951526">Sponsor</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="you_are_not_allowed_to_mark_threads_as_sponsor" added="1269952247">You are not allowed to mark threads as sponsor.</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="user_setting_can_purchase_sponsor" added="1271152478">Can members of this user group purchase a sponsored ad space?</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="unsponsor" added="1271159396">Unsponsor</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="thread_successfully_sponsored" added="1271161358">Thread Successfully Sponsored</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="thread_successfully_unsponsored" added="1271161410">Thread Successfully Unsponsored</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="user_setting_forum_thread_sponsor_price" added="1271847763">How much is the sponsor space worth for forum threads?
This works in a CPM basis.</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="sponsor_error_not_found" added="1272005806">That thread is no longer available</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="sponsor_title" added="1272005846">Forum thread: {sThreadTitle}</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="sponsor_paypal_message" added="1272005907">Sponsor of forum thread: {sThreadTitle}</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="user_setting_auto_publish_sponsored_item" added="1272006656">After the user has purchased a sponsored space, should the thread be published right away?
If set to false, the admin will have to approve each new purchased sponsored thread space before it is shown in the site.</phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="setting_global_forum_timezone" added="1273245857"><![CDATA[<title>Forum Global Time Stamp</title><info>This is the time stamp that is displayed at the bottom of the forum.</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="user_setting_approve_forum_thread" added="1274844636">Approve threads before they are displayed publicly?</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="user_setting_can_approve_forum_thread" added="1274845237">Can approve forum threads?</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="thread_is_pending_approval" added="1274845561">Thread is pending approval.</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="approve_thread" added="1274845632">Approve Thread</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="thread_approved_on_site_title" added="1274927037">Thread Approved on {site_title}</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="your_thread_title_on_site_title_has_been_approved" added="1274927265"><![CDATA[Your thread "{thread_title}" on {site_title} has been approved. To view your thread follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="forum_threads" added="1274927850">Forum Threads</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="can_approve_threads" added="1274931426">Can approve threads?</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="can_approve_posts" added="1274931944">Can approve posts?</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="user_setting_approve_forum_post" added="1274932013">Approve forum posts before they are displayed publicly?</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="your_post_has_successfully_been_added_however_it_is_pending_an_admins_approval_before_it_can_be_displayed_publicly" added="1274932351">Your post has successfully been added, however it is pending an Admins approval before it can be displayed publicly.</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="approve_this_forum_post" added="1274932988">Approve this forum post.</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="user_setting_can_approve_forum_post" added="1274933104">Can approve forum posts?</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="forum_post_approved_on_site_title" added="1274933764">Forum Post Approved on {site_title}</phrase>
		<phrase module_id="forum" version_id="2.0.5dev1" var_name="your_post_that_is_part_of_the_forum_thread_title_on_site_title" added="1274933802"><![CDATA[Your post that is part of the forum thread "{thread_title}" on {site_title} has been approved. To view your post follow the link below: 
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="forum" version_id="2.0.5dev2" var_name="setting_forum_database_tracking" added="1275199323"><![CDATA[<title>Database Tracking</title><info>If this option is enabled it will track users by storing the threads they have viewed in the database. As opposed to storing recent threads in cookies and basing if a user has viewed a thread or not on several time stamps. With this feature enabled it is much more accurate, however it requires extra server resources and on large forums it is best to disable this feature.</info>]]></phrase>
		<phrase module_id="forum" version_id="2.0.5" var_name="user_setting_auto_publish_sponsored_thread" added="1276177393">After the user has purchased a sponsored space, should the thread be published right away?
If set to false, the admin will have to approve each new purchased sponsored thread before it is shown in the site.</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="you_have_already_given_your_thanks_for_this_post" added="1279572411">You have already given your thanks for this post.</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="give_your_thanks" added="1279572441">Give your Thanks!</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="user_setting_can_thank_on_forum_posts" added="1279572555"><![CDATA[Can give "thanks" on forum posts?]]></phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="user_setting_can_delete_thanks_by_other_users" added="1279572813"><![CDATA[Can delete "thanks" added by other users?]]></phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="remove_this_thank_you" added="1279572846">Remove this Thank You!</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="the_thank_you_you_are_trying_to_delete_cannot_be_found" added="1279572992"><![CDATA[The "Thank You" you are trying to delete cannot be found.]]></phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="you_do_not_have_the_proper_permissions_to_delete_this_thank_you" added="1279573082"><![CDATA[You do not have the proper permissions to delete this "Thank You".]]></phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="manage_permissions" added="1279586520">Manage Permissions</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="user_setting_can_manage_forum_permissions" added="1279586614">Can manage forum permissions?</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="you_do_not_have_the_proper_permission_to_view_this_thread" added="1279591975">You do not have the proper permission to view this thread.</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="user_groups" added="1279623580">User Groups</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="user_group" added="1279623593">User Group</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="select_a_user_group_to_assign_special_permissions_for_this_specific_forum" added="1279623621">Select a user group to assign special permissions for this specific forum.</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="forum_permissions" added="1279623634">Forum Permissions</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="reset" added="1279623651">Reset</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="can_view_forum" added="1279623667">Can view forum?</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="can_view_thread_content" added="1279623677">Can view thread content?</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="poll_results" added="1279631067">Poll Results</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="poll" added="1279631163">Poll</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="attach_poll" added="1279631173">Attach Poll</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="delete" added="1279631622">Delete</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="click_to_delete_this_poll" added="1279631634">Click to delete this poll.</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="user_setting_can_add_poll_to_forum_thread" added="1279633816">Can attach polls to forum threads?</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="the_following_users_say_thank_you" added="1279634192">The following users say Thank You to {full_name} for this useful post</phrase>
		<phrase module_id="forum" version_id="2.0.6" var_name="search_options" added="1285076440">Search Options</phrase>
		<phrase module_id="forum" version_id="2.1.0beta2" var_name="reply_multi_quoting" added="1301326373">Reply Multi-Quoting</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="post_a_reply" added="1319122298">Post a Reply</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="add_some_text" added="1319184214">Add some text.</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="forum_statistics" added="1319196350">Forum Statistics</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="pending_threads" added="1319196459">Pending Threads</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="pending_posts" added="1319196469">Pending Posts</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="by_full_name_on_time" added="1319196519">by {full_name} on {time}</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="moderate" added="1319196594">Moderate</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="this_thread_contains_a_poll" added="1319196606">This thread contains a poll.</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="posted_in" added="1319196738">Posted in</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="via" added="1319196764">via</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="report" added="1319196775">Report</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="edit" added="1319196802">Edit</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="forum_tags" added="1319196940">Forum Tags</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="no_threads_found" added="1319197142">No threads found.</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="full_name_liked_one_of_your_forum_posts" added="1319536342">{full_name} liked one of your forum posts</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="full_name_liked_your_one_of_your_forum_posts_in" added="1319536407"><![CDATA[{full_name} liked your one of your forum posts in the thread "<a href="{link}">{title}</a>"
To view this post follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="users_liked_gender_own_forum_post_in_the_thread_title" added="1319552874"><![CDATA[{users} liked {gender} own forum post in the thread "{title}"]]></phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="users_liked_your_forum_post_in_the_thread_title" added="1319552915"><![CDATA[{users} liked your forum post in the thread "{title}"]]></phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_row_full_name_s_span_forum_post_in_the_thread_title" added="1319552955"><![CDATA[{users} liked <span class="drop_data_user">{row_full_name}'s</span> forum post in the thread "{title}"]]></phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="users_replied_to_the_thread_title" added="1319553063"><![CDATA[{users} replied to the thread "{title}"]]></phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="post_a_new_thread" added="1319553110">Post a New Thread</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="who_can_start_a_discussion" added="1319553123">Who can start a discussion?</phrase>
		<phrase module_id="forum" version_id="3.0.0beta5" var_name="who_can_view_browse_discussions" added="1319553133">Who can view/browse discussions?</phrase>
		<phrase module_id="forum" version_id="3.0.0rc1" var_name="view_additional_options" added="1320326265">View Additional Options</phrase>
		<phrase module_id="forum" version_id="3.0.0rc1" var_name="update" added="1320326274">Update</phrase>
		<phrase module_id="forum" version_id="3.0.0rc1" var_name="view_thread" added="1320326350">View Thread</phrase>
		<phrase module_id="forum" version_id="3.0.0rc1" var_name="pages" added="1320414326">Pages</phrase>
		<phrase module_id="forum" version_id="3.0.0rc1" var_name="discussions" added="1320414336">Discussions</phrase>
		<phrase module_id="forum" version_id="3.0.0rc1" var_name="unable_to_view_this_item_due_to_privacy_settings" added="1320414345">Unable to view this item due to privacy settings.</phrase>
		<phrase module_id="forum" version_id="3.0.0rc2" var_name="approve" added="1321360256">Approve</phrase>
		<phrase module_id="forum" version_id="3.0.0" var_name="thread_s_successfully_approved" added="1322739519">Thread(s) successfully approved.</phrase>
		<phrase module_id="forum" version_id="3.0.0" var_name="thread_s_successfully_deleted" added="1322739531">Thread(s) successfully deleted.</phrase>
		<phrase module_id="forum" version_id="3.0.0" var_name="post_s_successfully_approved" added="1322739549">Post(s) successfully approved.</phrase>
		<phrase module_id="forum" version_id="3.0.0" var_name="post_s_successfully_deleted" added="1322739561">Post(s) successfully deleted.</phrase>
		<phrase module_id="forum" version_id="3.0.0" var_name="report_this_post" added="1323085478">Report this post</phrase>
		<phrase module_id="forum" version_id="3.0.0" var_name="thread_contains_new_posts" added="1323085808">Thread contains new posts.</phrase>
		<phrase module_id="forum" version_id="3.0.0" var_name="replying_to_a_post_by_full_name" added="1323158668">Replying to a post by {full_name}</phrase>
		<phrase module_id="forum" version_id="3.1.0rc1" var_name="menu_forum_forum_532c28d5412dd75bf975fb951c740a30" added="1332257760">Forum</phrase>
		<phrase module_id="forum" version_id="3.3.0beta2" var_name="your_thread_has_been_approved" added="1341323681"><![CDATA[Your thread "{thread_title}" has been approved.]]></phrase>
		<phrase module_id="forum" version_id="3.5.0beta1" var_name="item_phrase" added="1352730619">forum post</phrase>
		<phrase module_id="forum" version_id="3.5.0rc1" var_name="log_in_to_view_thread" added="1359965595">Please log in to view this thread.</phrase>
	</phrases>
	<rss_group>
		<group module_id="forum" group_id="3" name_var="forum.rss_group_name_3" is_active="1" />
	</rss_group>
	<rss>
		<feed module_id="forum" group_id="3" title_var="forum.rss_title_4" description_var="forum.rss_description_4" feed_link="forum" is_active="1" is_site_wide="1">
			<php_group_code></php_group_code>
			<php_view_code><![CDATA[$aRows = Phpfox::getService('forum.thread')->getForRss(Phpfox::getParam('rss.total_rss_display'));]]></php_view_code>
		</feed>
	</rss>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_stick_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_close_a_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_post_announcement</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_delete_own_post</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_delete_other_posts</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_add_new_forum</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_edit_forum</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_manage_forum_moderators</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="0" module="forum" ordering="0">can_delete_forum</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_edit_own_post</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_edit_other_posts</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_move_forum_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_copy_forum_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_merge_forum_threads</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_multi_quote_forum</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_reply_to_own_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_reply_on_other_threads</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_add_new_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_add_forum_attachments</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_add_tags_on_threads</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="0" user="0" guest="1" staff="0" module="forum" ordering="0">enable_captcha_on_posting</setting>
		<setting is_admin_setting="0" module_id="forum" type="integer" admin="0" user="1" guest="50" staff="0" module="forum" ordering="0">forum_thread_flood_control</setting>
		<setting is_admin_setting="0" module_id="forum" type="integer" admin="0" user="1" guest="50" staff="0" module="forum" ordering="0">forum_post_flood_control</setting>
		<setting is_admin_setting="0" module_id="forum" type="integer" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">points_forum</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="1" staff="1" module="forum" ordering="0">can_view_forum</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="false" user="false" guest="false" staff="false" module="forum" ordering="0">can_sponsor_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="false" user="false" guest="false" staff="false" module="forum" ordering="0">can_purchase_sponsor</setting>
		<setting is_admin_setting="0" module_id="forum" type="string" admin="null" user="null" guest="null" staff="null" module="forum" ordering="0">forum_thread_sponsor_price</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="true" user="false" guest="false" staff="false" module="forum" ordering="0">auto_publish_sponsored_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="0" user="0" guest="0" staff="0" module="forum" ordering="0">approve_forum_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_approve_forum_thread</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="0" user="0" guest="0" staff="0" module="forum" ordering="0">approve_forum_post</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_approve_forum_post</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_thank_on_forum_posts</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_delete_thanks_by_other_users</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="0" guest="0" staff="1" module="forum" ordering="0">can_manage_forum_permissions</setting>
		<setting is_admin_setting="0" module_id="forum" type="boolean" admin="1" user="1" guest="0" staff="1" module="forum" ordering="0">can_add_poll_to_forum_thread</setting>
	</user_group_settings>
	<tables><![CDATA[a:12:{s:12:"phpfox_forum";a:3:{s:7:"COLUMNS";a:14:{s:8:"forum_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_category";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_closed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"post_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"last_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_post";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_thread";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"forum_id";s:4:"KEYS";a:3:{s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}s:7:"post_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"post_id";}s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"thread_id";}}}s:19:"phpfox_forum_access";a:2:{s:7:"COLUMNS";a:4:{s:8:"forum_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"user_group_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"var_value";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:8:"forum_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"forum_id";i:1;s:13:"user_group_id";}}s:13:"user_group_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:13:"user_group_id";i:1;s:8:"var_name";}}}}s:25:"phpfox_forum_announcement";a:3:{s:7:"COLUMNS";a:3:{s:15:"announcement_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"forum_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:15:"announcement_id";s:4:"KEYS";a:2:{s:8:"forum_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"forum_id";}s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"thread_id";}}}s:22:"phpfox_forum_moderator";a:3:{s:7:"COLUMNS";a:3:{s:12:"moderator_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"forum_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:12:"moderator_id";s:4:"KEYS";a:2:{s:8:"forum_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"forum_id";i:1;s:7:"user_id";}}s:10:"forum_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:8:"forum_id";}}}s:29:"phpfox_forum_moderator_access";a:2:{s:7:"COLUMNS";a:2:{s:12:"moderator_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:12:"moderator_id";a:2:{i:0;s:5:"INDEX";i:1;s:12:"moderator_id";}}}s:17:"phpfox_forum_post";a:3:{s:7:"COLUMNS";a:11:{s:7:"post_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:16:"total_attachment";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"update_time";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"update_user";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"post_id";s:4:"KEYS";a:4:{s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"thread_id";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:11:"thread_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"thread_id";i:1;s:7:"view_id";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}}}s:22:"phpfox_forum_post_text";a:2:{s:7:"COLUMNS";a:3:{s:7:"post_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"text_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"post_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"post_id";}}}s:22:"phpfox_forum_subscribe";a:3:{s:7:"COLUMNS";a:3:{s:12:"subscribe_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:12:"subscribe_id";s:4:"KEYS";a:2:{s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"thread_id";i:1;s:7:"user_id";}}s:11:"thread_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:9:"thread_id";}}}s:18:"phpfox_forum_thank";a:3:{s:7:"COLUMNS";a:4:{s:8:"thank_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"post_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"thank_id";s:4:"KEYS";a:2:{s:7:"post_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"post_id";i:1;s:7:"user_id";}}s:9:"post_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"post_id";}}}s:19:"phpfox_forum_thread";a:3:{s:7:"COLUMNS";a:18:{s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"forum_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"group_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"poll_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"start_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"is_announcement";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_closed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"title_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"time_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"order_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"post_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"last_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_post";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"thread_id";s:4:"KEYS";a:9:{s:8:"forum_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"forum_id";i:1;s:8:"group_id";i:2;s:7:"view_id";}}s:8:"group_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"group_id";i:1;s:7:"view_id";i:2;s:9:"title_url";}}s:10:"forum_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:8:"forum_id";}s:10:"group_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"group_id";i:1;s:7:"view_id";i:2;s:15:"is_announcement";}}s:10:"group_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"group_id";i:1;s:9:"title_url";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"thread_id";i:1;s:8:"group_id";}}s:8:"start_id";a:2:{i:0;s:5:"INDEX";i:1;s:8:"start_id";}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:5:"title";}}}}s:25:"phpfox_forum_thread_track";a:2:{s:7:"COLUMNS";a:3:{s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"thread_id";i:1;s:7:"user_id";}}s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"thread_id";}}}s:18:"phpfox_forum_track";a:2:{s:7:"COLUMNS";a:3:{s:8:"forum_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"forum_id";i:1;s:7:"user_id";}}}}}]]></tables>
	<install><![CDATA[
		$aForumCategories = array(
			'Discussions' => array(
				'url' => 'discussions',				
				'sub_forums' => array(
					'General' => 'general',
					'Movies' => 'movies',
					'Music' => 'music'
				)
			),
			'Computers & Technology' => array(
				'url' => 'computers-technology',				
				'sub_forums' => array(
					'Computers' => 'computers',
					'Electronics' => 'electronics',
					'Gadgets' => 'gadgets',
					'General' => 'general'
				)
			)
		);		
		
		$iCategoryOrder = 0;
		foreach ($aForumCategories as $sCategory => $aForum)
		{
			$iCategoryOrder++;
			$iForumId = $this->database()->insert(Phpfox::getT('forum'), array(
					'is_category' => 1,
					'name' => $sCategory,
					'name_url' => $aForum['url'],
					'ordering' => $iCategoryOrder			
				)
			);
			
			$iForumOrder = 0;
			foreach ($aForum['sub_forums'] as $sName => $sUrl)
			{
				$iForumOrder++;
				$this->database()->insert(Phpfox::getT('forum'), array(
						'parent_id' => $iForumId,						
						'name' => $sName,
						'name_url' => $sUrl,
						'ordering' => $iForumOrder			
					)
				);			
			}
			
		}
	]]></install>
</module>