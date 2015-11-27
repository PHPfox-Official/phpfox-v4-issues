<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>min_count_for_top_rating</var_name>
			<phrase_var_name>setting_min_count_for_top_rating</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0</version_id>
			<var_name>total_score_out_of_5</var_name>
			<added>1261177339</added>
			<value>{total_score} out of 5.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0</version_id>
			<var_name>setting_min_count_for_top_rating</var_name>
			<added>1261177451</added>
			<value><![CDATA[<title>Minimum Ratings for "Top Rated" Users</title><info>Define how many times a member must be rated on before they are listed on the "Top Rated" section.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0</version_id>
			<var_name>top_rated_members</var_name>
			<added>1261178262</added>
			<value>Top Rated Members</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0</version_id>
			<var_name>no_top_members_found</var_name>
			<added>1261178695</added>
			<value>No top members found.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0</version_id>
			<var_name>menu_user_top_rated_members</var_name>
			<added>1261178780</added>
			<value>Top Rated Members</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0</version_id>
			<var_name>all</var_name>
			<added>1261179636</added>
			<value>All</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0</version_id>
			<var_name>male</var_name>
			<added>1261179642</added>
			<value>Male</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0</version_id>
			<var_name>female</var_name>
			<added>1261179649</added>
			<value>Female</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0alpha2</version_id>
			<var_name>setting_multi_step_registration_form</var_name>
			<added>1237571029</added>
			<value><![CDATA[<title>Multi-step Registration Form</title><info>Enabling this option will turn the registration process into multiple steps and using as few fields as we can on the first step to entice users to register.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0alpha2</version_id>
			<var_name>setting_registration_steps</var_name>
			<added>1237574533</added>
			<value><![CDATA[<title>Registration Steps</title><info>With this option you can add extra steps to the registration process.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>you_need_to_verify_your_email_address_before_logging_in</var_name>
			<added>1255348029</added>
			<value><![CDATA[You need to verify your email address before logging in.

We sent a verification code to: <b>{email}</b>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>2.0.0rc10</version_id>
			<var_name>setting_redirect_after_signup</var_name>
			<added>1259688625</added>
			<value><![CDATA[<title>Redirect After SignUp</title><info>Add the full path you want to send users right after they register. If you want to use our default routine just leave this blank.</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<menus>
		<menu>
			<module_id>user</module_id>
			<parent_id>0</parent_id>
			<m_connection>user.browse</m_connection>
			<var_name>menu_user_top_rated_members</var_name>
			<ordering>93</ordering>
			<url_value>user.browse.view_top</url_value>
			<version_id>2.0.0</version_id>
			<disallow_access />
			<module>user</module>
			<value />
		</menu>
	</menus>
	<hooks>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_auth_login__start</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_auth_login__no_user_name</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_auth_login__password</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_auth_login__cookie_start</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_auth_login__cookie_end</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_auth_login__end</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_auth_logout__start</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>service</hook_type>
			<module>user</module>
			<call_name>user.service_auth_logout__end</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>controller</hook_type>
			<module>user</module>
			<call_name>user.component_controller_browse_genders_top_users</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_login_block__start</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
		<hook>
			<module_id>user</module_id>
			<hook_type>template</hook_type>
			<module>user</module>
			<call_name>user.template_controller_login_block__end</call_name>
			<added>1261572640</added>
			<version_id>2.0.0</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="controller">browse.html.php</file>
		<file type="block">login-block.html.php</file>
		<file type="block">filter.html.php</file>
	</update_templates>
</upgrade>