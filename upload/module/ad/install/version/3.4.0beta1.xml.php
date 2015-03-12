<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>ad</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>advanced_ad_filters</var_name>
			<phrase_var_name>setting_advanced_ad_filters</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.4.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>ad</module_id>
			<version_id>3.4.0beta1</version_id>
			<var_name>setting_advanced_ad_filters</var_name>
			<added>1345630097</added>
			<value><![CDATA[<title>Enable Advanced Ad Filters</title><info>This setting enables the site to display ads based on the State/Province, Zip Code/Postal Code and City.</info>]]></value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:2:{s:9:"phpfox_ad";a:2:{s:11:"postal_code";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"city_location";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:17:"phpfox_ad_country";a:1:{s:8:"child_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>