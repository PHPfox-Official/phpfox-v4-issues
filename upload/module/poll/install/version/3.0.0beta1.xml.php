<upgrade>
	<phpfox_update_settings>
		<setting>
			<group>search_engine_optimization</group>
			<module_id>poll</module_id>
			<is_hidden>0</is_hidden>
			<type>large_string</type>
			<var_name>poll_meta_description</var_name>
			<phrase_var_name>setting_poll_meta_description</phrase_var_name>
			<ordering>9</ordering>
			<version_id>2.0.0rc1</version_id>
			<value>New polls on Site Name daily.</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>poll</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>poll</var_name>
			<added>1302203087</added>
			<value>Poll</value>
		</phrase>
		<phrase>
			<module_id>poll</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>say_something_about_this_poll</var_name>
			<added>1302203094</added>
			<value>Say something about this poll...</value>
		</phrase>
	</phrases>
	<phpfox_update_menus>
		<menu>
			<module_id>poll</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_poll</var_name>
			<ordering>24</ordering>
			<url_value>poll</url_value>
			<version_id>2.0.0alpha1</version_id>
			<disallow_access />
			<module>poll</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<feed_share>
		<share>
			<module_id>poll</module_id>
			<title><![CDATA[{phrase var='poll.poll'}]]></title>
			<description><![CDATA[{phrase var='poll.say_something_about_this_poll'}]]></description>
			<block_name>share</block_name>
			<no_input>1</no_input>
			<is_frame>0</is_frame>
			<ajax_request>addViaStatusUpdate</ajax_request>
			<no_profile>1</no_profile>
			<icon>poll.png</icon>
			<ordering>4</ordering>
			<value />
		</share>
	</feed_share>
	<sql><![CDATA[a:3:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_poll";a:2:{s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:2:{s:11:"phpfox_poll";a:3:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"item_id";i:1;s:7:"view_id";i:2;s:7:"privacy";}}s:9:"item_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"item_id";i:1;s:7:"user_id";i:2;s:7:"view_id";i:3;s:7:"privacy";}}s:9:"item_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"item_id";i:1;s:7:"view_id";i:2;s:8:"question";i:3;s:7:"privacy";}}}s:18:"phpfox_poll_answer";a:1:{s:9:"answer_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"answer_id";i:1;s:7:"poll_id";}}}}s:10:"REMOVE_KEY";a:1:{s:11:"phpfox_poll";a:3:{i:0;a:2:{i:0;s:5:"INDEX";i:1;s:12:"question_url";}i:1;a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:9:"module_id";i:1;s:7:"view_id";i:2;s:7:"privacy";}}i:2;a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:9:"module_id";i:1;s:7:"user_id";i:2;s:7:"view_id";}}}}}]]></sql>
</upgrade>