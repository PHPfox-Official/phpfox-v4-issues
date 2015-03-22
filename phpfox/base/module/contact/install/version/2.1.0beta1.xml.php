<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>contact</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enable_auto_responder</var_name>
			<phrase_var_name>setting_enable_auto_responder</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>1</value>
		</setting>
		<setting>
			<group />
			<module_id>contact</module_id>
			<is_hidden>0</is_hidden>
			<type>large_string</type>
			<var_name>auto_responder_subject</var_name>
			<phrase_var_name>setting_auto_responder_subject</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value><![CDATA[{phrase var='contact.auto_responder_subject'}]]></value>
		</setting>
		<setting>
			<group />
			<module_id>contact</module_id>
			<is_hidden>0</is_hidden>
			<type>large_string</type>
			<var_name>auto_responder_message</var_name>
			<phrase_var_name>setting_auto_responder_message</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value><![CDATA[{phrase var='contact.auto_responder_message'}]]></value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>contact</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_enable_auto_responder</var_name>
			<added>1297760186</added>
			<value><![CDATA[<title>Enable Auto Responder</title><info>When this setting is enabled an email will be sent to the user who submits a message.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>contact</module_id>
			<version_id>2.0.8</version_id>
			<var_name>auto_responder_subject</var_name>
			<added>1297760326</added>
			<value>Thank you for contacting us</value>
		</phrase>
		<phrase>
			<module_id>contact</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_auto_responder_subject</var_name>
			<added>1297761617</added>
			<value><![CDATA[<title>Auto Responder Subject Phrase</title><info>This is the phrase that will be used when sending an auto response message. 

You can enter the language phrase here or write the text directly. The default phrase is contact.auto_responder_subject</info>]]></value>
		</phrase>
		<phrase>
			<module_id>contact</module_id>
			<version_id>2.0.8</version_id>
			<var_name>auto_responder_message</var_name>
			<added>1297761926</added>
			<value>We have received your message and will reply as soon as possible.

Have a nice day</value>
		</phrase>
		<phrase>
			<module_id>contact</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_auto_responder_message</var_name>
			<added>1297761991</added>
			<value><![CDATA[<title>Auto Responder Message Phrase</title><info>This is the phrase that will be used when sending an auto response message.

You can enter the language phrase here or write the text directly. The default phrase is contact.auto_responder_message</info>]]></value>
		</phrase>
	</phrases>
</upgrade>