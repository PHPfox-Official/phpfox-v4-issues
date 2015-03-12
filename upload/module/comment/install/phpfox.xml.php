<module>
	<data>
		<module_id>comment</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_comment</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="time_stamps" module_id="comment" is_hidden="0" type="string" var_name="comment_time_stamp" phrase_var_name="setting_comment_time_stamp" ordering="2" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="" module_id="comment" is_hidden="0" type="integer" var_name="comment_page_limit" phrase_var_name="setting_comment_page_limit" ordering="0" version_id="2.0.0alpha1">10</setting>
		<setting group="spam" module_id="comment" is_hidden="0" type="boolean" var_name="spam_check_comments" phrase_var_name="setting_spam_check_comments" ordering="6" version_id="2.0.0rc1">1</setting>
		<setting group="spam" module_id="comment" is_hidden="0" type="boolean" var_name="comment_hash_check" phrase_var_name="setting_comment_hash_check" ordering="8" version_id="2.0.0rc1">0</setting>
		<setting group="spam" module_id="comment" is_hidden="0" type="integer" var_name="comments_to_check" phrase_var_name="setting_comments_to_check" ordering="9" version_id="2.0.0rc1">10</setting>
		<setting group="spam" module_id="comment" is_hidden="0" type="string" var_name="total_minutes_to_wait_for_comments" phrase_var_name="setting_total_minutes_to_wait_for_comments" ordering="13" version_id="2.0.0rc1">2</setting>
		<setting group="" module_id="comment" is_hidden="0" type="integer" var_name="total_comments_in_activity_feed" phrase_var_name="setting_total_comments_in_activity_feed" ordering="1" version_id="3.0.0Beta1">2</setting>
		<setting group="" module_id="comment" is_hidden="0" type="boolean" var_name="comment_is_threaded" phrase_var_name="setting_comment_is_threaded" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="comment" is_hidden="0" type="integer" var_name="thread_comment_total_display" phrase_var_name="setting_thread_comment_total_display" ordering="1" version_id="3.0.0">3</setting>
		<setting group="cache" module_id="comment" is_hidden="0" type="boolean" var_name="load_delayed_comments_items" phrase_var_name="setting_load_delayed_comments_items" ordering="1" version_id="3.6.0rc1">0</setting>
		<setting group="" module_id="comment" is_hidden="1" type="integer" var_name="total_amount_of_comments_to_load" phrase_var_name="setting_total_amount_of_comments_to_load" ordering="1" version_id="3.0.0Beta1">10</setting>
		<setting group="" module_id="comment" is_hidden="1" type="integer" var_name="total_child_comments" phrase_var_name="setting_total_child_comments" ordering="1" version_id="2.0.0rc1">4</setting>
		<setting group="" module_id="comment" is_hidden="1" type="boolean" var_name="wysiwyg_comments" phrase_var_name="setting_wysiwyg_comments" ordering="0" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="comment" is_hidden="1" type="boolean" var_name="allow_rss_feed_on_comments" phrase_var_name="setting_allow_rss_feed_on_comments" ordering="1" version_id="2.0.0beta5">1</setting>
		<setting group="" module_id="comment" is_hidden="1" type="boolean" var_name="allow_comments_on_profiles" phrase_var_name="setting_allow_comments_on_profiles" ordering="1" version_id="2.0.0rc4">1</setting>
	</settings>
	<hooks>
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_rating_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_rating_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_display_process_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_display_process_validation" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_display_process_middle" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_display_process_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_display_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_view_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_view_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_ajax_ajax_add_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_ajax_ajax_add_passed" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_callback__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_getquote_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_getquote_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_getcommentforedit" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_hasaccess_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_hasaccess_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_process_add" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_process_deleteinline" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_process_delete" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_process___call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="template" module="comment" call_name="comment.template_block_display_add_comment" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="template" module="comment" call_name="comment.template_block_display_textarea_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="template" module="comment" call_name="comment.template_block_display_textarea_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="comment" hook_type="controller" module="comment" call_name="comment.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_mini_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_moderate_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="comment" hook_type="controller" module="comment" call_name="comment.component_controller_admincp_spam_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="comment" hook_type="controller" module="comment" call_name="comment.component_controller_moderate_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="comment" hook_type="controller" module="comment" call_name="comment.component_controller_view_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="comment" hook_type="controller" module="comment" call_name="comment.component_controller_rss_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_get__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_get__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_getforrss__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_getforrss__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.component_service_callback_getrequestlink__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.component_service_callback_getredirectrequest__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.component_service_callback_getnotificationsettings__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.component_service_callback_ondeleteuser__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.component_service_callback_updatecounterlist__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.component_service_callback_updatecounter__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.component_service_callback_updatecounter__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_ajax_get_quote" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_ajax_get_text" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="comment" hook_type="template" module="comment" call_name="comment.template_block_display_add_comment_define" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_process_add_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_get_count_query" added="1286546859" version_id="2.0.7" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_get_query" added="1286546859" version_id="2.0.7" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_ajax_browse" added="1286546859" version_id="2.0.7" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_view_process_template_load" added="1290072896" version_id="2.0.7" />
		<hook module_id="comment" hook_type="controller" module="comment" call_name="comment.component_controller_profile_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_comment_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_process_notify_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="comment" hook_type="component" module="comment" call_name="comment.component_block_share_clean" added="1339076699" version_id="3.3.0beta1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_massmail__1" added="1361180401" version_id="3.5.0rc1" />
		<hook module_id="comment" hook_type="service" module="comment" call_name="comment.service_comment_massmail__0" added="1363075699" version_id="3.5.0" />
	</hooks>
	<components>
		<component module_id="comment" component="display" m_connection="" module="comment" is_controller="0" is_block="1" is_active="1" />
		<component module_id="comment" component="view" m_connection="" module="comment" is_controller="0" is_block="1" is_active="1" />
		<component module_id="comment" component="rating" m_connection="" module="comment" is_controller="0" is_block="1" is_active="1" />
		<component module_id="comment" component="ajax" m_connection="" module="comment" is_controller="0" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_setting_wysiwyg_on_comments" added="1214975355">Can use a WYSIWYG Editor on comments?

Note: The WYSIWYG Editor feature must be enabled.</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_setting_edit_own_comment" added="1214975363">Can edit their own comments?</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_setting_edit_user_comment" added="1214975374">Can edit comments added by other users?</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_setting_delete_own_comment" added="1214975381">Can delete their own comments?</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_setting_delete_user_comment" added="1214975391">Can delete comments added by other users?</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_setting_points_comment" added="1214975689">Specify how many points the user will receive when adding a new comment.</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_setting_can_vote_on_comments" added="1218723462">Allow users to vote on comments?</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_setting_can_post_comments" added="1219216463">Can post comments?</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="module_comment" added="1219147587">Comment</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="x_wrote" added="1212758463"><![CDATA[<a href="{link}">{full_name}</a> wrote at {date}]]></phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="edit" added="1212758797">Edit</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="reply" added="1212758815">Reply</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="quote" added="1212758831">Quote</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="delete" added="1212758847">Delete</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="delete_comment" added="1212758863">Delete Comment</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="last_update_on_x_by_x" added="1212761285">Last Update on {date} by {full_name}</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="fill_text_your_comment" added="1212761438">Fill in some text for your comment</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="leave_a_reply" added="1212761679">Leave a Reply</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="comment" added="1212761697">Comment</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="submit_comment" added="1212761728">Submit Comment</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="adding_comment" added="1212761764">Adding Comment</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="comment_deleted" added="1215261123">Comment Deleted</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="voted" added="1218714564">Voted!</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="vote" added="1218723227">{total} Vote</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="votes" added="1218723235">{total} Votes</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="vote_this_comment" added="1218723252">Vote This Comment Up</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="vote_this_comment_down" added="1218723273">Vote This Comment Down</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="comments_header" added="1218724890">Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="comments" added="1219061995"><![CDATA[No comments. Be the first to <a href="#add-comment" onclick="$.scrollTo('#add-comment', 360); return false;">add</a> a comment.]]></phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="user_wrote_date" added="1219404347">{full_name} wrote at {date}</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="name" added="1219404436">Name</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="email_will_not_published" added="1219404453">Email (Will not be published)</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="website" added="1219404463">Website</phrase>
		<phrase module_id="comment" version_id="2.0.0alpha1" var_name="comments_must_login_signup" added="1219405155"><![CDATA[No Comments. <a href="{login}">Login</a> or <a href="{register}">Signup</a> to be first.]]></phrase>
		<phrase module_id="comment" version_id="2.0.0alpha3" var_name="user_setting_comment_post_flood_control" added="1239106180">Define how many minutes this user group should wait before they can post a new comment.

Note: Set to 0 if there should be no limit.</phrase>
		<phrase module_id="comment" version_id="2.0.0beta5" var_name="setting_allow_rss_feed_on_comments" added="1245661168"><![CDATA[<title>RSS Feed on Comments</title><info>Set to <b>True</b> to enable RSS feeds on comments.</info>]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc1" var_name="setting_total_child_comments" added="1250665239"><![CDATA[<title>Total Child Comments</title><info>Define how many child comments can a parent comment have?

Note: This is only used if threaded replies are enabled.</info>]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc1" var_name="user_setting_can_moderate_comments" added="1251193218">Can moderate comments?</phrase>
		<phrase module_id="comment" version_id="2.0.0rc1" var_name="setting_spam_check_comments" added="1251271192"><![CDATA[<title>Spam Check Comments</title><info>Spam Check Comments</info>]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc1" var_name="setting_comment_hash_check" added="1251284550"><![CDATA[<title>Comment Hash Check</title><info>If enabled this will check if the last X comments added in the last Y minutes are identical to the comment being added.

Notice: X & Y are settings that can be changed.</info>]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc1" var_name="setting_comments_to_check" added="1251284777"><![CDATA[<title>Comments To Check</title><info>If the setting to check if comments are identical you can set here how many comments in the past should be checked.</info>]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc1" var_name="setting_total_minutes_to_wait_for_comments" added="1251284849"><![CDATA[<title>Comment Minutes to Wait Until Next Check</title><info>If the setting to check if comments are identical you can set here how far back we should check in minutes.</info>]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="posting_a_comment_a_little_too_soon_total_time" added="1252996489">Posting a comment a little too soon. {total_time}</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="add_some_text_to_your_comment" added="1252996511">Add some text to your comment.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="your_comment_was_successfully_added_moderated" added="1252996553">Your comment was successfully added, however this item requires that all comments be moderated by the owner before they are publicly displayed.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="last_update_on_time_stamp_by_full_name" added="1252996649">Last update on {time_stamp} by {full_name}.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="comment_successfully_deleted" added="1252998594">Comment successfully deleted.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="fill_in_your_name" added="1252998674">Fill in your name.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="comment_title" added="1252998712">Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="last_activity" added="1252998824">Last Activity</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="rating" added="1252998834">Rating</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="rss_feeds_are_disabled_for_comments" added="1252998882">RSS feeds are disabled for comments.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="comment_does_not_exist" added="1252998893">Comment does not exist.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="nothing_new_to_approve" added="1252998943">Nothing new to approve.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="comments_pending_approval" added="1252998961">Comments Pending Approval</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="comments_pending_approval_total" added="1252998996"><![CDATA[Comments Pending Approval (<span id="js_request_comment_count_total">{total}</span>)]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="new_comments" added="1252999027">New Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="comments_for_approval" added="1252999037">Comments for Approval</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="add_comment" added="1252999047">Add Comment</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="view_comments" added="1252999055">View Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="user_link_added_a_comment_and_is_pending_your_approval" added="1252999095">{user_link} added a comment and is pending your approval.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="by_full_name" added="1252999214">By: {full_name}</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="latest_comments_on_site_title" added="1252999246">Latest comments on {site_title}.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="latest_comments" added="1252999267">Latest Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="your_comment_has_been_marked_as_spam_it_will_have_to_be_approved_by_an_admin" added="1252999400">Your comment has been marked as spam. It will have to be approved by an Admin before it is displayed publicly.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="not_a_valid_comment" added="1252999445">Not a valid comment.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="unable_to_moderate_this_comment" added="1252999489">Unable to moderate this comment.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="email" added="1252999530">Email</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="will_not_be_published" added="1252999537">Will not be published.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="message" added="1252999547">Message</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="item" added="1252999578">Item</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="approve" added="1252999602">Approve</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="deny" added="1252999610">Deny</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="your_comment_has_successfully_added" added="1253003073">Your comment has successfully added.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="view_replies_total_to_this_comment" added="1253003246">View replies ({total}) to this comment.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="are_you_sure" added="1253003269">Are you sure?</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="user_link_at_item_time_stamp" added="1253003465">{user_link} at {item_time_stamp}.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="view_more" added="1253005082">View More</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="moderate_comments" added="1253005324">Moderate Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="comment_successfully_approved" added="1253005331">Comment successfully approved.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="user_link_left_a_comment_on_your_item" added="1253005615"><![CDATA[{user_link} left a comment on your <a href="{link}">{item_name}</a>.]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc2" var_name="no_comments" added="1253007452">No comments.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc3" var_name="user_setting_can_delete_comments_posted_on_own_profile" added="1254142484">Can this user group delete comments posted on their own profile?</phrase>
		<phrase module_id="comment" version_id="2.0.0rc3" var_name="no_comments_added" added="1254575996">No comments added.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc4" var_name="setting_allow_comments_on_profiles" added="1255773488"><![CDATA[<title>Allow Comments on Profile</title><info>Enable this feature to allow comments on profiles.</info>]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc4" var_name="loading" added="1255779973">Loading</phrase>
		<phrase module_id="comment" version_id="2.0.0rc4" var_name="view_all_total_left_comments" added="1255780014">View all {total_left} comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc4" var_name="comments_text" added="1255860241">Comments Text</phrase>
		<phrase module_id="comment" version_id="2.0.0rc4" var_name="view_all_comments" added="1256652089">View All Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc4" var_name="view_all_comments_total" added="1256652375">View All Comments ({total})</phrase>
		<phrase module_id="comment" version_id="2.0.0rc8" var_name="cannot_comment_on_this_item_as_it_does_not_exist_any_longer" added="1258388355">Cannot comment on this item as it does not exist any longer.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc8" var_name="comments_activity" added="1258500371">Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc8" var_name="new_comments_stats" added="1258756851">Comments</phrase>
		<phrase module_id="comment" version_id="2.0.0rc8" var_name="you_cannot_write_a_comment_on_your_own_profile" added="1258848075">You cannot write a comment on your own profile.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc8" var_name="user_setting_can_comment_on_own_profile" added="1258848146">Can comment on own profile?</phrase>
		<phrase module_id="comment" version_id="2.0.0rc8" var_name="update_owner_id_for_comments_only_for_those_that_upgraded_from_v1_6_21" added="1258985244">Update Owner ID# for Comments (Only for those that upgraded from v1.6.21).</phrase>
		<phrase module_id="comment" version_id="2.0.0rc8" var_name="your_old_v1_6_21_setting_file_must_exist" added="1258985284">Your old v1.6.21 setting file must exist in order for us to continue. Old setting file: {file}</phrase>
		<phrase module_id="comment" version_id="2.0.0rc8" var_name="the_database_table_table_does_not_exist" added="1258985369"><![CDATA[The database table "{table}" does not exist. We cannot update this counter.]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc11" var_name="full_name_approved_your_comment_on_site_title" added="1260134308">{full_name} approved your comment on {site_title}.</phrase>
		<phrase module_id="comment" version_id="2.0.0rc11" var_name="full_name_approved_your_comment_on_site_title_message" added="1260134338"><![CDATA[{full_name} approved your comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_comment_a" added="1260473572"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">comment</a>.]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_a_href_link_coment_a" added="1260483353"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">comment</a>.]]></phrase>
		<phrase module_id="comment" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_comment_a" added="1260483372"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">comment</a>.]]></phrase>
		<phrase module_id="comment" version_id="2.0.5dev1" var_name="user_setting_approve_all_comments" added="1275006612">Approve comments before they are displayed publicly?</phrase>
		<phrase module_id="comment" version_id="2.0.5dev1" var_name="your_comment_has_successfully_been_added_however_it_is_pending_an_admins_approval" added="1275010416">Your comment has successfully been added, however it is pending an Admins approval.</phrase>
		<phrase module_id="comment" version_id="2.0.5dev1" var_name="comments_approve" added="1275010577">Comments</phrase>
		<phrase module_id="comment" version_id="2.0.5dev1" var_name="comment_approved_on_site_title" added="1275012409">Comment Approved on {site_title}</phrase>
		<phrase module_id="comment" version_id="2.0.5dev1" var_name="one_of_your_comments_on_site_title" added="1275012488"><![CDATA[One of your comments on {site_title} has been approved. To view this comment click the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="comment" version_id="2.0.6" var_name="subscribe_to_comments" added="1282665092">Subscribe to comments</phrase>
		<phrase module_id="comment" version_id="3.0.0Beta1" var_name="setting_total_comments_in_activity_feed" added="1295000248"><![CDATA[<title>Total Comments in Activity Feed</title><info>Define how many comments should be displayed within each activity feed.</info>]]></phrase>
		<phrase module_id="comment" version_id="3.0.0Beta1" var_name="setting_total_amount_of_comments_to_load" added="1295000484"><![CDATA[<title>Total Amount of Comments To Load</title><info>When a user clicks to view more comments on a feed or item this setting controls how many comments to load via AJAX on the page they are on. If this number is surpassed they are then directed to the parent item where it will display all the comments and comes built in with a pager.</info>]]></phrase>
		<phrase module_id="comment" version_id="3.0.0beta5" var_name="delete_this_comment" added="1319121256">Delete this comment</phrase>
		<phrase module_id="comment" version_id="3.0.0beta5" var_name="1_person" added="1319121314">1 person</phrase>
		<phrase module_id="comment" version_id="3.0.0beta5" var_name="total_people" added="1319121332">{total} people</phrase>
		<phrase module_id="comment" version_id="3.0.0" var_name="viewing_comment" added="1322467136">Viewing Comment</phrase>
		<phrase module_id="comment" version_id="3.0.0" var_name="setting_thread_comment_total_display" added="1322566739"><![CDATA[<title>Total Nested Comments</title><info>Define how many nested comments we should display.

Note: This is only used if threaded replies are enabled.</info>]]></phrase>
		<phrase module_id="comment" version_id="3.0.0" var_name="view_total_more" added="1322634365">View {total} more</phrase>
		<phrase module_id="comment" version_id="3.0.0" var_name="viewing_a_single_comment" added="1323170547">Viewing a single comment.</phrase>
		<phrase module_id="comment" version_id="3.0.0" var_name="view_previous_comments" added="1323170568">View previous comments</phrase>
		<phrase module_id="comment" version_id="3.1.0rc1" var_name="user_setting_can_delete_comment_on_own_item" added="1332248539">Can delete any comments posted on their own item?</phrase>
		<phrase module_id="comment" version_id="3.2.0beta1" var_name="comment_on_items" added="1334578769">Comment on Items</phrase>
		<phrase module_id="comment" version_id="3.5.0beta1" var_name="item_phrase" added="1355134050">comment</phrase>
		<phrase module_id="comment" version_id="3.6.0rc1" var_name="setting_load_delayed_comments_items" added="1371732573"><![CDATA[<title>Load Comments via AJAX</title><info>Enable to load comments via AJAX when viewing items.</info>]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="0" user="0" guest="0" staff="0" module="comment" ordering="0">wysiwyg_on_comments</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="0" guest="0" staff="1" module="comment" ordering="0">edit_own_comment</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="0" guest="0" staff="1" module="comment" ordering="0">edit_user_comment</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="1" guest="0" staff="1" module="comment" ordering="0">delete_own_comment</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="0" guest="0" staff="1" module="comment" ordering="0">delete_user_comment</setting>
		<setting is_admin_setting="0" module_id="comment" type="integer" admin="1" user="1" guest="1" staff="1" module="comment" ordering="0">points_comment</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="1" guest="0" staff="1" module="comment" ordering="0">can_vote_on_comments</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="1" guest="0" staff="1" module="comment" ordering="0">can_post_comments</setting>
		<setting is_admin_setting="0" module_id="comment" type="integer" admin="0" user="0" guest="1" staff="0" module="comment" ordering="0">comment_post_flood_control</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="0" guest="0" staff="1" module="comment" ordering="0">can_moderate_comments</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="1" guest="0" staff="1" module="comment" ordering="0">can_delete_comments_posted_on_own_profile</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="1" user="1" guest="0" staff="1" module="comment" ordering="0">can_comment_on_own_profile</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="0" user="0" guest="0" staff="0" module="comment" ordering="0">approve_all_comments</setting>
		<setting is_admin_setting="0" module_id="comment" type="boolean" admin="0" user="0" guest="0" staff="0" module="comment" ordering="0">can_delete_comment_on_own_item</setting>
	</user_group_settings>
	<tables><![CDATA[a:4:{s:14:"phpfox_comment";a:3:{s:7:"COLUMNS";a:18:{s:10:"comment_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"owner_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"update_time";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"update_user";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"rating";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"author";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:12:"author_email";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"author_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"child_total";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"comment_id";s:4:"KEYS";a:6:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"view_id";}}s:13:"owner_user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:13:"owner_user_id";i:1;s:7:"view_id";}}s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"type_id";i:1;s:7:"item_id";i:2;s:7:"view_id";}}s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"parent_id";i:1;s:7:"view_id";}}s:11:"parent_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:9:"parent_id";i:1;s:7:"type_id";i:2;s:7:"item_id";i:3;s:7:"view_id";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}}}s:19:"phpfox_comment_hash";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"item_hash";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:9:"item_hash";i:2;s:10:"time_stamp";}}}}s:21:"phpfox_comment_rating";a:2:{s:7:"COLUMNS";a:5:{s:10:"comment_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"rating";a:4:{i:0;s:7:"VCHAR:2";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:10:"comment_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"comment_id";i:1;s:7:"user_id";}}}}s:19:"phpfox_comment_text";a:2:{s:7:"COLUMNS";a:3:{s:10:"comment_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"text_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:10:"comment_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"comment_id";}}}}]]></tables>
</module>