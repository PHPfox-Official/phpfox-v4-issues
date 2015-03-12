<upgrade>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.1.0rc1</version_id>
			<var_name>menu_feed_news_feed_532c28d5412dd75bf975fb951c740a30</var_name>
			<added>1332257737</added>
			<value>News Feed</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>comments_on_profiles</var_name>
			<added>1334579341</added>
			<value>Comments on Profiles</value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>feed</module_id>
			<parent_var_name />
			<m_connection>mobile</m_connection>
			<var_name>menu_feed_news_feed_532c28d5412dd75bf975fb951c740a30</var_name>
			<ordering>116</ordering>
			<url_value>feed</url_value>
			<version_id>3.1.0rc1</version_id>
			<disallow_access />
			<module>feed</module>
			<mobile_icon>small_activity-feed.png</mobile_icon>
			<value />
		</menu>
	</menus>
	<hooks>
		<hook>
			<module_id>feed</module_id>
			<hook_type>service</hook_type>
			<module>feed</module>
			<call_name>feed.service_feed_getsharelinks__start</call_name>
			<added>1334069444</added>
			<version_id>3.2.0beta1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>