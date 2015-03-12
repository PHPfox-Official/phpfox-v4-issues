<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>profile</module_id>
			<is_hidden>1</is_hidden>
			<type>boolean</type>
			<var_name>display_submenu_for_photo</var_name>
			<phrase_var_name>setting_display_submenu_for_photo</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>profile</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_display_submenu_for_photo</var_name>
			<added>1355998784</added>
			<value><![CDATA[<title>Display Sub-Menu for Photos</title><info>If this setting is enabled it will display a sub menu in the profiles where users can click to view "Albums" or "Photos". 
If this setting is disabled that sub-menu will not be shown, and instead a bigger menu will be displayed on the right side. 
Please note that this is only valid if Timeline is disabled.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>profile</module_id>
			<hook_type>component</hook_type>
			<module>profile</module>
			<call_name>profile.component_block_pic_start</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>profile</module_id>
			<component>logo</component>
			<location>13</location>
			<is_active>1</is_active>
			<ordering>8</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Pages Cover Photo</title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>