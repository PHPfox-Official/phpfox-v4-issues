<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>blog</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>blog_cache_minutes</var_name>
			<phrase_var_name>setting_blog_cache_minutes</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0Beta1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>blog</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>total_pages_to_cache_blog</var_name>
			<phrase_var_name>setting_total_pages_to_cache_blog</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0Beta1</version_id>
			<value>4</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>blog</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>length_in_index</var_name>
			<phrase_var_name>setting_length_in_index</phrase_var_name>
			<ordering>1</ordering>
			<version_id>30</version_id>
			<value>500</value>
		</setting>
		<setting>
			<group>search_engine_optimization</group>
			<module_id>blog</module_id>
			<is_hidden>0</is_hidden>
			<type>large_string</type>
			<var_name>blog_meta_description</var_name>
			<phrase_var_name>setting_blog_meta_description</phrase_var_name>
			<ordering>6</ordering>
			<version_id>2.0.0rc1</version_id>
			<value>Read up on the latest blogs on Site Name.</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>blog</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>setting_blog_cache_minutes</var_name>
			<added>1295019128</added>
			<value><![CDATA[<title>Blog Cache (Minutes)</title><info>Define how many minutes to wait until blogs are repopulated with new data.

Set this to "0" (without quotes) to always output the latest data.

Note for larger communities we strongly advice to enable this feature as this will improve your sites overall performance.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>setting_total_pages_to_cache_blog</var_name>
			<added>1295255472</added>
			<value><![CDATA[<title>Total Pages to Cache</title><info>By default we display 5 blogs per page on the blog section. If caching is enabled this setting controls how many blogs to cache thus allowing users to browse X number of pages in cache before running a query to retrieve live data. If we display 5 items per page and this setting is set to 4 it will cache 20 blogs as we multiply the total blogs we display by this setting.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>blog</module_id>
			<version_id>3.0.0Beta1</version_id>
			<var_name>write_your_blog_entry_here</var_name>
			<added>1302203113</added>
			<value>Write your blog entry here...</value>
		</phrase>
	</phrases>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>blog.profile</m_connection>
			<module_id>blog</module_id>
			<component>categories</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>User Profile Blog Categories</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>blog.index</m_connection>
			<module_id>blog</module_id>
			<component>categories</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Categories</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>blog.index</m_connection>
			<module_id>blog</module_id>
			<component>top</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Top Bloggers</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<feed_share>
		<share>
			<module_id>blog</module_id>
			<title><![CDATA[{phrase var='blog.blog'}]]></title>
			<description><![CDATA[{phrase var='blog.write_your_blog_entry_here'}]]></description>
			<block_name>share</block_name>
			<no_input>0</no_input>
			<is_frame>0</is_frame>
			<ajax_request>addViaStatusUpdate</ajax_request>
			<no_profile>1</no_profile>
			<icon>blog.png</icon>
			<ordering>5</ordering>
			<value />
		</share>
	</feed_share>
	<sql><![CDATA[a:5:{s:11:"ALTER_FIELD";a:1:{s:11:"phpfox_blog";a:1:{s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ADD_FIELD";a:1:{s:11:"phpfox_blog";a:2:{s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ALTER_KEY";a:2:{s:11:"phpfox_blog";a:2:{s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"user_id";i:1;s:11:"is_approved";i:2;s:7:"privacy";i:3;s:11:"post_status";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:7:"user_id";i:1;s:10:"time_stamp";i:2;s:11:"is_approved";i:3;s:7:"privacy";i:4;s:11:"post_status";}}}s:20:"phpfox_blog_category";a:1:{s:8:"name_url";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:7:"ADD_KEY";a:1:{s:11:"phpfox_blog";a:2:{s:10:"time_stamp";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:10:"time_stamp";i:1;s:11:"is_approved";i:2;s:7:"privacy";i:3;s:11:"post_status";}}s:5:"title";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:5:"title";i:1;s:11:"is_approved";i:2;s:7:"privacy";i:3;s:11:"post_status";}}}}s:10:"REMOVE_KEY";a:2:{s:11:"phpfox_blog";a:4:{i:0;a:2:{i:0;s:5:"INDEX";i:1;s:9:"title_url";}i:1;a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}i:2;a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:11:"is_approved";}}i:3;a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"user_id";i:1;s:11:"is_approved";i:2;s:11:"post_status";}}}s:16:"phpfox_blog_text";a:1:{i:0;a:2:{i:0;s:5:"INDEX";i:1;s:7:"blog_id";}}}}]]></sql>
</upgrade>