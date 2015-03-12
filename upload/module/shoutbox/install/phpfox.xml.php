<module>
	<data>
		<module_id>shoutbox</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_shoutbox</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="shoutbox" is_hidden="0" type="boolean" var_name="shoutbox_is_live" phrase_var_name="setting_shoutbox_is_live" ordering="1" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="shoutbox" is_hidden="0" type="integer" var_name="shoutbox_flood_limit" phrase_var_name="setting_shoutbox_flood_limit" ordering="1" version_id="2.0.0alpha1">5</setting>
		<setting group="" module_id="shoutbox" is_hidden="0" type="integer" var_name="shoutbox_refresh" phrase_var_name="setting_shoutbox_refresh" ordering="1" version_id="2.0.0alpha1">4</setting>
		<setting group="" module_id="shoutbox" is_hidden="0" type="integer" var_name="shoutbox_display_limit" phrase_var_name="setting_shoutbox_display_limit" ordering="1" version_id="2.0.0alpha1">5</setting>
		<setting group="time_stamps" module_id="shoutbox" is_hidden="0" type="string" var_name="shoutbox_time_stamp" phrase_var_name="setting_shoutbox_time_stamp" ordering="1" version_id="2.0.0alpha1">M j, g:i a</setting>
		<setting group="" module_id="shoutbox" is_hidden="0" type="integer" var_name="shoutbox_wordwrap" phrase_var_name="setting_shoutbox_wordwrap" ordering="1" version_id="2.0.0alpha1">25</setting>
		<setting group="" module_id="shoutbox" is_hidden="0" type="integer" var_name="shoutbox_total" phrase_var_name="setting_shoutbox_total" ordering="1" version_id="2.0.0alpha1">100</setting>
		<setting group="cache" module_id="shoutbox" is_hidden="0" type="boolean" var_name="load_content_ajax" phrase_var_name="setting_load_content_ajax" ordering="1" version_id="3.6.0rc1">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="core.index-member" module_id="shoutbox" component="display" location="3" is_active="1" ordering="8" disallow_access="" can_move="1">
			<title><![CDATA[{phrase var=&#039;shoutbox.shoutbox&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="group.view" module_id="shoutbox" component="display" location="0" is_active="1" ordering="8" disallow_access="" can_move="1">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="pages.view" module_id="shoutbox" component="display" location="3" is_active="1" ordering="7" disallow_access="" can_move="1">
			<title>Shoutbox</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="shoutbox" hook_type="controller" module="shoutbox" call_name="shoutbox.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="shoutbox" hook_type="component" module="shoutbox" call_name="shoutbox.component_block_entry_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="shoutbox" hook_type="service" module="shoutbox" call_name="shoutbox.service_shoutbox__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="shoutbox" hook_type="service" module="shoutbox" call_name="shoutbox.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="shoutbox" hook_type="service" module="shoutbox" call_name="shoutbox.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
	</hooks>
	<components>
		<component module_id="shoutbox" component="display" m_connection="" module="shoutbox" is_controller="0" is_block="1" is_active="1" />
	</components>
	<crons>
		<cron module_id="shoutbox" type_id="3" every="1"><![CDATA[Phpfox::getService('shoutbox.process')->clear(Phpfox::getParam('shoutbox.shoutbox_total'));
]]></cron>
	</crons>
	<phrases>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="module_shoutbox" added="1232969781">Shoutbox</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="setting_shoutbox_is_live" added="1233911435"><![CDATA[<title>Live Shoutbox</title><info>Set to <b>True</b> if you would like your shoutbox to be live. If it is set to <b>True</b> your shoutbox will automatically refresh without the need for your members to refresh the page manually in order to view new shoutouts.

<b>Notice:</b> Not all servers can handle such a feature so use with caution.</info>]]></phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="setting_shoutbox_flood_limit" added="1233912129"><![CDATA[<title>Shoutbox Flood Limit (Seconds)</title><info>Define the flood limit in seconds.</info>]]></phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="setting_shoutbox_refresh" added="1233913715"><![CDATA[<title>Shoutbox Refresh (Seconds)</title><info>Define in seconds when the shoutbox should refresh and get new shoutouts.

<b>Notice:</b> The setting <setting>shoutbox_flood_limit</setting> must set to <b>True</b> in order for this setting to function.</info>]]></phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="setting_shoutbox_display_limit" added="1233913988"><![CDATA[<title>Display Limit</title><info>Select how many shoutouts we should display in the shoutbox.</info>]]></phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="setting_shoutbox_time_stamp" added="1233914427"><![CDATA[<title>Time Stamp</title><info>Control the time stamps displayed on each of the shoutouts.</info>]]></phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="user_setting_can_view_shoutbox" added="1233914536">Can view the shoutbox?</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="user_setting_can_add_shoutout" added="1233916307">Can post a shoutout?</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="setting_shoutbox_wordwrap" added="1233916620"><![CDATA[<title>Wordwrap</title><info>Define a text wordwrap. The integer defined will be used to wrap long phrases so it does not stretch the shoutbox.

<b>Notice:</b> The shoutbox using a default theme outputs shoutouts within a HTML DIV that allows long phrases within the DIV without stretching the entire site.</info>]]></phrase>
		<phrase module_id="shoutbox" version_id="2.0.0alpha1" var_name="setting_shoutbox_total" added="1233922563"><![CDATA[<title>Shoutouts To Save</title><info>Select the amount of shoutouts we should save. Once a shoutout has passed this limit it is removed from our history to keep the shoutbox working as fast as possible.</info>]]></phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc4" var_name="please_wait_limit_seconds_before_adding_a_new_shoutout" added="1255336884">Please wait {limit} seconds before adding a new shoutout.</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc4" var_name="only_members_of_this_group_can_leave_a_message" added="1255336919">Only members of this group can leave a message.</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc4" var_name="shoutbox" added="1255337003">Shoutbox</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc4" var_name="view_shoutbox" added="1255337022">View Shoutbox</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc4" var_name="adding_your_shoutout" added="1255337063">Adding your shoutout</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc4" var_name="user_setting_can_delete_all_shoutbox_messages" added="1255864855">Can delete all shoutbox messages?</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc4" var_name="delete_this_shoutout" added="1255865184">Delete this shoutout.</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc4" var_name="are_you_sure" added="1255865416">Are you sure?</phrase>
		<phrase module_id="shoutbox" version_id="2.0.0rc8" var_name="enter_a_shoutout" added="1258389086">Enter a shoutout.</phrase>
		<phrase module_id="shoutbox" version_id="3.4.0rc1" var_name="can_view_post_in_shoutbox" added="1349765715">Can view/post in shoutbox?</phrase>
		<phrase module_id="shoutbox" version_id="3.6.0rc1" var_name="setting_load_content_ajax" added="1371731961"><![CDATA[<title>Shoutbox Content via AJAX</title><info>Load shoutbox content after the site has loaded via AJAX.</info>]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="shoutbox" type="boolean" admin="1" user="1" guest="1" staff="1" module="shoutbox" ordering="0">can_view_shoutbox</setting>
		<setting is_admin_setting="0" module_id="shoutbox" type="boolean" admin="1" user="1" guest="0" staff="1" module="shoutbox" ordering="0">can_add_shoutout</setting>
		<setting is_admin_setting="0" module_id="shoutbox" type="boolean" admin="1" user="0" guest="0" staff="1" module="shoutbox" ordering="0">can_delete_all_shoutbox_messages</setting>
	</user_group_settings>
	<tables><![CDATA[a:1:{s:15:"phpfox_shoutbox";a:3:{s:7:"COLUMNS";a:4:{s:8:"shout_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"shout_id";s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}}]]></tables>
</module>