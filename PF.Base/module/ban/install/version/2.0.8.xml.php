<upgrade>
	<phrases>
		<phrase>
			<module_id>ban</module_id>
			<version_id>2.0.8</version_id>
			<var_name>this_user_has_been_unbanned</var_name>
			<added>1297945314</added>
			<value>This user has been unbanned</value>
		</phrase>
		<phrase>
			<module_id>ban</module_id>
			<version_id>2.0.8</version_id>
			<var_name>the_user_a_href_link_user_a_has_been_banned</var_name>
			<added>1297945492</added>
			<value><![CDATA[The user <a href="{link}">"{user_name}"</a> has been banned.]]></value>
		</phrase>
		<phrase>
			<module_id>ban</module_id>
			<version_id>2.0.8</version_id>
			<var_name>you_need_to_choose_a_user_to_ban</var_name>
			<added>1297946808</added>
			<value>You need to choose a user to ban</value>
		</phrase>
		<phrase>
			<module_id>ban</module_id>
			<version_id>2.0.8</version_id>
			<var_name>you_are_about_to_ban_the_user</var_name>
			<added>1297947001</added>
			<value>You are about to ban the user:</value>
		</phrase>
		<phrase>
			<module_id>ban</module_id>
			<version_id>2.0.8</version_id>
			<var_name>phrase_variable_when_banning_explanation</var_name>
			<added>1297947304</added>
			<value><![CDATA[You can enter a language phrase variable, for example: {phrase var='report.attacks_individual_or_group'}, or text directly]]></value>
		</phrase>
		<phrase>
			<module_id>ban</module_id>
			<version_id>2.0.8</version_id>
			<var_name>ban_for_how_many_days</var_name>
			<added>1297947320</added>
			<value>Ban for how many days:</value>
		</phrase>
		<phrase>
			<module_id>ban</module_id>
			<version_id>2.0.8</version_id>
			<var_name>0_means_indefinite</var_name>
			<added>1297947350</added>
			<value>0 means indefinite</value>
		</phrase>
		<phrase>
			<module_id>ban</module_id>
			<version_id>2.0.8</version_id>
			<var_name>user_group_to_move_the_user_when_the_ban_expires</var_name>
			<added>1297947370</added>
			<value>User group to move the user when the ban expires:</value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:10:"phpfox_ban";a:4:{s:11:"days_banned";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:17:"return_user_group";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"reason";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:20:"user_groups_affected";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>