<upgrade>
	<rss_group>
		<group>
			<module_id>blog</module_id>
			<group_id>1</group_id>
			<name_var>blog.rss_group_name_1</name_var>
			<is_active>1</is_active>
			<value />
		</group>
	</rss_group>
	<rss>
		<feed>
			<module_id>blog</module_id>
			<group_id>1</group_id>
			<title_var>blog.rss_title_1</title_var>
			<description_var>blog.rss_description_1</description_var>
			<feed_link>blog</feed_link>
			<is_active>1</is_active>
			<is_site_wide>1</is_site_wide>
			<php_group_code />
			<php_view_code><![CDATA[list($iCnt, $aRows) = Phpfox::getService('blog')->get(array('AND blog.is_approved = 1 AND blog.privacy = 1 AND blog.post_status = 1'), 'blog.time_stamp DESC', 0, Phpfox::getParam('rss.total_rss_display'));
foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['description'] = $aRow['text'];
	$aRows[$iKey]['link'] = Phpfox::itemUrl('blog', $aRow['title_url'], $aRow['user_name']);
	$aRows[$iKey]['creator'] = $aRow['full_name'];
}]]></php_view_code>
		</feed>
		<feed>
			<module_id>blog</module_id>
			<group_id>1</group_id>
			<title_var>blog.rss_title_2</title_var>
			<description_var>blog.rss_description_2</description_var>
			<feed_link>blog.category.{TITLE_URL}</feed_link>
			<is_active>1</is_active>
			<is_site_wide>0</is_site_wide>
			<php_group_code><![CDATA[$aCategories = $this->database()->select('category_id, name, name_url')
	->from(Phpfox::getT('blog_category'))
	->where('user_id = 0')
	->execute('getSlaveRows');
if (count($aCategories))
{
	foreach ($aCategories as $aCategory)
	{
		$aRow['child'][Phpfox::getLib('phpfox.url')->makeUrl('rss', array('id' => $aRow['feed_id'], 'category' => $aCategory['name_url']))] = $aCategory['name'];
	}
}]]></php_group_code>
			<php_view_code><![CDATA[list($iCnt, $aRows) = Phpfox::getService('blog.category')->getBlogsByCategory(Phpfox::getLib('phpfox.request')->get('category'), 0, array('AND blog.is_approved = 1 AND blog.privacy = 1 AND blog.post_status = 1'), 'blog.time_stamp DESC', 0, Phpfox::getParam('rss.total_rss_display'));
foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['description'] = $aRow['text'];
	$aRows[$iKey]['link'] = Phpfox::itemUrl('blog', $aRow['title_url'], $aRow['user_name']);
	$aRows[$iKey]['creator'] = $aRow['full_name'];
}
if (isset($aRows[0]))
{
	$aFeed['feed_link'] = str_replace('{TITLE_URL}', $aRows[0]['category_name_url'], $aFeed['feed_link']);
	$sDescription = str_replace('{CATEGORY}', $aRows[0]['category_name'], $sDescription);
}]]></php_view_code>
		</feed>
	</rss>
	<update_templates>
		<file type="block">new.html.php</file>
	</update_templates>
</upgrade>