<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>tag</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>tag_days_treading</var_name>
			<phrase_var_name>setting_tag_days_treading</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.1.0Beta1</version_id>
			<value>7</value>
		</setting>
		<setting>
			<group />
			<module_id>tag</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>tag_trend_total_display</var_name>
			<phrase_var_name>setting_tag_trend_total_display</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.1.0Beta1</version_id>
			<value>10</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>tag</module_id>
			<version_id>2.1.0Beta1</version_id>
			<var_name>setting_tag_days_treading</var_name>
			<added>1293606550</added>
			<value><![CDATA[<title>Days a Tag Can Trend</title><info>Define how many days a tag can trend.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>tag</module_id>
			<version_id>2.1.0Beta1</version_id>
			<var_name>setting_tag_trend_total_display</var_name>
			<added>1293606604</added>
			<value><![CDATA[<title>Total Tags to Display</title><info>Define how many tags to display in the trending topics block on each section.</info>]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>blog.index</m_connection>
			<module_id>tag</module_id>
			<component>cloud</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Trending Topics</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>tag</module_id>
			<component>cloud</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>tag</module_id>
			<component>cloud</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:10:"phpfox_tag";a:1:{s:13:"category_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"category_id";i:1;s:8:"tag_text";}}}}}]]></sql>
</upgrade>