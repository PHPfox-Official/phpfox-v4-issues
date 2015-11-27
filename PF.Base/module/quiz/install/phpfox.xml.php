<module>
	<data>
		<module_id>quiz</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_quiz</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:14:"file/pic/quiz/";}]]></writable>
	</data>
	<menus>
		<menu module_id="quiz" parent_var_name="" m_connection="main" var_name="menu_quiz" ordering="7" url_value="quiz" version_id="2.0.0alpha1" disallow_access="" module="quiz" mobile_icon="puzzle-piece" />
		<menu module_id="quiz" parent_var_name="" m_connection="profile" var_name="menu_profile_quiz" ordering="48" url_value="profile.quiz" version_id="2.0.0alpha1" disallow_access="" module="quiz" />
		<menu module_id="quiz" parent_var_name="" m_connection="quiz" var_name="menu_add_new_quiz" ordering="49" url_value="quiz.add" version_id="2.0.0alpha1" disallow_access="" module="quiz" />
		<menu module_id="quiz" parent_var_name="" m_connection="mobile" var_name="menu_quiz_quizzes_532c28d5412dd75bf975fb951c740a30" ordering="125" url_value="quiz" version_id="3.1.0rc1" disallow_access="" module="quiz" mobile_icon="small_quizzes.png" />
	</menus>
	<settings>
		<setting group="" module_id="quiz" is_hidden="0" type="integer" var_name="quizzes_to_show" phrase_var_name="setting_quizzes_to_show" ordering="1" version_id="2.0.0alpha1">10</setting>
		<setting group="" module_id="quiz" is_hidden="0" type="string" var_name="quiz_view_time_stamp" phrase_var_name="setting_quiz_view_time_stamp" ordering="1" version_id="2.0.0alpha1">F j, Y</setting>
		<setting group="" module_id="quiz" is_hidden="0" type="integer" var_name="default_answers_count" phrase_var_name="setting_default_answers_count" ordering="1" version_id="2.0.0alpha1">4</setting>
		<setting group="" module_id="quiz" is_hidden="0" type="boolean" var_name="show_percentage_in_track" phrase_var_name="setting_show_percentage_in_track" ordering="1" version_id="2.0.0alpha3">1</setting>
		<setting group="" module_id="quiz" is_hidden="0" type="boolean" var_name="show_percentage_in_results" phrase_var_name="setting_show_percentage_in_results" ordering="1" version_id="2.0.0alpha3">1</setting>
		<setting group="" module_id="quiz" is_hidden="0" type="integer" var_name="takers_to_show" phrase_var_name="setting_takers_to_show" ordering="1" version_id="2.0.0beta2">5</setting>
		<setting group="" module_id="quiz" is_hidden="0" type="integer" var_name="quiz_max_image_pic_size" phrase_var_name="setting_quiz_max_image_pic_size" ordering="1" version_id="2.0.0beta3">75</setting>
		<setting group="" module_id="quiz" is_hidden="1" type="large_string" var_name="quiz_meta_keywords" phrase_var_name="setting_quiz_meta_keywords" ordering="10" version_id="2.0.0rc1">quiz, test, online, quizzes, tests, free, cool, fun</setting>
		<setting group="" module_id="quiz" is_hidden="1" type="large_string" var_name="quiz_meta_description" phrase_var_name="setting_quiz_meta_description" ordering="16" version_id="2.0.0rc1"><![CDATA[Take Free Fun Quizzes & Tests. Cool Online Fun Quiz & Test. Fun Quizzes and Fun Tests by Site Name.]]></setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="quiz.view" module_id="quiz" component="stat" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="quiz" hook_type="controller" module="quiz" call_name="quiz.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="controller" module="quiz" call_name="quiz.component_controller_view_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="controller" module="quiz" call_name="quiz.component_controller_add_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="controller" module="quiz" call_name="quiz.component_controller_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="controller" module="quiz" call_name="quiz.component_controller_profile_process_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="controller" module="quiz" call_name="quiz.component_controller_profile_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="component" module="quiz" call_name="quiz.component_block_stat_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_quiz_get_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_quiz_getquizbyurl_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_quiz__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.component_service_callback_addtrack_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.component_service_callback_addtrack_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="quiz" hook_type="component" module="quiz" call_name="quiz.component_ajax_deleteimage_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="quiz" hook_type="component" module="quiz" call_name="quiz.component_ajax_deleteimage_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process_deleteimage_start" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process_deleteimage_end" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process_add__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="quiz" hook_type="controller" module="quiz" call_name="quiz.component_controller_profile_process_end" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_browse__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process_answerquiz_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process_approvequiz_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process_update_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process_deleteimage_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="quiz" hook_type="service" module="quiz" call_name="quiz.service_process_deletequiz_1" added="1335951260" version_id="3.2.0" />
		<hook module_id="quiz" hook_type="controller" module="quiz" call_name="quiz.component_controller_view_process_end" added="1395674818" version_id="3.7.6rc1" />
	</hooks>
	<components>
		<component module_id="quiz" component="profile" m_connection="quiz.profile" module="quiz" is_controller="1" is_block="0" is_active="1" />
		<component module_id="quiz" component="view" m_connection="quiz.view" module="quiz" is_controller="1" is_block="0" is_active="1" />
		<component module_id="quiz" component="stat" m_connection="" module="quiz" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="module_quiz" added="1232964526">Quizzes</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="menu_quiz" added="1232964544">Quizzes</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="menu_add_new_quiz" added="1236280629">Add New Quiz</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="setting_quizzes_to_show" added="1236538181"><![CDATA[<title>Quizzes to show</title><info>How many quizzes to show on the main page of the quizzes section</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="setting_quiz_view_time_stamp" added="1236760605"><![CDATA[<title>Quiz Time Stamp</title><info>This is the format used to display dates, it complies with http://php.net/date</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="setting_default_answers_count" added="1236763431"><![CDATA[<title>How Many Answers Per Default</title><info>When adding a new question in a quiz how many answer fields to show</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_max_questions" added="1236783840">How many questions can a new Quiz (created by a member of this user group) have.</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_min_questions" added="1236783905">How many questions is the least a Quiz (created by members of this user group) can have.</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_max_answers" added="1236785889">How many answers maximum can each question in a quiz have</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_min_answers" added="1236785965">How many answers (minimum) can a question in a quiz have?</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_can_answer_own_quiz" added="1236943951">Can users answer their own quizzes?</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_can_approve_quizzes" added="1237047092">Are members of this group able to approve quizzes</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_can_delete_others_quizzes" added="1237047540"><![CDATA[Can members of this user group delete other people's quizzes]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_new_quizzes_need_moderation" added="1237048619">Do quizzes from user group need to be moderated before being shown?</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha1" var_name="user_setting_can_delete_own_quiz" added="1237552548">Allow users from this user group to delete their own quizzes?</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha3" var_name="setting_show_percentage_in_track" added="1238587346"><![CDATA[<title>Show success as percentage in Tracker</title><info>In the block "Recently Taken By" set this to true if you want the success of each user to be shown as a percentage:
75%

If you set it to false it will be shown as correct vs total answers:
3/4</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha3" var_name="setting_show_percentage_in_results" added="1238587985"><![CDATA[<title>Show success as percentage in Results</title><info>When viewing "Users Results" if you set this to true you will see results as a percentage:
75%

If you set it to false you will see results as correct vs total:
3/4</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha3" var_name="user_setting_can_post_comment_on_quiz" added="1238667312">Can members of this user group post comments on quizzes?</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha3" var_name="user_setting_can_edit_own_questions" added="1238755312">This setting tells if members of this user group can edit questions and answers in their own quizzes.</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha3" var_name="user_setting_can_edit_others_questions" added="1238755426">This setting tells if users of this user group can edit the questions and answers in quizzes made by other users.</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha3" var_name="user_setting_can_edit_own_title" added="1238755519">This setting tells if members of this user group can edit the title, description and privacy settings in quizzes they posted.</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha3" var_name="user_setting_can_edit_others_title" added="1238755589">This setting tells if members of this user group can edit the title, description and privacy settings in quizzes posted by other members.</phrase>
		<phrase module_id="quiz" version_id="2.0.0alpha3" var_name="user_setting_points_quiz" added="1239114765">How many points to award per new quiz.</phrase>
		<phrase module_id="quiz" version_id="2.0.0beta2" var_name="setting_takers_to_show" added="1242300171"><![CDATA[<title>Recent Takers To Show</title><info>On the "Recently Taken By" box, when viewing the results of one specific quiz, how many results do you want to show?</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0beta2" var_name="user_setting_can_view_results_before_answering" added="1242303282">If this option is enabled members of this user group will be able to view what other users answered in a quiz before they answer the quiz themselves.</phrase>
		<phrase module_id="quiz" version_id="2.0.0beta3" var_name="user_setting_can_upload_picture" added="1243866546">Can members of this user group upload a picture along with the quiz?</phrase>
		<phrase module_id="quiz" version_id="2.0.0beta3" var_name="user_setting_is_picture_upload_required" added="1243866831"><![CDATA[Is it a requirement to upload a picture with the quiz?

Be careful as this setting along with the "quiz.can_upload_picture" could keep members from uploading any quiz (having is_picture_upload_required enabled but can_upload_picture disabled would render a useless add quiz page because of the mutual exclusion)]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0beta3" var_name="setting_quiz_max_image_pic_size" added="1243867563"><![CDATA[<title>Size of Uploaded Picture</title><info>When users upload an image with their quizzes this will be the maximum size for that picture, anything bigger will be resized.</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc1" var_name="setting_quiz_meta_keywords" added="1252130471"><![CDATA[<title>Quiz Meta Keywords</title><info>Meta keywords used within quiz related sections.</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc1" var_name="setting_quiz_meta_description" added="1252130542"><![CDATA[<title>Quiz Meta Description</title><info>Meta description used for quiz related sections.</info>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc1" var_name="menu_profile_quiz" added="1252158191">Quizzes</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="an_error_occured_and_your_image_could_not_be_deleted_please_try_again" added="1255179090">An error occurred and your image could not be deleted. Please try again.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="quiz_approved" added="1255179107">Quiz Approved</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="an_error_kept_the_system_from_approving_the_quiz_please_try_again" added="1255179118">An error kept the system from approving the quiz, please try again.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="your_membership_does_not_allow_you_to_delete_this_quiz" added="1255179144">Your membership does not allow you to delete this quiz.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="recently_taken_by" added="1255179158">Recently Taken By</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="view_more" added="1255179167">View More</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="that_quiz_does_not_exist_or_its_awaiting_moderation" added="1255179184">That quiz does not exist or its awaiting moderation.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="your_quiz_has_been_edited" added="1255179193">Your quiz has been edited.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="edit_quiz" added="1255179332">Edit Quiz</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="add_new_quiz" added="1255179343">Add New Quiz</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_need_to_write_a_title" added="1255179355">You need to write a title.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_need_to_write_a_description" added="1255179363">You need to write a description.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="do_you_want_to_allow_comments" added="1255179371">Do you want to allow comments?</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="is_this_quiz_public_for_friends_only_or_a_specific_list_of_members" added="1255179383">Is this quiz public, for friends only or a specific list of members?</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="your_quiz_has_been_added_it_needs_to_be_approved_by_our_staff_before_it_can_be_shown" added="1255179396">Your quiz has been added. It needs to be approved by our staff before it can be shown.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="your_quiz_has_been_added" added="1255179405">Your quiz has been added.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="there_was_an_error_with_your_quiz_please_try_again" added="1255179415">There was an error with your quiz, please try again.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_are_not_allowed_to_edit_this_quiz" added="1255179426">You are not allowed to edit this quiz.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="full_name_s_quizzes" added="1255179462"><![CDATA[{full_name}'s Quizzes]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="quizzes" added="1255179484">Quizzes</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_have_already_answered_this_quiz" added="1255179499">You have already answered this quiz.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_have_to_answer_the_questions_if_you_want_to_do_that" added="1255179510">You have to answer the questions if you want to do that.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_are_not_allowed_to_answer_your_own_quiz" added="1255179519">You are not allowed to answer your own quiz.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="your_answers_have_been_submitted_and_your_score_is_score" added="1255179553">Your answers have been submitted and your score is {score}%</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_need_to_answer_the_quiz_before_looking_at_the_results" added="1255179603">You need to answer the quiz before looking at the results.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="full_name_s_quiz_from_time_stamp_title" added="1255179676"><![CDATA[{full_name}'s quiz from {time_stamp}: {title}.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_quiz_a_href_question_url_question_a" added="1255179742"><![CDATA[<a href="{user_link}">{full_name}</a> added a new quiz "<a href="{question_url}">{question}</a>".]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_quiz_a" added="1255180630"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">quiz</a>.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_quiz_a" added="1255180721"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">quiz</a>.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link_item_user_name_s_a_a_href_title_link_quiz_a" added="1255180745"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">quiz</a>.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="full_name_approved_your_comment_on_site_title" added="1255180828">{full_name} approved your comment on {site_title}.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="full_name_approved_your_comment_on_site_title_message" added="1255180889"><![CDATA[{full_name} approved your comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title" added="1255180942">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title_message" added="1255180994"><![CDATA[{user_name} left you a comment on {site_title}.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title_however_before_it_can_be_displayed_it_needs_to_be_approved_by_you_you_can_approve_or_deny_this_comment_by_following_the_link_below_a_href_link_link_a" added="1255181069"><![CDATA[{user_name} left you a comment on {site_title}, however before it can be displayed it needs to be approved by you.

You can approve or deny this comment by following the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="on_name_s_quiz" added="1255181115"><![CDATA[On {name}'s quiz.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="create_a_quiz" added="1255181137">Create a Quiz</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="manage_quizzes" added="1255181145">Manage Quizzes</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_cannot_answer_a_quiz_that_has_not_been_approved" added="1255181166">You cannot answer a quiz that has not been approved.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_need_to_answer_every_question" added="1255181174">You need to answer every question.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_cannot_answer_your_own_quiz" added="1255181186">You cannot answer your own quiz.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_do_not_have_the_permission_to_edit_this_quiz" added="1255181213">You do not have the permission to edit this quiz.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="answer" added="1255181259">Answer</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="we_do_not_allow_empty_answers" added="1255181274">We do not allow empty answers.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="we_do_not_allow_default_answers_answer" added="1255181295">We do not allow default answers ({answer}).</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="the_question_field_cannot_be_empty" added="1255181314">The question field cannot be empty.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_need_to_set_at_least_one_correct_answer_per_question" added="1255181324">You need to set at least one correct answer per question.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_need_to_add_a_minimum_of_min_and_a_maximum_of_max_questions_per_quiz_you_submitted_total" added="1255181354">You need to add a minimum of {min} and a maximum of {max} questions per quiz. You submitted {total}.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_need_to_add_a_minimum_of_2_answers_in_each_question" added="1255181393">You need to add a minimum of 2 answers in each question.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="not_answered" added="1255181413">Not answered</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_have_reached_the_maximum_questions_allowed_per_quiz" added="1255181465">You have reached the maximum questions allowed per quiz.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_are_required_a_minimum_of_total_questions" added="1255181503">You are required a minimum of {total} questions.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_have_reached_the_maximum_answers_allowed_per_question" added="1255181539">You have reached the maximum answers allowed per question.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_are_required_a_minimum_of_total_answers_per_question" added="1255181567">You are required a minimum of {total} answers per question.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="are_you_sure" added="1255181599">Are you sure?</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="delete" added="1255181638">Delete</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="are_you_sure_you_want_to_delete_this_quiz" added="1255181693">Are you sure you want to delete this quiz?</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="quiz_created_on_time_stamp_by_user_info" added="1255328471">Quiz created on {time_stamp} by {user_info}.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="quiz_created_on_time_stamp" added="1255328503">Quiz created on {time_stamp}.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="this_quiz_is_awaiting_moderation" added="1255328532">This quiz is awaiting moderation.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="view" added="1255328556">View</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="be_the_first_to_answer_this_quiz" added="1255328565">Be the first to answer this quiz</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="submit_your_answers" added="1255328586">Submit Your Answers</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="approve" added="1255328597">Approve</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="results" added="1255328626">Results</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="take" added="1255328638">Take</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="edit" added="1255328646">Edit</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="question" added="1255328675">Question</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="quiz_results_percentage_100" added="1255328797">Quiz Results ({percentage}/100)</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="quiz_results_for_full_name_percentage_100" added="1255328863">Quiz Results for {full_name} ({percentage}/100)</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="full_name_s_answer" added="1255328904"><![CDATA[{full_name}'s answer]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="correct_answer" added="1255328920">Correct Answer</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="title" added="1255328972">Title</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="description" added="1255328983">Description</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="255_character_limit" added="1255328992">255 character limit.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="quiz_questions" added="1255329004">Quiz Questions</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="submit" added="1255329019">Submit</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="add_another_question" added="1255329025">Add Another Question</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="additional_options" added="1255329033">Additional Options</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="image" added="1255329040">Image</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="click_here_to_delete_this_image_and_upload_a_new_one_in_its_place" added="1255329061">Click here to delete this image and upload a new one in its place.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1255329078">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="comments" added="1255329084">Comments</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="allow_comments" added="1255329093">Allow Comments</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="moderate_comments_first" added="1255329102">Moderate Comments First</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="no_comments" added="1255329109">No Comments</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="privacy" added="1255329116">Privacy</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="public_quiz_will_be_added_to_our_public_quiz_section" added="1255329126">Public (quiz will be added to our public quiz section)</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="personal_quiz_will_only_be_displayed_on_your_profile" added="1255329135">Personal (quiz will only be displayed on your profile)</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="friends_only_friends_can_view_this_quiz" added="1255329144">Friends (Only friends can view this quiz)</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="preferred_list_only_the_people_you_select_will_be_able_to_see_the_quiz" added="1255329156">Preferred list (only the people you select will be able to see the quiz)</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="you_have_not_added_any_quizzes" added="1255329188">You have not added any quizzes.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="no_quizzes_have_been_added_yet" added="1255329194">No quizzes have been added yet.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="add_your_quizzes_here" added="1255329203">Add your quizzes here.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="be_the_first_to_add_a_quiz" added="1255329212">Be the first to add a quiz</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="the_link_that_brought_you_here_is_wrong" added="1255329224">The link that brought you here is wrong.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="click_here_to_get_the_quiz_from_the_real_owner" added="1255329232">Click here to get the quiz from the real owner.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="unable_to_load_rating_callback" added="1255329272">Unable to load rating callback.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc4" var_name="not_a_valid_post" added="1255329293">Not a valid POST.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc8" var_name="user_info_has_not_added_any_quizzes_yet" added="1258396653">{user_info} has not added any quizzes yet.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc8" var_name="quiz_successfully_deleted" added="1258492359">Quiz successfully deleted.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc8" var_name="question_count" added="1258996653">Question {count}</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc8" var_name="answer_count" added="1258996761">Answer {count}...</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc8" var_name="answers" added="1258997586">Answers</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc8" var_name="taken_on_time_stamp" added="1259076940">Taken on {time_stamp}.</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc8" var_name="users_results" added="1259077018">User Results</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc9" var_name="add" added="1259169302">Add</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc9" var_name="accept" added="1259169333">Accept</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc11" var_name="user_setting_can_access_quiz" added="1260286388">Can browse and view the quiz module?</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc11" var_name="user_setting_can_create_quiz" added="1260329212">Can create a quiz?</phrase>
		<phrase module_id="quiz" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_quiz_a" added="1260461040"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">quiz</a>.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_their_own_a_href_link_quiz_a" added="1260461147"><![CDATA[<a href="{user_link}">{full_name}</a> likes their own <a href="{link}">quiz</a>.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_quiz_a" added="1260461167"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">quiz</a>.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.5dev2" var_name="user_setting_flood_control_quiz" added="1275108124"><![CDATA[How many minutes should a user wait before they can create another quiz?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></phrase>
		<phrase module_id="quiz" version_id="2.0.5dev2" var_name="you_are_creating_a_quiz_a_little_too_soon" added="1275108149">You are creating a quiz a little too soon.</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="quiz_has_been_approved" added="1319184189">Quiz has been approved.</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="no_quizzes_found" added="1319199424">No quizzes found.</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="search_quizzes" added="1319199443">Search Quizzes...</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="latest" added="1319199453">Latest</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="most_viewed" added="1319199488">Most Viewed</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="most_liked" added="1319199501">Most Liked</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="most_discussed" added="1319199508">Most Discussed</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="all_quizzes" added="1319199526">All Quizzes</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="my_quizzes" added="1319199544">My Quizzes</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="friends_quizzes" added="1319199594"><![CDATA[Friends' Quizzes]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="pending_quizzes" added="1319199603">Pending Quizzes</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="report_this_quiz" added="1319199750">Report this quiz</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="view_quiz" added="1319199766">View Quiz</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="control_who_can_see_this_quiz" added="1319199786">Control who can see this quiz.</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="comment_privacy" added="1319199793">Comment Privacy</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="control_who_can_comment_on_this_quiz" added="1319199801">Control who can comment on this quiz.</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="update" added="1319199810">Update</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="by" added="1319199871">by</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="actions" added="1319199885">Actions</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="moderate" added="1319199901">Moderate</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="view_results" added="1319199924">View Results</phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="full_name_liked_your_quiz_title" added="1319535889"><![CDATA[{full_name} liked your quiz "{title}"]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0beta5" var_name="full_name_liked_your_quiz_message" added="1319536296"><![CDATA[{full_name} liked your quiz "<a href="{link}">{title}</a>"
To view this quiz follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="full_name_commented_on_one_of_your_quiz_title" added="1322465785"><![CDATA[{full_name} commented on one of your quizzes "{title}".]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1322656304">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="posted_a_comment_on_gender_quiz_a_href_link_title_a" added="1322656428"><![CDATA[posted a comment on {gender} quiz "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="user_name_liked_span_class_drop_data_user_full_name_s_span_quiz_title" added="1322729762"><![CDATA[{user_name} liked <span class="drop_data_user">{full_name}'s</span> quiz "{title}"]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="your_quiz_title_has_been_approved" added="1322729818"><![CDATA[Your quiz "{title}" has been approved.]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="quiz_zes_successfully_approved" added="1322740878">Quiz(zes) successfully approved.</phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="quiz_zes_successfully_deleted" added="1322740895">Quiz(zes) successfully deleted.</phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="full_name_commented_on_gender_quiz" added="1323778225">{full_name} commented on {gender} quiz.</phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="full_name_commented_on_other" added="1323778315"><![CDATA[{full_name} commented on {other_full_name}'s quiz.]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_quiz" added="1323778781"><![CDATA[{full_name} commented on {other_full_name}'s quiz "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="full_name_commented_on_your_quiz_a_href" added="1323779377"><![CDATA[{full_name} commented on your quiz "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="posted_a_comment_user_quiz" added="1323779646"><![CDATA[posted a comment on {user_name}'s quiz "<a href="{link}">{title}</a>"]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="user_names_commented_on_quiz" added="1323779858"><![CDATA[{user_names} commented on {gender} quiz "{title}"]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="user_names_commented_on_your" added="1323779956"><![CDATA[{user_names} commented on your quiz "{title}"]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="user_names_commented_full_name" added="1323780119"><![CDATA[{user_names} commented on <span class="drop_data_user">{full_name}'s</span> quiz "{title}"]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="user_name_liked_gender_own_quiz_title" added="1323793215"><![CDATA[{user_name} liked {gender} own quiz "{title}".]]></phrase>
		<phrase module_id="quiz" version_id="3.0.0" var_name="user_name_liked_your_quiz_title" added="1323793258"><![CDATA[{user_name} liked your quiz "{title}".]]></phrase>
		<phrase module_id="quiz" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_a_quiz" added="1331221260">{user_name} tagged you in a comment in a quiz</phrase>
		<phrase module_id="quiz" version_id="3.1.0rc1" var_name="menu_quiz_quizzes_532c28d5412dd75bf975fb951c740a30" added="1332257984">Quizzes</phrase>
		<phrase module_id="quiz" version_id="3.5.0beta1" var_name="item_phrase" added="1352730806">quiz</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="quiz" type="integer" admin="9999" user="10" guest="0" staff="20" module="quiz" ordering="0">max_questions</setting>
		<setting is_admin_setting="0" module_id="quiz" type="integer" admin="1" user="5" guest="9999999" staff="2" module="quiz" ordering="0">min_questions</setting>
		<setting is_admin_setting="0" module_id="quiz" type="integer" admin="25" user="10" guest="1" staff="15" module="quiz" ordering="0">max_answers</setting>
		<setting is_admin_setting="0" module_id="quiz" type="integer" admin="2" user="2" guest="999999" staff="2" module="quiz" ordering="0">min_answers</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="true" guest="false" staff="true" module="quiz" ordering="0">can_answer_own_quiz</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="false" guest="false" staff="true" module="quiz" ordering="0">can_approve_quizzes</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="false" guest="false" staff="true" module="quiz" ordering="0">can_delete_others_quizzes</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="false" user="false" guest="true" staff="false" module="quiz" ordering="0">new_quizzes_need_moderation</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="true" guest="false" staff="true" module="quiz" ordering="0">can_delete_own_quiz</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="true" guest="true" staff="true" module="quiz" ordering="0">can_post_comment_on_quiz</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="false" guest="false" staff="false" module="quiz" ordering="0">can_edit_own_questions</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="false" guest="false" staff="false" module="quiz" ordering="0">can_edit_others_questions</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="true" guest="false" staff="true" module="quiz" ordering="0">can_edit_own_title</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="false" guest="false" staff="false" module="quiz" ordering="0">can_edit_others_title</setting>
		<setting is_admin_setting="0" module_id="quiz" type="integer" admin="10" user="5" guest="0" staff="7" module="quiz" ordering="0">points_quiz</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="false" guest="false" staff="false" module="quiz" ordering="0">can_view_results_before_answering</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="true" user="true" guest="false" staff="true" module="quiz" ordering="0">can_upload_picture</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="false" user="false" guest="true" staff="false" module="quiz" ordering="0">is_picture_upload_required</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="1" user="1" guest="1" staff="1" module="quiz" ordering="0">can_access_quiz</setting>
		<setting is_admin_setting="0" module_id="quiz" type="boolean" admin="1" user="1" guest="0" staff="1" module="quiz" ordering="0">can_create_quiz</setting>
		<setting is_admin_setting="0" module_id="quiz" type="integer" admin="0" user="0" guest="0" staff="0" module="quiz" ordering="0">flood_control_quiz</setting>
	</user_group_settings>
	<tables><![CDATA[a:5:{s:11:"phpfox_quiz";a:3:{s:7:"COLUMNS";a:14:{s:7:"quiz_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"quiz_id";s:4:"KEYS";a:5:{s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"user_id";}}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"user_id";i:2;s:7:"privacy";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:5:"title";i:2;s:7:"privacy";}}}}s:18:"phpfox_quiz_answer";a:3:{s:7:"COLUMNS";a:4:{s:9:"answer_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:11:"question_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"answer";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_correct";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"answer_id";s:4:"KEYS";a:1:{s:11:"question_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"question_id";}}}s:20:"phpfox_quiz_question";a:3:{s:7:"COLUMNS";a:3:{s:11:"question_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"quiz_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"question";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"question_id";s:4:"KEYS";a:1:{s:7:"quiz_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"quiz_id";}}}s:18:"phpfox_quiz_result";a:2:{s:7:"COLUMNS";a:5:{s:7:"quiz_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"question_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"answer_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"quiz_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"quiz_id";i:1;s:7:"user_id";}}}}s:17:"phpfox_quiz_track";a:2:{s:7:"COLUMNS";a:3:{s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}}}}]]></tables>
</module>