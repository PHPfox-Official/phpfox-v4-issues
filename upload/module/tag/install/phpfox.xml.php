<module>
	<data>
		<module_id>tag</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_tag</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="time_stamps" module_id="tag" is_hidden="0" type="string" var_name="trending_topics_timestamp" phrase_var_name="setting_trending_topics_timestamp" ordering="1" version_id="3.0.1">F j, Y</setting>
		<setting group="" module_id="tag" is_hidden="0" type="integer" var_name="total_tag_display" phrase_var_name="setting_total_tag_display" ordering="1" version_id="2.0.0alpha1">25</setting>
		<setting group="" module_id="tag" is_hidden="0" type="integer" var_name="tag_trend_total_display" phrase_var_name="setting_tag_trend_total_display" ordering="1" version_id="2.1.0Beta1">10</setting>
		<setting group="" module_id="tag" is_hidden="0" type="integer" var_name="tag_cache_tag_cloud" phrase_var_name="setting_tag_cache_tag_cloud" ordering="0" version_id="2.0.0alpha1">180</setting>
		<setting group="" module_id="tag" is_hidden="0" type="integer" var_name="tag_min_display" phrase_var_name="setting_tag_min_display" ordering="0" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="tag" is_hidden="0" type="integer" var_name="tag_days_treading" phrase_var_name="setting_tag_days_treading" ordering="1" version_id="2.1.0Beta1">7</setting>
		<setting group="" module_id="tag" is_hidden="0" type="boolean" var_name="enable_hashtag_support" phrase_var_name="setting_enable_hashtag_support" ordering="1" version_id="3.7.0beta1">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="blog.index" module_id="tag" component="cloud" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title>Trending Topics</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="photo.index" module_id="tag" component="cloud" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="video.index" module_id="tag" component="cloud" location="3" is_active="1" ordering="5" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="core.index-member" module_id="tag" component="cloud" location="3" is_active="1" ordering="12" disallow_access="" can_move="0">
			<title>Hashtags</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_tag__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_tag_hasaccess_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_tag_getinlinesearchforuser_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_tag_hasaccess_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_tag_getinlinesearchforuser_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_tag_gettagcloud_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_tag_gettagcloud_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="tag" hook_type="service" module="tag" call_name="tag.service_callback__call" added="1258389334" version_id="2.0.0rc8" />
	</hooks>
	<components>
		<component module_id="tag" component="add" m_connection="" module="tag" is_controller="0" is_block="1" is_active="1" />
		<component module_id="tag" component="ajax" m_connection="" module="tag" is_controller="0" is_block="0" is_active="1" />
		<component module_id="tag" component="item" m_connection="" module="tag" is_controller="0" is_block="1" is_active="1" />
		<component module_id="tag" component="cloud" m_connection="" module="tag" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="tag" version_id="2.0.0alpha1" var_name="user_setting_edit_own_tags" added="1214436301">Can edit their own tags?</phrase>
		<phrase module_id="tag" version_id="2.0.0alpha1" var_name="user_setting_edit_user_tags" added="1214975277">Can edit tags added by other users?</phrase>
		<phrase module_id="tag" version_id="2.0.0alpha1" var_name="user_setting_can_add_tags_on_blogs" added="1214975295">Can add tags on blogs?</phrase>
		<phrase module_id="tag" version_id="2.0.0alpha1" var_name="module_tag" added="1219147106">Tag</phrase>
		<phrase module_id="tag" version_id="2.0.0alpha1" var_name="click_to_edit" added="1212122994">Click to Edit</phrase>
		<phrase module_id="tag" version_id="2.0.0alpha1" var_name="tags" added="1212123035">Tags</phrase>
		<phrase module_id="tag" version_id="2.0.0alpha1" var_name="separate_tags_commas" added="1213612331">Separate tags with commas.</phrase>
		<phrase module_id="tag" version_id="2.0.0alpha1" var_name="setting_total_tag_display" added="1237049953"><![CDATA[<title>Total Tag Display</title><info>Define the number of tags to display in a tag cloud.

<b>Note:</b> This is the global default setting, other modules can override this setting.</info>]]></phrase>
		<phrase module_id="tag" version_id="2.0.0rc4" var_name="add_tags" added="1255341335">Add tags.</phrase>
		<phrase module_id="tag" version_id="2.0.0rc4" var_name="missing_param_stagtype" added="1255341378">Missing param: $sTagType</phrase>
		<phrase module_id="tag" version_id="2.0.0rc4" var_name="missing_param_stype" added="1255341401">Missing param: sType</phrase>
		<phrase module_id="tag" version_id="2.0.0rc4" var_name="separate_multiple_tags_with_commas" added="1255341461">Separate multiple tags with commas.</phrase>
		<phrase module_id="tag" version_id="2.0.0rc4" var_name="last_modified_time_stamp_by_full_name" added="1255341533">Last modified {time_stamp} by {full_name}</phrase>
		<phrase module_id="tag" version_id="2.0.0rc8" var_name="tag_cloud" added="1258731513">Tag Cloud</phrase>
		<phrase module_id="tag" version_id="2.0.0rc8" var_name="no_tags_have_been_found" added="1258731805">No tags have been found.</phrase>
		<phrase module_id="tag" version_id="2.1.0Beta1" var_name="setting_tag_days_treading" added="1293606550"><![CDATA[<title>Days a Tag Can Trend</title><info>Define how many days a tag can trend.</info>]]></phrase>
		<phrase module_id="tag" version_id="2.1.0Beta1" var_name="setting_tag_trend_total_display" added="1293606604"><![CDATA[<title>Total Tags to Display</title><info>Define how many tags to display in the trending topics block on each section.</info>]]></phrase>
		<phrase module_id="tag" version_id="3.0.0beta5" var_name="topics" added="1319188777">Topics</phrase>
		<phrase module_id="tag" version_id="3.0.0beta5" var_name="separate_multiple_topics_with_commas" added="1319188797">Separate multiple topics with commas.</phrase>
		<phrase module_id="tag" version_id="3.0.0rc1" var_name="topic" added="1320239182">Topic</phrase>
		<phrase module_id="tag" version_id="3.0.0rc1" var_name="trending_since_since" added="1320239415">Trending since {since}</phrase>
		<phrase module_id="tag" version_id="3.0.1" var_name="trending_topics" added="1327429607">Trending Topics</phrase>
		<phrase module_id="tag" version_id="3.0.1" var_name="setting_trending_topics_timestamp" added="1327429718"><![CDATA[<title>Trending Topics Timestamp</title><info>This is the timestamp used for the phrase "Trending since {time}"</info>]]></phrase>
		<phrase module_id="tag" version_id="3.7.0beta1" var_name="setting_enable_hashtag_support" added="1373896214"><![CDATA[<title>Enable Hashtags</title><info>Enable this option if you wish to allow hashtags on the site to create topics for the item being added. This will remove the default tagging system.</info>]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="tag" type="boolean" admin="1" user="1" guest="0" staff="1" module="tag" ordering="0">edit_own_tags</setting>
		<setting is_admin_setting="0" module_id="tag" type="boolean" admin="1" user="0" guest="0" staff="1" module="tag" ordering="0">edit_user_tags</setting>
		<setting is_admin_setting="0" module_id="tag" type="boolean" admin="1" user="1" guest="0" staff="1" module="tag" ordering="0">can_add_tags_on_blogs</setting>
	</user_group_settings>
	<tables><![CDATA[a:1:{s:10:"phpfox_tag";a:3:{s:7:"COLUMNS";a:7:{s:6:"tag_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"category_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"tag_text";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"tag_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"tag_id";s:4:"KEYS";a:9:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:8:"tag_text";}}s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:11:"category_id";}}s:11:"category_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"category_id";}s:7:"tag_url";a:2:{i:0;s:5:"INDEX";i:1;s:7:"tag_url";}s:11:"user_search";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:11:"category_id";i:1;s:7:"user_id";i:2;s:8:"tag_text";}}s:19:"user_search_general";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"category_id";i:1;s:7:"user_id";}}s:9:"item_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"item_id";i:1;s:11:"category_id";i:2;s:7:"user_id";}}s:9:"item_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"item_id";i:1;s:11:"category_id";i:2;s:7:"tag_url";}}s:13:"category_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"category_id";i:1;s:8:"tag_text";}}}}}]]></tables>
</module>