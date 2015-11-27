<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>add_feed_for_comments</var_name>
			<phrase_var_name>setting_add_feed_for_comments</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.4.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>1</is_hidden>
			<type>boolean</type>
			<var_name>integrate_comments_into_feeds</var_name>
			<phrase_var_name>setting_integrate_comments_into_feeds</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc2</version_id>
			<value>0</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>setting_add_feed_for_comments</var_name>
			<added>1347341347</added>
			<value><![CDATA[<title>Add Comments as Feeds</title><info>If this setting is enabled it will add comments that are added to items such as videos, blogs, photos etc... as its own feed entry.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>sort</var_name>
			<added>1347362981</added>
			<value>Sort</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>top_stories</var_name>
			<added>1347362989</added>
			<value>Top Stories</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>most_recent</var_name>
			<added>1347362995</added>
			<value>Most Recent</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>update_feed_time_stamps</var_name>
			<added>1347363856</added>
			<value>Update Feed Time Stamps</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>update_feed_time_stamps_for_pages</var_name>
			<added>1347363870</added>
			<value>Update Feed Time Stamps for Pages</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>update_feed_time_stamps_for_events</var_name>
			<added>1347363879</added>
			<value>Update Feed Time Stamps for Events</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>feed</module_id>
			<component>display</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>9</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Activity Feed</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_feed";a:1:{s:11:"time_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:11:"phpfox_feed";a:1:{s:11:"time_update";a:2:{i:0;s:5:"INDEX";i:1;s:11:"time_update";}}}}]]></sql>
</upgrade>