<module>
	<data>
		<module_id>poke</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_poke</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="poke" is_hidden="0" type="boolean" var_name="add_to_feed" phrase_var_name="setting_add_to_feed" ordering="1" version_id="3.0.0beta1">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="core.index-member" module_id="poke" component="display" location="3" is_active="1" ordering="7" disallow_access="a:1:{i:0;s:1:&quot;3&quot;;}" can_move="1">
			<title><![CDATA[{phrase var=&#039;poke.pokes&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="poke" hook_type="controller" module="poke" call_name="poke.component_controller_index_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="poke" hook_type="service" module="poke" call_name="poke.service_callback__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="poke" hook_type="service" module="poke" call_name="poke.service_poke__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="poke" hook_type="service" module="poke" call_name="poke.service_process__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="poke" hook_type="service" module="poke" call_name="poke.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
	</hooks>
	<components>
		<component module_id="poke" component="display" m_connection="" module="poke" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="poke" version_id="3.0.0beta1" var_name="module_poke" added="1307704085">Poke</phrase>
		<phrase module_id="poke" version_id="3.0.0beta1" var_name="user_setting_can_poke" added="1307704928">Can members of this user group poke other members?</phrase>
		<phrase module_id="poke" version_id="3.0.0beta1" var_name="poke" added="1307705292">Poke</phrase>
		<phrase module_id="poke" version_id="3.0.0beta1" var_name="user_setting_can_send_poke" added="1307966022">Can members of this user group send Pokes?</phrase>
		<phrase module_id="poke" version_id="3.0.0beta1" var_name="user_setting_can_only_poke_friends" added="1307966175">Can members of this user group send a poke only to  people in their friends list?

(If you disable it, members of this user group will be able to poke people also not in their friends list)</phrase>
		<phrase module_id="poke" version_id="3.0.0beta1" var_name="setting_add_to_feed" added="1308041673"><![CDATA[<title>Add pokes to activity feed</title><info>If enabled every poke sent by a user will be added to the activity feed</info>]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta3" var_name="you_are_not_allowed_to_send_pokes" added="1315944406">You are not allowed to send pokes</phrase>
		<phrase module_id="poke" version_id="3.0.0beta3" var_name="you_can_only_poke_your_own_friends" added="1315944418">You can only poke your own friends</phrase>
		<phrase module_id="poke" version_id="3.0.0beta3" var_name="poke_sent" added="1315944430">Poke sent.</phrase>
		<phrase module_id="poke" version_id="3.0.0beta3" var_name="poke_could_not_be_sent" added="1315944442">Poke could not be sent.</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="pokes" added="1319103693">Pokes</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="full_name_liked_one_of_your_pokes" added="1319103762">{full_name} liked one of your pokes</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="full_name_liked_when_you_poked_row_full_name" added="1319103882"><![CDATA[{full_name} liked when you poked "<a href="{link}">{row_full_name}</a>"
To view this poke follow the link below:
<a href="{link}">{link}</a>"]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1319103922">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="full_name_commented_on_your_poke" added="1319103939">{full_name} commented on your poke</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="full_name_commented_on_your_poke_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1319103983"><![CDATA[{full_name} commented on your poke.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="full_name_commented_on_gender_poke" added="1319104029">{full_name} commented on {gender} poke.</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="full_name_commented_on_row_full_name_s_poke" added="1319104071"><![CDATA[{full_name} commented on {row_full_name}'s poke.]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="full_name_commented_on_gender_poke_to_see_the_comment_thread" added="1319104146"><![CDATA[{full_name} commented on {gender} poke.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="full_name_commented_on_row_full_name_s_poke_message" added="1319104355"><![CDATA[{full_name} commented on {row_full_name}'s poke.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="can_send_pokes" added="1319104390">Can send pokes</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="users_liked_gender_poke_for_title" added="1319104472"><![CDATA[{users} liked {gender} poke for "{title}"]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="users_liked_your_poke_for_title" added="1319104512"><![CDATA[{users} liked your poke for "{title}"]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_row_full_name_s_span_for_title" added="1319104556"><![CDATA[{users} liked <span class="drop_data_user">{row_full_name}'s</span> for "{title}"]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="users_commented_on_gender_poke_for_title" added="1319104648"><![CDATA[{users} commented on {gender} poke for "{title}"]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="users_commented_on_your_poke_for_title" added="1319104687"><![CDATA[{users} commented on your poke for "{title}"]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="users_commented_on_span_class_drop_data_user_row_full_name_s_span_for_title" added="1319104727"><![CDATA[{users} commented on <span class="drop_data_user">{row_full_name}'s</span> for "{title}"]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="poked_a_href_link_full_name_a" added="1319104791"><![CDATA[poked <a href="{link}">{full_name}</a>]]></phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="poke_back" added="1319108683">Poke Back</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="view_more_total" added="1319108700">View More ({total})</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="you_are_about_to_poke_full_name" added="1319108800">You are about to poke {full_name}.</phrase>
		<phrase module_id="poke" version_id="3.0.0beta5" var_name="loading" added="1319111495">Loading...</phrase>
		<phrase module_id="poke" version_id="3.0.0" var_name="full_name_has_poked_you" added="1322466757">{full_name} has poked you.</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="poke" type="boolean" admin="true" user="true" guest="false" staff="true" module="poke" ordering="0">can_poke</setting>
		<setting is_admin_setting="0" module_id="poke" type="boolean" admin="false" user="false" guest="true" staff="false" module="poke" ordering="0">can_only_poke_friends</setting>
	</user_group_settings>
	<tables><![CDATA[a:1:{s:16:"phpfox_poke_data";a:3:{s:7:"COLUMNS";a:6:{s:7:"poke_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"to_user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"status_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"poke_id";s:4:"KEYS";a:3:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:10:"to_user_id";}}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:10:"to_user_id";i:2;s:9:"status_id";}}s:10:"to_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"to_user_id";}}}}]]></tables>
</module>