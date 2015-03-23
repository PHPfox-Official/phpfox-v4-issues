<module>
	<data>
		<module_id>share</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:36:"share.admin_menu_manage_social_sites";a:1:{s:3:"url";a:1:{i:0;s:5:"share";}}s:32:"share.admin_menu_add_social_site";a:1:{s:3:"url";a:2:{i:0;s:5:"share";i:1;s:3:"add";}}}]]></menu>
		<phrase_var_name>module_share</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="share" is_hidden="0" type="boolean" var_name="enable_social_bookmarking" phrase_var_name="setting_enable_social_bookmarking" ordering="1" version_id="2.0.0rc2">1</setting>
		<setting group="" module_id="share" is_hidden="0" type="boolean" var_name="share_facebook_like" phrase_var_name="setting_share_facebook_like" ordering="1" version_id="3.0.0beta1">1</setting>
		<setting group="" module_id="share" is_hidden="0" type="boolean" var_name="share_twitter_link" phrase_var_name="setting_share_twitter_link" ordering="1" version_id="3.0.0beta1">1</setting>
		<setting group="" module_id="share" is_hidden="0" type="boolean" var_name="share_google_plus_one" phrase_var_name="setting_share_google_plus_one" ordering="1" version_id="3.0.0beta1">1</setting>
		<setting group="" module_id="share" is_hidden="0" type="string" var_name="twitter_consumer_key" phrase_var_name="setting_twitter_consumer_key" ordering="1" version_id="3.0.0beta1" />
		<setting group="" module_id="share" is_hidden="0" type="string" var_name="twitter_consumer_secret" phrase_var_name="setting_twitter_consumer_secret" ordering="1" version_id="3.0.0beta1" />
		<setting group="" module_id="share" is_hidden="0" type="boolean" var_name="share_on_facebook" phrase_var_name="setting_share_on_facebook" ordering="1" version_id="3.0.0beta1">0</setting>
		<setting group="" module_id="share" is_hidden="0" type="boolean" var_name="share_on_twitter" phrase_var_name="setting_share_on_twitter" ordering="1" version_id="3.0.0beta1">0</setting>
	</settings>
	<hooks>
		<hook module_id="share" hook_type="controller" module="share" call_name="share.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="component" module="share" call_name="share.component_block_bookmark_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="component" module="share" call_name="share.component_block_frame_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="component" module="share" call_name="share.component_block_link_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="component" module="share" call_name="share.component_block_post_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="component" module="share" call_name="share.component_block_send_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_site__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_bookmark__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_share__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="share" hook_type="component" module="share" call_name="share.component_block_friend_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="share" hook_type="component" module="share" call_name="share.component_block_email_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="share" hook_type="controller" module="share" call_name="share.component_controller_admincp_social_index_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="share" hook_type="controller" module="share" call_name="share.component_controller_admincp_social_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="share" hook_type="component" module="share" call_name="share.component_block_connect_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="share" hook_type="controller" module="share" call_name="share.component_controller_connect_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_process_sendemails_1" added="1339076699" version_id="3.3.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_process_sendemails_7" added="1339076699" version_id="3.3.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_process_sendemails_2" added="1339076699" version_id="3.3.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_process_sendemails_3" added="1339076699" version_id="3.3.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_process_sendemails_6" added="1339076699" version_id="3.3.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_process_sendemails_4" added="1339076699" version_id="3.3.0beta1" />
		<hook module_id="share" hook_type="service" module="share" call_name="share.service_process_sendemails_5" added="1339076699" version_id="3.3.0beta1" />
	</hooks>
	<phrases>
		<phrase module_id="share" version_id="2.0.0alpha1" var_name="module_share" added="1233837703">Share</phrase>
		<phrase module_id="share" version_id="2.0.0rc1" var_name="user_setting_can_send_emails" added="1249835659">Can send emails when sharing?</phrase>
		<phrase module_id="share" version_id="2.0.0rc1" var_name="user_setting_total_emails_per_round" added="1249835888"><![CDATA[How many emails per round can be sent when sharing?

<b>Notice:</b> The value "0" (without quotes) gives the user group an unlimited amount of emails per round.]]></phrase>
		<phrase module_id="share" version_id="2.0.0rc1" var_name="user_setting_emails_per_hour" added="1249836245"><![CDATA[Define how many emails can be sent when sharing items each hour.

<b>Notice:</b> The value "0" (without quotes) allows an unlimited amount of emails to be sent each hour.]]></phrase>
		<phrase module_id="share" version_id="2.0.0rc1" var_name="admin_menu_manage_social_sites" added="1249838039">Manage Social Sites</phrase>
		<phrase module_id="share" version_id="2.0.0rc1" var_name="admin_menu_add_social_site" added="1249838039">Add Social Site</phrase>
		<phrase module_id="share" version_id="2.0.0rc2" var_name="setting_enable_social_bookmarking" added="1253454253"><![CDATA[<title>Enable Social Bookmarking</title><info>Enable Social Bookmarking</info>]]></phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="message_successfully_sent" added="1255334742">Message successfully sent.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="hi_check_this_out_url" added="1255334784"><![CDATA[Hi,

Check this out...

<a href="{url}">{url}</a>]]></phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="site_successfully_updated" added="1255334834">Site successfully updated.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="site_successfully_added" added="1255334843">Site successfully added.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="add_a_social_bookmarking_site" added="1255334855">Add a Social Bookmarking Site</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="social_bookmarking" added="1255334862">Social Bookmarking</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="add_a_site" added="1255334869">Add a Site</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="site_successfully_deleted" added="1255334979">Site successfully deleted.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="manage_sites" added="1255334987">Manage Sites</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="share" added="1255334996">Share</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="select_what_type_of_a_site_this_is" added="1255335019">Select what type of a site this is.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="provide_a_name_for_the_site" added="1255335026">Provide a name for the site.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="provide_a_url_for_the_site" added="1255335034">Provide a URL for the site.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="this_site_already_exists" added="1255335043">This site already exists.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="the_site_cannot_be_found" added="1255335058">The site cannot be found.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="none_of_the_emails_entered_were_valid" added="1255335069">None of the emails entered were valid.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="provide_a_icon_for_this_site" added="1255335079">Provide a icon for this site.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="provide_an_e_mail_address" added="1255335242">Provide an e-mail address.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="email_s" added="1255335257">Email(s)</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="separate_multiple_emails_with_a_comma" added="1255335274">Separate multiple emails with a comma.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="max_emails_limit" added="1255335723">Max emails: {limit}</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="subject" added="1255335734">Subject</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="message" added="1255335741">Message</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="send" added="1255335748">Send</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="you_are_unable_to_send_any_more_emails_we_have_a_limit_of_how_many_emails_can_be_sent_each_hour_br_current_limit_limit" added="1255335767"><![CDATA[You are unable to send any more emails. We have a limit of how many emails can be sent each hour. <br />
Current limit: {limit}]]></phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="social_bookmarks" added="1255335788">Social Bookmarks</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="friends" added="1255335798">Friends</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="e_mail" added="1255335807">E-Mail</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="post" added="1255335814">Post</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="need_to_select_some_friends_before_we_try_to_send_the_message" added="1255335828">Need to select some friends before we try to send the message.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="continue" added="1255335844">Continue</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="site_info" added="1255335933">Site Info</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="type" added="1255335939">Type</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="select" added="1255335946">Select</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="bookmark" added="1255335951">Bookmark</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="title" added="1255335962">Title</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="url" added="1255335969">URL</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="you_can_pass_a_title_and_url_string_by_adding_the_following_replacements_br_url_url_of_the_item_br_title_title_of_the_item" added="1255336002"><![CDATA[You can pass a title and URL string by adding the following replacements...
<br />
{URL} = URL of the item.
<br />
{TITLE} = Title of the item.]]></phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="icon" added="1255336012">Icon</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="click_here_to_change_this_icon" added="1255336032">Click here to change this icon.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="cancel" added="1255336041">cancel</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="you_can_upload_a_jpg_gif_or_png_file_br_advised_size_is_16x16_pixels" added="1255336057"><![CDATA[You can upload a JPG, GIF or PNG file. <br />
Advised size is 16x16 pixels.]]></phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="is_active" added="1255336067">Is Active</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="yes" added="1255336074">Yes</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="no" added="1255336079">No</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="submit" added="1255336086">Submit</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="sites" added="1255336266">Sites</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="name" added="1255336277">Name</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="active" added="1255336283">Active</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="manage" added="1255336290">Manage</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="edit" added="1255336297">Edit</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="delete" added="1255336303">Delete</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="are_you_sure" added="1255336311">Are you sure?</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="deactivate" added="1255336320">Deactivate</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="activate" added="1255336326">Activate</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="please_wait_limit_seconds_before_adding_a_new_shoutout" added="1255336870">Please wait {limit} seconds before adding a new shoutout.</phrase>
		<phrase module_id="share" version_id="2.0.0rc4" var_name="hi_check_this_out_bbcode" added="1256557298"><![CDATA[Hi,

Check this out...

[link={url}]{url}[/link]]]></phrase>
		<phrase module_id="share" version_id="2.0.4" var_name="check_out" added="1266509614">Check out:</phrase>
		<phrase module_id="share" version_id="3.0.0beta1" var_name="setting_share_facebook_like" added="1312362742"><![CDATA[<title>Enable Facebook Like</title><info>Set this to true to enable the Facebook Like button on items.</info>]]></phrase>
		<phrase module_id="share" version_id="3.0.0beta1" var_name="setting_share_twitter_link" added="1312371053"><![CDATA[<title>Enable Twitter Button</title><info>Set this to true to enable the Twitter Button when viewing items.</info>]]></phrase>
		<phrase module_id="share" version_id="3.0.0beta1" var_name="setting_share_google_plus_one" added="1312371128"><![CDATA[<title>Google +1</title><info>Set this to true to enable the Google +1 button when viewing items.</info>]]></phrase>
		<phrase module_id="share" version_id="3.0.0beta1" var_name="setting_share_on_facebook" added="1312531324"><![CDATA[<title>Facebook Social Sharing</title><info>Allow your users to share content that they post on this site directly to Facebook.</info>]]></phrase>
		<phrase module_id="share" version_id="3.0.0beta1" var_name="setting_share_on_twitter" added="1312531396"><![CDATA[<title>Twitter Social Sharing</title><info>Allow users to share content they post on this site directly to Twitter.</info>]]></phrase>
		<phrase module_id="share" version_id="3.0.0beta5" var_name="social_sharing" added="1319122174">Social Sharing</phrase>
		<phrase module_id="share" version_id="3.0.0rc1" var_name="before_using_this_feature_you_will_have_to_setup_up_a_connection_with_this_3rd_party_service" added="1320229448">Before using this feature you will have to setup up a connection with this 3rd party service.</phrase>
		<phrase module_id="share" version_id="3.0.0rc1" var_name="connect_now" added="1320229456">Connect Now</phrase>
		<phrase module_id="share" version_id="3.3.0beta1" var_name="on_your_wall" added="1336400616">On your wall</phrase>
		<phrase module_id="share" version_id="3.3.0beta1" var_name="on_a_friend_s_wall" added="1336400624"><![CDATA[On a friend&#039;s wall]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="share" type="boolean" admin="1" user="1" guest="0" staff="1" module="share" ordering="0">can_send_emails</setting>
		<setting is_admin_setting="0" module_id="share" type="integer" admin="0" user="10" guest="0" staff="0" module="share" ordering="0">total_emails_per_round</setting>
		<setting is_admin_setting="0" module_id="share" type="integer" admin="0" user="50" guest="0" staff="0" module="share" ordering="0">emails_per_hour</setting>
	</user_group_settings>
	<tables><![CDATA[a:3:{s:21:"phpfox_share_bookmark";a:3:{s:7:"COLUMNS";a:7:{s:7:"site_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:250";i:1;s:0:"";i:2;s:0:"";i:3;s:2:"NO";}s:4:"icon";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:3:"url";a:4:{i:0;s:9:"VCHAR:250";i:1;s:0:"";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"site_id";s:4:"KEYS";a:1:{s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"type_id";i:1;s:9:"is_active";}}}}s:20:"phpfox_share_connect";a:2:{s:7:"COLUMNS";a:5:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"connect_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"token";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"secret";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:18:"phpfox_share_email";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"email";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:10:"time_stamp";}}}}}]]></tables>
	<install><![CDATA[
	
		$aRows = array(
			  0 => 
			  array (
			    'type_id' => 'post',
			    'title' => 'Facebook',
			    'icon' => 'facebook.gif',
			    'is_active' => '1',
			    'ordering' => '1',
			    'url' => 'http://www.facebook.com/share.php?u={URL}',
			  ),
			  1 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Newsvine',
			    'icon' => 'newsvine.png',
			    'is_active' => '1',
			    'ordering' => '2',
			    'url' => 'http://www.newsvine.com/_wine/save?u={URL}&h={TITLE}',
			  ),
			  3 => 
			  array (
			    'type_id' => 'post',
			    'title' => 'Twitter',
			    'icon' => 'twitter.png',
			    'is_active' => '1',
			    'ordering' => '4',
			    'url' => 'http://twitter.com/home?status={TITLE} {URL}',
			  ),
			  4 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Reddit',
			    'icon' => 'reddit.png',
			    'is_active' => '1',
			    'ordering' => '5',
			    'url' => 'http://www.reddit.com/submit?url={URL}&title={TITLE}',
			  ),
			  5 => 
			  array (
			    'type_id' => 'post',
			    'title' => 'Myspace',
			    'icon' => 'myspace.png',
			    'is_active' => '1',
			    'ordering' => '6',
			    'url' => 'http://www.myspace.com/Modules/PostTo/Pages/?l=3&u={URL}&t={TITLE}&c=',
			  ),
			  6 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Technorati',
			    'icon' => 'technorati.png',
			    'is_active' => '1',
			    'ordering' => '7',
			    'url' => 'http://www.technorati.com/faves?add={URL}',
			  ),
			  7 => 
			  array (
			    'type_id' => 'post',
			    'title' => 'Friend Feed',
			    'icon' => 'friend_feed.png',
			    'is_active' => '1',
			    'ordering' => '8',
			    'url' => 'http://friendfeed.com/share?url={URL}',
			  ),
			  8 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Digg',
			    'icon' => 'digg.gif',
			    'is_active' => '1',
			    'ordering' => '9',
			    'url' => 'http://digg.com/submit?phase=2&url={URL}&title={TITLE}',
			  ),
			  9 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'del.icio.us',
			    'icon' => 'delicious.gif',
			    'is_active' => '1',
			    'ordering' => '10',
			    'url' => 'http://del.icio.us/post?url={URL}&title={TITLE}',
			  ),
			  10 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Google',
			    'icon' => 'google.gif',
			    'is_active' => '1',
			    'ordering' => '11',
			    'url' => 'http://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk={URL}&title={TITLE}',
			  ),
			  11 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'StumbleUpon',
			    'icon' => 'stumbleupon.gif',
			    'is_active' => '1',
			    'ordering' => '12',
			    'url' => 'http://www.stumbleupon.com/submit?url={URL}&title={TITLE}',
			  ),
			);		
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('share_bookmark'), $aInsert);
		}	
	
	]]></install>
</module>