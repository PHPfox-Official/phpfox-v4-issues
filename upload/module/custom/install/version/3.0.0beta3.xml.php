<upgrade>
	<phpfox_update_phrases>
		<phrase>
			<module_id>custom</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>custom_relation_it_s_complicated_with</var_name>
			<added>1306418181</added>
			<value>is in a complicated relationship with {with_full_name}</value>
		</phrase>
	</phpfox_update_phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.info</m_connection>
			<module_id>custom</module_id>
			<component>panel</component>
			<location>4</location>
			<is_active>0</is_active>
			<ordering>10</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Custom Fields for Profile Panel</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.info</m_connection>
			<module_id>custom</module_id>
			<component>cf_movies</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Custom Movies</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.info</m_connection>
			<module_id>custom</module_id>
			<component>cf_interests</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Interests</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.info</m_connection>
			<module_id>custom</module_id>
			<component>cf_music</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Music</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:22:"phpfox_custom_relation";a:1:{s:12:"confirmation";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:27:"phpfox_custom_relation_data";a:2:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:12:"with_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:12:"with_user_id";}}}}]]></sql>
</upgrade>