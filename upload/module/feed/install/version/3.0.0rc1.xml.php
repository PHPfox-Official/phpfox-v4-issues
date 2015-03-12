<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>twitter_share_via</var_name>
			<phrase_var_name>setting_twitter_share_via</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0rc1</version_id>
			<value>YourSite</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>activity_feed</var_name>
			<added>1320067556</added>
			<value>Activity Feed</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>setting_twitter_share_via</var_name>
			<added>1320229326</added>
			<value><![CDATA[<title>Twitter Share VIA</title><info>Provide your sites Twitter profile user name.</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.0.0beta5</version_id>
			<var_name>replied_on_gender_thread_a_href_link_title_a</var_name>
			<added>1319119665</added>
			<value><![CDATA[replied on {gender} thread "<a href="{link}">{title}</a>".]]></value>
		</phrase>
	</phpfox_update_phrases>
	<hooks>
		<hook>
			<module_id>feed</module_id>
			<hook_type>service</hook_type>
			<module>feed</module>
			<call_name>feed.service_feed_get_start</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>service</hook_type>
			<module>feed</module>
			<call_name>feed.service_process_deletefeed</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>template</hook_type>
			<module>feed</module>
			<call_name>feed.template_block_comment_border</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>