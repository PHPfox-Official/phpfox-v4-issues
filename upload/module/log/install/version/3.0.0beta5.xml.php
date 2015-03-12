<upgrade>
	<phrases>
		<phrase>
			<module_id>log</module_id>
			<version_id>3.0.0beta5</version_id>
			<var_name>active_users_total</var_name>
			<added>1319196397</added>
			<value>Active Users ({total})</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>log</module_id>
			<component>login</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title><![CDATA[{phrase var=&#039;log.recent_logins&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
</upgrade>