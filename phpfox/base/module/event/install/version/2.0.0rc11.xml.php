<upgrade>
	<phrases>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>user_setting_can_access_event</var_name>
			<added>1260286460</added>
			<value>Can browse and view the event module?</value>
		</phrase>
		<phrase>
			<module_id>event</module_id>
			<version_id>2.0.0rc11</version_id>
			<var_name>user_setting_can_create_event</var_name>
			<added>1260329621</added>
			<value>Can create an event?</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>event</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>1</guest>
			<staff>1</staff>
			<module>event</module>
			<ordering>0</ordering>
			<value>can_access_event</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>event</module_id>
			<type>boolean</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>event</module>
			<ordering>0</ordering>
			<value>can_create_event</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>event</module_id>
			<hook_type>service</hook_type>
			<module>event</module>
			<call_name>event.service_process_add__end</call_name>
			<added>1260366442</added>
			<version_id>2.0.0rc11</version_id>
			<value />
		</hook>
	</hooks>
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
$aConditions[] = 'm.view_id = 0 AND m.module_id = \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'event\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\' AND m.item_id = 0';
$aConditions[] = 'AND m.start_time >= \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'' . $iTimeDisplay . '\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'';
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
	<update_templates>
		<file type="controller">add.html.php</file>
		<file type="controller">index.html.php</file>
	</update_templates>
</upgrade>