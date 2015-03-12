<upgrade>
	<settings>
		<setting>
			<group>general</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>no_more_ie6</var_name>
			<phrase_var_name>setting_no_more_ie6</phrase_var_name>
			<ordering>11</ordering>
			<version_id>2.0.0rc11</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group>formatting</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>resize_embed_video</var_name>
			<phrase_var_name>setting_resize_embed_video</phrase_var_name>
			<ordering>4</ordering>
			<version_id>2.0.0rc11</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group>general</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>site_copyright</var_name>
			<phrase_var_name>setting_site_copyright</phrase_var_name>
			<ordering>6</ordering>
			<version_id>2.0.0alpha1</version_id>
			<value />
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>his</var_name>
			<added>1259966039</added>
			<value>his</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>her</var_name>
			<added>1259966050</added>
			<value>her</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>setting_no_more_ie6</var_name>
			<added>1260114410</added>
			<value><![CDATA[<title>Detect IE6</title><info>With this feature enabled it will guide those using IE6 to upgrade to a supported browser.

This feature is powered by <a href="http://www.ie6nomore.com/" target="_blank">IE6 No More</a>

<b>Note:</b> The themes we provide by default require IE7 or higher, however other themes could work fine with IE6 as this comes down to the theme you have installed.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>warning</var_name>
			<added>1260115626</added>
			<value>Warning!</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>you_are_using_an_outdated_browser</var_name>
			<added>1260115640</added>
			<value>You are using an outdated browser</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>for_a_better_experience_using_this_site_please_upgrade_to_a_modern_web_browser</var_name>
			<added>1260115649</added>
			<value>For a better experience using this site, please upgrade to a modern web browser.</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>get_firefox</var_name>
			<added>1260115659</added>
			<value>Get Firefox</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>get_internet_explorer</var_name>
			<added>1260115674</added>
			<value>Get Internet Explorer</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>get_safari</var_name>
			<added>1260115686</added>
			<value>Get Safari</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>get_google_chrome</var_name>
			<added>1260115698</added>
			<value>Get Google Chrome</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>menu_core_new_sample</var_name>
			<added>1260125237</added>
			<value>New Sample</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>menu_core_sub_menu</var_name>
			<added>1260133497</added>
			<value>Sub Menu</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>setting_resize_embed_video</var_name>
			<added>1260137802</added>
			<value><![CDATA[<title>Resize Embedded Videos</title><info>Enable this feature to resize embedded videos to fit your sites default theme in areas where it is designed to fix flash videos (eg. users profile).

Note that enabling this feature will be an extra overhead.

Use this feature with caution as it is  experimental.
</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>translate</var_name>
			<added>1260209538</added>
			<value>Translate</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>locale_contruct__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_translate_child_country_clean</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_translate_country_clean</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
	</hooks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>welcome</component>
			<location>7</location>
			<is_active>1</is_active>
			<ordering>15</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>dashboard</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>11</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:11:"ALTER_FIELD";a:1:{s:11:"phpfox_menu";a:1:{s:12:"m_connection";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}s:7:"ADD_KEY";a:1:{s:11:"phpfox_menu";a:1:{s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;s:9:"parent_id";}}}}]]></sql>
	<update_templates>
		<file type="block">dashboard.html.php</file>
		<file type="block">latest-admin-login.html.php</file>
		<file type="block">footer.html.php</file>
		<file type="layout">breadcrumb.html.php</file>
		<file type="layout">template.html.php</file>
		<file type="layout">block.html.php</file>
	</update_templates>
	<update_styles>
		<file type="layout">im.css</file>
		<file type="layout">layout.css</file>
		<file type="layout">common.css</file>
	</update_styles>
</upgrade>