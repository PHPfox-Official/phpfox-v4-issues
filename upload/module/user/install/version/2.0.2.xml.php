<upgrade>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.2</version_id>
			<var_name>update_user_photos</var_name>
			<added>1262110390</added>
			<value>Update User Photos</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.2</version_id>
			<var_name>total_score_out_of_10</var_name>
			<added>1263212593</added>
			<value>{total_score} out of 10</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.2</version_id>
			<var_name>user_setting_can_view_if_a_user_is_invisible</var_name>
			<added>1263216036</added>
			<value><![CDATA[Can view a users "Last Login" time stamp on their profile even if their are invisible?]]></value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>user</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>user</module>
			<ordering>0</ordering>
			<value>can_view_if_a_user_is_invisible</value>
		</setting>
	</user_group_settings>
	<update_templates>
		<file type="controller">browse.html.php</file>
	</update_templates>
</upgrade>