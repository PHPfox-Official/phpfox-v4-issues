<upgrade>
	<phrases>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>a_href_user_link_full_name_a_updated_their_profile_design</var_name>
			<added>1256479461</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> updated their profile design.]]></value>
		</phrase>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>a_href_user_link_full_name_a_updated_their_profile</var_name>
			<added>1256479947</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> updated their profile.]]></value>
		</phrase>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>this_user_has_been_banned</var_name>
			<added>1256497825</added>
			<value>This user has been banned.</value>
		</phrase>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>user_setting_can_view_users_profile</var_name>
			<added>1256498007</added>
			<value>Can view a users profile? (Including their own profile.)</value>
		</phrase>
		<phrase>
			<module_id>profile</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>updates_from</var_name>
			<added>1256500572</added>
			<value>Updates from</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>profile</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>1</guest>
			<staff>1</staff>
			<module>profile</module>
			<ordering>0</ordering>
			<value>can_view_users_profile</value>
		</setting>
	</user_group_settings>
	<update_templates>
		<file type="controller">private.html.php</file>
	</update_templates>
</upgrade>