<module>
	<data>
		<module_id>captcha</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_captcha</phrase_var_name>
		<writable />
	</data>
	<setting_groups>
		<name module_id="captcha" version_id="2.0.0rc12" var_name="setting_group_recaptcha">recaptcha</name>
	</setting_groups>
	<settings>
		<setting group="" module_id="captcha" is_hidden="0" type="string" var_name="captcha_code" phrase_var_name="setting_captcha_code" ordering="1" version_id="2.0.0alpha1">23456789bcdfghjkmnpqrstvwxyzABCDEFGHJKLMNPQRSTUVWXYZ</setting>
		<setting group="" module_id="captcha" is_hidden="0" type="integer" var_name="captcha_limit" phrase_var_name="setting_captcha_limit" ordering="2" version_id="2.0.0alpha1">5</setting>
		<setting group="" module_id="captcha" is_hidden="0" type="boolean" var_name="captcha_use_font" phrase_var_name="setting_captcha_use_font" ordering="3" version_id="2.0.0alpha1">0</setting>
		<setting group="" module_id="captcha" is_hidden="0" type="string" var_name="captcha_font" phrase_var_name="setting_captcha_font" ordering="4" version_id="2.0.0alpha1">HECK.TTF</setting>
		<setting group="recaptcha" module_id="captcha" is_hidden="0" type="boolean" var_name="recaptcha" phrase_var_name="setting_recaptcha" ordering="1" version_id="2.0.0rc12">0</setting>
		<setting group="recaptcha" module_id="captcha" is_hidden="0" type="string" var_name="recaptcha_public_key" phrase_var_name="setting_recaptcha_public_key" ordering="2" version_id="2.0.0rc12" />
		<setting group="recaptcha" module_id="captcha" is_hidden="0" type="string" var_name="recaptcha_private_key" phrase_var_name="setting_recaptcha_private_key" ordering="3" version_id="2.0.0rc12" />
		<setting group="recaptcha" module_id="captcha" is_hidden="0" type="large_string" var_name="recaptcha_header" phrase_var_name="setting_recaptcha_header" ordering="4" version_id="2.0.0rc12" />
	</settings>
	<hooks>
		<hook module_id="captcha" hook_type="component" module="captcha" call_name="captcha.component_block_form_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="captcha" hook_type="component" module="captcha" call_name="captcha.component_block_form_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="captcha" hook_type="service" module="captcha" call_name="captcha.service_captcha__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="captcha" hook_type="controller" module="captcha" call_name="captcha.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="captcha" hook_type="service" module="captcha" call_name="captcha.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="captcha" hook_type="service" module="captcha" call_name="captcha.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
	</hooks>
	<components>
		<component module_id="captcha" component="form" m_connection="" module="captcha" is_controller="0" is_block="1" is_active="1" />
		<component module_id="captcha" component="image" m_connection="captcha.image" module="captcha" is_controller="1" is_block="0" is_active="1" />
		<component module_id="captcha" component="ajax" m_connection="" module="captcha" is_controller="0" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="user_setting_captcha_on_blog_add" added="1214436352">Enable CAPTCHA challenge when adding a new blog.</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="user_setting_captcha_on_comment" added="1214975404">Enable CAPTHCA challenge when a user adds a comment?</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="module_captcha" added="1214232551">Control CAPTCHA (Completely Automated Public Turing) testing.</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="complete_captcha_challenge" added="1214797483">Complete the CAPTCHA challenge.</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="image_verification" added="1219059191">Image Verification</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="captcha_failed_please_try_again" added="1219059511">Captcha failed. Please try again.</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="refreshing_image" added="1219059568">Refreshing Image</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="reload_image" added="1219059610">Reload Image</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="click_refresh_image" added="1219059622">Click to Refresh Image</phrase>
		<phrase module_id="captcha" version_id="2.0.0alpha1" var_name="type_verification_code_above" added="1219059639">Type in the verification code above</phrase>
		<phrase module_id="captcha" version_id="2.0.0rc12" var_name="setting_group_recaptcha" added="1260884786"><![CDATA[<title>reCAPTCHA</title><info>reCAPTCHA</info>]]></phrase>
		<phrase module_id="captcha" version_id="2.0.0rc12" var_name="setting_recaptcha" added="1260884933"><![CDATA[<title>Enable reCAPTCHA</title><info>By enabling <a href="http://recaptcha.net/" target="_blank">reCAPTCHA</a>, wherever we use a captcha routine to prevent spam it will be replaced with reCAPTCHA.

You can sign up for a free account at <a href="http://recaptcha.net/" target="_blank">reCAPTCHA</a>.

<b>Notice:</b> This feature is experimental and is not stable.</info>]]></phrase>
		<phrase module_id="captcha" version_id="2.0.0rc12" var_name="setting_recaptcha_public_key" added="1260885294"><![CDATA[<title>reCAPTCHA Public Key</title><info>Enter your reCAPTCHA public key here.</info>]]></phrase>
		<phrase module_id="captcha" version_id="2.0.0rc12" var_name="setting_recaptcha_private_key" added="1260885341"><![CDATA[<title>reCAPTCHA Private Key</title><info>Enter your reCAPTCHA private key here.</info>]]></phrase>
		<phrase module_id="captcha" version_id="2.0.0rc12" var_name="setting_recaptcha_header" added="1260886253"><![CDATA[<title>reCAPTCHA Header</title><info>You can modify the style of reCAPTCHA by adding JavaScript to the template header and by adding CSS to the same header or for each theme.

More information can be found <a href="http://code.google.com/intl/en/apis/recaptcha/docs/customization.html" target="_blank">here</a>.</info>]]></phrase>
		<phrase module_id="captcha" version_id="3.0.0rc2" var_name="captcha_challenge" added="1321363974">Captcha Challenge</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="captcha" type="boolean" admin="0" user="0" guest="0" staff="0" module="captcha" ordering="9">captcha_on_blog_add</setting>
		<setting is_admin_setting="0" module_id="captcha" type="boolean" admin="0" user="0" guest="1" staff="0" module="captcha" ordering="0">captcha_on_comment</setting>
	</user_group_settings>
</module>