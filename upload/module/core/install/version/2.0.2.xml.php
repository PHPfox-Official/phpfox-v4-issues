<upgrade>
	<settings>
		<setting>
			<group>time_stamps</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>footer_bar_tool_tip_time_stamp</var_name>
			<phrase_var_name>setting_footer_bar_tool_tip_time_stamp</phrase_var_name>
			<ordering>14</ordering>
			<version_id>2.0.2</version_id>
			<value>l, F j, Y g:i A</value>
		</setting>
		<setting>
			<group />
			<module_id>core</module_id>
			<is_hidden>1</is_hidden>
			<type>integer</type>
			<var_name>css_edit_id</var_name>
			<phrase_var_name>setting_css_edit_id</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.2</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.2</version_id>
			<var_name>setting_css_edit_id</var_name>
			<added>1262718486</added>
			<value><![CDATA[<title>CSS Edit ID#</title><info>CSS Edit ID#</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.2</version_id>
			<var_name>setting_footer_bar_tool_tip_time_stamp</var_name>
			<added>1263239803</added>
			<value><![CDATA[<title>Footerbar Tooltip Timestamp</title><info>This is the time stamp displayed when hovering over the mini time stamp on the footer bar.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>session_remove__start</call_name>
			<added>1263387694</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>service</hook_type>
			<module>core</module>
			<call_name>core.service_core_getgenders__end</call_name>
			<added>1263387694</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>set_defined_controller</call_name>
			<added>1263388996</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>run_start</call_name>
			<added>1263388996</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>get_controller</call_name>
			<added>1263388996</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>check_url_is_array</call_name>
			<added>1263388996</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>request_get</call_name>
			<added>1263388996</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>template_gettemplatefile</call_name>
			<added>1263388996</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>component_pre_process</call_name>
			<added>1263389358</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>library</hook_type>
			<module>core</module>
			<call_name>component_post_process</call_name>
			<added>1263389358</added>
			<version_id>2.0.2</version_id>
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
			<ordering>12</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>new</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>14</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>stat</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>10</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="controller">redirect.html.php</file>
	</update_templates>
	<update_styles>
		<file type="layout">common.css</file>
		<file type="layout">thickbox.css</file>
	</update_styles>
</upgrade>