<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>friend</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>friend_suggestion_search_total</var_name>
			<phrase_var_name>setting_friend_suggestion_search_total</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>50</value>
		</setting>
		<setting>
			<group />
			<module_id>friend</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enable_friend_suggestion</var_name>
			<phrase_var_name>setting_enable_friend_suggestion</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>friend</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>friend_suggestion_timeout</var_name>
			<phrase_var_name>setting_friend_suggestion_timeout</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>1440</value>
		</setting>
		<setting>
			<group />
			<module_id>friend</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>friend_suggestion_user_based</var_name>
			<phrase_var_name>setting_friend_suggestion_user_based</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_friend_suggestion_search_total</var_name>
			<added>1260554251</added>
			<value><![CDATA[<title>Friends Suggestion Friends Check Count</title><info>When performing the search to find friend suggestions for your members it will pull out X amount of users, where X is the numerical value of how many friends to search.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_enable_friend_suggestion</var_name>
			<added>1260554523</added>
			<value><![CDATA[<title>Friend Suggestions</title><info>Enable this if you want to suggest friends to your members when they visit their dashboard.

You can control the search criteria on what defines a friend to suggest.

This feature requires a lot of extra server resources in order to perform such a search. 

Each search result is cached for X minutes (where you can control X).

<b>Notice:</b> This feature is experimental and is not stable.
</info>]]></value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_friend_suggestion_timeout</var_name>
			<added>1260554689</added>
			<value><![CDATA[<title>Refresh Friend Suggestions</title><info>Define how long to wait till we run the search to find friends to suggest to a member in minutes.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_friend_suggestion_user_based</var_name>
			<added>1260729076</added>
			<value><![CDATA[<title>Check Location for Friend Suggestions</title><info>Enable this option in order for us to pick up friend suggestions for your members based on the Country, State/Province and City they live in.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>we_are_unable_to_find_any_friends_to_suggest_at_this_time_once_we_do_you_will_be_notified_within_our_dashboard</var_name>
			<added>1260879935</added>
			<value>We are unable to find any friends to suggest at this time. Once we do you will be notified within our Dashboard.</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>finding_another_suggestion</var_name>
			<added>1260879983</added>
			<value>Finding another suggestion...</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>hide_this_suggestion</var_name>
			<added>1260880006</added>
			<value>Hide this suggestion</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>friend</var_name>
			<added>1260880732</added>
			<value>Friend</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>hide</var_name>
			<added>1260893725</added>
			<value>Hide</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>friend</module_id>
			<component>profile.small</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>friend</module_id>
			<component>mutual-friend</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>suggestion</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="block">request.html.php</file>
		<file type="block">suggestion.html.php</file>
		<file type="block">search.html.php</file>
	</update_templates>
</upgrade>