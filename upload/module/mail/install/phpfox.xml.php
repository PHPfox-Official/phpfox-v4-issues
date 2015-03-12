<module>
	<data>
		<module_id>mail</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_mail</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="mail" parent_var_name="" m_connection="mail" var_name="menu_compose" ordering="2" url_value="mail.compose" version_id="2.0.0alpha1" disallow_access="" module="mail" />
		<menu module_id="mail" parent_var_name="" m_connection="mobile" var_name="menu_mail_mail_532c28d5412dd75bf975fb951c740a30" ordering="119" url_value="mail" version_id="3.1.0rc1" disallow_access="" module="mail" mobile_icon="small_mail.png" />
	</menus>
	<settings>
		<setting group="time_stamps" module_id="mail" is_hidden="0" type="string" var_name="mail_time_stamp" phrase_var_name="setting_mail_time_stamp" ordering="9" version_id="2.0.0alpha1">M j, g:i a</setting>
		<setting group="" module_id="mail" is_hidden="0" type="boolean" var_name="show_core_mail_folders_item_count" phrase_var_name="setting_show_core_mail_folders_item_count" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="mail" is_hidden="0" type="boolean" var_name="display_total_mail_count" phrase_var_name="setting_display_total_mail_count" ordering="1" version_id="2.0.0alpha2">0</setting>
		<setting group="" module_id="mail" is_hidden="0" type="boolean" var_name="enable_mail_box_warning" phrase_var_name="setting_enable_mail_box_warning" ordering="1" version_id="2.0.0beta5">1</setting>
		<setting group="cron" module_id="mail" is_hidden="0" type="boolean" var_name="enable_cron_delete_old_mail" phrase_var_name="setting_enable_cron_delete_old_mail" ordering="1" version_id="2.0.0beta5">1</setting>
		<setting group="cron" module_id="mail" is_hidden="0" type="integer" var_name="cron_delete_messages_delay" phrase_var_name="setting_cron_delete_messages_delay" ordering="2" version_id="2.0.0beta5">30</setting>
		<setting group="" module_id="mail" is_hidden="0" type="integer" var_name="message_age_to_delete" phrase_var_name="setting_message_age_to_delete" ordering="1" version_id="2.0.0beta5">20</setting>
		<setting group="" module_id="mail" is_hidden="0" type="boolean" var_name="delete_sent_when_account_cancel" phrase_var_name="setting_delete_sent_when_account_cancel" ordering="1" version_id="2.0.0beta5">1</setting>
		<setting group="spam" module_id="mail" is_hidden="0" type="boolean" var_name="spam_check_messages" phrase_var_name="setting_spam_check_messages" ordering="7" version_id="2.0.0rc1">1</setting>
		<setting group="spam" module_id="mail" is_hidden="0" type="boolean" var_name="mail_hash_check" phrase_var_name="setting_mail_hash_check" ordering="2" version_id="2.0.0rc1">0</setting>
		<setting group="spam" module_id="mail" is_hidden="0" type="integer" var_name="total_mail_messages_to_check" phrase_var_name="setting_total_mail_messages_to_check" ordering="10" version_id="2.0.0rc1">10</setting>
		<setting group="spam" module_id="mail" is_hidden="0" type="integer" var_name="total_minutes_to_wait_for_pm" phrase_var_name="setting_total_minutes_to_wait_for_pm" ordering="14" version_id="2.0.0rc1">2</setting>
		<setting group="" module_id="mail" is_hidden="0" type="boolean" var_name="show_preview_message" phrase_var_name="setting_show_preview_message" ordering="1" version_id="2.0.0rc3">1</setting>
		<setting group="" module_id="mail" is_hidden="0" type="boolean" var_name="disallow_select_of_recipients" phrase_var_name="setting_disallow_select_of_recipients" ordering="1" version_id="2.0.7">0</setting>
		<setting group="" module_id="mail" is_hidden="0" type="boolean" var_name="update_message_notification_preview" phrase_var_name="setting_update_message_notification_preview" ordering="1" version_id="3.1.0beta1">1</setting>
		<setting group="" module_id="mail" is_hidden="0" type="boolean" var_name="threaded_mail_conversation" phrase_var_name="setting_threaded_mail_conversation" ordering="1" version_id="3.2.0beta1">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="mail.index" module_id="mail" component="folder" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="mail.sentbox" module_id="mail" component="folder" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="mail.view" module_id="mail" component="folder" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="mail.compose" module_id="mail" component="folder" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="mail" hook_type="component" module="mail" call_name="mail.component_block_folder_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="component" module="mail" call_name="mail.component_block_folder_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="component" module="mail" call_name="mail.component_block_box_edit_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_box_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_sentbox_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_view_process_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_view_process_validation" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_view_process_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_view_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_compose_controller_to" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_compose_controller_validation" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_compose_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_trash_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_folder_folder__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_folder_process_move" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_folder_process_add" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_folder_process_update" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_folder_process_delete" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_folder_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_mail_get" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_mail_getmail" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_mail__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_add" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_toggleview" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_delete" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_deletetrash" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_undelete" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_cronDeleteMessages_start" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_cronDeleteMessages_end" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_admincp_view_clean" added="1261572640" version_id="2.0.0" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_compose_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_index_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_view_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="mail" hook_type="component" module="mail" call_name="mail.component_ajax_compose" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="component" module="mail" call_name="mail.component_block_box_add_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="component" module="mail" call_name="mail.component_block_box_select_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="component" module="mail" call_name="mail.component_block_latest_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="component" module="mail" call_name="mail.component_block_notify_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_api__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_mail_canmessageuser_1" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_add_1" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="template" module="mail" call_name="mail.template_controller_compose_ajax_onsubmit" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="mail" hook_type="controller" module="mail" call_name="mail.component_controller_thread_clean" added="1334069444" version_id="3.2.0beta1" />
		<hook module_id="mail" hook_type="service" module="mail" call_name="mail.service_process_add_2" added="1384774431" version_id="3.7.3" />
	</hooks>
	<components>
		<component module_id="mail" component="compose" m_connection="mail.compose" module="mail" is_controller="1" is_block="0" is_active="1" />
		<component module_id="mail" component="folder" m_connection="" module="mail" is_controller="0" is_block="1" is_active="1" />
		<component module_id="mail" component="ajax" m_connection="" module="mail" is_controller="0" is_block="0" is_active="1" />
		<component module_id="mail" component="box.edit" m_connection="" module="mail" is_controller="0" is_block="1" is_active="1" />
		<component module_id="mail" component="index" m_connection="mail.index" module="mail" is_controller="1" is_block="0" is_active="1" />
		<component module_id="mail" component="view" m_connection="mail.view" module="mail" is_controller="1" is_block="0" is_active="1" />
		<component module_id="mail" component="sentbox" m_connection="mail.sentbox" module="mail" is_controller="1" is_block="0" is_active="1" />
		<component module_id="mail" component="box.index" m_connection="mail.box.index" module="mail" is_controller="1" is_block="0" is_active="1" />
		<component module_id="mail" component="trash" m_connection="mail.trash" module="mail" is_controller="1" is_block="0" is_active="1" />
	</components>
	<crons>
		<cron module_id="mail" type_id="3" every="30"><![CDATA[Phpfox::getService('mail.process')->cronDeleteMessages();]]></cron>
	</crons>
	<phrases>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="user_setting_total_folders" added="1230127070"><![CDATA[Total amount folders a user can add to their mail box. 

To add an unlimited number add "0" (without quotes).]]></phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="menu_compose" added="1220273240">Compose</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="module_mail" added="1219932350">Mail</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="user_wrote_time" added="1220427735"><![CDATA[<a href="{link}">{user}</a> wrote on {time}]]></phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="add_new_folder" added="1220533241">Add new Folder...</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="adding_new_folder" added="1220539091">Adding new folder</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="invalid_message" added="1220877891">Invalid message.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="add_reply" added="1220877933">Add a reply.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="message" added="1220877953">Message</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="adding_message" added="1220878629">Adding message.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="reply" added="1220878770">Reply</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="send" added="1220878779">Send</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="folders" added="1220878830">Folders</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="edit_folders" added="1220878857">Edit Folders</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="inbox" added="1220878881">Inbox</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="sent_messages" added="1220878890">Sent Messages</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="trash" added="1220878897">Trash</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="add" added="1220878920">Add</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="update" added="1220878964">Update</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="cancel" added="1220878979">Cancel</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="delete" added="1220879064">Delete</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="view_folders" added="1220879177">View Folders</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="move_folder" added="1220880629">Move to folder</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="or_cancel" added="1220880651"><![CDATA[or <a href="#" onclick="$('#js_action_selector').val(''); $('#js_folders').hide(); $('#js_select_info').show('slow'); return false;">cancel</a>.]]></phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="default" added="1220880680">Default</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="custom" added="1220880687">Custom</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="select" added="1220880732">Select</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="undelete" added="1220880841">Undelete</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="mark_read" added="1220880862">Mark as Read</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="mark_unread" added="1220880871">Mark as Unread</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="none" added="1220880891">None</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="read" added="1220880898">Read</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="unread" added="1220880905">Unread</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="all" added="1220880911">All</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="to" added="1220880945">To</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="re" added="1220880971">Re</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="messages" added="1220881016">No messages.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="messages_updated" added="1220881062">Message(s) updated.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="messages_deleted" added="1220881105">Message(s) deleted.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="search_inbox" added="1220881134">Search Inbox</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="invalid_box" added="1220881154">Invalid box.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="message_successfully_deleted" added="1220882572">Message successfully deleted.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="messages_successfully_moved" added="1220882602">Message(s) successfully moved.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="folder_error" added="1220882927">Folders can only contain alphanumeric characters, limit of 255 characters and the following symbols: _-</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="folder_already_use" added="1220883004">Folder is already in use.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="compose_new_message" added="1220948605">Compose New Message</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="subject" added="1220948653">Subject</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="provide_user_email" added="1220948710">Provide a user or email.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="provide_subject_for_your_message" added="1220948729">Provide a subject for your message.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="provide_message" added="1220948745">Provide a message.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="message_was_successfully_users" added="1220956341">Your message was successfully sent to the following users</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="not_member" added="1220956574">Not a member.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="cannot_send_message_yourself" added="1220957273">Cannot send a message to yourself.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="and" added="1220963302">and</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="user_setting_can_compose_message" added="1230159206">Can compose messages to another users?</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="user_setting_can_add_folders" added="1230159364">Can add custom folders?</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="setting_show_core_mail_folders_item_count" added="1233234365"><![CDATA[<title>Show inbox, sentbox and deletebox item count</title><info>If enabled will display the mail count totals in each folder, i.e.:

inbox (2)
sentbox (6)
delete (10)</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0alpha1" var_name="user_setting_show_core_mail_folders_item_count" added="1233235474">When enabled shows how many messages are in the inbox, sentbox and deletebox of every profile. 

Note that this adds extra queries to your database.</phrase>
		<phrase module_id="mail" version_id="2.0.0alpha2" var_name="setting_display_total_mail_count" added="1237808974"><![CDATA[<title>Display Total Mail Count</title><info>Set to <b>True</b> if you would like to display the number of new messages a user has beside the main "Mail" link found in the main menu by default.

<b>Notice:</b> This will add an extra SQL query.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0alpha2" var_name="user_setting_can_add_attachment_on_mail" added="1237813579">Can add attachments?</phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="user_setting_mail_box_limit" added="1245750405">This setting tells how many messages can be stored based on the user group. It is complemented by the setting override_mail_box_limit to allow administrators and staff members to store any number of messages.

This setting does not work with threaded mail.</phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="user_setting_override_mail_box_limit" added="1245750539">This setting tells if members of this user group can overcome the limit imposed by the setting mail_box_limit.

By default only administrators and staff members can have unlimited messages stored.</phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="user_setting_restrict_message_to_friends" added="1245765917">This setting tells if the user can only send messages to people in his/her friends list.</phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="user_setting_can_message_self" added="1245767264">This setting controls if members of this user group can send messages to themselves.</phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="user_setting_override_restrict_message_to_friends" added="1245767642"><![CDATA[Members allowed to override the "restrict_message_to_friends" will be able to receive messages regardless if they are friends of the sender or not.]]></phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="user_setting_mail_box_warning" added="1245847270">When users are about to use all their allowed mail space a warning will be shown. 

This setting tells what percentage of their mail capacity must be used before showing this warning.

Set it to zero to never show a warning.</phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="setting_enable_mail_box_warning" added="1245851230"><![CDATA[<title>Show Warning When Approaching Maibox Limit</title><info>This setting overrides the user group setting 'mail.mail_box_warning'. If this setting is disabled no warning will be shown regardless of whats set in mail.mail_box_warning.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="user_setting_allow_delete_every_message" added="1245851578"><![CDATA[When enabled this setting allows users to delete all the messages from the current folder without having to delete several times or going through the pager.

A new option will be shown in the mail selector with the count of messages to delete next in parenthesis.

example:
   None
   Read
   Unread
   All
-> All(24)]]></phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="setting_enable_cron_delete_old_mail" added="1245932314"><![CDATA[<title>Auto Delete Old Mail</title><info>This setting enables or disables the auto deletion of old messages.

You can set how old a message should be to be deleted in the setting <setting>mail.message_age_to_delete</setting>.

You can set how often to run this job in the setting <setting>mail.cron_delete_messages_delay</setting>.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="setting_cron_delete_messages_delay" added="1245932446"><![CDATA[<title>Auto Delete Messages Delay</title><info>This setting tells how often (in days) will the auto deleter remove old messages.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="setting_message_age_to_delete" added="1245932715"><![CDATA[<title>An Old Message Is...</title><info>This setting tells how old a message must be in (in days) order to be auto deleted.

This setting is directly dependent on <setting>mail.enable_cron_delete_old_mail</setting>.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0beta5" var_name="setting_delete_sent_when_account_cancel" added="1246883093"><![CDATA[<title>Delete Sent Mail</title><info>When a user cancels their account should the system delete the sent messages?

This affects the other user's received messages list and is enabled by default.</info>]]></phrase>
		<phrase module_id="mail" version_id="30" var_name="user_setting_can_read_private_messages" added="1247588434">Can members of this user group read private messages in your site?</phrase>
		<phrase module_id="mail" version_id="30" var_name="user_setting_can_delete_others_messages" added="1247742397"><![CDATA[Can members of this user group delete other people's messages?]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc1" var_name="user_setting_enable_captcha_on_mail" added="1251273638">Enable Captcha when composing messages.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc1" var_name="setting_spam_check_messages" added="1251274372"><![CDATA[<title>Spam Check Internal PM</title><info>Spam Check Internal PM</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc1" var_name="setting_mail_hash_check" added="1251277943"><![CDATA[<title>PM Hash Check</title><info>If enabled this will check if the last X messages sent in the last Y minutes are identical to the message being set.

Notice: X & Y are settings that can be changed.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc1" var_name="setting_total_mail_messages_to_check" added="1251278379"><![CDATA[<title>PM Messages to Check</title><info>If the setting to check if PM's are identical you can see here how many messages in the past should be checked.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc1" var_name="setting_total_minutes_to_wait_for_pm" added="1251278493"><![CDATA[<title>PM Minutes to Wait Until Next Check</title><info>If the setting to check if PM's are identical you can set here how far back we should check in minutes.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc3" var_name="setting_show_preview_message" added="1254749315"><![CDATA[<title>Show Preview Message</title><info>If enabled, users will see a short version of their messages.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc3" var_name="user_setting_send_message_to_max_users_each_time" added="1254829395">This value restricts sending private messages.
It sets the maximum number of recipients when sending private messages, avoiding users to select way too many users and potentially spamming.

Set to 0 for unlimited.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="read_private_message" added="1255010691">Read Private Message</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="subject_amp_text" added="1255010724"><![CDATA[Subject &amp; Text]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="text" added="1255010742">Text</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="all_members" added="1255010754">All Members</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="featured_members" added="1255010763">Featured Members</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="online" added="1255010771">Online</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="updated" added="1255010780">Updated</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="name_and_photo_only" added="1255010789">Name and Photo Only</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="name_photo_and_users_details" added="1255010800">Name, Photo and Users Details</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="private_messages" added="1255010811">Private Messages</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="view_private_messages" added="1255010824">View Private Messages</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="currently_your_account_is_marked_as_a_spammer" added="1255010848"><![CDATA[Currently your account is marked as a "spammer". This specific feature is not enabled for your account at the moment.]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="unable_to_send_a_private_message_to_this_user_at_the_moment" added="1255010860">Unable to send a private message to this user at the moment.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="select_a_member_to_send_a_message_to" added="1255010873">Select a member to send a message to.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="this_message_feels_like_spam_try_again" added="1255010889">This message feels like SPAM. Try again.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="mail" added="1255010900">Mail</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="no_mail_specified" added="1255010921">No mail specified.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="mail_deleted_successfully" added="1255010931">Mail deleted successfully.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="mail_could_not_be_deleted" added="1255010940">Mail could not be deleted.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="error_you_did_not_select_any_message" added="1255010975">Error you did not select any message.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="mail_folder_does_not_exist" added="1255010990">Mail folder does not exist.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="new_messages" added="1255011113">New Messages</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="compose_message" added="1255011123">Compose Message</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="1_new_message" added="1255011141">1 new message</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="total_new_messages" added="1255011158">{total} new messages</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="user_link_sent_you_a_message" added="1255011189">{user_link} sent you a message.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="mail_text" added="1255011211">Mail Text</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="too_many_users_this_message_was_sent_to_the_first_total_users" added="1255011269">Too many users, this message was sent to the first {total} users.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="unable_to_send_a_private_message_to_full_name_as_they_have_disabled_this_option_for_the_moment" added="1255011317"><![CDATA[Unable to send a private message to "{full_name}" as they have disabled this option for the moment.]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="user_has_reached_their_inbox_limit" added="1255011371">User has reached their inbox limit.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="you_cannot_message_yourself" added="1255011381">You cannot message yourself.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="you_can_only_message_your_friends" added="1255011391">You can only message your friends.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="not_a_valid_message" added="1255011402">Not a valid message.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="full_name_sent_you_a_message_on_site_title" added="1255011428">{full_name} sent you a message on {site_title}.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="full_name_sent_you_a_message_subject_subject" added="1255011550"><![CDATA[{full_name} sent you a message.

--------------------
Subject: {subject}

{message}
--------------------

To reply to this message, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="you_will_delete_every_message_in_this_folder" added="1255011670">You will delete every message in this folder.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="member_search" added="1255011737">Member Search</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="search" added="1255011746">Search</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="within" added="1255011754">within</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="user_group" added="1255011762">User Group</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="show_members" added="1255011771">Show Members</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="messages_title" added="1255011791">Messages</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="from" added="1255012424">From</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="sent" added="1255012445">Sent</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="read_message" added="1255012456">Read Message</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="delete_message" added="1255012464">Delete Message</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="message_sender" added="1255012478">Message Sender</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="message_user" added="1255012491">Message User</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="message_receiver" added="1255012502">Message Receiver</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="are_you_sure" added="1255012828">Are you sure?</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="no_messages_to_show" added="1255012839">No messages to show.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="send_a_copy_to_myself" added="1255012896">Send a copy to myself.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="you_can_only_send_this_message_to_total_users" added="1255012917">You can only send this message to {total} users.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="messages_total_days_old_will_be_auto_deleted" added="1255012972">Messages {total} days old will be auto deleted.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="you_have_reached_your_mail_box_capacity_and_wont_be_able" added="1255013019">You have reached your mail box capacity and wont be able to receive any more mail until you free some space.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="you_are_approaching_your_mail_box_limit" added="1255013047">You are approaching your mail box limit, currently at {total}%. When you reach 100% you wont be able to receive more mail.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="view_attachments" added="1255013086">View Attachments</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="you_wrote_to_yourself_at_time_stamp" added="1255013288">You wrote to yourself at {time_stamp}.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="preview" added="1255013349">Preview</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="you_wrote_to_user_name_at_time_stamp" added="1255013419">You wrote to {user_name} at {time_stamp}.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="user_name_wrote_at_time_stamp" added="1255013490">{user_name} wrote at {time_stamp}.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="site_sent_you_a_message" added="1255013528">{site} sent you a message.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="mass_message_to" added="1255013568">Mass message to</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="previous" added="1255013600">Previous</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="newer_message" added="1255013608">Newer Message</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="next" added="1255013615">Next</phrase>
		<phrase module_id="mail" version_id="2.0.0rc4" var_name="older_message" added="1255013623">Older Message</phrase>
		<phrase module_id="mail" version_id="2.0.0rc6" var_name="provide_a_name_for_your_folder" added="1257264043">Provide a name for your folder.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc6" var_name="you_have_reached_your_limit" added="1257264190">You have reached your limit.</phrase>
		<phrase module_id="mail" version_id="2.0.0rc8" var_name="mesages_sent" added="1258845591">Messages</phrase>
		<phrase module_id="mail" version_id="2.0.0" var_name="viewing_private_message" added="1261069259">Viewing Private Message</phrase>
		<phrase module_id="mail" version_id="2.0.0" var_name="private_message_from_timestamp" added="1261069539">Private message from {time_stamp} between {owner} and {viewer}.</phrase>
		<phrase module_id="mail" version_id="2.0.0" var_name="message_not_found" added="1261069623">Message not found.</phrase>
		<phrase module_id="mail" version_id="2.0.0" var_name="report" added="1261069915">Report</phrase>
		<phrase module_id="mail" version_id="2.0.0" var_name="report_this_message" added="1261069925">Report this message.</phrase>
		<phrase module_id="mail" version_id="2.0.4" var_name="mobile_messages" added="1267559963">Messages</phrase>
		<phrase module_id="mail" version_id="2.0.4" var_name="compose" added="1267559980">Compose</phrase>
		<phrase module_id="mail" version_id="2.0.4" var_name="no_messages" added="1267622617">No messages</phrase>
		<phrase module_id="mail" version_id="2.0.4" var_name="unable_to_find_any_messages" added="1267622629">Unable to find any messages</phrase>
		<phrase module_id="mail" version_id="2.0.4" var_name="select_recipient" added="1267622645">Select Recipient</phrase>
		<phrase module_id="mail" version_id="2.0.4" var_name="select_a_recipient_below" added="1267622665">Select a recipient below</phrase>
		<phrase module_id="mail" version_id="2.0.5" var_name="update_mail_count" added="1273245609">Update Mail Count</phrase>
		<phrase module_id="mail" version_id="2.0.7" var_name="updating" added="1288207511">Updating</phrase>
		<phrase module_id="mail" version_id="2.0.7" var_name="setting_disallow_select_of_recipients" added="1289312477"><![CDATA[<title>Disallow Selecting Not Allowed Recipients</title><info>When this setting is enabled the script will run an extra check on each target user when selecting who will receive an internal mail.

This helps the user selector to be more user friendly by not allowing to choose and write a message to someone who cannot receive it but at the same time it uses more resources and could slow down your site.</info>]]></phrase>
		<phrase module_id="mail" version_id="2.0.8" var_name="processing_batch_number" added="1297075659">Processing batch {number}</phrase>
		<phrase module_id="mail" version_id="2.0.8" var_name="batch_number_completed_percentage" added="1297075916">Batch {page_number} completed ({percentage}%)</phrase>
		<phrase module_id="mail" version_id="2.0.8" var_name="use_the_exact_user_name" added="1298293000">Use the exact user name</phrase>
		<phrase module_id="mail" version_id="2.0.8" var_name="send_from_my_own_address_semail" added="1298898843">Send from my own address ({sEmail})</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="messages_notify" added="1319116475">Messages</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="send_a_new_message" added="1319116486">Send a New Message</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="no_new_messages" added="1319116504">No new messages.</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="see_all_messages" added="1319116511">See All Messages</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="new_folder" added="1319121551">New Folder</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="new_message" added="1319121563">New Message</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="select_folder" added="1319121572">Select Folder</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="folder_successfully_created" added="1319124181">Folder successfully created.</phrase>
		<phrase module_id="mail" version_id="3.0.0beta5" var_name="create_new_folder" added="1319124191">Create New Folder</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="delete_this_list" added="1319792161">Delete This List</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="moderate" added="1319792181">Moderate</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="mark_as_read" added="1319792194">Mark as Read</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="mark_as_unread" added="1319792203">Mark as Unread</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="you" added="1319792216">You</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="no_messages_found_here" added="1319792229">No messages found here.</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="create_a_new_folder" added="1319792250">Create a New Folder</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="search_messages" added="1319792276">Search Messages...</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="latest" added="1319792284">Latest</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="unread_first" added="1319792292">Unread First</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="move" added="1319792308">Move</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="this_message_was_sent_from_full_name" added="1319792349">This message was sent from {full_name}</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="actions" added="1319792388">Actions</phrase>
		<phrase module_id="mail" version_id="3.0.0rc1" var_name="search_friends_by_their_name" added="1319792505">Search friends by their name...</phrase>
		<phrase module_id="mail" version_id="3.0.0rc2" var_name="enter_the_name_of_your_custom_folder" added="1321350373">Enter the name of your custom folder.</phrase>
		<phrase module_id="mail" version_id="3.0.0rc2" var_name="submit" added="1321350378">Submit</phrase>
		<phrase module_id="mail" version_id="3.0.0rc2" var_name="your_message_was_successfully_sent" added="1321350415">Your message was successfully sent</phrase>
		<phrase module_id="mail" version_id="3.0.0" var_name="li_a_href_link_email_image_new_messages_messages_number_a_li" added="1322564965"><![CDATA[<li><a href="{link}">{email_image} New Messages( {messages_number})</a><li>]]></phrase>
		<phrase module_id="mail" version_id="3.0.0" var_name="get_the_total_number_of_unseen_messages_if_you_do_not_pass_the_user_id_we_will_return_information_about_the_user_that_is_currently_logged_in" added="1322565349">Get the total number of unseen messages. If you do not pass the #{USER_ID} we will return information about the user that is currently logged in.</phrase>
		<phrase module_id="mail" version_id="3.0.0" var_name="folder_successfully_deleted" added="1322739661">Folder successfully deleted.</phrase>
		<phrase module_id="mail" version_id="3.0.0" var_name="message_s_successfully_deleted" added="1322739692">Message(s) successfully deleted.</phrase>
		<phrase module_id="mail" version_id="3.1.0beta1" var_name="setting_update_message_notification_preview" added="1331560640"><![CDATA[<title>Update Message "Read" on Notification Preview</title><info>Enable this option to update the notification counter for new messages when a user previews the mail via the site wide mail notification icon.</info>]]></phrase>
		<phrase module_id="mail" version_id="3.1.0rc1" var_name="menu_mail_mail_532c28d5412dd75bf975fb951c740a30" added="1332257801">Mail</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="setting_threaded_mail_conversation" added="1332427188"><![CDATA[<title>Threaded Mail Conversation</title><info>Enable this option to display messages from 2 users as 1 conversation.</info>]]></phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="full_name_sent_you_a_message_no_subject" added="1333370797"><![CDATA[{full_name} sent you a message.

--------------------
{message}
--------------------

To reply to this message, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="unable_to_export_your_messages" added="1333551243">Unable to export your messages.</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="message_has_been_read" added="1333551307">Message has been read</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="forward" added="1333551331">Forward</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="unable_to_find_a_conversation_history_with_this_user" added="1333551348">Unable to find a conversation history with this user.</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="messages_un_archived" added="1333551406">Messages un-archived</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="messages_archived" added="1333551413">Messages archived</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="moderation" added="1333551420">Moderation</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="sent_via_a_mobile_device" added="1333551450">Sent via a mobile device</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="message_successfully_archived" added="1333551511">Message successfully archived.</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="message_successfully_unarchived" added="1333551530">Message successfully unarchived.</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="archive" added="1333551553">Archive</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="un_archive" added="1333551560">Un-archive</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="export" added="1333551567">Export</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="unable_to_find_the_message_you_are_trying_to_mark_as_read_unread" added="1333551590">Unable to find the message you are trying to mark as read/unread.</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="unarchive" added="1333551635">Unarchive</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="you_are_currently_viewing_our_legacy_inbox" added="1333629750">You are currently viewing our legacy inbox.</phrase>
		<phrase module_id="mail" version_id="3.2.0beta1" var_name="you_are_viewing_a_message_that_is_from_our_legacy_inbox" added="1333629873">You are viewing a message that is from our legacy inbox.</phrase>
		<phrase module_id="mail" version_id="3.3.0beta2" var_name="view_more" added="1340287869">View More</phrase>
		<phrase module_id="mail" version_id="3.3.0beta2" var_name="custom_folders" added="1340816002">Custom Folders</phrase>
		<phrase module_id="mail" version_id="3.3.0beta2" var_name="this_message_was_sent_to_full_name" added="1341218986">This message was sent to {full_name}</phrase>
		<phrase module_id="mail" version_id="3.3.0beta2" var_name="this_message_was_sent_from_you" added="1341219032">This message was sent from you</phrase>
		<phrase module_id="mail" version_id="3.4.0rc1" var_name="legacy_inbox" added="1349866285">Legacy Inbox</phrase>
		<phrase module_id="mail" version_id="3.4.0" var_name="page_claim_message" added="1350911604"><![CDATA[Hello, I hereby claim the page "{title}" (URL: {url}) as my own and request your attention to the matter. I am able to provide any documentation that you may require.]]></phrase>
		<phrase module_id="mail" version_id="3.4.0" var_name="claiming_page_title" added="1350912704"><![CDATA[Claiming Page &#039;{title}&#039;]]></phrase>
		<phrase module_id="mail" version_id="3.5.0beta2" var_name="delete_conversation" added="1359462488">Delete Conversation</phrase>
		<phrase module_id="mail" version_id="3.5.1" var_name="conversation_successfully_deleted" added="1366631869">Conversation successfully deleted.</phrase>
		<phrase module_id="mail" version_id="3.5.1" var_name="who_can_share_blogs" added="1366632035">Who can share blogs</phrase>
		<phrase module_id="mail" version_id="3.5.1" var_name="who_can_view_blogs" added="1366632054">Who can view blogs</phrase>
		<phrase module_id="mail" version_id="3.7.1" var_name="mark_all_read" added="1381234465">Mark All As Read</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="mail" type="integer" admin="10" user="10" guest="0" staff="10" module="mail" ordering="0">total_folders</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="1" user="1" guest="0" staff="1" module="mail" ordering="0">can_compose_message</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="1" user="1" guest="0" staff="1" module="mail" ordering="0">can_add_folders</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="1" user="0" guest="0" staff="0" module="mail" ordering="0">show_core_mail_folders_item_count</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="1" user="1" guest="0" staff="1" module="mail" ordering="0">can_add_attachment_on_mail</setting>
		<setting is_admin_setting="0" module_id="mail" type="integer" admin="0" user="15" guest="0" staff="0" module="mail" ordering="0">mail_box_limit</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="true" user="false" guest="false" staff="true" module="mail" ordering="0">override_mail_box_limit</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="false" user="true" guest="true" staff="false" module="mail" ordering="0">restrict_message_to_friends</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="true" user="true" guest="false" staff="true" module="mail" ordering="0">can_message_self</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="true" user="false" guest="false" staff="true" module="mail" ordering="0">override_restrict_message_to_friends</setting>
		<setting is_admin_setting="0" module_id="mail" type="integer" admin="0" user="80" guest="01" staff="90" module="mail" ordering="0">mail_box_warning</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="true" user="true" guest="false" staff="true" module="mail" ordering="0">allow_delete_every_message</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="true" user="false" guest="false" staff="false" module="mail" ordering="0">can_read_private_messages</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="true" user="false" guest="false" staff="false" module="mail" ordering="0">can_delete_others_messages</setting>
		<setting is_admin_setting="0" module_id="mail" type="boolean" admin="0" user="0" guest="0" staff="0" module="mail" ordering="0">enable_captcha_on_mail</setting>
		<setting is_admin_setting="0" module_id="mail" type="integer" admin="0" user="50" guest="1" staff="100" module="mail" ordering="0">send_message_to_max_users_each_time</setting>
	</user_group_settings>
	<tables><![CDATA[a:8:{s:11:"phpfox_mail";a:3:{s:7:"COLUMNS";a:15:{s:7:"mail_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"mass_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"subject";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"preview";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"owner_user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"owner_folder_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"owner_type_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"viewer_user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:16:"viewer_folder_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"viewer_type_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"viewer_is_new";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"time_updated";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"total_attachment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"mail_id";s:4:"KEYS";a:4:{s:13:"owner_user_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:13:"owner_user_id";i:1;s:15:"owner_folder_id";i:2;s:13:"owner_type_id";}}s:14:"viewer_user_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:14:"viewer_user_id";i:1;s:16:"viewer_folder_id";i:2;s:14:"viewer_type_id";}}s:15:"owner_user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:13:"owner_user_id";i:1;s:14:"viewer_user_id";}}s:7:"mail_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"mail_id";i:1;s:13:"owner_user_id";}}}}s:18:"phpfox_mail_folder";a:3:{s:7:"COLUMNS";a:3:{s:9:"folder_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"folder_id";s:4:"KEYS";a:3:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:4:"name";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:4:"name";i:1;s:7:"user_id";}}s:9:"folder_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"folder_id";i:1;s:4:"name";}}}}s:16:"phpfox_mail_hash";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"item_hash";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:9:"item_hash";i:2;s:10:"time_stamp";}}}}s:16:"phpfox_mail_text";a:2:{s:7:"COLUMNS";a:3:{s:7:"mail_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"text_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"mail_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"mail_id";}}}s:18:"phpfox_mail_thread";a:3:{s:7:"COLUMNS";a:4:{s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"hash_id";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"last_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"thread_id";s:4:"KEYS";a:1:{s:7:"last_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"last_id";}}}s:26:"phpfox_mail_thread_forward";a:3:{s:7:"COLUMNS";a:3:{s:10:"forward_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"message_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"copy_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"forward_id";s:4:"KEYS";a:2:{s:10:"message_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"message_id";}s:7:"copy_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"copy_id";}}}s:23:"phpfox_mail_thread_text";a:3:{s:7:"COLUMNS";a:8:{s:10:"message_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:16:"total_attachment";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_mobile";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"has_forward";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"message_id";s:4:"KEYS";a:2:{s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"thread_id";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:23:"phpfox_mail_thread_user";a:2:{s:7:"COLUMNS";a:6:{s:9:"thread_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_read";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_archive";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_sent";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"is_sent_update";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:6:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:9:"thread_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"thread_id";i:1;s:7:"user_id";}}s:9:"user_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"is_sent";}}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:10:"is_archive";i:2;s:14:"is_sent_update";}}s:9:"user_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:10:"is_archive";i:2;s:7:"is_sent";}}s:9:"user_id_5";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:10:"is_archive";}}}}}]]></tables>
</module>