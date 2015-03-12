<upgrade>
	<phrases>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.7</version_id>
			<var_name>auto_approve</var_name>
			<added>1288794965</added>
			<value>Auto Approve Invited Users</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.7</version_id>
			<var_name>yes_invited_users_will_not_need_to_be_approved</var_name>
			<added>1288795141</added>
			<value>Yes (Invited users will not need to be approved)</value>
		</phrase>
		<phrase>
			<module_id>group</module_id>
			<version_id>2.0.7</version_id>
			<var_name>no_every_user_will_have_to_be_approved_before_becoming_a_member</var_name>
			<added>1288797446</added>
			<value>No (Every user will have to be approved before becoming a member)</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>group</module_id>
			<hook_type>service</hook_type>
			<module>group</module>
			<call_name>group.service_callback_getnewsfeed_start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_group";a:1:{s:12:"auto_approve";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>