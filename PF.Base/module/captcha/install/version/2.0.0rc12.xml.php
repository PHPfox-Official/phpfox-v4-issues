<upgrade>
	<settings>
		<setting>
			<group>recaptcha</group>
			<module_id>captcha</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>recaptcha</var_name>
			<phrase_var_name>setting_recaptcha</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group>recaptcha</group>
			<module_id>captcha</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>recaptcha_public_key</var_name>
			<phrase_var_name>setting_recaptcha_public_key</phrase_var_name>
			<ordering>2</ordering>
			<version_id>2.0.0rc12</version_id>
			<value />
		</setting>
		<setting>
			<group>recaptcha</group>
			<module_id>captcha</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>recaptcha_private_key</var_name>
			<phrase_var_name>setting_recaptcha_private_key</phrase_var_name>
			<ordering>3</ordering>
			<version_id>2.0.0rc12</version_id>
			<value />
		</setting>
		<setting>
			<group>recaptcha</group>
			<module_id>captcha</module_id>
			<is_hidden>0</is_hidden>
			<type>large_string</type>
			<var_name>recaptcha_header</var_name>
			<phrase_var_name>setting_recaptcha_header</phrase_var_name>
			<ordering>4</ordering>
			<version_id>2.0.0rc12</version_id>
			<value />
		</setting>
	</settings>
	<setting_groups>
		<name>
			<module_id>captcha</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_group_recaptcha</var_name>
			<value>recaptcha</value>
		</name>
	</setting_groups>
	<phrases>
		<phrase>
			<module_id>captcha</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_group_recaptcha</var_name>
			<added>1260884786</added>
			<value><![CDATA[<title>reCAPTCHA</title><info>reCAPTCHA</info>]]></value>
		</phrase>
		<phrase>
			<module_id>captcha</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_recaptcha</var_name>
			<added>1260884933</added>
			<value><![CDATA[<title>Enable reCAPTCHA</title><info>By enabling <a href="http://recaptcha.net/" target="_blank">reCAPTCHA</a>, wherever we use a captcha routine to prevent spam it will be replaced with reCAPTCHA.

You can sign up for a free account at <a href="http://recaptcha.net/" target="_blank">reCAPTCHA</a>.

<b>Notice:</b> This feature is experimental and is not stable.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>captcha</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_recaptcha_public_key</var_name>
			<added>1260885294</added>
			<value><![CDATA[<title>reCAPTCHA Public Key</title><info>Enter your reCAPTCHA public key here.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>captcha</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_recaptcha_private_key</var_name>
			<added>1260885341</added>
			<value><![CDATA[<title>reCAPTCHA Private Key</title><info>Enter your reCAPTCHA private key here.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>captcha</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_recaptcha_header</var_name>
			<added>1260886253</added>
			<value><![CDATA[<title>reCAPTCHA Header</title><info>You can modify the style of reCAPTCHA by adding JavaScript to the template header and by adding CSS to the same header or for each theme.

More information can be found <a href="http://wiki.recaptcha.net/index.php/How_to_change_reCAPTCHA_colors" target="_blank">here</a>.</info>]]></value>
		</phrase>
	</phrases>
	<update_templates>
		<file type="block">form.html.php</file>
	</update_templates>
</upgrade>