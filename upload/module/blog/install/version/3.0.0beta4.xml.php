<upgrade>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>blog</module_id>
			<component>categories</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_rss>
		<feed>
			<module_id>blog</module_id>
			<group_id>1</group_id>
			<title_var>blog.rss_title_1</title_var>
			<description_var>blog.rss_description_1</description_var>
			<feed_link>blog</feed_link>
			<is_active>1</is_active>
			<is_site_wide>1</is_site_wide>
			<php_group_code />
			<php_view_code><![CDATA[$aRows = $this->database()->select('bt.text_parsed, b.blog_id, u.user_name, u.full_name')
	->from(Phpfox::getT('blog'), 'b')
	->join(Phpfox::getT('user'), 'u', 'u.user_id = b.blog_id')
	->join(Phpfox::getT('blog_text'), 'bt','bt.blog_id = b.blog_id')
	->where('b.is_approved = 1 AND b.privacy = 1 AND b.post_status = 1')
	->limit(Phpfox::getParam('rss.total_rss_display'))
	->order('b.blog_id DESC')
	->execute('getSlaveRows');
$iCnt = count($aRows);

foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['description'] = $aRow['text'];
	$aRows[$iKey]['link'] = Phpfox::permaLink('blog', $aRow['blog_id'], $aRow['title']);
	$aRows[$iKey]['creator'] = $aRow['full_name'];
}
]]></php_view_code>
		</feed>
		<feed>
			<module_id>blog</module_id>
			<group_id>1</group_id>
			<title_var>blog.rss_title_2</title_var>
			<description_var>blog.rss_description_2</description_var>
			<feed_link>blog.category.{TITLE_URL}</feed_link>
			<is_active>1</is_active>
			<is_site_wide>0</is_site_wide>
			<php_group_code><![CDATA[$aCategories = $this->database()->select('category_id, name')
	->from(Phpfox::getT('blog_category'))
	->where('user_id = 0')
	->execute('getSlaveRows');
if (count($aCategories))
{
	foreach ($aCategories as $aCategory)
	{
		$aRow['child'][Phpfox::getLib('phpfox.url')->makeUrl('rss', array('id' => $aRow['feed_id'], 'category' => $aCategory['category_id']))] = $aCategory['name'];
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
	</phpfox_update_rss>
</upgrade>