<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>comment</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>allow_comments_on_profiles</var_name>
			<phrase_var_name>setting_allow_comments_on_profiles</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc4</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>setting_allow_comments_on_profiles</var_name>
			<added>1255773488</added>
			<value><![CDATA[<title>Allow Comments on Profile</title><info>Enable this feature to allow comments on profiles.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>loading</var_name>
			<added>1255779973</added>
			<value>Loading</value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>view_all_total_left_comments</var_name>
			<added>1255780014</added>
			<value>View all {total_left} comments</value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>comments_text</var_name>
			<added>1255860241</added>
			<value>Comments Text</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc2</version_id>
			<var_name>view_replies_total_to_this_comment</var_name>
			<added>1253003246</added>
			<value>View replies ({total}) to this comment.</value>
		</phrase>
	</phpfox_update_phrases>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="controller">rss.html.php</file>
		<file type="controller">view.html.php</file>
		<file type="block">display.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">mini.html.php</file>
		<file type="block">moderate.html.php</file>
		<file type="block">rating.html.php</file>
	</update_templates>
</upgrade>