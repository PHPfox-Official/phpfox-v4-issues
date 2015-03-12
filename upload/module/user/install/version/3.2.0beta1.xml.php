<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>user</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>shorter_password_reset_routine</var_name>
			<phrase_var_name>setting_shorter_password_reset_routine</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.1.0rc1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.1.0rc1</version_id>
			<var_name>setting_shorter_password_reset_routine</var_name>
			<added>1332231623</added>
			<value><![CDATA[<title>Shorter Password Reset Routine</title><info>If this is enabled when a user clicks on Forgot your password he will receive an email with a link, when clicking on the link he will be shown an input where to change the password. The site will not assign a new password to that user and the previous password will work until it has been reset.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.1.0rc1</version_id>
			<var_name>request_expired_please_try_again</var_name>
			<added>1332235241</added>
			<value>Request expired. Please try again.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.1.0rc1</version_id>
			<var_name>menu_user_members_532c28d5412dd75bf975fb951c740a30</var_name>
			<added>1332258017</added>
			<value>Members</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>set_as_cover_photo</var_name>
			<added>1334069903</added>
			<value>Set as Cover Photo</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>set_this_photo_as_your_profile_cover_photo</var_name>
			<added>1334069940</added>
			<value>Set this photo as your profile cover photo.</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>add_a_cover</var_name>
			<added>1334155780</added>
			<value>Add a Cover</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>change_cover</var_name>
			<added>1334155789</added>
			<value>Change Cover</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>choose_from_photos</var_name>
			<added>1334155795</added>
			<value>Choose From Photos</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>upload_photo</var_name>
			<added>1334155802</added>
			<value>Upload Photo</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>reposition</var_name>
			<added>1334155808</added>
			<value>Reposition</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>remove</var_name>
			<added>1334155814</added>
			<value>Remove</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>drag_to_reposition_cover</var_name>
			<added>1334155838</added>
			<value>Drag to Reposition Cover</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>cancel_cover_photo</var_name>
			<added>1334155858</added>
			<value>Cancel</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>select_a_photo</var_name>
			<added>1334155876</added>
			<value>Select a Photo</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>upload</var_name>
			<added>1334155888</added>
			<value>Upload</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>status_updates</var_name>
			<added>1334579416</added>
			<value>Status Updates</value>
		</phrase>
		<phrase>
			<module_id>user</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>who_can_tag_me_in_written_contexts</var_name>
			<added>1334583235</added>
			<value>Who can tag me in written contexts?</value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>user</module_id>
			<parent_var_name />
			<m_connection>mobile</m_connection>
			<var_name>menu_user_members_532c28d5412dd75bf975fb951c740a30</var_name>
			<ordering>126</ordering>
			<url_value>user.browse</url_value>
			<version_id>3.1.0rc1</version_id>
			<disallow_access />
			<module>user</module>
			<mobile_icon>small_groups.png</mobile_icon>
			<value />
		</menu>
	</menus>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:17:"phpfox_user_field";a:2:{s:11:"cover_photo";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"cover_photo_top";a:4:{i:0;s:7:"VCHAR:5";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>