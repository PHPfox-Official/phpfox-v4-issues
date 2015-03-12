<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>notification</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>total_notification_title_length</var_name>
			<phrase_var_name>setting_total_notification_title_length</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0Beta1</version_id>
			<value>100</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>notification</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>notify_ajax_refresh</var_name>
			<phrase_var_name>setting_notify_ajax_refresh</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha4</version_id>
			<value>2</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>notification</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>setting_total_notification_title_length</var_name>
			<added>1296210370</added>
			<value><![CDATA[<title>Notification Title Length</title><info>When users receive a notification certain items include a title. This setting controls the length of the title.</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>notification</module_id>
			<component>feed</component>
			<location>3</location>
			<is_active>0</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:7:"ADD_KEY";a:1:{s:19:"phpfox_notification";a:2:{s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"is_seen";}}s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"type_id";i:1;s:7:"item_id";}}}}s:10:"REMOVE_KEY";a:1:{s:19:"phpfox_notification";a:1:{i:0;a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:15:"notification_id";i:1;s:7:"user_id";}}}}}]]></sql>
</upgrade>