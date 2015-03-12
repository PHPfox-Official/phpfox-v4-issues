<upgrade>
	<settings>
		<setting>
			<group>general</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>display_older_ie_error</var_name>
			<phrase_var_name>setting_display_older_ie_error</phrase_var_name>
			<ordering>15</ordering>
			<version_id>3.0.0rc1</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>setting_display_older_ie_error</var_name>
			<added>1320238795</added>
			<value><![CDATA[<title>IE8 or Higher Requirement Check</title><info>By default the script requires IE8 or higher. We will show users a notice if they are using an older version and a link to upgrade their browser. Disable this if you do not want to show a warning.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>ie8_or_higher_warning</var_name>
			<added>1320238851</added>
			<value><![CDATA[You seem to be using an older version of Internet Explorer. This site requires Internet Explorer 8 or higher. Update your browser <a href="http://www.microsoft.com/ie/" target="_blank">here</a> today to fully enjoy all the marvels of this site.]]></value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc1</version_id>
			<var_name>setting_registration_enable_dob</var_name>
			<added>1250761283</added>
			<value><![CDATA[<title>Date of Birth</title><info>Enable this so users can register their date of birth when signing up for the site.</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<hooks>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>editor_construct</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>image_helper_display_start</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>parse_bbcode__code1</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>parse_bbcode__code2</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>parse_bbcode__code3</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>url_getdomain_1</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>librayr_url__send_switch</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block__clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_category_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_moderation_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_body_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_breadcrumblist_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_breadcrumbmenu_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_contentclass_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_copyright_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template-footer_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_holdername_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_logo_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_menu_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_menuaccount_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template-menufooter_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_menusub_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_template_notification_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>service</hook_type>
			<module>core</module>
			<call_name>core.service_redirect_process__call</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>template</hook_type>
			<module>core</module>
			<call_name>core.template_block_comment_border_new</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>