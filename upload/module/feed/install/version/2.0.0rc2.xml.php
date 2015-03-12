<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>integrate_comments_into_feeds</var_name>
			<phrase_var_name>setting_integrate_comments_into_feeds</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc2</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc2</version_id>
			<var_name>setting_integrate_comments_into_feeds</var_name>
			<added>1252753029</added>
			<value><![CDATA[<title>Integrate Comments Into Feeds</title><info>By enabling this option you will integrate comments found on a users profile into their feed. This will also disable the comment module on profiles if this feature is enabled since the news feed module will take over comments.</info>]]></value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:3:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_feed";a:1:{s:6:"rating";a:4:{i:0;s:8:"VCHAR:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}s:7:"ADD_KEY";a:1:{s:11:"phpfox_feed";a:3:{s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"type_id";i:1;s:12:"item_user_id";}}s:9:"type_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"type_id";i:1;s:7:"user_id";}}s:9:"type_id_3";a:2:{i:0;s:5:"INDEX";i:1;s:7:"type_id";}}}s:9:"ALTER_KEY";a:1:{s:11:"phpfox_feed";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}}]]></sql>
</upgrade>