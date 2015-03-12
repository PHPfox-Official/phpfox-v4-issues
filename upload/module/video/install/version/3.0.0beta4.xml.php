<upgrade>
	<components>
		<component>
			<module_id>video</module_id>
			<component>featured</component>
			<m_connection />
			<module>video</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>video</module_id>
			<component>featured</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>featured</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>video</module_id>
			<component>sponsored</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<phpfox_update_rss>
		<feed>
			<module_id>video</module_id>
			<group_id>4</group_id>
			<title_var>video.rss_title_5</title_var>
			<description_var>video.rss_description_5</description_var>
			<feed_link>video</feed_link>
			<is_active>1</is_active>
			<is_site_wide>1</is_site_wide>
			<php_group_code />
			<php_view_code><![CDATA[$oDb = Phpfox::getLib('database');

$aConditions = array();
$aConditions[] = "v.in_process = 0 AND v.view_id = 0 AND v.module_id = 'video' AND v.item_id = 0";
$aRows = $oDb->select('u.user_name, u.full_name, vt.text_parsed as text, v.title, v.video_id')
	->from(Phpfox::getT('video'),'v')
	->join(Phpfox::getT('user'),'u', 'u.user_id = v.user_id')
->leftJoin(Phpfox::getT('video_text'),'vt','vt.video_id = v.video_id')			->where($aConditions)
			->limit(Phpfox::getParam('rss.total_rss_display'))
			->order('v.time_stamp DESC')
			->execute('getSlaveRows');		   
		
foreach ($aRows as $iKey => $aRow)
{
   $aRows[$iKey]['link'] = Phpfox::getLib('phpfox.url')->makeUrl($aRow['user_name'], array('video', $aRow['title_url']));
		   $aRows[$iKey]['creator'] = $aRow['full_name'];
		   $aRows[$iKey]['description'] = (isset($aRow['text']) ? $aRow['text'] : '');
		}]]></php_view_code>
		</feed>
	</phpfox_update_rss>
</upgrade>