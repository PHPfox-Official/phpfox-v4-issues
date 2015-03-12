<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>feed_limit_days</var_name>
			<phrase_var_name>setting_feed_limit_days</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0beta3</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>1</is_hidden>
			<type>array</type>
			<var_name>user_feed_display_limit</var_name>
			<phrase_var_name>setting_user_feed_display_limit</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0beta3</version_id>
			<value><![CDATA[s:29:"array(5, 10, 15, 20, 25, 30);";]]></value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>1</is_hidden>
			<type>boolean</type>
			<var_name>allow_rating_of_feeds</var_name>
			<phrase_var_name>setting_allow_rating_of_feeds</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc4</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>1</is_hidden>
			<type>boolean</type>
			<var_name>enable_like_system</var_name>
			<phrase_var_name>setting_enable_like_system</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>1</is_hidden>
			<type>integer</type>
			<var_name>display_feeds_from</var_name>
			<phrase_var_name>setting_display_feeds_from</phrase_var_name>
			<ordering>0</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value>30</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>1</is_hidden>
			<type>integer</type>
			<var_name>height_for_resized_videos</var_name>
			<phrase_var_name>setting_height_for_resized_videos</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.1.0beta2</version_id>
			<value>260</value>
		</setting>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>1</is_hidden>
			<type>integer</type>
			<var_name>width_for_resized_videos</var_name>
			<phrase_var_name>setting_width_for_resized_videos</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.1.0beta2</version_id>
			<value>300</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.0.0beta3</version_id>
			<var_name>setting_feed_limit_days</var_name>
			<added>1316518935</added>
			<value><![CDATA[<title>Feed Limit (Days)</title><info>This setting controls how many days we should look back when displaying feeds. If you set this to 0 it will look for all the feeds. We advice to add a limit to keep your site fresh. Note that this setting does not apply when viewing a users profile as it will list all of their feeds.</info>]]></value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:11:"phpfox_feed";a:1:{s:8:"type_id6";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"type_id";i:1;s:7:"item_id";}}}}}]]></sql>
</upgrade>