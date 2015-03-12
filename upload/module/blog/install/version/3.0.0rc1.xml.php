<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>blog</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>length_in_index</var_name>
			<phrase_var_name>setting_length_in_index</phrase_var_name>
			<ordering>1</ordering>
			<version_id>30</version_id>
			<value>200</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>blog</module_id>
			<version_id>3.0.0rc1</version_id>
			<var_name>see_more</var_name>
			<added>1320076456</added>
			<value>See More</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>blog</module_id>
			<hook_type>component</hook_type>
			<module>blog</module>
			<call_name>blog.component_ajax_addviastatusupdate</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>blog</module_id>
			<hook_type>component</hook_type>
			<module>blog</module>
			<call_name>blog.component_block_share_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>blog</module_id>
			<hook_type>service</hook_type>
			<module>blog</module>
			<call_name>blog.component_service_blog_gettotaldrafts</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>blog</module_id>
			<hook_type>service</hook_type>
			<module>blog</module>
			<call_name>blog.service_browse__call</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
	</hooks>
	<phpfox_update_rss>
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
			<php_view_code><![CDATA[list($iCnt, $aRows) = Phpfox::getService('blog.category')->getBlogsByCategory(Phpfox::getLib('phpfox.request')->get('category'), 0, array('AND blog.is_approved = 1 AND blog.privacy = 0 AND blog.post_status = 1'), 'blog.time_stamp DESC', 0, Phpfox::getParam('rss.total_rss_display'));

foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['description'] = $aRow['text'];
	$aRows[$iKey]['link'] = Phpfox::permalink('blog', $aRow['blog_id'], $aRow['title']);
	$aRows[$iKey]['creator'] = $aRow['full_name'];
}


$aCategory = $this->database()->select('*')
	->from(Phpfox::getT('blog_category'))
	->where('category_id = ' . (int) Phpfox::getLib('phpfox.request')->get('category'))
	->execute('getSlaveRow');

$aFeed['feed_link'] = Phpfox::permalink('blog.category', $aCategory['category_id'], $aCategory['name']);
$sDescription = $aCategory['name'];]]></php_view_code>
		</feed>
	</phpfox_update_rss>
</upgrade>