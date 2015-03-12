<module>
	<data>
		<module_id>mobile</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_mobile</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="mobile" parent_var_name="" m_connection="footer" var_name="menu_mobile_mobile_251d164643533a527361dbe1a7b9235d" ordering="94" url_value="mobile" version_id="2.0.4" disallow_access="" module="mobile" />
	</menus>
	<hooks>
		<hook module_id="mobile" hook_type="service" module="mobile" call_name="mobile.service_process__call" added="1267629983" version_id="2.0.4" />
		<hook module_id="mobile" hook_type="service" module="mobile" call_name="mobile.service_callback__call" added="1267629983" version_id="2.0.4" />
		<hook module_id="mobile" hook_type="service" module="mobile" call_name="mobile.service_mobile__call" added="1267629983" version_id="2.0.4" />
		<hook module_id="mobile" hook_type="controller" module="mobile" call_name="mobile.component_controller_index_mobile_clean" added="1267629983" version_id="2.0.4" />
		<hook module_id="mobile" hook_type="controller" module="mobile" call_name="mobile.component_controller_index_clean" added="1267629983" version_id="2.0.4" />
	</hooks>
	<phrases>
		<phrase module_id="mobile" version_id="2.0.4" var_name="module_mobile" added="1267105228">Mobile</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="mobile" added="1267628774">Mobile</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="to_view_our_mobile_site_visit" added="1267628825">To view our mobile site visit:</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="menu_mobile_mobile_251d164643533a527361dbe1a7b9235d" added="1267628860">Mobile</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="home" added="1267629890">Home</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="profile" added="1267629900">Profile</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="friends" added="1267629907">Friends</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="mail" added="1267629913">Mail</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="full_site" added="1267629927">Full Site</phrase>
		<phrase module_id="mobile" version_id="2.0.4" var_name="logout" added="1267629934">Logout</phrase>
		<phrase module_id="mobile" version_id="3.0.0" var_name="notifications" added="1322737627">Notifications</phrase>
		<phrase module_id="mobile" version_id="3.7.4" var_name="mobile_icon" added="1386000583">Mobile Icon</phrase>
	</phrases>
	<pages>
		<page module_id="mobile" is_phrase="1" has_bookmark="0" parse_php="1" add_view="0" full_size="1" title="mobile.mobile" title_url="mobile-info" added="1267628853">
			<keyword></keyword>
			<description></description>
			<text><![CDATA[{phrase var='mobile.to_view_our_mobile_site_visit'} <a href="{url link='mobile'}" class="no_ajax_link">{url link='mobile'}</a>]]></text>
			<text_parsed><![CDATA[<?php /* Cached: November 14, 2011, 2:23 pm */ ?>
<?php echo Phpfox::getPhrase('mobile.to_view_our_mobile_site_visit'); ?> <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('mobile'); ?>" class="no_ajax_link"><?php echo Phpfox::getLib('phpfox.url')->makeUrl('mobile'); ?></a>]]></text_parsed>
		</page>
	</pages>
</module>