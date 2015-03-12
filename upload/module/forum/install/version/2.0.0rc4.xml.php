<upgrade>
	<rss_group>
		<group>
			<module_id>forum</module_id>
			<group_id>3</group_id>
			<name_var>forum.rss_group_name_3</name_var>
			<is_active>1</is_active>
			<value />
		</group>
	</rss_group>
	<rss>
		<feed>
			<module_id>forum</module_id>
			<group_id>3</group_id>
			<title_var>forum.rss_title_4</title_var>
			<description_var>forum.rss_description_4</description_var>
			<feed_link>forum</feed_link>
			<is_active>1</is_active>
			<is_site_wide>1</is_site_wide>
			<php_group_code />
			<php_view_code><![CDATA[$aRows = Phpfox::getService('forum.thread')->getForRss(Phpfox::getParam('rss.total_rss_display'));]]></php_view_code>
		</feed>
	</rss>
	<update_templates>
		<file type="controller">action.html.php</file>
		<file type="controller">forum.html.php</file>
		<file type="controller">group.html.php</file>
		<file type="controller">index.html.php</file>
		<file type="controller">post.html.php</file>
		<file type="controller">read.html.php</file>
		<file type="controller">rss.html.php</file>
		<file type="controller">search.html.php</file>
		<file type="controller">tag.html.php</file>
		<file type="controller">thread.html.php</file>
		<file type="block">copy.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">forum.html.php</file>
		<file type="block">jump.html.php</file>
		<file type="block">merge.html.php</file>
		<file type="block">move.html.php</file>
		<file type="block">parent.html.php</file>
		<file type="block">post.html.php</file>
		<file type="block">preview.html.php</file>
		<file type="block">thread-entry.html.php</file>
		<file type="block">timezone.html.php</file>
	</update_templates>
</upgrade>