<upgrade>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>image</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>info</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>rsvp</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.index</m_connection>
			<module_id>event</module_id>
			<component>category</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>event</module_id>
			<component>profile</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>8</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>group.view</m_connection>
			<module_id>event</module_id>
			<component>parent</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.view</m_connection>
			<module_id>event</module_id>
			<component>menu</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>event.index</m_connection>
			<module_id>event</module_id>
			<component>filter</component>
			<location>1</location>
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
$aConditions[] = 'm.view_id = 0 AND m.module_id = \\\\\\\\\\\\\\\\'event\\\\\\\\\\\\\\\\' AND m.item_id = 0';
$aConditions[] = 'AND m.start_time >= \\\\\\\\\\\\\\\\'' . $iTimeDisplay . '\\\\\\\\\\\\\\\\'';
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
	</phpfox_update_rss>
</upgrade>