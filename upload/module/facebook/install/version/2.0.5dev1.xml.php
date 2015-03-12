<upgrade>
	<settings>
		<setting>
			<group>facebook_connect</group>
			<module_id>facebook</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>facebook_app_id</var_name>
			<phrase_var_name>setting_facebook_app_id</phrase_var_name>
			<ordering>4</ordering>
			<version_id>2.0.5</version_id>
			<value />
		</setting>
		<setting>
			<group />
			<module_id>facebook</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>facebook_like_blog</var_name>
			<phrase_var_name>setting_facebook_like_blog</phrase_var_name>
			<ordering>5</ordering>
			<version_id>2.0.5dev1</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>facebook</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>facebook_like_photo</var_name>
			<phrase_var_name>setting_facebook_like_photo</phrase_var_name>
			<ordering>6</ordering>
			<version_id>2.0.5dev1</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>facebook</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>facebook_like_video</var_name>
			<phrase_var_name>setting_facebook_like_video</phrase_var_name>
			<ordering>7</ordering>
			<version_id>2.0.5dev1</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>facebook</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>facebook_like_group</var_name>
			<phrase_var_name>setting_facebook_like_group</phrase_var_name>
			<ordering>8</ordering>
			<version_id>2.0.5dev1</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>facebook</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>facebook_like_event</var_name>
			<phrase_var_name>setting_facebook_like_event</phrase_var_name>
			<ordering>9</ordering>
			<version_id>2.0.5dev1</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>facebook</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>facebook_like_marketplace</var_name>
			<phrase_var_name>setting_facebook_like_marketplace</phrase_var_name>
			<ordering>10</ordering>
			<version_id>2.0.5dev1</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5</version_id>
			<var_name>setting_facebook_app_id</var_name>
			<added>1272970806</added>
			<value><![CDATA[<title>Application ID</title><info>Provide the Application ID for your Facebook application.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5</version_id>
			<var_name>facebook_connect</var_name>
			<added>1273144993</added>
			<value>Facebook Connect</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5</version_id>
			<var_name>the_email_you_have_associated_with_facebook_is_already_in_use</var_name>
			<added>1273145141</added>
			<value>The email you have associated with Facebook is already in use on our website and cannot be used with this account.</value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>setting_facebook_like_blog</var_name>
			<added>1274191742</added>
			<value><![CDATA[<title>Enable Facebook Like Button (Blogs)</title><info>Enable to use the Facebook Like Button feature.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>setting_facebook_like_photo</var_name>
			<added>1274192408</added>
			<value><![CDATA[<title>Enable Facebook Like Button (Photo)</title><info>Enable to use the Facebook Like Button feature.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>setting_facebook_like_video</var_name>
			<added>1274193338</added>
			<value><![CDATA[<title>Enable Facebook Like Button (Video)</title><info>Enable to use the Facebook Like Button feature.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>setting_facebook_like_group</var_name>
			<added>1274193550</added>
			<value><![CDATA[<title>Enable Facebook Like Button (Groups)</title><info>Enable to use the Facebook Like Button feature.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>setting_facebook_like_event</var_name>
			<added>1274278715</added>
			<value><![CDATA[<title>Enable Facebook Like Button (Events)</title><info>Enable to use the Facebook Like Button feature.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>facebook</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>setting_facebook_like_marketplace</var_name>
			<added>1274278840</added>
			<value><![CDATA[<title>Enable Facebook Like Button (Marketplace)</title><info>Enable to use the Facebook Like Button feature.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>facebook</module_id>
			<hook_type>controller</hook_type>
			<module>facebook</module>
			<call_name>facebook.component_controller_email_clean</call_name>
			<added>1274286148</added>
			<version_id>2.0.5dev1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>