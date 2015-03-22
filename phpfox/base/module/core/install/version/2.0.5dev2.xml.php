<upgrade>
	<settings>
		<setting>
			<group>server_settings</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>force_https_secure_pages</var_name>
			<phrase_var_name>setting_force_https_secure_pages</phrase_var_name>
			<ordering>10</ordering>
			<version_id>2.0.5dev1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>array</type>
			<var_name>global_genders</var_name>
			<phrase_var_name>setting_global_genders</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.5dev2</version_id>
			<value><![CDATA[s:86:"array(
  0 => '1|core.his|profile.male',
  1 => '2|core.her|profile.female|female',
);";]]></value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.5dev1</version_id>
			<var_name>setting_force_https_secure_pages</var_name>
			<added>1274840652</added>
			<value><![CDATA[<title>Secure Pages with HTTPS</title><info>If your server has support for HTTPS you can enable this feature to secure certain pages like the login, registration and account setting pages.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>try_again_in_time_seconds</var_name>
			<added>1275106296</added>
			<value>Try again in {time} seconds.</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>try_again_in_1_second</var_name>
			<added>1275106549</added>
			<value>Try again in 1 second.</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>setting_global_genders</var_name>
			<added>1275182678</added>
			<value><![CDATA[<title>Genders</title><info>This setting controls the genders used on this community. To add a new gender you need to populate it with 3 values separated by a pipe "|" (without quotes). Use the default Male and Female genders we provide as examples.
 The first value needs to be a unique numerical ID number. For Male and Female we use the numbers 1 and 2. We advice to go upwards from there. The 2nd field needs to be a phrase that you must first add using our language manager. Once you add a phrase it gives you several examples on how to use the phrase. We will be using the "Text" method, which is basically the variable name of the phrase and how we will connect to this specific word. So the 2nd value needs to be a phrase that identifies this gender. For Male and Female we used his and her. The 3rd value identifies the gender and must also be a phrase much like the 2nd value. For male and female we used Male and Female to populate this value.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.5dev2</version_id>
			<var_name>all</var_name>
			<added>1275184041</added>
			<value>All</value>
		</phrase>
	</phrases>
	<update_styles>
		<file type="layout">layout.css</file>
		<file type="layout">common.css</file>
		<file type="layout">forum.css</file>
	</update_styles>
</upgrade>