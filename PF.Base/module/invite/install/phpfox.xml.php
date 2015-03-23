<module>
	<data>
		<module_id>invite</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_invite</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="invite" parent_var_name="" m_connection="footer" var_name="menu_invite" ordering="30" url_value="invite" version_id="2.0.0alpha1" disallow_access="" module="invite" />
		<menu module_id="invite" parent_var_name="" m_connection="invite" var_name="menu_pending_invitations" ordering="45" url_value="invite.invitations" version_id="2.0.0alpha1" disallow_access="" module="invite" />
		<menu module_id="invite" parent_var_name="" m_connection="invite" var_name="menu_invite_friends" ordering="44" url_value="invite" version_id="2.0.0alpha1" disallow_access="" module="invite" />
	</menus>
	<settings>
		<setting group="" module_id="invite" is_hidden="0" type="integer" var_name="invite_expire" phrase_var_name="setting_invite_expire" ordering="1" version_id="2.0.0alpha1">7</setting>
		<setting group="" module_id="invite" is_hidden="0" type="integer" var_name="pendings_to_show_per_page" phrase_var_name="setting_pendings_to_show_per_page" ordering="1" version_id="2.0.0alpha1">9</setting>
		<setting group="" module_id="invite" is_hidden="0" type="boolean" var_name="check_duplicate_invites" phrase_var_name="setting_check_duplicate_invites" ordering="1" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="invite" is_hidden="0" type="boolean" var_name="make_friends_on_invitee_registration" phrase_var_name="setting_make_friends_on_invitee_registration" ordering="1" version_id="2.0.0alpha1">1</setting>
	</settings>
	<hooks>
		<hook module_id="invite" hook_type="controller" module="invite" call_name="invite.component_controller_index_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="invite" hook_type="controller" module="invite" call_name="invite.component_controller_index_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="invite" hook_type="controller" module="invite" call_name="invite.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="invite" hook_type="controller" module="invite" call_name="invite.component_controller_invitations_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="invite" hook_type="service" module="invite" call_name="invite.service_invite__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="invite" hook_type="service" module="invite" call_name="invite.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="invite" hook_type="service" module="invite" call_name="invite.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="invite" hook_type="template" module="invite" call_name="invite.template_controller_index_h3_start" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="invite" hook_type="controller" module="invite" call_name="invite.component_controller_index_process_send" added="1276177474" version_id="2.0.5" />
	</hooks>
	<components>
		<component module_id="invite" component="find" m_connection="" module="invite" is_controller="0" is_block="1" is_active="1" />
		<component module_id="invite" component="index" m_connection="invite.index" module="invite" is_controller="1" is_block="0" is_active="1" />
		<component module_id="invite" component="invitations" m_connection="invite.invitations" module="invite" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="invite" version_id="2.0.0alpha1" var_name="module_invite" added="1232964659">Invite</phrase>
		<phrase module_id="invite" version_id="2.0.0alpha1" var_name="menu_invite" added="1232964676">Invite</phrase>
		<phrase module_id="invite" version_id="2.0.0alpha1" var_name="menu_pending_invitations" added="1235390476">Pending Invitations</phrase>
		<phrase module_id="invite" version_id="2.0.0alpha1" var_name="menu_invite_friends" added="1235390890">Invite Friends</phrase>
		<phrase module_id="invite" version_id="2.0.0alpha1" var_name="setting_invite_expire" added="1236536751"><![CDATA[<title>Expire invites timeout</title><info>How many days is an invite valid for?

Note: this relies on cookies.</info>]]></phrase>
		<phrase module_id="invite" version_id="2.0.0alpha1" var_name="setting_pendings_to_show_per_page" added="1237058214"><![CDATA[<title>How Many Pendings To Show</title><info>This tells how many pending invites to show per page.</info>]]></phrase>
		<phrase module_id="invite" version_id="2.0.0alpha1" var_name="setting_check_duplicate_invites" added="1237283223"><![CDATA[<title>Check Duplicate Invites</title><info>Do you want the site to check for duplicate invites before sending mail invites?
This can avoid spamming (userA, userB and userC know personA, they all 3 send an invite so personA receives 3 emails) but can also slow down a little the process</info>]]></phrase>
		<phrase module_id="invite" version_id="2.0.0alpha1" var_name="setting_make_friends_on_invitee_registration" added="1237540055"><![CDATA[<title>Make invited users friends with their host</title><info>When a user invites aPerson and aPerson becomes a member, should they be made friends right then?</info>]]></phrase>
		<phrase module_id="invite" version_id="2.0.0alpha2" var_name="user_setting_points_invite" added="1237542827">How many points the invitee and the inviter will receive upon a successfully request.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="find_friends" added="1254984401">Find Friends</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="full_name_invites_you_to_site_title" added="1254984544">{full_name} invites you to {site_title}.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="full_name_invites_you_to_site_title_link" added="1254984752"><![CDATA[{full_name} invites you to {site_title}.

To check out this invitation, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="invite_s_were_not_sent_due_to_that_the_email_s" added="1254984797">Invite(s) were not sent due to that the email(s) were invalid or you have already sent an invitation to the email(s).</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="your_friends_have_successfully_been_invited" added="1254984809">Your friends have successfully been invited.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="invite_your_friends" added="1254984820">Invite your Friends</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="invitation_deleted" added="1254984836">Invitation deleted.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="invitation_not_found" added="1254984843">Invitation not found.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="pending_invitations" added="1254984862">Pending Invitations</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="search_by_name_or_email" added="1254984970">Search by name or email.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="search" added="1254984979">Search</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="skip_this_step" added="1255000683">Skip This Step</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="you_have_successfully_sent_an_invitation_to" added="1255000692">You have successfully sent an invitation to</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="your_friend_will_automatically_be_added_to_your_friends_list_when_they_join" added="1255000702">Your friend will automatically be added to your friends list when they join!</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="invite_your_friends_to_b_title_b" added="1255000903"><![CDATA[Invite your friends to <b>{title}</b>.]]></phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="email_your_friends" added="1255000927">Email your Friends</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="subject" added="1255000934">Subject</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="from" added="1255000941">From</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="to" added="1255000951">To</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="full_name_invites_you_to_title" added="1255000987">{full_name} invites you to {title}.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="separate_multiple_emails_with_a_comma" added="1255001011">Separate multiple emails with a comma.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="send_invitation_s" added="1255001022">Send Invitation(s)</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="send_a_custom_invitation_link" added="1255001031">Send a Custom Invitation Link</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="send_friends_your_custom_invitation_link_by_copy_and_pasting_it_into_your_own_email_application" added="1255001053">Send friends your custom invitation link by copy and pasting it into your own email application. When your friend joins</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="select" added="1255001064">Select</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="none" added="1255001072">None</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="all" added="1255001078">All</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="delete" added="1255001085">Delete</phrase>
		<phrase module_id="invite" version_id="2.0.0rc4" var_name="there_are_no_pending_invitations" added="1255009666">There are no pending invitations.</phrase>
		<phrase module_id="invite" version_id="2.0.0rc8" var_name="invites" added="1258500553">Invites</phrase>
		<phrase module_id="invite" version_id="2.0.0rc8" var_name="the_following_emails_were_not_sent" added="1258755327">The following emails were not sent</phrase>
		<phrase module_id="invite" version_id="2.0.0rc8" var_name="you_have_already_invited" added="1258755409">You have already invited</phrase>
		<phrase module_id="invite" version_id="2.0.0rc8" var_name="not_a_valid_email" added="1258755419">Not a valid email</phrase>
		<phrase module_id="invite" version_id="3.0.0beta5" var_name="successfully_removed_invites" added="1319184093">Successfully removed invites.</phrase>
		<phrase module_id="invite" version_id="3.0.0beta5" var_name="moderation" added="1319184099">Moderation</phrase>
		<phrase module_id="invite" version_id="3.3.0beta2" var_name="unable_to_find_your_invitation" added="1340288672">Unable to find your invitation.</phrase>
		<phrase module_id="invite" version_id="3.3.0beta2" var_name="this_email_is_already_registered_within_our_community" added="1340288682">This email is already registered within our community.</phrase>
		<phrase module_id="invite" version_id="3.7.3" var_name="already_invited" added="1384264138">Already invited</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="invite" type="integer" admin="1" user="1" guest="0" staff="1" module="invite" ordering="0">points_invite</setting>
	</user_group_settings>
	<tables><![CDATA[a:1:{s:13:"phpfox_invite";a:3:{s:7:"COLUMNS";a:5:{s:9:"invite_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"email";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_used";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"invite_id";s:4:"KEYS";a:2:{s:5:"email";a:2:{i:0;s:5:"INDEX";i:1;s:5:"email";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:5:"email";}}}}}]]></tables>
</module>