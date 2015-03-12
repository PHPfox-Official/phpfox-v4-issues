<module>
	<data>
		<module_id>apps</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_apps</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:13:"file/pic/app/";}]]></writable>
	</data>
	<menus>
		<menu module_id="apps" parent_var_name="" m_connection="main" var_name="menu_apps_apps_fad58de7366495db4650cfefac2fcd61" ordering="104" url_value="apps" version_id="3.0.0beta1" disallow_access="" module="apps" />
		<menu module_id="apps" parent_var_name="" m_connection="apps" var_name="menu_apps_add_an_app_9a6dd283c3de653fbca500f9721f634f" ordering="105" url_value="apps.add" version_id="3.0.0beta1" disallow_access="" module="apps" />
		<menu module_id="apps" parent_var_name="" m_connection="footer" var_name="menu_apps_developers_251d164643533a527361dbe1a7b9235d" ordering="106" url_value="apps.developer" version_id="3.0.0beta1" disallow_access="" module="apps" />
		<menu module_id="apps" parent_var_name="" m_connection="mobile" var_name="menu_core_apps_532c28d5412dd75bf975fb951c740a30" ordering="113" url_value="apps" version_id="3.1.0rc1" disallow_access="" module="apps" mobile_icon="small_apps.png" />
	</menus>
	<settings>
		<setting group="" module_id="apps" is_hidden="0" type="boolean" var_name="enable_api_support" phrase_var_name="setting_enable_api_support" ordering="1" version_id="3.0.0beta3">0</setting>
		<setting group="" module_id="apps" is_hidden="0" type="string" var_name="openssl_config_path" phrase_var_name="setting_openssl_config_path" ordering="2" version_id="3.0.0beta3" />
		<setting group="" module_id="apps" is_hidden="1" type="integer" var_name="token_keep_alive" phrase_var_name="setting_token_keep_alive" ordering="3" version_id="3.0.0beta1">60</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="apps.index" module_id="apps" component="categories" location="1" is_active="1" ordering="2" disallow_access="" can_move="1">
			<title>Categories</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="core.index-member" module_id="apps" component="menu" location="1" is_active="1" ordering="1" disallow_access="" can_move="1">
			<title><![CDATA[{phrase var=&#039;apps.apps&#039;}]]></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="apps" hook_type="controller" module="apps" call_name="apps.component_controller_index_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="apps" hook_type="component" module="apps" call_name="apps.component_block_menu_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="apps" hook_type="controller" module="apps" call_name="apps.component_controller_developer_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="apps" hook_type="service" module="apps" call_name="apps.service_apps__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="apps" hook_type="service" module="apps" call_name="apps.service_callback__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="apps" hook_type="service" module="apps" call_name="apps.service_process__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="apps" hook_type="controller" module="apps" call_name="apps.component_controller_admincp_import_clean" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="apps" hook_type="controller" module="apps" call_name="apps.component_controller_admincp_export_clean" added="1358258443" version_id="3.5.0beta1" />
	</hooks>
	<components>
		<component module_id="apps" component="index" m_connection="apps.index" module="apps" is_controller="1" is_block="0" is_active="1" />
		<component module_id="apps" component="categories" m_connection="" module="apps" is_controller="0" is_block="1" is_active="1" />
		<component module_id="apps" component="menu" m_connection="" module="apps" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="module_apps" added="1312898098">Apps</phrase>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="menu_apps_apps_fad58de7366495db4650cfefac2fcd61" added="1313566699">Apps</phrase>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="menu_apps_add_an_app_9a6dd283c3de653fbca500f9721f634f" added="1313657007">Create an App</phrase>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="user_setting_can_add_app" added="1314102373">Can add an app to the site?</phrase>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="user_setting_can_view_app" added="1314102489">Can view apps?</phrase>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="user_setting_apps_require_moderation" added="1314106769">Moderate apps before showing them if they were uploaded by a member of this user group?</phrase>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="user_setting_can_moderate_apps" added="1314106908">Can members of this user group moderate apps?</phrase>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="menu_apps_developers_251d164643533a527361dbe1a7b9235d" added="1314169541">Developers</phrase>
		<phrase module_id="apps" version_id="3.0.0beta1" var_name="setting_token_keep_alive" added="1314178338"><![CDATA[<title>Token Keep Alive</title><info>When viewing an app the site will start a session that grants the application access to the user's shared items.

This variable tells how often will this session be updated (in seconds). 

A higher value would grant the application access for longer after the user has stopped using the app.

A value too small could slow down your site.</info>]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="setting_enable_api_support" added="1316002975"><![CDATA[<title>Enable API Support</title><info>Before developers can start using your site to create Apps you must first enable API support. By enabling this you will allow 3rd party developers the ability to create Apps for your community that they will host and maintain on their own servers. They will get access using a token system that uses OpenSSL. In order for this feature to work your server must have OpenSSL support.</info>]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="setting_openssl_config_path" added="1316003324"><![CDATA[<title>OpenSSL Config Path</title><info>If your server does not have a config file for OpenSSL installed you can define the full path to this file here.</info>]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="apps" added="1316525979">Apps</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="operation_carried_out_successfully" added="1316526096">Operation carried out successfully.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="category_deleted_successfully" added="1316526114">Category deleted successfully.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="an_error_occurred_and_the_category_has_not_been_deleted" added="1316526129">An error occurred and the category has not been deleted.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="an_error_occurred_and_your_confirmation_could_not_be_saved" added="1316526154">An error occurred and your confirmation could not be saved.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="category_renamed" added="1316526176">Category Renamed</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="an_error_occurred" added="1316526187">An error occurred.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="permissions_updated_successfully" added="1316526200">Permissions updated successfully.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="categories" added="1316526220">Categories</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="that_app_does_not_exist" added="1316526254">That app does not exist.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="category_successfully_added" added="1316526279">Category successfully added.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="app_categories" added="1316526288">App Categories</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="app_successfully_created" added="1316526301">App successfully created.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="general" added="1316526311">General</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="photo" added="1316526318">Photo</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="url" added="1316526328">URL</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="view_this_app" added="1316526341">View This App</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="successfully_updated_the_app" added="1316526367">Successfully updated the app.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="you_are_not_allowed_to_edit_this_app" added="1316526382">You are not allowed to edit this app.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="editing_app" added="1316526396">Editing App</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="create_an_app" added="1316526407">Create an App</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="app_developers" added="1316526453">App Developers</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="developers" added="1316526472">Developers</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="app_successfully_deleted" added="1316526505">App successfully deleted.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="app_successfully_uninstalled" added="1316526517">App successfully uninstalled.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="all_apps" added="1316526532">All Apps</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="my_apps" added="1316526541">My Apps</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="installed_apps" added="1316526552">Installed Apps</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="pending_apps" added="1316526567">Pending Apps</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="search_apps" added="1316526607">Search Apps...</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="latest" added="1316526619">Latest</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="delete" added="1316526640">Delete</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="approve" added="1316526650">Approve</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="uninstall" added="1316526663">Uninstall</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="that_app_was_not_found" added="1316526699">That app was not found.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="that_app_was_not_found_check" added="1316526736">That app was not found check.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="this_app_does_not_exist" added="1316526776">This app does not exist.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="app_not_found" added="1316526843">App not found.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="every_field_is_required" added="1316526867">Every field is required.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="you_are_not_allowed_to_delete_this_app" added="1316526887">You are not allowed to delete this app.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="cannot_edit_this_app" added="1316526918">Cannot edit this app.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="please_provide_a_valid_url" added="1316526930">Please provide a valid URL.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="manage" added="1316527077">Manage</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="are_you_sure" added="1316527139">Are you sure?</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="permissions" added="1316527173">Permissions</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="allow" added="1316527265">Allow</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="not_allow" added="1316527276">Not allow</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="update" added="1316527285">Update</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="category" added="1316527309">Category</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="update_name" added="1316527331">Update Name</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="add_new_category" added="1316527340">Add new category</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="name" added="1316527347">Name</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="add_category" added="1316527362">Add Category</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="select" added="1316527741">Select</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="submit" added="1316527751">Submit</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="app_id" added="1316527762">APP ID</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="title" added="1316527773">Title</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="description" added="1316527793">Description</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="upload_new_picture" added="1316527802">Upload new picture</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="call_home_url" added="1316527814">Call Home URL</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="introduction" added="1316527965">Introduction</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="api" added="1316529478">API</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="as_a_developer_you_can_create_applications" added="1316529523">As a developer you can create applications and add them to {site_name}, taking advantage of the existing user base. You host the application, which means that you are in full control of your server specifications.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="setting_up_an_app" added="1316529554">Setting up an APP</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="to_interact_with_site_name_your" added="1316529580">To interact with {site_name} your application can issue calls to our API and request or post information.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="when_you_add_an_application" added="1316529619"><![CDATA[When you <a href="{link}">add an application</a> to our site we will give you an <b>APP ID</b>.]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="requesting_a_token" added="1316529681">Requesting a Token</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="whenever_you_plan_on_using_our_api_you_must_first_request_a_token_in_order_to_request_a_token_you_need_a_unique_key_that_we_send_to_you_when_a_user_visits_your_app_from_an_iframe_on_our_site_we_pass_this_along_as_b_get_key_b" added="1316529697"><![CDATA[Whenever you plan on using our API you must first request a token. In order to request a token you need a unique key that we send to you when a user visits your APP from an iframe on our site. We pass this along as <b>$_GET['key']</b>.]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="this_is_an_example_of_how_you_can_request_a_token" added="1316529716">This is an example of how you can request a token</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="if_successful_you_will_get_a_json_response_like" added="1316529727">If successful, you will get a JSON response like</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="sending_a_request" added="1316529737">Sending a Request</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="now_that_you_have_a_valid_token_you_can_make_requests_to_our_server_with_each_request_you_must_pass_the_token_we_created_for_you" added="1316529747">Now that you have a valid token you can make requests to our server. With each request you must pass the token we created for you.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="an_example_call_to_our_api_server_would_look_like" added="1316529757">An example call to our API server would look like</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="understanding_an_api_response" added="1316529768">Understanding an API Response</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="for_methods_that_could_return_more_than_on" added="1316529797"><![CDATA[For methods that could return more than one item the response will contain an indicator of the total items available as well as how many pages there are. We return by default 10 items at most and in order to get the next 10 items you would have to pass the param "<b>page=2</b>".]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="to_the_left_you_will_find_a_list_of_the_modules_that_implement" added="1316529823">To the left you will find a list of the modules that implement API methods. Click on the module and you will see a list of the methods that your application can use. For shortness and formatting purposes we do not include the full request in there but only the most relevant parts.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="response" added="1316529835">Response</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="actions" added="1316529874">Actions</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="moderate" added="1316529882">Moderate</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="no_apps_found" added="1316529895">No apps found.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="install_this_app" added="1316529905">Install this App?</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="in_order_to_use_app_title" added="1316529934"><![CDATA[In order to use <span class="app_name">{app_title}</span> you need to confirm what you allow it to do]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="dont_allow" added="1316529962">Dont allow</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="don_t_allow" added="1316529978"><![CDATA[Don't allow]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="report_this_app" added="1316529990">Report this app</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="report_this_application" added="1316529999">Report this application</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="developed_by_user" added="1316530019">Developed by {full_name}</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="1_like" added="1316530036">1 like</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="total_like_likes" added="1316530051">{total_like} likes</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="install" added="1316530069">Install</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="don_t_install" added="1316530079"><![CDATA[Don't install]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="you_are_logged_in_as_full_name" added="1316530094">You are logged in as {full_name}</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="api_support_is_disabled_at_the_moment" added="1316530112">API support is disabled at the moment.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="this_app_currently_does_not_have_a_call_home_url_set" added="1316530139"><![CDATA[This app currently does not have a "call home" URL set.]]></phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="this_app_is_still_under_development" added="1316530148">This App is still under development.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="contact_the_developer" added="1316530176">Contact the Developer</phrase>
		<phrase module_id="apps" version_id="3.0.0beta3" var_name="un_install_this_app" added="1316530187">Un-install this App</phrase>
		<phrase module_id="apps" version_id="3.0.0beta5" var_name="can_see_who_is_on_my_friends_list" added="1319465114">Can see who is on my friends list</phrase>
		<phrase module_id="apps" version_id="3.0.0beta5" var_name="share_my_full_name" added="1319465130">Share my full name</phrase>
		<phrase module_id="apps" version_id="3.0.0beta5" var_name="share_my_email" added="1319465138">Share my email</phrase>
		<phrase module_id="apps" version_id="3.0.0beta5" var_name="post_a_status_update_as_me" added="1319465147">Post a status update as me.</phrase>
		<phrase module_id="apps" version_id="3.0.0beta5" var_name="would_you_like_to_view_this_app_without_installing_it" added="1319465771">Would you like to view this App without installing it?</phrase>
		<phrase module_id="apps" version_id="3.0.0beta5" var_name="yes" added="1319465778">Yes</phrase>
		<phrase module_id="apps" version_id="3.1.0rc1" var_name="menu_core_apps_532c28d5412dd75bf975fb951c740a30" added="1332250396">Apps</phrase>
		<phrase module_id="apps" version_id="3.4.0" var_name="admin_menu_categories" added="1351240790">Categories</phrase>
		<phrase module_id="apps" version_id="3.4.0" var_name="admincp_menu_apps" added="1351240933">Apps</phrase>
		<phrase module_id="apps" version_id="3.4.0" var_name="install_app" added="1351241071">Install App</phrase>
		<phrase module_id="apps" version_id="3.4.0" var_name="export_apps" added="1351241088">Export Apps</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="export" added="1359469690">Export</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="package_title" added="1359469700">Package Title</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="callback_url" added="1359469707">Callback URL</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="this_is_the_url_you_will" added="1359469720">This is the URL you will be notified when a client installs your set of Apps and you will be provided with API keys.</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="apps_to_export" added="1359469732">Apps to Export</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="will_your_app_be_on_this_site" added="1359469907">Will your App be on this site?</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="no" added="1359469920">No</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="frame_url" added="1359469971">Frame URL</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="this_is_the_url_to_your_application" added="1359469978">This is the URL to your application.</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="return_url" added="1359469984">Return URL</phrase>
		<phrase module_id="apps" version_id="3.5.0beta2" var_name="if_your_app_is_not_on_this_site_you_need_to_provide_return_url_for_authentication" added="1359470005">If your App is not on this site you need to provide return URL for authentication.</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="apps" type="boolean" admin="true" user="false" guest="false" staff="true" module="apps" ordering="0">can_add_app</setting>
		<setting is_admin_setting="0" module_id="apps" type="boolean" admin="true" user="true" guest="false" staff="true" module="apps" ordering="0">can_view_app</setting>
		<setting is_admin_setting="0" module_id="apps" type="boolean" admin="false" user="true" guest="true" staff="false" module="apps" ordering="0">apps_require_moderation</setting>
		<setting is_admin_setting="0" module_id="apps" type="boolean" admin="true" user="false" guest="false" staff="true" module="apps" ordering="0">can_moderate_apps</setting>
	</user_group_settings>
	<tables><![CDATA[a:7:{s:10:"phpfox_app";a:3:{s:7:"COLUMNS";a:13:{s:6:"app_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"app_title";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"app_description";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"public_key";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"private_key";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"image_path";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"app_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"return_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:6:"is_ext";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"app_id";s:4:"KEYS";a:5:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:10:"time_stamp";a:2:{i:0;s:5:"INDEX";i:1;s:10:"time_stamp";}s:7:"privacy";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"privacy";i:1;s:7:"view_id";}}s:10:"public_key";a:2:{i:0;s:5:"INDEX";i:1;s:10:"public_key";}s:6:"app_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:6:"app_id";i:1;s:6:"is_ext";}}}}s:17:"phpfox_app_access";a:3:{s:7:"COLUMNS";a:7:{s:9:"access_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:6:"app_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"token_key";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"token_private";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"token";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"access_id";s:4:"KEYS";a:2:{s:5:"token";a:2:{i:0;s:5:"INDEX";i:1;s:5:"token";}s:6:"app_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:6:"app_id";i:1;s:7:"user_id";}}}}s:19:"phpfox_app_category";a:3:{s:7:"COLUMNS";a:3:{s:11:"category_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"category_id";s:4:"KEYS";a:1:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}s:24:"phpfox_app_category_data";a:3:{s:7:"COLUMNS";a:3:{s:15:"category_app_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:11:"category_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"app_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:15:"category_app_id";s:4:"KEYS";a:2:{s:11:"category_id";a:2:{i:0;s:6:"UNIQUE";i:1;a:2:{i:0;s:11:"category_id";i:1;s:6:"app_id";}}s:6:"app_id";a:2:{i:0;s:5:"INDEX";i:1;s:6:"app_id";}}}s:19:"phpfox_app_disallow";a:3:{s:7:"COLUMNS";a:4:{s:7:"data_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:6:"app_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"var_name";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"data_id";s:4:"KEYS";a:2:{s:6:"app_id";a:2:{i:0;s:5:"INDEX";i:1;s:6:"app_id";}s:8:"app_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:6:"app_id";i:1;s:7:"user_id";}}}}s:20:"phpfox_app_installed";a:3:{s:7:"COLUMNS";a:4:{s:10:"install_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:6:"app_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"install_id";s:4:"KEYS";a:2:{s:6:"app_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:6:"app_id";i:1;s:7:"user_id";}}s:8:"app_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:6:"app_id";}}}s:14:"phpfox_app_key";a:3:{s:7:"COLUMNS";a:5:{s:6:"key_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"key_check";a:4:{i:0;s:7:"CHAR:32";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"app_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"key_id";s:4:"KEYS";a:1:{s:9:"key_check";a:2:{i:0;s:5:"INDEX";i:1;s:9:"key_check";}}}}]]></tables>
	<install><![CDATA[
		$aAppCategories = array(
			'Just for Fun',			
			'Gaming',
			'Sports',
			'Utility',
			'Education',
			'Dating',
			'Messaging',
			'Chat',
			'Music',
			'Events',
			'Alerts',
			'Photo',
			'Business',
			'Video',
			'Politics',
			'Fashion',
			'Food and Drink',
			'Travel',
			'Money',
			'Mobile',
			'Classified',
			'File Sharing'
		);		
		sort($aAppCategories);
		$iCategoryOrder = 0;
		foreach ($aAppCategories as $sCategory)
		{
			$iCategoryOrder++;
			$this->database()->insert(Phpfox::getT('app_category'), array(					
					'name' => $sCategory					
				)
			);
		}
	]]></install>
</module>