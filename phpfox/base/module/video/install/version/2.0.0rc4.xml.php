<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>drop</type>
			<var_name>show_share_and_upload_video_on_dashboard</var_name>
			<phrase_var_name>setting_show_share_and_upload_video_on_dashboard</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc3</version_id>
			<value><![CDATA[a:2:{s:7:"default";s:5:"share";s:6:"values";a:3:{i:0;s:5:"share";i:1;s:6:"upload";i:2;s:4:"both";}}]]></value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>manage_videos</var_name>
			<added>1255354432</added>
			<value>Manage Videos</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>your_video_title_has_been_approved</var_name>
			<added>1255354861</added>
			<value><![CDATA[Your video "{title}" has been approved.]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>view_videos</var_name>
			<added>1255354886</added>
			<value>View Videos</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>a_href_user_link_owner_full_name_a_added_a_new_video_a_href_title_link_title_a</var_name>
			<added>1255354930</added>
			<value><![CDATA[<a href="{user_link}">{owner_full_name}</a> added a new video "<a href="{title_link}">{title}</a>".]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_video_a</var_name>
			<added>1255355112</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">video</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_video_a</var_name>
			<added>1255355165</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">video</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link_item_user_name_s_a_a_href_title_link_video_a</var_name>
			<added>1255355190</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">video</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>on_name_s_video</var_name>
			<added>1255355310</added>
			<value><![CDATA[On {name}'s video.]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>user_name_left_you_a_comment_on_site_title</var_name>
			<added>1255355342</added>
			<value>{user_name} left you a comment on {site_title}.</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>user_name_left_you_a_comment_on_your_video_title</var_name>
			<added>1255355395</added>
			<value><![CDATA[{user_name} left you a comment on your video "{title}".

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>video_text</var_name>
			<added>1255860208</added>
			<value>Video Text</value>
		</phrase>
	</phrases>
	<update_templates>
		<file type="controller">category.html.php</file>
		<file type="controller">convert.html.php</file>
		<file type="controller">edit.html.php</file>
		<file type="controller">frame.html.php</file>
		<file type="controller">group.html.php</file>
		<file type="controller">index.html.php</file>
		<file type="controller">profile.html.php</file>
		<file type="controller">share.html.php</file>
		<file type="controller">upload.html.php</file>
		<file type="controller">view.html.php</file>
		<file type="block">category.html.php</file>
		<file type="block">detail.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">filter.html.php</file>
		<file type="block">form.html.php</file>
		<file type="block">install.html.php</file>
		<file type="block">menu.html.php</file>
		<file type="block">mini.html.php</file>
		<file type="block">my.html.php</file>
		<file type="block">new.html.php</file>
		<file type="block">parent.html.php</file>
		<file type="block">profile.html.php</file>
		<file type="block">related.html.php</file>
		<file type="block">spotlight.html.php</file>
	</update_templates>
</upgrade>