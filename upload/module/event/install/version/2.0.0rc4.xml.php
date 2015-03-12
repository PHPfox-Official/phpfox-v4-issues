<upgrade>
	<phrases>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>a_href_user_link_user_name_a_added_a_comment_on_the_event_a_href_title_link_title_a</var_name>
			<added>1255941112</added>
			<value><![CDATA[<a href="{user_link}">{user_name}</a> added a comment on the event "<a href="{title_link}">{title}</a>".]]></value>
		</phrase>
	</phrases>
	<rss_group>
		<group>
			<module_id>event</module_id>
			<group_id>2</group_id>
			<name_var>event.rss_group_name_2</name_var>
			<is_active>1</is_active>
			<value />
		</group>
	</rss_group>
	<rss>
		<feed>
			<module_id>event</module_id>
			<group_id>2</group_id>
			<title_var>event.rss_title_3</title_var>
			<description_var>event.rss_description_3</description_var>
			<feed_link>event</feed_link>
			<is_active>1</is_active>
			<is_site_wide>1</is_site_wide>
			<php_group_code />
			<php_view_code><![CDATA[$oServiceEventBrowse = Phpfox::getService('event.browse');
$iTimeDisplay = Phpfox::getLib('phpfox.date')->mktime(0, 0, 0, Phpfox::getTime('m'), Phpfox::getTime('d'), Phpfox::getTime('Y'));
$aConditions = array();
$aConditions[] = 'm.view_id = 0 AND m.module_id = \\\\'event\\\\' AND m.item_id = 0';
$aConditions[] = 'AND m.start_time >= \\\\'' . $iTimeDisplay . '\\\\'';
$oServiceEventBrowse->condition($aConditions)
	->page(0)
	->full(true)
	->size(Phpfox::getParam('rss.total_rss_display'))
	->execute();
$aRows = $oServiceEventBrowse->get();	
foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['link'] = Phpfox::getLib('phpfox.url')->makeUrl('event.view', $aRow['title_url']);
	$aRows[$iKey]['creator'] = $aRow['full_name'];
}]]></php_view_code>
		</feed>
	</rss>
	<update_templates>
		<file type="controller">add.html.php</file>
		<file type="controller">group.html.php</file>
		<file type="controller">index.html.php</file>
		<file type="controller">view.html.php</file>
		<file type="block">category.html.php</file>
		<file type="block">filter.html.php</file>
		<file type="block">image.html.php</file>
		<file type="block">info.html.php</file>
		<file type="block">list.html.php</file>
		<file type="block">menu.html.php</file>
		<file type="block">parent.html.php</file>
		<file type="block">profile.html.php</file>
		<file type="block">rsvp.html.php</file>
	</update_templates>
</upgrade>