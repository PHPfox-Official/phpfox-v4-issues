<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enable_like_system</var_name>
			<phrase_var_name>setting_enable_like_system</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>nobody_likes_this</var_name>
			<added>1260439366</added>
			<value>Nobody likes this.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>you_like_this</var_name>
			<added>1260439664</added>
			<value>You like this.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>people_who_like_this</var_name>
			<added>1260439672</added>
			<value>People who like this</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>user_link_likes_this</var_name>
			<added>1260439694</added>
			<value>{user_link} likes this.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>you_and_user_link_like_this</var_name>
			<added>1260439746</added>
			<value>You and {user_link} like this.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>and</var_name>
			<added>1260439790</added>
			<value>and</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>you</var_name>
			<added>1260439797</added>
			<value>You</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>other_person</var_name>
			<added>1260439817</added>
			<value>other person</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>others</var_name>
			<added>1260439830</added>
			<value>others</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>like_this</var_name>
			<added>1260439841</added>
			<value>like this</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>like</var_name>
			<added>1260439890</added>
			<value>Like</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>unlike</var_name>
			<added>1260439897</added>
			<value>Unlike</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>you_have_already_liked_this_feed</var_name>
			<added>1260440751</added>
			<value><![CDATA[You have already "liked" this feed.]]></value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>user_link_and_user_link_like_this</var_name>
			<added>1260445733</added>
			<value>{user_link_owner} and {user_link} like this.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>the_feed_you_are_trying_to_like_unlike_does_not_exist_any_longer</var_name>
			<added>1260459851</added>
			<value>The feed you are trying to like/unlike does not exist any longer.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>a_href_user_link_full_name_a_likes_your_a_href_link_status_a</var_name>
			<added>1260475302</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">status</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_enable_like_system</var_name>
			<added>1260830264</added>
			<value><![CDATA[<title>Enable "Like" System</title><info>With this feature enabled it will allow users to "like/unlike" certain feeds.

Not all feeds support the "like/unlike" feature.

<b>Notice:</b> This feature is experimental and is not stable.</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc2</version_id>
			<var_name>setting_integrate_comments_into_feeds</var_name>
			<added>1252753029</added>
			<value><![CDATA[<title>Allow Comments in Feeds</title><info>By enabling this option you will allow members to add comments in feeds.</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>feed</module_id>
			<component>display</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="block">display.html.php</file>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>