<upgrade>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.6</version_id>
			<var_name>time_separator</var_name>
			<added>1284989757</added>
			<value><![CDATA[&nbsp;&nbsp;at&nbsp;&nbsp;]]></value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>setting_blog_display_user_post_count</var_name>
			<added>1217808470</added>
			<value><![CDATA[<title>Display Post Count for Categories (Personal)</title><info>If set to <b>True</b> we will display a users post count for a specific category. This will be displayed on their profile, blog and when browsing their own blogs.

Notice: This will add an extra strain to your server if set to <b>True</b>.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0alpha1</version_id>
			<var_name>setting_profile_use_id</var_name>
			<added>1221724040</added>
			<value><![CDATA[<title>Profile User ID Connection</title><info>Set to <b>True</b> if you would like to have user profiles connected via their user ID#. Set to <b>False</b> if you would like to have user profiles connected via their user name. 

Note if you connect via their user ID# you will allow your members the ability to use non-supported characters which are not allowed if connecting a profile with their user name.

<b>Warning:</b> This action cannot be reversed.
This setting may lock users out if you force log in by their user names
</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
	<update_templates>
		<file type="block">currency.html.php</file>
	</update_templates>
	<update_styles>
		<file type="layout">forum.css</file>
		<file type="layout">common.css</file>
	</update_styles>
</upgrade>