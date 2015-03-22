<module>
	<data>
		<module_id>ad</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:6:{s:33:"ad.admin_menu_create_new_campaign";a:1:{s:3:"url";a:2:{i:0;s:2:"ad";i:1;s:3:"add";}}s:30:"ad.admin_menu_manage_campaigns";a:1:{s:3:"url";a:1:{i:0;s:2:"ad";}}s:31:"ad.admin_menu_manage_placements";a:1:{s:3:"url";a:2:{i:0;s:2:"ad";i:1;s:9:"placement";}}s:26:"ad.admin_menu_ad_placement";a:1:{s:3:"url";a:3:{i:0;s:2:"ad";i:1;s:9:"placement";i:2;s:3:"add";}}s:22:"ad.admin_menu_invoices";a:1:{s:3:"url";a:2:{i:0;s:2:"ad";i:1;s:7:"invoice";}}s:33:"ad.admin_menu_manage_sponsorships";a:1:{s:3:"url";a:2:{i:0;s:2:"ad";i:1;s:7:"sponsor";}}}]]></menu>
		<phrase_var_name>module_ad</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:12:"file/pic/ad/";}]]></writable>
	</data>
	<menus>
		<menu module_id="ad" parent_var_name="" m_connection="ad" var_name="menu_ad_create_an_ad_523af537946b79c4f8369ed39ba78605" ordering="95" url_value="ad.add" version_id="2.0.5" disallow_access="" module="ad" />
		<menu module_id="ad" parent_var_name="" m_connection="footer" var_name="menu_ad_advertise_251d164643533a527361dbe1a7b9235d" ordering="98" url_value="ad" version_id="2.0.5" disallow_access="" module="ad" />
	</menus>
	<settings>
		<setting group="" module_id="ad" is_hidden="0" type="integer" var_name="ad_cache_limit" phrase_var_name="setting_ad_cache_limit" ordering="1" version_id="2.0.0beta3">60</setting>
		<setting group="" module_id="ad" is_hidden="0" type="boolean" var_name="ad_ajax_refresh" phrase_var_name="setting_ad_ajax_refresh" ordering="1" version_id="2.0.0beta3">0</setting>
		<setting group="" module_id="ad" is_hidden="0" type="integer" var_name="ad_ajax_refresh_time" phrase_var_name="setting_ad_ajax_refresh_time" ordering="1" version_id="2.0.0beta3">2</setting>
		<setting group="" module_id="ad" is_hidden="0" type="boolean" var_name="enable_ads" phrase_var_name="setting_enable_ads" ordering="1" version_id="2.0.0beta3">1</setting>
		<setting group="" module_id="ad" is_hidden="0" type="integer" var_name="how_many_ads_per_location" phrase_var_name="setting_how_many_ads_per_location" ordering="1" version_id="3.2.0beta1">1</setting>
		<setting group="" module_id="ad" is_hidden="0" type="boolean" var_name="advanced_ad_filters" phrase_var_name="setting_advanced_ad_filters" ordering="1" version_id="3.4.0beta1">0</setting>
		<setting group="" module_id="ad" is_hidden="0" type="boolean" var_name="multi_ad" phrase_var_name="setting_multi_ad" ordering="1" version_id="3.7.0beta1">0</setting>
		<setting group="" module_id="ad" is_hidden="0" type="integer" var_name="ad_multi_ad_count" phrase_var_name="setting_ad_multi_ad_count" ordering="1" version_id="3.7.0beta1">5</setting>
	</settings>
	<hooks>
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_index_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_index_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_add_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_sample_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_block_display_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_block_sample_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_callback__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_construct__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_updateactivity__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_updateactivity__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_update__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_update__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_delete__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_delete__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_add__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_add__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_get__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_get__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getforblock__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getforblock__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getadredirect__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getadredirect__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getforedit__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getforedit__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getsizes__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getsizes__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_callback_construct__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_ajax_update__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_ajax_update__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_iframe_clean" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_process__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_add_process__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_add_process__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_process__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_process__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_block_display_process__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_block_display_process__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="template" module="ad" call_name="ad.template_block_display__start" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="template" module="ad" call_name="ad.template_block_display__end" added="1263387694" version_id="2.0.2" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_preview_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_invoice_index_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_image_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_add_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_manage_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_invoice_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_placement_add_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_placement_index_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_block_sponsored_clean" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="template" module="ad" call_name="ad.template_controller_index" added="1271160844" version_id="2.0.5" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getadsponsor__start" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_sponsor_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_sponsor_process__start" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_sponsor_process__end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="ad" hook_type="controller" module="ad" call_name="ad.component_controller_admincp_sponsor__clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_deleteinvoice__start" added="1286546859" version_id="2.0.7" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_process_addcustom_before_insert_ad" added="1286546859" version_id="2.0.7" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_process_addcustom_before_insert_invoice" added="1286546859" version_id="2.0.7" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_block_inner_process__start" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="ad" hook_type="component" module="ad" call_name="ad.component_block_inner_process__end" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="ad" hook_type="service" module="ad" call_name="ad.service_ad_getforblock__1" added="1361180401" version_id="3.5.0rc1" />
	</hooks>
	<components>
		<component module_id="ad" component="sponsored" m_connection="" module="ad" is_controller="0" is_block="1" is_active="1" />
		<component module_id="ad" component="index" m_connection="index" module="ad" is_controller="1" is_block="0" is_active="1" />
		<component module_id="ad" component="manage-sponsor" m_connection="ad.manage-sponsor" module="ad" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="ad" version_id="2.0.0beta3" var_name="admin_menu_create_new_campaign" added="1243091789">Create New Campaign</phrase>
		<phrase module_id="ad" version_id="2.0.0beta3" var_name="admin_menu_manage_campaigns" added="1243091789">Manage Campaigns</phrase>
		<phrase module_id="ad" version_id="2.0.0beta3" var_name="module_ad" added="1243091789">Ad Management</phrase>
		<phrase module_id="ad" version_id="2.0.0beta3" var_name="setting_ad_cache_limit" added="1243185354"><![CDATA[<title>Ad Cache Limit (Minutes)</title><info>Define in minutes how long we should cache ads.</info>]]></phrase>
		<phrase module_id="ad" version_id="2.0.0beta3" var_name="setting_ad_ajax_refresh" added="1243185608"><![CDATA[<title>Refresh Ads (AJAX)</title><info>Enable this feature to refresh ads via AJAX.</info>]]></phrase>
		<phrase module_id="ad" version_id="2.0.0beta3" var_name="setting_ad_ajax_refresh_time" added="1243185732"><![CDATA[<title>Ad Refresh Time (Minutes)</title><info>Define how many minutes to way before the ads refresh.</info>]]></phrase>
		<phrase module_id="ad" version_id="2.0.0beta3" var_name="setting_enable_ads" added="1243241593"><![CDATA[<title>Enable Ads</title><info>Set to <b>True</b> in order to enable ads.</info>]]></phrase>
		<phrase module_id="ad" version_id="30" var_name="user_setting_show_ads" added="1247583832">Should ads be shown to members of this user group?</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="select_a_banner_type" added="1252753837">Select a banner type.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="provide_a_name_for_this_campaign" added="1252753852">Provide a name for this campaign.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="provide_a_link_for_your_banner" added="1252753867">Provide a link for your banner.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="provide_html_for_your_banner" added="1252753880">Provide HTML for your banner.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="ad_successfully_updated" added="1252753898">Ad successfully updated.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="ad_successfully_added" added="1252753912">Ad successfully added.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="create_new_campaign" added="1252753952">Create New Campaign</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="ad_successfully_deleted" added="1252753984">Ad successfully deleted.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="ad_s_successfully_updated" added="1252753996">Ad(s) successfully updated.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="manage_ad_campaigns" added="1252754009">Manage Ad Campaigns</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="live" added="1252754044">Live</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="inactive" added="1252754056">Inactive</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="pending" added="1252754087">Pending</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="the_ad_you_are_looking_for_does_not_exist" added="1252754114">The ad you are looking for does not exist.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="unable_to_find_this_ad" added="1252754128">Unable to find this ad.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="unable_to_find_the_ad_you_want_to_delete" added="1252754169">Unable to find the ad you want to delete.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="media" added="1252754277">Media</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="banner_type" added="1252754868">Banner Type</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="image" added="1252755783">Image</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="html" added="1252755791">HTML</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="banner_image" added="1252755809">Banner Image</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="click_here_to_change_this_banner_image" added="1252755843"><![CDATA[Click <a href="#" onclick="$('#js_ad_upload_banner').show(); $('#js_ad_banner').hide(); return false;">here</a> to change this banner image.]]></phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1252755856">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="cancel" added="1252755868">cancel</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="banner_link" added="1252755962">Banner Link</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="campaign_details" added="1252755974">Campaign Details</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="campaign_name" added="1252755984">Campaign Name</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="start_date" added="1252755996">Start Date</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="end_date" added="1252756009">End Date</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="do_not_end_this_campaign" added="1252756023">Do not end this campaign.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="end_on_a_specific_date" added="1252756033">End on a specific date.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="total_views" added="1252756046">Total Views</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="unlimited" added="1252756064">Unlimited</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="total_clicks" added="1252756100">Total Clicks</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="active" added="1252756118">Active</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="placement" added="1252756132">Placement</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="block_placement" added="1252756143">Block Placement</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="view_site_layout" added="1252756155">View Site Layout</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="notice_the_ad_sizes_provided_is_a_recommendation" added="1252756164">Notice: The ad sizes provided is a recommendation.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="audience" added="1252756171">Audience</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="user_groups" added="1252756180">User Groups</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="all_user_groups" added="1252756189">All User Groups</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="selected_user_groups" added="1252756197">Selected User Groups</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="location" added="1252756209">Location</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="gender" added="1252756218">Gender</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="age_group_between" added="1252756226">Age Group Between</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="any" added="1252756234">Any</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="min_age_cannot_be_higher_than_max_age" added="1252756315">Min age cannot be higher than max age.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="max_age_cannot_be_lower_than_the_min_age" added="1252756568">Max age cannot be lower than the Min age.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="ads" added="1252756602">Ads</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="id" added="1252756610">ID</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="name" added="1252756618">Name</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="status" added="1252756626">Status</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="views" added="1252756642">Views</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="clicks" added="1252756682">Clicks</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="edit" added="1252756691">Edit</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="delete" added="1252756699">Delete</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="no_ads_have_been_created" added="1252756733">No ads have been created.</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="add_a_new_add" added="1252756768">Add a New Ad</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="cache_manager" added="1252757546">Cache Manager</phrase>
		<phrase module_id="ad" version_id="2.0.0rc2" var_name="note_the_time_is_set_to_your_registered_time_zone" added="1253448407">Note the time is set to your registered time zone.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="advertise" added="1269358548">Advertise</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="creating_an_ad" added="1269358674">Creating an Ad</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="there_are_pending_ads_that_require_your_attention_view_all_pending_ads_a_href_link_here_a" added="1270622615"><![CDATA[There are pending ads that require your attention. View all pending ads <a href="{link}">here</a>.]]></phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="approve" added="1270625082">Approve</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="deny" added="1270625107">Deny</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="view_edit" added="1270625193">View/Edit</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="preview_this_ad" added="1270629557">Preview This Ad</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="no_search_results_were_found" added="1270632300">No search results were found.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="pending_approval" added="1270634365">Pending Approval</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="denied" added="1270638343">Denied</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_filter" added="1270638612">Ad Filter</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="type" added="1270638651">Type</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="display" added="1270638660">Display</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="sort_by" added="1270638669">Sort By</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_successfully_approved" added="1270639259">Ad successfully approved.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_successfully_denied" added="1270639290">Ad successfully denied.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="manage" added="1270641630">Manage</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="n_a" added="1270641646">N/A</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="recently_added" added="1270642427">Recently Added</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="pending_payment" added="1270642444">Pending Payment</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="unable_to_edit_purchase_this_ad" added="1270642518">Unable to edit/purchase this ad.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="not_a_valid_ad_plan" added="1270642532">Not a valid ad plan.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="your_ad_has_successfully_been_submitted_to_complete_the_process_continue_with_paying_below" added="1270646738">Your ad has successfully been submitted. To complete the process continue with paying below.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="payment_methods" added="1270646751">Payment Methods</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="image_placement" added="1270646772"><![CDATA[[Image Placement]]]></phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="example_ad" added="1270646787">Example Ad</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="this_is_a_sample_ad" added="1270646804">This is a sample ad.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="1_ad_design" added="1270646819">1. Ad Design</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="create_an_ad" added="1270646829">Create an Ad</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="upload_an_ad" added="1270646837">Upload an Ad</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_placement" added="1270646848">Ad Placement</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="change" added="1270646872">Change</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="select_a_position" added="1270646879">Select a Position</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="background_color" added="1270647281">Background Color</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="select" added="1270647289">Select</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="border_color" added="1270647301">Border Color</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="text_color" added="1270647308">Text Color</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="title" added="1270647319">Title</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="25_character_limit" added="1270647330">25 character limit.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="135_character_limit" added="1270647339">135 character limit.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="body_text" added="1270647346">Body Text</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="image_optional" added="1270647361">Image (optional)</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="change_image" added="1270647371">Change Image</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="we_only_accept_the_following_extensions_gif_jpg_and_png" added="1270647382">We only accept the following extensions: GIF, JPG and PNG</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="supported_extensions_gif_jpg_and_png" added="1270647390">Supported extensions: GIF, JPG and PNG</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="destination_url" added="1270647421">Destination URL</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="example_http_www_yourwebsite_com" added="1270647431">Example: http://www.yourwebsite.com/</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="2_targeting" added="1270647443">2. Targeting</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="continue" added="1270647453">Continue</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="3_campaigns_and_pricing" added="1270647483">3. Campaigns and Pricing</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="impressions" added="1270647502">Impressions</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="recalculate_costs" added="1270647518">Recalculate Costs</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="submit" added="1270647538">Submit</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="select_an_ad_placement" added="1270647720">Select an ad placement.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_management" added="1270726614">Ad Management</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="management" added="1270726624">Management</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="approved" added="1270727477">Approved</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="campaign" added="1270727516">Campaign</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="continue_this_campaign" added="1270727549">Continue this campaign</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="pause_this_campaign" added="1270727556">Pause this campaign</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="no_ads_found" added="1270727566">No ads found.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="updating_an_ad" added="1270728858">Updating an Ad</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="the_file_dimensions_are_too_big" added="1270730916">The file dimensions are too big.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="provide_a_campaign_name" added="1270731048">Provide a campaign name.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="admin_menu_manage_placements" added="1270807089">Manage Placements</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="admin_menu_ad_placement" added="1270807089">Ad Placement</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_placement_successfully_deleted" added="1271066010">Ad placement successfully deleted.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="manage_ad_placements" added="1271066020">Manage Ad Placements</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_placements" added="1271066046">Ad Placements</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="campaigns" added="1271066068">Campaigns</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_placement_successfully_updated" added="1271066099">Ad placement successfully updated.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_placement_successfully_added" added="1271066107">Ad placement successfully added.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="add_ad_placement" added="1271066118">Add Ad Placement</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="manage_placements" added="1271066132">Manage Placements</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_placement_details" added="1271066207">Ad Placement Details</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="price" added="1271066229">Price</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="is_active" added="1271066237">Is Active</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="yes" added="1271066249">Yes</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="no" added="1271066255">No</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="provide_a_title" added="1271070431">Provide a title</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="select_a_placement" added="1271070598">Select a placement.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="provide_a_cost" added="1271070607">Provide a cost.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="select_if_this_ad_placement_is_active_or_not" added="1271070619">Select if this ad placement is active or not.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_invoices" added="1271141914">Ad Invoices</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="invoices" added="1271141922">Invoices</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="paid" added="1271141986">Paid</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="cancelled" added="1271141993">Cancelled</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="date" added="1271142436">Date</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="pay_now" added="1271142446">Pay Now</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="you_do_not_have_any_invoices" added="1271142492">You do not have any invoices.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="admin_menu_invoices" added="1271157077">Invoices</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="there_are_no_invoices" added="1271158304">There are no invoices.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="invoice_filter" added="1271158419">Invoice Filter</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="menu_ad_create_an_ad_523af537946b79c4f8369ed39ba78605" added="1271158736">Create an Ad</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="reach_your_exact_audience_and_connect_real_customers_to_your_business" added="1271159708">Reach your exact audience and connect real customers to your business.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="create_your_ad" added="1271159717">Create Your Ad</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="menu_ad_advertise_251d164643533a527361dbe1a7b9235d" added="1271159780">Advertise</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="click_on_the_ad_size_you_want_to_create_an_ad_for" added="1271160387">Click on the ad size you want to create an ad for.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="block_location_cost_cpm_1_000_views" added="1271160406">Block {location} - {cost} CPM (1,000 views)</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="1_confirm_your_item" added="1271321429">1. Confirm your Item</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="for_currency_total_cost" added="1271330091">for {currency} {total_cost}</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="impressions_cant_be_less_than_a_thousand" added="1271330965">Impressions cant be less than a thousand</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="sponsor_error_owner" added="1272015812">This item can only be sponsored by its owner or a site administrator.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="default_campaign_name" added="1272449447">Admin Created Campaign</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="manage_sponsor_campaigns" added="1272465557">Manage Sponsor Campaigns</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="admin_menu_manage_sponsorships" added="1272549823">Manage Sponsorships</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="the_currency_for_your_membership_has_no_price" added="1272971541">The currency for your membership has no price</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="the_default_currency_has_no_price" added="1272971574">The default currency has no price</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="no_placements_found" added="1273003077">No placements found.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="add_a_placement" added="1273003196">Add a Placement</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="can_create_ad_campaigns" added="1273048621">Can create ad campaigns?</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="user_setting_can_create_ad_campaigns" added="1273048700">Can create ad campaigns?</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="there_is_minimum_of_1000_impressions" added="1271337234">There is minimum of 1000 impressions.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="define_how_many_impressions_for_this_ad" added="1271337402">Define how many impressions for this ad.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="provide_a_title_for_your_ad" added="1271403313">Provide a title for your ad.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="provide_text_for_your_ad" added="1271403325">Provide text for your ad.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="provide_a_url_for_your_ad" added="1271403334">Provide a URL for your ad.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="select_an_image_for_your_ad" added="1271942180">Select an image for your ad.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="thank_you_for_your_purchase_your_ad_is_currently_pending_approval" added="1271942565">Thank you for your purchase. Your ad is currently pending approval.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="no_ad_placements_have_been_created_check_back_here_shortly" added="1273050956">No ad placements have been created. Check back here shortly.</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_approved" added="1273065665">Ad Approved</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="your_ad_on_site_name_has_been_approved" added="1273066852"><![CDATA[Your ad on {site_name} has been approved:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="ad_denied" added="1273067107">Ad Denied</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="your_ad_on_site_name_has_been_denied" added="1273067141"><![CDATA[Your ad on {site_name} has been denied:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="sponsor_ad_approved" added="1273150101">Sponsor Ad Approved</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="your_sponsor_ad_on_site_name_has_been_approved" added="1273150164"><![CDATA[Your sponsored ad on {site_name} has been approved:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="sponsor_ad_denied" added="1273150461">Sponsor Ad Denied</phrase>
		<phrase module_id="ad" version_id="2.0.5" var_name="your_sponsor_ad_on_site_name_has_been_denied" added="1273150501"><![CDATA[Your sponsored ad on {site_name} has been denied:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="ad" version_id="2.0.5dev1" var_name="your_order_has_been_processed" added="1274289160">Your order has been processed.</phrase>
		<phrase module_id="ad" version_id="2.0.6" var_name="and" added="1285598055">and</phrase>
		<phrase module_id="ad" version_id="2.0.7" var_name="total_ad_views" added="1288277434">{total} views</phrase>
		<phrase module_id="ad" version_id="2.0.7" var_name="invoice_successfully_deleted" added="1288620889">Invoice successfully deleted</phrase>
		<phrase module_id="ad" version_id="3.0.0beta5" var_name="enabled" added="1319184231">Enabled</phrase>
		<phrase module_id="ad" version_id="3.0.0beta5" var_name="disabled" added="1319184236">Disabled</phrase>
		<phrase module_id="ad" version_id="3.0.0rc2" var_name="blogs" added="1321448291">Blogs</phrase>
		<phrase module_id="ad" version_id="3.0.0" var_name="manage_ads" added="1323261463">Manage Ads</phrase>
		<phrase module_id="ad" version_id="3.0.0" var_name="manage_invoices" added="1323261476">Manage Invoices</phrase>
		<phrase module_id="ad" version_id="3.0.0" var_name="manage_sponsorships" added="1323261491">Manage Sponsorships</phrase>
		<phrase module_id="ad" version_id="3.0.0" var_name="choose_image" added="1323261560">Choose image</phrase>
		<phrase module_id="ad" version_id="3.2.0beta1" var_name="setting_how_many_ads_per_location" added="1332855052"><![CDATA[<title>How Many Ads Per Location</title><info>This setting tells how many ads will be shown per location. 

If you set this to a numerical zero (0) it will load every ad available for that location.

The default is 1</info> ]]></phrase>
		<phrase module_id="ad" version_id="3.2.0beta1" var_name="completed" added="1332928081">Completed</phrase>
		<phrase module_id="ad" version_id="3.2.0beta1" var_name="block_location_cost_ppc" added="1333024947">Block {location} - {cost} per click</phrase>
		<phrase module_id="ad" version_id="3.2.0beta1" var_name="you_are_not_the_owner_of_this_ad" added="1333451181">You are not the owner of this ad</phrase>
		<phrase module_id="ad" version_id="3.2.0beta1" var_name="this_ad_has_used_all_its_views" added="1333451198">This ad has used all its views</phrase>
		<phrase module_id="ad" version_id="3.2.0beta1" var_name="this_ad_has_used_all_its_clicks" added="1333451211">This ad has used all its clicks</phrase>
		<phrase module_id="ad" version_id="3.3.0beta2" var_name="sponsored" added="1340791705">Sponsored</phrase>
		<phrase module_id="ad" version_id="3.3.0rc1" var_name="amount_currency_per_1000_impressions" added="1341399162">{amount} {currency} per 1000 impressions</phrase>
		<phrase module_id="ad" version_id="3.3.0rc1" var_name="amount_currency_per_click" added="1341399183">{amount} {currency} per click</phrase>
		<phrase module_id="ad" version_id="3.4.0beta1" var_name="setting_advanced_ad_filters" added="1345630097"><![CDATA[<title>Enable Advanced Ad Filters</title><info>This setting enables the site to display ads based on the State/Province, Zip Code/Postal Code and City.</info>]]></phrase>
		<phrase module_id="ad" version_id="3.4.0beta2" var_name="close" added="1348481525">Close</phrase>
		<phrase module_id="ad" version_id="3.4.0beta2" var_name="your_ad_has_been_created" added="1348481535">Your ad has been created.</phrase>
		<phrase module_id="ad" version_id="3.4.0rc1" var_name="module_placement" added="1349933038">Module Placement</phrase>
		<phrase module_id="ad" version_id="3.4.0rc1" var_name="disallow_controller" added="1349933216">Disallow Controller</phrase>
		<phrase module_id="ad" version_id="3.4.0rc1" var_name="separate_each_controller_with_a_comma_eg_blog_index_video_view" added="1349933223">Separate each controller with a comma. (Eg. blog.index,video.view)</phrase>
		<phrase module_id="ad" version_id="3.4.0" var_name="postal_code" added="1350910156">Postal Code</phrase>
		<phrase module_id="ad" version_id="3.4.0" var_name="separate_multiple_postal_codes_by_a_comma" added="1350910172">Separate multiple postal codes by a comma.</phrase>
		<phrase module_id="ad" version_id="3.4.0" var_name="city" added="1350910183">City</phrase>
		<phrase module_id="ad" version_id="3.4.0" var_name="separate_multiple_cities_by_a_comma" added="1350910195">Separate multiple cities by a comma.</phrase>
		<phrase module_id="ad" version_id="3.5.0beta2" var_name="this_item_has_successfully_been_submitted" added="1359358139">This item has successfully been submitted. Before it can be displayed it will have to first be approved by a site Admin.</phrase>
		<phrase module_id="ad" version_id="3.5.1" var_name="dimensions" added="1366792170">Dimensions</phrase>
		<phrase module_id="ad" version_id="3.5.1" var_name="ad_dimensions_are_in_pixels" added="1366792177">Ad dimensions are in pixels.</phrase>
		<phrase module_id="ad" version_id="3.5.1" var_name="width" added="1366792186">Width</phrase>
		<phrase module_id="ad" version_id="3.5.1" var_name="height" added="1366792192">Height</phrase>
		<phrase module_id="ad" version_id="3.5.1" var_name="placement_type" added="1366792202">Placement Type</phrase>
		<phrase module_id="ad" version_id="3.5.1" var_name="cpm_cost_per_mille" added="1366792209">CPM (Cost per mille)</phrase>
		<phrase module_id="ad" version_id="3.5.1" var_name="ppc_pay_per_click" added="1366792217">PPC (Pay per click)</phrase>
		<phrase module_id="ad" version_id="3.7.0beta1" var_name="setting_multi_ad" added="1374062738"><![CDATA[<title>Multi-Ad Location</title><info>Enabling this setting will show ads only in block #3 and change the visual aspect of the ads for a standard one</info>]]></phrase>
		<phrase module_id="ad" version_id="3.7.0beta1" var_name="setting_ad_multi_ad_count" added="1374149027"><![CDATA[<title>Ads in Multi-Ad Location</title><info>How many ads should be shown in the Multi-Ad Location?

Default is 5</info>]]></phrase>
		<phrase module_id="ad" version_id="3.7.0beta2" var_name="sponsorships" added="1376307785">Sponsorships</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="ad" type="boolean" admin="true" user="true" guest="true" staff="true" module="ad" ordering="0">show_ads</setting>
		<setting is_admin_setting="0" module_id="ad" type="boolean" admin="0" user="0" guest="0" staff="0" module="ad" ordering="0">can_create_ad_campaigns</setting>
	</user_group_settings>
	<tables><![CDATA[a:6:{s:9:"phpfox_ad";a:3:{s:7:"COLUMNS";a:28:{s:5:"ad_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"is_custom";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"url_link";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"start_date";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"end_date";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_click";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"is_cpm";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:13:"module_access";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"location";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"country_iso";a:4:{i:0;s:6:"CHAR:2";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"gender";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"age_from";a:4:{i:0;s:6:"TINT:2";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"age_to";a:4:{i:0;s:6:"TINT:2";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"user_group";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"html_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"count_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"count_click";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"gmt_offset";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:19:"disallow_controller";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"postal_code";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:13:"city_location";a:4:{i:0;s:4:"TEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:5:"ad_id";s:4:"KEYS";a:2:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_active";i:1;s:8:"location";}}s:9:"is_custom";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_custom";i:1;s:7:"type_id";}}}}s:17:"phpfox_ad_invoice";a:3:{s:7:"COLUMNS";a:9:{s:10:"invoice_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:5:"ad_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"currency_id";a:4:{i:0;s:6:"CHAR:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"price";a:4:{i:0;s:10:"DECIMAL:14";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"status";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"time_stamp_paid";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"invoice_id";s:4:"KEYS";a:3:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:10:"is_sponsor";a:2:{i:0;s:5:"INDEX";i:1;s:10:"is_sponsor";}s:5:"ad_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:5:"ad_id";i:1;s:10:"is_sponsor";}}}}s:14:"phpfox_ad_plan";a:3:{s:7:"COLUMNS";a:8:{s:7:"plan_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"d_width";a:4:{i:0;s:7:"VCHAR:4";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"d_height";a:4:{i:0;s:7:"VCHAR:4";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"block_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"cost";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"is_cpm";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"plan_id";s:4:"KEYS";a:1:{s:8:"block_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:8:"block_id";i:1;s:9:"is_active";}}}}s:15:"phpfox_ad_track";a:3:{s:7:"COLUMNS";a:5:{s:8:"track_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:5:"ad_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"track_id";s:4:"KEYS";a:2:{s:5:"ad_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:5:"ad_id";i:1;s:7:"user_id";}}s:7:"ad_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:5:"ad_id";i:1;s:10:"ip_address";}}}}s:17:"phpfox_ad_sponsor";a:2:{s:7:"COLUMNS";a:17:{s:10:"sponsor_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"country_iso";a:4:{i:0;s:6:"CHAR:2";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"gender";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"age_from";a:4:{i:0;s:6:"TINT:2";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"age_to";a:4:{i:0;s:6:"TINT:2";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"campaign_name";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"impressions";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:3:"cpm";a:4:{i:0;s:10:"DECIMAL:14";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"start_date";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"auto_publish";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_custom";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_view";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_click";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"sponsor_id";}s:17:"phpfox_ad_country";a:3:{s:7:"COLUMNS";a:4:{s:13:"ad_country_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:5:"ad_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"country_id";a:4:{i:0;s:6:"CHAR:2";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"child_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:13:"ad_country_id";s:4:"KEYS";a:1:{s:5:"ad_id";a:2:{i:0;s:5:"INDEX";i:1;s:5:"ad_id";}}}}]]></tables>
</module>