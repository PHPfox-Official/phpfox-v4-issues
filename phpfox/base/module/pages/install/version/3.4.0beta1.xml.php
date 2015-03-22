<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>pages</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>admin_in_charge_of_page_claims</var_name>
			<phrase_var_name>setting_admin_in_charge_of_page_claims</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.4.0beta1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>pages</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>show_page_admins</var_name>
			<phrase_var_name>setting_show_page_admins</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.4.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>user_setting_can_claim_page</var_name>
			<added>1345729845</added>
			<value>Can members of this user group contact the site to claim a page?</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>setting_admin_in_charge_of_page_claims</var_name>
			<added>1345733443</added>
			<value><![CDATA[<title>Admin in Charge of Page Claims</title><info>Choose which admin should receive a mail when someone claims a page. 

Claiming a page is a user group setting, not every member is allowed to claim a page. To enable a user group to claim pages please go to Users -> Manage User Groups.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>admin_menu_manage_claims</var_name>
			<added>1346156588</added>
			<value>Manage Claims</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>step_count</var_name>
			<added>1347264641</added>
			<value>Step {count}</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>skip_view_this_page</var_name>
			<added>1347264684</added>
			<value><![CDATA[Skip & View This Page]]></value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>after_updating</var_name>
			<added>1347264713</added>
			<value>After Updating</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>go_to_the_next_step</var_name>
			<added>1347264756</added>
			<value>Go to the next step</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>view_this_page_lower</var_name>
			<added>1347264855</added>
			<value>View this page</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>setting_show_page_admins</var_name>
			<added>1344509028</added>
			<value><![CDATA[<title>Show Page Admins</title><info>Enable this option to show the page admins within a block when viewing a page. The person who created the page will be listed as the "Founder".</info>]]></value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>founder</var_name>
			<added>1344509085</added>
			<value>Founder</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>full_name_s_pages</var_name>
			<added>1344588607</added>
			<value><![CDATA[{full_name}&#039;s Pages]]></value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>upload_a_new_image_below_if_you_wish_to_change_this_icon</var_name>
			<added>1344857405</added>
			<value>Upload a new image below if you wish to change this icon.</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>icon</var_name>
			<added>1344857415</added>
			<value>Icon</value>
		</phrase>
		<phrase>
			<module_id>pages</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>continue</var_name>
			<added>1345021485</added>
			<value>Continue</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>pages</module_id>
			<type>boolean</type>
			<admin>true</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>pages</module>
			<ordering>0</ordering>
			<value>can_claim_page</value>
		</setting>
	</user_group_settings>
	<components>
		<component>
			<module_id>pages</module_id>
			<component>admin</component>
			<m_connection />
			<module>pages</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>pages</module_id>
			<component>coverphoto</component>
			<m_connection />
			<module>pages</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>pages</module_id>
			<component>profile</component>
			<m_connection>pages.profile</m_connection>
			<module>pages</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>pages.view</m_connection>
			<module_id>pages</module_id>
			<component>admin</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Page Admins</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:3:{s:12:"phpfox_pages";a:2:{s:14:"cover_photo_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:20:"cover_photo_position";a:4:{i:0;s:7:"VCHAR:4";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:17:"phpfox_pages_feed";a:1:{s:11:"time_update";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:19:"phpfox_pages_widget";a:2:{s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:15:"image_server_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:17:"phpfox_pages_feed";a:1:{s:11:"time_update";a:2:{i:0;s:5:"INDEX";i:1;s:11:"time_update";}}}}]]></sql>
</upgrade>