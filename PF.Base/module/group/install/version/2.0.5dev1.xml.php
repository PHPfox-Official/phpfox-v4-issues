<upgrade>
	<phrases>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_can_sponsor_group</var_name>
			<added>1269953518</added>
			<value>Can members of this user group mark groups as sponsor?</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor</var_name>
			<added>1269953806</added>
			<value>Sponsor</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>unsponsor</var_name>
			<added>1269953819</added>
			<value>Unsponsor</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsored_group</var_name>
			<added>1270023390</added>
			<value>Sponsored Group</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_can_purchase_sponsor</var_name>
			<added>1271075391</added>
			<value>Can members of this user group purchase a sponsored ad space?</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_help</var_name>
			<added>1271148206</added>
			<value><![CDATA[In order to sponsor a group click on a group you wish to sponsor below and then look for the link "Sponsor".]]></value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>encourage_sponsor</var_name>
			<added>1271150296</added>
			<value>Sponsor your Groups</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_group_sponsor_price</var_name>
			<added>1271857417</added>
			<value>How much is the sponsor space worth for groups?
This works in a CPM basis.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_error_privacy</var_name>
			<added>1271944677</added>
			<value>Your group is not public, sponsoring conflicts with its privacy settings.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_error_owner</var_name>
			<added>1271944774</added>
			<value>Only the group creator or an administrator can sponsor groups.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_error_not_found</var_name>
			<added>1271944830</added>
			<value>The group you are trying to sponsor is not available.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_title</var_name>
			<added>1271944878</added>
			<value>Group: {sGroupTitle}</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_paypal_message</var_name>
			<added>1271944943</added>
			<value>Payment for the sponsor space of group: {sGroupTitle}</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_auto_publish_sponsored_item</var_name>
			<added>1272007153</added>
			<value>After the user has purchased a sponsored space, should the group be published right away?
If set to false, the admin will have to approve each new purchased sponsored group space before it is shown in the site.</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>group_successfully_sponsored</var_name>
			<added>1272453463</added>
			<value>Group successfully sponsored</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>group_successfully_un_sponsored</var_name>
			<added>1272453527</added>
			<value>Group successfully unsponsored</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.5</version_id>
			<var_name>group_invite_count</var_name>
			<added>1273230500</added>
			<value>Group Invite Count</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>group</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>true</staff>
			<module>group</module>
			<ordering>0</ordering>
			<value>can_sponsor_group</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>group</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>group</module>
			<ordering>0</ordering>
			<value>can_purchase_sponsor</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>group</module_id>
			<type>string</type>
			<admin>null</admin>
			<user>null</user>
			<guest>null</guest>
			<staff>null</staff>
			<module>group</module>
			<ordering>0</ordering>
			<value>group_sponsor_price</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>group</module_id>
			<type>boolean</type>
			<admin>true</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>group</module>
			<ordering>0</ordering>
			<value>auto_publish_sponsored_item</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>group</module_id>
			<hook_type>service</hook_type>
			<module>group</module>
			<call_name>group.service_process_sponsor__end</call_name>
			<added>1274286148</added>
			<version_id>2.0.5dev1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>group</module_id>
			<hook_type>template</hook_type>
			<module>group</module>
			<call_name>group.template_default_controller_view_extra_info</call_name>
			<added>1274286148</added>
			<version_id>2.0.5dev1</version_id>
			<value />
		</hook>
	</hooks>
	<components>
		<component>
			<module_id>group</module_id>
			<component>sponsored</component>
			<m_connection />
			<module>group</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>invite.index</m_connection>
			<module_id>group</module_id>
			<component>sponsored</component>
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
			<m_connection>group.index</m_connection>
			<module_id>group</module_id>
			<component>sponsored</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>group.index</m_connection>
			<module_id>group</module_id>
			<component>filter</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.index</m_connection>
			<module_id>group</module_id>
			<component>category</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.index</m_connection>
			<module_id>group</module_id>
			<component>popular</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:11:"ALTER_FIELD";a:1:{s:12:"phpfox_group";a:1:{s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}s:9:"ADD_FIELD";a:1:{s:12:"phpfox_group";a:1:{s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
	<update_templates>
		<file type="controller">view.html.php</file>
		<file type="controller">index.html.php</file>
		<file type="block">menu.html.php</file>
	</update_templates>
	<update_styles>
		<file type="module">profile.css</file>
	</update_styles>
</upgrade>