<upgrade>
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
			<php_view_code><![CDATA[$aRows = $this->database()->select('bt.text_parsed AS text, b.blog_id, b.title, u.user_name, u.full_name, b.time_stamp')
	->from(Phpfox::getT('blog'), 'b')
	->join(Phpfox::getT('user'), 'u', 'u.user_id = b.blog_id')
	->join(Phpfox::getT('blog_text'), 'bt','bt.blog_id = b.blog_id')
	->where('b.is_approved = 1 AND b.privacy = 0 AND b.post_status = 1')
	->limit(Phpfox::getParam('rss.total_rss_display'))
	->order('b.blog_id DESC')
	->execute('getSlaveRows');
$iCnt = count($aRows);

foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['description'] = $aRow['text'];
	$aRows[$iKey]['link'] = Phpfox::permaLink('blog', $aRow['blog_id'], $aRow['title']);
	$aRows[$iKey]['creator'] = $aRow['full_name'];
}]]></php_view_code>
		</feed>
	</phpfox_update_rss>
</upgrade>