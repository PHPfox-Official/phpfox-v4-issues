<module>
	<data>
		<module_id>poll</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_poll</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:14:"file/pic/poll/";}]]></writable>
	</data>
	<menus>
		<menu module_id="poll" parent_var_name="" m_connection="main" var_name="menu_poll" ordering="24" url_value="poll" version_id="2.0.0alpha1" disallow_access="" module="poll" />
		<menu module_id="poll" parent_var_name="" m_connection="poll.index" var_name="menu_add_new_poll" ordering="39" url_value="poll.add" version_id="2.0.0alpha1" disallow_access="" module="poll" />
		<menu module_id="poll" parent_var_name="" m_connection="profile" var_name="menu_polls" ordering="41" url_value="profile.poll" version_id="2.0.0alpha1" disallow_access="" module="poll" />
		<menu module_id="poll" parent_var_name="" m_connection="mobile" var_name="menu_poll_polls_532c28d5412dd75bf975fb951c740a30" ordering="123" url_value="poll" version_id="3.1.0rc1" disallow_access="" module="poll" mobile_icon="small_polls.png" />
	</menus>
	<settings>
		<setting group="" module_id="poll" is_hidden="0" type="boolean" var_name="is_image_required" phrase_var_name="setting_is_image_required" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="poll" is_hidden="0" type="integer" var_name="poll_max_image_pic_size" phrase_var_name="setting_poll_max_image_pic_size" ordering="1" version_id="2.0.0alpha1">75</setting>
		<setting group="time_stamps" module_id="poll" is_hidden="0" type="string" var_name="poll_view_time_stamp" phrase_var_name="setting_poll_view_time_stamp" ordering="1" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="" module_id="poll" is_hidden="0" type="integer" var_name="polls_to_show" phrase_var_name="setting_polls_to_show" ordering="1" version_id="2.0.0alpha1">10</setting>
		<setting group="" module_id="poll" is_hidden="0" type="integer" var_name="show_x_users_who_took_poll" phrase_var_name="setting_show_x_users_who_took_poll" ordering="1" version_id="2.0.0beta3">10</setting>
		<setting group="search_engine_optimization" module_id="poll" is_hidden="0" type="large_string" var_name="poll_meta_description" phrase_var_name="setting_poll_meta_description" ordering="9" version_id="2.0.0rc1">New polls on Site Name daily.</setting>
		<setting group="search_engine_optimization" module_id="poll" is_hidden="0" type="large_string" var_name="poll_meta_keywords" phrase_var_name="setting_poll_meta_keywords" ordering="15" version_id="2.0.0rc1">poll, polls</setting>
	</settings>
	<hooks>
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_index_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_index_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_design_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_design_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_view_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_view_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_view_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_add_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_add_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_profile_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_profile_process_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="controller" module="poll" call_name="poll.component_controller_profile_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_ajax_addvote_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_ajax_addvote_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_ajax_moderatepoll_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_ajax_moderatepoll_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_block_new_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_block_vote_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_block_vote_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_add_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_add_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_moderate_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_moderate_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_hasuservoted_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_hasuservoted_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getpollbyid_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getpollbyid_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getpollbyurl_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getpollbyurl_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getpollbyuser_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getpolls_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getpolls_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getanswers_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getanswers_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getprofilelink_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getajaxcommentvar_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getcommentitem_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_addcomment_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_addcomment_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_deletecomment_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_deletecomment_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_processcommentmoderation_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_processcommentmoderation_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getcommentnewsfeed_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getcommentnewsfeed_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_addtrack_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_addtrack_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getlatesttrackusers_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getlatesttrackusers_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getcommentitemname_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="template" module="poll" call_name="poll.template_controller_add_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_ajax_deleteimage_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_ajax_deleteimage_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_block_votes_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_block_votes_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_deleteimage_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_deleteimage_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getVotedAnswersByUser_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getVotedAnswersByUser_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getnew_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_poll_getnew_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_add_ainsert" added="1286546859" version_id="2.0.7" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_add_insert_answer" added="1286546859" version_id="2.0.7" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_moderate_selected" added="1286546859" version_id="2.0.7" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_moderate_updated_activity" added="1286546859" version_id="2.0.7" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="poll" hook_type="component" module="poll" call_name="poll.component_block_share_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_browse__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_moderatepoll__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_deleteimage_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="poll" hook_type="service" module="poll" call_name="poll.service_process_addvote_1" added="1335951260" version_id="3.2.0" />
	</hooks>
	<components>
		<component module_id="poll" component="index" m_connection="poll.index" module="poll" is_controller="1" is_block="0" is_active="1" />
		<component module_id="poll" component="design" m_connection="poll.design" module="poll" is_controller="1" is_block="0" is_active="1" />
		<component module_id="poll" component="profile" m_connection="poll.profile" module="poll" is_controller="1" is_block="0" is_active="1" />
	</components>
	<stats>
		<stat module_id="poll" phrase_var="poll.stat_title_4" stat_link="poll" stat_image="poll.png" is_active="1"><![CDATA[$this->database()
->select('COUNT(*)')
->from(Phpfox::getT('poll'))
->where('view_id = 0')
->execute('getSlaveField');]]></stat>
	</stats>
	<feed_share>
		<share module_id="poll" title="{phrase var='poll.poll'}" description="{phrase var='poll.say_something_about_this_poll'}" block_name="share" no_input="1" is_frame="0" ajax_request="addViaStatusUpdate" no_profile="1" icon="poll.png" ordering="4" />
	</feed_share>
	<phrases>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="module_poll" added="1232964260">Polls</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="menu_poll" added="1232964276">Polls</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="menu_add_new_poll" added="1233240881">Add New Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="menu_polls" added="1233311326">Polls</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="setting_is_image_required" added="1234290147"><![CDATA[<title>Is Image Required</title><info>If set to true, users will have to upload an image with every poll they post.

By default is set to false, so they don't need to upload an image with their polls.</info>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_can_upload_image" added="1234356544">This setting defines if members of this usergroup can add images along with their polls.</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="setting_poll_max_image_pic_size" added="1234366729"><![CDATA[<title>Size of the poll image</title><info>When users upload an image with their polls this will be the maximum size for that picture, anything bigger will be resized</info>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_can_edit_own_poll" added="1234377080">Can members of this user group edit polls they have posted?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_can_change_own_vote" added="1234866837">Tells if a user group member can change its vote on a poll.

If set to false the first vote will be the definitive vote for that user and that poll.

If set to true users will be able to change their vote in the future.</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="poll_vote_updated" added="1234867333">You have successfully changed your vote for this poll</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="poll_new_vote_added_successfully" added="1234867509">Your vote has been added successfully</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="setting_poll_view_time_stamp" added="1234870704"><![CDATA[<title>Poll Time Stamp</title><info>This is the format used to display dates, it complies with http://php.net/date</info>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_flood_control" added="1234879747"><![CDATA[How often can members of this user group post new polls (in minutes).

0 => no restriction
1 => 1 minute
10 => 10 minutes]]></phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="poll_flood_control" added="1234879960">You can only post polls every {x} minutes.</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_requires_admin_moderation" added="1234881616">This setting tells if polls posted by members of this group will need to be moderated (approved) before being shown on the site.</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_can_moderate_polls" added="1234894665">Can members of this user group moderate polls? (delete, approve)</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_require_captcha_challenge" added="1234961189">Do members of this user group need to complete a captcha challenge to submit a poll?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_can_edit_own_polls" added="1234963511">Can members of this user group edit their own polls after submitted?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_can_edit_others_polls" added="1234983674"><![CDATA[Can members of this user group edit other member's polls?]]></phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_can_delete_own_polls" added="1234984289">can members of this user group delete their own polls?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_poll_can_delete_others_polls" added="1234987167">Can members of this user group delete polls posted by other members?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_can_post_comment_on_poll" added="1235390654">Can members of this user group post comments on polls?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_view_poll_results_after_vote" added="1235399479">When set to yes members of this user group will see the poll results right after voting.</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_maximum_answers_count" added="1235473759">How many answers can members of this user group add to their polls?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="setting_polls_to_show" added="1235572567"><![CDATA[<title>How many to show</title><info>This setting tells how many polls should be shown per page.</info>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_can_vote_in_own_poll" added="1235587145">Do you want to enable members of this user group to vote on their own polls?

This is different than changing their votes.</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha1" var_name="user_setting_points_poll" added="1236090929">how many points does adding a poll award?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha2" var_name="user_setting_can_view_user_poll_results_own_poll" added="1237745898">Can view what users have voted on their own poll?</phrase>
		<phrase module_id="poll" version_id="2.0.0alpha2" var_name="user_setting_can_view_user_poll_results_other_poll" added="1237745995">Can view users poll results on other polls?</phrase>
		<phrase module_id="poll" version_id="2.0.0beta3" var_name="user_setting_can_edit_title" added="1243320229">Can members of this user group edit the title, image, random setting, privacy setting and comment setting on a poll?

This may be overridden by the setting poll_can_edit_others_polls and the poll_can_edit_own_polls.

If this setting is disabled, users will not be able to change the colors in the poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0beta3" var_name="user_setting_can_edit_question" added="1243320278">Can members of this user group edit the question and answers of a poll?

This may be overridden by the setting poll_can_edit_others_polls and the poll_can_edit_own_polls</phrase>
		<phrase module_id="poll" version_id="2.0.0beta3" var_name="setting_show_x_users_who_took_poll" added="1243511926"><![CDATA[<title>How many takers to show</title><info>This setting tells how many users who have taken the poll should be shown in the poll page. 

Changing this setting affects the Members Votes mini section.</info>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0beta3" var_name="user_setting_view_poll_results_before_vote" added="1243520504"><![CDATA[Can members of this user group view poll results before voting on a poll?


Note that this setting may be overridden by the "poll.can_view_user_poll_results_own_poll" and the "poll.can_view_user_poll_results_other_poll" settings.
It can also be complemented with the setting "poll.view_poll_results_after_vote"]]></phrase>
		<phrase module_id="poll" version_id="2.0.0beta3" var_name="user_setting_highlight_answer_voted_by_viewer" added="1243596992">If set to yes the answer chosen by the viewer will be highlighted with a background color.

This is useful if you have it set so the members of this usegroup cant view the results after taking the poll as they still will be able to view their own answer.</phrase>
		<phrase module_id="poll" version_id="2.0.0beta4" var_name="stat_title_4" added="1245143660">Polls</phrase>
		<phrase module_id="poll" version_id="2.0.0rc1" var_name="setting_poll_meta_description" added="1252064414"><![CDATA[<title>Poll Meta Description</title><info>Meta description used for the Poll module.</info>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc1" var_name="setting_poll_meta_keywords" added="1252064465"><![CDATA[<title>Poll Meta Keywords</title><info>Meta keywords for the Poll module.</info>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="an_error_occured_and_your_image_could_not_be_deleted_please_try_again" added="1255170382">An error occurred and your image could not be deleted. Please try again.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="this_poll_is_being_moderated_and_no_votes_can_be_added_yet" added="1255170416">This poll is being moderated and no votes can be added yet.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="your_vote_has_successfully_been_cast" added="1255170427">Your vote has successfully been cast.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="poll_successfully_approved" added="1255170455">Poll successfully approved.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="poll_successfully_deleted" added="1255170466">Poll successfully deleted.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="there_was_a_problem_moderating_this_poll" added="1255170475">There was a problem moderating this poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="provide_a_question_for_your_poll" added="1255171716">Provide a question for your poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="image_is_required" added="1255171726">Image is required.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="your_user_group_lacks_permissions_to_edit_that_poll" added="1255171738">Your user group lacks permissions to edit that poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="that_poll_does_not_exist" added="1255171746">That poll does not exist.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="each_poll_requires_an_image" added="1255171757">Each poll requires an image.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="your_poll_has_been_updated" added="1255171768">Your poll has been updated.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="your_poll_has_been_added" added="1255171787">Your poll has been added.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="your_poll_needs_to_be_approved_before_being_shown_on_the_site" added="1255171818">Your poll needs to be approved before being shown on the site.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="your_poll_has_been_added_feel_free_to_custom_design_it_the_way_you_want_here" added="1255171832">Your poll has been added, feel free to custom design it the way you want here.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="editing_a_new_poll" added="1255171871">Editing a New Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="adding_a_new_poll" added="1255171883">Adding a New Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="editing_poll" added="1255171892">Editing Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="adding_poll" added="1255171902">Adding Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="polls" added="1255173283">Polls</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="that_poll_doesn_t_exist" added="1255173405"><![CDATA[That poll doesn't exist.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="you_do_not_have_permission_to_change_the_design_of_this_poll" added="1255173415">You do not have permission to change the design of this poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="your_design_has_been_updated" added="1255173455">Your design has been updated.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="error" added="1255173463">Error</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="there_are_no_answers_for_this_poll" added="1255173474">There are no answers for this poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="design_your_poll" added="1255173496">Design your poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="full_name_s_polls" added="1255173530"><![CDATA[{full_name}'s polls]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="full_name_s_polls_on_site_title_full_name_has_total_poll_s" added="1255173568"><![CDATA[{full_name}'s polls on {site_title}. {full_name} has {total} poll(s).]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="full_name_s_polls_upper" added="1255173688"><![CDATA[{full_name}'s Polls]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="unable_to_view_this_poll" added="1255173739">Unable to view this poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="full_name_s_poll_from_time_stamp_question" added="1255173901"><![CDATA[{full_name}'s poll from {time_stamp}: {question}.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title" added="1255174139">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title_to_view_this_comment_follow_the_link_below_a_href_link_link_a" added="1255174369"><![CDATA[{user_name} left you a comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title_however_before_it_can_be_displayed_it_needs_to_be_approved_by_you_you_can_approve_or_deny_this_comment_by_following_the_link_below_a_href_link_link_a" added="1255174466"><![CDATA[{user_name} left you a comment on {site_title}, however before it can be displayed it needs to be approved by you.

You can approve or deny this comment by following the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="on_name_s_poll" added="1255174523"><![CDATA[On {name}'s poll.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="full_name_approved_your_comment_on_site_title" added="1255174562">{full_name} approved your comment on {site_title}.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="full_name_approved_your_comment_on_site_title_message" added="1255174622"><![CDATA[{full_name} approved your comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_poll_a" added="1255174724"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">poll</a>.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_poll_a" added="1255174763"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">poll</a>.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link_item_user_name_s_a_a_href_title_link_poll_a" added="1255174808"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">poll</a>.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_poll_a_href_question_url_question_a" added="1255174875"><![CDATA[<a href="{user_link}">{full_name}</a> added a new poll "<a href="{question_url}">{question}</a>".]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="create_a_poll" added="1255174957">Create a Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="manage_polls" added="1255174964">Manage Polls</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="maximum_length_for_the_question_is_255_characters_and_it_cannot_be_empty" added="1255174984">Maximum length for the question is 255 characters and it cannot be empty.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="we_dont_allow_default_answers_answer" added="1255174998">We dont allow default answers ({answer}).</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="maximum_length_for_the_answers_is_150_characters" added="1255175017">Maximum length for the answers is 150 characters.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="you_need_to_write_at_least_2_answers" added="1255175025">You need to write at least 2 answers.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="insufficient_permissions_to_vote_on_this_poll" added="1255175086">Insufficient permissions to vote on this poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="only_friends_can_vote_on_this_poll" added="1255175103">Only friends can vote on this poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="you_have_reached_your_limit" added="1255175150">You have reached your limit.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="answer" added="1255175205">Answer</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="you_must_have_a_minimum_of_total_answers" added="1255175407">You must have a minimum of {total} answers.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="are_you_sure" added="1255175467">Are you sure?</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="poll_created_on_time_stamp_by_user_info" added="1255175511">Poll created on {time_stamp} by {user_info}.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="this_poll_is_being_moderated_and_no_votes_can_be_added_until_it_has_been_approved" added="1255175581">This poll is being moderated and no votes can be added until it has been approved.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="submit_your_vote" added="1255175597">Submit your Vote</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="cancel" added="1255175606">cancel</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="approve" added="1255175615">Approve</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="edit" added="1255175621">Edit</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="delete" added="1255175628">Delete</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="report_this_poll" added="1255175642">Report this Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="report" added="1255175648">Report</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="votes_total_votes" added="1255175662">Votes ({total_votes})</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="comments_total_comment" added="1255175682">Comments ({total_comment})</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="members_votes_total_votes" added="1255175708">Members Votes ({total_votes})</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="poll_designer" added="1255175724">Poll Designer</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="background" added="1255175738">Background</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="select_color" added="1255175759">Select Color</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="percent" added="1255175766">Percent</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="border" added="1255175781">Border</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="save" added="1255175789">Save</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="no_polls_have_been_added_yet" added="1255175819">No polls have been added yet.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="be_the_first_to_create_a_poll" added="1255175829">Be the First to Create a Poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="votes_0" added="1255175879">Votes (0)</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="total_votes_votes" added="1255175894">{total_votes} Votes</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="no_answers_to_show" added="1255175916">No answers to show.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="user_info_voted_answer_on_time_stamp" added="1255175946"><![CDATA[{user_info} voted "{answer}" on {time_stamp}.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="default_answer" added="1255175983">Default Answer</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="answers" added="1255176044">Answers</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="image" added="1255176132">Image</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1255176141">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="click_here_to_delete_this_image_and_upload_a_new_one_in_its_place" added="1255176228">Click here to delete this image and upload a new one in its place.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="save_and_design_this_poll" added="1255176241">Save and Design this Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="update" added="1255176248">Update</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="submit" added="1255176254">Submit</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="skip_and_design_this_poll" added="1255176261">Skip and Design this Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="additional_options" added="1255176271">Additional Options</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="randomize_answers" added="1255176303">Randomize Answers</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="yes" added="1255177470">Yes</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="no" added="1255177476">No</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="comments" added="1255177482">Comments</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="allow_comments" added="1255177491">Allow Comments</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="moderate_comments_first" added="1255177499">Moderate Comments First</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="no_comments" added="1255177507">No Comments</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="privacy" added="1255177514">Privacy</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="public_poll_will_be_added_to_our_public_poll_section" added="1255177525">Public (Poll will be added to our public poll section)</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="personal_poll_will_only_be_displayed_on_your_profile" added="1255177533">Personal (Poll will only be displayed on your profile)</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="friends_only_friends_can_view_this_poll" added="1255177541">Friends (Only friends can view this poll)</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="preferred_list_only_the_people_you_select_will_be_able_to_see_the_poll" added="1255177549">Preferred list (only the people you select will be able to see the poll)</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="you_have_not_added_any_polls" added="1255177760">You have not added any polls.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="add_a_new_poll" added="1255177767">Add a New Poll</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="user_info_has_not_added_any_polls" added="1255177778">{user_info} has not added any polls.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="browse_other_polls" added="1255177793">Browse Other Polls</phrase>
		<phrase module_id="poll" version_id="2.0.0rc4" var_name="be_the_first_to_add_a_poll" added="1255177809">Be the first to add a poll.</phrase>
		<phrase module_id="poll" version_id="2.0.0rc8" var_name="polls_activity" added="1258500499">Polls</phrase>
		<phrase module_id="poll" version_id="2.0.0rc8" var_name="question" added="1259076823">Question</phrase>
		<phrase module_id="poll" version_id="2.0.0rc11" var_name="user_setting_can_access_polls" added="1260276844">Can browse and view polls?</phrase>
		<phrase module_id="poll" version_id="2.0.0rc11" var_name="user_setting_can_create_poll" added="1260329272">Can create a poll?</phrase>
		<phrase module_id="poll" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_poll_a" added="1260464634"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">poll</a>.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_a_href_link_poll_a" added="1260464942"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">poll</a>.]]></phrase>
		<phrase module_id="poll" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_poll_a" added="1260464961"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">poll</a>.]]></phrase>
		<phrase module_id="poll" version_id="2.0.6" var_name="poll_results" added="1279631100">Poll Results</phrase>
		<phrase module_id="poll" version_id="2.0.6" var_name="public_votes" added="1283182388">Public Votes</phrase>
		<phrase module_id="poll" version_id="2.0.6" var_name="displays_all_users_who_voted_and_what_choice_they_voted_for" added="1283182519">Displays all users who voted, and what choice they voted for.</phrase>
		<phrase module_id="poll" version_id="2.0.6" var_name="user_setting_can_view_hidden_poll_votes" added="1283182954">Can view votes even if the poll is marked to hide votes? (Admin Option)</phrase>
		<phrase module_id="poll" version_id="2.0.6" var_name="votes_are_hidden_for_this_poll" added="1283183023">Votes are hidden for this poll.</phrase>
		<phrase module_id="poll" version_id="3.0.0Beta1" var_name="poll" added="1302203087">Poll</phrase>
		<phrase module_id="poll" version_id="3.0.0Beta1" var_name="say_something_about_this_poll" added="1302203094">Say something about this poll...</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="add_another_answer" added="1319122638">Add another answer</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="poll_has_been_approved" added="1319124211">Poll has been approved.</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="poll_approved" added="1319124218">Poll Approved</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="no_polls_found" added="1319197167">No polls found.</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="search_polls" added="1319197187">Search Polls...</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="latest" added="1319197194">Latest</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="most_viewed" added="1319197202">Most Viewed</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="most_liked" added="1319197209">Most Liked</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="most_discussed" added="1319197217">Most Discussed</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="all_polls" added="1319197479">All Polls</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="my_polls" added="1319197487">My Polls</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="friends_polls" added="1319197497"><![CDATA[Friends' Polls]]></phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="pending_polls" added="1319197505">Pending Polls</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="by" added="1319197535">by</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="actions" added="1319197551">Actions</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="moderate" added="1319197565">Moderate</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="view_results" added="1319197603">View Results</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="cannot_cast_a_vote_when_a_poll_is_pending_approval" added="1319197611">Cannot cast a vote when a poll is pending approval.</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="cancel_uppercase" added="1319197630">Cancel</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="control_who_can_see_this_poll" added="1319197666">Control who can see this poll.</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="comment_privacy" added="1319197673">Comment Privacy</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="control_who_can_comment_on_this_poll" added="1319197684">Control who can comment on this poll.</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="report_this_poll_lowercase" added="1319197738">Report this poll</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="view_poll" added="1319197854">View Poll</phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="full_name_liked_your_poll_question" added="1319467488"><![CDATA[{full_name} liked your poll "{question}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0beta5" var_name="full_name_liked_your_poll_question_message" added="1319468144"><![CDATA[{full_name} liked your poll "<a href="{link}">{question}</a>"
To view this poll follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="full_name_voted_on_your_poll_question" added="1322467444"><![CDATA[{full_name} voted on your poll "{question}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="full_name_voted_answer_on_your_poll_question" added="1322467707"><![CDATA[{full_name} voted "{answer}" on your poll "{question}"
To view this poll follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1322651650">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="posted_a_comment_on_gender_poll_a_href_link_title_a" added="1322651748"><![CDATA[posted a comment on {gender} poll "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="posted_a_comment_on_user_name_s_poll_a_href_link_title_a" added="1322651829"><![CDATA[posted a comment on {user_name}'s poll "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="full_name_commented_on_one_of_your_polls_title" added="1322651995"><![CDATA[{full_name} commented on one of your polls "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="full_name_commented_on_your_poll_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322652479"><![CDATA[{full_name} commented on your poll "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="full_name_commented_on_gender_poll" added="1322652605">{full_name} commented on {gender} poll.</phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_poll" added="1322652759"><![CDATA[{full_name} commented on {other_full_name}'s poll.]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="full_name_commented_on_gender_poll_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322652939"><![CDATA[{full_name} commented on {gender} poll "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_poll_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322654278"><![CDATA[{full_name} commented on {other_full_name}'s poll "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_commented_on_gender_poll_title" added="1322654449"><![CDATA[{user_name} commented on {gender} poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_commented_on_your_poll_title" added="1322654556"><![CDATA[{user_name} commented on your poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_commented_on_span_class_drop_data_user_full_name_s_span_poll_title" added="1322654649"><![CDATA[{user_name} commented on <span class="drop_data_user">{full_name}'s</span> poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_voted_on_gender_poll_title" added="1322654843"><![CDATA[{user_name} voted on {gender} poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_voted_on_your_poll_title" added="1322655354"><![CDATA[{user_name} voted on your poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_voted_on_span_class_drop_data_user_full_name_s_span_poll_title" added="1322655509"><![CDATA[{user_name} voted on <span class="drop_data_user">{full_name}'s</span> poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_liked_gender_own_poll_title" added="1322655705"><![CDATA[{user_name} liked {gender} own poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_liked_your_poll_title" added="1322655801"><![CDATA[{user_name} liked your poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="user_name_liked_span_class_drop_data_user_full_name_span_poll_title" added="1322655913"><![CDATA[{user_name} liked <span class="drop_data_user">{full_name}</span> poll "{title}"]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="your_poll_title_has_been_approved" added="1322656009"><![CDATA[Your poll "{title}" has been approved.]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="poll_s_successfully_approved" added="1322740778">Poll(s) successfully approved.</phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="poll_s_successfully_deleted" added="1322740791">Poll(s) successfully deleted.</phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="background_chooser" added="1322741043">Background Chooser</phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="percentage_chooser" added="1322741062">Percentage Chooser</phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="border_chooser" added="1322741076">Border Chooser</phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="your_poll_a_href_link_title_a_has_been_approved_to_view_this_poll_follow_the_link_below_a_href_link_link_a" added="1323086113"><![CDATA[Your poll "<a href="{link}">{title}</a>" has been approved.
To view this poll follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poll" version_id="3.0.0" var_name="unable_to_find_this_poll" added="1323086202">Unable to find this poll.</phrase>
		<phrase module_id="poll" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_a_poll" added="1331221318">{user_name} tagged you in a comment in a poll</phrase>
		<phrase module_id="poll" version_id="3.1.0rc1" var_name="menu_poll_polls_532c28d5412dd75bf975fb951c740a30" added="1332257923">Polls</phrase>
		<phrase module_id="poll" version_id="3.5.0beta1" var_name="item_phrase" added="1352730674">poll</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="1" user="1" guest="0" staff="1" module="poll" ordering="0">poll_can_upload_image</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="false" guest="false" staff="true" module="poll" ordering="0">view_poll_results_before_vote</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="false" guest="false" staff="true" module="poll" ordering="0">poll_can_change_own_vote</setting>
		<setting is_admin_setting="0" module_id="poll" type="integer" admin="0" user="1" guest="9999999" staff="1" module="poll" ordering="0">poll_flood_control</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="false" user="false" guest="true" staff="false" module="poll" ordering="0">poll_requires_admin_moderation</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="1" user="0" guest="0" staff="1" module="poll" ordering="0">poll_can_moderate_polls</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="false" user="false" guest="true" staff="false" module="poll" ordering="0">poll_require_captcha_challenge</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="true" guest="false" staff="true" module="poll" ordering="0">poll_can_edit_own_polls</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="false" guest="false" staff="true" module="poll" ordering="0">poll_can_edit_others_polls</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="true" guest="false" staff="true" module="poll" ordering="0">poll_can_delete_own_polls</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="false" guest="false" staff="true" module="poll" ordering="0">poll_can_delete_others_polls</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="true" guest="true" staff="true" module="poll" ordering="0">can_post_comment_on_poll</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="true" guest="false" staff="true" module="poll" ordering="0">view_poll_results_after_vote</setting>
		<setting is_admin_setting="0" module_id="poll" type="integer" admin="20" user="6" guest="0" staff="10" module="poll" ordering="0">maximum_answers_count</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="true" guest="false" staff="true" module="poll" ordering="0">can_vote_in_own_poll</setting>
		<setting is_admin_setting="0" module_id="poll" type="integer" admin="5" user="1" guest="0" staff="3" module="poll" ordering="0">points_poll</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="1" user="1" guest="0" staff="1" module="poll" ordering="0">can_view_user_poll_results_own_poll</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="1" user="1" guest="" staff="1" module="poll" ordering="0">can_view_user_poll_results_other_poll</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="true" guest="false" staff="true" module="poll" ordering="0">can_edit_title</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="false" guest="false" staff="false" module="poll" ordering="0">can_edit_question</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="true" user="true" guest="false" staff="true" module="poll" ordering="0">highlight_answer_voted_by_viewer</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="1" user="1" guest="1" staff="1" module="poll" ordering="0">can_access_polls</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="1" user="1" guest="0" staff="1" module="poll" ordering="0">can_create_poll</setting>
		<setting is_admin_setting="0" module_id="poll" type="boolean" admin="1" user="0" guest="0" staff="1" module="poll" ordering="0">can_view_hidden_poll_votes</setting>
	</user_group_settings>
	<tables><![CDATA[a:5:{s:11:"phpfox_poll";a:3:{s:7:"COLUMNS";a:17:{s:7:"poll_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"question";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"randomize";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:9:"hide_vote";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"poll_id";s:4:"KEYS";a:4:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"item_id";i:1;s:7:"view_id";i:2;s:7:"privacy";}}s:9:"item_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"item_id";i:1;s:7:"user_id";i:2;s:7:"view_id";i:3;s:7:"privacy";}}s:9:"item_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"item_id";i:1;s:7:"view_id";i:2;s:8:"question";i:3;s:7:"privacy";}}}}s:18:"phpfox_poll_answer";a:3:{s:7:"COLUMNS";a:5:{s:9:"answer_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"poll_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"answer";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_votes";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"answer_id";s:4:"KEYS";a:2:{s:7:"poll_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"poll_id";}s:9:"answer_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"answer_id";i:1;s:7:"poll_id";}}}}s:18:"phpfox_poll_result";a:2:{s:7:"COLUMNS";a:4:{s:7:"poll_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"answer_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:3:{s:7:"poll_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"poll_id";}s:10:"user_voted";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"poll_id";i:1;s:7:"user_id";}}s:9:"answer_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"answer_id";i:1;s:7:"user_id";}}}}s:18:"phpfox_poll_design";a:3:{s:7:"COLUMNS";a:4:{s:7:"poll_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"background";a:4:{i:0;s:7:"VCHAR:6";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"percentage";a:4:{i:0;s:7:"VCHAR:6";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"border";a:4:{i:0;s:7:"VCHAR:6";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:7:"poll_id";s:4:"KEYS";a:1:{s:10:"background";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:10:"background";i:1;s:10:"percentage";i:2;s:6:"border";}}}}s:17:"phpfox_poll_track";a:2:{s:7:"COLUMNS";a:3:{s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}}]]></tables>
</module>