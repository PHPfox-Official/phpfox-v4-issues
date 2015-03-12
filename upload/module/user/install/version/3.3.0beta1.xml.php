<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>maximum_length_for_full_name</var_name>
			<phrase_var_name>setting_maximum_length_for_full_name</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.3.0beta1</version_id>
			<value>25</value>
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>drop</type>
			<var_name>user_browse_display_results_default</var_name>
			<phrase_var_name>setting_user_browse_display_results_default</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0alpha3</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:17:"name_photo_detail";s:6:"values";a:2:{i:0;s:17:"name_photo_detail";i:1;s:10:"name_photo";}}]]></value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>setting_maximum_length_for_full_name</var_name>
			<added>1338899710</added>
			<value><![CDATA[<title>Maximum Length for Full Name</title><info>Maximum length for full name</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>please_shorten_full_name</var_name>
			<added>1338900126</added>
			<value>Please shorten your full name to a maximum of {iMax} characters.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>please_shorten_display_name</var_name>
			<added>1338900157</added>
			<value>Please shorten your display name to a maximum of {iMax} characters.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.3.0beta1</version_id>
			<var_name>timeline</var_name>
			<added>1339425152</added>
			<value>Timeline</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0beta5</version_id>
			<var_name>setting_randomize_featured_members</var_name>
			<added>1246007440</added>
			<value><![CDATA[<title>Random featured members</title><info>Should featured members randomly show up?</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:3:{s:18:"phpfox_user_custom";a:2:{s:23:"cf_which_best_describes";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"cf_test_1";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:24:"phpfox_user_custom_value";a:2:{s:23:"cf_which_best_describes";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"cf_test_1";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:17:"phpfox_user_field";a:1:{s:12:"use_timeline";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:11:"ALTER_FIELD";a:1:{s:27:"phpfox_user_delete_feedback";a:1:{s:13:"reasons_given";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>