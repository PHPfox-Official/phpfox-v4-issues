<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>feed</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>cache_timeout</var_name>
			<phrase_var_name>setting_feedcache_timeout</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.6</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.6</version_id>
			<var_name>setting_feedcache_timeout</var_name>
			<added>1282124296</added>
			<value><![CDATA[<title>Cache Feeds</title><info>Value is in minutes.
This greatly improves performance on sites with a medium to large user base</info>]]></value>
		</phrase>
	</phrases>
	<update_templates>
		<file type="block">display.html.php</file>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>