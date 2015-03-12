<upgrade>
	<settings>
		<setting>
			<group>general</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>global_site_title</var_name>
			<phrase_var_name>setting_global_site_title</phrase_var_name>
			<ordering>3</ordering>
			<version_id>2.0.0</version_id>
			<value>phpFox - Social Networking Script</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0</version_id>
			<var_name>sample_phrase</var_name>
			<added>1261078500</added>
			<value>Sample Phrase</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0</version_id>
			<var_name>setting_global_site_title</var_name>
			<added>1261332596</added>
			<value><![CDATA[<title>Site Title</title><info>This will displayed on each page as the title of your site.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0</version_id>
			<var_name>uploading</var_name>
			<added>1261570167</added>
			<value>Uploading</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>setting_captcha_on_signup</var_name>
			<added>1221831949</added>
			<value><![CDATA[<title>Captcha on Registration</title><info>Enable this option to add a captcha routine to the registration process. This will help against spam.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>setting_mail_from_name</var_name>
			<added>1230348032</added>
			<value><![CDATA[<title>From</title><info>This is the name displayed when users receive emails from this site.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>setting_email_from_email</var_name>
			<added>1230348559</added>
			<value><![CDATA[<title>Email</title><info>This is the default email used when sending out emails and it will be the email users will see in their email.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>setting_mail_signature</var_name>
			<added>1230350155</added>
			<value><![CDATA[<title>Signature</title><info>This is the signature added to the bottom of each email that is sent from this site.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>setting_cache_plugins</var_name>
			<added>1231410765</added>
			<value><![CDATA[<title>Cache Plugins</title><info>Enable this setting if all plug-ins should be cached. It is advised to enable this on live sites.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc1</version_id>
			<var_name>setting_registration_enable_dob</var_name>
			<added>1250761283</added>
			<value><![CDATA[<title>Data of Birth</title><info>Enable this so users can register their date of birth when signing up for the site.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc1</version_id>
			<var_name>setting_registration_enable_gender</var_name>
			<added>1250761528</added>
			<value><![CDATA[<title>Gender Field</title><info>Enable this so users can register their gender when signing up for the site. </info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc1</version_id>
			<var_name>setting_registration_enable_location</var_name>
			<added>1250761639</added>
			<value><![CDATA[<title>Location</title><info>Enable this so users can register their location when signing up for the site. </info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc1</version_id>
			<var_name>setting_registration_enable_timezone</var_name>
			<added>1250761716</added>
			<value><![CDATA[<title>Timezone</title><info>Enable this so users can register their timezone when signing up for the site. </info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_categories_to_show_at_first</var_name>
			<added>1260886987</added>
			<value><![CDATA[<title>How many subcategories to show at first</title><info>This setting tells how many subcategories are to be shown at first. If the list of subcategories is longer than this value the extra ones will be hidden and a "View More" option will be shown instead, allowing the user to display the hidden subcategories.

a "View Less" option will be available to provide the full "accordion" effect.

If you set it to zero ("0" without quotes) it will hide every subcategory and a plus sign will show next to the category name, clicking the plus sign will show that category's subcategories.
</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<hooks>
		<hook>
			<module_id>core</module_id>
			<hook_type>component</hook_type>
			<module>core</module>
			<call_name>core.component_block_holder_clean</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>core</module_id>
			<hook_type>template</hook_type>
			<module>core</module>
			<call_name>theme_template_body__end</call_name>
			<added>1261572988</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="block">dashboard.html.php</file>
		<file type="block">category.html.php</file>
		<file type="block">quick-find.html.php</file>
	</update_templates>
</upgrade>