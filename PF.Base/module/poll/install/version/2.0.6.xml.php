<upgrade>
	<phrases>
		<phrase>
			<module_id>poll</module_id>
			<version_id>2.0.6</version_id>
			<var_name>poll_results</var_name>
			<added>1279631100</added>
			<value>Poll Results</value>
		</phrase>
		<phrase>
			<module_id>poll</module_id>
			<version_id>2.0.6</version_id>
			<var_name>public_votes</var_name>
			<added>1283182388</added>
			<value>Public Votes</value>
		</phrase>
		<phrase>
			<module_id>poll</module_id>
			<version_id>2.0.6</version_id>
			<var_name>displays_all_users_who_voted_and_what_choice_they_voted_for</var_name>
			<added>1283182519</added>
			<value>Displays all users who voted, and what choice they voted for.</value>
		</phrase>
		<phrase>
			<module_id>poll</module_id>
			<version_id>2.0.6</version_id>
			<var_name>user_setting_can_view_hidden_poll_votes</var_name>
			<added>1283182954</added>
			<value>Can view votes even if the poll is marked to hide votes? (Admin Option)</value>
		</phrase>
		<phrase>
			<module_id>poll</module_id>
			<version_id>2.0.6</version_id>
			<var_name>votes_are_hidden_for_this_poll</var_name>
			<added>1283183023</added>
			<value>Votes are hidden for this poll.</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>poll</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>0</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>poll</module>
			<ordering>0</ordering>
			<value>can_view_hidden_poll_votes</value>
		</setting>
	</user_group_settings>
	<sql><![CDATA[a:3:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_poll";a:3:{s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"hide_vote";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:11:"phpfox_poll";a:2:{s:9:"module_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:9:"module_id";i:1;s:7:"view_id";i:2;s:7:"privacy";}}s:11:"module_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:9:"module_id";i:1;s:7:"user_id";i:2;s:7:"view_id";}}}}s:10:"REMOVE_KEY";a:1:{s:11:"phpfox_poll";a:2:{i:0;a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}i:1;a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:7:"view_id";}}}}}]]></sql>
	<update_templates>
		<file type="controller">add.html.php</file>
		<file type="block">votes.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">vote.html.php</file>
	</update_templates>
	<update_styles>
		<file type="module">poll.css</file>
	</update_styles>
</upgrade>