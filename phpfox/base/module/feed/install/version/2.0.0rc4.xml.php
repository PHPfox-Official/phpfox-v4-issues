<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>allow_rating_of_feeds</var_name>
			<phrase_var_name>setting_allow_rating_of_feeds</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc4</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group>time_stamps</group>
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>feed_display_time_stamp</var_name>
			<phrase_var_name>setting_feed_display_time_stamp</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha3</version_id>
			<value>F j, Y g:i a</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>setting_allow_rating_of_feeds</var_name>
			<added>1255781516</added>
			<value><![CDATA[<title>Allow Rating of Feeds</title><info>Enable this option to allow users to rate feeds.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>are_you_sure</var_name>
			<added>1255781764</added>
			<value>Are you sure?</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>user_setting_can_delete_own_feed</var_name>
			<added>1255781932</added>
			<value>Can delete own feed?</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>user_setting_can_delete_other_feeds</var_name>
			<added>1255781966</added>
			<value>Can delete other feeds?</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>delete</var_name>
			<added>1255782554</added>
			<value>Delete</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>feed_successfully_deleted</var_name>
			<added>1255782937</added>
			<value>Feed successfully deleted.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>feed</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>feed</module>
			<ordering>0</ordering>
			<value>can_delete_own_feed</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>feed</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>feed</module>
			<ordering>0</ordering>
			<value>can_delete_other_feeds</value>
		</setting>
	</user_group_settings>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="block">display.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">rating.html.php</file>
		<file type="block">setting.html.php</file>
	</update_templates>
</upgrade>