<upgrade>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.2</version_id>
			<var_name>rss_group_name_4</var_name>
			<added>1263216651</added>
			<value>Videos</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.2</version_id>
			<var_name>rss_title_5</var_name>
			<added>1263216811</added>
			<value>Latest Videos</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.2</version_id>
			<var_name>rss_description_5</var_name>
			<added>1263216811</added>
			<value>List of all the latest videos.</value>
		</phrase>
	</phrases>
	<phpfox_update_phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.0rc3</version_id>
			<var_name>no_videos_added_yet_link_to_add</var_name>
			<added>1254491516</added>
			<value><![CDATA[No videos added yet. Click <a href="{sAddNewVideoLink}"> here</a> to add a new video.]]></value>
		</phrase>
	</phpfox_update_phrases>
	<rss_group>
		<group>
			<module_id>video</module_id>
			<group_id>4</group_id>
			<name_var>video.rss_group_name_4</name_var>
			<is_active>1</is_active>
			<value />
		</group>
	</rss_group>
	<rss>
		<feed>
			<module_id>video</module_id>
			<group_id>4</group_id>
			<title_var>video.rss_title_5</title_var>
			<description_var>video.rss_description_5</description_var>
			<feed_link>video</feed_link>
			<is_active>1</is_active>
			<is_site_wide>1</is_site_wide>
			<php_group_code />
			<php_view_code><![CDATA[$oServiceVideoBrowse = Phpfox::getService('video.browse');
$aConditions = array();
$aConditions[] = "m.in_process = 0 AND m.view_id = 0 AND m.module_id = 'video' AND m.item_id = 0";
$oServiceVideoBrowse->condition($aConditions)
	->page(0)
	->full(true)
	->order('m.time_stamp DESC ')
	->size(Phpfox::getParam('rss.total_rss_display'))
	->execute();
$aRows = $oServiceVideoBrowse->get();	
foreach ($aRows as $iKey => $aRow)
{
	$aRows[$iKey]['link'] = Phpfox::getLib('phpfox.url')->makeUrl($aRow['user_name'], array('video', $aRow['title_url']));
	$aRows[$iKey]['creator'] = $aRow['full_name'];
	$aRows[$iKey]['description'] = (isset($aRow['text']) ? $aRow['text'] : '');
}]]></php_view_code>
		</feed>
	</rss>
</upgrade>