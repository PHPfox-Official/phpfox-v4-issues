<upgrade>
	<phrases>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.1.0beta1</version_id>
			<var_name>user_name_tagged_you_in_a_comment_in_a_page</var_name>
			<added>1331221936</added>
			<value>{user_name} tagged you in a comment in a page.</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.1.0beta1</version_id>
			<var_name>customize_design</var_name>
			<added>1330438425</added>
			<value>Customize Design</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>pages</module_id>
			<hook_type>controller</hook_type>
			<module>pages</module>
			<call_name>pages.component_controller_view_build</call_name>
			<added>1331554502</added>
			<version_id>3.1.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>pages</module_id>
			<hook_type>controller</hook_type>
			<module>pages</module>
			<call_name>pages.component_controller_view_assign</call_name>
			<added>1331554502</added>
			<version_id>3.1.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>pages</module_id>
			<component>photo</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title><![CDATA[Pages Photo &amp; Menu]]></title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>pages</module_id>
			<component>like</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Pages Likes/Members</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>pages</module_id>
			<component>menu</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Pages Mini Menu</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_pages";a:1:{s:17:"designer_style_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>