<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>profile</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>ajax_profile_tab</var_name>
			<phrase_var_name>setting_ajax_profile_tab</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.1.0Beta1</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.1.0Beta1</version_id>
			<var_name>setting_ajax_profile_tab</var_name>
			<added>1292314822</added>
			<value><![CDATA[<title>Ajax Profile Sections</title><info>Enable this option to load sub-sections on a users profile using AJAX.</info>]]></value>
		</phrase>
	</phrases>
	<components>
		<component>
			<module_id>profile</module_id>
			<component>info</component>
			<m_connection>profile.info</m_connection>
			<module>profile</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>quiz.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.info</m_connection>
			<module_id>profile</module_id>
			<component>info</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Profile Info</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.info</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>blog.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>video.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>poll.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>music.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>photo.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>friend.profile</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title><![CDATA[Profile Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>info</component>
			<location>2</location>
			<is_active>0</is_active>
			<ordering>17</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>pic</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>profile</module_id>
			<component>menu</component>
			<location>3</location>
			<is_active>0</is_active>
			<ordering>8</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>