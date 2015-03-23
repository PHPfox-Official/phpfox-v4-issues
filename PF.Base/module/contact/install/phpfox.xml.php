<module>
	<data>
		<module_id>contact</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:1:{s:29:"contact.admin_menu_categories";a:1:{s:3:"url";a:1:{i:0;s:7:"contact";}}}]]></menu>
		<phrase_var_name>module_contact</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="contact" parent_var_name="" m_connection="footer" var_name="menu_contact" ordering="33" url_value="contact" version_id="2.0.0alpha1" disallow_access="" module="contact" />
	</menus>
	<settings>
		<setting group="" module_id="contact" is_hidden="0" type="boolean" var_name="contact_enable_captcha" phrase_var_name="setting_contact_enable_captcha" ordering="1" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="contact" is_hidden="0" type="boolean" var_name="allow_html_in_contact" phrase_var_name="setting_allow_html_in_contact" ordering="1" version_id="2.0.0alpha1">1</setting>
		<setting group="" module_id="contact" is_hidden="0" type="string" var_name="contact_staff_emails" phrase_var_name="setting_contact_staff_emails" ordering="1" version_id="2.0.0alpha2" />
		<setting group="" module_id="contact" is_hidden="0" type="boolean" var_name="enable_auto_responder" phrase_var_name="setting_enable_auto_responder" ordering="1" version_id="2.0.8">1</setting>
		<setting group="" module_id="contact" is_hidden="0" type="large_string" var_name="auto_responder_subject" phrase_var_name="setting_auto_responder_subject" ordering="1" version_id="2.0.8"><![CDATA[{phrase var='contact.auto_responder_subject'}]]></setting>
		<setting group="" module_id="contact" is_hidden="0" type="large_string" var_name="auto_responder_message" phrase_var_name="setting_auto_responder_message" ordering="1" version_id="2.0.8"><![CDATA[{phrase var='contact.auto_responder_message'}]]></setting>
		<setting group="" module_id="contact" is_hidden="1" type="boolean" var_name="is_email_required" phrase_var_name="setting_is_email_required" ordering="1" version_id="2.0.0alpha1">1</setting>
	</settings>
	<hooks>
		<hook module_id="contact" hook_type="controller" module="contact" call_name="contact.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="contact" hook_type="service" module="contact" call_name="contact.service_process_add_start" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="contact" hook_type="service" module="contact" call_name="contact.service_process_add_end" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="contact" hook_type="service" module="contact" call_name="contact.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="contact" hook_type="service" module="contact" call_name="contact.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="contact" hook_type="service" module="contact" call_name="contact.service_contact__call" added="1240687633" version_id="2.0.0beta1" />
	</hooks>
	<phrases>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="module_contact" added="1232965280">Contact</phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="menu_contact" added="1232965307">Contact Us</phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="admin_menu_categories" added="1233309828">Categories</phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="category_succesfully_added" added="1233665594">Category successfully added</phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="category_could_not_be_added" added="1233665700">An error did not allow adding the category</phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="categories_successfully_deleted" added="1233668042">Categories successfully deleted</phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="edit" added="1233669367">Edit</phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="categories_successfully_edited" added="1233672243">Categories successfully edited</phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="setting_contact_enable_captcha" added="1233747823"><![CDATA[<title>Enable Captcha for Contact</title><info>If enabled the users trying to reach you through the Contact Us module will need to complete a captcha challenge before submitting their message.</info>]]></phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="setting_is_email_required" added="1233749051"><![CDATA[<title>Require email</title><info>If enabled users will need to enter a valid email address before their message is sent</info>]]></phrase>
		<phrase module_id="contact" version_id="2.0.0alpha1" var_name="setting_allow_html_in_contact" added="1236190859"><![CDATA[<title>Allow html in contact form</title><info>This setting tells if the site allows HTML in the contact us form.</info>]]></phrase>
		<phrase module_id="contact" version_id="2.0.0alpha2" var_name="setting_contact_staff_emails" added="1237535242"><![CDATA[<title>Staff Emails</title><info>List of emails separated by a comma that will receive an email when someone uses the "Contact Us" form.</info>]]></phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="categories" added="1253022948">Categories</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="fill_in_some_text_for_your_message" added="1253022992">Fill in some text for your message.</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="you_need_to_choose_a_category" added="1253023004">You need to choose a category.</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="provide_a_subject" added="1253023017">Provide a subject.</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="provide_your_full_name" added="1253023027">Provide your full name.</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="provide_a_valid_email" added="1253023050">Provide a valid email.</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="your_message_was_successfully_sent" added="1253023065">Your message was successfully sent.</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="contact_us" added="1253082677">Contact Us</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="add_a_new_category" added="1253082767">Add a New Category</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="category" added="1253082775">Category</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="add" added="1253082784">Add</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="manage_categories" added="1253082798">Manage Categories</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="order" added="1253082808">Order</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="select" added="1253082841">Select</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="full_name" added="1253082855">Full Name</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="subject" added="1253082865">Subject</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="email" added="1253082875">Email</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="website" added="1253082883">Website</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="message" added="1253083188">Message</phrase>
		<phrase module_id="contact" version_id="2.0.0rc2" var_name="submit" added="1253083201">Submit</phrase>
		<phrase module_id="contact" version_id="2.0.0rc11" var_name="send_yourself_a_copy" added="1260370608">Send Yourself a Copy</phrase>
		<phrase module_id="contact" version_id="2.0.0rc11" var_name="user_id" added="1260371359">User ID#</phrase>
		<phrase module_id="contact" version_id="2.0.0rc11" var_name="profile" added="1260371389">Profile</phrase>
		<phrase module_id="contact" version_id="2.0.0rc12" var_name="currently_unavailable" added="1260794762">Currently unavailable</phrase>
		<phrase module_id="contact" version_id="2.0.3" var_name="delete_selected" added="1264424410">Delete Selected</phrase>
		<phrase module_id="contact" version_id="2.0.8" var_name="setting_enable_auto_responder" added="1297760186"><![CDATA[<title>Enable Auto Responder</title><info>When this setting is enabled an email will be sent to the user who submits a message.</info>]]></phrase>
		<phrase module_id="contact" version_id="2.0.8" var_name="auto_responder_subject" added="1297760326">Thank you for contacting us</phrase>
		<phrase module_id="contact" version_id="2.0.8" var_name="setting_auto_responder_subject" added="1297761617"><![CDATA[<title>Auto Responder Subject Phrase</title><info>This is the phrase that will be used when sending an auto response message. 

You can enter the language phrase here or write the text directly. The default phrase is contact.auto_responder_subject</info>]]></phrase>
		<phrase module_id="contact" version_id="2.0.8" var_name="auto_responder_message" added="1297761926">We have received your message and will reply as soon as possible.

Have a nice day</phrase>
		<phrase module_id="contact" version_id="2.0.8" var_name="setting_auto_responder_message" added="1297761991"><![CDATA[<title>Auto Responder Message Phrase</title><info>This is the phrase that will be used when sending an auto response message.

You can enter the language phrase here or write the text directly. The default phrase is contact.auto_responder_message</info>]]></phrase>
		<phrase module_id="contact" version_id="3.4.0" var_name="no_admin_has_been_set_to_handle_this_type_of_issues" added="1350912355">No admin has been set to handle this type of issues</phrase>
	</phrases>
	<tables><![CDATA[a:1:{s:23:"phpfox_contact_category";a:3:{s:7:"COLUMNS";a:3:{s:11:"category_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"category_id";s:4:"KEYS";a:1:{s:8:"ordering";a:2:{i:0;s:5:"INDEX";i:1;s:8:"ordering";}}}}]]></tables>
	<install><![CDATA[
		$aContactCategories = array(
			'Sales' => '0',	
			'Support' => '1',			
			'Suggestions' => '2'
		);
		foreach ($aContactCategories as $sTitle => $iOrdering)
		{
			$this->database()->insert(Phpfox::getT('contact_category'), array(
					'title' => $sTitle,
					'ordering' => $iOrdering
				)
			);
		}
	]]></install>
</module>