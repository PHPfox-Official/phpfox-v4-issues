<module>
	<data>
		<module_id>im</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_im</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="time_stamps" module_id="im" is_hidden="0" type="string" var_name="im_time_stamp" phrase_var_name="setting_im_time_stamp" ordering="10" version_id="2.0.0beta5">G:i</setting>
		<setting group="" module_id="im" is_hidden="0" type="boolean" var_name="enable_im_in_footer_bar" phrase_var_name="setting_enable_im_in_footer_bar" ordering="1" version_id="2.0.0beta5">0</setting>
		<setting group="" module_id="im" is_hidden="0" type="integer" var_name="total_friends_to_display_in_im" phrase_var_name="setting_total_friends_to_display_in_im" ordering="6" version_id="2.0.0rc1">50</setting>
		<setting group="time_stamps" module_id="im" is_hidden="0" type="string" var_name="im_time_stamp_past" phrase_var_name="setting_im_time_stamp_past" ordering="2" version_id="2.0.0rc11">m/d/y g:i a</setting>
		<setting group="" module_id="im" is_hidden="0" type="integer" var_name="im_php_sleep" phrase_var_name="setting_im_php_sleep" ordering="2" version_id="3.0.0beta1">5</setting>
		<setting group="" module_id="im" is_hidden="0" type="integer" var_name="im_php_loops" phrase_var_name="setting_im_php_loops" ordering="3" version_id="3.0.0beta1">6</setting>
		<setting group="" module_id="im" is_hidden="0" type="integer" var_name="js_interval_value" phrase_var_name="setting_js_interval_value" ordering="4" version_id="3.0.0beta1">3000</setting>
		<setting group="" module_id="im" is_hidden="0" type="string" var_name="server_for_ajax_calls" phrase_var_name="setting_server_for_ajax_calls" ordering="5" version_id="3.0.0beta1" />
	</settings>
	<hooks>
		<hook module_id="im" hook_type="component" module="im" call_name="im.component_block_chat_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="component" module="im" call_name="im.component_block_messenger_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="component" module="im" call_name="im.component_block_message_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="component" module="im" call_name="im.component_block_footer_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="component" module="im" call_name="im.component_block_list_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="component" module="im" call_name="im.component_block_user_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="controller" module="im" call_name="im.component_controller_index_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="service" module="im" call_name="im.service_im__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="service" module="im" call_name="im.service_process__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="service" module="im" call_name="im.service_callback__call" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="im" hook_type="service" module="im" call_name="im.service_process_addtext_pre_insert" added="1286546859" version_id="2.0.7" />
		<hook module_id="im" hook_type="service" module="im" call_name="im.service_process_addtext_1" added="1378372973" version_id="3.7.0rc1" />
	</hooks>
	<phrases>
		<phrase module_id="im" version_id="2.0.0beta5" var_name="module_im" added="1246347993">Instant Messenger</phrase>
		<phrase module_id="im" version_id="2.0.0beta5" var_name="setting_im_time_stamp" added="1246864828"><![CDATA[<title>Messenger Time Stamp</title><info>Messenger Time Stamp</info>]]></phrase>
		<phrase module_id="im" version_id="2.0.0beta5" var_name="setting_enable_im_in_footer_bar" added="1247130604"><![CDATA[<title>Enable IM (Footer Bar)</title><info>Set to <b>True</b> to enable the Instant Messenger to be part of the site wide footer bar.</info>]]></phrase>
		<phrase module_id="im" version_id="2.0.0rc1" var_name="setting_group_total_friends_to_display_in_im" added="1250753660"><![CDATA[<title>total friends to display in im</title><info>Define how many friends should be displayed within the IM list.</info>]]></phrase>
		<phrase module_id="im" version_id="2.0.0rc1" var_name="setting_total_friends_to_display_in_im" added="1250753735"><![CDATA[<title>Total Friends in IM List</title><info>Define how many friends should be displayed within the IM list.</info>]]></phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="online" added="1254982727">Online</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="away" added="1254982736">Away</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="appear_offline" added="1254982746">Appear Offline</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="not_a_valid_chat_room" added="1254982823">Not a valid chat room.</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="unable_to_send_this_user_an_offline_message" added="1254982832">Unable to send this user an offline message.</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="report" added="1254982972">Report</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="report_this_user" added="1254983057">Report this User</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="instant_messenger" added="1254983096">Instant Messenger</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="chat" added="1254983153">Chat</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="offline" added="1254983161">Offline</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="close" added="1254983185">Close</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="find_your_friends" added="1254983211">Find your friends...</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="no_friends_online" added="1254983488">No friends online.</phrase>
		<phrase module_id="im" version_id="2.0.0rc4" var_name="member_is_offline" added="1254983914">Member is offline.</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="go_offline" added="1256804861">Go Offline</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="edit_block_list" added="1256804873">Edit Block List</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="status" added="1256804880">Status</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="play_sound_on_new_message" added="1256804890">Play sound on new message</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="yes" added="1256804897">Yes</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="no" added="1256804903">No</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="options" added="1256804920">Options</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="block" added="1256805201">Block</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="more_conversations" added="1256805266">More Conversations...</phrase>
		<phrase module_id="im" version_id="2.0.0rc5" var_name="conversations" added="1256805343">Conversations</phrase>
		<phrase module_id="im" version_id="2.0.0rc11" var_name="setting_im_time_stamp_past" added="1259962435"><![CDATA[<title>IM Time Stamp (Past)</title><info>IM Time Stamp (Past)</info>]]></phrase>
		<phrase module_id="im" version_id="2.0.6" var_name="are_you_sure" added="1284994281">Are you sure?</phrase>
		<phrase module_id="im" version_id="3.0.0beta1" var_name="setting_im_php_sleep" added="1312373490"><![CDATA[<title>Server Sleep Timeout</title><info>When the IM requests an update from the server, the server will check for new messages and other information, if nothing new is found it will wait to check again, this value sets how long (in seconds) should the server wait.

The lower the value the more real time the IM will look, but it will use more server resources. 

Too low a value and your server may not be able to handle it, use carefully.</info>]]></phrase>
		<phrase module_id="im" version_id="3.0.0beta1" var_name="setting_im_php_loops" added="1312373834"><![CDATA[<title>Server Number Of Checks</title><info>When the IM requests an update from the server, the server will check for new messages and other information, if nothing new is found it will wait to check again, this happens in the same ajax call. This setting tells how many times should the same process check for new updates before closing the connection.

Some servers limit how long can a PHP process run (for example 30 seconds), you can use this value and "Server Sleep Timeout" to schedule the updates for the IM.

The default combination allows the checks to run for 30 seconds before returning control to the web browser for another run.</info>]]></phrase>
		<phrase module_id="im" version_id="3.0.0beta1" var_name="setting_js_interval_value" added="1312374230"><![CDATA[<title>JS Ajax Interval Check Timeout</title><info>This setting controls how often will the IM check on the state of an Ajax call. The value is in milliseconds, so it defaults to 3 seconds.

If the value is too low the web browser may become unresponsive. It is advised to keep it in the thousands range.</info>]]></phrase>
		<phrase module_id="im" version_id="3.0.0beta1" var_name="setting_server_for_ajax_calls" added="1312528680"><![CDATA[<title>Server For Ajax Calls</title><info>To improve performance you can distribute the load from the IM to a different server.
This setting tells to which server should the IM query for updates.

Keep in mind that the server must still be under the same domain.

If you leave it blank the IM will query the main server.
Acceptable values are in the form of a domain or an IP address, for example:
http://im.domain.com/
http://67.15.104.63/

are valid examples. Also dont forget the http:// and the ending /</info>]]></phrase>
		<phrase module_id="im" version_id="3.0.0" var_name="block_this_user" added="1323086309">Block This User</phrase>
		<phrase module_id="im" version_id="3.0.0" var_name="unable_to_block_this_user" added="1323086356">Unable to block this user.</phrase>
		<phrase module_id="im" version_id="3.2.0" var_name="clear_this_conversation" added="1336464370">Clear this conversation</phrase>
	</phrases>
	<tables><![CDATA[a:3:{s:9:"phpfox_im";a:3:{s:7:"COLUMNS";a:11:{s:5:"im_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:6:"is_new";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"is_alert";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"owner_user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"last_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:18:"cleared_time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:5:"im_id";s:4:"KEYS";a:2:{s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"parent_id";i:1;s:7:"user_id";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:9:"is_active";}}}}s:15:"phpfox_im_alert";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"room_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_seen";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"room_id";}}}}s:14:"phpfox_im_text";a:3:{s:7:"COLUMNS";a:5:{s:7:"text_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"text_id";s:4:"KEYS";a:1:{s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"parent_id";}}}}]]></tables>
</module>